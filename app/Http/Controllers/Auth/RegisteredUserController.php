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
                'nombres'    => 'Cliente General',
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

            // 2.5 Crear roles base y asignar rol admin al usuario en esta empresa
            $adminRoleId = $this->seedRolesAndPermissions($empresa->id);

            DB::table('user_role')->updateOrInsert(
                ['empresa_id' => $empresa->id, 'user_id' => $user->id, 'role_id' => $adminRoleId],
                ['empresa_id' => $empresa->id, 'user_id' => $user->id, 'role_id' => $adminRoleId]
            );

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

    private function seedRolesAndPermissions(int $empresaId): int
    {
        $adminId = DB::table('roles')->updateOrInsert(
            ['empresa_id' => $empresaId, 'nombre' => 'Administrador'],
            ['empresa_id' => $empresaId, 'nombre' => 'Administrador', 'estado' => 1, 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('roles')->updateOrInsert(
            ['empresa_id' => $empresaId, 'nombre' => 'Recepcionista'],
            ['empresa_id' => $empresaId, 'nombre' => 'Recepcionista', 'estado' => 1, 'updated_at' => now(), 'created_at' => now()]
        );

        $adminRoleId = DB::table('roles')
            ->where('empresa_id', $empresaId)
            ->where('nombre', 'Administrador')
            ->value('id');

        $pantallas = DB::table('app_pantallas')
            ->where('estado', 1)
            ->pluck('id');

        foreach ($pantallas as $pantallaId) {
            DB::table('role_pantalla')->updateOrInsert(
                ['empresa_id' => $empresaId, 'role_id' => $adminRoleId, 'pantalla_id' => $pantallaId],
                ['empresa_id' => $empresaId, 'role_id' => $adminRoleId, 'pantalla_id' => $pantallaId]
            );
        }

        return (int) $adminRoleId;
    }
}
