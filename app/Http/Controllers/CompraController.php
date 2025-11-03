<?php

namespace App\Http\Controllers;

use App\Models\almacen;
use App\Models\Compra;
use App\Models\Producto;
use App\Models\Producto_compra;
use App\Models\Producto_almacen;
use App\Models\Proveedor;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('compra.compra');
    }
    public function crud()
    {
        return view('compra.crud'); // la tabla CRUD
    }


    /**
     * Buscar proveedores (para TomSelect en compras)
     */
    public function ProveedorSearch(Request $request)
    {
        $empresaId = auth()->user()->id_empresa; // filtrar por empresa
        $query = $request->input('query');

        $proveedores = Proveedor::where('id_empresa', $empresaId)
            ->where('estado', 1) // solo activos, opcional
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'LIKE', "%{$query}%")
                    ->orWhere('paterno', 'LIKE', "%{$query}%")
                    ->orWhere('materno', 'LIKE', "%{$query}%")
                    ->orWhere('telefono', 'LIKE', "%{$query}%")
                    ->orWhere('correo', 'LIKE', "%{$query}%")
                    ->orWhere('ci', 'LIKE', "%{$query}%");
            })
            ->limit(10)
            ->get();

        $data = $proveedores->map(function ($p) {
            return [
                'id'       => $p->id,
                'nombre'   => trim("{$p->nombre} {$p->paterno} {$p->materno}"),
                'ruc'      => $p->ci,
                'telefono' => $p->telefono,
                'email'    => $p->correo,
            ];
        });

        return response()->json($data);
    }

    /**
     * Guardar un nuevo proveedor desde el modal
     */
    public function ProveedorStore(Request $request)
    {
        $empresaId = auth()->user()->id_empresa;

        $validated = $request->validate([
            'nombre'   => 'required|string|max:255',
            'paterno'  => 'nullable|string|max:255',
            'materno'  => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'correo'   => 'nullable|email|max:255',
            'ci'       => 'nullable|string|max:100',
        ]);

        $proveedor = Proveedor::create([
            'nombre'    => $validated['nombre'],
            'paterno'   => $validated['paterno'] ?? null,
            'materno'   => $validated['materno'] ?? null,
            'telefono'  => $validated['telefono'] ?? null,
            'correo'    => $validated['correo'] ?? null,
            'ci'        => $validated['ci'] ?? null,
            'id_empresa' => $empresaId,
            'estado'    => 1,
        ]);

        return response()->json([
            'id'       => $proveedor->id,
            'nombre'   => trim("{$proveedor->nombre} {$proveedor->paterno} {$proveedor->materno}"),
            'ruc'      => $proveedor->ci,
            'telefono' => $proveedor->telefono,
            'email'    => $proveedor->correo,
        ]);
    }

    public function AlmacenList()
    {
        $empresaId = auth()->user()->id_empresa;

        // Obtener todos los almacenes de las sucursales de esta empresa
        $almacenes = Almacen::whereHas('sucursal', function ($q) use ($empresaId) {
            $q->where('empresa_id', $empresaId);
        })->get();

        // Transformar a JSON simple
        $data = $almacenes->map(function ($a) {
            return [
                'id' => $a->id,
                'nombre' => $a->nombre,
            ];
        });

        return response()->json($data);
    }

    /**
     * Guarda un nuevo almacén.
     */
    public function AlmacenStore(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'responsable' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
        ]);

        $empresaId = auth()->user()->id_empresa;

        // Por defecto asignar la primera sucursal de la empresa
        $sucursal = Sucursal::where('empresa_id', $empresaId)->first();
        if (!$sucursal) {
            return response()->json(['error' => 'No hay sucursal asociada a la empresa'], 422);
        }

        $almacen = almacen::create([
            'sucursal_id' => $sucursal->id,
            'nombre' => $request->nombre,
            'estado' => 1, // activo por defecto
        ]);

        return response()->json($almacen);
    }
    public function ProductoList(Request $request)
    {
        $empresaId = auth()->user()->id_empresa; // filtrar por empresa si aplica

        $productos = Producto::where('id_empresa', $empresaId)
            ->with(['categoria', 'tipoPrecio']) // incluir relaciones si quieres
            ->limit(100) // limitar cantidad por rendimiento
            ->get();

        $data = $productos->map(function ($p) {
            return [
                'id'      => $p->id,
                'name'    => $p->nombre,
                'price'   => $p->tipoPrecio ? ($p->tipoPrecio->valor ?? 0) : 0,
                'category' => $p->categoria ? $p->categoria->nombre : '-',
                'brand'   => $p->marca ?? '-',
                'model'   => $p->modelo ?? '-',
                'origin'  => $p->origen ?? '-'
            ];
        });

        return response()->json($data);
    }


    public function apiIndex(Request $request)
    {
        $empresaId = auth()->user()->id_empresa;

        $q = Compra::query()
            ->with(['proveedor:id,nombre,paterno,materno', 'almacen:id,nombre'])
            ->where('id_empresa', $empresaId);

        // filtros
        if ($s = trim($request->get('search', ''))) {
            $q->where(function($qq) use ($s) {
                $qq->where('observacion','like',"%{$s}%")
                ->orWhere('numero_factura','like',"%{$s}%")
                ->orWhereHas('proveedor', function($qp) use ($s){
                    $qp->where(DB::raw("CONCAT(IFNULL(nombre,''),' ',IFNULL(paterno,''),' ',IFNULL(materno,''))"), 'like', "%{$s}%");
                });
            });
        }
        if ($from = $request->get('from')) $q->whereDate('fecha_ingreso','>=',$from);
        if ($to   = $request->get('to'))   $q->whereDate('fecha_ingreso','<=',$to);

        $perPage = max(10, (int) $request->get('per_page', 10));
        $rows = $q->orderByDesc('id')->paginate($perPage);

        // adapta nombres al front
        $rows->getCollection()->transform(function($c){
            return [
                'id'               => $c->id,
                'proveedor'        => trim(($c->proveedor->nombre ?? '').' '.($c->proveedor->paterno ?? '')),
                'numero_factura'   => $c->numero_factura,
                'fecha'            => $c->fecha_ingreso,
                'almacen_nombre'   => $c->almacen->nombre ?? '—',
                'total'            => $c->total,
                'estado'           => $c->estado,
            ];
        });

        return response()->json([
            'data' => $rows->items(),
            'meta' => [
                'current_page' => $rows->currentPage(),
                'last_page'    => $rows->lastPage(),
                'from'         => $rows->firstItem(),
                'to'           => $rows->lastItem(),
                'total'        => $rows->total(),
            ],
        ]);
    }

    /** Detalle para una compra (filas del desplegable) */
    public function apiDetalles($id)
    {
        $empresaId = auth()->user()->id_empresa;

        $detalles = Producto_compra::with('producto:id,nombre,codigo,marca,modelo')
            ->whereHas('compra', function($q) use ($empresaId, $id) {
                $q->where('id_empresa', $empresaId)->where('id', $id);
            })
            ->orderBy('id')
            ->get()
            ->map(function($d){
                return [
                    'producto'          => $d->producto->nombre ?? '—',
                    'codigo'            => $d->producto->codigo ?? '—',
                    'marca'             => $d->producto->marca ?? '—',
                    'modelo'            => $d->producto->modelo ?? '—',
                    'lote'              => $d->lote,
                    'fecha_vencimiento' => $d->fecha_vencimiento,
                    'cantidad'          => $d->cantidad,
                    'costo_unitario'    => $d->costo_unitario,
                    'costo_total'       => $d->costo_total,
                ];
            });

        return response()->json(['items' => $detalles]);
    }

    //registrar la compra
    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedor,id',
            'almacen_id' => 'required|exists:almacen,id',
            'fecha_ingreso' => 'required|date',
            'tipo' => 'nullable|string',
            'observacion' => 'nullable|string',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required|exists:producto,id',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'productos.*.costo_unitario' => 'required|numeric|min:0',
            'productos.*.costo_total' => 'required|numeric|min:0', // ✅ corregido
            'productos.*.lote' => 'nullable|string',
            'productos.*.fecha_vencimiento' => 'nullable|date',
            'factura' => 'nullable|boolean',
            'numero_factura' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // 1️⃣ Crear la compra
            $compra = Compra::create([
                'id_empresa'   => Auth::user()->id_empresa,
                'sucursal_id'  => Auth::user()->sucursal_id ?? 1,
                'almacen_id'   => $request->almacen_id,
                'proveedor_id' => $request->proveedor_id,
                'fecha_ingreso' => $request->fecha_ingreso,
                'tipo'         => $request->tipo ?? 'compra',
                'subtotal'     => collect($request->productos)->sum(fn($p) => $p['cantidad'] * $p['costo_unitario']),
                'descuento'    => $request->descuento ?? 0,
                'total'        => collect($request->productos)->sum(fn($p) => $p['costo_total']), // ✅ corregido
                'estado'       => 1,
                'observacion'  => $request->observacion,
                'recepcion'    => $request->factura ?? 0,
                'usuario_id'   => Auth::id(),
            ]);
            

            // 2️⃣ Recorrer los productos y crear detalle
            foreach ($request->productos as $p) {
                $detalle = Producto_compra::create([
                    'producto_id'       => $p['producto_id'],
                    'compra_id'         => $compra->id,
                    'empresa_id'        => Auth::user()->id_empresa,
                    'lote'              => $p['lote'] ?? null,
                    'fecha_vencimiento' => $p['fecha_vencimiento'] ?? null,
                    'cantidad'          => $p['cantidad'],
                    'costo_unitario'    => $p['costo_unitario'],
                    'costo_total'       => $p['costo_total'],
                ]);
                
                // 👇 MUY IMPORTANTE: volver a leer lo que guardó el trigger
                $detalle->refresh();
                
                // 👇 Plan B (por si el trigger no se ejecutó o estás en otra BD)
                if (empty($detalle->id_lote)) {
                    $next = DB::table('producto_compra')
                        ->where('empresa_id', Auth::user()->id_empresa)
                        ->max('id_lote');
                    $next = ($next ?? 0) + 1;
                
                    DB::table('producto_compra')
                        ->where('id', $detalle->id)
                        ->update(['id_lote' => $next]);
                
                    $detalle->id_lote = $next;
                }
                

                // 3️⃣ Actualizar stock en producto_almacen
                $productoAlmacen = Producto_almacen::firstOrCreate(
                    [
                        'producto_id'        => $p['producto_id'],
                        'almacen_id'         => $request->almacen_id,
                        'empresa_id'         => Auth::user()->id_empresa,
                        'id_lote'            => $detalle->id_lote,   // <-- ¡aquí!
                    ],
                    [
                        'producto_compra_id' => $detalle->id,
                        'lote'               => $p['lote'] ?? null,
                        'stock'              => 0,
                        'estado'             => 1,
                    ]
                );
                $productoAlmacen->increment('stock', $p['cantidad']);
                
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Compra registrada correctamente',
                'compra_id' => $compra->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar la compra: ' . $e->getMessage()
            ], 500);
        }
    }
    public function create()
    {
        // Aquí retornas la vista del formulario de nueva compra
        return view('compra.compra'); 
        // ⚠️ asegúrate de que exista resources/views/compra/compra.blade.php
    }
}
