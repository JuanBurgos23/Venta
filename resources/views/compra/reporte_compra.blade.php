<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @vite(['resources/js/datos_usuario.js'])
        
        <div class="container-fluid p-2">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card shadow-sm my-2">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Reporte de Compras</h5>
                                <small class="text-muted">Generar reportes descargables de compras</small>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm" id="btnGenerarReporte">
                                    <i class="bx bx-refresh"></i> Generar Reporte
                                </button>
                                <div class="dropdown">
                                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownExport" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-download"></i> Exportar
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownExport">
                                        <li><a class="dropdown-item" href="#" id="exportExcel"><i class="bx bx-file"></i> Excel (.xlsx)</a></li>
                                        <li><a class="dropdown-item" href="#" id="exportPDF"><i class="bx bx-file"></i> PDF (.pdf)</a></li>
                                        <li><a class="dropdown-item" href="#" id="exportCSV"><i class="bx bx-file"></i> CSV (.csv)</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Filtros de Reporte -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-3">
                                    <label class="form-label small">Fecha Desde</label>
                                    <input type="date" id="report-from" class="form-control form-control-sm" value="{{ date('Y-m-d', strtotime('-30 days')) }}" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Fecha Hasta</label>
                                    <input type="date" id="report-to" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Proveedor</label>
                                    <select id="report-proveedor" class="form-select form-select-sm">
                                        <option value="">Todos</option>
                                        <!-- Se llenará dinámicamente -->
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Almacén</label>
                                    <select id="report-warehouse" class="form-select form-select-sm">
                                        <option value="">Todos</option>
                                        <!-- Se llenará dinámicamente -->
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Estado</label>
                                    <select id="report-status" class="form-select form-select-sm">
                                        <option value="">Todos</option>
                                        <option value="1">Activas</option>
                                        <option value="0">Anuladas</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Resumen del Reporte -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card border-primary border">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-0 text-primary">Total Compras</h6>
                                            <h4 class="mb-0" id="totalCompras">0</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card border-success border">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-0 text-success">Monto Total</h6>
                                            <h4 class="mb-0" id="montoTotal">Bs/ 0.00</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card border-info border">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-0 text-info">Compra Promedio</h6>
                                            <h4 class="mb-0" id="compraPromedio">Bs/ 0.00</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card border-warning border">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-0 text-warning">Compras/Día</h6>
                                            <h4 class="mb-0" id="comprasPorDia">0</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabla de Reporte -->
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm" id="reporte-table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Nro. Factura</th>
                                            <th>Fecha</th>
                                            <th>Proveedor</th>
                                            <th>RUC/NIT</th>
                                            <th>Almacén</th>
                                            <th class="text-end">Subtotal</th>
                                            <th class="text-end">IVA</th>
                                            <th class="text-end">Descuento</th>
                                            <th class="text-end">Total</th>
                                            <th>Tipo Compra</th>
                                            <th>Estado</th>
                                            <th>Registrado por</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reporte-body">
                                        <tr>
                                            <td colspan="13" class="text-center py-4 text-muted">
                                                <i class="bx bx-file me-2"></i>No hay datos para mostrar. Use los filtros y haga clic en "Generar Reporte".
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="bg-light fw-bold">
                                        <tr>
                                            <td colspan="6" class="text-end">TOTALES:</td>
                                            <td class="text-end" id="totalSubtotal">Bs/ 0.00</td>
                                            <td class="text-end" id="totalIVA">Bs/ 0.00</td>
                                            <td class="text-end" id="totalDescuento">Bs/ 0.00</td>
                                            <td class="text-end" id="totalGeneral">Bs/ 0.00</td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Gráficos de Análisis -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0">Top 5 Proveedores</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <canvas id="graficoProveedores" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0">Compras por Almacén</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <canvas id="graficoAlmacenes" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                <span id="reporteInfo">Reporte generado el: {{ date('d/m/Y H:i') }}</span>
                            </div>
                            <div class="text-muted small">
                                <span id="totalRegistros">0 registros</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts para gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Script para exportar a Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <!-- Script para PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
        const setupReporteCompraPage = () => {
            // Variables globales
            let reporteData = [];
            let graficoProveedores = null;
            let graficoAlmacenes = null;
            
            // Configuración
            const REPORT_URL = '/compras/reporte'; // Endpoint que devuelve datos para reporte
            const PROVEEDORES_URL = '/api/proveedores'; // Endpoint para cargar proveedores
            const ALMACENES_URL = '/api/almacenes'; // Endpoint para cargar almacenes
            
            // Elementos DOM
            const btnGenerarReporte = document.getElementById('btnGenerarReporte');
            const exportExcel = document.getElementById('exportExcel');
            const exportPDF = document.getElementById('exportPDF');
            const exportCSV = document.getElementById('exportCSV');
            const reporteBody = document.getElementById('reporte-body');
            const reporteInfo = document.getElementById('reporteInfo');
            const totalRegistros = document.getElementById('totalRegistros');
            
            // Elementos de estadísticas
            const totalCompras = document.getElementById('totalCompras');
            const montoTotal = document.getElementById('montoTotal');
            const compraPromedio = document.getElementById('compraPromedio');
            const comprasPorDia = document.getElementById('comprasPorDia');
            const totalSubtotal = document.getElementById('totalSubtotal');
            const totalIVA = document.getElementById('totalIVA');
            const totalDescuento = document.getElementById('totalDescuento');
            const totalGeneral = document.getElementById('totalGeneral');
            
            // Cargar listas de filtros
            async function cargarFiltros() {
                try {
                    // Cargar proveedores
                    const resProveedores = await fetch(PROVEEDORES_URL, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (resProveedores.ok) {
                        const data = await resProveedores.json();
                        const selectProveedor = document.getElementById('report-proveedor');
                        selectProveedor.innerHTML = '<option value="">Todos</option>';
                        data.forEach(proveedor => {
                            const option = document.createElement('option');
                            option.value = proveedor.id;
                            option.textContent = proveedor.nombre;
                            selectProveedor.appendChild(option);
                        });
                    }
                    
                    // Cargar almacenes
                    const sucursalId = document.getElementById('report-sucursal')?.value || '';
                    const qs = sucursalId ? `?sucursal_id=${encodeURIComponent(sucursalId)}` : '';
                    const resAlmacenes = await fetch(ALMACENES_URL + qs, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (resAlmacenes.ok) {
                        const data = await resAlmacenes.json();
                        const selectAlmacen = document.getElementById('report-warehouse');
                        selectAlmacen.innerHTML = '<option value="">Todos</option>';
                        data.forEach(almacen => {
                            const option = document.createElement('option');
                            option.value = almacen.id;
                            option.textContent = almacen.nombre;
                            selectAlmacen.appendChild(option);
                        });
                    }
                } catch (error) {
                    console.error('Error cargando filtros:', error);
                }
            }
            
            // Generar reporte
            async function generarReporte() {
                try {
                    const params = new URLSearchParams({
                        from: document.getElementById('report-from').value,
                        to: document.getElementById('report-to').value,
                        proveedor: document.getElementById('report-proveedor').value,
                        warehouse: document.getElementById('report-warehouse').value,
                        status: document.getElementById('report-status').value
                    });
                    
                    const res = await fetch(`${REPORT_URL}?${params.toString()}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    
                    if (!res.ok) throw new Error('Error generando reporte');
                    
                    const data = await res.json();
                    reporteData = data.compras || [];
                    
                    actualizarEstadisticas();
                    renderizarTabla();
                    renderizarGraficos();
                    actualizarInfoReporte();
                    
                } catch (error) {
                    console.error('Error:', error);
                    showToast('Error generando reporte', 'danger');
                }
            }
            
            // Actualizar estadísticas
            function actualizarEstadisticas() {
                if (!reporteData.length) {
                    resetEstadisticas();
                    return;
                }
                
                let totalComprasCount = reporteData.length;
                let totalMonto = 0;
                let totalSub = 0;
                let totalIva = 0;
                let totalDesc = 0;
                
                reporteData.forEach(compra => {
                    totalMonto += parseFloat(compra.total || 0);
                    totalSub += parseFloat(compra.subtotal || compra.total || 0);
                    totalIva += parseFloat(compra.iva || 0);
                    totalDesc += parseFloat(compra.descuento || 0);
                });
                
                // Calcular días entre fechas
                const from = new Date(document.getElementById('report-from').value);
                const to = new Date(document.getElementById('report-to').value);
                const dias = Math.max(1, Math.ceil((to - from) / (1000 * 60 * 60 * 24)) + 1);
                
                // Actualizar UI
                totalCompras.textContent = totalComprasCount;
                montoTotal.textContent = `Bs/ ${formatNumber(totalMonto)}`;
                compraPromedio.textContent = `Bs/ ${formatNumber(totalMonto / totalComprasCount)}`;
                comprasPorDia.textContent = (totalComprasCount / dias).toFixed(1);
                totalSubtotal.textContent = `Bs/ ${formatNumber(totalSub)}`;
                totalIVA.textContent = `Bs/ ${formatNumber(totalIva)}`;
                totalDescuento.textContent = `Bs/ ${formatNumber(totalDesc)}`;
                totalGeneral.textContent = `Bs/ ${formatNumber(totalMonto)}`;
                totalRegistros.textContent = `${totalComprasCount} registros`;
            }
            
            function resetEstadisticas() {
                totalCompras.textContent = '0';
                montoTotal.textContent = 'Bs/ 0.00';
                compraPromedio.textContent = 'Bs/ 0.00';
                comprasPorDia.textContent = '0';
                totalSubtotal.textContent = 'Bs/ 0.00';
                totalIVA.textContent = 'Bs/ 0.00';
                totalDescuento.textContent = 'Bs/ 0.00';
                totalGeneral.textContent = 'Bs/ 0.00';
                totalRegistros.textContent = '0 registros';
            }
            
            // Renderizar tabla
            function renderizarTabla() {
                reporteBody.innerHTML = '';
                
                if (!reporteData.length) {
                    reporteBody.innerHTML = `
                        <tr>
                            <td colspan="13" class="text-center py-4 text-muted">
                                No hay compras para los filtros seleccionados.
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                reporteData.forEach((compra, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${escapeHtml(compra.numero_factura || compra.num_factura || '-')}</td>
                        <td>${formatDate(compra.fecha)}</td>
                        <td>${escapeHtml(compra.proveedor_nombre || compra.proveedor?.nombre || '-')}</td>
                        <td>${escapeHtml(compra.proveedor_ruc || compra.proveedor?.ruc || '-')}</td>
                        <td>${escapeHtml(compra.almacen_nombre || compra.almacen?.nombre || '-')}</td>
                        <td class="text-end">Bs/ ${formatNumber(compra.subtotal || 0)}</td>
                        <td class="text-end">Bs/ ${formatNumber(compra.iva || 0)}</td>
                        <td class="text-end">Bs/ ${formatNumber(compra.descuento || 0)}</td>
                        <td class="text-end fw-bold">Bs/ ${formatNumber(compra.total || 0)}</td>
                        <td>${escapeHtml(compra.tipo_compra || 'Normal')}</td>
                        <td><span class="badge bg-${compra.estado == 1 ? 'success' : 'danger'}">${compra.estado == 1 ? 'Activo' : 'Anulado'}</span></td>
                        <td>${escapeHtml(compra.usuario_nombre || compra.usuario?.name || '-')}</td>
                    `;
                    reporteBody.appendChild(tr);
                });
            }
            
            // Renderizar gráficos
            function renderizarGraficos() {
                if (graficoProveedores) graficoProveedores.destroy();
                if (graficoAlmacenes) graficoAlmacenes.destroy();
                
                if (!reporteData.length) return;
                
                // Gráfico de top 5 proveedores
                const proveedoresData = {};
                reporteData.forEach(compra => {
                    const proveedor = compra.proveedor_nombre || compra.proveedor?.nombre || 'No especificado';
                    proveedoresData[proveedor] = (proveedoresData[proveedor] || 0) + parseFloat(compra.total || 0);
                });
                
                // Ordenar y tomar top 5
                const topProveedores = Object.entries(proveedoresData)
                    .sort((a, b) => b[1] - a[1])
                    .slice(0, 5);
                
                const ctxProveedores = document.getElementById('graficoProveedores').getContext('2d');
                graficoProveedores = new Chart(ctxProveedores, {
                    type: 'bar',
                    data: {
                        labels: topProveedores.map(p => p[0]),
                        datasets: [{
                            label: 'Monto Total (Bs)',
                            data: topProveedores.map(p => p[1]),
                            backgroundColor: [
                                '#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Bs/ ' + (value / 1000).toFixed(0) + 'k';
                                    }
                                }
                            }
                        }
                    }
                });
                
                // Gráfico de compras por almacén
                const almacenesData = {};
                reporteData.forEach(compra => {
                    const almacen = compra.almacen_nombre || compra.almacen?.nombre || 'No especificado';
                    almacenesData[almacen] = (almacenesData[almacen] || 0) + 1; // Contar compras
                });
                
                const ctxAlmacenes = document.getElementById('graficoAlmacenes').getContext('2d');
                graficoAlmacenes = new Chart(ctxAlmacenes, {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(almacenesData),
                        datasets: [{
                            data: Object.values(almacenesData),
                            backgroundColor: [
                                '#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6', '#34495e'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });
            }
            
            // Actualizar información del reporte
            function actualizarInfoReporte() {
                const from = document.getElementById('report-from').value;
                const to = document.getElementById('report-to').value;
                const fecha = new Date().toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
                
                reporteInfo.textContent = `Reporte del ${formatDate(from)} al ${formatDate(to)} - Generado: ${fecha}`;
            }
            
            // Exportar a Excel
            function exportarExcel() {
                if (!reporteData.length) {
                    showToast('No hay datos para exportar', 'warning');
                    return;
                }
                
                // Crear hoja de trabajo
                const wsData = [
                    ['#', 'Nro. Factura', 'Fecha', 'Proveedor', 'RUC/NIT', 'Almacén', 'Subtotal', 'IVA', 'Descuento', 'Total', 'Tipo Compra', 'Estado', 'Registrado por']
                ];
                
                reporteData.forEach((compra, index) => {
                    wsData.push([
                        index + 1,
                        compra.numero_factura || compra.num_factura || '',
                        compra.fecha,
                        compra.proveedor_nombre || compra.proveedor?.nombre || '',
                        compra.proveedor_ruc || compra.proveedor?.ruc || '',
                        compra.almacen_nombre || compra.almacen?.nombre || '',
                        compra.subtotal || 0,
                        compra.iva || 0,
                        compra.descuento || 0,
                        compra.total || 0,
                        compra.tipo_compra || 'Normal',
                        compra.estado == 1 ? 'Activo' : 'Anulado',
                        compra.usuario_nombre || compra.usuario?.name || ''
                    ]);
                });
                
                // Agregar totales
                const totals = calcularTotales();
                wsData.push(['', '', '', '', '', '', '', '', '', '', '', '', '']);
                wsData.push(['TOTALES:', '', '', '', '', '', 
                    totals.subtotal, 
                    totals.iva, 
                    totals.descuento, 
                    totals.total, 
                    '', '', '']);
                
                const ws = XLSX.utils.aoa_to_sheet(wsData);
                
                // Estilos básicos (ancho de columnas)
                const wscols = [
                    {wch: 5},   // #
                    {wch: 15},  // Nro. Factura
                    {wch: 12},  // Fecha
                    {wch: 25},  // Proveedor
                    {wch: 12},  // RUC/NIT
                    {wch: 15},  // Almacén
                    {wch: 12},  // Subtotal
                    {wch: 10},  // IVA
                    {wch: 12},  // Descuento
                    {wch: 12},  // Total
                    {wch: 12},  // Tipo Compra
                    {wch: 10},  // Estado
                    {wch: 20}   // Registrado por
                ];
                ws['!cols'] = wscols;
                
                // Crear libro de trabajo
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Reporte Compras');
                
                // Generar nombre de archivo
                const from = document.getElementById('report-from').value;
                const to = document.getElementById('report-to').value;
                const filename = `Reporte_Compras_${from}_al_${to}.xlsx`;
                
                // Descargar
                XLSX.writeFile(wb, filename);
            }
            
            // Exportar a PDF
            async function exportarPDF() {
                if (!reporteData.length) {
                    showToast('No hay datos para exportar', 'warning');
                    return;
                }
                
                showToast('Generando PDF...', 'info');
                
                // Crear HTML para el PDF
                const from = document.getElementById('report-from').value;
                const to = document.getElementById('report-to').value;
                const totals = calcularTotales();
                
                const htmlContent = `
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="UTF-8">
                        <title>Reporte de Compras</title>
                        <style>
                            body { font-family: Arial, sans-serif; font-size: 11px; }
                            .header { text-align: center; margin-bottom: 15px; }
                            .title { font-size: 16px; font-weight: bold; }
                            .subtitle { font-size: 12px; color: #666; }
                            .info { margin-bottom: 15px; }
                            table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
                            th { background-color: #f2f2f2; text-align: left; padding: 6px; border: 1px solid #ddd; }
                            td { padding: 5px; border: 1px solid #ddd; }
                            .text-right { text-align: right; }
                            .text-center { text-align: center; }
                            .total-row { font-weight: bold; background-color: #f9f9f9; }
                            .footer { margin-top: 20px; font-size: 9px; color: #666; text-align: center; }
                            .badge { padding: 2px 6px; border-radius: 3px; font-size: 10px; }
                            .bg-success { background-color: #d4edda; color: #155724; }
                            .bg-danger { background-color: #f8d7da; color: #721c24; }
                        </style>
                    </head>
                    <body>
                        <div class="header">
                            <div class="title">REPORTE DE COMPRAS</div>
                            <div class="subtitle">Del ${formatDate(from)} al ${formatDate(to)}</div>
                        </div>
                        
                        <div class="info">
                            <strong>Filtros aplicados:</strong><br>
                            Fecha: ${formatDate(from)} - ${formatDate(to)}<br>
                            Proveedor: ${document.getElementById('report-proveedor').value ? document.querySelector('#report-proveedor option:checked').textContent : 'Todos'}<br>
                            Almacén: ${document.getElementById('report-warehouse').value ? document.querySelector('#report-warehouse option:checked').textContent : 'Todos'}<br>
                            Estado: ${document.getElementById('report-status').value == '1' ? 'Activas' : document.getElementById('report-status').value == '0' ? 'Anuladas' : 'Todos'}<br>
                            Total Registros: ${reporteData.length}
                        </div>
                        
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nro. Factura</th>
                                    <th>Fecha</th>
                                    <th>Proveedor</th>
                                    <th>Almacén</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="text-right">IVA</th>
                                    <th class="text-right">Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${reporteData.map((compra, index) => `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${compra.numero_factura || compra.num_factura || ''}</td>
                                        <td>${formatDate(compra.fecha)}</td>
                                        <td>${compra.proveedor_nombre || compra.proveedor?.nombre || ''}</td>
                                        <td>${compra.almacen_nombre || compra.almacen?.nombre || ''}</td>
                                        <td class="text-right">Bs/ ${formatNumber(compra.subtotal || 0)}</td>
                                        <td class="text-right">Bs/ ${formatNumber(compra.iva || 0)}</td>
                                        <td class="text-right">Bs/ ${formatNumber(compra.total || 0)}</td>
                                        <td><span class="badge bg-${compra.estado == 1 ? 'success' : 'danger'}">${compra.estado == 1 ? 'Activo' : 'Anulado'}</span></td>
                                    </tr>
                                `).join('')}
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td colspan="5" class="text-right"><strong>TOTALES:</strong></td>
                                    <td class="text-right"><strong>Bs/ ${formatNumber(totals.subtotal)}</strong></td>
                                    <td class="text-right"><strong>Bs/ ${formatNumber(totals.iva)}</strong></td>
                                    <td class="text-right"><strong>Bs/ ${formatNumber(totals.total)}</strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <div class="footer">
                            Generado el ${new Date().toLocaleString('es-ES')} | Sistema de Compras
                        </div>
                    </body>
                    </html>
                `;
                
                // Crear PDF
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('landscape');
                
                // Agregar contenido HTML al PDF
                await doc.html(htmlContent, {
                    callback: function(doc) {
                        const filename = `Reporte_Compras_${from}_al_${to}.pdf`;
                        doc.save(filename);
                        showToast('PDF generado exitosamente', 'success');
                    },
                    x: 10,
                    y: 10,
                    width: 280,
                    windowWidth: 1200
                });
            }
            
            // Exportar a CSV
            function exportarCSV() {
                if (!reporteData.length) {
                    showToast('No hay datos para exportar', 'warning');
                    return;
                }
                
                const headers = ['#', 'Nro. Factura', 'Fecha', 'Proveedor', 'RUC/NIT', 'Almacén', 'Subtotal', 'IVA', 'Descuento', 'Total', 'Tipo Compra', 'Estado', 'Registrado por'];
                const rows = reporteData.map((compra, index) => [
                    index + 1,
                    compra.numero_factura || compra.num_factura || '',
                    compra.fecha,
                    compra.proveedor_nombre || compra.proveedor?.nombre || '',
                    compra.proveedor_ruc || compra.proveedor?.ruc || '',
                    compra.almacen_nombre || compra.almacen?.nombre || '',
                    compra.subtotal || 0,
                    compra.iva || 0,
                    compra.descuento || 0,
                    compra.total || 0,
                    compra.tipo_compra || 'Normal',
                    compra.estado == 1 ? 'Activo' : 'Anulado',
                    compra.usuario_nombre || compra.usuario?.name || ''
                ]);
                
                const csvContent = [
                    headers.join(','),
                    ...rows.map(row => row.map(cell => `"${cell}"`).join(','))
                ].join('\n');
                
                const from = document.getElementById('report-from').value;
                const to = document.getElementById('report-to').value;
                const filename = `Reporte_Compras_${from}_al_${to}.csv`;
                
                const blob = new Blob(['\uFEFF' + csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = filename;
                link.click();
                
                showToast('CSV generado exitosamente', 'success');
            }
            
            // Helper functions
            function calcularTotales() {
                let subtotal = 0;
                let iva = 0;
                let descuento = 0;
                let total = 0;
                
                reporteData.forEach(compra => {
                    subtotal += parseFloat(compra.subtotal || compra.total || 0);
                    iva += parseFloat(compra.iva || 0);
                    descuento += parseFloat(compra.descuento || 0);
                    total += parseFloat(compra.total || 0);
                });
                
                return { subtotal, iva, descuento, total };
            }
            
            function formatNumber(num) {
                return (Number(num) || 0).toLocaleString('es-ES', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
            
            function formatDate(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                return date.toLocaleDateString('es-ES');
            }
            
            function escapeHtml(text) {
                if (text === null || text === undefined) return '';
                return String(text)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }
            
            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-white bg-${type}`;
                toast.role = 'alert';
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">${escapeHtml(message)}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;
                document.body.appendChild(toast);
                const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
                bsToast.show();
                toast.addEventListener('hidden.bs.toast', () => toast.remove());
            }
            
            // Event Listeners
            btnGenerarReporte.addEventListener('click', generarReporte);
            exportExcel.addEventListener('click', (e) => {
                e.preventDefault();
                exportarExcel();
            });
            exportPDF.addEventListener('click', (e) => {
                e.preventDefault();
                exportarPDF();
            });
            exportCSV.addEventListener('click', (e) => {
                e.preventDefault();
                exportarCSV();
            });
            
            // Inicializar
            cargarFiltros();
            actualizarInfoReporte();
        };

        const handleReporteCompraLoad = () => {
            const root = document.getElementById('reporte-body');
            if (!root) return;
            if (root.dataset.reporteCompraInit === '1') return;
            root.dataset.reporteCompraInit = '1';
            setupReporteCompraPage();
        };

        document.addEventListener('turbo:load', handleReporteCompraLoad);
        document.addEventListener('DOMContentLoaded', handleReporteCompraLoad);
    </script>

    <style>
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            font-size: 0.85rem;
            white-space: nowrap;
        }
        
        .table td {
            font-size: 0.85rem;
            vertical-align: middle;
        }
        
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.02);
        }
        
        .badge {
            font-size: 0.75em;
            padding: 0.35em 0.65em;
        }
        
        .card {
            border: 1px solid rgba(0,0,0,.125);
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        }
        
        .border-primary { border-color: #3498db !important; }
        .border-success { border-color: #2ecc71 !important; }
        .border-info { border-color: #17a2b8 !important; }
        .border-warning { border-color: #f39c12 !important; }
        
        .text-primary { color: #3498db !important; }
        .text-success { color: #2ecc71 !important; }
        .text-info { color: #17a2b8 !important; }
        .text-warning { color: #f39c12 !important; }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .form-control-sm, .form-select-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
        
        .toast {
            position: fixed;
            top: 1rem;
            right: 1rem;
            z-index: 9999;
        }
    </style>
</x-layout>
