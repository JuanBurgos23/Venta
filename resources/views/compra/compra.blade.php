<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
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
                        <h6 class="mb-1 font-weight-bolder">Registro de Ingreso a Inventario</h6>
                        <p class="text-sm mb-0 text-secondary d-flex flex-wrap">
                            <span class="d-flex align-items-center me-3">
                                <i class="fa fa-user me-1" aria-hidden="true"></i>
                                Almacenero: <span id="warehouse-manager" class="ms-1 fw-bold">{{ Auth::user()->name ?? 'Usuario' }}</span>
                            </span>
                            <span class="d-flex align-items-center">
                                <i class="fa fa-calendar me-1" aria-hidden="true"></i>
                                <input type="date" class="form-control form-control-sm border-0 bg-transparent p-0 ms-1 text-dark" id="entry-date" value="{{ date('Y-m-d') }}" style="width: auto; display: inline-block;">
                            </span>
                        </p>
                    </div>
                    <div class="card-body p-3 pt-4">
                        <!-- Botón para abrir detalles en móvil -->
                        <div class="d-lg-none d-block mb-4">
                            <button class="btn btn-primary w-100 d-flex align-items-center justify-content-center" id="mobile-details-toggle">
                                <i class="fa fa-list me-2" aria-hidden="true"></i>
                                Ver Detalles
                                <span class="badge bg-white text-primary ms-2" id="mobile-products-count">0</span>
                            </button>
                        </div>

                        <div class="row">
                            <!-- Panel de información - Columna izquierda -->
                            <div class="col-lg-8 col-md-7 mb-4 mb-md-0">
                                <div class="card card-body border-radius-lg shadow-none border-dashed mb-4">
                                    <h6 class="mb-3 font-weight-bolder">Información del Ingreso</h6>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-sm">Tipo Inventario</label>
                                            <select class="form-select px-3" id="inventory-type" style="min-height: 44px;">
                                                <option value="finished">Producto terminado</option>
                                                <option value="raw">Materia prima</option>
                                                <option value="supplies">Insumos</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-sm">Motivo</label>
                                            <select class="form-select px-3" id="reason" style="min-height: 44px;">
                                                <option value="purchase">Compra</option>
                                                <option value="transfer">Traslado</option>
                                                <option value="production">Producción</option>
                                                <option value="adjustment">Ajuste</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-sm">Proveedor</label>
                                            <div class="d-flex">
                                                <select class="form-select px-3" id="supplier-select" style="min-height: 44px; flex: 1;">
                                                    <!-- Los proveedores se cargarán aquí mediante JavaScript -->
                                                </select>
                                                <button class="btn btn-outline-primary ms-2" id="new-supplier-btn" style="width: 38px; height: 38px; padding: 0; font-size: 1.2rem;">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-sm">Almacén</label>
                                            <div class="d-flex">
                                                <select class="form-select px-3" id="warehouse-select" style="min-height: 44px; flex: 1;">
                                                    <!-- Los almacenes se cargarán aquí mediante JavaScript -->
                                                </select>
                                                <button class="btn btn-outline-primary ms-2" id="new-warehouse-btn" style="width: 38px; height: 38px; padding: 0; font-size: 1.2rem;">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-sm">Forma de pago</label>
                                            <select class="form-select px-3" id="payment-form" style="min-height: 44px;">
                                                <option value="cash">Contado</option>
                                                <option value="credit">Crédito</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-sm">Tipo de pago</label>
                                            <select class="form-select px-3" id="payment-type" style="min-height: 44px;">
                                                <option value="cash">Efectivo</option>
                                                <option value="transfer">Transferencia</option>
                                                <option value="check">Cheque</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-sm">¿Esta compra tiene factura?</label>
                                            <div class="d-flex mt-2">
                                                <div class="form-check me-3">
                                                    <input class="form-check-input" type="radio" name="hasInvoice" id="hasInvoiceYes" value="yes">
                                                    <label class="form-check-label" for="hasInvoiceYes">Sí</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hasInvoice" id="hasInvoiceNo" value="no" checked>
                                                    <label class="form-check-label" for="hasInvoiceNo">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3 invoice-number-container" style="overflow: hidden; max-width: 0; transition: max-width 0.5s ease, opacity 0.5s ease; opacity: 0;">
                                            <label class="form-label text-sm">N° Factura</label>
                                            <input type="text" class="form-control" id="invoice-number" placeholder="Número de factura">
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            const hasInvoiceYes = document.getElementById("hasInvoiceYes");
                                            const hasInvoiceNo = document.getElementById("hasInvoiceNo");
                                            const invoiceContainer = document.querySelector(".invoice-number-container");

                                            function toggleInvoiceInput() {
                                                if (hasInvoiceYes.checked) {
                                                    // Mostrar con animación
                                                    invoiceContainer.style.maxWidth = "100%";
                                                    invoiceContainer.style.opacity = "1";
                                                } else {
                                                    // Ocultar con animación
                                                    invoiceContainer.style.maxWidth = "0";
                                                    invoiceContainer.style.opacity = "0";
                                                }
                                            }

                                            // Inicializar según selección por defecto
                                            toggleInvoiceInput();

                                            // Escuchar cambios en los radios
                                            hasInvoiceYes.addEventListener("change", toggleInvoiceInput);
                                            hasInvoiceNo.addEventListener("change", toggleInvoiceInput);
                                        });
                                    </script>
                                    <div class="mb-3">
                                        <label class="form-label text-sm">Observación</label>
                                        <textarea class="form-control" id="observation" rows="2" placeholder="Observaciones adicionales..."></textarea>
                                    </div>
                                </div>

                                <!-- Panel de productos -->
                                <div class="card card-body border-radius-lg shadow-none border-dashed">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0 font-weight-bolder">Lista de Productos</h6>
                                        <a href="{{route('productos.index')}}" class="btn btn-sm btn-outline-primary mb-0" id="add-product-btn">
                                            <i class="fa fa-plus me-1" aria-hidden="true"></i>
                                            Agregar Producto
                                        </a>
                                    </div>

                                    <!-- Select de productos -->
                                    <div class="mb-3">
                                        <select class="form-select" id="product-select">
                                            <option value="">Seleccionar producto...</option>
                                            <!-- Los productos se cargarán aquí mediante JavaScript -->
                                        </select>
                                    </div>

                                    <!-- Detalles del producto seleccionado -->
                                    <div class="card border-radius-lg p-3 mb-3 d-none" id="product-details-card">
                                        <h6 class="mb-2 font-weight-bolder">Detalles del producto:</h6>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <span class="text-sm text-secondary">Tipo de precio:</span>
                                                <span class="text-sm font-weight-bold d-block" id="product-price-type">-</span>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <span class="text-sm text-secondary">Precio:</span>
                                                <span class="text-sm font-weight-bold d-block" id="product-price">-</span>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <span class="text-sm text-secondary">Categoría:</span>
                                                <span class="text-sm font-weight-bold d-block" id="product-category">-</span>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <span class="text-sm text-secondary">Marca:</span>
                                                <span class="text-sm font-weight-bold d-block" id="product-brand">-</span>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <span class="text-sm text-secondary">Modelo:</span>
                                                <span class="text-sm font-weight-bold d-block" id="product-model">-</span>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <span class="text-sm text-secondary">Origen:</span>
                                                <span class="text-sm font-weight-bold d-block" id="product-origin">-</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detalles del ingreso -->
                                    <div class="d-none" id="product-entry-details">
                                        <h6 class="mb-2 font-weight-bolder">Detalle del ingreso</h6>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label text-sm">Lote</label>
                                                <input type="text" class="form-control form-control-sm" id="product-lot" placeholder="Número de lote">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label text-sm">Código</label>
                                                <input type="text" class="form-control form-control-sm" id="product-code" placeholder="Código del producto">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label text-sm">Cantidad</label>
                                                <input type="number" class="form-control form-control-sm" id="product-quantity" min="1" value="1">
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label text-sm">Costo unit.</label>
                                                <input type="number" class="form-control form-control-sm" id="product-unit-cost" min="0" step="0.01" value="0">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label text-sm">Fecha vencimiento</label>
                                                <input type="date" class="form-control form-control-sm" id="product-expiry-date">
                                            </div>
                                            <div class="col-md-6 mb-3 d-flex align-items-end">
                                                <button class="btn btn-sm btn-primary w-100" id="add-to-list-btn">
                                                    <i class="fa fa-cart-plus me-1" aria-hidden="true"></i>
                                                    Agregar a la lista
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabla de productos agregados -->
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover" id="products-table">
                                            <thead>
                                                <tr>
                                                    <th>Lote</th>
                                                    <th>Código</th>
                                                    <th>Producto</th>
                                                    <th>Categoria</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo unit.</th>
                                                    <th>Costo total</th>
                                                    <th>Fecha venc.</th>
                                                    <th>Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Los productos se agregarán aquí mediante JavaScript -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-end fw-bold">Total:</td>
                                                    <td colspan="4" class="fw-bold" id="products-total">Bs/ 0.00</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel de resumen - Columna derecha (Solo escritorio) -->
                            <div class="col-lg-4 col-md-5 d-md-block d-none">
                                <div class="card card-body border-radius-lg shadow-none border-dashed h-100">
                                    <h6 class="mb-3 font-weight-bolder">Resumen del Ingreso</h6>

                                    <!-- Información del proveedor -->
                                    <div class="mb-3">
                                        <label class="form-label text-sm">Proveedor seleccionado</label>
                                        <div class="card border-radius-lg p-3" id="selected-supplier-info">
                                            <div class="text-center text-muted">
                                                <i class="fa fa-building fa-2x mb-2" aria-hidden="true"></i>
                                                <p class="mb-0">No hay proveedor seleccionado</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Información del almacén -->
                                    <div class="mb-3">
                                        <label class="form-label text-sm">Almacén seleccionado</label>
                                        <div class="card border-radius-lg p-3" id="selected-warehouse-info">
                                            <div class="text-center text-muted">
                                                <i class="fa fa-warehouse fa-2x mb-2" aria-hidden="true"></i>
                                                <p class="mb-0">No hay almacén seleccionado</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Resumen de costos -->
                                    <div class="sale-summary mb-3">
                                        <div id="summary-products" class="mb-3">
                                            <!-- Aquí se insertan dinámicamente los productos -->
                                        </div>
                                        <hr class="my-2">
                                        <div class="d-flex justify-content-between fw-bold">
                                            <span class="text-dark">Total:</span>
                                            <span class="text-dark" id="summary-total">Bs/ 0.00</span>
                                        </div>
                                    </div>

                                    <!-- Botón para finalizar ingreso -->
                                    <button class="btn bg-gradient-primary w-100 mt-2 mb-0" id="complete-entry">
                                        <i class="fa fa-check-circle me-1" aria-hidden="true"></i>
                                        Registrar Ingreso
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
    <button id="floating-cart-btn"
        class="btn btn-primary rounded-circle position-fixed d-lg-none shadow-lg"
        style="bottom: 70px; right: 20px; display: none; width: 52px; height: 52px; z-index:1050;">
        <i class="menu-icon icon-base bx bx-cart fs-5"></i>
        <span id="floating-cart-count"
            class="badge bg-danger position-absolute top-0 start-100 translate-middle px-2 py-1">0</span>
    </button>
    <!-- Panel lateral para móviles -->
    <div class="mobile-details-sidebar d-lg-none">
        <div class="mobile-details-overlay" id="mobile-details-overlay"></div>
        <div class="mobile-details-content">
            <div class="mobile-details-header">
                <h6 class="mb-0 font-weight-bolder">Resumen del Ingreso</h6>
                <button class="btn btn-link text-dark p-0" id="close-mobile-details">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="mobile-details-body">
                <!-- Información del proveedor -->
                <div class="mb-3">
                    <label class="form-label text-sm">Proveedor seleccionado</label>
                    <div class="card bg-gray-100 border-radius-lg p-3" id="mobile-selected-supplier-info">
                        <div class="text-center text-muted">
                            <i class="fa fa-building fa-2x mb-2" aria-hidden="true"></i>
                            <p class="mb-0">No hay proveedor seleccionado</p>
                        </div>
                    </div>
                </div>

                <!-- Información del almacén -->
                <div class="mb-3">
                    <label class="form-label text-sm">Almacén seleccionado</label>
                    <div class="card bg-gray-100 border-radius-lg p-3" id="mobile-selected-warehouse-info">
                        <div class="text-center text-muted">
                            <i class="fa fa-warehouse fa-2x mb-2" aria-hidden="true"></i>
                            <p class="mb-0">No hay almacén seleccionado</p>
                        </div>
                    </div>
                </div>

                <!-- Resumen de costos -->
                <div class="sale-summary mb-3">
                    <div id="mobile-summary-products" class="mb-3">
                        <!-- Aquí se insertan dinámicamente los productos -->
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between fw-bold">
                        <span class="text-dark">Total:</span>
                        <span class="text-dark" id="mobile-summary-total">Bs/ 0.00</span>
                    </div>
                </div>

                <!-- Botón para finalizar ingreso -->
                <button class="btn bg-gradient-primary w-100 mt-2 mb-0" id="mobile-complete-entry">
                    <i class="fa fa-check-circle me-1" aria-hidden="true"></i>
                    Registrar Ingreso
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para nuevo proveedor -->
    <div class="modal fade" id="supplierModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Nuevo Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplier-form">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="supplier-name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">RUC</label>
                                <input type="text" class="form-control" id="supplier-ruc">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="supplier-address">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="supplier-phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="supplier-email">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="save-supplier">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para nuevo almacén -->
    <div class="modal fade" id="warehouseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Nuevo Almacén</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="warehouse-form">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="warehouse-name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="warehouse-address">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Responsable</label>
                            <input type="text" class="form-control" id="warehouse-responsible">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="warehouse-phone">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="save-warehouse">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Template Customizer va fuera de main y slot -->
    <!-- Incluir Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>
    <style>
        :root {
            --primary-gradient: linear-gradient(195deg, #42424a, #191919);
            --secondary-gradient: linear-gradient(195deg, #49a3f1, #1A73E8);
        }

        .border-dashed {
            border: 1px dashed #cb0c9f !important;
        }

        /* ====== Estilos para móviles ====== */
        .mobile-details-sidebar {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100%;
            z-index: 9999;
            transition: right 0.3s ease;
        }

        .mobile-details-sidebar.active {
            right: 0;
        }

        .mobile-details-overlay {
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

        .mobile-details-sidebar.active .mobile-details-overlay {
            opacity: 1;
            visibility: visible;
        }

        .mobile-details-content {
            position: absolute;
            top: 0;
            right: 0;
            width: 85%;
            max-width: 400px;
            height: 100%;
            padding: 20px;
            overflow-y: auto;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            border-left: 1px solid rgba(0, 0, 0, 0.1);
        }

        .mobile-details-sidebar.active .mobile-details-content {
            transform: translateX(0);
        }

        .mobile-details-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        /* ====== Tema claro ====== */
        [data-bs-theme="light"] .mobile-details-content {
            background: #fff;
            color: #000;
        }

        /* ====== Tema oscuro ====== */
        [data-bs-theme="dark"] .mobile-details-content {
            background: #1e1e2d;
            color: #f1f1f1;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }


        /* Estilos generales */
        .bg-gray-100 {
            background-color: #f8f9fa !important;
        }

        .border-radius-lg {
            border-radius: 12px;
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

        .table-sm th,
        .table-sm td {
            padding: 0.5rem;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .card-header.bg-transparent {
                background: transparent !important;
            }

            .table-responsive {
                font-size: 0.8rem;
            }
        }

        #floating-cart-btn {
            transition: transform 0.3s ease, opacity 0.3s ease;
            opacity: 0;
            transform: scale(0);
            z-index: 1050;
        }

        /* Animación de entrada (burbuja) */
        #floating-cart-btn.show {
            opacity: 1;
            animation: bubbleIn 0.4s ease forwards;
        }

        /* Animación de salida (pop / reventar) */
        #floating-cart-btn.hide {
            opacity: 0;
            animation: bubbleOut 0.35s ease forwards;
        }

        @keyframes bubbleIn {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            60% {
                transform: scale(1.2);
                opacity: 1;
            }

            80% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes bubbleOut {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            30% {
                transform: scale(1.3);
                opacity: 0.8;
            }

            100% {
                transform: scale(0);
                opacity: 0;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('mobile-details-toggle');
            const closeBtn = document.getElementById('close-mobile-details');
            const sidebar = document.querySelector('.mobile-details-sidebar');
            const overlay = document.getElementById('mobile-details-overlay');

            if (toggleBtn && sidebar && overlay) {
                // Abrir el panel
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.add('active');
                });

                // Cerrar el panel con botón "X"
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        sidebar.classList.remove('active');
                    });
                }

                // Cerrar el panel al hacer clic en el overlay
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('active');
                });
            }
        });
    </script>
    <script>
        function showAlert(message, type) {
            // Crear elemento de alerta
            const toastEl = document.querySelector('.bs-toast');
            toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
            toastEl.querySelector('.toast-body').textContent = message;
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
            @if(session('success'))
            showToast("{{ session('success') }}", 'success');
            @endif

            @if($errors -> any())
            let errorMsg = '';
            @foreach($errors -> all() as $error)
            errorMsg += "{{ $error }}\n";
            @endforeach
            showToast(errorMsg.trim(), 'danger');
            @endif
            // Auto-eliminar después de 5 segundos
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 5000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            let supplierSelect;

            // Inicializar TomSelect
            supplierSelect = new TomSelect("#supplier-select", {
                valueField: "id",
                labelField: "nombre",
                searchField: ["nombre", "ruc"],
                placeholder: "Seleccione un proveedor",
                render: {
                    option: function(item, escape) {
                        return `
                    <div>
                        <strong>${escape(item.nombre)}</strong><br>
                        <small>RUC: ${item.ruc || "N/A"}</small>
                    </div>
                `;
                    },
                    item: function(item, escape) {
                        return `<div>${escape(item.nombre)}</div>`;
                    }
                },
                onChange: function(value) {
                    updateSupplierInfo(value);
                }
            });

            // Función para cargar proveedores desde el backend
            function loadSuppliers() {
                fetch("/proveedores/list") // Ajusta a tu ruta real
                    .then(res => res.json())
                    .then(data => {
                        supplierSelect.clearOptions();
                        supplierSelect.addOptions(data);
                    })
                    .catch(err => console.error("Error cargando proveedores:", err));
            }

            // Función para actualizar el panel de detalle del proveedor
            function updateSupplierInfo(supplierId) {
                const desktopInfoContainer = document.getElementById("selected-supplier-info");
                const mobileInfoContainer = document.getElementById("mobile-selected-supplier-info");
                const supplier = supplierSelect.options[supplierId] || null;

                const content = supplier ? `
        <div>
            <strong>${supplier.nombre || "-"}</strong><br>
            <small>RUC: ${supplier.ruc || "N/A"}</small><br>
            <small>Tel: ${supplier.telefono || "N/A"}</small><br>
            <small>Email: ${supplier.correo || "N/A"}</small>
        </div>
    ` : `
        <div class="text-center text-muted">
            <i class="fa fa-building fa-2x mb-2" aria-hidden="true"></i>
            <p class="mb-0">No hay proveedor seleccionado</p>
        </div>
    `;

                if (desktopInfoContainer) desktopInfoContainer.innerHTML = content;
                if (mobileInfoContainer) mobileInfoContainer.innerHTML = content;
            }

            const supplierModalEl = document.getElementById("supplierModal");
            const supplierForm = document.getElementById("supplier-form");
            const newSupplierBtn = document.getElementById("new-supplier-btn");
            const saveSupplierBtn = document.getElementById("save-supplier");

            // Crear **una sola instancia** del modal
            const supplierModal = new bootstrap.Modal(supplierModalEl);

            // Abrir modal al hacer clic en "+"
            newSupplierBtn.addEventListener("click", function() {
                supplierForm.reset(); // limpiar formulario
                supplierModal.show(); // mostrar modal
            });

            // Guardar nuevo proveedor
            saveSupplierBtn.addEventListener("click", function() {
                const newSupplier = {
                    nombre: document.getElementById("supplier-name").value.trim(),
                    ruc: document.getElementById("supplier-ruc").value.trim(),
                    direccion: document.getElementById("supplier-address").value.trim(),
                    telefono: document.getElementById("supplier-phone").value.trim(),
                    email: document.getElementById("supplier-email").value.trim(),
                };

                // Validar nombre
                if (!newSupplier.nombre) {
                    showAlert("El nombre es obligatorio.", "warning");
                    return;
                }

                fetch("/proveedores/store", { // Ajusta a tu ruta real
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(newSupplier)
                    })
                    .then(res => res.json())
                    .then(saved => {
                        // Agregar al select y seleccionar automáticamente
                        supplierSelect.addOption(saved);
                        supplierSelect.setValue(saved.id);

                        // Cerrar modal usando la misma instancia
                        supplierModal.hide();

                        showAlert("Proveedor guardado exitosamente.", "success");
                        supplierForm.reset();
                    })
                    .catch(err => showAlert("Error guardando proveedor:", "danger"));
            });
            loadSuppliers();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const warehouseSelect = document.getElementById("warehouse-select");
            const newWarehouseBtn = document.getElementById("new-warehouse-btn");
            const saveWarehouseBtn = document.getElementById("save-warehouse");
            const warehouseForm = document.getElementById("warehouse-form");
            const warehouseModal = new bootstrap.Modal(document.getElementById("warehouseModal"));

            // Abrir modal de nuevo almacén
            newWarehouseBtn.addEventListener("click", function() {
                warehouseForm.reset();
                warehouseModal.show();
            });

            // Guardar nuevo almacén
            saveWarehouseBtn.addEventListener("click", function() {
                const name = document.getElementById("warehouse-name").value.trim();
                const address = document.getElementById("warehouse-address").value.trim();
                const responsible = document.getElementById("warehouse-responsible").value.trim();
                const phone = document.getElementById("warehouse-phone").value.trim();

                if (!name) {
                    showAlert("El nombre del almacén es obligatorio", "danger");
                    return;
                }

                fetch("/almacenes/store", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            nombre: name,
                            direccion: address,
                            responsable: responsible,
                            telefono: phone
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.id) {
                            const option = document.createElement("option");
                            option.value = data.id;
                            option.textContent = data.nombre;
                            warehouseSelect.appendChild(option);
                            warehouseSelect.value = data.id;

                            updateWarehouseInfo(data); // marcar en panel de detalle
                            warehouseModal.hide();
                        } else {
                            alert("No se pudo guardar el almacén");
                        }
                    })
                    .catch(err => {
                        console.error("Error al guardar almacén:", err);
                        showAlert("Error al guardar el almacén", "danger");
                    });
            });

            // Cargar almacenes desde backend
            let warehousesData = []; // almacenar todos los almacenes

            function loadWarehouses() {
                fetch("/almacenes/list")
                    .then(res => res.json())
                    .then(data => {
                        warehousesData = data; // guardar todos los almacenes
                        warehouseSelect.innerHTML = "";
                        data.forEach(w => {
                            const option = document.createElement("option");
                            option.value = w.id;
                            option.textContent = w.nombre;
                            warehouseSelect.appendChild(option);
                        });

                        // Seleccionar primer almacén disponible y mostrar en panel
                        if (data.length > 0) {
                            warehouseSelect.value = data[0].id;
                            updateWarehouseInfo(data[0]);
                        }
                    })
                    .catch(err => console.error("Error cargando almacenes:", err));
            }

            // Evento change del select
            warehouseSelect.addEventListener("change", function() {
                const selectedId = parseInt(this.value);
                const selectedWarehouse = warehousesData.find(w => w.id === selectedId);
                updateWarehouseInfo(selectedWarehouse);
            });

            // Actualizar panel de detalle de almacén
            function updateWarehouseInfo(warehouse) {
                const desktopInfoContainer = document.getElementById("selected-warehouse-info");
                const mobileInfoContainer = document.getElementById("mobile-selected-warehouse-info");

                const content = (!warehouse || !warehouse.id) ? `
        <div class="text-center text-muted">
            <i class="fa fa-warehouse fa-2x mb-2" aria-hidden="true"></i>
            <p class="mb-0">No hay almacén seleccionado</p>
        </div>
    ` : `
        <div>
            <strong>${warehouse.nombre || "-"}</strong><br>
            <small>Dirección: ${warehouse.direccion || "N/A"}</small><br>
            <small>Responsable: ${warehouse.responsable || "N/A"}</small><br>
            <small>Tel: ${warehouse.telefono || "N/A"}</small>
        </div>
    `;

                if (desktopInfoContainer) desktopInfoContainer.innerHTML = content;
                if (mobileInfoContainer) mobileInfoContainer.innerHTML = content;
            }

            // Evento change del select para actualizar el panel
            warehouseSelect.addEventListener("change", function() {
                const selectedId = this.value;
                fetch(`/almacenes/${selectedId}`)
                    .then(res => res.json())
                    .then(data => {
                        updateWarehouseInfo(data);
                    })
                    .catch(err => console.error("Error cargando almacén:", err));
            });

            loadWarehouses();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productDetailsCard = document.getElementById("product-details-card");
            const productEntryDetails = document.getElementById("product-entry-details");
            const addToListBtn = document.getElementById("add-to-list-btn");
            const productsTableBody = document.querySelector("#products-table tbody");
            const productsTotalEl = document.getElementById("products-total");

            // Resumen escritorio
            const summaryTotalEl = document.getElementById("summary-total");
            const summaryContainerEl = document.createElement("div");
            summaryContainerEl.id = "summary-products-list";

            // Resumen móvil
            const mobileSummaryTotalEl = document.getElementById("mobile-summary-total");
            const mobileSummaryContainerEl = document.createElement("div");
            mobileSummaryContainerEl.id = "mobile-summary-products-list";
            const mobileProductsCount = document.getElementById("mobile-products-count");
 // Referencias botones registrar
            const completeEntryBtn = document.getElementById("complete-entry");
            const mobileCompleteEntryBtn = document.getElementById("mobile-complete-entry");
            // Insertamos contenedores
            const desktopSaleSummary = document.querySelector(".sale-summary");
            desktopSaleSummary.insertBefore(summaryContainerEl, summaryTotalEl.parentElement);

            const mobileSaleSummary = document.querySelector(".mobile-details-body .sale-summary");
            mobileSaleSummary.insertBefore(mobileSummaryContainerEl, mobileSummaryTotalEl.parentElement);

            // Botón flotante carrito
            const floatingCartBtn = document.createElement("button");
            floatingCartBtn.id = "floating-cart-btn";
            floatingCartBtn.className = "btn btn-primary rounded-circle shadow-lg position-fixed";
            floatingCartBtn.style.bottom = "20px";
            floatingCartBtn.style.right = "20px";
            floatingCartBtn.style.width = "50px"; // 🔽 más pequeño
            floatingCartBtn.style.height = "50px"; // 🔽 más pequeño
            floatingCartBtn.innerHTML = `
    <i class="menu-icon icon-base bx bx-cart fs-5"></i>
    <span id="floating-cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>
`;
            document.body.appendChild(floatingCartBtn);

            // ⚡️ Guardamos referencia del contador aquí
            const floatingCartCount = floatingCartBtn.querySelector("#floating-cart-count");

            let productsData = [];
            let selectedProduct = null;
            let productsList = [];

            function formatCurrency(value) {
                return `S/ ${parseFloat(value).toFixed(2)}`;
            }

            // TomSelect
            const productSelectEl = document.getElementById("product-select");
            let productSelect;

            if (!productSelectEl.tomselect) {
                productSelect = new TomSelect(productSelectEl, {
                    valueField: "id",
                    labelField: "nombre",
                    searchField: ["nombre", "codigo"],
                    placeholder: "Seleccionar producto...",
                    maxOptions: 100,
                    render: {
                        option: function(item, escape) {
                            return `<div><strong>${escape(item.nombre)}</strong><br><small>Código: ${escape(item.codigo || "-")}</small></div>`;
                        },
                        item: function(item, escape) {
                            return `<div>${escape(item.nombre)}</div>`;
                        }
                    },
                    onChange: function(value) {
                        const selectedId = parseInt(value);
                        selectedProduct = productsData.find(p => p.id === selectedId);

                        if (!selectedProduct) {
                            productDetailsCard.classList.add("d-none");
                            productEntryDetails.classList.add("d-none");
                            return;
                        }

                        productDetailsCard.classList.remove("d-none");
                        productEntryDetails.classList.remove("d-none");

                        document.getElementById("product-price-type").textContent = selectedProduct.category || "-";
                        document.getElementById("product-price").textContent = formatCurrency(selectedProduct.price);
                        document.getElementById("product-category").textContent = selectedProduct.category || "-";
                        document.getElementById("product-brand").textContent = selectedProduct.brand || "-";
                        document.getElementById("product-model").textContent = selectedProduct.model || "-";
                        document.getElementById("product-origin").textContent = selectedProduct.origin || "-";

                        document.getElementById("product-lot").value = "";
                        document.getElementById("product-code").value = selectedProduct.codigo || "";
                        document.getElementById("product-quantity").value = 1;
                        document.getElementById("product-unit-cost").value = selectedProduct.price || 0;
                        document.getElementById("product-expiry-date").value = "";
                    }
                });
            } else {
                productSelect = productSelectEl.tomselect;
            }

            // Cargar productos
            function loadProducts() {
                fetch("/productos/list")
                    .then(res => res.json())
                    .then(data => {
                        productsData = data.map(p => ({
                            id: p.id,
                            nombre: p.name,
                            codigo: p.codigo || "-",
                            category: p.category || "-",
                            brand: p.brand || "-",
                            model: p.model || "-",
                            price: p.price || 0,
                            origin: p.origin || "-"
                        }));

                        productSelect.clearOptions();
                        productSelect.addOptions(productsData);
                    })
                    .catch(err => console.error("Error cargando productos:", err));
            }
            loadProducts();

            // Agregar producto
            addToListBtn.addEventListener("click", function(e) {
                e.preventDefault();
                if (!selectedProduct) return;

                const lote = document.getElementById("product-lot").value.trim();
                const codigo = document.getElementById("product-code").value.trim();
                const cantidad = parseFloat(document.getElementById("product-quantity").value) || 0;
                const unitCost = parseFloat(document.getElementById("product-unit-cost").value) || 0;
                const expiryDate = document.getElementById("product-expiry-date").value;

                if (cantidad <= 0 || unitCost < 0) {
                    alert("Cantidad y costo deben ser mayores a cero.");
                    return;
                }

                const totalCost = cantidad * unitCost;

                const productItem = {
                    id: selectedProduct.id,
                    name: selectedProduct.nombre,
                    lot: lote,
                    code: codigo,
                    quantity: cantidad,
                    unitCost: unitCost,
                    totalCost: totalCost,
                    expiryDate: expiryDate,
                    type: selectedProduct.category || "-"
                };

                productsList.push(productItem);
                renderProductsTable();
                updateSummary();
            });

            // Tabla de productos
            function renderProductsTable() {
                productsTableBody.innerHTML = "";
                productsList.forEach((p, index) => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                <td>${p.lot}</td>
                <td>${p.code}</td>
                <td>${p.name}</td>
                <td>${p.type}</td>
                <td>${p.quantity}</td>
                <td>${formatCurrency(p.unitCost)}</td>
                <td>${formatCurrency(p.totalCost)}</td>
                <td>${p.expiryDate || "-"}</td>
                <td>
                    <button class="btn btn-sm btn-danger remove-product" data-index="${index}">
                        <i class="bx bx-trash"></i>
                    </button>
                </td>
            `;
                    productsTableBody.appendChild(tr);
                });

                document.querySelectorAll(".remove-product").forEach(btn => {
                    btn.addEventListener("click", function() {
                        const idx = parseInt(this.dataset.index);
                        productsList.splice(idx, 1);
                        renderProductsTable();
                        updateSummary();
                    });
                });
            }

            // Resumen
            function updateSummary() {
                summaryContainerEl.innerHTML = "";
                mobileSummaryContainerEl.innerHTML = "";
                let total = 0;

                productsList.forEach(p => {
                    total += p.totalCost;

                    const card = document.createElement("div");
                    card.classList.add("card", "mb-2", "p-2", "shadow-sm");
                    card.innerHTML = `
                <div class="d-flex justify-content-between">
                    <div>
                        <strong>${p.name}</strong><br>
                        <small>Cant: ${p.quantity} x ${formatCurrency(p.unitCost)}</small>
                    </div>
                    <div><strong>${formatCurrency(p.totalCost)}</strong></div>
                </div>
            `;
                    summaryContainerEl.appendChild(card);

                    const mobileCard = card.cloneNode(true);
                    mobileSummaryContainerEl.appendChild(mobileCard);
                });

                summaryTotalEl.textContent = formatCurrency(total);
                mobileSummaryTotalEl.textContent = formatCurrency(total);

                // 🔄 Actualizar contadores
                mobileProductsCount.textContent = productsList.length;
                floatingCartCount.textContent = productsList.length; // ✅ usar la referencia correcta
                // ✅ Actualizar total del tfoot de la tabla
                const productsTotalEl = document.getElementById("products-total");
                if (productsTotalEl) {
                    productsTotalEl.textContent = formatCurrency(total);
                }
            }
// 👉 Registrar compra
            function registerPurchase() {
                const proveedorId = document.getElementById("supplier-select").value;
                const almacenId = document.getElementById("warehouse-select").value;
                const fecha = document.getElementById("entry-date").value;
                const inventoryType = document.getElementById("inventory-type").value;
                const reason = document.getElementById("reason").value;
                const paymentForm = document.getElementById("payment-form").value;
                const paymentType = document.getElementById("payment-type").value;
                const observacion = document.getElementById("entry-observation")?.value || "";
                const hasInvoice = document.querySelector('input[name="hasInvoice"]:checked').value === 'yes';
                const numeroFactura = hasInvoice ? document.getElementById("invoice-number").value.trim() : null;

                if (!proveedorId || !almacenId) {
                    showAlert("Debe seleccionar proveedor y almacén.", "warning");
                    return;
                }
                if (productsList.length === 0) {
                    showAlert("Debe agregar al menos un producto.", "warning");
                    return;
                }

                const payload = {
                    proveedor_id: proveedorId,
                    almacen_id: almacenId,
                    fecha_ingreso: fecha,
                    tipo: "compra",
                    inventario: inventoryType,
                    motivo: reason,
                    forma_pago: paymentForm,
                    tipo_pago: paymentType,
                    observacion: observacion,
                    factura: hasInvoice ? 1 : 0,
                    numero_factura: numeroFactura,
                    productos: productsList.map(p => ({
                        producto_id: p.id,
                        cantidad: p.quantity,
                        costo_unitario: p.unitCost,
                        costo_total: p.totalCost,
                        lote: p.lot,
                        fecha_vencimiento: p.expiryDate
                    }))
                };
console.log("Payload de compra:", payload); // 🔍 Depuración
                fetch("/compras/store", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showAlert("Compra registrada correctamente. ID: " + data.compra_id, "success");
                            productsList = [];
                            renderProductsTable();
                            updateSummary();
                        } else {
                            showAlert("Error: " + data.message, "danger");
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showAlert("Error al registrar la compra.", "danger");
                    });
            }

            // 👉 Listeners para botones
            if (completeEntryBtn) {
                completeEntryBtn.addEventListener("click", registerPurchase);
            }
            if (mobileCompleteEntryBtn) {
                mobileCompleteEntryBtn.addEventListener("click", registerPurchase);
            }
            // Mostrar/ocultar botón flotante
            const mobileToggleBtn = document.getElementById("mobile-details-toggle");
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (window.innerWidth < 992) { // 👈 solo móvil
                        if (entry.isIntersecting) {
                            floatingCartBtn.classList.remove("show");
                        } else {
                            floatingCartBtn.classList.add("show");
                        }
                    } else {
                        floatingCartBtn.classList.remove("show"); // no mostrar en escritorio
                    }
                });
            }, {
                threshold: 0
            });
            observer.observe(mobileToggleBtn);

            // 📌 Abrir el sidebar al hacer clic en el botón flotante
            floatingCartBtn.addEventListener("click", function() {
                mobileToggleBtn.click(); // dispara el mismo evento del botón original
            });


        });
    </script>


  

</x-layout>