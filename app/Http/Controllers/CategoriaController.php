<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /** Vista (listado + modales vía AJAX) */
    public function index()
    {
        return view('categoria/categoria'); // misma pantalla para cat/subcat
    }

    /** GET /categorias/fetch?search=&page=1&per_page=10
     *  Devuelve categorías (con subcategorías) paginadas
     */
    public function fetch(Request $request)
    {
        $search  = (string) $request->input('search', '');
        $perPage = (int) $request->input('per_page', 10);
        $page    = (int) $request->input('page', 1);

        $user = Auth::user();

        $q = Categoria::with(['subcategorias' => function($sc){
                $sc->where('estado', '!=', 0)->orderBy('nombre');
            }])
            ->where('estado', '!=', 0);
        if ($search !== '') {
            $q->where(function($w) use ($search){
                $w->where('nombre', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        $data = $q->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
        return response()->json($data);
    }

    /** GET /categorias/{id}/edit */
    public function edit($id)
    {
        $user = Auth::user();
        $q = Categoria::query();
        $categoria = $q->findOrFail($id);
        return response()->json($categoria);
    }

    /** POST /categorias */
    public function store(Request $request)
    {
        $empresaId = Auth::user()->id_empresa ?? null;
        if (!$empresaId) {
            return response()->json(['status'=>'error','message'=>'El usuario no tiene empresa asociada.'], 200);
        }

        $v = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:200',
            'estado'      => 'nullable|integer|in:0,1',
        ]);
        if ($v->fails()) {
            return response()->json(['status'=>'error','message'=>$v->errors()->first(),'errors'=>$v->errors()], 200);
        }

        $cat = Categoria::create([
            'id_empresa'  => $empresaId,
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado'      => $request->filled('estado') ? (int)$request->estado : 1,
        ]);

        return response()->json(['status'=>'success','message'=>'Categoría creada correctamente','categoria'=>$cat], 200);
    }

    /** PUT /categorias/{id} */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $q = Categoria::query();
        $cat = $q->find($id);
        if (!$cat || (int)$cat->estado === 0) {
            return response()->json(['status'=>'error','message'=>'Categoría no encontrada'], 200);
        }

        $v = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:150',
            'descripcion' => 'nullable|string|max:200',
            'estado'      => 'nullable|integer|in:0,1',
        ]);
        if ($v->fails()) {
            return response()->json(['status'=>'error','message'=>$v->errors()->first(),'errors'=>$v->errors()], 200);
        }

        $cat->nombre      = $request->nombre;
        $cat->descripcion = $request->descripcion;
        if ($request->filled('estado')) $cat->estado = (int)$request->estado;
        $cat->save();

        return response()->json(['status'=>'success','message'=>'Categoría actualizada correctamente','categoria'=>$cat], 200);
    }

    /** DELETE /categorias/{id} — borrado lógico */
    public function destroy($id)
    {
        $user = Auth::user();
        $q = Categoria::query();
        $cat = $q->find($id);
        if (!$cat) return response()->json(['status'=>'error','message'=>'Categoría no encontrada'], 200);

        $cat->estado = 0;
        $cat->save();

        return response()->json(['status'=>'success','message'=>'Categoría eliminada'], 200);
    }
}