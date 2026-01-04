<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Sucursal;
use Illuminate\View\View;
use App\Models\Suscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\EmpresaSuscripcion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        // 1) Validacion usuario + empresa
        $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'              => ['required'],
            // Empresa
            'empresa_nombre'        => ['required', 'string', 'max:255'],
            'empresa_nit'           => ['nullable', 'string', 'max:50'],
            'empresa_telefono'      => ['nullable', 'string', 'max:50'],
            'empresa_correo'        => ['nullable', 'email', 'max:255'],
            'empresa_direccion'     => ['nullable', 'string', 'max:255'],
        ]);

        // 2) Transaccion: crear usuario, empresa, sucursal central y almacen central
        DB::beginTransaction();

        try {
            // 2.1 Crear usuario
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // 2.2 Crear empresa
            $empresa = Empresa::create([
                'nombre'    => $request->empresa_nombre,
                'telefono'  => $request->empresa_telefono,
                'correo'    => $request->empresa_correo ?: $request->email,
                'direccion' => $request->empresa_direccion,
                'nit'       => $request->empresa_nit,
            ]);

            Cliente::create([
                'nombre'     => 'Cliente General',
                'id_empresa' => $empresa->id,
            ]);

            $user->id_empresa = $empresa->id;
            $user->save();
            $sucursal = Sucursal::create([
                'empresa_id'   => $empresa->id,
                'nombre'       => 'Sucursal Central',
                'telefono'     => $request->empresa_telefono,
                'correo'       => $request->empresa_correo ?: $request->email,
                'direccion'    => $request->empresa_direccion,
                'ciudad'       => null,
                'departamento' => null,
                'lat'          => null,
                'lng'          => null,
                'estado'       => 1,
            ]);

            // 3.6 Crear Almacen Central asociado a la sucursal
            $almacen = Almacen::create([
                'sucursal_id' => $sucursal->id,
                'nombre'      => 'Almacen Central',
                'estado'      => 1,
            ]);

            // 2.4 Crear o reutilizar suscripción base (id=1 Plan Gratis)
            $suscripcion = Suscripcion::firstOrCreate(
                ['id' => 1],
                ['nombre' => 'Plan Gratis', 'descripcion' => 'Plan gratuito por defecto', 'estado' => 1]
            );

            EmpresaSuscripcion::create([
                'empresa_id'      => $empresa->id,
                'suscripcion_id'  => $suscripcion->id,
                'fecha_inicio'    => now(),
                'fecha_fin'       => now()->addDays(5),
                'estado'          => 1,
            ]);

            // 2.5 Sembrar roles/permisos base para la nueva empresa y obtener rol admin
            $adminRole = $this->seedRolesAndPermissions($empresa->id);

            // Asignar el rol de administrador al usuario con pivot empresa_id
            $user->roles()->syncWithoutDetaching([
                $adminRole->id => ['empresa_id' => $empresa->id],
            ]);

            DB::commit();

            event(new Registered($user));
            Auth::login($user);

            return redirect('/inicio');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error en registro', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return back()
                ->withErrors(['register' => 'No se pudo completar el registro: ' . $e->getMessage()])
                ->withInput();
        }
    }

    private function seedRolesAndPermissions(int $empresaId): Role
    {
        $permissions = [
            // Ventas
            ['name' => 'ventas.ver', 'descripcion' => 'Permite ver las ventas'],
            ['name' => 'ventas.crear', 'descripcion' => 'Permite crear una venta'],
            ['name' => 'ventas.editar', 'descripcion' => 'Permite editar una venta'],
            ['name' => 'ventas.eliminar', 'descripcion' => 'Permite eliminar una venta'],
            // Compras
            ['name' => 'compras.ver', 'descripcion' => 'Permite ver las compras'],
            ['name' => 'compras.crear', 'descripcion' => 'Permite crear una compra'],
            ['name' => 'compras.editar', 'descripcion' => 'Permite editar una compra'],
            ['name' => 'compras.eliminar', 'descripcion' => 'Permite eliminar una compra'],
            // Inventario
            ['name' => 'inventario.ver', 'descripcion' => 'Permite ver el inventario'],
            ['name' => 'inventario.crear', 'descripcion' => 'Permite crear un producto en el inventario'],
            ['name' => 'inventario.editar', 'descripcion' => 'Permite editar un producto en el inventario'],
            ['name' => 'inventario.eliminar', 'descripcion' => 'Permite eliminar un producto en el inventario'],
            // Usuarios
            ['name' => 'usuarios.ver', 'descripcion' => 'Permite ver los usuarios'],
            ['name' => 'usuarios.crear', 'descripcion' => 'Permite crear un usuario'],
            ['name' => 'usuarios.editar', 'descripcion' => 'Permite editar un usuario'],
            ['name' => 'usuarios.eliminar', 'descripcion' => 'Permite eliminar un usuario'],
            // Clientes
            ['name' => 'Cliente', 'descripcion' => 'Permite gestionar clientes'],
            ['name' => 'clientes.store', 'descripcion' => 'Permite registrar clientes'],
            ['name' => 'clientes.update', 'descripcion' => 'Permite actualizar clientes'],
            ['name' => 'clientes.borrar', 'descripcion' => 'Permite eliminar clientes'],
        ];

        $permModels = collect($permissions)->map(function ($perm) use ($empresaId) {
            return Permission::firstOrCreate(
                ['empresa_id' => $empresaId, 'name' => $perm['name'], 'guard_name' => 'web'],
                ['descripcion' => $perm['descripcion']]
            );
        });

        $admin = Role::firstOrCreate(
            ['empresa_id' => $empresaId, 'name' => 'Administrador', 'guard_name' => 'web']
        );
        $recepcionista = Role::firstOrCreate(
            ['empresa_id' => $empresaId, 'name' => 'Recepcionista', 'guard_name' => 'web']
        );

        // Admin con todos los permisos, recepcionista con los mismos por defecto (ajusta si necesitas menos)
        $admin->permissions()->syncWithPivotValues(
            $permModels->pluck('id')->all(),
            ['empresa_id' => $empresaId]
        );
        $recepcionista->permissions()->syncWithPivotValues(
            $permModels->pluck('id')->all(),
            ['empresa_id' => $empresaId]
        );

        return $admin;
    }
}
