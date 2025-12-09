<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\Sucursal;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Database\Seeders\RolesSeeder;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

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
            'password'              => ['required', 'confirmed', Rules\Password::defaults()],
            // Empresa
            'empresa_nombre'        => ['required', 'string', 'max:255'],
            'empresa_nit'           => ['nullable', 'string', 'max:50'],
            'empresa_telefono'      => ['nullable', 'string', 'max:50'],
            'empresa_correo'        => ['nullable', 'email', 'max:255'],
            'empresa_direccion'     => ['nullable', 'string', 'max:255'],
        ]);

        // 2) Sembrar roles y permisos necesarios antes de asignar roles
        $this->seedRolesAndPermissions();

        // 3) Transaccion: crear usuario, empresa, sucursal central y almacen central
        DB::beginTransaction();

        try {
            // 3.1 Crear usuario
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
            ]);

            // 3.2 Crear empresa
            $empresa = Empresa::create([
                'nombre'    => $request->empresa_nombre,
                'telefono'  => $request->empresa_telefono,
                'correo'    => $request->empresa_correo ?: $request->email,
                'direccion' => $request->empresa_direccion,
                'nit'       => $request->empresa_nit,
            ]);

            // 3.3 Cliente General por defecto
            Cliente::create([
                'nombre'     => 'Cliente General',
                'id_empresa' => $empresa->id,
            ]);

            // 3.4 Vincular empresa al usuario
            $user->id_empresa = $empresa->id;
            $user->save();

            // 3.5 Crear Sucursal Central
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

            // Crear o obtener el rol 'Administrador'
            $role = Role::firstOrCreate(['name' => 'Administrador']);

            // Asignar el rol de administrador al usuario
            $user->assignRole($role);

            DB::commit();

            event(new Registered($user));
            Auth::login($user);

            return redirect('/inicio');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withErrors(['register' => 'No se pudo completar el registro: ' . $e->getMessage()])
                ->withInput();
        }
    }

    private function seedRolesAndPermissions(): void
    {
        // Uso del contenedor para que el seeder pueda resolver sus dependencias
        app(RolesSeeder::class)->run();
    }
}
