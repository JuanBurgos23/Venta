<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardControoler;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware('auth')->get('/routes-list', function () {
    $routes = collect(Route::getRoutes())
        ->filter(function ($route) {
            $name = $route->getName();

            return $route->methods()[0] === 'GET' // solo GET
                && empty($route->parameterNames()) // sin parámetros
                && $name !== null                  // con nombre
                && (
                    $name === 'Inicio'             // excepción dashboard
                    || in_array($name, ['Cliente', 'Empresa', 'Perfil']) // rutas sin .index
                    || str_ends_with($name, '.index') // rutas index
                );
        })
        ->map(function ($route) {
            $name = $route->getName();

            // Categoría dinámica
            $category = 'Otras';
            if ($name === 'Inicio') {
                $category = 'Dashboard';
            } elseif (in_array($name, ['Cliente', 'Empresa', 'Perfil'])) {
                $category = $name; // Usamos el nombre directo
            } elseif (str_contains($name, '.')) {
                $category = ucfirst(strtok($name, '.')); // Ej: Ventas.index -> Ventas
            }

            return [
                'uri' => $route->uri(),
                'name' => $name,
                'url' => route($name),
                'category' => $category,
            ];
        })
        ->values();

    return response()->json($routes);
})->name('routes.list');


//dashboard
Route::get('/inicio', [DashboardControoler::class, 'index'])->name('Inicio')->middleware(['auth', 'verified']);

//cliente
Route::get('/cliente', [ClienteController::class, 'index'])->name('Cliente');
Route::get('clientes/fetch', [ClienteController::class, 'fetch'])->name('clientes.fetch');
Route::post('/clientes/store', [ClienteController::class, 'store'])->name('clientes.store');
Route::put('clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
Route::put('/clientes/{id}/delete', [ClienteController::class, 'marcarBorrado'])->name('clientes.borrar');

//empresa
Route::get('/empresa', [EmpresaController::class, 'index'])->name('Empresa');
Route::get('empresa/fetch', [EmpresaController::class, 'fetch'])->name('empresa.fetch');
Route::post('/empresa/store', [EmpresaController::class, 'store'])->name('empresa.store');
Route::put('empresa/{id}', [EmpresaController::class, 'update'])->name('empresa.update');
Route::get('/empresa/{id}/edit', [EmpresaController::class, 'edit'])->name('empresa.edit');

//perfil
Route::get('/perfil', [PerfilController::class, 'index'])->name('Perfil');
Route::patch('/profile/update', [PerfilController::class, 'update'])->name('profile.update');
Route::patch('/profile/password', [PerfilController::class, 'updatePassword'])->name('profile.password');
Route::delete('/user/avatar/reset', [PerfilController::class, 'resetAvatar'])
    ->name('user.resetAvatar')
    ->middleware('auth');



//Crear Usuario
Route::get('/user', [UsuarioController::class, 'index'])->name('Crear Usuario')->middleware(['auth', 'verified']);
Route::get('/usuarios/lista', [UsuarioController::class, 'getUsers'])->name('usuarios.lista');
Route::post('/usuarios/store', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');


//Crear Rol y Permisos
Route::get('/rol', [RolController::class, 'index'])->name('rol.index');
Route::post('/roles', [RolController::class, 'store'])->name('roles.store');
Route::put('/roles/{role}', [RolController::class, 'update'])->name('roles.update');
Route::delete('/roles/{role}', [RolController::class, 'destroy'])->name('roles.destroy');

require __DIR__ . '/auth.php';
