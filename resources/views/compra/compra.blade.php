<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg compact-main">

        @vite([ 'resources/js/app.js'])
        
        <div class="container-fluid py-2 px-2">
            <div class="col-12">
                <div class="card my-2 shadow-sm">
                    <!-- Header mejorado -->
                    <div class="card-header p-3 pb-2 bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1 font-weight-bolder text-dark">Registro de Ingreso a Inventario</h6>
                                <div class="text-sm text-secondary d-flex flex-wrap align-items-center">
                                    <span class="d-flex align-items-center me-3">
                                        <i class="fas fa-user me-1"></i>
                                        Almacenero: <span id="warehouse-manager" class="ms-1 fw-bold text-dark">{{ Auth::user()->name ?? 'Usuario' }}</span>
                                    </span>
                                    <span class="d-flex align-items-center">
                                        <i class="fas fa-calendar me-1"></i>
                                        <input type="date" class="form-control form-control-sm border-0 bg-transparent p-0 ms-1 text-dark fw-medium" 
                                               id="entry-date" value="{{ date('Y-m-d') }}" style="width: auto; max-width: 140px;">
                                    </span>
                                </div>
                            </div>
                            <span class="badge bg-gradient-primary fs-6">Compra</span>
                        </div>
                    </div>
                    
                    <div class="card-body p-3 pt-4">
                        <div class="row">
                            <div class="col-12">
                                
                                <!-- SECCIÓN 1: Información básica de la compra - MEJORADA -->
                                <div class="card card-body border-radius-lg mb-4 border">
                                    <div class="section-header mb-3">
                                        <h6 class="mb-2 font-weight-bolder text-dark d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2 text-primary"></i>
                                            Información de la Compra
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">Complete los datos principales del ingreso</p>
                                    </div>
                                    
                                    <div class="row g-3">
                                        <!-- Proveedor mejorado -->
                                        <div class="col-md-6">
                                            <label class="form-label text-sm fw-bold mb-1">Proveedor <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-truck text-primary"></i>
                                                </span>
                                                <select class="form-select border-start-0 ps-0" id="supplier-select" style="min-height: 44px;">
                                                    <!-- Los proveedores se cargarán aquí mediante JavaScript -->
                                                </select>
                                                <button class="btn btn-outline-primary border" type="button" id="new-supplier-btn" title="Nuevo proveedor">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Almacén mejorado -->
                                        <div class="col-md-6">
                                            <label class="form-label text-sm fw-bold mb-1">Almacén Destino <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-warehouse text-primary"></i>
                                                </span>
                                                <select class="form-select border-start-0 ps-0" id="warehouse-select" style="min-height: 44px;">
                                                    <!-- Los almacenes se cargarán aquí mediante JavaScript -->
                                                </select>
                                                <button class="btn btn-outline-primary border" type="button" id="new-warehouse-btn" title="Nuevo almacén">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Tipo de Inventario mejorado -->
                                        <div class="col-md-6">
                                            <label class="form-label text-sm fw-bold mb-1">Tipo de Inventario</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-boxes text-primary"></i>
                                                </span>
                                                <select class="form-select border-start-0 ps-0" id="inventory-type" style="min-height: 44px;">
                                                    <option value="finished">Producto terminado</option>
                                                    <option value="raw">Materia prima</option>
                                                    <option value="supplies">Insumos</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Motivo mejorado -->
                                        <div class="col-md-6">
                                            <label class="form-label text-sm fw-bold mb-1">Motivo del Ingreso</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-clipboard-list text-primary"></i>
                                                </span>
                                                <select class="form-select border-start-0 ps-0" id="reason" style="min-height: 44px;">
                                                    <option value="purchase">Compra</option>
                                                    <option value="transfer">Traslado</option>
                                                    <option value="production">Producción</option>
                                                    <option value="adjustment">Ajuste</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- SECCIÓN 2: Información de pago y facturación - MEJORADA -->
                                <div class="card card-body border-radius-lg mb-4 border">
                                    <div class="section-header mb-3">
                                        <h6 class="mb-2 font-weight-bolder text-dark d-flex align-items-center">
                                            <i class="fas fa-file-invoice-dollar me-2 text-primary"></i>
                                            Información de Pago
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">Detalles de pago y facturación</p>
                                    </div>
                                    
                                    <div class="row g-3">
                                        <!-- Forma de pago mejorado -->
                                        <div class="col-md-6">
                                            <label class="form-label text-sm fw-bold mb-1">Forma de pago</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-money-bill-wave text-primary"></i>
                                                </span>
                                                <select class="form-select border-start-0 ps-0" id="payment-form" style="min-height: 44px;">
                                                    <option value="cash">Contado</option>
                                                    <option value="credit">Crédito</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Tipo de pago mejorado -->
                                        <div class="col-md-6">
                                            <label class="form-label text-sm fw-bold mb-1">Tipo de pago</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light border-end-0">
                                                    <i class="fas fa-credit-card text-primary"></i>
                                                </span>
                                                <select class="form-select border-start-0 ps-0" id="payment-type" style="min-height: 44px;">
                                                    <option value="cash">Efectivo</option>
                                                    <option value="transfer">Transferencia</option>
                                                    <option value="check">Cheque</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <!-- Factura mejorado -->
                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label text-sm fw-bold mb-1">¿Esta compra tiene factura?</label>
                                                    <div class="d-flex align-items-center mt-1">
                                                        <div class="form-check me-4">
                                                            <input class="form-check-input" type="radio" name="hasInvoice" id="hasInvoiceYes" value="yes">
                                                            <label class="form-check-label fw-medium" for="hasInvoiceYes">
                                                                <i class="fas fa-check-circle me-1 text-success"></i>Sí
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="hasInvoice" id="hasInvoiceNo" value="no" checked>
                                                            <label class="form-check-label fw-medium" for="hasInvoiceNo">
                                                                <i class="fas fa-times-circle me-1 text-danger"></i>No
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 invoice-number-container" style="overflow: hidden; max-width: 0; transition: max-width 0.5s ease, opacity 0.5s ease; opacity: 0;">
                                                    <label class="form-label text-sm fw-bold mb-1">N° Factura</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="fas fa-file-invoice text-primary"></i>
                                                        </span>
                                                        <input type="text" class="form-control border-start-0 ps-0" id="invoice-number" placeholder="Número de factura">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Observación mejorado -->
                                        <div class="col-12">
                                            <label class="form-label text-sm fw-bold mb-1">Observaciones</label>
                                            <div class="input-group">
                                                <span class="input-group-text bg-light align-items-start">
                                                    <i class="fas fa-sticky-note text-primary mt-1"></i>
                                                </span>
                                                <textarea class="form-control border-start-0 ps-0" id="observation" rows="2" 
                                                          placeholder="Observaciones adicionales sobre la compra..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- SECCIÓN 3: Gestión de productos - MEJORADA -->
                                <div class="card card-body border-radius-lg border">
                                    <div class="section-header mb-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1 font-weight-bolder text-dark d-flex align-items-center">
                                                    <i class="fas fa-box-open me-2 text-primary"></i>
                                                    Productos a Ingresar
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">Seleccione y configure los productos de la compra</p>
                                            </div>
                                            <a href="{{route('productos.index')}}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-plus me-1"></i> Nuevo Producto
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Buscador de productos mejorado -->
                                    <div class="mb-4">
                                        <label class="form-label text-sm fw-bold mb-1">Buscar Producto</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="fas fa-search text-primary"></i>
                                            </span>
                                            <select class="form-select border-start-0 ps-0" id="product-select">
                                                <option value="">Seleccionar producto...</option>
                                                <!-- Los productos se cargarán aquí mediante JavaScript -->
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Detalles del producto seleccionado mejorado -->
                                    <div class="card border mb-4 d-none" id="product-details-card">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0 text-dark font-weight-bold">Detalles del Producto</h6>
                                        </div>
                                        <div class="card-body py-3">
                                            <div class="row g-2">
                                                <div class="col-md-4">
                                                    <span class="text-xs text-secondary">Tipo de precio:</span>
                                                    <span class="d-block text-sm fw-bold" id="product-price-type">-</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-xs text-secondary">Precio referencial:</span>
                                                    <span class="d-block text-sm fw-bold" id="product-price">-</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-xs text-secondary">Categoría:</span>
                                                    <span class="d-block text-sm fw-bold" id="product-category">-</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-xs text-secondary">Marca:</span>
                                                    <span class="d-block text-sm fw-bold" id="product-brand">-</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-xs text-secondary">Modelo:</span>
                                                    <span class="d-block text-sm fw-bold" id="product-model">-</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="text-xs text-secondary">Origen:</span>
                                                    <span class="d-block text-sm fw-bold" id="product-origin">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Detalles del ingreso mejorado -->
                                    <div class="d-none" id="product-entry-details">
                                        <div class="card border">
                                            <div class="card-header bg-light py-2">
                                                <h6 class="mb-0 text-dark font-weight-bold">Detalle del Ingreso</h6>
                                            </div>
                                            <div class="card-body py-3">
                                                <div class="row g-3">
                                                    <div class="col-md-3">
                                                        <label class="form-label text-xs fw-bold mb-1">Número de Lote</label>
                                                        <input type="text" class="form-control form-control-sm" 
                                                               id="product-lot" placeholder="Ej: LOTE-001">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label text-xs fw-bold mb-1">Cantidad <span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control form-control-sm" 
                                                               id="product-quantity" min="1" value="1">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label text-xs fw-bold mb-1">Costo Unit. <span class="text-danger">*</span></label>
                                                        <div class="input-group input-group-sm">
                                                            <span class="input-group-text">Bs.</span>
                                                            <input type="number" class="form-control" 
                                                                   id="product-unit-cost" min="0" step="0.01" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label text-xs fw-bold mb-1">Fecha de Vencimiento</label>
                                                        <input type="date" class="form-control form-control-sm" 
                                                               id="product-expiry-date">
                                                    </div>
                                                    <div class="col-md-2 d-flex align-items-end">
                                                        <button class="btn btn-sm btn-primary w-100" id="add-to-list-btn">
                                                            <i class="fas fa-cart-plus me-1"></i> Agregar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabla de productos agregados mejorada -->
                                    <div class="mt-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="mb-0 font-weight-bolder text-dark">Productos Agregados</h6>
                                            <span class="badge bg-gradient-info" id="products-count">0 productos</span>
                                        </div>
                                        
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover align-middle" id="products-table">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th width="120">Lote</th>
                                                        <th>Producto</th>
                                                        <th width="100">Categoría</th>
                                                        <th width="100">Cantidad</th>
                                                        <th width="120">Costo Unit.</th>
                                                        <th width="120">Costo Total</th>
                                                        <th width="120">Fecha Venc.</th>
                                                        <th width="60" class="text-center">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Los productos se agregarán aquí mediante JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <!-- Resumen total mejorado -->
                                        <div class="mt-3 pt-3 border-top">
                                            <div class="row justify-content-end">
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card bg-light border">
                                                        <div class="card-body py-2 px-3">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="text-dark fw-bold">TOTAL COMPRA:</span>
                                                                <span class="h5 mb-0 text-success fw-bold" id="products-total">Bs/ 0.00</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones de acción mejorados -->
                                <div class="mt-4 pt-3 border-top">
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-outline-secondary" id="cancel-btn">
                                            <i class="fas fa-times me-1"></i> Cancelar
                                        </button>
                                        <div>
                                            <button class="btn btn-outline-primary me-2" id="save-draft-btn">
                                                <i class="fas fa-save me-1"></i> Guardar Borrador
                                            </button>
                                            <button class="btn bg-gradient-primary btn-lg" id="completeEntryBtn">
                                                <i class="fas fa-check-circle me-2"></i>
                                                Registrar Ingreso
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modales (se mantienen igual) -->
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

    <!-- Incluir Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>
    
    <!-- CSS mejorado -->
    <style>
        :root {
            --primary-gradient: linear-gradient(195deg, #42424a, #191919);
            --secondary-gradient: linear-gradient(195deg, #49a3f1, #1A73E8);
            --primary-color: #4361ee;
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
        }

        .compact-main {
            padding-top: 8px !important;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }
        
        .compact-main .container-fluid {
            padding-top: 8px !important;
            padding-bottom: 12px !important;
            padding-left: 4px !important;
            padding-right: 4px !important;
        }
        
        .compact-main .card {
            margin-top: 6px;
            border-radius: 10px;
        }
        
        .border-dashed {
            border: 1px dashed #cb0c9f !important;
        }
        
        .border-radius-lg {
            border-radius: 12px;
        }
        
        /* Estilos mejorados para formulario ERP */
        .section-header {
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .input-group .input-group-text {
            background-color: var(--light-bg);
            border-color: var(--border-color);
            color: var(--primary-color);
        }
        
        .form-select, .form-control {
            border-color: var(--border-color);
            font-size: 0.875rem;
        }
        
        .form-select:focus, .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }
        
        .table th {
            background-color: var(--light-bg);
            color: #495057;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .table td {
            vertical-align: middle;
            font-size: 0.875rem;
        }
        
        .btn {
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        .btn.bg-gradient-primary {
            background-image: var(--secondary-gradient);
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .btn.bg-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(0, 0, 0, 0.15);
        }
        
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
        }
        
        .card-header.bg-transparent {
            background: transparent !important;
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.8rem;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .d-flex.justify-content-between {
                flex-direction: column;
            }
        }
        
        /* Animaciones */
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Mejora visual para campos */
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        
        /* Estilo para la tabla de productos */
        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        /* Mejora en los selects */
        .ts-control {
            border: 1px solid var(--border-color) !important;
            border-radius: 6px !important;
        }
        
        .ts-control.focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15) !important;
        }
    </style>

    <!-- JavaScript mejorado (mantiene tu lógica pero con mejoras UI) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Función para formatear moneda
            function formatCurrency(value) {
                return `Bs/ ${parseFloat(value || 0).toFixed(2)}`;
            }

            // Actualizar contador de productos
            function updateProductsCount() {
                const count = window.productsList ? window.productsList.length : 0;
                const countElement = document.getElementById('products-count');
                if (countElement) {
                    countElement.textContent = `${count} producto${count !== 1 ? 's' : ''}`;
                }
            }

            // Actualizar total en el resumen
            function updateTotal() {
                const total = window.productsList ? 
                    window.productsList.reduce((sum, product) => sum + product.totalCost, 0) : 0;
                const totalElement = document.getElementById('products-total');
                if (totalElement) {
                    totalElement.textContent = formatCurrency(total);
                }
            }

            // Mejorar la tabla de productos
            function renderProductsTable() {
                const tbody = document.querySelector('#products-table tbody');
                if (!tbody) return;
                
                tbody.innerHTML = '';
                
                if (!window.productsList || window.productsList.length === 0) {
                    const emptyRow = document.createElement('tr');
                    emptyRow.innerHTML = `
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-box-open fa-2x mb-2"></i>
                            <p class="mb-0">No hay productos agregados</p>
                            <small class="text-xs">Seleccione productos para comenzar</small>
                        </td>
                    `;
                    tbody.appendChild(emptyRow);
                    return;
                }
                
                window.productsList.forEach((product, index) => {
                    const row = document.createElement('tr');
                    row.className = 'fade-in';
                    row.innerHTML = `
                        <td>
                            <span class="badge bg-light text-dark">${product.lot || 'S/L'}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <i class="fas fa-box text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">${product.name}</div>
                                    <small class="text-muted">${product.type}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">${product.type}</span>
                        </td>
                        <td>
                            <span class="badge bg-secondary">${product.quantity}</span>
                        </td>
                        <td class="text-end">${formatCurrency(product.unitCost)}</td>
                        <td class="text-end fw-bold">${formatCurrency(product.totalCost)}</td>
                        <td>${product.expiryDate || '<span class="text-muted">N/A</span>'}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-danger remove-product" 
                                    data-index="${index}"
                                    title="Eliminar producto">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
                
                updateProductsCount();
                updateTotal();
            }

            // Inicializar eventos para eliminar productos
            function initRemoveProductEvents() {
                document.querySelectorAll('.remove-product').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const idx = parseInt(this.dataset.index);
                        if (window.productsList && window.productsList[idx]) {
                            window.productsList.splice(idx, 1);
                            renderProductsTable();
                            updateTotal();
                        }
                    });
                });
            }

            // Switch de factura mejorado
            const invoiceRadios = document.querySelectorAll('input[name="hasInvoice"]');
            const invoiceContainer = document.querySelector('.invoice-number-container');
            
            invoiceRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'yes') {
                        invoiceContainer.style.maxWidth = '100%';
                        invoiceContainer.style.opacity = '1';
                        setTimeout(() => {
                            document.getElementById('invoice-number')?.focus();
                        }, 300);
                    } else {
                        invoiceContainer.style.maxWidth = '0';
                        invoiceContainer.style.opacity = '0';
                    }
                });
            });

            // Botón de cancelar
            const cancelBtn = document.getElementById('cancel-btn');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function() {
                    if (window.productsList && window.productsList.length > 0) {
                        Swal.fire({
                            title: '¿Cancelar compra?',
                            text: 'Tiene productos agregados que se perderán',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, cancelar',
                            cancelButtonText: 'Continuar editando',
                            confirmButtonColor: '#dc3545'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('compras.index') }}";
                            }
                        });
                    } else {
                        window.location.href = "{{ route('compras.index') }}";
                    }
                });
            }

            // Botón para guardar borrador
            const saveDraftBtn = document.getElementById('save-draft-btn');
            if (saveDraftBtn) {
                saveDraftBtn.addEventListener('click', function() {
                    // Implementar lógica de guardado como borrador
                    Swal.fire({
                        title: 'Guardar como borrador',
                        text: '¿Desea guardar esta compra como borrador?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Lógica para guardar borrador
                            Swal.fire({
                                title: 'Guardado',
                                text: 'La compra se guardó como borrador',
                                icon: 'success',
                                timer: 2000
                            });
                        }
                    });
                });
            }

            // Inicializar productosList si no existe
            if (!window.productsList) {
                window.productsList = [];
            }

            // Renderizar tabla inicial
            renderProductsTable();

            // Observador para inicializar eventos de eliminación
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        initRemoveProductEvents();
                    }
                });
            });

            const tbody = document.querySelector('#products-table tbody');
            if (tbody) {
                observer.observe(tbody, { childList: true });
            }

            // Sobrescribir la función updateSummary para usar nuestro nuevo diseño
            if (typeof updateSummary === 'function') {
                const originalUpdateSummary = updateSummary;
                window.updateSummary = function() {
                    originalUpdateSummary();
                    renderProductsTable();
                    updateTotal();
                };
            }

            // Sobrescribir la función renderProductsTable para usar nuestro nuevo diseño
            if (typeof renderProductsTable === 'function') {
                const originalRenderProductsTable = renderProductsTable;
                window.renderProductsTable = function() {
                    originalRenderProductsTable();
                    renderProductsTable(); // Llamar a nuestra nueva función
                    updateTotal();
                };
            }
        });
    </script>

    <!-- Mantener todo tu JavaScript original (se mantiene intacto) -->
    <script>
        // Tu JavaScript original se mantiene aquí
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
    
    <!-- Mantener tus funciones JavaScript originales -->
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
        const sucursalSelect = document.getElementById("sucursal-select");

        // --- Resumen escritorio (opcional) ---
        const summaryTotalEl = document.getElementById("summary-total");
        const summaryContainerEl = document.createElement("div");
        summaryContainerEl.id = "summary-products-list";

        const desktopSaleSummary = document.querySelector(".sale-summary");
        if (desktopSaleSummary && summaryTotalEl && summaryTotalEl.parentElement) {
            desktopSaleSummary.insertBefore(summaryContainerEl, summaryTotalEl.parentElement);
        }

        // --- Resumen móvil (opcional) ---
        const mobileSummaryTotalEl = document.getElementById("mobile-summary-total");
        const mobileSummaryContainerEl = document.createElement("div");
        mobileSummaryContainerEl.id = "mobile-summary-products-list";
        const mobileProductsCount = document.getElementById("mobile-products-count");

        const mobileSaleSummary = document.querySelector(".mobile-details-body .sale-summary");
        if (mobileSaleSummary && mobileSummaryTotalEl && mobileSummaryTotalEl.parentElement) {
            mobileSaleSummary.insertBefore(mobileSummaryContainerEl, mobileSummaryTotalEl.parentElement);
        }

        async function loadSucursales() {
            if (!sucursalSelect) return;
            try {
                let data = [];
                const cache = localStorage.getItem("sucursalesEmpresa");
                if (cache) {
                    try {
                        data = JSON.parse(cache) || [];
                    } catch {
                        data = [];
                    }
                }
                if (!Array.isArray(data) || !data.length) {
                    const res = await fetch("/sucursal/fetch?per_page=1000&page=1");
                    if (res.ok) {
                        const json = await res.json();
                        data = Array.isArray(json?.data) ? json.data : [];
                    }
                }
                sucursalSelect.innerHTML = "";
                data.forEach(s => {
                    const opt = document.createElement("option");
                    opt.value = s.id;
                    opt.textContent = s.nombre || `Sucursal ${s.id}`;
                    sucursalSelect.appendChild(opt);
                });
                if (data.length && !sucursalSelect.value) {
                    sucursalSelect.value = data[0].id;
                }
            } catch (err) {
                console.error("Error cargando sucursales", err);
            }
        }

        // Botón flotante carrito (opcional)
        const floatingCartBtn = document.createElement("button");
        floatingCartBtn.id = "floating-cart-btn";
        floatingCartBtn.className = "btn btn-primary rounded-circle shadow-lg position-fixed";
        floatingCartBtn.style.bottom = "20px";
        floatingCartBtn.style.right = "20px";
        floatingCartBtn.style.width = "50px";
        floatingCartBtn.style.height = "50px";
        floatingCartBtn.innerHTML = `
            <i class="menu-icon icon-base bx bx-cart fs-5"></i>
            <span id="floating-cart-count" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">0</span>`;
        document.body.appendChild(floatingCartBtn);
        const floatingCartCount = floatingCartBtn.querySelector("#floating-cart-count");

        let productsData = [];
        let selectedProduct = null;
        let productsList = [];

        function formatCurrency(value) {
            return `S/ ${parseFloat(value || 0).toFixed(2)}`;
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
                option: (item, escape) =>
                `<div><strong>${escape(item.nombre)}</strong><br><small>Código: ${escape(item.codigo || "-")}</small></div>`,
                item: (item, escape) => `<div>${escape(item.nombre)}</div>`
            },
            onChange: (value) => {
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

                // --- ¡Quitado! Era la línea que rompía si no existe el input:
                // document.getElementById("product-code").value = selectedProduct.codigo || "";

                document.getElementById("product-lot").value = "";
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
                console.log("Productos recibidos:", data.length, data);
                productsData = data.map(p => ({
                id: p.id,
                nombre: p.name,           // backend envía "name"
                category: p.category || "-",
                brand: p.brand || "-",
                model: p.model || "-",
                price: p.price || 0,
                origin: p.origin || "-",
                codigo: p.codigo || ""    // si el backend lo envía
                }));
                productSelect.clearOptions();
                productSelect.addOptions(productsData);
            })
            .catch(err => console.error("Error cargando productos:", err));
        }
        loadProducts();
        loadSucursales();

        // Agregar producto
        addToListBtn.addEventListener("click", function(e) {
            e.preventDefault();
            if (!selectedProduct) return;

            const lote = document.getElementById("product-lot").value.trim();
            const cantidad = parseFloat(document.getElementById("product-quantity").value) || 0;
            const unitCost = parseFloat(document.getElementById("product-unit-cost").value) || 0;
            const expiryDate = document.getElementById("product-expiry-date").value;
            if (cantidad <= 0 || unitCost < 0) return alert("Cantidad y costo deben ser mayores a cero.");

            const totalCost = cantidad * unitCost;
            productsList.push({
            id: selectedProduct.id,
            name: selectedProduct.nombre,
            lot: lote,
            quantity: cantidad,
            unitCost,
            totalCost,
            expiryDate,
            type: selectedProduct.category || "-"
            });
            renderProductsTable();
            updateSummary();
        });

        function renderProductsTable() {
            productsTableBody.innerHTML = "";
            productsList.forEach((p, index) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${p.lot}</td>
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
                </td>`;
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

        function updateSummary() {
            if (summaryContainerEl) summaryContainerEl.innerHTML = "";
            let total = productsList.reduce((s,p)=> s + p.totalCost, 0);

            const productsTotalEl = document.getElementById("products-total");
            if (productsTotalEl) productsTotalEl.textContent = formatCurrency(total);
            if (summaryTotalEl) summaryTotalEl.textContent = formatCurrency(total);
            if (mobileSummaryTotalEl) mobileSummaryTotalEl.textContent = formatCurrency(total);

            if (mobileProductsCount) mobileProductsCount.textContent = productsList.length;
            if (floatingCartCount) floatingCartCount.textContent = productsList.length;
        }


        async function registerPurchase() {
        const proveedorId = document.getElementById("supplier-select").value;
        const almacenId = document.getElementById("warehouse-select").value;
        const sucursalId = sucursalSelect?.value;
        const fecha = document.getElementById("entry-date").value;
        const inventoryType = document.getElementById("inventory-type").value;
        const reason = document.getElementById("reason").value;
        const paymentForm = document.getElementById("payment-form").value;
        const paymentType = document.getElementById("payment-type").value;
        const observacion = document.getElementById("observation")?.value || ""; // corregido id
        const hasInvoice = document.querySelector('input[name="hasInvoice"]:checked').value === 'yes';
        const numeroFactura = hasInvoice ? document.getElementById("invoice-number").value.trim() : null;

        if (!proveedorId || !almacenId) {
            showAlert("Debe seleccionar proveedor y almacén.", "warning");
            return;
        }
        if (!sucursalId) {
            showAlert("Debe seleccionar una sucursal.", "warning");
            return;
        }
        if (productsList.length === 0) {
            showAlert("Debe agregar al menos un producto.", "warning");
            return;
        }

        const payload = {
            proveedor_id: proveedorId,
            almacen_id: almacenId,
            sucursal_id: sucursalId,
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

        console.log("Payload de compra:", payload);

        // 🔹 Confirmación antes de registrar la compra
        const confirm = await Swal.fire({
            title: '¿Confirmar registro de compra?',
            text: "Se guardará el ingreso al inventario con los productos seleccionados.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, registrar compra',
            cancelButtonText: 'Cancelar'
        });

        if (!confirm.isConfirmed) return;

        try {
            const response = await fetch("/compras/store", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();

            if (result.success) {
                // 🔹 Confirmación de compra exitosa
                const nextAction = await Swal.fire({
                    title: 'Compra registrada',
                    text: `La compra se registró correctamente. ID: ${result.compra_id}`,
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Seguir registrando',
                    cancelButtonText: 'Ir al listado de compras'
                });

                // 🔹 Reset del formulario
                productsList = [];
                renderProductsTable();
                updateSummary();

                // Limpieza de selects y campos principales
                document.getElementById("supplier-select").tomselect?.clear();
                document.getElementById("warehouse-select").value = "";
                document.getElementById("observation").value = "";
                document.getElementById("invoice-number").value = "";

                if (!nextAction.isConfirmed) {
                    window.location.href = '/compras'; // 👈 redirige al listado
                }
            } else {
                Swal.fire({
                    title: 'Error al registrar',
                    text: result.message || 'Ocurrió un error en el registro de la compra.',
                    icon: 'error'
                });
            }
        } catch (error) {
            console.error("Error al registrar la compra:", error);
            Swal.fire({
                title: 'Error del servidor',
                text: 'No se pudo registrar la compra. Intenta nuevamente.',
                icon: 'error'
            });
        }
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