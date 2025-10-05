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
                                <input type="date" class="form-control form-control-sm border-0 bg-transparent p-0 ms-1 text-dark" id="sale-date" value="{{ date('Y-m-d') }}" style="width: auto; display: inline-block;">
                            </span>
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
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="mb-0 font-weight-bolder">Productos Disponibles</h6>
                                    <div class="input-group input-group-outline w-50">
                                        <label class="form-label">Buscar producto...</label>
                                        <input type="text" class="form-control" id="product-search">
                                    </div>
                                </div>

                                <!-- Pestañas de productos -->
                                <ul class="nav nav-tabs mb-3" id="productsTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active mb-0" id="new-products-tab" data-bs-toggle="tab"
                                            data-bs-target="#new-products" type="button" role="tab">Nuevos Productos</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link mb-0" id="best-sellers-tab" data-bs-toggle="tab"
                                            data-bs-target="#best-sellers" type="button" role="tab">Más Vendidos</button>
                                    </li>
                                </ul>

                                <!-- Contenido de pestañas -->
                                <div class="tab-content" id="productsTabContent">
                                    <!-- Productos nuevos -->
                                    <div class="tab-pane fade show active" id="new-products" role="tabpanel">
                                        <div class="row" id="new-products-container">
                                            <!-- Los productos se cargarán aquí mediante JavaScript -->

                                        </div>
                                        <div class="text-center mt-3">
                                            <button class="btn btn-outline-primary btn-sm mb-0" id="load-more-new">Cargar más productos</button>
                                        </div>
                                    </div>

                                    <!-- Productos más vendidos -->
                                    <div class="tab-pane fade" id="best-sellers" role="tabpanel">
                                        <div class="row" id="best-sellers-container">
                                            <!-- Los productos se cargarán aquí mediante JavaScript -->
                                        </div>
                                        <div class="text-center mt-3">
                                            <button class="btn btn-outline-primary btn-sm mb-0" id="load-more-best">Cargar más productos</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Carrito de compras - Columna derecha (Solo escritorio) -->
                            <div class="col-lg-4 col-md-5 d-md-block d-none">
                                <div class="card card-body border-radius-lg shadow-none border-dashed h-100">
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
                                    <div class="cart-items mb-3" id="cart-items" style="max-height: 200px; overflow-y: auto;">
                                        <div class="text-center p-3 text-muted">
                                            <i class="fa fa-shopping-cart fa-2x mb-2" aria-hidden="true"></i>
                                            <p class="mb-0">No hay productos en el carrito</p>
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
                <div class="cart-items mb-3" id="mobile-cart-items" style="max-height: 200px; overflow-y: auto;">
                    <div class="text-center p-3 text-muted">
                        <i class="fa fa-shopping-cart fa-2x mb-2" aria-hidden="true"></i>
                        <p class="mb-0">No hay productos en el carrito</p>
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

    <style>
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
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            overflow: hidden;
            background: #ffffffff;
            box-shadow: 0 3px 5px -1px rgba(0, 0, 0, 0.05), 0 6px 10px 0 rgba(0, 0, 0, 0.05), 0 1px 18px 0 rgba(0, 0, 0, 0.05);
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }

        .cart-item {
            border-bottom: 1px dashed #dee2e6;
            padding: 10px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
        }

        .quantity-btn {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .quantity-btn:hover {
            background: #e9ecef;
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
        const defaultImage = "{{ asset('assets/img/avatars/perfil1.jpg') }}";
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

            // Cargar productos y clientes al iniciar
            loadProducts();
            loadClients();

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

            // Función para crear elemento de producto
            function createProductElement(product) {
                const col = document.createElement('div');
                col.className = 'col-lg-3 col-md-4 col-sm-6 mb-3';

                col.innerHTML = `
    <div class="product-card" data-product-id="${product.id}">
        <div class="product-image" style="height: 120px; overflow: hidden; background: #f8f9fa;">
            <img src="${product.image || defaultImage}" 
                 alt="${product.name}" class="w-100 h-100 object-fit-cover">
        </div>
        <div class="card-body">
            <h6 class="mb-1 text-sm">${product.name}</h6>
            <p class="mb-1 text-xs">Stock: ${product.stock}</p>
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-sm font-weight-bold">Bs/ ${product.price.toFixed(2)}</span>
                <button class="btn btn-sm btn-outline-primary add-to-cart">Agregar</button>
            </div>
        </div>
    </div>
`;

                // Agregar evento para añadir al carrito
                col.querySelector('.add-to-cart').addEventListener('click', function(e) {
                    e.stopPropagation();
                    addToCart(product);
                });

                return col;
            }

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
            <div class="text-center p-3 text-muted">
                <i class="fa fa-shopping-cart fa-2x mb-2" aria-hidden="true"></i>
                <p class="mb-0">No hay productos en el carrito</p>
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
            <div class="cart-item">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="my-0 text-sm">${item.name}</h6>
                        <p class="text-xs text-muted mb-1">Bs/ ${item.price.toFixed(2)} c/u</p>
                    </div>
                    <button class="btn btn-sm btn-link text-danger remove-item" data-id="${item.id}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="quantity-controls">
                        <span class="quantity-btn decrease-quantity" data-id="${item.id}">-</span>
                        <span class="mx-2">${item.quantity}</span>
                        <span class="quantity-btn increase-quantity" data-id="${item.id}">+</span>
                    </div>
                    <span class="font-weight-bold">Bs/ ${itemTotal.toFixed(2)}</span>
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
                const saleType = saleTypeSelect.value;

                const saleData = {
                    client_id: clientId,
                    almacen_id: almacenId,
                    payment_method: paymentMethod,
                    sale_type: saleType,
                    items: cart,
                    date: document.getElementById('sale-date').value
                };

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