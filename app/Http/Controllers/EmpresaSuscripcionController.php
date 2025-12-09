<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\EmpresaSuscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmpresaSuscripcionController extends Controller
{
    public function fetch(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa ?? null;

        // Permitir filtrar otra empresa solo para admins
        if ($user->hasRole('Administrador') && $request->filled('empresa_id')) {
            $empresaId = $request->input('empresa_id');
        }

        if (!$empresaId) {
            return response()->json([
                'data' => [],
                'current_page' => 1,
                'last_page' => 1,
                'total' => 0,
            ]);
        }

        $perPage = (int) $request->input('per_page', 10);
        $page    = (int) $request->input('page', 1);

        $query = EmpresaSuscripcion::with(['empresa', 'suscripcion'])
            ->where('empresa_id', $empresaId);

        $data = $query->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa ?? null;

        // Solo admin puede asignar a otra empresa
        if ($user->hasRole('Administrador') && $request->filled('empresa_id')) {
            $empresaId = $request->input('empresa_id');
        }

        if (!$empresaId) {
            return response()->json(['status' => 'error', 'message' => 'El usuario no tiene empresa asociada'], 200);
        }

        $v = Validator::make($request->all(), [
            'suscripcion_id' => 'required|exists:suscripcion,id',
            'fecha_inicio'   => 'required|date',
            'fecha_fin'      => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $v->errors()->first(),
                'errors'  => $v->errors(),
            ], 200);
        }

        $exists = EmpresaSuscripcion::where('empresa_id', $empresaId)
            ->where('suscripcion_id', $request->suscripcion_id)
            ->first();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'La empresa ya tiene esta suscripción asignada',
            ], 200);
        }

        $registro = EmpresaSuscripcion::create([
            'empresa_id'     => $empresaId,
            'suscripcion_id' => $request->suscripcion_id,
            'fecha_inicio'   => $request->fecha_inicio,
            'fecha_fin'      => $request->fecha_fin,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Suscripción asignada a la empresa',
            'empresa_suscripcion' => $registro->load(['empresa', 'suscripcion']),
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa ?? null;

        if ($user->hasRole('Administrador') && $request->filled('empresa_id')) {
            $empresaId = $request->input('empresa_id');
        }

        $registro = EmpresaSuscripcion::where('id', $id)
            ->when($empresaId, function ($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->first();

        if (!$registro) {
            return response()->json(['status' => 'error', 'message' => 'Registro no encontrado'], 200);
        }

        $v = Validator::make($request->all(), [
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $v->errors()->first(),
                'errors'  => $v->errors(),
            ], 200);
        }

        $registro->update($v->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Suscripción actualizada',
            'empresa_suscripcion' => $registro->load(['empresa', 'suscripcion']),
        ], 200);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa ?? null;

        $registro = EmpresaSuscripcion::where('id', $id)
            ->when($empresaId, function ($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })
            ->first();

        if (!$registro) {
            return response()->json(['status' => 'error', 'message' => 'Registro no encontrado'], 200);
        }

        $registro->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Suscripción eliminada de la empresa',
        ], 200);
    }
}
