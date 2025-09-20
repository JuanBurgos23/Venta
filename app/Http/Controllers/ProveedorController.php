<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    public function index()
    {
        // Pon aquí la vista que usarás para listar/crear/editar proveedores
        return view('compra.compra');
    }

    // GET /proveedores/fetch?search=&page=1
    public function fetch(Request $request)
    {
        $search  = (string) $request->input('search', '');
        $perPage = (int) $request->input('per_page', 10);
        $page    = (int) $request->input('page', 1);

        $user = Auth::user();
        $empresaId = $user->id_empresa ?? 0;

        $query = Proveedor::with('empresa')
            ->where('id_empresa', $empresaId)
            ->where('estado', '!=', 0); // 1=activo, 0=inactivo/borrado

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('paterno', 'like', "%{$search}%")
                  ->orWhere('materno', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%")
                  ->orWhere('ci', 'like', "%{$search}%")
                  ->orWhere('correo', 'like', "%{$search}%");
            });
        }

        $proveedores = $query->orderByDesc('id')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json($proveedores);
    }

    // POST /proveedores
    public function store(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa;

        if (!$empresaId) {
            return response()->json([
                'status'  => 'error',
                'message' => 'No se encontró la empresa asociada al usuario'
            ], 200);
        }

        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:255',
            'paterno'  => 'nullable|string|max:255',
            'materno'  => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:255',
            'ci'       => 'nullable|string|max:20|unique:proveedor,ci', // si quieres unicidad por empresa, quítalo o arma regla custom
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 200);
        }

        $proveedor = Proveedor::create([
            'nombre'     => $request->nombre,
            'paterno'    => $request->paterno,
            'materno'    => $request->materno,
            'telefono'   => $request->telefono,
            'correo'     => $request->correo,
            'ci'         => $request->ci,
            'estado'     => 1,             // entero, no string
            'id_empresa' => $empresaId,
        ]);

        return response()->json([
            'status'    => 'success',
            'message'   => 'Proveedor registrado correctamente',
            'proveedor' => $proveedor
        ], 200);
    }

    // PUT /proveedores/{id}
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa ?? 0;

        $proveedor = Proveedor::where('id_empresa', $empresaId)->find($id);
        if (!$proveedor) {
            return response()->json(['status' => 'error', 'message' => 'Proveedor no encontrado'], 200);
        }

        $validator = Validator::make($request->all(), [
            'nombre'   => 'required|string|max:255',
            'paterno'  => 'nullable|string|max:255',
            'materno'  => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:255',
            'ci'       => 'nullable|string|max:20|unique:proveedor,ci,' . $id,
            'estado'   => 'nullable|integer|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 200);
        }

        // Actualiza campos básicos
        $proveedor->nombre   = $request->nombre;
        $proveedor->paterno  = $request->paterno;
        $proveedor->materno  = $request->materno;
        $proveedor->telefono = $request->telefono;
        $proveedor->correo   = $request->correo;
        $proveedor->ci       = $request->ci;

        // Si te permiten cambiar estado desde el form
        if ($request->filled('estado')) {
            $proveedor->estado = (int) $request->estado;
        }

        $proveedor->save();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Proveedor actualizado correctamente',
            'proveedor' => $proveedor
        ], 200);
    }

    // DELETE lógico /proveedores/{id}  (o PUT /proveedores/{id}/delete)
    public function marcarBorrado(Request $request, $id)
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa ?? 0;

        $proveedor = Proveedor::where('id_empresa', $empresaId)->find($id);
        if (!$proveedor) {
            return response()->json(['status' => 'error', 'message' => 'Proveedor no encontrado'], 200);
        }

        $proveedor->estado = 0; // inactivo/borrado lógico
        $proveedor->save();

        return response()->json(['status' => 'success', 'message' => 'Proveedor marcado como inactivo'], 200);
    }
}
