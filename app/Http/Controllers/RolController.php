<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{
    private function resolveEmpresaId(Request $request): int
    {
        return (int) ($request->input('empresa_id') ?? Auth::user()?->id_empresa);
    }

    public function index()
    {
        $empresaId = $this->resolveEmpresaId(request());

        $roles = Role::with('permissions', 'users')
            ->where('empresa_id', $empresaId)
            ->get();

        $permissions = Permission::where('empresa_id', $empresaId)->get();

        return view('rol.rol', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $empresaId = $this->resolveEmpresaId($request);
        $request->validate([
            'name' => 'required|unique:roles,name,NULL,id,empresa_id,' . $empresaId,
            'permissions' => 'required|array',
            'empresa_id' => 'nullable|integer'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'empresa_id' => $empresaId,
            'guard_name' => $request->input('guard_name', 'web'),
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('rol.index')->with('success', 'Rol creado correctamente');
    }

    public function update(Request $request, Role $role)
    {
        $empresaId = $this->resolveEmpresaId($request);
        if ((int) $role->empresa_id !== $empresaId) {
            abort(403, 'No autorizado para modificar este rol');
        }

        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . ',id,empresa_id,' . $empresaId,
            'permissions' => 'required|array',
            'empresa_id' => 'nullable|integer'
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('rol.index')->with('success', 'Rol actualizado correctamente');
    }

    public function destroy(Role $role)
    {
        $empresaId = $this->resolveEmpresaId(request());
        if ((int) $role->empresa_id !== $empresaId) {
            abort(403, 'No autorizado para eliminar este rol');
        }

        if ($role->name === 'Administrador') {
            return redirect()->route('rol.index')->with('error', 'No puedes eliminar el rol Administrador');
        }

        $role->delete();
        return redirect()->route('rol.index')->with('success', 'Rol eliminado correctamente');
    }
}
