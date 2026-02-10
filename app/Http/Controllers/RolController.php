<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    private function resolveEmpresaId(Request $request): int
    {
        return (int) ($request->input('empresa_id') ?? Auth::user()?->id_empresa);
    }

    public function index()
    {
        $empresaId = $this->resolveEmpresaId(request());

        $roles = DB::table('roles')
            ->where('empresa_id', $empresaId)
            ->orderBy('nombre')
            ->get()
            ->map(function ($role) use ($empresaId) {
                $users = DB::table('user_role')
                    ->join('users', 'user_role.user_id', '=', 'users.id')
                    ->where('user_role.empresa_id', $empresaId)
                    ->where('user_role.role_id', $role->id)
                    ->select('users.id', 'users.name', 'users.foto')
                    ->get();
                $role->users = $users;
                return $role;
            });

        $pantallas = DB::table('app_pantallas as p')
            ->leftJoin('app_modulos as m', 'p.modulo_id', '=', 'm.id')
            ->select('p.*', 'm.nombre as modulo_nombre')
            ->where('p.estado', 1)
            ->orderBy('m.orden')
            ->orderBy('p.orden')
            ->get();

        $rolePantallas = DB::table('role_pantalla')
            ->where('empresa_id', $empresaId)
            ->get()
            ->groupBy('role_id')
            ->map(fn ($rows) => $rows->pluck('pantalla_id'));

        return view('rol.rol', compact('roles', 'pantallas', 'rolePantallas'));
    }

    public function store(Request $request)
    {
        $empresaId = $this->resolveEmpresaId($request);
        $request->validate([
            'name' => 'required|unique:roles,nombre,NULL,id,empresa_id,' . $empresaId,
            'pantallas' => 'required|array',
            'empresa_id' => 'nullable|integer'
        ]);

        $roleId = DB::table('roles')->insertGetId([
            'empresa_id' => $empresaId,
            'nombre' => $request->name,
            'estado' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $pantallaIds = DB::table('app_pantallas')
            ->whereIn('id', $request->pantallas ?? [])
            ->pluck('id');

        $rows = $pantallaIds->map(fn ($pid) => [
            'empresa_id' => $empresaId,
            'role_id' => $roleId,
            'pantalla_id' => $pid,
        ])->all();

        if (!empty($rows)) {
            DB::table('role_pantalla')->insert($rows);
        }

        return redirect()->route('rol.index')->with('success', 'Rol creado correctamente');
    }

    public function update(Request $request, $role)
    {
        $empresaId = $this->resolveEmpresaId($request);
        $roleRow = DB::table('roles')->where('id', $role)->first();
        if (! $roleRow || (int) $roleRow->empresa_id !== $empresaId) {
            abort(403, 'No autorizado para modificar este rol');
        }

        $request->validate([
            'name' => 'required|unique:roles,nombre,' . $role . ',id,empresa_id,' . $empresaId,
            'pantallas' => 'required|array',
            'empresa_id' => 'nullable|integer'
        ]);

        DB::table('roles')
            ->where('id', $role)
            ->update(['nombre' => $request->name, 'updated_at' => now()]);

        DB::table('role_pantalla')
            ->where('empresa_id', $empresaId)
            ->where('role_id', $role)
            ->delete();

        $pantallaIds = DB::table('app_pantallas')
            ->whereIn('id', $request->pantallas ?? [])
            ->pluck('id');

        $rows = $pantallaIds->map(fn ($pid) => [
            'empresa_id' => $empresaId,
            'role_id' => $role,
            'pantalla_id' => $pid,
        ])->all();

        if (!empty($rows)) {
            DB::table('role_pantalla')->insert($rows);
        }

        return redirect()->route('rol.index')->with('success', 'Rol actualizado correctamente');
    }

    public function destroy($role)
    {
        $empresaId = $this->resolveEmpresaId(request());
        $roleRow = DB::table('roles')->where('id', $role)->first();
        if (! $roleRow || (int) $roleRow->empresa_id !== $empresaId) {
            abort(403, 'No autorizado para eliminar este rol');
        }

        if ($roleRow->nombre === 'Administrador') {
            return redirect()->route('rol.index')->with('error', 'No puedes eliminar el rol Administrador');
        }

        DB::table('roles')->where('id', $role)->delete();
        return redirect()->route('rol.index')->with('success', 'Rol eliminado correctamente');
    }
    public function indexpermisos()
    {
        return redirect()->route('permisos.pantallas');
    }
}
