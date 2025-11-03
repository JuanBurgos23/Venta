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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // 1) Validación usuario + empresa
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

        // 2) Transacción: crear usuario, empresa, sucursal central y almacén central
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
                // 'logo'   => null,
                // 'qr'     => null,
            ]);

            // 2.3 Cliente General por defecto
            Cliente::create([
                'nombre'     => 'Cliente General',
                'id_empresa' => $empresa->id,
            ]);

            // 2.4 Vincular empresa al usuario
            $user->id_empresa = $empresa->id;
            $user->save();

            // 2.5 Crear Sucursal Central
            $sucursal = Sucursal::create([
                'empresa_id'  => $empresa->id,
                'nombre'      => 'Sucursal Central',
                'telefono'    => $request->empresa_telefono,
                'correo'      => $request->empresa_correo ?: $request->email,
                'direccion'   => $request->empresa_direccion,
                'ciudad'      => null,
                'departamento'=> null,
                'lat'         => null,
                'lng'         => null,
                'estado'      => 1,
            ]);

            // 2.6 Crear Almacén Central asociado a la sucursal
            $almacen = Almacen::create([
                'sucursal_id' => $sucursal->id,
                'nombre'      => 'Almacén Central',
                'estado'      => 1,
            ]);

            DB::commit();

            event(new Registered($user));
            Auth::login($user);

            return redirect()->intended(route('dashboard', absolute: false));
        } catch (\Throwable $e) {
            DB::rollBack();

            // Puedes redirigir de vuelta con errores o responder JSON si es una SPA
            return back()
                ->withErrors(['register' => 'No se pudo completar el registro: '.$e->getMessage()])
                ->withInput();
        }
    }
}
