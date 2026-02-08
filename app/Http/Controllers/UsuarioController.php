<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = Role::where('empresa_id', $user->id_empresa ?? 0)->get();
        return view('usuario.usuario', compact('roles'));
    }

    // Endpoint JSON para DataTable
    public function getUsers(Request $request)
    {
        $user = Auth::user();

        // Restringimos siempre a la empresa del usuario autenticado
        $query = User::with('roles')
            ->where('estado', '!=', 'Eliminado')
            ->where('id_empresa', $user->id_empresa ?? 0);

        // Busqueda general (sin tocar tu logica)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        // Filtro por rol (sin tocar tu logica)
        if ($request->has('role') && $request->role != '') {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->get();

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $authUser = Auth::user();

        // Determinar empresa
        $idEmpresa = $authUser->id_empresa;
        if (!$idEmpresa) {
            return redirect()
                ->back()
                ->with('error', 'El usuario autenticado no tiene empresa asignada.')
                ->withInput();
        }

        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_empresa' => $idEmpresa,
        ]);

        // Asignar rol
        $user->assignRole($request->role);

        return redirect()
            ->route('Crear Usuario') // ruta principal de usuarios
            ->with('success', 'Usuario creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        $authUser = Auth::user();
        $user = User::findOrFail($id);

        // Seguridad: si NO es Administrador, solo puede editar usuarios de su empresa
        if (!$authUser->hasRole('Administrador') && $authUser->id_empresa !== $user->id_empresa) {
            return response()->json([
                'status' => 'error',
                'message' => 'No autorizado para editar este usuario'
            ], 200);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Actualizamos roles (reemplaza roles previos por el nuevo)
        $user->syncRoles([$request->role]);

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario actualizado correctamente',
            'user' => $user->load('roles')
        ], 200);
    }

    public function destroy($id)
    {
        $authUser = Auth::user();
        $user = User::findOrFail($id);

        // Seguridad: si NO es Administrador, solo puede eliminar usuarios de su misma empresa
        if (!$authUser->hasRole('Administrador') && $authUser->id_empresa !== $user->id_empresa) {
            return response()->json([
                'status' => 'error',
                'message' => 'No autorizado para eliminar este usuario'
            ], 200);
        }

        // Cambiar estado a Eliminado
        $user->estado = 'Eliminado';
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario marcado como eliminado correctamente'
        ], 200);
    }
}
