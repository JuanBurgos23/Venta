<?php

namespace App\Http\Controllers;

use App\Models\Subcategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubcategoriaController extends Controller
{
    /** Opcional: listar solo subcategorías (si quisieras una pestaña separada) */
    public function fetch(Request $request)
    {
        $search  = (string) $request->input('search', '');
        $catId   = $request->input('categoria_id');
        $perPage = (int) $request->input('per_page', 10);
        $page    = (int) $request->input('page', 1);

        $user = Auth::user();

        $q = Subcategoria::with('categoria:id,nombre')
            ->where('estado', '!=', 0);

        if (!$user->hasRole('Administrador')) {
            $q->where('id_empresa', $user->id_empresa ?? 0);
        }

        if ($catId) $q->where('categoria_id', $catId);

        if ($search !== '') {
            $q->where(function($w) use ($search){
                $w->where('nombre','like',"%{$search}%")
                  ->orWhere('descripcion','like',"%{$search}%");
            });
        }

        $data = $q->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);
        return response()->json($data);
    }

    /** Subcategorías por categoría (para combos dependientes) */
    public function listByCategoria($categoriaId)
    {
        $user = Auth::user();

        $q = Subcategoria::select('id','nombre','categoria_id')
            ->where('estado','!=',0)
            ->where('categoria_id', $categoriaId);

        if (!$user->hasRole('Administrador')) {
            $q->where('id_empresa', $user->id_empresa ?? 0);
        }

        return response()->json($q->orderBy('nombre')->get());
    }

    /** POST /subcategorias — crea subcategoría asociada */
    public function store(Request $request)
    {
        $empresaId = Auth::user()->id_empresa ?? null;
        if (!$empresaId) {
            return response()->json(['status'=>'error','message'=>'El usuario no tiene empresa asociada.'], 200);
        }

        $v = Validator::make($request->all(), [
            'categoria_id' => 'required|integer|exists:categoria,id',
            'nombre'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string|max:200',
            'estado'       => 'nullable|integer|in:0,1',
        ]);
        if ($v->fails()) {
            return response()->json(['status'=>'error','message'=>$v->errors()->first(),'errors'=>$v->errors()], 200);
        }

        // Validar que la categoría pertenezca a la empresa si NO es Admin
        $user = Auth::user();
        if (!$user->hasRole('Administrador')) {
            $cat = Categoria::select('id','id_empresa')->find($request->categoria_id);
            if (!$cat || (int)$cat->id_empresa !== (int)($user->id_empresa ?? 0)) {
                return response()->json(['status'=>'error','message'=>'No autorizado para usar esta categoría.'], 200);
            }
        }

        $sub = Subcategoria::create([
            'categoria_id'=> $request->categoria_id,
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado'      => $request->filled('estado') ? (int)$request->estado : 1,
        ]);

        return response()->json(['status'=>'success','message'=>'Subcategoría creada correctamente','subcategoria'=>$sub], 200);
    }

    /** PUT /subcategorias/{id} */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $q = Subcategoria::query();
        if (!$user->hasRole('Administrador')) {
        }
        $sub = $q->find($id);
        if (!$sub || (int)$sub->estado === 0) {
            return response()->json(['status'=>'error','message'=>'Subcategoría no encontrada'], 200);
        }

        $v = Validator::make($request->all(), [
            'categoria_id' => 'nullable|integer|exists:categoria,id',
            'nombre'       => 'required|string|max:150',
            'descripcion'  => 'nullable|string|max:200',
            'estado'       => 'nullable|integer|in:0,1',
        ]);
        if ($v->fails()) {
            return response()->json(['status'=>'error','message'=>$v->errors()->first(),'errors'=>$v->errors()], 200);
        }

        // Si cambia la categoría, validar pertenencia (no Admin)
        if ($request->filled('categoria_id') && (int)$request->categoria_id !== (int)$sub->categoria_id) {
            if (!$user->hasRole('Administrador')) {
                $cat = Categoria::select('id','id_empresa')->find($request->categoria_id);
                if (!$cat || (int)$cat->id_empresa !== (int)($user->id_empresa ?? 0)) {
                    return response()->json(['status'=>'error','message'=>'No autorizado para mover a esta categoría.'], 200);
                }
            }
            $sub->categoria_id = (int)$request->categoria_id;
        }

        $sub->nombre      = $request->nombre;
        $sub->descripcion = $request->descripcion;
        if ($request->filled('estado')) $sub->estado = (int)$request->estado;
        $sub->save();

        return response()->json(['status'=>'success','message'=>'Subcategoría actualizada correctamente','subcategoria'=>$sub], 200);
    }

    /** DELETE /subcategorias/{id} — borrado lógico */
    public function destroy($id)
    {
        $user = Auth::user();

        $q = Subcategoria::query();
        if (!$user->hasRole('Administrador')) {
            $q->where('id_empresa', $user->id_empresa ?? 0);
        }
        $sub = $q->find($id);
        if (!$sub) return response()->json(['status'=>'error','message'=>'Subcategoría no encontrada'], 200);

        $sub->estado = 0;
        $sub->save();

        return response()->json(['status'=>'success','message'=>'Subcategoría eliminada'], 200);
    }
}