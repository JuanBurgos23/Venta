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
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Vendors CSS -->
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión de Compras</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Boxicons -->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <style>
            :root {
                --primary-color: #696cff;
                --primary-hover: #5f61e0;
                --border-radius: 0.375rem;
                --box-shadow: 0 0.125rem 0.25rem rgba(165, 163, 174, 0.3);
            }
            
            body {
                background-color: #f5f5f9;
                font-family: 'Inter', sans-serif;
            }
            
            .main-content {
                background-color: #f5f5f9;
            }
            
            .card {
                border: none;
                border-radius: 0.5rem;
                box-shadow: var(--box-shadow);
                margin-bottom: 1.5rem;
            }
            
            .card-header {
                background-color: #fff;
                border-bottom: 1px solid #d9dee3;
                padding: 1.2rem 1.5rem;
            }
            
            .card-title {
                font-weight: 600;
                margin-bottom: 0;
                color: #566a7f;
            }
            
            .sticky-summary {
                position: sticky;
                top: 20px;
            }
            
            .supplier-card {
                transition: all 0.3s ease;
                cursor: pointer;
            }
            
            .supplier-card:hover, .supplier-card.active {
                border-color: var(--primary-color);
                transform: translateY(-2px);
            }
            
            .supplier-card.active {
                box-shadow: 0 0 0 1px var(--primary-color);
            }
            
            .order-item {
                border-bottom: 1px solid #d9dee3;
                padding: 1rem 0;
            }
            
            .order-item:last-child {
                border-bottom: none;
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
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow);
                z-index: 1000;
                max-height: 300px;
                overflow-y: auto;
            }
            
            .search-item {
                padding: 0.75rem 1rem;
                border-bottom: 1px solid #d9dee3;
                cursor: pointer;
            }
            
            .search-item:hover {
                background-color: #f8f9fa;
            }
            
            .form-label {
                font-weight: 500;
                margin-bottom: 0.5rem;
                color: #566a7f;
            }
            
            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }
            
            .btn-primary:hover {
                background-color: var(--primary-hover);
                border-color: var(--primary-hover);
            }
            
            .table th {
                font-weight: 600;
                color: #566a7f;
            }
            
            .status-badge {
                padding: 0.35em 0.65em;
                font-size: 0.75em;
                font-weight: 600;
            }
            
            .order-summary {
                background-color: #f8f9fa;
                border-radius: var(--border-radius);
                padding: 1.25rem;
            }
            
            .detail-row {
                margin-bottom: 0.75rem;
                padding-bottom: 0.75rem;
                border-bottom: 1px solid #e9ecef;
            }
            
            .detail-row:last-child {
                border-bottom: none;
                margin-bottom: 0;
                padding-bottom: 0;
            }
            
            .product-detail-row {
                background-color: #f8f9fa;
                border-radius: 0.5rem;
                padding: 1rem;
                margin-bottom: 1rem;
            }
            
            .editable-field {
                background-color: #fff;
                border: 1px solid #d9dee3;
                border-radius: 0.375rem;
                padding: 0.375rem 0.75rem;
                width: 100%;
            }
            
            .editable-field:focus {
                outline: none;
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(105, 108, 255, 0.25);
            }
            
            .section-title {
                font-size: 0.875rem;
                font-weight: 600;
                color: #566a7f;
                margin-bottom: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
        </style>


    </head>

    <body>
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
                                              <input type="text" class="form-control" placeholder="Buscar proveedor..." id="supplierSearch" autocomplete="off">
                                              <div class="search-results d-none" id="supplierSearchResults"></div>
                                            </div>
                                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal" id="btnNuevoProveedor">
                                              <i class='bx bx-plus'></i> Nuevo
                                            </button>
                                          </div>
                                        </div>
                                    
                                        <div class="card-body">
                                          <!-- Grid de proveedores -->
                                          <div class="row g-3 mb-4" id="supplierList">
                                            <div class="text-center text-muted py-4">
                                              <i class='bx bx-user-pin display-4'></i>
                                              <p class="mt-2">Cargando proveedores...</p>
                                            </div>
                                          </div>
                                    
                                          <nav>
                                            <ul class="pagination justify-content-center" id="suppliersPagination"></ul>
                                          </nav>
                                    
                                          <hr>
                                    
                                          <!-- Productos del proveedor -->
                                          <h5 class="mb-3">Productos del Proveedor</h5>
                                          <div class="search-box mb-3">
                                            <input type="text" class="form-control" placeholder="Buscar producto..." id="productSearch" disabled>
                                            <div class="search-results d-none" id="productSearchResults"></div>
                                          </div>
                                    
                                          <div id="supplierProducts">
                                            <div class="text-center text-muted py-4">
                                              <i class='bx bx-package display-4'></i>
                                              <p class="mt-2">Seleccione un proveedor para ver sus productos</p>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    
                                      <!-- Historial de órdenes -->
                                      <div class="card mt-4">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                          <h5 class="card-title mb-0">Historial de Órdenes de Compra</h5>
                                          <div class="btn-group">
                                            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                              <i class='bx bx-filter'></i> Filtrar
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
                                                <tr><td colspan="6" class="text-center text-muted">Sin datos</td></tr>
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
  
                                  <!-- Panel de la orden de compra - Rediseñado -->
                                  <div class="col-lg-4">
                                      <div class="card sticky-summary">
                                          <div class="card-header">
                                              <h5 class="card-title mb-0">Orden de Compra</h5>
                                          </div>
                                          <div class="card-body">
                                              <!-- Información de ubicación -->
                                              <div class="section-title">Información de Ubicación</div>
                                              <div class="row g-3 mb-4">
                                                  <div class="col-12">
                                                      <label class="form-label">Sucursal</label>
                                                      <select id="sucursal_id" class="form-select">
                                                          <option value="">Seleccionar sucursal</option>
                                                      </select>
                                                  </div>
                                                  <div class="col-12">
                                                      <label class="form-label">Almacén</label>
                                                      <select id="almacen_id" class="form-select" disabled>
                                                          <option value="">Seleccionar almacén</option>
                                                      </select>
                                                  </div>
                                              </div>
  
                                              <!-- Información del proveedor -->
                                              <div class="section-title">Información del Proveedor</div>
                                              <div class="mb-4">
                                                  <div class="alert alert-info py-2" id="selectedSupplier">
                                                      <div class="text-center text-muted">Ningún proveedor seleccionado</div>
                                                  </div>
                                              </div>
  
                                              <!-- Información de la orden -->
                                              <div class="section-title">Detalles de la Orden</div>
                                              <div class="row g-3 mb-4">
                                                  <div class="col-md-6">
                                                      <label class="form-label">Fecha de Emisión</label>
                                                      <input type="date" class="form-control" id="issueDate" value="{{ date('Y-m-d') }}">
                                                  </div>
                                                  <div class="col-md-6">
                                                      <label class="form-label">Fecha Esperada de Entrega</label>
                                                      <input type="date" class="form-control" id="expectedDeliveryDate">
                                                  </div>
                                                  <div class="col-12">
                                                      <label class="form-label">Términos de Pago</label>
                                                      <select class="form-select" id="paymentTerms">
                                                          <option value="contado">Contado</option>
                                                          <option value="15_dias">15 días</option>
                                                          <option value="30_dias">30 días</option>
                                                          <option value="60_dias">60 días</option>
                                                      </select>
                                                  </div>
                                                  <div class="col-12">
                                                      <label class="form-label">Notas</label>
                                                      <textarea class="form-control" id="orderNotes" rows="2" placeholder="Notas adicionales para la orden"></textarea>
                                                  </div>
                                              </div>
  
                                              <!-- Items de la orden -->
                                              <div class="section-title">Productos</div>
                                              <div class="mb-3">
                                                  <div id="orderItems">
                                                      <div class="text-center text-muted py-4">
                                                          <i class='bx bx-cart-add display-4'></i>
                                                          <p class="mt-2">No hay productos en la orden</p>
                                                      </div>
                                                  </div>
                                              </div>
  
                                              <!-- Resumen de la orden -->
                                              <div class="section-title">Resumen de la Orden</div>
                                              <div class="order-summary">
                                                  <div class="detail-row d-flex justify-content-between">
                                                      <span class="text-muted">Subtotal:</span>
                                                      <span id="orderSubtotal">$0.00</span>
                                                  </div>
                                                  <div class="detail-row d-flex justify-content-between">
                                                      <span class="text-muted">Impuestos (18%):</span>
                                                      <span id="orderTaxes">$0.00</span>
                                                  </div>
                                                  <div class="detail-row d-flex justify-content-between">
                                                      <span class="text-muted">Descuento:</span>
                                                      <div class="d-flex align-items-center">
                                                          <input type="number" class="form-control form-control-sm me-2" id="discountInput" style="width: 80px" min="0" value="0">
                                                          <span>%</span>
                                                      </div>
                                                  </div>
                                                  <div class="detail-row d-flex justify-content-between mb-3 fw-bold">
                                                      <span>Total:</span>
                                                      <span id="orderTotal">$0.00</span>
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
  
      <!-- Modal para agregar proveedor -->
      <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="supplierForm">
                @csrf
                <input type="hidden" id="proveedor_id">
                <div class="modal-header">
                  <h5 class="modal-title" id="supplierModalTitle">Agregar Nuevo Proveedor</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Nombre</label>
                      <input type="text" class="form-control" name="nombre" id="prov_nombre" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Apellido paterno</label>
                      <input type="text" class="form-control" name="paterno" id="prov_paterno">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Apellido materno</label>
                      <input type="text" class="form-control" name="materno" id="prov_materno">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Teléfono</label>
                      <input type="text" class="form-control" name="telefono" id="prov_telefono">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">CI / Documento</label>
                      <input type="text" class="form-control" name="ci" id="prov_ci">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Estado</label>
                      <select class="form-select" name="estado" id="prov_estado">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                      </select>
                    </div>
                  </div>
        
                  <div class="alert alert-danger d-none mt-3" id="formErrorsProv">
                    <ul class="mb-0" id="formErrorsListProv"></ul>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-label-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                  <button class="btn btn-primary" id="btnGuardarProveedor" type="submit">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        
        <!-- Toast simple -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
          <div class="toast bs-toast text-white bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
              <div class="toast-body">...</div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
          </div>
        </div>
        
      <!-- Modal para detalles de producto -->
      <div class="modal fade" id="productDetailModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title">Detalles del Producto</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <form id="productDetailForm">
                          <input type="hidden" id="detailProductId">
                          <div class="row mb-4">
                              <div class="col-md-8">
                                  <h6 id="detailProductName"></h6>
                                  <p class="text-muted mb-0" id="detailProductCategory"></p>
                              </div>
                              <div class="col-md-4 text-end">
                                  <p class="mb-0">Precio base: <span id="detailBasePrice" class="fw-bold"></span></p>
                              </div>
                          </div>
                          
                          <div class="product-detail-row">
                              <div class="row g-3">
                                  <div class="col-md-4">
                                      <label class="form-label">Cantidad</label>
                                      <input type="number" class="form-control" id="detailQuantity" min="1" value="1">
                                  </div>
                                  <div class="col-md-4">
                                      <label class="form-label">Costo Unitario</label>
                                      <div class="input-group">
                                          <span class="input-group-text">$</span>
                                          <input type="number" class="form-control" id="detailUnitCost" step="0.01" min="0">
                                      </div>
                                  </div>
                                  <div class="col-md-4">
                                      <label class="form-label">Total</label>
                                      <div class="form-control" id="detailTotalCost">$0.00</div>
                                  </div>
                                  <div class="col-md-6">
                                      <label class="form-label">Número de Lote</label>
                                      <input type="text" class="form-control" id="detailLotNumber">
                                  </div>
                                  <div class="col-md-6">
                                      <label class="form-label">Fecha de Vencimiento</label>
                                      <input type="date" class="form-control" id="detailExpiryDate">
                                  </div>
                                  <div class="col-12">
                                      <label class="form-label">Notas del Producto</label>
                                      <textarea class="form-control" id="detailProductNotes" rows="2"></textarea>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Cancelar</button>
                      <button type="button" class="btn btn-primary" id="saveProductDetails">Agregar a la Orden</button>
                  </div>
              </div>
          </div>
      </div>
  
      <!-- Core JS -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>








<!-- / Layout wrapper -->

<!-- Modal para agregar proveedor -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="supplierForm">
          @csrf
          <input type="hidden" id="proveedor_id">
          <div class="modal-header">
            <h5 class="modal-title" id="supplierModalTitle">Agregar Nuevo Proveedor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="prov_nombre" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Apellido paterno</label>
                <input type="text" class="form-control" name="paterno" id="prov_paterno">
              </div>
              <div class="col-md-6">
                <label class="form-label">Apellido materno</label>
                <input type="text" class="form-control" name="materno" id="prov_materno">
              </div>
              <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" id="prov_telefono">
              </div>
              <div class="col-md-6">
                <label class="form-label">CI / Documento</label>
                <input type="text" class="form-control" name="ci" id="prov_ci">
              </div>
              <div class="col-md-6">
                <label class="form-label">Estado</label>
                <select class="form-select" name="estado" id="prov_estado">
                  <option value="1">Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div>
  
            <div class="alert alert-danger d-none mt-3" id="formErrorsProv">
              <ul class="mb-0" id="formErrorsListProv"></ul>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-label-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
            <button class="btn btn-primary" id="btnGuardarProveedor" type="submit">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Toast simple -->
  <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
    <div class="toast bs-toast text-white bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">...</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
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
  $(function(){
      // ------------------ Config ------------------
      const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  
      const URLS = {
          proveedores: {
              fetch : `{{ route('proveedores.fetch') }}`,
              store : `{{ route('proveedores.store') }}`,
              base  : `{{ url('proveedores') }}`
          },
          productos: {
              fetch : `{{ route('productos.fetch') }}`
          },
          compras: {
              store : `{{ route('compras.store') }}`
          },
          sucursal: { 
              fetch: `{{ route('sucursal.fetch') }}` 
          },
          almacen:  { 
              fetch: `{{ route('almacen.fetch') }}` 
          }
      };
  
      // ------------------ Estado ------------------
      let currentPageProv = 1;
      let currentSearchProv = '';
      let debounceTimer = null;
  
      let selectedSupplier = null;
      let _productsCache = [];
      let currentProductDetails = null;

      const order = {
          items: [],
          subtotal: 0,
          taxes: 0,
          discount: 0,
          total: 0
      };
  
      // ------------------ Utils ------------------
      const money = n => '$' + (Number(n||0)).toFixed(2);
      const escapeHtml = s => (s ?? '').toString()
          .replaceAll('&','&amp;').replaceAll('<','&lt;')
          .replaceAll('>','&gt;').replaceAll('"','&quot;')
          .replaceAll("'",'&#39;');
      const attr = s => escapeHtml(s).replaceAll('"','&quot;');
      const notifyOk = (m) => {
          const toast = new bootstrap.Toast(document.querySelector('.toast'));
          document.querySelector('.toast-body').textContent = m;
          toast.show();
      };
      const notifyError = (m) => alert(m || 'Ocurrió un error');
  
      // ============================================================
      // PROVEEDORES
      // ============================================================
      async function fetchSuppliers(page=1, search=''){
          const url = new URL(URLS.proveedores.fetch, window.location.origin);
          url.searchParams.set('page', page);
          if (search) url.searchParams.set('search', search);
          const r = await fetch(url, { headers: { 'Accept':'application/json' }});
          const data = await r.json();
          renderSuppliers(data);
      }
  
      function renderSuppliers(resp){
          const $list = $('#supplierList').empty();
          const rows = resp?.data || [];
          if (!rows.length){
              $list.html(`
                  <div class="col-12">
                      <div class="text-center text-muted py-4">
                          <i class='bx bx-user-x display-4'></i>
                          <p class="mt-2">No hay proveedores</p>
                      </div>
                  </div>
              `);
              renderProvPagination(1,1);
              return;
          }
  
          rows.forEach(p => {
              const fullName = `${p.nombre ?? ''} ${p.paterno ?? ''} ${p.materno ?? ''}`.trim();
              $list.append(`
                  <div class="col-md-6 mb-3">
                      <div class="card supplier-card h-100" data-id="${p.id}">
                          <div class="card-body d-flex flex-column">
                              <h5 class="card-title mb-1">${escapeHtml(fullName)}</h5>
                              <div class="small text-muted mb-2">CI: ${escapeHtml(p.ci ?? '-')}</div>
                              <div class="small text-muted mb-3">Tel: ${escapeHtml(p.telefono ?? '-')}</div>
                              <div class="mt-auto d-flex gap-2">
                                  <button class="btn btn-sm btn-outline-primary select-supplier">Seleccionar</button>
                                  <button class="btn btn-sm btn-warning btn-edit"
                                          data-id="${p.id}"
                                          data-nombre="${attr(p.nombre)}"
                                          data-paterno="${attr(p.paterno)}"
                                          data-materno="${attr(p.materno)}"
                                          data-telefono="${attr(p.telefono)}"
                                          data-ci="${attr(p.ci)}">Editar</button>
                                  <button class="btn btn-sm btn-danger btn-delete" data-id="${p.id}">Eliminar</button>
                              </div>
                          </div>
                      </div>
                  </div>
              `);
          });
  
          renderProvPagination(resp.current_page, resp.last_page);
      }
  
      function renderProvPagination(page, last){
          const $pag = $('#suppliersPagination');
          let html = `
              <li class="page-item ${page<=1?'disabled':''}">
                  <a class="page-link" href="#" data-page="${page-1}">Anterior</a>
              </li>
          `;
          for (let i=1;i<=last;i++){
              html += `
                  <li class="page-item ${i===page?'active':''}">
                      <a class="page-link" href="#" data-page="${i}">${i}</a>
                  </li>
              `;
          }
          html += `
              <li class="page-item ${page>=last?'disabled':''}">
                  <a class="page-link" href="#" data-page="${page+1}">Siguiente</a>
              </li>
          `;
          $pag.html(html);
  
          $pag.find('a.page-link').off('click').on('click', function(e){
              e.preventDefault();
              const p = parseInt($(this).data('page'));
              if (!isNaN(p) && p>=1 && p<=last && p!==currentPageProv){
                  currentPageProv = p;
                  fetchSuppliers(currentPageProv, currentSearchProv);
              }
          });
      }

      // Cargar sucursales y almacenes
      async function loadSucursales(){
          const url = new URL(URLS.sucursal.fetch, window.location.origin);
          url.searchParams.set('per_page', 200);
          const res = await fetch(url, { headers:{'Accept':'application/json'} });
          const data = await res.json();
          const $s = $('#sucursal_id').empty();
          const items = data.data || [];
          if (!items.length){
              $s.append('<option value="">(sin sucursales)</option>');
              $('#almacen_id').prop('disabled', true).empty().append('<option value="">(sin almacenes)</option>');
              return;
          }
          items.forEach(it => $s.append(`<option value="${it.id}">${it.nombre}</option>`));
          // seleccionar 1ª y cargar almacenes
          $s.val(items[0].id).trigger('change');
      }

      async function loadAlmacenes(sucursalId){
          const url = new URL(URLS.almacen.fetch, window.location.origin);
          url.searchParams.set('per_page', 200);
          if (sucursalId) url.searchParams.set('sucursal_id', sucursalId);
          const res = await fetch(url, { headers:{'Accept':'application/json'} });
          const data = await res.json();
          const $a = $('#almacen_id').empty();
          const items = data.data || [];
          if (!items.length){
              $a.append('<option value="">(sin almacenes)</option>').prop('disabled', true);
              return;
          }
          items.forEach(it => $a.append(`<option value="${it.id}">${it.nombre}</option>`));
          $a.prop('disabled', false);
      }

      // Eventos de selects
      $(document).on('change', '#sucursal_id', function(){
          const sid = $(this).val();
          $('#almacen_id').prop('disabled', true).empty().append('<option value="">Cargando...</option>');
          loadAlmacenes(sid);
      });

      // Llamar al inicio
      loadSucursales();
  
      function setSelectedSupplierCard(id){
          $('.supplier-card').removeClass('active');
          $(`.supplier-card[data-id="${id}"]`).addClass('active');
      }
  
      function selectSupplierFromCard(card){
          const id = Number(card?.dataset?.id);
          if (!id) return;
          const title = card.querySelector('.card-title')?.innerText || '';
          selectedSupplier = { id, nombre: title };
          setSelectedSupplierCard(id);
          $('#selectedSupplier').html(`<strong>${escapeHtml(title)}</strong>`);
          $('#productSearch').prop('disabled', false).focus();
          // cargar productos del proveedor
          fetchProducts({ page:1, search:'', proveedor_id: id });
      }
  
      // ============================================================
      // PRODUCTOS
      // ============================================================
      async function fetchProducts({page=1, search='', proveedor_id=null} = {}) {
          const url = new URL(URLS.productos.fetch, window.location.origin);
          url.searchParams.set('page', page);
          if (search)       url.searchParams.set('search', search);
          if (proveedor_id) url.searchParams.set('proveedor_id', proveedor_id);
  
          const res = await fetch(url, { headers: { 'Accept':'application/json' } });
          if (!res.ok) { console.error('Error HTTP', res.status); return; }
          const data = await res.json();
  
          _productsCache = (data?.data || []).map(p => ({
              id: Number(p.id),
              nombre: p.nombre ?? '',
              precio: Number(p.precio ?? 0),
              categoria: p.categoria ?? null,
              subcategoria: p.subcategoria ?? null,
              stock_actual: p.stock_actual ?? null,
              minimo: p.minimo ?? null
          }));
  
          renderProductsList(_productsCache);
          renderProductSearchResults(_productsCache, {show:false});
      }
  
      function renderProductsList(list, {target='#supplierProducts', emptyMsg='No hay productos'} = {}){
          const $ctn = $(target).empty();
          if (!list.length) {
              $ctn.html(`
                  <div class="text-center text-muted py-4">
                      <i class='bx bx-package display-4'></i>
                      <p class="mt-2">${emptyMsg}</p>
                  </div>
              `);
              return;
          }
  
          list.forEach(p => {
              const precio = money(p.precio);
              const cat = escapeHtml(p.categoria?.nombre ?? '-');
              const sub = p.subcategoria?.nombre ? ' · ' + escapeHtml(p.subcategoria.nombre) : '';
              const stockInfo = (p.stock_actual != null && p.minimo != null)
                  ? `<small class="${Number(p.stock_actual) < Number(p.minimo) ? 'text-danger' : 'text-muted'}">
                      Stock: ${p.stock_actual} (Mín: ${p.minimo})
                      </small>` : '';
  
              $ctn.append(`
                  <div class="product-selector" data-id="${p.id}">
                      <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                          <div>
                              <h6 class="mb-1">${escapeHtml(p.nombre)}</h6>
                              <small class="text-muted">${cat}${sub}</small>
                          </div>
                          <div class="text-end">
                              <span class="fw-bold">${precio}</span>
                              <div class="mt-1">${stockInfo}</div>
                              <button class="btn btn-sm btn-primary mt-2 add-to-order" data-id="${p.id}">Agregar</button>
                          </div>
                      </div>
                  </div>
              `);
          });
      }
  
      function renderProductSearchResults(list, {show=true} = {}){
          const $res = $('#productSearchResults').empty();
          if (!list.length) {
              $res.html('<div class="search-item px-2 py-2 text-muted">No se encontraron productos</div>');
          } else {
              list.forEach(p => {
                  $res.append(`
                      <div class="search-item px-2 py-2" data-id="${p.id}">
                          <div class="d-flex justify-content-between">
                              <span>${escapeHtml(p.nombre)}</span>
                              <span>${money(p.precio)}</span>
                          </div>
                          <small class="text-muted">
                              ${escapeHtml(p.categoria?.nombre ?? '-')}${p.subcategoria?.nombre ? ' · ' + escapeHtml(p.subcategoria.nombre) : ''}
                          </small>
                      </div>
                  `);
              });
          }
          if (show) $res.removeClass('d-none'); else $res.addClass('d-none');
      }

      // Abrir modal de detalles de producto
      function openProductDetailModal(productId) {
          const p = _productsCache.find(x => x.id === productId);
          if (!p) return;
          
          currentProductDetails = p;
          
          $('#detailProductId').val(p.id);
          $('#detailProductName').text(p.nombre);
          $('#detailProductCategory').text(`${p.categoria?.nombre || ''} ${p.subcategoria?.nombre ? ' / ' + p.subcategoria.nombre : ''}`);
          $('#detailBasePrice').text(money(p.precio));
          $('#detailUnitCost').val(p.precio);
          $('#detailQuantity').val(1);
          $('#detailLotNumber').val('');
          $('#detailExpiryDate').val('');
          $('#detailProductNotes').val('');
          
          calculateDetailTotal();
          
          const modal = new bootstrap.Modal(document.getElementById('productDetailModal'));
          modal.show();
      }
      
      function calculateDetailTotal() {
          const quantity = parseInt($('#detailQuantity').val()) || 0;
          const unitCost = parseFloat($('#detailUnitCost').val()) || 0;
          const total = quantity * unitCost;
          $('#detailTotalCost').text(money(total));
      }
  
      // ============================================================
      // ORDEN (carrito)
      // ============================================================
      function addToOrderWithDetails(details) {
          if (!selectedSupplier){
              notifyError('Seleccione un proveedor primero');
              return;
          }
          
          const it = order.items.find(i => i.producto_id === details.producto_id && i.lote === details.lote);
          if (it) {
              it.cantidad += details.cantidad;
          } else {
              order.items.push({
                  producto_id: details.producto_id,
                  nombre: details.nombre,
                  precio: details.precio,
                  cantidad: details.cantidad,
                  lote: details.lote,
                  fecha_vencimiento: details.fecha_vencimiento,
                  notas: details.notas
              });
          }
          
          recalcOrder(); 
          renderOrder();
      }
  
      function changeQty(producto_id, lote, delta){
          const it = order.items.find(x => x.producto_id === producto_id && x.lote === lote);
          if (!it) return;
          it.cantidad += delta;
          if (it.cantidad <= 0) {
              order.items = order.items.filter(x => !(x.producto_id === producto_id && x.lote === lote));
          }
          recalcOrder(); 
          renderOrder();
      }
  
      function removeItem(producto_id, lote){
          order.items = order.items.filter(x => !(x.producto_id === producto_id && x.lote === lote));
          recalcOrder(); 
          renderOrder();
      }
  
      function recalcOrder(){
          const subtotal = order.items.reduce((s,i)=> s + i.precio*i.cantidad, 0);
          const taxes = subtotal * 0.18;
          const discount = subtotal * (order.discount / 100);
          order.subtotal = subtotal; 
          order.taxes = taxes; 
          order.total = subtotal + taxes - discount;
          
          $('#orderSubtotal').text(money(order.subtotal));
          $('#orderTaxes').text(money(order.taxes));
          $('#orderTotal').text(money(order.total));
      }
  
      function renderOrder(){
          const $box = $('#orderItems');
          if (!order.items.length) {
              $box.html(`
                  <div class="text-center text-muted py-4">
                      <i class='bx bx-cart-add display-4'></i>
                      <p class="mt-2">No hay productos en la orden</p>
                  </div>
              `);
              return;
          }
          
          let html = '';
          order.items.forEach(it => {
              const tot = it.precio * it.cantidad;
              const loteInfo = it.lote ? `<small class="text-muted d-block">Lote: ${escapeHtml(it.lote)}</small>` : '';
              const expiryInfo = it.fecha_vencimiento ? `<small class="text-muted d-block">Vence: ${it.fecha_vencimiento}</small>` : '';
              
              html += `
                  <div class="order-item" data-id="${it.producto_id}" data-lote="${it.lote || ''}">
                      <div class="d-flex justify-content-between">
                          <div class="w-60">
                              <h6 class="mb-1">${escapeHtml(it.nombre)}</h6>
                              ${loteInfo}
                              ${expiryInfo}
                              <small class="text-muted">${money(it.precio)} c/u</small>
                          </div>
                          <div class="text-end">
                              <span class="fw-bold">${money(tot)}</span>
                              <div class="mt-2 d-flex align-items-center">
                                  <button class="btn btn-sm btn-outline-secondary btn-dec">-</button>
                                  <span class="mx-2">${it.cantidad}</span>
                                  <button class="btn btn-sm btn-outline-secondary btn-inc">+</button>
                                  <button class="btn btn-sm btn-outline-danger ms-2 btn-del"><i class='bx bx-trash'></i></button>
                              </div>
                          </div>
                      </div>
                  </div>
              `;
          });
          $box.html(html);
      }
  
      async function createPurchaseOrder(){
          if (!selectedSupplier){ notifyError('Seleccione un proveedor'); return; }
          if (!order.items.length){ notifyError('No hay productos'); return; }
          
          const sucursalId = $('#sucursal_id').val();
          const almacenId = $('#almacen_id').val();
          if (!sucursalId || !almacenId) {
              notifyError('Seleccione una sucursal y un almacén');
              return;
          }
  
          const orderData = {
              id_proveedor: selectedSupplier.id,
              proveedor_id: selectedSupplier.id,
              almacen_id: Number(almacenId),
              sucursal_id: Number(sucursalId),
              fecha_emision: $('#issueDate').val(),
              fecha_esperada: $('#expectedDeliveryDate').val(),
              terminos_pago: $('#paymentTerms').val(),
              notas: $('#orderNotes').val(),
              descuento: order.discount,
              items: order.items.map(it => ({
                  producto_id: it.producto_id,
                  cantidad: it.cantidad,
                  costo_unitario: it.precio,
                  lote: it.lote || null,
                  fecha_vencimiento: it.fecha_vencimiento || null,
                  notas: it.notas || null
              }))
          };
  
          try {
              const res = await fetch(URLS.compras.store, {
                  method:'POST',
                  headers:{
                      'X-CSRF-TOKEN': CSRF,
                      'Accept':'application/json',
                      'Content-Type':'application/json'
                  },
                  body: JSON.stringify(orderData)
              });
              
              const data = await res.json();
              if (data.status !== 'success') {
                  throw new Error(data.message || 'No se pudo crear la orden');
              }

              notifyOk(`Orden creada (ID: ${data.compra?.id ?? '-'})`);
              clearOrder();
          } catch (error) {
              notifyError(error.message);
          }
      }
  
      function clearOrder(){
          selectedSupplier = null;
          order.items = [];
          order.discount = 0;
          recalcOrder(); 
          renderOrder();
          $('.supplier-card').removeClass('active');
          $('#selectedSupplier').html('<div class="text-center text-muted">Ningún proveedor seleccionado</div>');
          $('#productSearch').val('').prop('disabled', true);
          $('#productSearchResults').empty().addClass('d-none');
          $('#expectedDeliveryDate').val('');
          $('#paymentTerms').val('contado');
          $('#orderNotes').val('');
          $('#discountInput').val(0);
      }
  
      // ============================================================
      // EVENTOS
      // ============================================================
      // Carga inicial
      fetchSuppliers();
  
      // Buscar proveedores
      $('#supplierSearch').on('input', function(){
          currentSearchProv = $(this).val().trim();
          currentPageProv = 1;
          fetchSuppliers(currentPageProv, currentSearchProv);
      });
  
      // Seleccionar proveedor
      $(document).on('click', '.select-supplier', function(){
          const card = this.closest('.supplier-card');
          selectSupplierFromCard(card);
      });
  
      // Buscar productos (con debounce)
      $('#productSearch').on('input', function(){
          const term = $(this).val().trim();
          clearTimeout(debounceTimer);
          if (!term){
              $('#productSearchResults').addClass('d-none').empty();
              // si hay proveedor seleccionado y no hay término, recarga su catálogo
              if (selectedSupplier) fetchProducts({page:1, search:'', proveedor_id: selectedSupplier.id});
              return;
          }
          debounceTimer = setTimeout(()=> {
              fetchProducts({ page:1, search: term, proveedor_id: selectedSupplier?.id || null });
              renderProductSearchResults(_productsCache, {show:true});
          }, 250);
      });
      
      // Click en resultado de búsqueda de productos
      $(document).on('click', '#productSearchResults .search-item', function(){
          const id = Number($(this).data('id'));
          openProductDetailModal(id);
          $('#productSearch').val('');
          $('#productSearchResults').addClass('d-none').empty();
      });
      
      // Click en botón "Agregar" de productos
      $(document).on('click', '.add-to-order', function(){
          const id = Number($(this).data('id'));
          openProductDetailModal(id);
      });
      
      // Calcular total en modal de detalles
      $(document).on('input', '#detailQuantity, #detailUnitCost', function(){
          calculateDetailTotal();
      });
      
      // Guardar detalles del producto
      $(document).on('click', '#saveProductDetails', function(){
          const productId = $('#detailProductId').val();
          const product = _productsCache.find(p => p.id === Number(productId));
          
          if (!product) return;
          
          const details = {
              producto_id: product.id,
              nombre: product.nombre,
              precio: parseFloat($('#detailUnitCost').val()) || 0,
              cantidad: parseInt($('#detailQuantity').val()) || 1,
              lote: $('#detailLotNumber').val().trim() || null,
              fecha_vencimiento: $('#detailExpiryDate').val() || null,
              notas: $('#detailProductNotes').val().trim() || null
          };
          
          addToOrderWithDetails(details);
          
          // Cerrar modal
          bootstrap.Modal.getInstance(document.getElementById('productDetailModal')).hide();
      });
  
      // Botones +/- del carrito
      $(document).on('click', '.btn-inc', function(){
          const $item = $(this).closest('.order-item');
          const id = Number($item.data('id'));
          const lote = $item.data('lote') || '';
          changeQty(id, lote, +1);
      });
      
      $(document).on('click', '.btn-dec', function(){
          const $item = $(this).closest('.order-item');
          const id = Number($item.data('id'));
          const lote = $item.data('lote') || '';
          changeQty(id, lote, -1);
      });
      
      $(document).on('click', '.btn-del', function(){
          const $item = $(this).closest('.order-item');
          const id = Number($item.data('id'));
          const lote = $item.data('lote') || '';
          removeItem(id, lote);
      });
      
      // Cambio de descuento
      $(document).on('input', '#discountInput', function(){
          order.discount = parseFloat($(this).val()) || 0;
          recalcOrder();
      });
  
      // Crear orden y limpiar
      $('#createPurchaseOrder').on('click', async function(){
          try{ 
              await createPurchaseOrder(); 
          } catch(e){ 
              notifyError(e.message); 
          }
      });
      
      $('#clearOrder').on('click', clearOrder);
  });
</script>
  
  
    
    
 