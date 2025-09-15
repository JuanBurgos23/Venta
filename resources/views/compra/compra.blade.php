<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <title>Compras - Sistema ERP</title>

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="{{asset('assets/vendor/fonts/iconify-icons.css')}}" />

        <!-- Core CSS -->
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/pickr/pickr-themes.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/css/core.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />

        <!-- Page CSS -->
        <style>
            .supplier-card {
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .supplier-card:hover,
            .supplier-card.active {
                transform: translateY(-3px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-color: #696cff;
            }

            .order-item {
                border-bottom: 1px solid #e9ecef;
                padding: 12px 0;
            }

            .product-selector {
                cursor: pointer;
                padding: 10px;
                border-radius: 6px;
                margin-bottom: 8px;
                transition: all 0.2s;
                border: 1px solid #e9ecef;
            }

            .product-selector:hover,
            .product-selector.active {
                background-color: #f8f9fa;
                border-color: #696cff;
            }

            .sticky-summary {
                position: sticky;
                top: 80px;
                height: calc(100vh - 100px);
                overflow-y: auto;
            }

            .search-box {
                position: relative;
            }

            .search-results {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                border: 1px solid #ddd;
                border-radius: 4px;
                z-index: 1000;
                max-height: 300px;
                overflow-y: auto;
                display: none;
            }

            .search-item {
                padding: 10px;
                border-bottom: 1px solid #eee;
                cursor: pointer;
            }

            .search-item:hover {
                background-color: #f8f9fa;
            }

            .low-stock {
                color: #ff6b6b;
                font-weight: 500;
            }

            .order-status {
                padding: 4px 8px;
                border-radius: 4px;
                font-size: 0.8rem;
                font-weight: 500;
            }

            .status-pending {
                background-color: #fff3cd;
                color: #856404;
            }

            .status-approved {
                background-color: #d4edda;
                color: #155724;
            }

            .status-rejected {
                background-color: #f8d7da;
                color: #721c24;
            }

            .status-received {
                background-color: #d1ecf1;
                color: #0c5460;
            }
        </style>


    </head>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <!-- Scripts -->
        @vite([ 'resources/js/app.js'])
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="col-12">

                <div class="card-body">
                    <!-- Content wrapper -->
                    <div class="content-wrapper">
                        <!-- Content -->
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <h4 class="fw-bold py-3 mb-4">Gestión de Compras</h4>

                            <div class="row">
                                <!-- Panel de proveedores y productos -->
                                <div class="col-lg-8 mb-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Proveedores</h5>
                                            <div class="d-flex justify-content-between mt-3">
                                                <div class="search-box w-100 me-3">
                                                    <input type="text" class="form-control" placeholder="Buscar proveedor..." id="supplierSearch">
                                                    <div class="search-results" id="supplierSearchResults"></div>
                                                </div>
                                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                                                    <i class="icon-base bx bx-plus"></i> Nuevo
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-4" id="supplierList">
                                                <!-- Los proveedores se cargarán dinámicamente -->
                                            </div>

                                            <hr>

                                            <h5 class="mb-3">Productos del Proveedor</h5>
                                            <div class="search-box mb-3">
                                                <input type="text" class="form-control" placeholder="Buscar producto..." id="productSearch">
                                                <div class="search-results" id="productSearchResults"></div>
                                            </div>

                                            <div id="supplierProducts">
                                                <div class="text-center text-muted py-4">
                                                    <i class="icon-base bx bx-package display-4"></i>
                                                    <p class="mt-2">Seleccione un proveedor para ver sus productos</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Historial de órdenes de compra -->
                                    <div class="card mt-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h5 class="card-title mb-0">Historial de Órdenes de Compra</h5>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                    <i class="icon-base bx bx-filter"></i> Filtrar
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="#" data-status="all">Todas</a></li>
                                                    <li><a class="dropdown-item" href="#" data-status="pending">Pendientes</a></li>
                                                    <li><a class="dropdown-item" href="#" data-status="approved">Aprobadas</a></li>
                                                    <li><a class="dropdown-item" href="#" data-status="rejected">Rechazadas</a></li>
                                                    <li><a class="dropdown-item" href="#" data-status="received">Recibidas</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th># Orden</th>
                                                            <th>Proveedor</th>
                                                            <th>Fecha</th>
                                                            <th>Total</th>
                                                            <th>Estado</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="purchaseOrdersTable">
                                                        <!-- Las órdenes se cargarán dinámicamente -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Panel de la orden de compra -->
                                <div class="col-lg-4">
                                    <div class="card sticky-summary">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Orden de Compra</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <label class="form-label">Proveedor seleccionado</label>
                                                <div class="alert alert-info py-2" id="selectedSupplier">
                                                    <div class="text-center text-muted">Ningún proveedor seleccionado</div>
                                                </div>
                                            </div>

                                            <!-- Items de la orden -->
                                            <div class="mb-3">
                                                <h6 class="mb-3">Productos a ordenar</h6>
                                                <div id="orderItems">
                                                    <div class="text-center text-muted py-4">
                                                        <i class="icon-base bx bx-cart-add display-4"></i>
                                                        <p class="mt-2">No hay productos en la orden</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Resumen de la orden -->
                                            <div class="border-top pt-3">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Subtotal:</span>
                                                    <span id="orderSubtotal">$0.00</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Impuestos (18%):</span>
                                                    <span id="orderTaxes">$0.00</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-2">
                                                    <span class="text-muted">Descuento:</span>
                                                    <span id="orderDiscount">$0.00</span>
                                                </div>
                                                <div class="d-flex justify-content-between mb-3 fw-bold">
                                                    <span>Total:</span>
                                                    <span id="orderTotal">$0.00</span>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Fecha esperada de entrega</label>
                                                    <input type="date" class="form-control" id="expectedDeliveryDate">
                                                </div>

                                                <div class="d-grid gap-2">
                                                    <button class="btn btn-primary" id="createPurchaseOrder">Crear Orden de Compra</button>
                                                    <button class="btn btn-outline-secondary" id="clearOrder">Limpiar Orden</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Content -->
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
                <div class="container-xxl">
                    <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            © <script>
                                document.write(new Date().getFullYear());
                            </script>
                            Sistema ERP
                        </div>
                    </div>
                </div>
            </footer>
    </main>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>








<!-- / Layout wrapper -->

<!-- Modal para agregar proveedor -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="supplierForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre de la empresa</label>
                                <input type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contacto principal</label>
                                <input type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Dirección</label>
                                <textarea class="form-control" rows="2" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tipo de documento</label>
                                <select class="form-select">
                                    <option>RUC</option>
                                    <option>DNI</option>
                                    <option>Cédula</option>
                                    <option>Pasaporte</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Número de documento</label>
                                <input type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Plazo de pago (días)</label>
                                <input type="number" class="form-control" value="30" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Límite de crédito</label>
                                <input type="number" class="form-control" value="0" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Guardar Proveedor</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para detalles de orden -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de Orden de Compra #<span id="orderId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Proveedor:</strong> <span id="detailSupplier"></span></p>
                        <p><strong>Fecha de creación:</strong> <span id="detailDate"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Estado:</strong> <span id="detailStatus"></span></p>
                        <p><strong>Fecha esperada:</strong> <span id="detailExpectedDate"></span></p>
                    </div>
                </div>

                <h6 class="mb-3">Productos</h6>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="orderDetailsProducts">
                            <!-- Los productos se cargarán dinámicamente -->
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end mt-3">
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <span id="detailSubtotal">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Impuestos (18%):</span>
                            <span id="detailTaxes">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 fw-bold">
                            <span>Total:</span>
                            <span id="detailTotal">$0.00</span>
                        </div>
                        <span id="detailTotal">$0.00</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4" id="orderActions">
            <!-- Botones de acción según el estado -->
        </div>
    </div>
</div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-primary" id="printOrder">Imprimir</button>
</div>
</div>
</div>
</div>
</div>

<!-- Core JS -->
<script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
<script src="{{asset('assets/vendor/js/menu.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>

<!-- Vendors JS -->
<script src="{{asset('assets/vendor/libs/cleave-zen/cleave-zen.js')}}"></script>
<script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>

<!-- Custom JS para la pantalla de compras -->
<script>
    // Datos de ejemplo (en un sistema real vendrían de una base de datos)
    const suppliers = [{
            id: 1,
            name: "TecnoImport S.A.",
            contact: "Carlos Rodríguez",
            email: "carlos@tecnoimport.com",
            phone: "+1 234 567 890",
            address: "Av. Industrial 123, Lima",
            paymentTerms: 30,
            creditLimit: 10000
        },
        {
            id: 2,
            name: "Suministros Office",
            contact: "María González",
            email: "maria@suministrossoffice.com",
            phone: "+1 345 678 901",
            address: "Calle Comercio 456, Lima",
            paymentTerms: 15,
            creditLimit: 5000
        },
        {
            id: 3,
            name: "ElectroParts",
            contact: "Roberto Silva",
            email: "roberto@electroparts.com",
            phone: "+1 456 789 012",
            address: "Jr. Componentes 789, Lima",
            paymentTerms: 45,
            creditLimit: 15000
        }
    ];

    const products = [{
            id: 1,
            name: "Monitor 24\" LED",
            price: 179.99,
            category: "Tecnología",
            supplierId: 1,
            minOrder: 5,
            currentStock: 8
        },
        {
            id: 2,
            name: "Teclado Mecánico",
            price: 89.99,
            category: "Tecnología",
            supplierId: 1,
            minOrder: 10,
            currentStock: 15
        },
        {
            id: 3,
            name: "Mouse Inalámbrico",
            price: 29.99,
            category: "Tecnología",
            supplierId: 1,
            minOrder: 15,
            currentStock: 20
        },
        {
            id: 4,
            name: "Papel A4 Resma",
            price: 8.99,
            category: "Oficina",
            supplierId: 2,
            minOrder: 20,
            currentStock: 50
        },
        {
            id: 5,
            name: "Tóner Impresora HP",
            price: 69.99,
            category: "Oficina",
            supplierId: 2,
            minOrder: 5,
            currentStock: 12
        },
        {
            id: 6,
            name: "Silla Ergonómica",
            price: 199.99,
            category: "Mobiliario",
            supplierId: 3,
            minOrder: 3,
            currentStock: 5
        },
        {
            id: 7,
            name: "Escritorio Ejecutivo",
            price: 349.99,
            category: "Mobiliario",
            supplierId: 3,
            minOrder: 2,
            currentStock: 3
        },
        {
            id: 8,
            name: "CPU Intel i7",
            price: 499.99,
            category: "Tecnología",
            supplierId: 1,
            minOrder: 5,
            currentStock: 6
        }
    ];

    const purchaseOrders = [{
            id: "PO-001",
            supplierId: 1,
            date: "2023-10-15",
            expectedDate: "2023-10-25",
            status: "received",
            items: [{
                    productId: 1,
                    quantity: 10,
                    price: 175.99
                },
                {
                    productId: 2,
                    quantity: 15,
                    price: 85.99
                }
            ],
            subtotal: 3519.85,
            taxes: 633.57,
            total: 4153.42
        },
        {
            id: "PO-002",
            supplierId: 2,
            date: "2023-10-18",
            expectedDate: "2023-10-28",
            status: "approved",
            items: [{
                    productId: 4,
                    quantity: 25,
                    price: 8.50
                },
                {
                    productId: 5,
                    quantity: 8,
                    price: 65.99
                }
            ],
            subtotal: 655.42,
            taxes: 117.98,
            total: 773.40
        },
        {
            id: "PO-003",
            supplierId: 3,
            date: "2023-10-20",
            expectedDate: "2023-11-05",
            status: "pending",
            items: [{
                    productId: 6,
                    quantity: 4,
                    price: 189.99
                },
                {
                    productId: 7,
                    quantity: 2,
                    price: 329.99
                }
            ],
            subtotal: 1339.94,
            taxes: 241.19,
            total: 1581.13
        }
    ];

    let currentOrder = {
        supplierId: null,
        items: [],
        subtotal: 0,
        taxes: 0,
        total: 0
    };

    let selectedSupplierId = null;
    let orderFilterStatus = 'all';

    // Inicializar la pantalla de compras
    $(document).ready(function() {
        loadSuppliers();
        loadPurchaseOrders();
        setupEventListeners();
    });

    // Cargar proveedores en la interfaz
    function loadSuppliers() {
        const supplierList = $('#supplierList');
        supplierList.empty();

        suppliers.forEach(supplier => {
            const supplierCard = `
                    <div class="col-md-6 mb-3">
                        <div class="card supplier-card" data-id="${supplier.id}">
                            <div class="card-body">
                                <h5 class="card-title">${supplier.name}</h5>
                                <p class="card-text mb-1">
                                    <small class="text-muted">Contacto: ${supplier.contact}</small>
                                </p>
                                <p class="card-text mb-1">
                                    <small class="text-muted">Tel: ${supplier.phone}</small>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">Plazo: ${supplier.paymentTerms} días</small>
                                </p>
                                <button class="btn btn-sm btn-outline-primary select-supplier">Seleccionar</button>
                            </div>
                        </div>
                    </div>
                `;
            supplierList.append(supplierCard);
        });
    }

    // Cargar órdenes de compra en la tabla
    function loadPurchaseOrders() {
        const ordersTable = $('#purchaseOrdersTable');
        ordersTable.empty();

        const filteredOrders = orderFilterStatus === 'all' ?
            purchaseOrders :
            purchaseOrders.filter(order => order.status === orderFilterStatus);

        if (filteredOrders.length === 0) {
            ordersTable.html(`
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="icon-base bx bx-purchase-tag-alt display-4"></i>
                            <p class="mt-2 text-muted">No hay órdenes de compra</p>
                        </td>
                    </tr>
                `);
            return;
        }

        filteredOrders.forEach(order => {
            const supplier = suppliers.find(s => s.id === order.supplierId);
            const statusClass = `status-${order.status}`;
            let statusText = '';

            switch (order.status) {
                case 'pending':
                    statusText = 'Pendiente';
                    break;
                case 'approved':
                    statusText = 'Aprobada';
                    break;
                case 'rejected':
                    statusText = 'Rechazada';
                    break;
                case 'received':
                    statusText = 'Recibida';
                    break;
            }

            const orderRow = `
                    <tr>
                        <td>${order.id}</td>
                        <td>${supplier ? supplier.name : 'Proveedor no disponible'}</td>
                        <td>${order.date}</td>
                        <td>$${order.total.toFixed(2)}</td>
                        <td><span class="order-status ${statusClass}">${statusText}</span></td>
                        <td>
                            <button class="btn btn-sm btn-icon btn-outline-info view-order" data-id="${order.id}">
                                <i class="icon-base bx bx-show"></i>
                            </button>
                            ${order.status === 'pending' ? `
                                <button class="btn btn-sm btn-icon btn-outline-success approve-order" data-id="${order.id}">
                                    <i class="icon-base bx bx-check"></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-outline-danger reject-order" data-id="${order.id}">
                                    <i class="icon-base bx bx-x"></i>
                                </button>
                            ` : ''}
                            ${order.status === 'approved' ? `
                                <button class="btn btn-sm btn-icon btn-outline-primary receive-order" data-id="${order.id}">
                                    <i class="icon-base bx bx-package"></i>
                                </button>
                            ` : ''}
                        </td>
                    </tr>
                `;
            ordersTable.append(orderRow);
        });
    }

    // Configurar event listeners
    function setupEventListeners() {
        // Buscar proveedores
        $('#supplierSearch').on('input', function() {
            const query = $(this).val().toLowerCase();
            if (query.length > 2) {
                const results = suppliers.filter(s =>
                    s.name.toLowerCase().includes(query) ||
                    s.contact.toLowerCase().includes(query)
                );
                showSupplierSearchResults(results);
            } else {
                $('#supplierSearchResults').hide();
            }
        });

        // Seleccionar proveedor
        $(document).on('click', '.select-supplier', function() {
            const supplierId = $(this).closest('.supplier-card').data('id');
            selectSupplier(supplierId);
        });

        // Buscar productos
        $('#productSearch').on('input', function() {
            const query = $(this).val().toLowerCase();
            if (query.length > 2 && selectedSupplierId) {
                const supplierProducts = products.filter(p => p.supplierId === selectedSupplierId);
                const results = supplierProducts.filter(p =>
                    p.name.toLowerCase().includes(query) ||
                    p.category.toLowerCase().includes(query)
                );
                showProductSearchResults(results);
            } else {
                $('#productSearchResults').hide();
            }
        });

        // Agregar producto a la orden
        $(document).on('click', '.add-to-order', function() {
            const productId = $(this).closest('.product-selector').data('id');
            addToOrder(productId);
        });

        // Cambiar cantidad en orden
        $(document).on('click', '.quantity-btn', function() {
            const productId = $(this).closest('.order-item').data('id');
            const action = $(this).data('action');
            updateOrderItemQuantity(productId, action);
        });

        // Eliminar item de la orden
        $(document).on('click', '.remove-item', function() {
            const productId = $(this).closest('.order-item').data('id');
            removeFromOrder(productId);
        });

        // Crear orden de compra
        $('#createPurchaseOrder').click(createPurchaseOrder);

        // Limpiar orden
        $('#clearOrder').click(clearOrder);

        // Filtrar órdenes
        $('.dropdown-item[data-status]').click(function() {
            orderFilterStatus = $(this).data('status');
            loadPurchaseOrders();
        });

        // Ver detalles de orden
        $(document).on('click', '.view-order', function() {
            const orderId = $(this).data('id');
            viewOrderDetails(orderId);
        });

        // Aprobar orden
        $(document).on('click', '.approve-order', function() {
            const orderId = $(this).data('id');
            updateOrderStatus(orderId, 'approved');
        });

        // Rechazar orden
        $(document).on('click', '.reject-order', function() {
            const orderId = $(this).data('id');
            updateOrderStatus(orderId, 'rejected');
        });

        // Recibir orden
        $(document).on('click', '.receive-order', function() {
            const orderId = $(this).data('id');
            updateOrderStatus(orderId, 'received');
        });
    }

    // Mostrar resultados de búsqueda de proveedores
    function showSupplierSearchResults(results) {
        const resultsContainer = $('#supplierSearchResults');
        resultsContainer.empty();

        if (results.length === 0) {
            resultsContainer.html('<div class="search-item">No se encontraron proveedores</div>');
        } else {
            results.forEach(supplier => {
                const resultItem = `
                        <div class="search-item" data-id="${supplier.id}">
                            <div class="d-flex justify-content-between">
                                <span>${supplier.name}</span>
                            </div>
                            <small class="text-muted">${supplier.contact} • ${supplier.phone}</small>
                        </div>
                    `;
                resultsContainer.append(resultItem);
            });

            // Al hacer clic en un resultado
            $('.search-item', resultsContainer).click(function() {
                const supplierId = $(this).data('id');
                selectSupplier(supplierId);
                $('#supplierSearch').val('');
                resultsContainer.hide();
            });
        }

        resultsContainer.show();
    }

    // Seleccionar un proveedor
    function selectSupplier(supplierId) {
        selectedSupplierId = supplierId;
        const supplier = suppliers.find(s => s.id === supplierId);

        if (!supplier) return;

        // Resaltar el proveedor seleccionado
        $('.supplier-card').removeClass('active');
        $(`.supplier-card[data-id="${supplierId}"]`).addClass('active');

        // Actualizar la información del proveedor seleccionado
        $('#selectedSupplier').html(`
                <strong>${supplier.name}</strong><br>
                <small>Contacto: ${supplier.contact} • ${supplier.phone}</small>
            `);

        // Cargar productos del proveedor
        loadSupplierProducts(supplierId);
    }

    // Cargar productos del proveedor seleccionado
    function loadSupplierProducts(supplierId) {
        const supplierProductsContainer = $('#supplierProducts');
        supplierProductsContainer.empty();

        const supplierProducts = products.filter(p => p.supplierId === supplierId);

        if (supplierProducts.length === 0) {
            supplierProductsContainer.html(`
                    <div class="text-center text-muted py-4">
                        <i class="icon-base bx bx-package display-4"></i>
                        <p class="mt-2">Este proveedor no tiene productos registrados</p>
                    </div>
                `);
            return;
        }

        supplierProducts.forEach(product => {
            const stockClass = product.currentStock < product.minOrder ? 'low-stock' : '';

            const productSelector = `
                    <div class="product-selector" data-id="${product.id}">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">${product.name}</h6>
                                <small class="text-muted">${product.category}</small>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold">$${product.price.toFixed(2)}</span>
                                <div class="mt-1">
                                    <small class="${stockClass}">Stock: ${product.currentStock} (Mín: ${product.minOrder})</small>
                                </div>
                                <button class="btn btn-sm btn-primary mt-2 add-to-order">Agregar</button>
                            </div>
                        </div>
                    </div>
                `;
            supplierProductsContainer.append(productSelector);
        });
    }

    // Mostrar resultados de búsqueda de productos
    function showProductSearchResults(results) {
        const resultsContainer = $('#productSearchResults');
        resultsContainer.empty();

        if (results.length === 0) {
            resultsContainer.html('<div class="search-item">No se encontraron productos</div>');
        } else {
            results.forEach(product => {
                const resultItem = `
                        <div class="search-item" data-id="${product.id}">
                            <div class="d-flex justify-content-between">
                                <span>${product.name}</span>
                                <span>$${product.price.toFixed(2)}</span>
                            </div>
                            <small class="text-muted">${product.category} • Stock: ${product.currentStock}</small>
                        </div>
                    `;
                resultsContainer.append(resultItem);
            });

            // Al hacer clic en un resultado
            $('.search-item', resultsContainer).click(function() {
                const productId = $(this).data('id');
                addToOrder(productId);
                $('#productSearch').val('');
                resultsContainer.hide();
            });
        }

        resultsContainer.show();
    }

    // Agregar producto a la orden de compra
    function addToOrder(productId) {
        if (!selectedSupplierId) {
            showNotification('Error', 'Debe seleccionar un proveedor primero', 'error');
            return;
        }

        const product = products.find(p => p.id === productId);

        if (!product) return;

        // Verificar que el producto pertenece al proveedor seleccionado
        if (product.supplierId !== selectedSupplierId) {
            showNotification('Error', 'Este producto no pertenece al proveedor seleccionado', 'error');
            return;
        }

        // Buscar si el producto ya está en la orden
        const existingItem = currentOrder.items.find(item => item.productId === productId);

        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            currentOrder.items.push({
                productId: product.id,
                name: product.name,
                price: product.price,
                quantity: 1,
                minOrder: product.minOrder
            });
        }

        updateOrderDisplay();
        showNotification('Éxito', 'Producto agregado a la orden', 'success');
    }

    // Actualizar cantidad de un item en la orden
    function updateOrderItemQuantity(productId, action) {
        const item = currentOrder.items.find(item => item.productId === productId);

        if (action === 'increase') {
            item.quantity += 1;
        } else if (action === 'decrease') {
            if (item.quantity > 1) {
                item.quantity -= 1;
            } else {
                removeFromOrder(productId);
                return;
            }
        }

        updateOrderDisplay();
    }

    // Eliminar producto de la orden
    function removeFromOrder(productId) {
        currentOrder.items = currentOrder.items.filter(item => item.productId !== productId);
        updateOrderDisplay();
        showNotification('Info', 'Producto eliminado de la orden', 'info');
    }

    // Actualizar visualización de la orden
    function updateOrderDisplay() {
        const orderItemsContainer = $('#orderItems');

        if (currentOrder.items.length === 0) {
            orderItemsContainer.html(`
                    <div class="text-center text-muted py-4">
                        <i class="icon-base bx bx-cart-add display-4"></i>
                        <p class="mt-2">No hay productos en la orden</p>
                    </div>
                `);
        } else {
            let orderHTML = '';
            let subtotal = 0;

            currentOrder.items.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                orderHTML += `
                        <div class="order-item" data-id="${item.productId}">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="mb-1">${item.name}</h6>
                                    <small class="text-muted">$${item.price.toFixed(2)} c/u</small>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold">$${itemTotal.toFixed(2)}</span>
                                    <div class="mt-2 d-flex align-items-center">
                                        <button class="btn btn-sm btn-outline-secondary quantity-btn" data-action="decrease">-</button>
                                        <span class="mx-2">${item.quantity}</span>
                                        <button class="btn btn-sm btn-outline-secondary quantity-btn" data-action="increase">+</button>
                                        <button class="btn btn-sm btn-outline-danger ms-2 remove-item">
                                            <i class="icon-base bx bx-trash"></i>
                                        </button>
                                    </div>
                                    ${item.quantity < item.minOrder ? `
                                        <small class="text-danger">Cantidad mínima: ${item.minOrder}</small>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    `;
            });

            orderItemsContainer.html(orderHTML);
        }

        // Actualizar totales
        const taxes = subtotal * 0.18;
        const total = subtotal + taxes;

        currentOrder.subtotal = subtotal;
        currentOrder.taxes = taxes;
        currentOrder.total = total;

        $('#orderSubtotal').text('$' + subtotal.toFixed(2));
        $('#orderTaxes').text('$' + taxes.toFixed(2));
        $('#orderTotal').text('$' + total.toFixed(2));
    }

    // Crear orden de compra
    function createPurchaseOrder() {
        if (currentOrder.items.length === 0) {
            showNotification('Error', 'No hay productos en la orden', 'error');
            return;
        }

        if (!selectedSupplierId) {
            showNotification('Error', 'Debe seleccionar un proveedor', 'error');
            return;
        }

        // Validar cantidades mínimas
        for (const item of currentOrder.items) {
            if (item.quantity < item.minOrder) {
                showNotification('Error', `La cantidad de ${item.name} es menor al mínimo requerido (${item.minOrder})`, 'error');
                return;
            }
        }

        // Crear nueva orden
        const newOrder = {
            id: 'PO-' + String(purchaseOrders.length + 1).padStart(3, '0'),
            supplierId: selectedSupplierId,
            date: new Date().toISOString().split('T')[0],
            expectedDate: $('#expectedDeliveryDate').val(),
            status: 'pending',
            items: [...currentOrder.items],
            subtotal: currentOrder.subtotal,
            taxes: currentOrder.taxes,
            total: currentOrder.total
        };

        // Agregar a la lista de órdenes
        purchaseOrders.unshift(newOrder);

        // Actualizar la interfaz
        loadPurchaseOrders();
        clearOrder();

        showNotification('Éxito', `Orden de compra ${newOrder.id} creada correctamente`, 'success');
    }

    // Limpiar orden
    function clearOrder() {
        currentOrder = {
            supplierId: null,
            items: [],
            subtotal: 0,
            taxes: 0,
            total: 0
        };

        selectedSupplierId = null;
        $('.supplier-card').removeClass('active');
        $('#selectedSupplier').html('<div class="text-center text-muted">Ningún proveedor seleccionado</div>');
        $('#supplierProducts').html('<div class="text-center text-muted py-4"><i class="icon-base bx bx-package display-4"></i><p class="mt-2">Seleccione un proveedor para ver sus productos</p></div>');
        $('#expectedDeliveryDate').val('');

        updateOrderDisplay();
    }

    // Ver detalles de una orden
    function viewOrderDetails(orderId) {
        const order = purchaseOrders.find(o => o.id === orderId);
        if (!order) return;

        const supplier = suppliers.find(s => s.id === order.supplierId);

        // Actualizar información básica
        $('#orderId').text(order.id);
        $('#detailSupplier').text(supplier ? supplier.name : 'Proveedor no disponible');
        $('#detailDate').text(order.date);
        $('#detailExpectedDate').text(order.expectedDate);

        // Actualizar estado
        let statusText = '';
        switch (order.status) {
            case 'pending':
                statusText = '<span class="order-status status-pending">Pendiente</span>';
                break;
            case 'approved':
                statusText = '<span class="order-status status-approved">Aprobada</span>';
                break;
            case 'rejected':
                statusText = '<span class="order-status status-rejected">Rechazada</span>';
                break;
            case 'received':
                statusText = '<span class="order-status status-received">Recibida</span>';
                break;
        }
        $('#detailStatus').html(statusText);

        // Actualizar productos
        const productsContainer = $('#orderDetailsProducts');
        productsContainer.empty();

        order.items.forEach(item => {
            const product = products.find(p => p.id === item.productId);
            const productRow = `
                    <tr>
                        <td>${product ? product.name : 'Producto no disponible'}</td>
                        <td>${item.quantity}</td>
                        <td>$${item.price.toFixed(2)}</td>
                        <td>$${(item.price * item.quantity).toFixed(2)}</td>
                    </tr>
                `;
            productsContainer.append(productRow);
        });

        // Actualizar totales
        $('#detailSubtotal').text('$' + order.subtotal.toFixed(2));
        $('#detailTaxes').text('$' + order.taxes.toFixed(2));
        $('#detailTotal').text('$' + order.total.toFixed(2));

        // Configurar acciones según el estado
        const actionsContainer = $('#orderActions');
        actionsContainer.empty();

        if (order.status === 'pending') {
            actionsContainer.html(`
                    <div class="d-grid gap-2">
                        <button class="btn btn-success" onclick="updateOrderStatus('${order.id}', 'approved')">
                            <i class="icon-base bx bx-check"></i> Aprobar Orden
                        </button>
                        <button class="btn btn-danger" onclick="updateOrderStatus('${order.id}', 'rejected')">
                            <i class="icon-base bx bx-x"></i> Rechazar Orden
                        </button>
                    </div>
                `);
        } else if (order.status === 'approved') {
            actionsContainer.html(`
                    <div class="d-grid">
                        <button class="btn btn-primary" onclick="updateOrderStatus('${order.id}', 'received')">
                            <i class="icon-base bx bx-package"></i> Marcar como Recibida
                        </button>
                    </div>
                `);
        }

        // Mostrar el modal
        new bootstrap.Modal(document.getElementById('orderDetailsModal')).show();
    }

    // Actualizar estado de una orden
    function updateOrderStatus(orderId, status) {
        const order = purchaseOrders.find(o => o.id === orderId);
        if (!order) return;

        order.status = status;

        // Si la orden fue recibida, actualizar el stock
        if (status === 'received') {
            order.items.forEach(item => {
                const product = products.find(p => p.id === item.productId);
                if (product) {
                    product.currentStock += item.quantity;
                }
            });
        }

        // Actualizar la interfaz
        loadPurchaseOrders();

        // Cerrar el modal
        bootstrap.Modal.getInstance(document.getElementById('orderDetailsModal')).hide();

        showNotification('Éxito', `Estado de la orden ${orderId} actualizado a ${status}`, 'success');
    }

    // Mostrar notificación
    function showNotification(title, message, type) {
        // En un sistema real, se usaría la librería de notificaciones de la plantilla
        // Por ahora usamos alertas nativas para simplificar
        alert(`${title}: ${message}`);
    }
</script>