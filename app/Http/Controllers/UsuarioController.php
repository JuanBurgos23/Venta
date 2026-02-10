<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa ?? 0;
        $roles = DB::table('roles')
            ->where('empresa_id', $empresaId)
            ->orderBy('nombre')
            ->get();
        return view('usuario.usuario', compact('roles'));
    }

    // Endpoint JSON para DataTable
    public function getUsers(Request $request)
    {
        $user = Auth::user();
        $empresaId = $user->id_empresa ?? 0;

        // Restringimos siempre a la empresa del usuario autenticado
        $query = User::query()
            ->where('estado', '!=', 'Eliminado')
            ->where('id_empresa', $empresaId);

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
            $roleName = $request->role;
            $query->whereIn('id', function ($q) use ($empresaId, $roleName) {
                $q->select('ur.user_id')
                    ->from('user_role as ur')
                    ->join('roles as r', 'r.id', '=', 'ur.role_id')
                    ->where('ur.empresa_id', $empresaId)
                    ->where('r.nombre', $roleName);
            });
        }

        $users = $query->get()->map(function ($u) use ($empresaId) {
            $roles = DB::table('user_role as ur')
                ->join('roles as r', 'r.id', '=', 'ur.role_id')
                ->where('ur.empresa_id', $empresaId)
                ->where('ur.user_id', $u->id)
                ->select('r.id', 'r.nombre')
                ->get();
            $u->roles = $roles;
            return $u;
        });

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
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

        $roleId = DB::table('roles')
            ->where('empresa_id', $idEmpresa)
            ->where('nombre', $request->role)
            ->value('id');
        if (! $roleId) {
            return redirect()
                ->back()
                ->with('error', 'Rol inválido para esta empresa.')
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
        DB::table('user_role')->updateOrInsert(
            ['empresa_id' => $idEmpresa, 'user_id' => $user->id, 'role_id' => $roleId],
            ['empresa_id' => $idEmpresa, 'user_id' => $user->id, 'role_id' => $roleId]
        );

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
            'role' => 'required|string',
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
        if (!$authUser->hasRoleNombre('Administrador') && $authUser->id_empresa !== $user->id_empresa) {
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

        $roleId = DB::table('roles')
            ->where('empresa_id', $authUser->id_empresa)
            ->where('nombre', $request->role)
            ->value('id');
        if (! $roleId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rol inválido para esta empresa'
            ], 200);
        }

        DB::table('user_role')
            ->where('empresa_id', $authUser->id_empresa)
            ->where('user_id', $user->id)
            ->delete();

        DB::table('user_role')->insert([
            'empresa_id' => $authUser->id_empresa,
            'user_id' => $user->id,
            'role_id' => $roleId,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Usuario actualizado correctamente',
            'user' => $user
        ], 200);
    }

    public function destroy($id)
    {
        $authUser = Auth::user();
        $user = User::findOrFail($id);

        // Seguridad: si NO es Administrador, solo puede eliminar usuarios de su misma empresa
        if (!$authUser->hasRoleNombre('Administrador') && $authUser->id_empresa !== $user->id_empresa) {
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
