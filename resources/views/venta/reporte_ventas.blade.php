<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        @vite(['resources/js/datos_usuario.js'])
        <div class="venta-loader" id="venta-loader" aria-hidden="true">
            <div class="venta-loader-card">
                <svg stroke="hsl(228, 97%, 42%)" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="venta-loader-icon" aria-label="Cargando" role="img"><g><circle cx="12" cy="12" r="9.5" fill="none" stroke-width="3" stroke-linecap="round"><animate attributeName="stroke-dasharray" dur="1.5s" calcMode="spline" values="0 150;42 150;42 150;42 150" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/><animate attributeName="stroke-dashoffset" dur="1.5s" calcMode="spline" values="0;-16;-59;-59" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/></circle><animateTransform attributeName="transform" type="rotate" dur="2s" values="0 12 12;360 12 12" repeatCount="indefinite"/></g></svg>
                <div class="venta-loader-text" id="venta-loader-text">Cargando...</div>
            </div>
        </div>
        <div class="container-fluid p-2">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card shadow-sm my-2">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Reporte de Ventas</h5>
                                <small class="text-muted">Generar reportes descargables</small>
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
                                    <label class="form-label small">Estado</label>
                                    <select id="report-status" class="form-select form-select-sm">
                                        <option value="">Todos</option>
                                        <option value="Pagado">Pagado</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Anulado">Anulado</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Forma Pago</label>
                                    <select id="report-payment" class="form-select form-select-sm">
                                        <option value="">Todas</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Tarjeta">Tarjeta</option>
                                        <option value="Transferencia">Transferencia</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label small">Almacén</label>
                                    <select id="report-warehouse" class="form-select form-select-sm">
                                        <option value="">Todos</option>
                                        <!-- Se llenará dinámicamente -->
                                    </select>
                                </div>
                            </div>

                            <!-- Resumen del Reporte -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card border-primary border">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-0 text-primary">Total Ventas</h6>
                                            <h4 class="mb-0" id="totalVentas">0</h4>
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
                                            <h6 class="mb-0 text-info">Ticket Promedio</h6>
                                            <h4 class="mb-0" id="ticketPromedio">Bs/ 0.00</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card border-warning border">
                                        <div class="card-body p-2 text-center">
                                            <h6 class="mb-0 text-warning">Ventas/Día</h6>
                                            <h4 class="mb-0" id="ventasPorDia">0</h4>
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
                                            <th>Código</th>
                                            <th>Fecha y Hora</th>
                                            <th>Cliente</th>
                                            <th>Documento</th>
                                            <th>Almacén</th>
                                            <th class="text-end">Subtotal</th>
                                            <th class="text-end">Descuento</th>
                                            <th class="text-end">IVA</th>
                                            <th class="text-end">Total</th>
                                            <th>Forma Pago</th>
                                            <th>Estado</th>
                                            <th>Vendedor</th>
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
                                            <td class="text-end" id="totalDescuento">Bs/ 0.00</td>
                                            <td class="text-end" id="totalIVA">Bs/ 0.00</td>
                                            <td class="text-end" id="totalGeneral">Bs/ 0.00</td>
                                            <td colspan="3"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Detalles Adicionales -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0">Distribución por Forma de Pago</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <canvas id="graficoPagos" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light py-2">
                                            <h6 class="mb-0">Tendencia Diaria</h6>
                                        </div>
                                        <div class="card-body p-3">
                                            <canvas id="graficoDiario" height="200"></canvas>
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
        const setupReporteVentas = () => {
            // Variables globales
            let reporteData = [];
            let graficoPagos = null;
            let graficoDiario = null;
            
            // Configuración
            const REPORT_URL = '/ventas/reporte/resumen'; // Endpoint que devuelve datos para reporte
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
            const totalVentas = document.getElementById('totalVentas');
            const montoTotal = document.getElementById('montoTotal');
            const ticketPromedio = document.getElementById('ticketPromedio');
            const ventasPorDia = document.getElementById('ventasPorDia');
            const totalSubtotal = document.getElementById('totalSubtotal');
            const totalDescuento = document.getElementById('totalDescuento');
            const totalIVA = document.getElementById('totalIVA');
            const totalGeneral = document.getElementById('totalGeneral');
            const loaderEl = document.getElementById('venta-loader');
            const loaderTextEl = document.getElementById('venta-loader-text');
            let loaderCount = 0;

            const showLoader = (text = 'Cargando...') => {
                loaderCount += 1;
                if (loaderTextEl) loaderTextEl.textContent = text;
                loaderEl?.classList.add('is-active');
                loaderEl?.setAttribute('aria-hidden', 'false');
            };

            const hideLoader = () => {
                loaderCount = Math.max(0, loaderCount - 1);
                if (loaderCount === 0) {
                    loaderEl?.classList.remove('is-active');
                    loaderEl?.setAttribute('aria-hidden', 'true');
                }
            };
            // Cargar lista de almacenes
            async function cargarAlmacenes() {
                try {
                    showLoader('Cargando reporte...');
                    const res = await fetch(ALMACENES_URL, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        const select = document.getElementById('report-warehouse');
                        select.innerHTML = '<option value="">Todos</option>';
                        data.forEach(almacen => {
                            const option = document.createElement('option');
                            option.value = almacen.id;
                            option.textContent = almacen.nombre;
                            select.appendChild(option);
                        });
                    }
                     hideLoader();
                } catch (error) {
                    console.error('Error cargando almacenes:', error);
                }
            }
            
            // Generar reporte
            async function generarReporte() {
                try {
                    showLoader('Verificando caja...');
                    const params = new URLSearchParams({
                        from: document.getElementById('report-from').value,
                        to: document.getElementById('report-to').value,
                        status: document.getElementById('report-status').value,
                        payment: document.getElementById('report-payment').value,
                        warehouse: document.getElementById('report-warehouse').value
                    });
                    
                    const res = await fetch(`${REPORT_URL}?${params.toString()}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    
                    if (!res.ok) throw new Error('Error generando reporte');
                    
                    const data = await res.json();
                    reporteData = data.ventas || [];
                    
                    actualizarEstadisticas();
                    renderizarTabla();
                    renderizarGraficos();
                    actualizarInfoReporte();
                     hideLoader();
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
                
                let totalVentasCount = reporteData.length;
                let totalMonto = 0;
                let totalSub = 0;
                let totalDesc = 0;
                let totalIva = 0;
                
                reporteData.forEach(venta => {
                    totalMonto += parseFloat(venta.total || 0);
                    totalSub += parseFloat(venta.subtotal || venta.total || 0);
                    totalDesc += parseFloat(venta.descuento || 0);
                    totalIva += parseFloat(venta.iva || 0);
                });
                
                // Calcular días entre fechas
                const from = new Date(document.getElementById('report-from').value);
                const to = new Date(document.getElementById('report-to').value);
                const dias = Math.max(1, Math.ceil((to - from) / (1000 * 60 * 60 * 24)) + 1);
                
                // Actualizar UI
                totalVentas.textContent = totalVentasCount;
                montoTotal.textContent = `Bs/ ${formatNumber(totalMonto)}`;
                ticketPromedio.textContent = `Bs/ ${formatNumber(totalMonto / totalVentasCount)}`;
                ventasPorDia.textContent = (totalVentasCount / dias).toFixed(1);
                totalSubtotal.textContent = `Bs/ ${formatNumber(totalSub)}`;
                totalDescuento.textContent = `Bs/ ${formatNumber(totalDesc)}`;
                totalIVA.textContent = `Bs/ ${formatNumber(totalIva)}`;
                totalGeneral.textContent = `Bs/ ${formatNumber(totalMonto)}`;
                totalRegistros.textContent = `${totalVentasCount} registros`;
            }
            
            function resetEstadisticas() {
                totalVentas.textContent = '0';
                montoTotal.textContent = 'Bs/ 0.00';
                ticketPromedio.textContent = 'Bs/ 0.00';
                ventasPorDia.textContent = '0';
                totalSubtotal.textContent = 'Bs/ 0.00';
                totalDescuento.textContent = 'Bs/ 0.00';
                totalIVA.textContent = 'Bs/ 0.00';
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
                                No hay ventas para los filtros seleccionados.
                            </td>
                        </tr>
                    `;
                    return;
                }
                
                reporteData.forEach((venta, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${index + 1}</td>
                        <td>${escapeHtml(venta.codigo)}</td>
                        <td>${formatDateTime(venta.fecha)}</td>
                        <td>${escapeHtml(venta.cliente_nombre || venta.cliente?.nombre || '-')}</td>
                        <td>${escapeHtml(venta.cliente_documento || venta.cliente?.documento || '-')}</td>
                        <td>${escapeHtml(venta.almacen_nombre || venta.almacen?.nombre || '-')}</td>
                        <td class="text-end">Bs/ ${formatNumber(venta.subtotal || 0)}</td>
                        <td class="text-end">Bs/ ${formatNumber(venta.descuento || 0)}</td>
                        <td class="text-end">Bs/ ${formatNumber(venta.iva || 0)}</td>
                        <td class="text-end fw-bold">Bs/ ${formatNumber(venta.total || 0)}</td>
                        <td><span class="badge bg-info">${escapeHtml(venta.forma_pago || '-')}</span></td>
                        <td><span class="badge bg-${getEstadoColor(venta.estado)}">${escapeHtml(venta.estado || '-')}</span></td>
                        <td>${escapeHtml(venta.usuario_nombre || venta.usuario?.name || '-')}</td>
                    `;
                    reporteBody.appendChild(tr);
                });
            }
            
            // Renderizar gráficos
            function renderizarGraficos() {
                if (graficoPagos) graficoPagos.destroy();
                if (graficoDiario) graficoDiario.destroy();
                
                if (!reporteData.length) return;
                
                // Gráfico de distribución por forma de pago
                const pagosData = {};
                reporteData.forEach(venta => {
                    const formaPago = venta.forma_pago || 'No especificado';
                    pagosData[formaPago] = (pagosData[formaPago] || 0) + parseFloat(venta.total || 0);
                });
                
                const ctxPagos = document.getElementById('graficoPagos').getContext('2d');
                graficoPagos = new Chart(ctxPagos, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(pagosData),
                        datasets: [{
                            data: Object.values(pagosData),
                            backgroundColor: ['#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6']
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw;
                                        const total = Object.values(pagosData).reduce((a, b) => a + b, 0);
                                        const percentage = ((value / total) * 100).toFixed(1);
                                        return `Bs/ ${formatNumber(value)} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
                
                // Gráfico de tendencia diaria
                const diarioData = {};
                reporteData.forEach(venta => {
                    const fecha = venta.fecha.split(' ')[0]; // Solo fecha
                    diarioData[fecha] = (diarioData[fecha] || 0) + parseFloat(venta.total || 0);
                });
                
                const fechasOrdenadas = Object.keys(diarioData).sort();
                const ctxDiario = document.getElementById('graficoDiario').getContext('2d');
                graficoDiario = new Chart(ctxDiario, {
                    type: 'line',
                    data: {
                        labels: fechasOrdenadas,
                        datasets: [{
                            label: 'Ventas Diarias (Bs)',
                            data: fechasOrdenadas.map(fecha => diarioData[fecha]),
                            borderColor: '#3498db',
                            backgroundColor: 'rgba(52, 152, 219, 0.1)',
                            tension: 0.4,
                            fill: true
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
                    ['#', 'Código', 'Fecha', 'Cliente', 'Documento', 'Almacén', 'Subtotal', 'Descuento', 'IVA', 'Total', 'Forma Pago', 'Estado', 'Vendedor']
                ];
                
                reporteData.forEach((venta, index) => {
                    wsData.push([
                        index + 1,
                        venta.codigo,
                        venta.fecha,
                        venta.cliente_nombre || venta.cliente?.nombre || '',
                        venta.cliente_documento || venta.cliente?.documento || '',
                        venta.almacen_nombre || venta.almacen?.nombre || '',
                        venta.subtotal || 0,
                        venta.descuento || 0,
                        venta.iva || 0,
                        venta.total || 0,
                        venta.forma_pago || '',
                        venta.estado || '',
                        venta.usuario_nombre || venta.usuario?.name || ''
                    ]);
                });
                
                // Agregar totales
                const totals = calcularTotales();
                wsData.push(['', '', '', '', '', '', '', '', '', '', '', '', '']);
                wsData.push(['TOTALES:', '', '', '', '', '', 
                    totals.subtotal, 
                    totals.descuento, 
                    totals.iva, 
                    totals.total, 
                    '', '', '']);
                
                const ws = XLSX.utils.aoa_to_sheet(wsData);
                
                // Estilos básicos (ancho de columnas)
                const wscols = [
                    {wch: 5},  // #
                    {wch: 15}, // Código
                    {wch: 20}, // Fecha
                    {wch: 25}, // Cliente
                    {wch: 15}, // Documento
                    {wch: 15}, // Almacén
                    {wch: 12}, // Subtotal
                    {wch: 12}, // Descuento
                    {wch: 10}, // IVA
                    {wch: 12}, // Total
                    {wch: 15}, // Forma Pago
                    {wch: 10}, // Estado
                    {wch: 20}  // Vendedor
                ];
                ws['!cols'] = wscols;
                
                // Crear libro de trabajo
                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, 'Reporte Ventas');
                
                // Generar nombre de archivo
                const from = document.getElementById('report-from').value;
                const to = document.getElementById('report-to').value;
                const filename = `Reporte_Ventas_${from}_al_${to}.xlsx`;
                
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
                        <title>Reporte de Ventas</title>
                        <style>
                            body { font-family: Arial, sans-serif; font-size: 12px; }
                            .header { text-align: center; margin-bottom: 20px; }
                            .title { font-size: 18px; font-weight: bold; }
                            .subtitle { font-size: 14px; color: #666; }
                            .info { margin-bottom: 20px; }
                            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                            th { background-color: #f2f2f2; text-align: left; padding: 8px; border: 1px solid #ddd; }
                            td { padding: 6px; border: 1px solid #ddd; }
                            .text-right { text-align: right; }
                            .text-center { text-align: center; }
                            .total-row { font-weight: bold; background-color: #f9f9f9; }
                            .footer { margin-top: 30px; font-size: 10px; color: #666; text-align: center; }
                        </style>
                    </head>
                    <body>
                        <div class="header">
                            <div class="title">REPORTE DE VENTAS</div>
                            <div class="subtitle">${document.getElementById('reporteInfo').textContent}</div>
                        </div>
                        
                        <div class="info">
                            <strong>Filtros aplicados:</strong><br>
                            Fecha: ${formatDate(from)} - ${formatDate(to)}<br>
                            Estado: ${document.getElementById('report-status').value || 'Todos'}<br>
                            Forma Pago: ${document.getElementById('report-payment').value || 'Todas'}<br>
                            Total Registros: ${reporteData.length}
                        </div>
                        
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Almacén</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="text-right">Descuento</th>
                                    <th class="text-right">Total</th>
                                    <th>Forma Pago</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${reporteData.map((venta, index) => `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${venta.codigo}</td>
                                        <td>${venta.fecha}</td>
                                        <td>${venta.cliente_nombre || venta.cliente?.nombre || ''}</td>
                                        <td>${venta.almacen_nombre || venta.almacen?.nombre || ''}</td>
                                        <td class="text-right">Bs/ ${formatNumber(venta.subtotal || 0)}</td>
                                        <td class="text-right">Bs/ ${formatNumber(venta.descuento || 0)}</td>
                                        <td class="text-right">Bs/ ${formatNumber(venta.total || 0)}</td>
                                        <td>${venta.forma_pago || ''}</td>
                                        <td>${venta.estado || ''}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                            <tfoot>
                                <tr class="total-row">
                                    <td colspan="5" class="text-right"><strong>TOTALES:</strong></td>
                                    <td class="text-right"><strong>Bs/ ${formatNumber(totals.subtotal)}</strong></td>
                                    <td class="text-right"><strong>Bs/ ${formatNumber(totals.descuento)}</strong></td>
                                    <td class="text-right"><strong>Bs/ ${formatNumber(totals.total)}</strong></td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <div class="footer">
                            Generado el ${new Date().toLocaleString('es-ES')} | Sistema de Ventas
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
                        const filename = `Reporte_Ventas_${from}_al_${to}.pdf`;
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
                
                const headers = ['#', 'Código', 'Fecha', 'Cliente', 'Documento', 'Almacén', 'Subtotal', 'Descuento', 'IVA', 'Total', 'Forma Pago', 'Estado', 'Vendedor'];
                const rows = reporteData.map((venta, index) => [
                    index + 1,
                    venta.codigo,
                    venta.fecha,
                    venta.cliente_nombre || venta.cliente?.nombre || '',
                    venta.cliente_documento || venta.cliente?.documento || '',
                    venta.almacen_nombre || venta.almacen?.nombre || '',
                    venta.subtotal || 0,
                    venta.descuento || 0,
                    venta.iva || 0,
                    venta.total || 0,
                    venta.forma_pago || '',
                    venta.estado || '',
                    venta.usuario_nombre || venta.usuario?.name || ''
                ]);
                
                const csvContent = [
                    headers.join(','),
                    ...rows.map(row => row.map(cell => `"${cell}"`).join(','))
                ].join('\n');
                
                const from = document.getElementById('report-from').value;
                const to = document.getElementById('report-to').value;
                const filename = `Reporte_Ventas_${from}_al_${to}.csv`;
                
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
                let descuento = 0;
                let iva = 0;
                let total = 0;
                
                reporteData.forEach(venta => {
                    subtotal += parseFloat(venta.subtotal || venta.total || 0);
                    descuento += parseFloat(venta.descuento || 0);
                    iva += parseFloat(venta.iva || 0);
                    total += parseFloat(venta.total || 0);
                });
                
                return { subtotal, descuento, iva, total };
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
            
            function formatDateTime(value) {
                if (!value) return '-';
                try {
                    const d = new Date(value);
                    return d.toLocaleString('es-ES');
                } catch {
                    return value;
                }
            }
            
            function getEstadoColor(estado) {
                switch(estado) {
                    case 'Pagado': return 'success';
                    case 'Anulado': return 'danger';
                    case 'Pendiente': return 'warning';
                    default: return 'secondary';
                }
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
            cargarAlmacenes();
            actualizarInfoReporte();
        };

        const handleReporteVentasLoad = () => {
            const root = document.getElementById('reporte-body');
            if (!root) return;
            if (root.dataset.reporteVentasInit === '1') return;
            root.dataset.reporteVentasInit = '1';
            setupReporteVentas();
        };

        document.addEventListener('turbo:load', handleReporteVentasLoad);
        document.addEventListener('DOMContentLoaded', handleReporteVentasLoad);
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
        
/* Loader overlay */
.venta-loader {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.35);
    backdrop-filter: blur(2px);
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
}
.venta-loader.is-active {
    opacity: 1;
    pointer-events: all;
}
.venta-loader-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.venta-loader-icon {
    width: 36px;
    height: 36px;
}
.venta-loader-text {
    font-weight: 600;
    color: #1f2937;
}
[data-bs-theme="dark"] .venta-loader-card {
    background: #0f172a;
    color: #e5e7eb;
    border: 1px solid #1f2937;
}
[data-bs-theme="dark"] .venta-loader-text {
    color: #e5e7eb;
}

/* ===== Dark theme overrides ===== */
[data-bs-theme="dark"] {
    --primary-color: #e2e8f0;
    --secondary-color: #60a5fa;
    --accent-color: #3b82f6;
    --light-color: #122143;
    --medium-color: #1a2b46;
    --dark-color: #cbd5f5;
    --box-shadow: 0 6px 18px rgba(21, 26, 68, 0.35);
    --box-shadow-hover: 0 12px 26px rgba(20, 22, 75, 0.45);
}

[data-bs-theme="dark"] .venta-container {
    background: #0b1220;
}

[data-bs-theme="dark"] .venta-header,
[data-bs-theme="dark"] .venta-main-card {
    background: #1b2844;
    border-color: #1f2b3d;
}

[data-bs-theme="dark"] .venta-header h6,
[data-bs-theme="dark"] .search-header h4,
[data-bs-theme="dark"] .carrito-header h6,
[data-bs-theme="dark"] .section-title,
[data-bs-theme="dark"] .summary-label,
[data-bs-theme="dark"] .summary-value {
    color: #e5e7eb;
}

[data-bs-theme="dark"] .venta-header-info .info-item,
[data-bs-theme="dark"] .text-muted {
    color: #cbd5e1 !important;
}

[data-bs-theme="dark"] .venta-header .form-control-sm,
[data-bs-theme="dark"] .venta-header .form-select-sm,
[data-bs-theme="dark"] .search-box .form-control,
[data-bs-theme="dark"] .input-group-text {
    background: #0f172a;
    border-color: #1f2937;
    color: #e5e7eb;
}

[data-bs-theme="dark"] .venta-header .text-dark {
    color: #e5e7eb !important;
}

[data-bs-theme="dark"] .quick-client-card,
[data-bs-theme="dark"] .client-card {
    background: #0f172a;
    border-color: #1f2937;
}

[data-bs-theme="dark"] .quick-inline-input,
[data-bs-theme="dark"] .summary-inline-input {
    color: #e5e7eb;
    border-bottom-color: #334155;
}

[data-bs-theme="dark"] .summary-inline-input:focus,
[data-bs-theme="dark"] .quick-inline-input:focus {
    background: #0b1426;
}

[data-bs-theme="dark"] .carrito-section {
    background: transparent;
}

[data-bs-theme="dark"] .carrito-header {
    border-bottom-color: #1f2937;
}

[data-bs-theme="dark"] .input-group-pro label {
    color: #cbd5e1;
}

[data-bs-theme="dark"] .input-group-pro input,
[data-bs-theme="dark"] .input-group-pro select {
    background: #0f172a;
    border-color: #1f2937;
    color: #e5e7eb;
}

[data-bs-theme="dark"] .input-group-pro input:focus,
[data-bs-theme="dark"] .input-group-pro select:focus {
    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.2);
}

[data-bs-theme="dark"] .product-card-pro {
    background: #0f172a;
    border-color: #1f2937;
}

[data-bs-theme="dark"] .product-header-pro {
    background: #111827;
    border-bottom-color: #1f2937;
}

[data-bs-theme="dark"] .product-image-pro {
    background: #0b1426;
}

[data-bs-theme="dark"] .product-info-pro {
    color: #e5e7eb;
}

[data-bs-theme="dark"] .product-title-pro {
    color: #e5e7eb;
}

[data-bs-theme="dark"] .product-specs-pro {
    border-top-color: #1f2937;
}

[data-bs-theme="dark"] .spec-label-pro {
    color: #cbd5e1;
}

[data-bs-theme="dark"] .spec-value-pro {
    color: #e5e7eb;
}

[data-bs-theme="dark"] .price-unit-pro {
    color: #cbd5e1;
}

    </style>
</x-layout>
