<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('Cliente')) {
            return response()->view('errors.forbidden', [], 403);
        }
        return view('cliente.cliente');
    }

    // Endpoint JSON para fetch
    public function fetch(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = 10; // registros por página
        $page = $request->input('page', 1);

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

        $query = Cliente::with('empresa')
            ->where('estado', '!=', 'Borrado') // <-- filtrar clientes borrados
            ->where('id_empresa', $empresaId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                    ->orWhere('paterno', 'like', "%$search%")
                    ->orWhere('materno', 'like', "%$search%")
                    ->orWhere('telefono', 'like', "%$search%")
                    ->orWhere('correo', 'like', "%$search%")
                    ->orWhere('ci', 'like', "%$search%");
            });
        }

        $clientes = $query->orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($clientes);
    }

    public function store(Request $request)
    {
        // Validar datos
        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:255',
            'paterno'  => 'required|string|max:255',
            'materno'  => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:255',
            'ci'       => 'nullable|string|max:20|unique:cliente,ci',
        ]);

        if ($validator->fails()) {
            // IMPORTANTE: devolver 200 con status error en JSON
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        $user = Auth::user();

        // Sacamos la empresa desde el usuario
        $empresaId = $user->id_empresa;

        if (!$empresaId) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No se encontró la empresa asociada al usuario'
            ], 200);
        }

        // Crear cliente
        $cliente = Cliente::create([
            'nombre'     => $request->nombre,
            'paterno'    => $request->paterno,
            'materno'    => $request->materno,
            'telefono'   => $request->telefono,
            'correo'     => $request->correo,
            'ci'         => $request->ci,
            'estado'     => 'Activo',
            'id_empresa' => $empresaId,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Cliente registrado correctamente',
            'cliente' => $cliente
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $cliente = Cliente::where('id_empresa', $user->id_empresa ?? 0)->find($id);
        if (!$cliente) {
            return response()->json(['status' => 'error', 'message' => 'Cliente no encontrado'], 200);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo' => 'nullable|email|max:255',
            'ci' => 'nullable|string|max:20|unique:cliente,ci,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 200);
        }

        $cliente->update($request->all());

        return response()->json(['status' => 'success', 'message' => 'Cliente actualizado correctamente', 'cliente' => $cliente], 200);
    }

    public function marcarBorrado(Request $request, $id)
    {
        $user = Auth::user();
        $cliente = Cliente::where('id_empresa', $user->id_empresa ?? 0)->find($id);
        if (!$cliente) {
            return response()->json(['status' => 'error', 'message' => 'Cliente no encontrado'], 200);
        }

        $cliente->estado = $request->estado ?? 'Borrado';
        $cliente->save();

        return response()->json(['status' => 'success', 'message' => 'Cliente marcado como Borrado'], 200);
    }
}
