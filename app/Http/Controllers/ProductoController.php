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
                'inventariable' => 'required|in:0,1',

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
                'inventariable' => $p->inventariable,
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
            'inventariable' => $producto->inventariable,
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
                'inventariable' => 'required|in:0,1',

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
