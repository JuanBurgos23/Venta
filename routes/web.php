<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FinanzasController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardControoler;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\SuscripcionController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\UnidadMedidaController;
use App\Http\Controllers\EmpresaConfigController;
use App\Http\Controllers\IngresoEgresoController;
use App\Http\Controllers\ImportProductosController;
use App\Http\Controllers\ProductoAlmacenController;
use App\Http\Controllers\InventarioReporteController;
use App\Http\Controllers\PermisosPantallasController;
use App\Http\Controllers\SuscripcionStatusController;
use App\Http\Controllers\EmpresaSuscripcionController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware('auth')->group(function () {
        Route::get('/producto/importar', function () {
            return view('producto.importar');
        })->name('producto.importar');
    
        Route::post('/productos/importar', [ImportProductosController::class, 'store'])
            ->name('productos.importar.store');
    });
    
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
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/diario', [DashboardControoler::class, 'diario']);
    Route::get('/dashboard/mensual', [DashboardControoler::class, 'mensual']);
    Route::get('/dashboard/categorias-mensual', [DashboardControoler::class, 'categoriasMensual']);
    Route::get('/dashboard/historico-12m', [DashboardControoler::class, 'historico12Meses']);
    Route::get('/dashboard/top-vendedores-mensual', [DashboardControoler::class, 'topVendedoresMensual']);
});


// admin dashboard (auth + verified)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/admin', 'admin.dashboard')->name('admin.dashboard');

    // Empresas para admin (fetch)
    Route::get('/admin/empresas/fetch', [EmpresaController::class, 'fetchgeneral'])->name('admin.empresas.fetch');

    // Suscripciones CRUD
    Route::get('/suscripciones/fetch', [SuscripcionController::class, 'fetch'])->name('suscripciones.fetch');
    Route::post('/suscripciones', [SuscripcionController::class, 'store'])->name('suscripciones.store');
    Route::put('/suscripciones/{id}', [SuscripcionController::class, 'update'])->name('suscripciones.update');
    Route::delete('/suscripciones/{id}', [SuscripcionController::class, 'destroy'])->name('suscripciones.destroy');

    // Asignación Empresa-Suscripción
    Route::get('/empresa-suscripciones/fetch', [EmpresaSuscripcionController::class, 'fetch'])->name('empresa_suscripcion.fetch');
    Route::post('/empresa-suscripciones', [EmpresaSuscripcionController::class, 'store'])->name('empresa_suscripcion.store');
    Route::put('/empresa-suscripciones/{id}', [EmpresaSuscripcionController::class, 'update'])->name('empresa_suscripcion.update');
    Route::delete('/empresa-suscripciones/{id}', [EmpresaSuscripcionController::class, 'destroy'])->name('empresa_suscripcion.destroy');
});

Route::middleware('auth')->get('/api/empresa/suscripcion/status',[SuscripcionStatusController::class, 'status']);


Route::middleware(['auth', 'suscripcion.vigente'])->group(function () {
    //cliente
    
    

});
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

        //Crear Rol y Permisos
    Route::get('/permisos', [RolController::class, 'indexpermisos'])->name('permisos.index');
    Route::post('/permisos', [RolController::class, 'store'])->name('permisos.store');
    Route::put('/permisos/{permiso}', [RolController::class, 'update'])->name('permisos.update');
    Route::delete('/permisos/{permiso}', [RolController::class, 'destroy'])->name('permisos.destroy');
    

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
        return view('producto.importar');
    })->name('producto.importar');

    Route::post('/productos/importar', [ImportProductosController::class, 'store'])
        ->name('productos.importar.store');

    Route::get('/inventario/reporte', [InventarioReporteController::class, 'index'])
        ->name('inventario.view');

    // DATOS (JSON)
    Route::get('/inventario/reporte/data', [InventarioReporteController::class, 'reporte'])
        ->name('inventario.reporte');

    // LOTES
    Route::get('/inventario/reporte/{productoId}/lotes', [InventarioReporteController::class, 'lotes'])
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
    Route::get('/venta/registradas', [VentaController::class, 'ventasRegistradas'])->name('ventas.registradas');
    Route::get('/ventas/fetch', [VentaController::class, 'fetchVentas'])->name('ventas.fetch');
    //impirmir venta
    Route::get('/ventas/print/{id}', [VentaController::class, 'imprimir'])->name('ventas.print');
    Route::post('/ventas/{venta}/anular', [VentaController::class, 'anular'])
    ->name('ventas.anular')
    ->middleware('permission:venta.anular');

    Route::get('/ventas/reporte', [VentaController::class, 'indexReporte'])->name('ventas.reporte_ventas');
    Route::get('/ventas/reporte/data', [VentaController::class, 'reporte'])->name('ventas.reporte.data');

    // si quieres el resumen/export separado:
    Route::get('/ventas/reporte/resumen', [VentaController::class, 'generarReporte'])->name('ventas.reporte.resumen');

    Route::get('/api/almacenes', [AlmacenController::class, 'listarParaFiltro']);
        //caja
    Route::get('/caja/verificar', [CajaController::class, 'verificarCajaActiva']);
    Route::post('/caja/abrir', [CajaController::class, 'abrirCaja']);
    Route::post('/caja/cerrar', [CajaController::class, 'cerrarCaja']);

    //Ingresoos/ Egresos
    Route::get('/ingreso-egreso-tipo', [IngresoEgresoController::class, 'index'])->name('ingreso-egreso-tipo.index');
    Route::get('/tipo_ingreso_egreso/fetch', [IngresoEgresoController::class, 'fetch']);
    Route::get('/tipo_ingreso_egreso/{id}', [IngresoEgresoController::class, 'show']);
    Route::post('/tipo_ingreso_egreso', [IngresoEgresoController::class, 'store']);
    Route::put('/tipo_ingreso_egreso/{id}', [IngresoEgresoController::class, 'update']);
    //registrar ingreso/egreso
    Route::get('/ingreso-egreso/registrar', [IngresoEgresoController::class, 'registrarIngresoEgresoIndex'])->name('ingreso-egreso.registrar');
    Route::get('/ingreso-egreso/fetch', [IngresoEgresoController::class, 'fetchIngresoEgreso'])->name('ingreso-egreso.fetch');
    Route::post('/ingreso_egreso_registrar', [IngresoEgresoController::class, 'storeIngresoEgreso'])->name('ingreso_egreso.store');
    Route::get('/ingreso-egreso/{id}', [IngresoEgresoController::class, 'showIngresoEgreso'])->name('ingreso-egreso.show');
    Route::post('/ingreso_egreso_actualizar/{id}', [IngresoEgresoController::class, 'updateIngresoEgreso'])->name('ingreso_egreso.update');



    //configuraciones
    // web.php
    Route::get('/empresas/{empresa}/config', [EmpresaConfigController::class, 'show'])->name('empresa.config.show');   // devuelve JSON
    Route::patch('/empresas/{empresa}/config', [EmpresaConfigController::class, 'update'])->name('empresa.config.update');



    //finanzas
    Route::get('/finanzas/diario', function () {
        return view('finanzas.diario');
    })->name('finanzas.diario.view');

    Route::get('/finanzas/diario/data', [FinanzasController::class, 'diario'])
        ->name('finanzas.diario');

    Route::get('/finanzas/mensual', function () {
        return view('finanzas.mensual');
    })->name('finanzas.mensual.view');

    Route::get('/finanzas/mensual/data', [FinanzasController::class, 'mensual'])
        ->name('finanzas.mensual');

    Route::get('/finanzas/ventas-producto', function () {
        return view('finanzas.ventas_producto');
    })->name('finanzas.vp.view');

    Route::get('/finanzas/ventas-producto/data', [FinanzasController::class, 'ventasPorProducto'])
        ->name('finanzas.vp.data');

    Route::get('/permisos-pantallas', [PermisosPantallasController::class, 'index'])
    ->name('permisos.pantallas');

    Route::post('/permisos-pantallas/guardar', [PermisosPantallasController::class, 'guardarCambios'])
        ->name('permisos.pantallas.guardar');

    Route::post('/permisos-pantallas/sync', [PermisosPantallasController::class, 'syncPantallas'])
        ->name('permisos.pantallas.sync');

    Route::get('/permisos-pantallas/pantalla/{pantalla}', [PermisosPantallasController::class, 'detallePantalla'])
        ->name('permisos.pantallas.detalle');

    Route::get('/permisos-pantallas/rol/{role}/resumen', [PermisosPantallasController::class, 'resumenRol'])
        ->name('permisos.pantallas.resumenRol');




    require __DIR__ . '/auth.php';
