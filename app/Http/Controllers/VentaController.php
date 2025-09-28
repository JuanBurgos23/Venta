<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Producto_almacen;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        return view('venta.venta');
    }
    public function fetchProducto(Request $request)
    {
        $empresaId = auth()->user()->id_empresa;
        $almacenId = $request->input('almacen_id'); // viene del frontend

        if (!$almacenId) {
            return response()->json([], 400); // si no envían almacén
        }

        $productos = Producto::deEmpresa($empresaId)
            ->with('categoria')
            ->get();

        $data = $productos->map(function ($p) use ($empresaId, $almacenId) {
            // 🔹 stock solo del almacen seleccionado
            $stock = Producto_almacen::where('producto_id', $p->id)
                ->where('empresa_id', $empresaId)
                ->where('almacen_id', $almacenId)
                ->sum('stock');

            // solo devolver productos con stock > 0
            if ($stock <= 0) return null;

            return [
                'id'       => $p->id,
                'name'     => $p->nombre,
                'price'    => $p->precio ?? 0,
                'category' => $p->categoria_id,
                'stock'    => $stock,
                'image'    => $p->foto ? asset('storage/' . $p->foto) : null,
            ];
        })->filter()->values(); // eliminar nulls

        return response()->json($data);
    }

    public function fetchAlmacenes()
    {
        $empresaId = auth()->user()->id_empresa;

        // Obtener todos los almacenes cuya sucursal pertenece a la empresa
        $almacenes = Almacen::whereHas('sucursal', function ($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        })->orderBy('id', 'asc')->get();

        return response()->json($almacenes);
    }
    public function BuscarProducto(Request $request)
    {
        $empresaId = auth()->user()->id_empresa; // filtrar por empresa
        $query = $request->input('query');

        $productos = Producto::deEmpresa($empresaId)
            ->with(['categoria', 'tipoPrecio']) // si quieres incluir relaciones
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%")
                    ->orWhere('descripcion', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get();

        $data = $productos->map(function ($p) use ($empresaId) {
            $stock = Producto_almacen::where('producto_id', $p->id)
                ->where('empresa_id', $empresaId)
                ->sum('stock');
            return [
                'id'       => $p->id,
                'name'     => $p->nombre,
                'price'    => $p->precio ? ($p->precio ?? 0) : 0, // misma lógica que fetchProducto
                'category' => $p->categoria_id,
                'stock'    => $stock ?? 0,
                'image'    => $p->foto ? asset('storage/' . $p->foto) : null,
            ];
        });

        return response()->json($data);
    }
    public function fetchJson(Request $request)
    {
        $empresaId = auth()->user()->id_empresa;

        $categorias = Categoria::where('id_empresa', $empresaId)
            ->withCount('subcategorias') // opcional, si quieres info extra
            ->orderBy('nombre')
            ->get();

        $data = $categorias->map(function ($c) {
            return [
                'id'   => $c->id,
                'name' => $c->nombre,      // uniforme con 'name' en productos
                'subcategories_count' => $c->subcategorias_count ?? 0, // opcional
            ];
        });

        return response()->json($data);
    }
    public function fetchClientes(Request $request)
    {
        $empresaId = auth()->user()->id_empresa;
        $clientes = Cliente::where('id_empresa', $empresaId)
            ->select('id', 'nombre', 'ci', 'telefono', 'paterno')
            ->orderBy('nombre')
            ->get();

        return response()->json($clientes);
    }
    public function buscarPorCodigo($codigo)
    {
        $empresaId = auth()->user()->id_empresa; // filtrar por empresa

        $producto = Producto::deEmpresa($empresaId)
            ->with(['categoria', 'tipoPrecio'])
            ->where('codigo', $codigo)
            ->first();

        if (!$producto) {
            return response()->json(null, 404); // devolver 404 si no existe
        }

        // 🔹 Calcular stock real desde Producto_almacen (todos los almacenes de la empresa)
        $stock = Producto_almacen::where('producto_id', $producto->id)
            ->where('empresa_id', $empresaId)
            ->sum('stock');

        $data = [
            'id'       => $producto->id,
            'name'     => $producto->nombre,
            'price'    => $producto->precio ?? 0,
            'category' => $producto->categoria_id,
            'stock'    => $stock ?? 0,
            'image'    => $producto->foto ? asset('storage/' . $producto->foto) : null,
        ];

        return response()->json($data);
    }


    public function ClienteStore(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'paterno'  => 'nullable|string|max:255',
            'materno'  => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'ci'       => 'nullable|string|max:50',
            'correo'   => 'nullable|email|max:255',
        ]);

        $cliente = Cliente::create([
            'nombre'     => $request->nombre,
            'paterno'    => $request->paterno,
            'materno'    => $request->materno,
            'telefono'   => $request->telefono,
            'ci'         => $request->ci,
            'correo'     => $request->correo,
            'id_empresa' => Auth::user()->id_empresa ?? null,
            'estado'     => 'Activo',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado correctamente',
            'cliente' => $cliente
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'client_id'      => 'required|exists:cliente,id',
            'payment_method' => 'required|string',
            'sale_type'      => 'required|string',
            'date'           => 'required|date',
            'items'          => 'required|array|min:1',
        ]);

        try {
            DB::beginTransaction();

            // Generar código (ejemplo simple VTA-0001)
            $codigo = 'VTA-' . str_pad((Venta::count() + 1), 4, '0', STR_PAD_LEFT);

            $total = 0;

            // Calcular total desde los items enviados
            foreach ($request->items as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $almacenId = $request->input('almacen_id'); // 📌 almacén seleccionado

            // Crear venta
            $venta = Venta::create([
                'codigo'       => $codigo,
                'fecha'        => $request->date,
                'cliente_id'   => $request->client_id,
                'usuario_id'   => Auth::id(),
                'empresa_id'   => Auth::user()->id_empresa ?? null,
                'almacen_id'   => $almacenId, // usar almacén seleccionado
                'descuento'    => 0,
                'total'        => $total,
                'forma_pago'   => $request->payment_method,
                'observaciones' => null,
            ]);

            // Insertar detalles y descontar stock del almacén correcto
            foreach ($request->items as $item) {
                DetalleVenta::create([
                    'venta_id'       => $venta->id,
                    'producto_id'    => $item['id'],
                    'cantidad'       => $item['quantity'],
                    'precio_unitario' => $item['price'],
                    'subtotal'       => $item['price'] * $item['quantity'],
                ]);

                $productoAlmacen = Producto_almacen::where('producto_id', $item['id'])
                    ->where('empresa_id', Auth::user()->id_empresa)
                    ->where('almacen_id', $almacenId) // 🔹 almacén seleccionado
                    ->first();

                if ($productoAlmacen) {
                    $productoAlmacen->stock -= $item['quantity'];
                    $productoAlmacen->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Venta registrada correctamente',
                'venta'   => $venta->load('detalles'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la venta',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
