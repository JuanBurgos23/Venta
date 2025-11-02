<?php

namespace App\Http\Controllers;

use App\Models\TipoIngresoEgreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IngresoEgresoController extends Controller
{
    public function index()
    {
        return view('IngresoEgreso.tipoIngresoEgreso');
    }
    // 📥 Listado dinámico (con búsqueda y empresa)
    public function fetch(Request $request)
    {
        $empresaId = auth()->user()->id_empresa;
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);

        $query = TipoIngresoEgreso::where('empresa_id', $empresaId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%")
                    ->orWhere('tipo', 'like', "%{$search}%")
                    ->orWhere('estado', 'like', "%{$search}%");
            });
        }

        $data = $query->orderByDesc('id')->paginate($perPage);

        return response()->json([
            'data' => $data->items(),
            'total' => $data->total(),
            'per_page' => $data->perPage(),
            'current_page' => $data->currentPage(),
        ]);
    }

    // 📄 Obtener un registro específico
    public function show($id)
    {
        $empresaId = auth()->user()->id_empresa;
        $item = TipoIngresoEgreso::where('empresa_id', $empresaId)->find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Registro no encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $item]);
    }

    // ➕ Crear un nuevo registro
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:ingreso,egreso',
            'descripcion' => 'nullable|string',
        ]);

        $empresaId = auth()->user()->id_empresa;

        $item = TipoIngresoEgreso::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'estado' => 1,
            'empresa_id' => $empresaId,
        ]);

        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $empresaId = auth()->user()->id_empresa;
        $item = TipoIngresoEgreso::where('empresa_id', $empresaId)->find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Registro no encontrado'], 404);
        }

        // Actualizar directamente sin validación
        $item->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
        ]);

        return response()->json(['success' => true]);
    }
}
