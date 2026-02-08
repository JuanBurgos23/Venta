<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Venta;
use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\Categoria;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use App\Services\CajaService;
use App\Models\Producto_compra;
use App\Models\Producto_almacen;
use App\Models\detalle_venta_lote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::where('empresa_id', Auth::user()->id_empresa)->get();
        return view('venta.venta', compact('sucursales'));
    }
    public function fetchProducto(Request $request)
    {
        $usuario = auth()->user();
        $empresaId = $usuario->id_empresa;
        $almacenId = $request->input('almacen_id');

        // ⚠️ 1️⃣ Verificar si el usuario tiene caja activa
        $cajaActiva = \App\Models\Caja::where('usuario_id', $usuario->id)
            ->where('empresa_id', $empresaId)
            ->where('estado', 1)
            ->first();

        if (!$cajaActiva) {
            return response()->json([
                'error' => true,
                'message' => 'No hay una caja activa. Debes abrir una caja para realizar ventas.'
            ], 403);
        }

        // ⚠️ 2️⃣ Verificar que se haya enviado el almacén
        if (!$almacenId) {
            return response()->json([], 400);
        }

        // ✅ 3️⃣ Cargar productos normalmente
        $productos = \App\Models\Producto::deEmpresa($empresaId)
            ->with([
                'categoria:id,nombre',
                'subcategoria:id,nombre',
            ])
            ->get();

        $data = $productos->map(function ($p) use ($empresaId, $almacenId) {
            $esInventariable = (int) ($p->inventariable ?? 1) === 1;
            $stock = \App\Models\Producto_almacen::where('producto_id', $p->id)
                ->where('empresa_id', $empresaId)
                ->where('almacen_id', $almacenId)
                ->sum('stock');

            if ($esInventariable && $stock <= 0) return null;

            return [
                'id'               => $p->id,
                'codigo'           => $p->codigo,
                'name'             => $p->nombre,
                'description'      => $p->descripcion,
                'price'            => $p->precio ?? 0,
                'category'         => $p->categoria_id,
                'category_name'    => $p->categoria?->nombre,
                'subcategory'      => $p->subcategoria_id,
                'subcategory_name' => $p->subcategoria?->nombre,
                'brand'            => $p->marca,
                'model'            => $p->modelo,
                'inventariable'    => $esInventariable ? 1 : 0,
                'stock'            => $esInventariable ? $stock : null,
                'image'            => $p->foto ? asset('storage/' . $p->foto) : null,
            ];
        })->filter()->values();

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
            ->with([
                'categoria:id,nombre',
                'subcategoria:id,nombre',
                'tipoPrecio'
            ]) // si quieres incluir relaciones
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%")
                    ->orWhere('descripcion', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get();

        $data = $productos->map(function ($p) use ($empresaId) {
            $esInventariable = (int) ($p->inventariable ?? 1) === 1;
            $stock = Producto_almacen::where('producto_id', $p->id)
                ->where('empresa_id', $empresaId)
                ->sum('stock');
            return [
                'id'               => $p->id,
                'codigo'           => $p->codigo,
                'name'             => $p->nombre,
                'description'      => $p->descripcion,
                'price'            => $p->precio ? ($p->precio ?? 0) : 0,
                'category'         => $p->categoria_id,
                'category_name'    => $p->categoria?->nombre,
                'subcategory'      => $p->subcategoria_id,
                'subcategory_name' => $p->subcategoria?->nombre,
                'brand'            => $p->marca,
                'model'            => $p->modelo,
                'inventariable'    => $esInventariable ? 1 : 0,
                'stock'            => $esInventariable ? ($stock ?? 0) : null,
                'image'            => $p->foto ? asset('storage/' . $p->foto) : null,
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
            ->with([
                'categoria:id,nombre',
                'subcategoria:id,nombre',
                'tipoPrecio'
            ])
            ->where('codigo', $codigo)
            ->first();

        if (!$producto) {
            return response()->json(null, 404); // devolver 404 si no existe
        }

        // 🔹 Calcular stock real desde Producto_almacen (todos los almacenes de la empresa)
        $stock = Producto_almacen::where('producto_id', $producto->id)
            ->where('empresa_id', $empresaId)
            ->sum('stock');
        $esInventariable = (int) ($producto->inventariable ?? 1) === 1;

        $data = [
            'id'               => $producto->id,
            'codigo'           => $producto->codigo,
            'name'             => $producto->nombre,
            'description'      => $producto->descripcion,
            'price'            => $producto->precio ?? 0,
            'category'         => $producto->categoria_id,
            'category_name'    => $producto->categoria?->nombre,
            'subcategory'      => $producto->subcategoria_id,
            'subcategory_name' => $producto->subcategoria?->nombre,
            'brand'            => $producto->marca,
            'model'            => $producto->modelo,
            'inventariable'    => $esInventariable ? 1 : 0,
            'stock'            => $esInventariable ? ($stock ?? 0) : null,
            'image'            => $producto->foto ? asset('storage/' . $producto->foto) : null,
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
            'sale_type'      => 'required|string|in:contado,credito',
            'date'           => 'required|date',
            'sucursal_id'    => 'required|exists:sucursal,id',
            'items'          => 'required|array|min:1',
            'subtotal'       => 'required|numeric',
            'descuento'      => 'nullable|numeric|min:0',
            'total'          => 'required|numeric|min:0',
            'billete'        => 'nullable|numeric|min:0',
            'cambio'         => 'nullable|numeric|min:0',

            // ✅ Asegura que venga almacén
            'almacen_id'     => 'required|exists:almacen,id',
        ]);

        $usuarioId = Auth::id();
        $empresaId = Auth::user()->id_empresa;

        // ✅ Derivar sucursal desde almacén
        $almacenId = (int) $request->input('almacen_id');
        $almacen = Almacen::findOrFail($almacenId);
        $sucursalId = (int) $almacen->sucursal_id;

        // ✅ Verificar caja abierta para empresa+sucursal+usuario (en el store también)
        $cajaActiva = \App\Models\Caja::where('usuario_id', $usuarioId)
            ->where('empresa_id', $empresaId)
            ->where('sucursal_id', $sucursalId)
            ->where('estado', 1)
            ->orderBy('fecha_apertura', 'desc')
            ->first();

        if (!$cajaActiva) {
            return response()->json([
                'success' => false,
                'message' => 'No hay una caja activa para esta sucursal. Debes abrir caja para registrar ventas.'
            ], 403);
        }

        try {
            DB::beginTransaction();

            // Generar código (ejemplo simple VTA-0001)
            $codigo = 'VTA-' . str_pad((Venta::count() + 1), 4, '0', STR_PAD_LEFT);

            // Crear venta
            $venta = Venta::create([
                'codigo'        => $codigo,
                'fecha'         => $request->date,
                'cliente_id'    => $request->client_id,
                'usuario_id'    => $usuarioId,
                'empresa_id'    => $empresaId,
                'sucursal_id'   => $sucursalId,
                'almacen_id'    => $almacenId,
                'descuento'     => $request->descuento ?? 0,
                'total'         => $request->total,
                'forma_pago'    => $request->payment_method,
                'tipo_pago'     => $request->sale_type, // contado o credito
                'observaciones' => null,
                'billete'       => $request->billete ?? 0,
                'cambio'        => $request->cambio ?? 0,
                'estado'        => $request->sale_type === 'contado' ? 'Pagado' : 'Pendiente',
            ]);

            // Insertar detalles y descontar stock por lotes (FIFO)
            foreach ($request->items as $item) {
                $producto = Producto::select('id', 'nombre', 'inventariable')->find($item['id']);
                if (!$producto) {
                    throw new \Exception("Producto no encontrado.");
                }
                $esInventariable = (int) ($producto->inventariable ?? 1) === 1;
                $detalle = DetalleVenta::create([
                    'venta_id'        => $venta->id,
                    'producto_id'     => $producto->id,
                    'cantidad'        => $item['quantity'],
                    'precio_unitario' => $item['price'],
                    'subtotal'        => $item['price'] * $item['quantity'],
                ]);

                if (!$esInventariable) {
                    continue;
                }

                $cantidadPendiente = $item['quantity'];

                $lotes = Producto_almacen::where('producto_id', $item['id'])
                    ->where('empresa_id', $empresaId)
                    ->where('almacen_id', $almacenId)
                    ->where('stock', '>', 0)
                    ->orderBy('created_at', 'asc')
                    ->get();

                foreach ($lotes as $lote) {
                    if ($cantidadPendiente <= 0) break;

                    $costoUnit = 0;
                    if ($lote->producto_compra_id) {
                        $pc = Producto_compra::find($lote->producto_compra_id);
                        $costoUnit = $pc?->costo_unitario ?? 0;
                    }

                    if ($lote->stock >= $cantidadPendiente) {
                        $consumir = $cantidadPendiente;

                        detalle_venta_lote::create([
                            'detalle_venta_id'    => $detalle->id,
                            'producto_id'         => $item['id'],
                            'producto_compra_id'  => $lote->producto_compra_id,
                            'producto_almacen_id' => $lote->id,
                            'cantidad'            => $consumir,
                            'costo_unitario'      => $costoUnit,
                            'costo_total'         => $costoUnit * $consumir,
                        ]);

                        $lote->decrement('stock', $consumir);
                        $cantidadPendiente = 0;
                    } else {
                        $consumir = $lote->stock;

                        detalle_venta_lote::create([
                            'detalle_venta_id'    => $detalle->id,
                            'producto_id'         => $item['id'],
                            'producto_compra_id'  => $lote->producto_compra_id,
                            'producto_almacen_id' => $lote->id,
                            'cantidad'            => $consumir,
                            'costo_unitario'      => $costoUnit,
                            'costo_total'         => $costoUnit * $consumir,
                        ]);

                        $cantidadPendiente -= $consumir;
                        $lote->update(['stock' => 0]);
                    }
                }

                if ($cantidadPendiente > 0) {
                    $productoNombre = $producto->nombre ?? 'Desconocido';
                    throw new \Exception("No hay stock suficiente para '{$productoNombre}' en el almacén seleccionado.");
                }
            }

            DB::commit();

            // ✅ Llamar al SP SOLO si es contado (caja)
            CajaService::registrarVentaDirecta(
                $empresaId,
                $sucursalId,
                $usuarioId,
                $venta->id,
                $venta->created_at->format('Y-m-d H:i:s'),
                (float) $venta->total
            );


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

    public function ventasRegistradas()
    {
        return view('venta.ventaRegistrada');
    }
    public function fetchVentas(Request $request)
    {
        $empresaId = auth()->user()->id_empresa;
        $user = auth()->user();


        $query = Venta::with([
            'cliente',
            'usuario',
            'almacen',
            'detalles.producto',
            'detalles.unidadMedida'
        ])->whereHas('almacen.sucursal', function ($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        });

        // 📅 Filtro fechas
        if ($request->filled('from') && $request->filled('to')) {
            $from = Carbon::parse($request->from)->startOfDay();
            $to = Carbon::parse($request->to)->endOfDay();
            $query->whereBetween('fecha', [$from, $to]);
        }

        // 🔍 Buscador general
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                    ->orWhere('forma_pago', 'like', "%{$search}%")
                    ->orWhere('estado', 'like', "%{$search}%")
                    ->orWhere('total', 'like', "%{$search}%")
                    ->orWhereHas('cliente', fn($qc) =>
                    $qc->where('nombre', 'like', "%{$search}%")
                        ->orWhere('paterno', 'like', "%{$search}%")
                        ->orWhere('ci', 'like', "%{$search}%"))
                    ->orWhereHas('usuario', fn($qu) =>
                    $qu->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('almacen', fn($qa) =>
                    $qa->where('nombre', 'like', "%{$search}%"));
            });
        }

        // 📌 Filtro estado (opcional)
        if ($request->filled('status') && $request->status !== 'Todos') {
            $query->where('estado', $request->status);
        }

        // 📄 Paginación
        $perPage = $request->get('per_page', 10);
        $ventas = $query->orderBy('fecha', 'desc')->paginate($perPage);

        return response()->json($ventas);
    }


    // Imprimir venta
    public function imprimir($id)
    {
        $venta = Venta::with(['cliente', 'usuario', 'detalles', 'detalles.producto'])->findOrFail($id);
        $empresa = Empresa::first();

        $logoBase64 = null;
        if ($empresa && $empresa->logo) {
            $path = storage_path('app/public/' . $empresa->logo);
            if (file_exists($path)) {
                $logoBase64 = 'data:image/' . pathinfo($path, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($path));
            }
        }

        return view('venta.imprimir.imprimirVenta', compact('venta', 'empresa', 'logoBase64'));
    }
    public function anular(Request $request, Venta $venta)
    {
        // 1) permiso (aunque ya lo controla el middleware, esto es “seguro por si acaso”)
        if (! $request->user()->can('venta.anular')) {
            abort(403, 'No tienes permiso para anular ventas');
        }

        // 2) multiempresa: la venta debe ser de la empresa activa
        $empresaId = $request->user()->id_empresa;
        if ((int) $venta->empresa_id !== (int) $empresaId) {
            abort(403, 'No autorizado para esta empresa');
        }

        // 3) anulación lógica
        $venta->estado = 'Anulado';
        $venta->save();

        return response()->json(['success' => true, 'message' => 'Venta anulada']);
    }
    

}
