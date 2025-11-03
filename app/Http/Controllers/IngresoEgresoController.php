<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\IngresoEgreso;
use App\Models\Sucursal;
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

    public function registrarIngresoEgresoIndex()
    {
        $sucursales = Sucursal::all();
        $tipos = TipoIngresoEgreso::all();
        return view('IngresoEgreso.registrarIngresoEgreso', compact('tipos', 'sucursales'));
    }
    public function fetchIngresoEgreso(Request $request)
    {
        $query = IngresoEgreso::with(['usuario', 'tipoIngresoEgreso'])
            ->orderBy('fecha', 'desc');

        // 🔎 Buscador general
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('descripcion', 'LIKE', "%{$search}%")
                    ->orWhere('motivo', 'LIKE', "%{$search}%")
                    ->orWhere('monto', 'LIKE', "%{$search}%")
                    ->orWhereHas('usuario', function ($u) use ($search) {
                        $u->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('tipoIngresoEgreso', function ($t) use ($search) {
                        $t->where('nombre', 'LIKE', "%{$search}%");
                    });
            });
        }

        // 📅 Filtro por rango de fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha', [
                $request->fecha_inicio . ' 00:00:00',
                $request->fecha_fin . ' 23:59:59'
            ]);
        } elseif ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        } elseif ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        // 📄 Paginación (por defecto 10)
        $registros = $query->paginate(10);

        // 💾 Retorno JSON (para fetch)
        return response()->json([
            'data' => $registros->items(),
            'pagination' => [
                'total' => $registros->total(),
                'per_page' => $registros->perPage(),
                'current_page' => $registros->currentPage(),
                'last_page' => $registros->lastPage(),
            ],
        ]);
    }
    public function storeIngresoEgreso(Request $request)
    {
        $usuario = Auth::user();
        $empresaId = $usuario->id_empresa;

        // 🔹 Verificar si hay caja activa
        $cajaActiva = Caja::where('usuario_id', $usuario->id)
            ->where('empresa_id', $empresaId)
            ->where('estado', 1)
            ->first();

        if (!$cajaActiva) {
            return response()->json([
                'success' => false,
                'message' => 'No hay una caja abierta para registrar ingresos o egresos.'
            ], 403);
        }

        // 🔹 Validación
        $validator = Validator::make($request->all(), [
            'tipo_ingreso_egreso_id' => 'required|exists:tipo_ingreso_egreso,id',
            'motivo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // 🔹 Crear el registro
        $registro = IngresoEgreso::create([
            'usuario_id' => $usuario->id,
            'descripcion' => $request->descripcion,
            'fecha' => now(),
            'motivo' => $request->motivo,
            'tipo_ingreso_egreso_id' => $request->tipo_ingreso_egreso_id,
            'monto' => $request->monto,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registro creado correctamente',
            'registro' => $registro
        ]);
    }
    public function showIngresoEgreso($id)
    {
        $registro = IngresoEgreso::find($id);

        if (!$registro) {
            return response()->json(['success' => false], 404);
        }

        return response()->json([
            'success' => true,
            'registro' => $registro
        ]);
    }
    public function updateIngresoEgreso(Request $request, $id)
    {
        $registro = IngresoEgreso::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tipo_ingreso_egreso_id' => 'required|exists:tipo_ingreso_egreso,id',
            'motivo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'monto' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $registro->update($request->all());

        return response()->json(['success' => true, 'registro' => $registro]);
    }
}
