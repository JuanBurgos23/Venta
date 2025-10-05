<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Tipo_precio;
use App\Models\Subcategoria;
use Illuminate\Http\Request;
use App\Models\Tipo_producto;
use App\Models\Unidad_medida;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('producto.producto');
    }
    public function categorias()
    {
        return response()->json(
            Categoria::select('id', 'nombre')->orderBy('nombre')->get()
        );
    }

    public function importarMasivo(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No autenticado'], 401);
        }

        $empresaId = $user->id_empresa;
        $items     = $request->input('items', []);
        if (!is_array($items) || empty($items)) {
            return response()->json([
                'success' => false,
                'message' => 'No se recibieron ítems para importar.'
            ], 422);
        }

        // Opcional: modo de importación (create|update|upsert)
        $modo = $request->input('modo', 'upsert'); // por defecto crea o actualiza por codigo + empresa

        $insertados = 0;
        $actualizados = 0;
        $errores = [];
        $procesados = 0;

        // Si vas a resolver por nombre -> id, prepara caches simples por rendimiento
        $cacheCategoria    = [];
        $cacheSubcategoria = [];
        $cacheUnidad       = [];
        $cacheTipoProducto = [];
        $cacheTipoPrecio   = [];

        DB::beginTransaction();
        try {
            foreach ($items as $idx => $row) {
                $fila = $idx + 1;
                $procesados++;

                // Normaliza claves esperadas desde la tabla preview
                // (del front que te pasé: codigo, nombre, categoria, unidad, costo, precio_menor, precio_mayor, stock, lote, fecha_venc)
                $payload = [
                    'codigo'          => trim((string)($row['codigo'] ?? '')),
                    'nombre'          => trim((string)($row['nombre'] ?? '')),
                    'categoria'       => trim((string)($row['categoria'] ?? '')),
                    'subcategoria'    => trim((string)($row['subcategoria'] ?? '')),
                    'unidad'          => trim((string)($row['unidad'] ?? '')),
                    'tipo_producto'   => trim((string)($row['tipo_producto'] ?? '')),
                    'tipo_precio'     => trim((string)($row['tipo_precio'] ?? '')),
                    'costo'           => $row['costo'] ?? null,
                    'precio_menor'    => $row['precio_menor'] ?? null,
                    'precio_mayor'    => $row['precio_mayor'] ?? null,
                    'stock'           => $row['stock'] ?? null,
                    'lote'            => $row['lote'] ?? null,
                    'fecha_venc'      => $row['fecha_venc'] ?? null,
                    // Si tu modelo Producto usa directamente "precio", lo inferimos del precio_menor
                    'precio'          => $row['precio'] ?? ($row['precio_menor'] ?? null),
                    // Si envías IDs directos también los respetamos
                    'categoria_id'     => $row['categoria_id'] ?? null,
                    'subcategoria_id'  => $row['subcategoria_id'] ?? null,
                    'unidad_medida_id' => $row['unidad_medida_id'] ?? null,
                    'tipo_producto_id' => $row['tipo_producto_id'] ?? null,
                    'tipo_precio_id'   => $row['tipo_precio_id'] ?? null,
                    // Si planeas cargar stock en un almacén específico por fila:
                    'almacen_id'      => $row['almacen_id'] ?? null,
                ];

                // Validación por fila
                $v = Validator::make($payload, [
                    'codigo'       => 'required|string|max:100',
                    'nombre'       => 'required|string|max:200',
                    'precio'       => 'nullable|numeric',
                    'costo'        => 'nullable|numeric|min:0',
                    'precio_menor' => 'nullable|numeric|min:0',
                    'precio_mayor' => 'nullable|numeric|min:0',
                    'stock'        => 'nullable|numeric|min:0',
                    'fecha_venc'   => 'nullable|date_format:Y-m-d',
                    // Si recibes IDs directos y quieres validarlos:
                    'categoria_id'     => 'nullable|exists:categoria,id',
                    'subcategoria_id'  => 'nullable|exists:subcategoria,id',
                    'unidad_medida_id' => 'nullable|exists:unidad_medida,id',
                    'tipo_producto_id' => 'nullable|exists:tipo_producto,id',
                    'tipo_precio_id'   => 'nullable|exists:tipo_precio,id',
                ], [], [
                    'codigo' => "código (fila {$fila})",
                    'nombre' => "nombre (fila {$fila})",
                ]);

                if ($v->fails()) {
                    $errores[] = [
                        'fila' => $fila,
                        'codigo' => $payload['codigo'],
                        'errors' => $v->errors()->all()
                    ];
                    continue;
                }

                // Resolver IDs por nombre si no vienen IDs
                try {
                    // Categoria
                    if (!$payload['categoria_id'] && $payload['categoria']) {
                        $cacheCategoria[$payload['categoria']] ??= \App\Models\Categoria::where('id_empresa', $empresaId)
                            ->where('nombre', $payload['categoria'])
                            ->value('id');
                        $payload['categoria_id'] = $cacheCategoria[$payload['categoria']] ?? null;
                    }
                    // Subcategoria
                    if (!$payload['subcategoria_id'] && $payload['subcategoria']) {
                        $cacheSubcategoria[$payload['subcategoria']] ??= \App\Models\Subcategoria::where('id_empresa', $empresaId)
                            ->where('nombre', $payload['subcategoria'])
                            ->value('id');
                        $payload['subcategoria_id'] = $cacheSubcategoria[$payload['subcategoria']] ?? null;
                    }
                    // Unidad de medida
                    if (!$payload['unidad_medida_id'] && $payload['unidad']) {
                        $cacheUnidad[$payload['unidad']] ??= \App\Models\Unidad_medida::where('id_empresa', $empresaId)
                            ->where('nombre', $payload['unidad'])
                            ->value('id');
                        $payload['unidad_medida_id'] = $cacheUnidad[$payload['unidad']] ?? null;
                    }
                    // Tipo de producto
                    if (!$payload['tipo_producto_id'] && $payload['tipo_producto']) {
                        $cacheTipoProducto[$payload['tipo_producto']] ??= \App\Models\Tipo_producto::where('id_empresa', $empresaId)
                            ->where('nombre', $payload['tipo_producto'])
                            ->value('id');
                        $payload['tipo_producto_id'] = $cacheTipoProducto[$payload['tipo_producto']] ?? null;
                    }
                    // Tipo de precio
                    if (!$payload['tipo_precio_id'] && $payload['tipo_precio']) {
                        $cacheTipoPrecio[$payload['tipo_precio']] ??= \App\Models\Tipo_precio::where('id_empresa', $empresaId)
                            ->where('nombre', $payload['tipo_precio'])
                            ->value('id');
                        $payload['tipo_precio_id'] = $cacheTipoPrecio[$payload['tipo_precio']] ?? null;
                    }
                } catch (\Throwable $e) {
                    $errores[] = [
                        'fila' => $fila,
                        'codigo' => $payload['codigo'],
                        'errors' => ["Error resolviendo IDs por nombre: " . $e->getMessage()]
                    ];
                    continue;
                }

                try {
                    // Buscar existente por codigo + empresa
                    $producto = \App\Models\Producto::where('id_empresa', $empresaId)
                        ->where('codigo', $payload['codigo'])
                        ->first();

                    if ($modo === 'create' && $producto) {
                        $errores[] = [
                            'fila' => $fila,
                            'codigo' => $payload['codigo'],
                            'errors' => ["El código ya existe y el modo es 'create'."]
                        ];
                        continue;
                    }

                    if ($modo === 'update' && !$producto) {
                        $errores[] = [
                            'fila' => $fila,
                            'codigo' => $payload['codigo'],
                            'errors' => ["El código no existe y el modo es 'update'."]
                        ];
                        continue;
                    }

                    if (!$producto) {
                        $producto = new \App\Models\Producto();
                        $producto->id_empresa = $empresaId;
                    }

                    // Mapeo a tu modelo (usa los campos reales de tu tabla)
                    $producto->codigo            = $payload['codigo'];
                    $producto->nombre            = $payload['nombre'];
                    $producto->precio            = $payload['precio'] ?? ($payload['precio_menor'] ?? 0); // tu controlador usa 'precio' en create/update
                    $producto->costo             = $payload['costo'] ?? ($producto->costo ?? null); // si existe el campo
                    $producto->categoria_id      = $payload['categoria_id'] ?: null;
                    $producto->subcategoria_id   = $payload['subcategoria_id'] ?: null;
                    $producto->unidad_medida_id  = $payload['unidad_medida_id'] ?: null;
                    $producto->tipo_producto_id  = $payload['tipo_producto_id'] ?: null;
                    $producto->tipo_precio_id    = $payload['tipo_precio_id'] ?: null;

                    // Otros opcionales si tu tabla los tiene (marca, modelo, origen, etc.)
                    if (array_key_exists('marca', $row))  $producto->marca  = $row['marca'];
                    if (array_key_exists('modelo', $row)) $producto->modelo = $row['modelo'];
                    if (array_key_exists('origen', $row)) $producto->origen = $row['origen'];

                    $wasExisting = $producto->exists;
                    $producto->save();

                    if ($wasExisting) $actualizados++; else $insertados++;

                    // Stock inicial opcional
                    // Si manejas stock por almacén en tabla producto_almacen, solo lo hacemos si se envía almacen_id y stock > 0
                    $stockNum = is_null($payload['stock']) ? null : (float)$payload['stock'];
                    if ($stockNum !== null && $stockNum > 0 && !empty($payload['almacen_id'])) {
                        // upsert en producto_almacen
                        $pa = \App\Models\Producto_almacen::firstOrNew([
                            'empresa_id'  => $empresaId,
                            'almacen_id'  => $payload['almacen_id'],
                            'producto_id' => $producto->id,
                        ]);
                        $pa->stock = ($pa->exists ? ($pa->stock ?? 0) : 0) + $stockNum;
                        $pa->save();

                        // Si registras lotes y vencimientos en otra tabla (p.ej. inv_det_ingresov2), aquí podrías crear el movimiento de ingreso…
                        // En este ejemplo, solo guardamos lote/fecha_venc en el producto si tienes esos campos (si no, omite esto).
                        if (property_exists($producto, 'lote') && array_key_exists('lote', $payload)) {
                            $producto->lote = $payload['lote'];
                        }
                        if (property_exists($producto, 'fecha_venc') && array_key_exists('fecha_venc', $payload)) {
                            $producto->fecha_venc = $payload['fecha_venc'];
                        }
                        // $producto->save(); // si cambiaste algo del producto
                    }

                } catch (\Throwable $e) {
                    $errores[] = [
                        'fila' => $fila,
                        'codigo' => $payload['codigo'],
                        'errors' => ["Error al guardar: " . $e->getMessage()]
                    ];
                    continue;
                }
            }

            DB::commit();

            return response()->json([
                'success'      => true,
                'message'      => 'Importación procesada',
                'resumen'      => [
                    'procesados'   => $procesados,
                    'insertados'   => $insertados,
                    'actualizados' => $actualizados,
                    'errores'      => count($errores),
                ],
                'errores'      => $errores, // lista detallada por fila
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error general en la importación: '.$e->getMessage()
            ], 500);
        }
    }


    /**
     * Listar subcategorías de una categoría
     */
    public function subcategorias($categoriaId)
    {
        return response()->json(
            Subcategoria::where('categoria_id', $categoriaId)
                ->select('id', 'nombre')
                ->orderBy('nombre')
                ->get()
        );
    }

    /**
     * Listar tipos de producto
     */
    public function tiposProducto()
    {
        return response()->json(
            Tipo_producto::select('id', 'nombre')->orderBy('nombre')->get()
        );
    }

    /**
     * Listar unidades de medida
     */
    public function unidadesMedida()
    {
        return response()->json(
            Unidad_medida::select('id', 'nombre')->orderBy('nombre')->get()
        );
    }

    /**
     * Listar tipos de precio
     */
    public function tiposPrecio()
    {
        return response()->json(
            Tipo_precio::select('id', 'nombre')->orderBy('nombre')->get()
        );
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'codigo'          => 'required|string|max:100',
                'nombre'          => 'required|string|max:200',
                'precio'           => 'required|numeric', // <-- agregado
                'descripcion'     => 'nullable|string',
                'marca'           => 'nullable|string|max:100',
                'modelo'          => 'nullable|string|max:100',
                'origen'          => 'nullable|string|max:100',
                'categoria_id'    => 'nullable|exists:categoria,id',
                'subcategoria_id' => 'nullable|exists:subcategoria,id',
                'unidad_medida_id' => 'nullable|exists:unidad_medida,id',
                'tipo_producto_id' => 'nullable|exists:tipo_producto,id',
                'tipo_precio_id'  => 'nullable|exists:tipo_precio,id',
            ]);

            $producto = new Producto();
            $producto->fill($validated); // precio ahora incluido
            $producto->id_empresa = auth()->user()->id_empresa;

            // subir imagen
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('productos', 'public');
            }
            $producto->foto = $fotoPath;
            $producto->save();

            return response()->json([
                'success' => true,
                'message' => 'Producto registrado correctamente'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }


    public function fetch(Request $request)
    {
        $user      = Auth::user();
        $empresaId = $user->id_empresa ?? null; // filtrar por empresa
        $search    = $request->input('search', '');
        $perPage   = 10;
        $page      = (int)$request->input('page', 1);

        $q = Producto::with(['categoria:id,nombre', 'subcategoria:id,nombre'])
            ->when($empresaId, fn($qq) => $qq->where('id_empresa', $empresaId))
            ->where('estado', '!=', 'Eliminado') // ✅ Excluir productos eliminados
            ->when($search, function ($qq) use ($search) {
                $qq->where(function ($w) use ($search) {
                    $w->where('nombre', 'like', "%{$search}%")
                        ->orWhere('codigo', 'like', "%{$search}%")
                        ->orWhere('marca', 'like', "%{$search}%")
                        ->orWhere('modelo', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('id');

        // Paginación
        $paginator = $q->paginate($perPage, ['*'], 'page', $page);

        $mapped = collect($paginator->items())->map(function ($p) use ($empresaId) {
            // 🔹 calcular stock real desde producto_almacen
            $stock = \App\Models\Producto_almacen::where('producto_id', $p->id)
                ->where('empresa_id', $empresaId)
                ->sum('stock');

            return [
                'id'           => (int)$p->id,
                'codigo'       => $p->codigo,
                'nombre'       => $p->nombre,
                'precio'       => $p->precio ?? 0,
                'categoria'    => $p->categoria ? ['nombre' => $p->categoria->nombre] : null,
                'subcategoria' => $p->subcategoria ? ['nombre' => $p->subcategoria->nombre] : null,
                'stock_actual' => $stock,
                'minimo'       => $p->minimo ?? null,
                'image'        => $p->foto ? asset('storage/' . $p->foto) : null,
            ];
        })->values();

        return response()->json([
            'data'         => $mapped,
            'current_page' => $paginator->currentPage(),
            'last_page'    => $paginator->lastPage(),
            'total'        => $paginator->total(),
        ]);
    }


    public function show($id)
    {
        $producto = Producto::with(['categoria:id,nombre', 'subcategoria:id,nombre'])
            ->findOrFail($id);

        return response()->json([
            'id'          => $producto->id,
            'codigo'      => $producto->codigo,
            'nombre'      => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'marca'       => $producto->marca,
            'modelo'      => $producto->modelo,
            'origen'      => $producto->origen,
            'categoria_id'    => $producto->categoria_id,
            'subcategoria_id' => $producto->subcategoria_id,
            'unidad_medida_id' => $producto->unidad_medida_id,
            'tipo_producto_id' => $producto->tipo_producto_id,
            'tipo_precio_id'  => $producto->tipo_precio_id,
            'foto'        => $producto->foto,
            'precio'      => $producto->precio ?? 0, // precio directo en producto
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $producto = Producto::findOrFail($id);

            $validated = $request->validate([
                'codigo'          => 'required|string|max:100',
                'nombre'          => 'required|string|max:200',
                'precio'          => 'required|numeric', // <-- agregado
                'descripcion'     => 'nullable|string',
                'marca'           => 'nullable|string|max:100',
                'modelo'          => 'nullable|string|max:100',
                'origen'          => 'nullable|string|max:100',
                'categoria_id'    => 'nullable|exists:categoria,id',
                'subcategoria_id' => 'nullable|exists:subcategoria,id',
                'unidad_medida_id' => 'nullable|exists:unidad_medida,id',
                'tipo_producto_id' => 'nullable|exists:tipo_producto,id',
                'tipo_precio_id'  => 'nullable|exists:tipo_precio,id',
            ]);
            $producto->fill($validated);

            // ✅ actualizar imagen si se sube otra
            if ($request->hasFile('foto')) {
                // eliminar la anterior si existe
                if ($producto->foto && \Storage::disk('public')->exists($producto->foto)) {
                    \Storage::disk('public')->delete($producto->foto);
                }
                $producto->foto = $request->file('foto')->store('productos', 'public');
            }

            $producto->save();

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado correctamente'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function Categorialist(Request $request)
    {
        $query = Categoria::query()
            ->where('estado', 1) // si usas estado activo
            ->orderBy('nombre');

        // Opcional: filtrar por empresa
        if (auth()->check()) {
            $query->where('id_empresa', auth()->user()->id_empresa);
        }

        $categorias = $query->get(['id', 'nombre']);

        return response()->json($categorias);
    }
    public function byCategoria($categoriaId)
    {
        $subcategorias = Subcategoria::where('categoria_id', $categoriaId)
            ->where('estado', 1) // solo activas
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json($subcategorias);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = 'Eliminado';
        $producto->save();

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado correctamente'
        ]);
    }
}
