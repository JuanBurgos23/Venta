<?php

namespace App\Http\Controllers;

use App\Models\Suscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuscripcionController extends Controller
{
    public function fetch(Request $request)
    {
        $search  = $request->input('search', '');
        $perPage = (int) $request->input('per_page', 10);
        $page    = (int) $request->input('page', 1);

        $query = Suscripcion::query();

        if ($search !== '') {
            $query->where(function ($w) use ($search) {
                $w->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        $data = $query->orderByDesc('id')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:150|unique:suscripcion,nombre',
            'descripcion' => 'nullable|string',
            'estado'      => 'nullable|boolean',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $v->errors()->first(),
                'errors'  => $v->errors(),
            ], 200);
        }

        $suscripcion = Suscripcion::create($v->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Suscripción creada correctamente',
            'suscripcion' => $suscripcion,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $suscripcion = Suscripcion::find($id);
        if (!$suscripcion) {
            return response()->json(['status' => 'error', 'message' => 'Suscripción no encontrada'], 200);
        }

        $v = Validator::make($request->all(), [
            'nombre'      => 'required|string|max:150|unique:suscripcion,nombre,' . $id,
            'descripcion' => 'nullable|string',
            'estado'      => 'nullable|boolean',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $v->errors()->first(),
                'errors'  => $v->errors(),
            ], 200);
        }

        $suscripcion->update($v->validated());

        return response()->json([
            'status'  => 'success',
            'message' => 'Suscripción actualizada correctamente',
            'suscripcion' => $suscripcion,
        ], 200);
    }

    public function destroy($id)
    {
        $suscripcion = Suscripcion::find($id);
        if (!$suscripcion) {
            return response()->json(['status' => 'error', 'message' => 'Suscripción no encontrada'], 200);
        }

        $suscripcion->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Suscripción eliminada',
        ], 200);
    }
}
