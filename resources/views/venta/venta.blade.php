<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    </main>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <!-- Scripts -->
        @vite([ 'resources/js/app.js'])
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-3 pb-0 bg-transparent">
                        <h6 class="mb-1 font-weight-bolder">Registrar Nueva Venta</h6>
                        <p class="text-sm mb-0 text-secondary d-flex flex-wrap">
                            <span class="d-flex align-items-center me-3">
                                <i class="fa fa-user me-1" aria-hidden="true"></i>
                                Atendiendo: <span id="user-name" class="ms-1 fw-bold">{{ Auth::user()->name ?? 'Usuario' }}</span>
                            </span>
                            <input type="text" name="empresa_id" id="empresa_id" value="{{ Auth::user()->id_empresa }}" hidden>
                            <span class="d-flex align-items-center">
                                <i class="fa fa-calendar me-1" aria-hidden="true"></i>
                                <input type="datetime-local"
                                    class="form-control form-control-sm border-0 bg-transparent p-0 ms-1 text-dark"
                                    id="sale-date"
                                    style="width: auto; display: inline-block;">
                            </span>
                        <div class="text-end mb-3">
                            <button class="btn btn-success" id="btnCajaAccion">
                                <i class="fas fa-cash-register"></i> Apertura/Cierre de Caja
                            </button>
                        </div>
                        <div class="mb-3">
                            <label for="almacen-select" class="form-label">Selecciona Almacén</label>
                            <select id="almacen-select" class="form-select">
                                <!-- Se llenará dinámicamente desde JS -->
                            </select>
                        </div>
                        </p>
                    </div>
                    <div class="card-body p-3 pt-4">
                        <!-- Botón para abrir carrito en móvil -->
                        <div class="d-lg-none d-block mb-4">
                            <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" id="mobile-cart-toggle">
                                <i class="fa fa-shopping-cart me-2" aria-hidden="true"></i>
                                Ver Carrito
                                <span class="badge bg-white text-primary ms-2" id="mobile-cart-count">0</span>
                            </button>
                        </div>

                        <div class="row">
                            <!-- Panel de productos - Columna izquierda -->
                            <div class="col-lg-8 col-md-7 mb-4 mb-md-0">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0 font-weight-bolder text-dark">Catálogo de Productos</h4>
                                    <div class="input-group input-group-outline w-50">
                                        <label class="form-label">Buscar producto...</label>
                                        <input type="text" class="form-control" id="product-search">
                                    </div>
                                </div>

                                <!-- Filtros por categoría mejorados -->
                                <div class="card mb-4">
                                    <div class="card-body py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 text-dark">Filtrar por categoría:</h6>
                                            <div class="d-flex flex-wrap gap-2" id="category-filters">
                                                <button class="btn btn-sm btn-primary active" data-category="all">Todos los productos</button>
                                                <!-- Las categorías se cargarán dinámicamente desde JavaScript -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pestañas de productos mejoradas -->
                                <div class="card">
                                    <div class="card-header p-0">
                                        <ul class="nav nav-tabs mb-0" id="productsTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active py-3 px-4" id="new-products-tab" data-bs-toggle="tab"
                                                    data-bs-target="#new-products" type="button" role="tab">
                                                    <i class="bx bx-star me-2"></i>Productos Nuevos
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link py-3 px-4" id="best-sellers-tab" data-bs-toggle="tab"
                                                    data-bs-target="#best-sellers" type="button" role="tab">
                                                    <i class="bx bx-trending-up me-2"></i>Más Vendidos
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="card-body p-4">
                                        <!-- Contenido de pestañas -->
                                        <div class="tab-content" id="productsTabContent">
                                            <!-- Productos nuevos -->
                                            <div class="tab-pane fade show active" id="new-products" role="tabpanel">
                                                <div class="row g-4" id="new-products-container">
                                                    <!-- Los productos se cargarán aquí mediante JavaScript -->
                                                </div>
                                                <div class="text-center mt-5">
                                                    <button class="btn btn-lg btn-outline-primary px-5" id="load-more-new">
                                                        <i class="bx bx-plus-circle me-2"></i>Cargar más productos
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Productos más vendidos -->
                                            <div class="tab-pane fade" id="best-sellers" role="tabpanel">
                                                <div class="row g-4" id="best-sellers-container">
                                                    <!-- Los productos se cargarán aquí mediante JavaScript -->
                                                </div>
                                                <div class="text-center mt-5">
                                                    <button class="btn btn-lg btn-outline-primary px-5" id="load-more-best">
                                                        <i class="bx bx-plus-circle me-2"></i>Cargar más productos
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Carrito de compras - Columna derecha (Solo escritorio) -->
                            <div class="col-lg-4 col-md-5 d-md-block d-none">
                                <div class="card card-body border-radius-lg shadow-none border-dashed h-100 sale-cart-card">
                                    <h6 class="mb-3 font-weight-bolder">Detalle de Venta</h6>

                                    <!-- Información del cliente -->
                                    <div class="mb-3 d-flex align-items-end gap-2">
                                        <div class="flex-grow-1">
                                            <label class="form-label text-sm">Cliente</label>
                                            <select class="form-select px-3" id="client-select" style="min-height: 44px;"></select>
                                        </div>
                                        <div style="align-self: flex-end;">
                                            <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center"
                                                style="height: 44px; padding: 0 12px;"
                                                data-bs-toggle="modal" data-bs-target="#newClientModal">
                                                <i class="bx bx-plus me-1"></i> Nuevo
                                            </button>
                                        </div>
                                    </div>


                                    <!-- Datos del cliente (solo lectura) -->
                                    <div class="card border-radius-lg p-3 mb-3 d-none" id="client-info-card">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-sm text-secondary">Nombre:</span>
                                            <span class="text-sm font-weight-bold" id="client-name">-</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-sm text-secondary">CI:</span>
                                            <span class="text-sm font-weight-bold" id="client-ci">-</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-sm text-secondary">Teléfono:</span>
                                            <span class="text-sm font-weight-bold" id="client-phone">-</span>
                                        </div>
                                    </div>

                                    <!-- Lista de productos en el carrito -->
                                    <div class="cart-items mb-3 slim-cart" id="cart-items">
                                        <div class="cart-empty text-center text-muted">
                                            <i class="fa fa-shopping-cart fa-lg mb-1" aria-hidden="true"></i>
                                            <p class="mb-0 text-sm">No hay productos en el carrito</p>
                                        </div>
                                    </div>

                                    <!-- Resumen de la venta -->
                                    <div class="sale-summary mb-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-sm">Subtotal:</span>
                                            <span class="text-sm font-weight-bold" id="subtotal">Bs/ 0.00</span>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label text-sm mb-0">Descuento:</label>
                                            <input type="number" class="form-control form-control-sm" id="discount-input" value="0" min="0">
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label text-sm mb-0">Billete:</label>
                                            <input type="number" class="form-control form-control-sm" id="billete" placeholder="Ej: 100">
                                        </div>

                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-sm">Cambio:</span>
                                            <span class="text-sm font-weight-bold" id="cambio">Bs/ 0.00</span>
                                        </div>

                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span class="text-dark">Total:</span>
                                            <span class="text-dark" id="total">Bs/ 0.00</span>
                                        </div>
                                    </div>

                                    <!-- Método de pago -->
                                    <div class="mb-3">
                                        <label class="form-label text-sm">Método de Pago</label>
                                        <select class="form-select px-3" id="payment-method" style="min-height: 44px;">
                                            <option value="Efectivo">Efectivo</option>
                                            <option value="Tarjeta">Tarjeta</option>
                                            <option value="qr">QR</option>
                                        </select>
                                    </div>

                                    <!-- Tipo de venta -->
                                    <div class="mb-3">
                                        <label class="form-label text-sm">Tipo de Venta</label>
                                        <select class="form-select px-3" id="sale-type" style="min-height: 44px;">
                                            <option value="contado">Contado</option>
                                            <option value="credito">Crédito</option>
                                        </select>
                                    </div>

                                    <!-- Campos para crédito (inicialmente ocultos) -->
                                    <div id="credit-fields" class="overflow-hidden" style="max-height: 0; transition: max-height 0.5s ease;">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label class="form-label text-sm">Fecha de plazo</label>
                                                <input type="date" class="form-control form-control-sm" id="due-date">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label text-sm">Cuotas</label>
                                                <input type="number" class="form-control form-control-sm" id="installments" min="1" value="1">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botón para finalizar venta -->
                                    <button class="btn bg-gradient-primary w-100 mt-2 mb-0" id="complete-sale">
                                        <i class="fa fa-check-circle me-1" aria-hidden="true"></i>
                                        Finalizar Venta
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Botón flotante de carrito (móvil) -->
    <button id="floating-sale-cart-btn" class="btn btn-primary floating-sale-cart-btn d-lg-none">
        <i class="menu-icon icon-base bx bx-cart fs-5"></i>
        <span id="floating-sale-cart-count" class="cart-bubble"></span>
    </button>
    <!-- Panel lateral para móviles -->
    <div class="mobile-cart-sidebar d-lg-none" id="mobile-cart-sidebar">
        <div class="mobile-cart-overlay" id="mobile-cart-overlay"></div>
        <div class="mobile-cart-content">
            <div class="mobile-cart-header">
                <h6 class="mb-0 font-weight-bolder">Detalle de Venta</h6>
                <button class="btn btn-link text-dark p-0" id="close-mobile-cart">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="mobile-cart-body">
                <!-- Información del cliente -->
                <div class="mb-3 d-flex align-items-center gap-2">
                    <div class="flex-grow-1">
                        <label class="form-label text-sm">Cliente</label>
                        <select class="form-select px-3" id="mobile-client-select" style="min-height: 44px;"></select>
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#newClientModal">
                            <i class="bx bx-plus"></i> Nuevo
                        </button>
                    </div>
                </div>
                <!-- Datos del cliente (solo lectura) -->
                <div class="card border-radius-lg p-3 mb-3 d-none" id="mobile-client-info-card">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-sm text-secondary">Nombre:</span>
                        <span class="text-sm font-weight-bold" id="mobile-client-name">-</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-sm text-secondary">CI:</span>
                        <span class="text-sm font-weight-bold" id="mobile-client-ci">-</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-sm text-secondary">Teléfono:</span>
                        <span class="text-sm font-weight-bold" id="mobile-client-phone">-</span>
                    </div>
                </div>

                <!-- Lista de productos en el carrito -->
                <div class="cart-items mb-3 slim-cart" id="mobile-cart-items">
                    <div class="cart-empty text-center text-muted">
                        <i class="fa fa-shopping-cart fa-lg mb-1" aria-hidden="true"></i>
                        <p class="mb-0 text-sm">No hay productos en el carrito</p>
                    </div>
                </div>

                <!-- Resumen de la venta -->
                <div class="sale-summary mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Subtotal:</span>
                        <span class="text-sm font-weight-bold" id="mobile-subtotal">Bs/ 0.00</span>
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-sm mb-0">Descuento:</label>
                        <input type="number" class="form-control form-control-sm" id="mobile-discount-input" value="0" min="0">
                    </div>

                    <div class="mb-2">
                        <label class="form-label text-sm mb-0">Billete:</label>
                        <input type="number" class="form-control form-control-sm" id="mobile-billete" placeholder="Ej: 100">
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-sm">Cambio:</span>
                        <span class="text-sm font-weight-bold" id="mobile-cambio">Bs/ 0.00</span>
                    </div>

                    <hr class="my-2">
                    <div class="d-flex justify-content-between fw-bold">
                        <span class="text-dark">Total:</span>
                        <span class="text-dark" id="mobile-total">Bs/ 0.00</span>
                    </div>
                </div>

                <!-- Método de pago -->
                <div class="mb-3">
                    <label class="form-label text-sm">Método de Pago</label>
                    <select class="form-select px-3" id="mobile-payment-method" style="min-height: 44px;">
                        <option value="Efectivo">Efectivo</option>
                        <option value="Tarjeta">Tarjeta</option>
                        <option value="qr">QR</option>
                    </select>
                </div>

                <!-- Tipo de venta -->
                <div class="mb-3">
                    <label class="form-label text-sm">Tipo de Venta</label>
                    <select class="form-select px-3" id="mobile-sale-type" style="min-height: 44px;">
                        <option value="contado">Contado</option>
                        <option value="credito">Crédito</option>
                    </select>
                </div>

                <!-- Campos para crédito (inicialmente ocultos) -->
                <div id="mobile-credit-fields" class="overflow-hidden" style="max-height: 0; transition: max-height 0.5s ease;">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-sm">Fecha de plazo</label>
                            <input type="date" class="form-control form-control-sm" id="mobile-due-date">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-sm">Cuotas</label>
                            <input type="number" class="form-control form-control-sm" id="mobile-installments" min="1" value="1">
                        </div>
                    </div>
                </div>

                <!-- Botón para finalizar venta -->
                <button class="btn bg-gradient-primary w-100 mt-2 mb-0" id="mobile-complete-sale">
                    <i class="fa fa-check-circle me-1" aria-hidden="true"></i>
                    Finalizar Venta
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para QR -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pago con QR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="qr-image" src="" alt="Código QR" class="img-fluid mb-3">
                    <p>Escanea el código QR para realizar el pago</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="confirm-qr-payment">Confirmar Pago</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Customizer va fuera de main y slot -->
    <div class="modal fade" id="newClientModal" tabindex="-1" aria-labelledby="newClientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="newClientForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newClientModalLabel">Registrar Nuevo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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
    <!-- 🔸 Modal de apertura de caja -->
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
    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const modalApertura = new bootstrap.Modal(document.getElementById('modalAperturaCaja'));
            const modalCierre = new bootstrap.Modal(document.getElementById('modalCierreCaja'));
            let cajaActiva = null;

            // Función para obtener caja activa
            async function verificarCaja() {
                const res = await fetch('/caja/verificar');
                const data = await res.json();
                cajaActiva = data.activa ? data.caja : null;
                return data;
            }

            // Mostrar modal si no hay caja activa
            const estado = await verificarCaja();
            if (!estado.activa) {
                setDefaultDatetime('fecha_apertura');
                modalApertura.show();
                document.querySelector("#contenedorProductos")?.classList.add("d-none");
            }

            // Configurar botón principal
            document.getElementById('btnCajaAccion').addEventListener('click', () => {
                if (!cajaActiva) {
                    setDefaultDatetime('fecha_apertura');
                    modalApertura.show();
                } else {
                    // Llenar datos de la caja activa en el modal de cierre
                    document.getElementById('fecha_apertura_cierre').value = cajaActiva.fecha_apertura;
                    document.getElementById('monto_inicial_cierre').value = cajaActiva.monto_inicial;
                    setDefaultDatetime('fecha_cierre');
                    modalCierre.show();
                }
            });

            // Abrir caja
            document.getElementById('formAperturaCaja').addEventListener('submit', async e => {
                e.preventDefault();
                const formData = new FormData(e.target);

                const res = await fetch('/caja/abrir', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Caja abierta correctamente',
                        timer: 1500,
                        showConfirmButton: false,
                        didClose: () => {
                            location.reload();
                        }
                    });
                    modalApertura.hide();
                    document.querySelector("#contenedorProductos")?.classList.remove("d-none");
                    cajaActiva = data.caja;

                }
            });

            // Cerrar caja
            document.getElementById('formCierreCaja').addEventListener('submit', async e => {
                e.preventDefault();
                const formData = new FormData(e.target);

                const res = await fetch('/caja/cerrar', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Caja cerrada correctamente',
                        timer: 1500,
                        showConfirmButton: false,
                        didClose: () => {
                            location.reload();
                        }
                    });
                    modalCierre.hide();
                    cajaActiva = null;
                    document.querySelector("#contenedorProductos")?.classList.add("d-none");
                }
            });

            // Cancelar apertura sin abrir caja
            document.getElementById('btnCancelarCaja').addEventListener('click', () => {
                Swal.fire({
                    icon: 'warning',
                    title: 'No puedes realizar ventas sin abrir una caja activa',
                    text: 'Por favor abre una caja para continuar.',
                    confirmButtonText: 'Entendido'
                });
            });

            // Función para establecer fecha/hora actual
            function setDefaultDatetime(id) {
                const input = document.getElementById(id);
                const now = new Date();
                const local = new Date(now.getTime() - now.getTimezoneOffset() * 60000)
                    .toISOString().slice(0, 16);
                input.value = local;
            }
        });
        
    </script>

    <style>
        /* Estilos mejorados para productos - Diseño e-commerce profesional */
/* Estilos mejorados para productos - Diseño más ancho y profesional */
:root {
    --primary-color: #4e73df;
    --primary-dark: #2e59d9;
    --secondary-color: #6c757d;
    --success-color: #1cc88a;
    --danger-color: #e74a3b;
    --warning-color: #f6c23e;
    --light-color: #f8f9fc;
    --dark-color: #5a5c69;
    --border-radius: 12px;
    --border-radius-lg: 16px;
    --box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    --box-shadow-hover: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
    --transition: all 0.3s ease;
}

/* Filtros de categoría mejorados */
#category-filters .btn {
    border-radius: 8px;
    transition: var(--transition);
    font-weight: 600;
    padding: 8px 16px;
    border: 2px solid transparent;
}

#category-filters .btn.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
}

#category-filters .btn:not(.active) {
    background-color: white;
    border-color: #e3e6f0;
    color: var(--dark-color);
}

#category-filters .btn:hover:not(.active) {
    background-color: rgba(78, 115, 223, 0.05);
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateY(-2px);
}

/* Tarjetas de producto mejoradas - Más anchas y profesionales */
.product-card {
    transition: var(--transition);
    cursor: pointer;
    border: 0;
    border-radius: var(--border-radius-lg);
    overflow: hidden;
    background: #fff;
    box-shadow: var(--box-shadow);
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
    border: 1px solid #e3e6f0;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--box-shadow-hover);
    border-color: var(--primary-color);
}

.product-card .product-image {
    position: relative;
    height: 220px;
    background: linear-gradient(135deg, #f8f9fa 0%, #eef2f7 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
}

.product-card .product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: var(--transition);
}

.product-card:hover .product-image img {
    transform: scale(1.08);
}

.product-card .product-badges {
    position: absolute;
    top: 12px;
    left: 12px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    z-index: 2;
}

.product-card .badge {
    font-size: 0.75rem;
    font-weight: 700;
    padding: 6px 10px;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-card .badge.new {
    background: linear-gradient(45deg, var(--success-color), #17a673);
    color: white;
    box-shadow: 0 2px 8px rgba(28, 200, 138, 0.3);
}

.product-card .badge.discount {
    background: linear-gradient(45deg, var(--danger-color), #d52a1e);
    color: white;
    box-shadow: 0 2px 8px rgba(231, 74, 59, 0.3);
}

.product-card .badge.category {
    background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
    color: white;
    box-shadow: 0 2px 8px rgba(78, 115, 223, 0.3);
}

.product-card .stock-chip {
    position: absolute;
    top: 12px;
    right: 12px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 700;
    background: rgba(255, 255, 255, 0.95);
    color: #111827;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    z-index: 2;
}

.product-card .stock-chip.low-stock {
    background: rgba(231, 74, 59, 0.1);
    color: var(--danger-color);
    border: 1px solid rgba(231, 74, 59, 0.2);
}

.product-card .stock-chip.out-of-stock {
    background: rgba(108, 117, 125, 0.1);
    color: var(--secondary-color);
    border: 1px solid rgba(108, 117, 125, 0.2);
}

/* Contenido de la tarjeta - Estructura mejorada */
.product-card .card-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    flex-grow: 1;
}

/* Título destacado */
.product-card .product-title-section {
    margin-bottom: 0.5rem;
}

.product-card .category {
    font-size: 0.85rem;
    color: var(--primary-color);
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.5rem;
    display: block;
}

.product-card .title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #2d3748;
    line-height: 1.3;
    margin-bottom: 0.5rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: auto;
    min-height: 3rem;
}

/* Información del producto seccionada */
.product-card .product-info-section {
    margin: 0.75rem 0;
    flex-grow: 1;
}

.product-card .description {
    font-size: 0.9rem;
    color: #718096;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 1rem;
}

.product-card .product-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 0.75rem 0;
    border-top: 1px solid #f7fafc;
    border-bottom: 1px solid #f7fafc;
}

.product-card .meta-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.85rem;
}

.product-card .meta-label {
    color: var(--secondary-color);
    font-weight: 600;
}

.product-card .meta-value {
    color: #2d3748;
    font-weight: 700;
}

/* Sección de precio y acción */
.product-card .product-action-section {
    margin-top: auto;
    padding-top: 1rem;
}

.product-card .price-container {
    margin-bottom: 1rem;
}

.product-card .current-price {
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--primary-color);
    line-height: 1;
}

.product-card .original-price {
    font-size: 1rem;
    color: var(--secondary-color);
    text-decoration: line-through;
    margin-left: 0.5rem;
}

.product-card .price-note {
    font-size: 0.8rem;
    color: var(--success-color);
    font-weight: 600;
    margin-top: 0.25rem;
}

.product-card .btn-add {
    border-radius: 50px;
    padding: 12px 24px;
    font-weight: 700;
    background: linear-gradient(45deg, var(--primary-color), var(--primary-dark));
    border: none;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    font-size: 1rem;
    box-shadow: 0 4px 12px rgba(78, 115, 223, 0.3);
}

.product-card .btn-add:hover {
    background: linear-gradient(45deg, var(--primary-dark), #2653d4);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(78, 115, 223, 0.4);
}

.product-card .btn-add:active {
    transform: translateY(0);
}

.product-card .btn-add:disabled {
    background: var(--secondary-color);
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* Grid responsivo mejorado */
@media (max-width: 1400px) {
    .product-card .product-image {
        height: 200px;
    }
}

@media (max-width: 1200px) {
    .product-card .title {
        font-size: 1.1rem;
    }
    
    .product-card .current-price {
        font-size: 1.3rem;
    }
}

@media (max-width: 768px) {
    .product-card .product-image {
        height: 180px;
    }
    
    .product-card .card-body {
        padding: 1.25rem;
    }
    
    .product-card .title {
        font-size: 1rem;
        min-height: 2.5rem;
    }
    
    .product-card .current-price {
        font-size: 1.2rem;
    }
    
    .product-card .btn-add {
        padding: 10px 20px;
        font-size: 0.9rem;
    }
}

/* Animaciones mejoradas */
@keyframes addToCart {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
    100% {
        transform: scale(1);
    }
}

.added-to-cart {
    animation: addToCart 0.4s ease;
}

/* Efecto de carga para imágenes */
.product-card .product-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    z-index: 1;
    opacity: 0;
}

.product-card .product-image.loading::before {
    opacity: 1;
}

.product-card .product-image img.loaded {
    opacity: 1;
}

.product-card .product-image img {
    opacity: 0;
    transition: opacity 0.3s ease;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}

/* Estados especiales */
.product-card.featured {
    border: 2px solid var(--warning-color);
    box-shadow: 0 0 0 1px var(--warning-color), var(--box-shadow);
}

.product-card.featured::before {
    content: '⭐ Destacado';
    position: absolute;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--warning-color);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 700;
    z-index: 3;
}
        :root {
            --primary-gradient: linear-gradient(195deg, #42424a, #191919);
            --secondary-gradient: linear-gradient(195deg, #49a3f1, #1A73E8);
        }

        /* Botón flotante */
        .floating-sale-cart-btn {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            color: #fff;
            border: none;
            outline: none;
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            cursor: pointer;
            opacity: 0;
            transform: scale(0);
            transition: all 0.3s ease-in-out;
        }

        /* Estado visible */
        .floating-sale-cart-btn.show {
            opacity: 1;
            transform: scale(1);
        }

        /* Burbuja del contador */
        .cart-bubble {
            position: absolute;
            top: -2px;
            /* ahora encima */
            right: -2px;
            /* pegada al borde */
            background: #ff3b30;
            color: white;
            border-radius: 50%;
            padding: 3px 7px;
            font-size: 12px;
            font-weight: bold;
            transform: scale(0);
            transition: transform 0.2s ease;
        }

        /* Cuando tenga valor, se anima */
        .cart-bubble.active {
            transform: scale(1);
            animation: bubble-pop 0.3s ease;
        }

        /* Animación burbuja */
        @keyframes bubble-pop {
            0% {
                transform: scale(0.5);
                opacity: 0.5;
            }

            50% {
                transform: scale(1.3);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .product-card {
            transition: all 0.25s ease;
            cursor: pointer;
            border: 0;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 6px 18px rgba(33, 37, 41, 0.08);
            display: flex;
            flex-direction: column;
            height: 100%;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 26px rgba(33, 37, 41, 0.12);
        }

        .product-card .product-image {
            position: relative;
            height: 170px;
            background: linear-gradient(135deg, #f8f9fa 0%, #eef2f7 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-card .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-card .stock-chip {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.9);
            color: #111827;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .product-card .card-body {
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .product-card .title {
            font-size: 0.98rem;
            font-weight: 700;
            color: #111827;
            min-height: 40px;
        }

        .product-card .meta {
            font-size: 0.82rem;
            color: #6b7280;
        }

        .product-card .price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4px;
        }

        .product-card .price {
            font-size: 1.05rem;
            font-weight: 800;
            color: #0f766e;
        }

        .product-card .btn-add {
            border-radius: 999px;
            padding: 6px 12px;
        }

        .sale-cart-card {
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.06);
            padding: 18px;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
        }

        .slim-cart {
            max-height: 320px;
            overflow-y: auto;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 10px;
        }

        .slim-cart::-webkit-scrollbar {
            width: 6px;
        }

        .slim-cart::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 6px;
        }

        .cart-line {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: center;
            padding: 10px 12px;
            border: 1px solid #eceff5;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            margin-bottom: 8px;
        }

        .cart-line__info {
            min-width: 0;
        }

        .cart-line__title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 4px;
            line-height: 1.3;
        }

        .cart-line__meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            font-size: 0.78rem;
            color: #6b7280;
        }

        .cart-line__actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .qty-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 4px 6px;
        }

        .qty-btn {
            width: 26px;
            height: 26px;
            border: none;
            background: transparent;
            border-radius: 50%;
            font-weight: 700;
            color: #111827;
            transition: background 0.2s ease, transform 0.2s ease;
        }

        .qty-btn:hover {
            background: #e5e7eb;
            transform: translateY(-1px);
        }

        .qty-pill__value {
            min-width: 24px;
            text-align: center;
            font-weight: 700;
            font-size: 0.85rem;
            color: #111827;
        }

        .cart-line__total {
            font-weight: 800;
            color: #0f766e;
            font-size: 0.95rem;
            min-width: 80px;
            text-align: right;
        }

        .icon-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #ef4444;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .icon-btn:hover {
            background: #fef2f2;
            border-color: #fecaca;
        }

        .cart-empty {
            padding: 18px;
            border: 1px dashed #e5e7eb;
            border-radius: 12px;
            background: #f8fafc;
        }

        .sale-summary {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px;
        }

        .sale-summary .form-control-sm {
            border-radius: 10px;
        }

        @media (max-width: 992px) {
            .cart-line {
                grid-template-columns: 1fr;
            }

            .cart-line__actions {
                justify-content: space-between;
                flex-wrap: wrap;
            }

            .cart-line__total {
                text-align: left;
            }
        }

        .border-dashed {
            border: 1px dashed #cb0c9f !important;
        }

        /* Estilos para móviles */
        .mobile-cart-sidebar {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100%;
            z-index: 9999;
            transition: right 0.3s ease;
        }

        .mobile-cart-sidebar.active {
            right: 0;
        }

        .mobile-cart-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-cart-sidebar.active .mobile-cart-overlay {
            opacity: 1;
            visibility: visible;
        }

        .mobile-cart-content {
            position: absolute;
            top: 0;
            right: 0;
            width: 85%;
            max-width: 400px;
            height: 100%;
            background: white;
            padding: 20px;
            overflow-y: auto;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .mobile-cart-sidebar.active .mobile-cart-content {
            transform: translateX(0);
        }

        .mobile-cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        /* Estilos generales */
        .nav-tabs .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            padding: 10px 15px;
            color: #6c757d;
            font-weight: 500;
        }


        .bg-gray-100 {
            background-color: #f8f9fa !important;
        }

        .border-radius-lg {
            border-radius: 12px;
        }

        .input-group.input-group-outline .form-label {
            position: absolute;
            top: -10px;
            left: 10px;
            background: white;
            padding: 0 5px;
            font-size: 12px;
            z-index: 1;
            color: #6c757d;
        }

        .input-group.input-group-outline .form-control {
            padding-top: 16px;
            padding-bottom: 12px;
        }

        .form-select {
            border-radius: 8px;
            border: 1px solid #d2d6da;
            padding: 10px 12px;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-size: 16px 12px;
        }

        .btn.bg-gradient-primary {
            background-image: var(--secondary-gradient);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .btn.bg-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .product-grid-mobile {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .card-header.bg-transparent {
                background: transparent !important;
            }
        }

        .product-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar modo claro */
        [data-bs-theme="light"] #mobile-cart-sidebar .mobile-cart-content {
            background: #fff;
            color: #000;
        }

        /* Sidebar modo oscuro */
        [data-bs-theme="dark"] #mobile-cart-sidebar .mobile-cart-content {
            background: #1e1e2d;
            color: #f1f1f1;
        }

        /* Cliente info adaptativo */
        [data-bs-theme="light"] .client-info-box,
        .product-card {
            background: #fff;
            color: #000;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            padding: 0.75rem;
            margin-top: 0.5rem;
        }

        [data-bs-theme="dark"] .client-info-box,
        [data-bs-theme="dark"] .product-card {
            background: #1e1e2d;
            color: #f1f1f1;
            border: 1px solid #333;
            border-radius: 0.5rem;
            padding: 0.75rem;
            margin-top: 0.5rem;
        }
    </style>
    <script>
        // aquí Laravel ya resuelve la ruta real de la imagen
        const defaultImage = "{{ asset('assets/img/backgrounds/default.jpg') }}";
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables globales
            let cart = [];
            let allProducts = [];
            let clients = [];
            let currentPageNew = 1;
            let currentPageBest = 1;
            const productsPerPage = 10;

            // Elementos DOM
            const cartItemsContainer = document.getElementById('cart-items');
            const mobileCartItemsContainer = document.getElementById('mobile-cart-items');
            const subtotalElement = document.getElementById('subtotal');
            const taxElement = document.getElementById('tax');
            const totalElement = document.getElementById('total');
            const discountElement = document.getElementById('discount');
            const mobileSubtotalElement = document.getElementById('mobile-subtotal');
            const mobileTaxElement = document.getElementById('mobile-tax');
            const mobileTotalElement = document.getElementById('mobile-total');
            const mobileDiscountElement = document.getElementById('mobile-discount');
            const saleTypeSelect = document.getElementById('sale-type');
            const mobileSaleTypeSelect = document.getElementById('mobile-sale-type');
            const creditFields = document.getElementById('credit-fields');
            const mobileCreditFields = document.getElementById('mobile-credit-fields');
            const paymentMethodSelect = document.getElementById('payment-method');
            const mobilePaymentMethodSelect = document.getElementById('mobile-payment-method');
            const qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
            const clientSelect = document.getElementById('client-select');
            const mobileClientSelect = document.getElementById('mobile-client-select');
            const clientInfoCard = document.getElementById('client-info-card');
            const mobileClientInfoCard = document.getElementById('mobile-client-info-card');
            const mobileCartSidebar = document.querySelector('.mobile-cart-sidebar');
            const mobileCartToggle = document.getElementById('mobile-cart-toggle');
            const closeMobileCart = document.getElementById('close-mobile-cart');
            const mobileCartOverlay = document.getElementById('mobile-cart-overlay');
            const mobileCartCount = document.getElementById('mobile-cart-count');
            const saleDateInput = document.getElementById('sale-date');
            const now = new Date();

            // Ajusta la hora local para datetime-local (YYYY-MM-DDTHH:mm)
            const offset = now.getTimezoneOffset();
            const localISOTime = new Date(now.getTime() - (offset * 60000))
                .toISOString()
                .slice(0, 16);

            saleDateInput.value = localISOTime;

            // Cargar productos y clientes al iniciar
            loadProducts();
            loadClients();
            const discountInput = document.getElementById("discount-input");
            const billeteInput = document.getElementById("billete");

            const mobileDiscountInput = document.getElementById("mobile-discount-input");
            const mobileBilleteInput = document.getElementById("mobile-billete");

            // Escritorio
            discountInput.addEventListener("input", () => updateCart());
            billeteInput.addEventListener("input", () => updateCart());

            // Móvil
            mobileDiscountInput.addEventListener("input", () => updateCart());
            mobileBilleteInput.addEventListener("input", () => updateCart());
            // Event listeners
            document.getElementById('load-more-new').addEventListener('click', loadMoreNewProducts);
            document.getElementById('load-more-best').addEventListener('click', loadMoreBestSellers);
            document.getElementById('product-search').addEventListener('input', searchProducts);

            saleTypeSelect.addEventListener('change', toggleCreditFields);
            mobileSaleTypeSelect.addEventListener('change', toggleMobileCreditFields);

            paymentMethodSelect.addEventListener('change', handlePaymentMethodChange);
            mobilePaymentMethodSelect.addEventListener('change', handleMobilePaymentMethodChange);

            document.getElementById('complete-sale').addEventListener('click', completeSale);
            document.getElementById('mobile-complete-sale').addEventListener('click', completeSale);
            document.getElementById('confirm-qr-payment').addEventListener('click', confirmQrPayment);

            // Toggle carrito móvil
            mobileCartToggle.addEventListener('click', toggleMobileCart);
            closeMobileCart.addEventListener('click', toggleMobileCart);
            mobileCartOverlay.addEventListener('click', toggleMobileCart);

            // Evento para selección de cliente
            clientSelect.addEventListener('change', updateClientInfo);
            mobileClientSelect.addEventListener('change', updateMobileClientInfo);



            async function loadAlmacenes() {
                try {
                    const res = await fetch('/venta/almacenes');
                    const almacenes = await res.json();

                    const select = document.getElementById('almacen-select');
                    select.innerHTML = '';

                    if (almacenes.length === 0) {
                        console.warn('No hay almacenes disponibles');
                        return;
                    }

                    almacenes.forEach((a, i) => {
                        const option = document.createElement('option');
                        option.value = a.id;
                        option.textContent = a.nombre;
                        select.appendChild(option);
                    });

                    // Seleccionamos el primer almacen
                    select.selectedIndex = 0;

                    // Llamamos loadProducts usando el value del select
                    const almacenId = select.value;
                    console.log('Cargando productos para almacen ID:', almacenId);
                    loadProducts(almacenId);

                    // Cambios en el select
                    select.addEventListener('change', () => {
                        loadProducts(select.value);
                    });

                } catch (error) {
                    console.error('Error cargando almacenes:', error);
                }
            }

            // Ajustar loadProducts para convertir price/stock a número
            function loadProducts(almacenId) {
                console.log('Fetch productos con almacenId:', almacenId);
                if (!almacenId) {
                    console.error('No hay almacenId, abortando fetch.');
                    return;
                }
                fetch(`/producto/venta?almacen_id=${almacenId}`)
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        // Convertir price y stock a número
                        allProducts = data.map(p => ({
                            ...p,
                            price: Number(p.price),
                            stock: Number(p.stock)
                        }));
                        console.log('Productos cargados:', allProducts);
                        renderNewProducts();
                        renderBestSellers();
                    })
                    .catch(error => console.error('Error cargando productos:', error));
            }

            // Inicializar
            loadAlmacenes();

            // Función para cargar clientes

            function loadClients() {
                const clientSelect = document.getElementById('client-select');
                const mobileClientSelect = document.getElementById('mobile-client-select');
                const url = '/clientes/fetch-json';

                if (!clientSelect || !mobileClientSelect) return;

                // destruir instancias TomSelect previas si existen
                if (clientSelect.tomselect && typeof clientSelect.tomselect.destroy === 'function') {
                    clientSelect.tomselect.destroy();
                }
                if (mobileClientSelect.tomselect && typeof mobileClientSelect.tomselect.destroy === 'function') {
                    mobileClientSelect.tomselect.destroy();
                }

                fetch(url)
                    .then(response => {
                        if (!response.ok) throw new Error('Error en la respuesta de clientes');
                        return response.json();
                    })
                    .then(data => {
                        // Guardar clientes globalmente
                        window.clients = data || [];

                        // Limpiar selects
                        clientSelect.innerHTML = '';
                        mobileClientSelect.innerHTML = '';

                        // Agregar <option> (solo clientes reales, nada de "Seleccionar cliente")
                        data.forEach(client => {
                            const option = document.createElement('option');
                            option.value = client.id;
                            const displayName = `${client.nombre || ''}${client.paterno ? ' ' + client.paterno : ''}${client.materno ? ' ' + client.materno : ''}`.trim();
                            option.textContent = displayName || (`Cliente ${client.id}`);
                            option.setAttribute('data-client', JSON.stringify(client));
                            clientSelect.appendChild(option);
                            mobileClientSelect.appendChild(option.cloneNode(true));
                        });

                        // Helper para actualizar la tarjeta de cliente
                        function updateClientInfo(clientId) {
                            const cardDesktop = document.getElementById('client-info-card');
                            const cardMobile = document.getElementById('mobile-client-info-card');

                            // Si no hay cliente o es Cliente General (id=1) → ocultar tarjetas
                            if (!clientId || Number(clientId) === 1) {
                                if (cardDesktop) cardDesktop.classList.add('d-none');
                                if (cardMobile) cardMobile.classList.add('d-none');
                                return;
                            }

                            // Buscar cliente en el array global
                            let client = (window.clients || []).find(c => String(c.id) === String(clientId)) || null;
                            if (!client) return;

                            // Desktop elements
                            if (cardDesktop) {
                                cardDesktop.classList.remove('d-none');
                                cardDesktop.classList.add('client-info-box');
                                document.getElementById('client-name').textContent =
                                    `${client.nombre || ''} ${client.paterno || ''} ${client.materno || ''}`.trim() || '-';
                                document.getElementById('client-ci').textContent = client.ci || '-';
                                document.getElementById('client-phone').textContent = client.telefono || '-';
                            }

                            // Mobile elements
                            if (cardMobile) {
                                cardMobile.classList.remove('d-none');
                                cardMobile.classList.add('client-info-box');
                                document.getElementById('mobile-client-name').textContent =
                                    `${client.nombre || ''} ${client.paterno || ''} ${client.materno || ''}`.trim() || '-';
                                document.getElementById('mobile-client-ci').textContent = client.ci || '-';
                                document.getElementById('mobile-client-phone').textContent = client.telefono || '-';
                            }
                        }

                        // Construir opciones para TomSelect
                        const tomOptions = data.map(c => ({
                            value: c.id,
                            text: `${c.nombre || ''}${c.paterno ? ' ' + c.paterno : ''}${c.ci ? ' — CI: ' + c.ci : ''}`,
                            raw: c
                        }));

                        // Inicializar TomSelect Escritorio
                        window.tsClient = new TomSelect(clientSelect, {
                            options: tomOptions,
                            valueField: "value",
                            labelField: "text",
                            searchField: ["text", "raw.ci", "raw.nombre", "raw.paterno", "raw.telefono"],
                            maxOptions: 100,
                            preload: true,
                            onChange: function(value) {
                                updateClientInfo(value);
                            },
                            onInitialize: function() {
                                if (tomOptions.length > 0) {
                                    // Buscar cliente con id = 1
                                    const generalClient = tomOptions.find(opt => Number(opt.value) === 1);

                                    if (generalClient) {
                                        this.setValue(generalClient.value);
                                        updateClientInfo(generalClient.value);
                                    } else {
                                        // fallback al primer cliente
                                        this.setValue(tomOptions[0].value);
                                        updateClientInfo(tomOptions[0].value);
                                    }
                                }
                            }
                        });

                        // Inicializar TomSelect Móvil
                        window.tsMobileClient = new TomSelect(mobileClientSelect, {
                            options: tomOptions,
                            valueField: "value",
                            labelField: "text",
                            searchField: ["text", "raw.ci", "raw.nombre", "raw.paterno", "raw.telefono"],
                            maxOptions: 100,
                            preload: true,
                            onChange: function(value) {
                                updateClientInfo(value);
                            },
                            onInitialize: function() {
                                if (tomOptions.length > 0) {
                                    // Buscar cliente con id = 1
                                    const generalClient = tomOptions.find(opt => Number(opt.value) === 1);

                                    if (generalClient) {
                                        this.setValue(generalClient.value);
                                        updateClientInfo(generalClient.value);
                                    } else {
                                        // fallback al primer cliente
                                        this.setValue(tomOptions[0].value);
                                        updateClientInfo(tomOptions[0].value);
                                    }
                                }
                            }
                        });

                        // Fallback: eventos change normales
                        clientSelect.onchange = function() {
                            updateClientInfo(this.value);
                        };
                        mobileClientSelect.onchange = function() {
                            updateClientInfo(this.value);
                        };
                    })
                    .catch(error => {
                        console.error('Error cargando clientes:', error);
                    });
            }




            // Función para renderizar productos nuevos
            function renderNewProducts() {
                const container = document.getElementById('new-products-container');
                const startIndex = (currentPageNew - 1) * productsPerPage;
                const endIndex = startIndex + productsPerPage;
                const productsToShow = allProducts.slice(startIndex, endIndex);

                renderProducts(productsToShow, container);
            }

            // Función para renderizar productos más vendidos
            function renderBestSellers() {
                const container = document.getElementById('best-sellers-container');

                // Simular productos más vendidos (en una implementación real, esto vendría del backend)
                const bestSellers = [...allProducts].sort((a, b) => {
                    // Ordenar por algún criterio de ventas (aquí simulamos con ID)
                    return b.id - a.id;
                }).slice(0, productsPerPage);

                renderProducts(bestSellers, container);
            }

            // Función para cargar más productos nuevos
            function loadMoreNewProducts() {
                currentPageNew++;
                renderNewProducts();
            }

            // Función para cargar más productos más vendidos
            function loadMoreBestSellers() {
                currentPageBest++;

                const container = document.getElementById('best-sellers-container');
                const startIndex = (currentPageBest - 1) * productsPerPage;
                const endIndex = startIndex + productsPerPage;

                // Simular más productos más vendidos
                const moreBestSellers = [...allProducts].sort((a, b) => {
                    return b.id - a.id;
                }).slice(startIndex, endIndex);

                appendProducts(moreBestSellers, container);
            }

            // Función para renderizar productos
            function renderProducts(products, container) {
                container.innerHTML = '';

                if (products.length === 0) {
                    container.innerHTML = '<div class="col-12 text-center py-4"><p>No hay productos disponibles</p></div>';
                    return;
                }

                products.forEach(product => {
                    const productElement = createProductElement(product);
                    container.appendChild(productElement);
                });
            }

            // Función para añadir productos al contenedor existente
            function appendProducts(products, container) {
                products.forEach(product => {
                    const productElement = createProductElement(product);
                    container.appendChild(productElement);
                });
            }

   function loadCategories() {
        // En una implementación real, esto vendría de tu API
        const categories = [
            { id: 1, name: 'Electrónicos', count: 12 },
            { id: 2, name: 'Hogar y Jardín', count: 8 },
            { id: 3, name: 'Ropa y Accesorios', count: 15 },
            { id: 4, name: 'Deportes', count: 6 },
            { id: 5, name: 'Juguetes', count: 9 },
            { id: 6, name: 'Salud y Belleza', count: 11 }
        ];
        
        const filtersContainer = document.getElementById('category-filters');
        
        categories.forEach(category => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-sm';
            button.innerHTML = `${category.name} <span class="badge bg-light text-dark ms-1">${category.count}</span>`;
            button.dataset.category = category.id;
            
            button.addEventListener('click', function() {
                // Remover clase active de todos los botones
                document.querySelectorAll('#category-filters .btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Agregar clase active al botón clickeado
                this.classList.add('active');
                
                // Filtrar productos por categoría
                filterProductsByCategory(this.dataset.category);
            });
            
            filtersContainer.appendChild(button);
        });
    }
    
    // Función para filtrar productos por categoría
    function filterProductsByCategory(categoryId) {
        const productCards = document.querySelectorAll('.product-card');
        let visibleCount = 0;
        
        productCards.forEach(card => {
            const productCategory = card.dataset.category;
            
            if (categoryId === 'all' || productCategory === categoryId) {
                card.style.display = 'block';
                visibleCount++;
                
                // Animación de aparición
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 100);
            } else {
                card.style.display = 'none';
            }
        });
        
        // Mostrar mensaje si no hay productos
        const containers = ['new-products-container', 'best-sellers-container'];
        containers.forEach(containerId => {
            const container = document.getElementById(containerId);
            const noProductsMsg = container.querySelector('.no-products-message');
            
            if (visibleCount === 0 && !noProductsMsg) {
                const message = document.createElement('div');
                message.className = 'col-12 no-products-message';
                message.innerHTML = `
                    <div class="text-center py-5">
                        <i class="bx bx-package fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">No se encontraron productos</h5>
                        <p class="text-muted">No hay productos disponibles en esta categoría.</p>
                    </div>
                `;
                container.appendChild(message);
            } else if (noProductsMsg && visibleCount > 0) {
                noProductsMsg.remove();
            }
        });
    }
    
    // Función para crear elemento de producto mejorado
    function createProductElement(product) {
        const col = document.createElement('div');
        col.className = 'col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4'; // Más ancho
        
        // Determinar clases de stock
        let stockClass = '';
        let stockText = '';
        
        if (product.stock > 10) {
            stockText = `📦 ${product.stock} disponibles`;
        } else if (product.stock > 0) {
            stockClass = 'low-stock';
            stockText = `⚠️ Solo ${product.stock}`;
        } else {
            stockClass = 'out-of-stock';
            stockText = '❌ Sin stock';
        }
        
        // Determinar si mostrar precio original (para productos con descuento)
        const hasDiscount = product.original_price && product.original_price > product.price;
        const discountPercent = hasDiscount ? 
            Math.round((1 - product.price / product.original_price) * 100) : 0;
        
        // Verificar si es producto destacado
        const isFeatured = product.featured || Math.random() > 0.8; // Ejemplo aleatorio
        
        col.innerHTML = `
            <div class="product-card ${isFeatured ? 'featured' : ''}" 
                 data-product-id="${product.id}" 
                 data-category="${product.category_id || ''}">
                
                <div class="product-image">
                    <img src="${product.image || defaultImage}" 
                         alt="${product.name}"
                         onerror="this.src='${defaultImage}'"
                         onload="this.classList.add('loaded')">
                    
                    <div class="product-badges">
                        ${product.is_new ? '<span class="badge new">Nuevo</span>' : ''}
                        ${hasDiscount ? `<span class="badge discount">-${discountPercent}%</span>` : ''}
                        ${product.category ? `<span class="badge category">${product.category}</span>` : ''}
                    </div>
                    
                    <span class="stock-chip ${stockClass}">${stockText}</span>
                </div>
                
                <div class="card-body">
                    <!-- Sección de título destacado -->
                    <div class="product-title-section">
                        <span class="category">${product.category || 'General'}</span>
                        <div class="title">${product.name}</div>
                    </div>
                    
                    <!-- Sección de información del producto -->
                    <div class="product-info-section">
                        ${product.description ? `
                            <div class="description">
                                ${product.description}
                            </div>
                        ` : ''}
                        
                        <div class="product-meta">
                            <div class="meta-item">
                                <span class="meta-label">Código:</span>
                                <span class="meta-value">${product.codigo || 'N/A'}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Marca:</span>
                                <span class="meta-value">${product.brand || 'Genérica'}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">SKU:</span>
                                <span class="meta-value">${product.sku || product.id}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sección de precio y acción -->
                    <div class="product-action-section">
                        <div class="price-container">
                            <div>
                                <span class="current-price">Bs/ ${product.price.toFixed(2)}</span>
                                ${hasDiscount ? `
                                    <span class="original-price">Bs/ ${product.original_price.toFixed(2)}</span>
                                ` : ''}
                            </div>
                            ${hasDiscount ? `
                                <div class="price-note">
                                    <i class="bx bx-time-five"></i> Oferta por tiempo limitado
                                </div>
                            ` : ''}
                        </div>
                        
                        <button class="btn btn-add add-to-cart" ${product.stock === 0 ? 'disabled' : ''}>
                            <i class="bx bx-cart-add fs-5"></i> 
                            ${product.stock === 0 ? 'SIN STOCK' : 'AGREGAR AL CARRITO'}
                        </button>
                    </div>
                </div>
            </div>
        `;

        // Agregar evento para añadir al carrito
        const addButton = col.querySelector('.add-to-cart');
        if (product.stock > 0) {
            addButton.addEventListener('click', function(e) {
                e.stopPropagation();
                addToCart(product);
                
                // Animación de confirmación mejorada
                this.innerHTML = '<i class="bx bx-check fs-5"></i> AGREGADO';
                this.classList.add('added-to-cart');
                this.style.background = 'linear-gradient(45deg, var(--success-color), #17a673)';
                
                setTimeout(() => {
                    this.innerHTML = '<i class="bx bx-cart-add fs-5"></i> AGREGAR AL CARRITO';
                    this.classList.remove('added-to-cart');
                    this.style.background = '';
                }, 1500);
            });
        }
        
        // Agregar evento para mostrar detalles del producto
        col.querySelector('.product-card').addEventListener('click', function(e) {
            if (!e.target.closest('.btn-add')) {
                showProductDetails(product);
            }
        });

        return col;
    }
    
    // Función para optimizar carga de imágenes
    function optimizeImageLoading() {
        const images = document.querySelectorAll('.product-image img');
        images.forEach(img => {
            if (!img.complete) {
                img.parentElement.classList.add('loading');
            }
        });
    }
    
    // Inicializar categorías y optimizaciones
    loadCategories();
    setTimeout(optimizeImageLoading, 100);

            // Función para buscar productos
            function searchProducts() {
                const searchTerm = document.getElementById('product-search').value.toLowerCase();

                if (searchTerm.length > 2) {
                    // URL del endpoint para búsqueda - REEMPLAZAR CON TU ENDPOINT
                    const url = `/producto/search?query=${encodeURIComponent(searchTerm)}`;

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            const newProductsContainer = document.getElementById('new-products-container');
                            const bestSellersContainer = document.getElementById('best-sellers-container');

                            renderProducts(data, newProductsContainer);
                            renderProducts(data, bestSellersContainer);
                        })
                        .catch(error => console.error('Error:', error));
                } else if (searchTerm.length === 0) {
                    // Si la búsqueda está vacía, recargar los productos originales
                    currentPageNew = 1;
                    currentPageBest = 1;
                    renderNewProducts();
                    renderBestSellers();
                }
            }

            // Función para añadir producto al carrito
            function addToCart(product) {
                const existingItem = cart.find(item => item.id === product.id);
                const empresaId = "{{ session('empresa_id') }}"; // Obtener empresa_id desde Blade

                if (existingItem) {
                    if (existingItem.quantity < product.stock) {
                        existingItem.quantity++;
                    } else {
                        showAlert('No hay suficiente stock disponible', 'warning');
                        return;
                    }
                } else {
                    if (product.stock > 0) {
                        cart.push({
                            id: product.id,
                            name: product.name,
                            price: product.price,
                            quantity: 1,
                            stock: product.stock
                        });
                    } else {
                        showAlert('Producto sin stock', 'warning');
                        return;
                    }
                }

                updateCart();
                updateMobileCartCount();

                // Si el método de pago es QR, mostrar el modal
                if (paymentMethodSelect.value === 'qr') {
                    showQrModal(empresaId);
                }
            }

            // Función para actualizar el carrito
            function updateCart() {
                updateCartUI(
                    cartItemsContainer,
                    subtotalElement,
                    document.getElementById('discount-input'),
                    totalElement,
                    document.getElementById('billete'),
                    document.getElementById('cambio')
                );

                updateCartUI(
                    mobileCartItemsContainer,
                    mobileSubtotalElement,
                    document.getElementById('mobile-discount-input'),
                    mobileTotalElement,
                    document.getElementById('mobile-billete'),
                    document.getElementById('mobile-cambio')
                );
            }

            // Función para actualizar la UI del carrito
            function updateCartUI(container, subtotalEl, discountEl, totalEl, billeteInput, cambioEl) {
                if (cart.length === 0) {
                    container.innerHTML = `
                        <div class="cart-empty text-center text-muted">
                            <i class="fa fa-shopping-cart fa-lg mb-1" aria-hidden="true"></i>
                            <p class="mb-0 text-sm">No hay productos en el carrito</p>
                        </div>
                    `;

                    subtotalEl.textContent = 'Bs/ 0.00';
                    discountEl.value = 0;
                    totalEl.textContent = 'Bs/ 0.00';
                    if (cambioEl) cambioEl.textContent = 'Bs/ 0.00';
                    return;
                }

                let subtotal = 0;
                let cartHTML = '';

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    subtotal += itemTotal;

                    cartHTML += `
                        <div class="cart-line">
                            <div class="cart-line__info">
                                <div class="cart-line__title">${item.name}</div>
                                <div class="cart-line__meta">
                                    <span>Bs/ ${item.price.toFixed(2)} c/u</span>
                                    <span>|</span>
                                    <span>Stock: ${item.stock}</span>
                                </div>
                            </div>
                            <div class="cart-line__actions">
                                <div class="qty-pill">
                                    <button type="button" class="qty-btn decrease-quantity" data-id="${item.id}">-</button>
                                    <span class="qty-pill__value">${item.quantity}</span>
                                    <button type="button" class="qty-btn increase-quantity" data-id="${item.id}">+</button>
                                </div>
                                <div class="cart-line__total">Bs/ ${itemTotal.toFixed(2)}</div>
                                <button type="button" class="icon-btn remove-item" data-id="${item.id}" aria-label="Quitar producto">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });

                // 🔹 descuento desde input
                const discount = parseFloat(discountEl.value || 0);
                const total = subtotal - discount;

                container.innerHTML = cartHTML;
                subtotalEl.textContent = `Bs/ ${subtotal.toFixed(2)}`;
                totalEl.textContent = `Bs/ ${total.toFixed(2)}`;

                // 🔹 calcular cambio si hay billete
                if (billeteInput && cambioEl) {
                    const billete = parseFloat(billeteInput.value || 0);
                    const cambio = billete > 0 ? billete - total : 0;
                    cambioEl.textContent = `Bs/ ${cambio.toFixed(2)}`;
                }

                // Eventos
                container.querySelectorAll('.increase-quantity').forEach(btn => {
                    btn.addEventListener('click', () => increaseQuantity(parseInt(btn.dataset.id)));
                });
                container.querySelectorAll('.decrease-quantity').forEach(btn => {
                    btn.addEventListener('click', () => decreaseQuantity(parseInt(btn.dataset.id)));
                });
                container.querySelectorAll('.remove-item').forEach(btn => {
                    btn.addEventListener('click', () => removeFromCart(parseInt(btn.dataset.id)));
                });
            }

            // Función para actualizar contador móvil
            function updateMobileCartCount() {
                const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
                mobileCartCount.textContent = totalItems;
            }

            // Función para aumentar cantidad
            function increaseQuantity(productId) {
                const item = cart.find(item => item.id === productId);
                if (item && item.quantity < item.stock) {
                    item.quantity++;
                    updateCart();
                    updateMobileCartCount();
                } else {
                    showAlert('No hay suficiente stock disponible', 'warning');
                }
            }

            // Función para disminuir cantidad
            function decreaseQuantity(productId) {
                const item = cart.find(item => item.id === productId);
                if (item && item.quantity > 1) {
                    item.quantity--;
                    updateCart();
                    updateMobileCartCount();
                } else {
                    removeFromCart(productId);
                }
            }

            // Función para eliminar producto del carrito
            function removeFromCart(productId) {
                cart = cart.filter(item => item.id !== productId);
                updateCart();
                updateMobileCartCount();
            }

            // Función para mostrar modal de QR
            const empresaId = document.getElementById('empresa_id').value;
            console.log('Empresa ID para QR:', empresaId);

            function showQrModal(empresaId) {
                fetch(`/empresa/${empresaId}/qr`)
                    .then(res => res.json())
                    .then(data => {
                        const qrImage = document.getElementById('qr-image');
                        if (data.qr_url) {
                            qrImage.src = data.qr_url;
                        } else {
                            qrImage.src = 'https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=SinQR';
                        }
                        qrModal.show();
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('No se pudo cargar el QR', 'danger');
                    });
            }

            // Función para confirmar pago con QR
            function confirmQrPayment() {
                qrModal.hide();
                completeSale();
            }

            // Función para completar la venta con confirmación SweetAlert2
            async function completeSale() {
                if (cart.length === 0) {
                    showAlert('Agrega al menos un producto para realizar la venta', 'warning');
                    return;
                }

                const clientId = clientSelect.value;
                const almacenId = document.getElementById('almacen-select').value; // 📌 almacén seleccionado
                if (!clientId) {
                    showAlert('Selecciona un cliente para continuar', 'warning');
                    return;
                }
                if (!almacenId) {
                    showAlert('Selecciona un almacén para continuar', 'warning');
                    return;
                }

                const paymentMethod = paymentMethodSelect.value;
                // Detectar el select visible o disponible
                const saleTypeElement = document.getElementById('sale-type') || document.getElementById('mobile-sale-type');
                const saleType = saleTypeElement.value; // "contado" o "credito"


                const saleData = {
                    client_id: clientId,
                    almacen_id: almacenId,
                    payment_method: paymentMethod,
                    sale_type: saleType,
                    items: cart,
                    date: document.getElementById('sale-date').value,
                    subtotal: parseFloat(document.getElementById('subtotal').textContent.replace(/[^\d.-]/g, '')) || 0,
                    descuento: parseFloat(document.getElementById('discount-input').value) || 0, // 👈 cuidado con el id
                    total: parseFloat(document.getElementById('total').textContent.replace(/[^\d.-]/g, '')) || 0,
                    billete: parseFloat(document.getElementById('billete').value) || 0,
                    cambio: parseFloat(document.getElementById('cambio').textContent.replace(/[^\d.-]/g, '')) || 0,
                };
                console.log('Datos de la venta:', saleData);
                if (saleType === 'credito') {
                    saleData.due_date = document.getElementById('due-date').value;
                    saleData.installments = document.getElementById('installments').value;

                    if (!saleData.due_date) {
                        showAlert('Ingresa la fecha de plazo para crédito', 'warning');
                        return;
                    }
                }

                // 🔹 Confirmación antes de registrar la venta
                const confirm = await Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Se registrará la venta. ¿Deseas continuar?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, registrar venta',
                    cancelButtonText: 'Cancelar'
                });

                if (confirm.isConfirmed) {
                    try {
                        const response = await fetch('/venta/store', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify(saleData)
                        });

                        const result = await response.json();

                        if (result.success) {
                            // 🔹 Mostrar segundo SweetAlert para elegir acción
                            const nextAction = await Swal.fire({
                                title: 'Venta registrada',
                                text: result.message,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Seguir registrando ventas',
                                cancelButtonText: 'Ir a la lista de ventas'
                            });

                            // 🔹 Limpiar carrito y recargar productos
                            loadProducts(almacenId);
                            cart = [];
                            updateCart();
                            updateMobileCartCount();
                            resetForm();
                            if (mobileCartSidebar.classList.contains('active')) {
                                toggleMobileCart();
                            }

                            if (!nextAction.isConfirmed) {
                                // Redirigir a lista de ventas
                                window.location.href = '/venta/registradas';
                            }

                        } else {
                            showAlert(result.message || 'Ocurrió un error al registrar la venta', 'danger');
                            console.error(result.error);
                        }
                    } catch (error) {
                        console.error('Error al enviar la venta:', error);
                        showAlert('Error al registrar la venta. Intenta nuevamente.', 'danger');
                    }
                }
            }


            // Función para resetear formulario
            function resetForm() {
                clientSelect.value = '';
                mobileClientSelect.value = '';
                clientInfoCard.classList.add('d-none');
                mobileClientInfoCard.classList.add('d-none');
                paymentMethodSelect.value = 'cash';
                mobilePaymentMethodSelect.value = 'cash';
                saleTypeSelect.value = 'cash';
                mobileSaleTypeSelect.value = 'cash';
                document.getElementById('due-date').value = '';
                document.getElementById('mobile-due-date').value = '';
                document.getElementById('installments').value = '1';
                document.getElementById('mobile-installments').value = '1';

                // Ocultar campos de crédito
                creditFields.style.maxHeight = '0';
                mobileCreditFields.style.maxHeight = '0';
            }

            // Función para mostrar/ocultar campos de crédito
            function toggleCreditFields() {
                if (this.value === 'credito') {
                    creditFields.style.maxHeight = creditFields.scrollHeight + 'px';
                } else {
                    creditFields.style.maxHeight = '0';
                }
            }

            // Función para mostrar/ocultar campos de crédito móviles
            function toggleMobileCreditFields() {
                if (this.value === 'credito') {
                    mobileCreditFields.style.maxHeight = mobileCreditFields.scrollHeight + 'px';
                } else {
                    mobileCreditFields.style.maxHeight = '0';
                }
            }

            // Función para manejar cambio de método de pago
            function handlePaymentMethodChange() {
                if (this.value === 'qr' && cart.length > 0) {
                    showQrModal(empresaId);
                }
            }

            // Función para manejar cambio de método de pago móvil
            function handleMobilePaymentMethodChange() {
                if (this.value === 'qr' && cart.length > 0) {
                    showQrModal(empresaId);
                }
            }

            // Función para actualizar información del cliente
            function updateClientInfo() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const clientData = JSON.parse(selectedOption.getAttribute('data-client') || '{}');
                    document.getElementById('client-name').textContent = clientData.nombre || '-';
                    document.getElementById('client-ci').textContent = clientData.ci || '-';
                    document.getElementById('client-phone').textContent = clientData.telefono || '-';
                    clientInfoCard.classList.remove('d-none');
                } else {
                    clientInfoCard.classList.add('d-none');
                }
            }

            // Función para actualizar información del cliente móvil
            function updateMobileClientInfo() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const clientData = JSON.parse(selectedOption.getAttribute('data-client') || '{}');
                    document.getElementById('mobile-client-name').textContent = clientData.nombre || '-';
                    document.getElementById('mobile-client-ci').textContent = clientData.ci || '-';
                    document.getElementById('mobile-client-phone').textContent = clientData.telefono || '-';
                    mobileClientInfoCard.classList.remove('d-none');
                } else {
                    mobileClientInfoCard.classList.add('d-none');
                }
            }

            // Función para mostrar/ocultar carrito móvil
            function toggleMobileCart() {
                mobileCartSidebar.classList.toggle('active');
            }

            // Función para mostrar alertas
            function showAlert(message, type) {
                // Crear elemento de alerta
                const toastEl = document.querySelector('.bs-toast');
                toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
                toastEl.querySelector('.toast-body').textContent = message;
                const toast = new bootstrap.Toast(toastEl);
                toast.show();

                // Auto-eliminar después de 5 segundos
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 5000);
            }

            // Ajustes para dispositivos móviles
            function adjustForMobile() {
                if (window.innerWidth <= 768) {
                    document.querySelector('.card-body').classList.add('p-2');
                    document.querySelectorAll('.product-card').forEach(card => {
                        card.style.fontSize = '0.8rem';
                    });
                }
            }

            // Inicializar ajustes para móviles
            adjustForMobile();
            window.addEventListener('resize', adjustForMobile);
            // Variables para capturar el código escaneado
            // Variables para capturar el código escaneado
            let barcode = '';
            let barcodeTimer;

            // Escuchar teclas globalmente
            document.addEventListener('keydown', function(e) {
                if (barcodeTimer) {
                    clearTimeout(barcodeTimer);
                }

                // Si presionan Enter, procesar el código
                if (e.key === 'Enter') {
                    if (barcode.length > 0) {
                        processBarcode(barcode);
                        barcode = ''; // resetear
                    }
                    e.preventDefault();
                    return;
                }

                // Solo números y letras
                if (/^[a-zA-Z0-9]$/.test(e.key)) {
                    barcode += e.key;
                }

                // Si no se escribe nada en 200ms, reseteamos (previene errores)
                barcodeTimer = setTimeout(() => {
                    barcode = '';
                }, 200);
            });

            // Función que consulta la base de datos y agrega al carrito
            async function processBarcode(code) {
                try {
                    const response = await fetch(`/buscar-producto/${code}`);
                    if (!response.ok) {
                        showAlert('Error en la búsqueda', 'danger');
                        return;
                    }

                    let product = await response.json();

                    if (product) {
                        // 🔹 Convertimos price y stock a números
                        product.price = parseFloat(product.price);
                        product.stock = parseFloat(product.stock);

                        // Ahora addToCart puede usar .toFixed sin errores
                        addToCart(product);
                    } else {
                        showAlert('Producto no encontrado', 'warning');
                    }
                } catch (error) {
                    showAlert('Error al procesar el código: ' + error.message, 'danger');
                }
            }
            document.getElementById('newClientForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const form = e.target;
                const formData = new FormData(form);

                try {
                    const res = await fetch("{{ route('clientes.store') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });
                    const data = await res.json();
                    if (data.success) {
                        // Agregar nuevo cliente al select
                        const select = document.getElementById('client-select');
                        const option = document.createElement('option');
                        option.value = data.cliente.id;
                        option.textContent = data.cliente.nombre + (data.cliente.paterno ? ' ' + data.cliente.paterno : '');
                        select.appendChild(option);
                        select.value = data.cliente.id;

                        // Cerrar modal
                        bootstrap.Modal.getInstance(document.getElementById('newClientModal')).hide();

                        // Opcional: mostrar mensaje
                        showAlert(data.message, 'success');
                        loadClients(); // recargar clientes para actualizar TomSelect
                    }
                } catch (err) {
                    console.error(err);
                    showAlert('Error al registrar cliente', 'danger');
                }
            });
            const floatingSaleCartBtn = document.getElementById("floating-sale-cart-btn");
            const floatingSaleCartCount = document.getElementById("floating-sale-cart-count");

            // 👉 Evento: abrir sidebar desde el botón flotante
            floatingSaleCartBtn.addEventListener("click", () => {
                mobileCartSidebar.classList.add("active");
                mobileCartOverlay.classList.add("active");
            });

            // 👉 Evento: cerrar sidebar
            closeMobileCart.addEventListener("click", () => {
                mobileCartSidebar.classList.remove("active");
                mobileCartOverlay.classList.remove("active");
            });
            mobileCartOverlay.addEventListener("click", () => {
                mobileCartSidebar.classList.remove("active");
                mobileCartOverlay.classList.remove("active");
            });
            // 👉 Mostrar/ocultar botón con scroll
            window.addEventListener("scroll", () => {
                if (window.scrollY > 100) {
                    floatingSaleCartBtn.classList.add("show");
                } else {
                    floatingSaleCartBtn.classList.remove("show");
                }
            });
            // 👉 Función: actualizar contador de productos
            function updateMobileCartCount() {
                const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);

                // 👉 contador flotante
                if (document.getElementById("floating-sale-cart-count")) {
                    const floatingCount = document.getElementById("floating-sale-cart-count");
                    floatingCount.textContent = totalItems;
                    if (totalItems > 0) {
                        floatingCount.classList.add("active");
                    } else {
                        floatingCount.classList.remove("active");
                    }
                }

                // 👉 contador del botón "Ver Carrito"
                if (document.getElementById("mobile-cart-count")) {
                    const toggleCount = document.getElementById("mobile-cart-count");
                    toggleCount.textContent = totalItems;
                }
            }
            // ...
            loadProducts();
            loadClients();
        });
    </script>
    <script>

    </script>
</x-layout>
