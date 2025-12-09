<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SucursalController extends Controller
{
    /**
     * GET /sucursales/fetch?search=&page=1&per_page=10
     * Lista paginada + búsqueda, scope por empresa (si no es Admin)
     */


     public function index()
     {
         return view('sucursal/sucursal');
     }
    public function fetch(Request $request)
    {
        $user = Auth::user();
        $search  = (string) $request->input('search', '');
        $perPage = (int) $request->input('per_page', 10);
        $page    = (int) $request->input('page', 1);

        $q = Sucursal::query()
            ->with('empresa')
            ->where('estado', '!=', 0);

        // Restringir por empresa del usuario
        if ($user && $user->id_empresa) {
            $q->where('empresa_id', $user->id_empresa);
        } else {
            // sin empresa asociada no devolvemos registros
            return response()->json([
                'data' => [],
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ]);
        }

        if ($search !== '') {
            $q->where(function ($w) use ($search) {
                $w->where('nombre', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%")
                  ->orWhere('correo', 'like', "%{$search}%")
                  ->orWhere('direccion', 'like', "%{$search}%")
                  ->orWhere('ciudad', 'like', "%{$search}%")
                  ->orWhere('departamento', 'like', "%{$search}%");
            });
        }

        $data = $q->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($data);
    }

    /**
     * GET /sucursales/{id}/edit
     * Devuelve la sucursal (JSON), con scope por empresa si no es Admin
     */
    public function edit($id)
    {
        $user = Auth::user();

        $q = Sucursal::with('empresa');

        if (!$user->hasRole('Administrador')) {
            $q->where('empresa_id', $user->id_empresa ?? 0);
        }

        $sucursal = $q->findOrFail($id); 

        return response()->json($sucursal);
    }

    /**
     * POST /sucursales
     * Crea sucursal asignando empresa_id desde el usuario
     */
    public function store(Request $request)
    {
        $empresaId = Auth::user()->id_empresa ?? null;
        if (!$empresaId) {
            return response()->json(['status'=>'error','message'=>'El usuario no tiene empresa asociada.'], 200);
        }

        $v = Validator::make($request->all(), [
            'nombre'       => 'required|string|max:120',
            'telefono'     => 'nullable|string|max:50',
            'correo'       => 'nullable|email|max:120',
            'direccion'    => 'nullable|string|max:200',
            'ciudad'       => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'lat'          => 'nullable|numeric',
            'lng'          => 'nullable|numeric',
        ]);

        if ($v->fails()) {
            return response()->json(['status'=>'error','message'=>$v->errors()->first(),'errors'=>$v->errors()], 200);
        }

        $sucursal = Sucursal::create(array_merge($v->validated(), [
            'empresa_id' => $empresaId,
            'estado'     => 1,
        ]));

        return response()->json(['status'=>'success','message'=>'Sucursal creada correctamente','sucursal'=>$sucursal->load('empresa')], 200);
    }

    /**
     * PUT /sucursales/{id}
     * Actualiza sucursal (scope por empresa si no es Admin)
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $q = Sucursal::query();
        if (!$user->hasRole('Administrador')) {
            $q->where('empresa_id', $user->id_empresa ?? 0);
        }
        $sucursal = $q->find($id);
        if (!$sucursal || (int)$sucursal->estado === 0) {
            return response()->json(['status'=>'error','message'=>'Sucursal no encontrada'], 200);
        }

        $v = Validator::make($request->all(), [
            'nombre'       => 'required|string|max:120',
            'telefono'     => 'nullable|string|max:50',
            'correo'       => 'nullable|email|max:120',
            'direccion'    => 'nullable|string|max:200',
            'ciudad'       => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'lat'          => 'nullable|numeric',
            'lng'          => 'nullable|numeric',
            'estado'       => 'nullable|integer|in:0,1',
        ]);

        if ($v->fails()) {
            return response()->json(['status'=>'error','message'=>$v->errors()->first(),'errors'=>$v->errors()], 200);
        }

        $sucursal->update(array_merge($v->validated(), [
            // evita que cambien empresa_id cruzado por POST
            'empresa_id' => $sucursal->empresa_id,
        ]));

        return response()->json(['status'=>'success','message'=>'Sucursal actualizada correctamente','sucursal'=>$sucursal->load('empresa')], 200);
    }

    /**
     * DELETE /sucursales/{id}
     * Borrado lógico (estado = 0), con scope por empresa si no es Admin
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $q = Sucursal::query();
        if (!$user->hasRole('Administrador')) {
            $q->where('empresa_id', $user->id_empresa ?? 0);
        }
        $sucursal = $q->find($id);

        if (!$sucursal) {
            return response()->json(['status'=>'error','message'=>'Sucursal no encontrada'], 200);
        }

        $sucursal->estado = 0;
        $sucursal->save();

        return response()->json(['status'=>'success','message'=>'Sucursal eliminada'], 200);
    }
}
