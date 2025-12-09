<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AlmacenController extends Controller
{
    /**
     * GET /almacenes/fetch?search=&page=1&per_page=10&sucursal_id=
     * Lista paginada + búsqueda; scope por empresa (si no es Admin).
     */
    public function index()
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa ?? null;

        $sucursal = Sucursal::select('id', 'nombre')
            ->when($empresaId, function ($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->where('estado', '!=', 0)
            ->orderBy('nombre')
            ->get();

        return view('almacen.almacen', compact('sucursal'));
    }

    public function fetch(Request $request)
    {
        $search  = $request->input('search', '');
        $perPage = $request->input('per_page', 10);
        $page    = $request->input('page', 1);

        $user = Auth::user();
        $empresaId = $user->id_empresa ?? null;
        if (!$empresaId) {
            return response()->json([
                'data' => [],
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ]);
        }

        $q = Almacen::with('sucursal') // traemos la sucursal
            ->where('estado', '!=', 0);

        // Scope por empresa del usuario (siempre)
        $q->whereHas('sucursal', function ($w) use ($empresaId) {
            $w->where('empresa_id', $empresaId);
        });

        if ($search !== '') {
            $q->where(function ($w) use ($search) {
                $w->where('nombre', 'like', "%{$search}%")
                    ->orWhereHas('sucursal', function ($ws) use ($search) {
                        $ws->where('nombre', 'like', "%{$search}%");
                    });
            });
        }

        $data = $q->with('sucursal')->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($data);
    }

    /**
     * GET /almacenes/{id}/edit
     * Devuelve el almacén; scope por empresa si NO es Admin.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa ?? null;

        $q = Almacen::with(['sucursal:id,empresa_id,nombre', 'sucursal.empresa:id,nombre'])
            ->whereHas('sucursal', function ($w) use ($empresaId) {
                if ($empresaId) {
                    $w->where('empresa_id', $empresaId);
                }
            });

        $almacen = $q->findOrFail($id);

        return response()->json($almacen);
    }

    /**
     * POST /almacenes
     * Crea almacén. Valida que la sucursal pertenezca a la empresa del usuario.
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'sucursal_id' => 'required|integer|exists:sucursal,id', // si tu tabla es 'sucursales', cambia a exists:sucursales,id
            'nombre'      => 'required|string|max:120',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $v->errors()->first(),
                'errors'  => $v->errors(),
            ], 200);
        }

        $user      = Auth::user();
        $sucursal  = Sucursal::select('id', 'empresa_id')->find($request->sucursal_id);

        if (!$sucursal) {
            return response()->json(['status' => 'error', 'message' => 'Sucursal no encontrada.'], 200);
        }

        // Scope por empresa si NO es Admin
        if (!$user->hasRole('Administrador')) {
            if (($user->id_empresa ?? 0) != $sucursal->empresa_id) {
                return response()->json(['status' => 'error', 'message' => 'No autorizado para usar esta sucursal.'], 200);
            }
        }

        $almacen = Almacen::create([
            'sucursal_id' => $sucursal->id,
            'nombre'      => $request->nombre,
            'estado'      => 1,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Almacén creado correctamente',
            'almacen' => $almacen->load(['sucursal:id,empresa_id,nombre', 'sucursal.empresa:id,nombre']),
        ], 200);
    }

    /**
     * PUT /almacenes/{id}
     * Actualiza almacén. Si cambia sucursal_id, valida pertenencia a la misma empresa (si no es Admin).
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        // Buscar con scope por empresa si no es Admin
        $empresaId = $user->id_empresa ?? null;

        $q = Almacen::query()->whereHas('sucursal', function ($w) use ($empresaId) {
            if ($empresaId) {
                $w->where('empresa_id', $empresaId);
            }
        });
        $almacen = $q->find($id);

        if (!$almacen || (int)$almacen->estado === 0) {
            return response()->json(['status' => 'error', 'message' => 'Almacén no encontrado'], 200);
        }

        $v = Validator::make($request->all(), [
            'sucursal_id' => 'nullable|integer|exists:sucursal,id', // ajusta a 'sucursales' si corresponde
            'nombre'      => 'required|string|max:120',
            'estado'      => 'nullable|integer|in:0,1',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $v->errors()->first(),
                'errors'  => $v->errors(),
            ], 200);
        }

        // Si piden mover a otra sucursal, validar pertenencia
        if ($request->filled('sucursal_id') && (int)$request->sucursal_id !== (int)$almacen->sucursal_id) {
            $nueva = Sucursal::select('id', 'empresa_id')->find($request->sucursal_id);
            if (!$nueva) {
                return response()->json(['status' => 'error', 'message' => 'Sucursal destino no encontrada.'], 200);
            }
            if (!$user->hasRole('Administrador')) {
                if (($user->id_empresa ?? 0) != $nueva->empresa_id) {
                    return response()->json(['status' => 'error', 'message' => 'No autorizado para mover a esta sucursal.'], 200);
                }
            }
            $almacen->sucursal_id = $nueva->id;
        }

        $almacen->nombre = $request->nombre;
        if ($request->filled('estado')) {
            $almacen->estado = (int)$request->estado;
        }
        $almacen->save();

        return response()->json([
            'status'  => 'success',
            'message' => 'Almacén actualizado correctamente',
            'almacen' => $almacen->load(['sucursal:id,empresa_id,nombre', 'sucursal.empresa:id,nombre']),
        ], 200);
    }

    /**
     * DELETE /almacenes/{id}
     * Borrado lógico (estado = 0). Scope por empresa si NO es Admin.
     */
    public function destroy($id)
    {
        $user = Auth::user();

        $empresaId = $user->id_empresa ?? null;

        $q = Almacen::query()->whereHas('sucursal', function ($w) use ($empresaId) {
            if ($empresaId) {
                $w->where('empresa_id', $empresaId);
            }
        });

        $almacen = $q->find($id);
        if (!$almacen) {
            return response()->json(['status' => 'error', 'message' => 'Almacén no encontrado'], 200);
        }

        $almacen->estado = 0;
        $almacen->save();

        return response()->json(['status' => 'success', 'message' => 'Almacén eliminado'], 200);
    }
}
