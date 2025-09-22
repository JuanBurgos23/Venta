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
        return view('compra.compra');
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
            $producto->fill($validated);
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

        $mapped = collect($paginator->items())->map(function ($p) {
            return [
                'id'           => (int)$p->id,
                'nombre'       => $p->nombre,
                'precio'       => 0, // por ahora fijo, ajusta si usas otra tabla de precios
                'categoria'    => $p->categoria ? ['nombre' => $p->categoria->nombre] : null,
                'subcategoria' => $p->subcategoria ? ['nombre' => $p->subcategoria->nombre] : null,
                'stock_actual' => null, // si no manejas stock aún
                'minimo'       => null,
            ];
        })->values();

        return response()->json([
            'data'         => $mapped,
            'current_page' => $paginator->currentPage(),
            'last_page'    => $paginator->lastPage(),
            'total'        => $paginator->total(),
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
