<?php

namespace App\Http\Controllers;

use App\Models\Unidad_medida; // <- tu modelo usa este nombre/clase
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UnidadMedidaController extends Controller
{
    /**
     * GET /unidad-medida
     * Devuelve la vista (el listado se carga vía fetch por AJAX)
     */
    public function index()
    {
        return view('unidad_medida/unidad_medida');
    }

    /**
     * GET /unidad-medida/fetch?search=&page=1&per_page=10
     * Lista paginada + búsqueda; scope por empresa si NO es Admin.
     */
    public function fetch(Request $request)
    {
        $search  = (string) $request->input('search', '');
        $perPage = (int) $request->input('per_page', 10);
        $page    = (int) $request->input('page', 1);

        $user = Auth::user();

        $q = Unidad_medida::query()
            ->where('estado', '!=', 0);

        if ($search !== '') {
            $q->where(function ($w) use ($search) {
                $w->where('nombre', 'like', "%{$search}%");
            });
        }

        $data = $q->orderByDesc('id')
                  ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($data);
    }

    /**
     * GET /unidad-medida/{id}/edit
     * Devuelve el registro (JSON); scope por empresa si NO es Admin.
     */
    public function edit($id)
    {
        $user = Auth::user();

        $q = Unidad_medida::query();

        if (!$user->hasRole('Administrador')) {
            $q->where('id_empresa', $user->id_empresa ?? 0);
        }

        $um = $q->findOrFail($id);

        return response()->json($um);
    }

    /**
     * POST /unidad-medida
     * Crea unidad de medida con empresa del usuario.
     */
    public function store(Request $request)
    {
        $empresaId = Auth::user()->id_empresa ?? null;
        if (!$empresaId) {
            return response()->json([
                'status'  => 'error',
                'message' => 'El usuario no tiene empresa asociada.'
            ], 200);
        }

        $v = Validator::make($request->all(), [
            'nombre' => 'required|string|max:120',
            'estado' => 'nullable|integer|in:0,1',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $v->errors()->first(),
                'errors'  => $v->errors(),
            ], 200);
        }

        $um = Unidad_medida::create([
            'id_empresa' => $empresaId,
            'nombre'     => $request->nombre,
            'estado'     => $request->filled('estado') ? (int)$request->estado : 1,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Unidad de medida creada correctamente',
            'unidad'  => $um
        ], 200);
    }

    /**
     * PUT /unidad-medida/{id}
     * Actualiza unidad de medida; scope por empresa si NO es Admin.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $q = Unidad_medida::query();
        if (!$user->hasRole('Administrador')) {
            $q->where('id_empresa', $user->id_empresa ?? 0);
        }
        $um = $q->find($id);

        if (!$um || (int)$um->estado === 0) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unidad de medida no encontrada'
            ], 200);
        }

        $v = Validator::make($request->all(), [
            'nombre' => 'required|string|max:120',
            'estado' => 'nullable|integer|in:0,1',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $v->errors()->first(),
                'errors'  => $v->errors(),
            ], 200);
        }

        $um->nombre = $request->nombre;
        if ($request->filled('estado')) {
            $um->estado = (int)$request->estado;
        }
        $um->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Unidad de medida actualizada correctamente',
            'unidad'  => $um
        ], 200);
    }

    /**
     * DELETE /unidad-medida/{id}
     * Borrado lógico (estado = 0); scope por empresa si NO es Admin.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $q = Unidad_medida::query();
        if (!$user->hasRole('Administrador')) {
            $q->where('id_empresa', $user->id_empresa ?? 0);
        }

        $um = $q->find($id);
        if (!$um) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unidad de medida no encontrada'
            ], 200);
        }

        $um->estado = 0;
        $um->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Unidad de medida eliminada'
        ], 200);
    }
}
