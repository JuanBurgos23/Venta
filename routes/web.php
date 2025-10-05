<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DashboardControoler;
use App\Http\Controllers\ProductoAlmacenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\VentaController;

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
                $category = 'Inicio';
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
Route::get('/empresa/fetch', [EmpresaController::class, 'fetch'])->name('empresa.fetch');
Route::post('/empresa/store', [EmpresaController::class, 'store'])->name('empresa.store');
Route::put('/empresa/{id}', [EmpresaController::class, 'update'])->name('empresa.update');
Route::get('/empresa/{id}/edit', [EmpresaController::class, 'edit'])->name('empresa.edit');
Route::get('/empresa/{id}/qr', [EmpresaController::class, 'getQr'])->name('empresa.qr');

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


//sucursal
Route::get('/sucursal', [SucursalController::class, 'index'])->name('sucursal.index');
Route::get('sucursal/fetch', [SucursalController::class, 'fetch'])->name('sucursal.fetch');
Route::post('/sucursal/store', [SucursalController::class, 'store'])->name('sucursal.store');
Route::put('sucursal/{id}', [SucursalController::class, 'update'])->name('sucursal.update');
Route::get('/sucursal/{id}/edit', [SucursalController::class, 'edit'])->name('sucursal.edit');
//almacen
Route::get('/almacen', [AlmacenController::class, 'index'])->name('almacen.index');
Route::get('/almacenes/fetch', [AlmacenController::class, 'fetch'])->name('almacen.fetch');
Route::post('/almacen/store', [AlmacenController::class, 'store'])->name('almacen.store');
Route::put('/almacen/{id}', [AlmacenController::class, 'update'])->name('almacen.update');
Route::get('/almacen/{id}/edit', [AlmacenController::class, 'edit'])->name('almacen.edit');

//proveedor
Route::get('/proveedores',        [ProveedorController::class, 'index'])->name('proveedores.index');
Route::get('/proveedores/fetch',  [ProveedorController::class, 'fetch'])->name('proveedores.fetch');
Route::post('/proveedores',       [ProveedorController::class, 'store'])->name('proveedores.store');
Route::put('/proveedores/{id}',   [ProveedorController::class, 'update'])->name('proveedores.update');
Route::post('/proveedores/{id}/delete', [ProveedorController::class, 'marcarBorrado'])->name('proveedores.delete');

//compra

// CRUD (listado)
Route::get('/compras', [CompraController::class, 'crud'])->name('compras.index');

// API tabla y detalles
Route::get('/api/compras', [CompraController::class, 'apiIndex'])->name('compras.api.index');
Route::get('/api/compras/{id}/detalles', [CompraController::class, 'apiDetalles'])->name('compras.api.detalles');

// Formulario nueva compra
Route::get('/compras/create', [CompraController::class, 'create'])->name('compras.create');
Route::post('/compras', [CompraController::class, 'store'])->name('compras.store');

// Acciones
Route::get('/compras/{id}', [CompraController::class, 'show'])->name('compras.show');      // si lo usas
Route::get('/compras/{id}/edit', [CompraController::class, 'edit'])->name('compras.edit'); // si lo usas
Route::delete('/compras/{id}', [CompraController::class, 'destroy'])->name('compras.destroy');



Route::get('/proveedores/list', [CompraController::class, 'ProveedorSearch'])->name('proveedores.search');
Route::post('/proveedores/store', [CompraController::class, 'ProveedorStore'])->name('proveedores.store');
Route::get('almacenes/list', [CompraController::class, 'AlmacenList'])->name('almacenes.list');
Route::post('/almacenes/store', [CompraController::class, 'AlmacenStore'])->name('almacenes.store');
Route::get('/productos/list', [CompraController::class, 'ProductoList'])->name('productos.list');
Route::post('/compras/store', [CompraController::class, 'store'])->name('compras.store');


//unidad de medida
Route::get('/unidad-medida',            [UnidadMedidaController::class, 'index'])->name('unidad_medida.index');
Route::get('/unidad-medida/fetch',      [UnidadMedidaController::class, 'fetch'])->name('unidad_medida.fetch');
Route::get('/unidad-medida/{id}/edit',  [UnidadMedidaController::class, 'edit'])->name('unidad_medida.edit');
Route::post('/unidad-medida',           [UnidadMedidaController::class, 'store'])->name('unidad_medida.store');
Route::put('/unidad-medida/{id}',       [UnidadMedidaController::class, 'update'])->name('unidad_medida.update');
Route::delete('/unidad-medida/{id}',    [UnidadMedidaController::class, 'destroy'])->name('unidad_medida.destroy');

// Categorías
Route::get('/categorias',              [CategoriaController::class, 'index'])->name('categorias.index');
Route::get('/categorias/fetch',        [CategoriaController::class, 'fetch'])->name('categorias.fetch');
Route::get('/categorias/{id}/edit',    [CategoriaController::class, 'edit'])->name('categorias.edit');
Route::post('/categorias',             [CategoriaController::class, 'store'])->name('categorias.store');
Route::put('/categorias/{id}',         [CategoriaController::class, 'update'])->name('categorias.update');
Route::delete('/categorias/{id}',      [CategoriaController::class, 'destroy'])->name('categorias.destroy');

//Productos
Route::get('/producto', [ProductoController::class, 'index'])->name('productos.index');
Route::post('/productos/store', [ProductoController::class, 'store'])->name('productos.store');
Route::get('/api/categorias', [ProductoController::class, 'categorias']);
Route::get('/api/subcategorias/{categoria}', [ProductoController::class, 'subcategorias']);
Route::get('/api/tipos-producto', [ProductoController::class, 'tiposProducto']);
Route::get('/api/unidades-medida', [ProductoController::class, 'unidadesMedida']);
Route::get('/api/tipos-precio', [ProductoController::class, 'tiposPrecio']);

Route::get('/producto/importar', function () {
    return view('producto.importar'); // nombre de tu blade
})->name('producto.importar');

Route::post('/productos/importar', [ProductoController::class, 'importarMasivo'])
    ->name('productos.importar.store');

//inventario
Route::get('/inventario/reporte', [ProductoAlmacenController::class, 'reporteInventario'])
    ->name('inventario.reporte');
Route::get('/inventario/producto/{productoId}/lotes', [ProductoAlmacenController::class, 'lotesPorProducto'])
    ->name('inventario.lotes');
// Productos (solo lectura para búsqueda)
Route::get('/productos', [ProductoController::class, 'fetch']);
Route::get('/productos/{id}', [ProductoController::class, 'show']);   // obtener producto por ID
Route::post('/productos/update/{id}', [ProductoController::class, 'update']); // actualizar producto
Route::get('/categorias/list', [ProductoController::class, 'Categorialist']);
Route::get('/subcategorias/byCategoria/{categoriaId}', [ProductoController::class, 'byCategoria']);
Route::post('/productos/delete/{id}', [ProductoController::class, 'delete'])->name('productos.delete');

// Subcategorías (usadas desde la misma pantalla)
Route::get('/subcategorias/fetch',     [SubcategoriaController::class, 'fetch'])->name('subcategorias.fetch'); // ?categoria_id=...
Route::get('/subcategorias/{id}/edit', [SubcategoriaController::class, 'edit'])->name('subcategorias.edit');
Route::post('/subcategorias',          [SubcategoriaController::class, 'store'])->name('subcategorias.store');
Route::put('/subcategorias/{id}',      [SubcategoriaController::class, 'update'])->name('subcategorias.update');
Route::delete('/subcategorias/{id}',   [SubcategoriaController::class, 'destroy'])->name('subcategorias.destroy');


//venta
Route::get('/venta', [VentaController::class, 'index'])->name('ventas.index');
Route::get('/producto/venta', [VentaController::class, 'fetchProducto'])->name('productos.fetch');
Route::get('/venta/almacenes', [VentaController::class, 'fetchAlmacenes']);
Route::get('/producto/search', [VentaController::class, 'BuscarProducto'])->name('productos.search');
Route::get('/categorias/fetch-json', [VentaController::class, 'fetchJson'])->name('categorias.fetchJson');
Route::get('/clientes/fetch-json', [VentaController::class, 'fetchClientes'])->name('clientes.fetch-json');
Route::get('/buscar-producto/{codigo}', [VentaController::class, 'buscarPorCodigo'])
    ->name('productos.buscar');
Route::post('/clientes/store', [VentaController::class, 'ClienteStore'])->name('clientes.store');
Route::post('/venta/store', [VentaController::class, 'store'])->name('venta.store');




require __DIR__ . '/auth.php';
