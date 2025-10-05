<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <style>
            /* Estilos personalizados para la vista de inventario */
            .inventory-table {
                font-size: 0.875rem;
            }
            
            .inventory-table th {
                background-color: #f8f9fa;
                font-weight: 600;
                border-bottom: 2px solid #dee2e6;
            }
            
            .totals-section {
                background-color: #f8f9fe;
                border-radius: 0.5rem;
                padding: 1rem;
                margin-top: 1.5rem;
            }
            
            .action-buttons .btn {
                margin-right: 0.5rem;
            }
            
            .filter-section {
                background-color: #f8f9fe;
                border-radius: 0.5rem;
                padding: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .status-badge {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }
            
            .low-stock {
                color: #dc3545;
                font-weight: 600;
            }
            
            .stock-ok {
                color: #198754;
            }
            
            .table-responsive {
                max-height: 500px;
                overflow-y: auto;
            }
        </style>
        <!-- Scripts -->
        <script>
            window.APP = {
              routes: {
                inventarioReporte: "{{ route('inventario.reporte') }}",
                // base que luego completarás con el ID
                inventarioLotesBase: "{{ route('inventario.lotes', ['productoId' => 0]) }}".replace(/0$/, '')
              },
              empresaId: {{ auth()->user()->id_empresa ?? 'null' }}
            };
        </script>
        @vite(['resources/js/reporte.js'])

          

        @vite([ 'resources/js/app.js'])
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header">Reporte de Inventario</div>
                </div>
                <div class="card-body">
                        <div class="col-12">
                            <div class="card my-4">
                                <div class="card-header p-3 pt-2">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h5 class="mb-0">Reporte de Inventario</h5>
                                            <p class="text-sm mb-0">Resumen completo del inventario actual</p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <div class="dropdown">
                                                <button class="btn bg-gradient-primary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Exportar
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                                    <li><a class="dropdown-item" href="#" id="exportPdf">PDF</a></li>
                                                    <li><a class="dropdown-item" href="#" id="exportExcel">Excel</a></li>
                                                    <li><a class="dropdown-item" href="#" id="exportCsv">CSV</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <!-- Filtros -->
                                    <div class="filter-section">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label for="categoryFilter" class="form-label">Categoría</label>
                                                <select class="form-select" id="categoryFilter">
                                                    <option value="">Todas las categorías</option>
                                                    <option value="Electrónicos">Electrónicos</option>
                                                    <option value="Oficina">Oficina</option>
                                                    <option value="Suministros">Suministros</option>
                                                    <option value="Mobiliario">Mobiliario</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="statusFilter" class="form-label">Estado</label>
                                                <select class="form-select" id="statusFilter">
                                                    <option value="">Todos los estados</option>
                                                    <option value="Disponible">Disponible</option>
                                                    <option value="Bajo Stock">Bajo Stock</option>
                                                    <option value="Agotado">Agotado</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label for="searchInput" class="form-label">Buscar producto</label>
                                                <input type="text" class="form-control" id="searchInput" placeholder="Nombre, código...">
                                            </div>
                                            <div class="col-md-3 d-flex align-items-end">
                                                <button class="btn bg-gradient-info w-100" id="applyFilters">Aplicar Filtros</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Tabla de inventario -->
                                    <div class="table-responsive">
                                        <table class="table table-hover inventory-table" id="inventoryTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th>Código</th>
                                                    <th>Producto</th>
                                                    <th>Categoría</th>
                                                    <th class="text-center">Stock Actual</th>
                                                    <th class="text-center">Stock Mínimo</th>
                                                    <th class="text-center">Estado</th>
                                                    <th class="text-end">Precio Unitario</th>
                                                    <th class="text-end">Valor Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Los datos se cargarán dinámicamente -->
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Totales -->
                                    <div class="totals-section">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h6 class="mb-0">Resumen del Inventario</h6>
                                                <p class="text-sm text-muted mb-0">Valores calculados en tiempo real</p>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="row text-end">
                                                    <div class="col-4">
                                                        <p class="text-sm mb-0">Total Productos:</p>
                                                        <h5 class="mb-0" id="totalProducts">0</h5>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class="text-sm mb-0">Valor Total Inventario:</p>
                                                        <h5 class="mb-0" id="totalInventoryValue">$0.00</h5>
                                                    </div>
                                                    <div class="col-4">
                                                        <p class="text-sm mb-0">Productos Bajo Stock:</p>
                                                        <h5 class="mb-0 text-danger" id="lowStockProducts">0</h5>
                                                    </div>
                                                </div>
                                            </div>
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

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>
