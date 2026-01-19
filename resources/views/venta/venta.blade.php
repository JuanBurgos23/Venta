<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>src="resouces/js/venta.js"</script>
    

    <main class="main-content position-relative max-height-vh-100 h-100 compact-main">
        @vite(['resources/js/app.js', 'resources/css/venta.css', 'resources/js/venta.js', 'resources/js/datos_usuario.js'])
        <!-- Contenedor principal -->
        <div class="venta-container" id="contenedorProductos">
            <!-- Header superior -->
            <div class="venta-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Registrar Nueva Venta</h6>
                        <div class="venta-header-info">
                            <div class="info-item">
                                <i class="fa fa-user"></i>
                                <span>Atendiendo: <strong id="user-name">{{ Auth::user()->name ?? 'Usuario' }}</strong></span>
                            </div>
                            <div class="info-item">
                                <i class="fa fa-calendar"></i>
                                <input type="date" 
                                       class="form-control-sm border-0 bg-transparent p-0 text-dark"
                                       id="sale-date"
                                       style="width: auto;">
                            </div>
                            <div class="info-item">
                                <i class="fa fa-warehouse"></i>
                                <select id="almacen-select" class="form-select-sm" style="width: auto;">
                                    <!-- Se llenará dinámicamente -->
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success" id="btnCajaAccion">
                        <i class="fas fa-cash-register me-2"></i>Apertura/Cierre de Caja
                    </button>
            </div>
            </div>

            <!-- Contenido principal -->
            <div class="row g-2">
                <!-- Panel de productos -->
                <div class="col-lg-8">
                    <div class="venta-main-card">
                        <div class="productos-section">
                            <!-- Header de búsqueda -->
                            <div class="search-header">
                                <h4>Catálogo de Productos</h4>
                                <div class="search-box">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fa fa-search text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               class="form-control border-start-0" 
                                               id="product-search" 
                                               placeholder="Buscar producto por nombre, código, categoría...">
                                    </div>
                                </div>
                            </div>

                            <!-- Pestañas de productos -->
                            <div class="product-tabs">
                                <ul class="nav nav-tabs" id="productsTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="new-products-tab" data-bs-toggle="tab"
                                                data-bs-target="#new-products" type="button" role="tab">
                                            <i class="bx bx-star me-2"></i>Productos Nuevos
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="best-sellers-tab" data-bs-toggle="tab"
                                                data-bs-target="#best-sellers" type="button" role="tab">
                                            <i class="bx bx-trending-up me-2"></i>Más Vendidos
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <!-- Contenido de pestañas -->
                            <div class="tab-content pt-3" id="productsTabContent">
                                <!-- Productos nuevos -->
                                <div class="tab-pane fade show active" id="new-products" role="tabpanel">
                                    <div class="product-grid" id="new-products-container">
                                        <!-- Los productos se cargarán aquí -->
                                    </div>
                                    <div class="text-center mt-4">
                                        <button class="btn btn-outline-primary" id="load-more-new">
                                            <i class="bx bx-plus me-2"></i>Cargar más productos
                                        </button>
                                    </div>
                                </div>

                                <!-- Productos más vendidos -->
                                <div class="tab-pane fade" id="best-sellers" role="tabpanel">
                                    <div class="product-grid" id="best-sellers-container">
                                        <!-- Los productos se cargarán aquí -->
                                    </div>
                                    <div class="text-center mt-4">
                                        <button class="btn btn-outline-primary" id="load-more-best">
                                            <i class="bx bx-plus me-2"></i>Cargar más productos
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel del carrito (Desktop) -->
                <div class="col-lg-4 d-none d-lg-block">
                    <div class="venta-main-card h-100">
                        <div class="carrito-section">
                            <!-- Header del carrito -->
                            <div class="carrito-header">
                                <h6>Detalle de Venta</h6>
                            </div>

                            <!-- Selección de cliente -->
                            <div class="client-section">
                                <div class="input-group-pro">
                                    <label>Cliente</label>
                                    <div class="client-select-wrapper">
                                        <div class="client-select">
                                            <select class="form-control" id="client-select"></select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Info + Alta rápida -->
                                <div class="card border mt-2 p-2 client-card" id="client-info-card">
                                    <div class="row g-1 align-items-center">
                                        <div class="col-12">
                                            <small class="text-muted">Cliente seleccionado / nuevo</small>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <input type="text" class="quick-inline-input" placeholder="Nombre" id="qc-nombre">
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <input type="text" class="quick-inline-input" placeholder="CI" id="qc-ci">
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <input type="text" class="quick-inline-input" placeholder="Teléfono" id="qc-telefono">
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-sm btn-primary w-100 d-none" id="qc-guardar">
                                                <i class="bx bx-save me-1"></i>Guardar y usar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Items del carrito -->
                            <div class="cart-items-container" id="cart-items">
                                <div class="cart-empty text-center text-muted py-4">
                                    <i class="fa fa-shopping-cart fa-2x mb-3"></i>
                                    <p class="mb-0">No hay productos en el carrito</p>
                                </div>
                            </div>

                            <!-- Resumen de venta -->
                            <div class="sale-summary-pro">
                                <div class="summary-row">
                                    <span class="summary-label">Subtotal:</span>
                                    <span class="summary-value" id="subtotal">Bs/ 0.00</span>
                                </div>
                                
                                <div class="summary-row summary-inline">
                                    <span class="summary-label">Descuento:</span>
                                    <input type="number" class="summary-inline-input" id="discount-input" value="0" min="0">
                                </div>
                                
                                <div class="summary-row summary-inline">
                                    <span class="summary-label">Billete:</span>
                                    <input type="number" class="summary-inline-input" id="billete" placeholder="Ej: 100">
                                </div>
                                
                                <div class="summary-row">
                                    <span class="summary-label">Cambio:</span>
                                    <span class="summary-value" id="cambio">Bs/ 0.00</span>
                                </div>
                                
                                <div class="summary-row summary-total">
                                    <span>TOTAL:</span>
                                    <span id="total">Bs/ 0.00</span>
                                </div>
                            </div>

                            <!-- Método de pago y tipo de venta -->
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <div class="input-group-pro">
                                        <label>Método de Pago</label>
                                        <select class="form-control" id="payment-method">
                                            <option value="Efectivo">Efectivo</option>
                                            <option value="Tarjeta">Tarjeta</option>
                                            <option value="qr">QR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group-pro">
                                        <label>Tipo de Venta</label>
                                        <select class="form-control" id="sale-type">
                                            <option value="contado">Contado</option>
                                            <option value="credito">Crédito</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Campos de crédito -->
                            <div id="credit-fields" class="overflow-hidden" style="max-height: 0;">
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="input-group-pro">
                                            <label>Fecha de plazo</label>
                                            <input type="date" class="form-control" id="due-date">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group-pro">
                                            <label>Cuotas</label>
                                            <input type="number" class="form-control" id="installments" min="1" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón de finalizar -->
                            <div class="action-buttons">
                                <button class="btn-complete" id="complete-sale">
                                    <i class="fa fa-check-circle me-2"></i>Finalizar Venta
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón flotante para móvil -->
        <button class="floating-cart-btn d-lg-none" id="mobile-cart-toggle">
            <i class="fa fa-shopping-cart"></i>
            <span class="cart-badge d-none" id="mobile-cart-count">0</span>
        </button>
    </main>
    <div class="modal fade" id="modalAperturaCaja" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Apertura de Caja</h5>
                </div>
                <div class="modal-body">
                    <form id="formAperturaCaja">
                        <div class="mb-3">
                            <label for="fecha_apertura" class="form-label">Fecha y hora de apertura</label>
                            <input type="datetime-local" id="fecha_apertura" name="fecha_apertura" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="monto_inicial" class="form-label">Monto de apertura</label>
                            <input type="number" step="0.01" id="monto_inicial" name="monto_inicial" class="form-control" required>
                        </div>
                        <select name="sucursal_id" class="form-select">
                            @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelarCaja">Cancelar</button>
                    <button type="submit" form="formAperturaCaja" class="btn btn-primary">Abrir caja</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Cierre de caja modal-->
    <div class="modal fade" id="modalCierreCaja" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Cierre de Caja</h5>
                </div>
                <div class="modal-body">
                    <form id="formCierreCaja">
                        <div class="mb-3">
                            <label for="fecha_apertura_cierre" class="form-label">Fecha y hora de apertura</label>
                            <input type="text" id="fecha_apertura_cierre" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="monto_inicial_cierre" class="form-label">Monto de apertura</label>
                            <input type="text" id="monto_inicial_cierre" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_cierre" class="form-label">Fecha y hora de cierre</label>
                            <input type="datetime-local" id="fecha_cierre" name="fecha_cierre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="monto_final" class="form-label">Monto de cierre</label>
                            <input type="number" id="monto_final" name="monto_final" class="form-control" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="observacion" class="form-label">Observaciones</label>
                            <textarea id="observacion" name="observacion" rows="3" class="form-control" placeholder="Observaciones sobre el cierre..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formCierreCaja" class="btn btn-danger">Cerrar Caja</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para nuevo cliente -->
    <div class="modal fade" id="newClientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="newClientForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Registrar Nuevo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" name="paterno">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" name="materno">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CI</label>
                                <input type="text" class="form-control" name="ci">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" name="telefono">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Correo</label>
                                <input type="email" class="form-control" name="correo">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <style>
        .compact-main {
            padding-top: 2px !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        .compact-main .container-fluid,
        .compact-main .venta-container {
            padding-top: 8px !important;
            padding-bottom: 12px !important;
        }
        .compact-main .venta-main-card,
        .compact-main .card {
            margin-top: 6px;
        }
    </style>
</x-layout>
