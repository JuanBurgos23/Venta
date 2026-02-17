<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <!-- Scripts -->
        @vite([ 'resources/js/app.js'])
        <script>
            window.EMPRESA_ID = @json(optional(auth()->user())->id_empresa);
        </script>
        <!-- End Navbar -->
        
        <div class="container-fluid py-4">
            <!-- Header Stats Row -->
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Ganancias Hoy</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            $<span id="gananciasHoy">0.00</span>
                                            <span class="text-success text-sm font-weight-bolder">+55%</span>
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+$3,450</span>
                                            vs ayer
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow-primary text-center border-radius-md">
                                        <i class="fas fa-dollar-sign text-lg opacity-10"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Ganancias Mensual</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            $<span id="gananciasMensual">0.00</span>
                                            <span class="text-success text-sm font-weight-bolder">+12%</span>
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+$12,800</span>
                                            vs mes anterior
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-success shadow-success text-center border-radius-md">
                                        <i class="fas fa-chart-line text-lg opacity-10"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Ventas Hoy</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            <span id="ventasHoy">0</span>
                                            <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-danger text-sm font-weight-bolder">-8</span>
                                            transacciones
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-warning shadow-warning text-center border-radius-md">
                                        <i class="fas fa-shopping-cart text-lg opacity-10"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Vendedores Activos</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            <span id="vendedoresActivos">0</span>/<span id="totalVendedores">0</span>
                                            <span class="text-success text-sm font-weight-bolder">+5</span>
                                        </h5>
                                        <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+85%</span>
                                            productividad
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-info shadow-info text-center border-radius-md">
                                        <i class="fas fa-users text-lg opacity-10"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Charts Row -->
            <div class="row mb-4">
                <!-- Ganancias Diarias Chart -->
                <div class="col-xl-8 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6>Ganancias Diarias</h6>
                                    <p class="text-sm mb-0">
                                        <i class="fas fa-circle text-primary"></i> Hoy
                                        <i class="fas fa-circle text-info"></i> Ayer
                                    </p>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-link text-body-secondary px-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="javascript:;">Últimos 7 días</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">Últimos 30 días</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">Este año</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart" style="height: 300px;">
                                <canvas id="gananciasChart" class="chart-canvas" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Rendimiento Vendedores -->
                <div class="col-xl-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Rendimiento de Vendedores</h6>
                            <p class="text-sm mb-0">Top 5 vendedores del mes</p>
                        </div>
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vendedor</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ventas</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Meta</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Rendimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody id="topVendedores">
                                        <!-- Los datos se cargarán dinámicamente -->
                                        <tr>
                                            <td colspan="4" class="text-center">
                                                <div class="spinner-border text-primary" role="status">
                                                    <span class="visually-hidden">Cargando...</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <div class="progress-wrapper">
                                    <div class="progress-info">
                                        <div class="progress-percentage">
                                            <span class="text-sm font-weight-bold">Meta del equipo: 75%</span>
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-gradient-primary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Second Row -->
            <div class="row mb-4">
                <!-- Métricas Mensuales -->
                <div class="col-xl-4 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h6>Métricas Mensuales</h6>
                                <div class="dropdown">
                                    <button class="btn btn-link text-body-secondary px-0" type="button" id="metricasDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="metricasDropdown">
                                        <li><a class="dropdown-item" href="javascript:;">Exportar PDF</a></li>
                                        <li><a class="dropdown-item" href="javascript:;">Exportar Excel</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row text-center">
                                <div class="col-6 mb-4">
                                    <div class="card border">
                                        <div class="card-body p-2">
                                            <h6 class="mb-0">Tasa Conversión</h6>
                                            <h2 class="mb-0 text-primary">4.8%</h2>
                                            <p class="text-xs mb-0">+0.4% vs mes anterior</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-4">
                                    <div class="card border">
                                        <div class="card-body p-2">
                                            <h6 class="mb-0">Ticket Promedio</h6>
                                            <h2 class="mb-0 text-success">$245.60</h2>
                                            <p class="text-xs mb-0">+$15.20 vs mes anterior</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card border">
                                        <div class="card-body p-2">
                                            <h6 class="mb-0">Clientes Nuevos</h6>
                                            <h2 class="mb-0 text-info">128</h2>
                                            <p class="text-xs mb-0">+24 vs mes anterior</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card border">
                                        <div class="card-body p-2">
                                            <h6 class="mb-0">Satisfacción</h6>
                                            <h2 class="mb-0 text-warning">4.7</h2>
                                            <p class="text-xs mb-0">/5.0 (+0.3)</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ventas por Categoría -->
                <div class="col-xl-4 mb-xl-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <h6>Ventas por Categoría</h6>
                            <p class="text-sm mb-0">Distribución mensual</p>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart" style="height: 250px;">
                                <canvas id="categoriasChart" class="chart-canvas" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Productos -->
                <div class="col-xl-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h6>Productos Más Vendidos</h6>
                                <span class="badge bg-primary">Hoy</span>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <ul class="list-group list-group-flush" id="topProductos">
                                <!-- Los datos se cargarán dinámicamente -->
                                <li class="list-group-item px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="spinner-border spinner-border-sm text-primary me-3" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                        <span class="text-sm">Cargando productos...</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Third Row -->
            <div class="row">
                <!-- Histórico de Ventas -->
                <div class="col-xl-8 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h6>Histórico de Ventas - Últimos 12 Meses</h6>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary active">Mensual</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary">Trimestral</button>
                                    <button type="button" class="btn btn-sm btn-outline-primary">Anual</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="chart" style="height: 250px;">
                                <canvas id="historicoChart" class="chart-canvas" height="250"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alertas y Notificaciones -->
                <div class="col-xl-4">
                    <div class="card h-100">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                                <h6>Alertas del Sistema</h6>
                                <span class="badge bg-danger">3</span>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="timeline timeline-one-side">
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step bg-gradient-danger">
                                        <i class="fas fa-exclamation-circle"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Stock Bajo</h6>
                                        <p class="text-secondary text-xs mt-1 mb-0">Producto "X" tiene solo 5 unidades</p>
                                        <span class="text-xs text-muted">Hace 2 horas</span>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step bg-gradient-warning">
                                        <i class="fas fa-clock"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Pedido Pendiente</h6>
                                        <p class="text-secondary text-xs mt-1 mb-0">Pedido #4567 espera aprobación</p>
                                        <span class="text-xs text-muted">Hace 4 horas</span>
                                    </div>
                                </div>
                                <div class="timeline-block mb-3">
                                    <span class="timeline-step bg-gradient-success">
                                        <i class="fas fa-chart-line"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Meta Superada</h6>
                                        <p class="text-secondary text-xs mt-1 mb-0">Ventas del día superaron la meta en 15%</p>
                                        <span class="text-xs text-muted">Hoy</span>
                                    </div>
                                </div>
                                <div class="timeline-block">
                                    <span class="timeline-step bg-gradient-info">
                                        <i class="fas fa-user-plus"></i>
                                    </span>
                                    <div class="timeline-content">
                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Nuevo Cliente</h6>
                                        <p class="text-secondary text-xs mt-1 mb-0">"Empresa ABC" se registró en el sistema</p>
                                        <span class="text-xs text-muted">Ayer</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 text-center">
                                <button class="btn btn-sm btn-outline-primary">Ver todas las alertas</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats Footer -->
            <div class="row mt-4">
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-calendar-check text-primary text-lg mb-2"></i>
                            <h6 class="mb-1">Órdenes Hoy</h6>
                            <h4 class="mb-0" id="ordenesHoy">0</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-user-check text-success text-lg mb-2"></i>
                            <h6 class="mb-1">Clientes Activos</h6>
                            <h4 class="mb-0" id="clientesActivos">0</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-box text-warning text-lg mb-2"></i>
                            <h6 class="mb-1">Inventario</h6>
                            <h4 class="mb-0" id="itemsInventario">0</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="card">
                        <div class="card-body text-center p-3">
                            <i class="fas fa-percentage text-info text-lg mb-2"></i>
                            <h6 class="mb-1">Tasa Éxito</h6>
                            <h4 class="mb-0" id="tasaExito">0%</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts para gráficos dinámicos -->
    <!-- Chart.js se carga via Vite (resources/js/app.js) para evitar bloqueos de CDN -->
<script>
function initDashboard() {
  initGananciasChart();
  initCategoriasChart();
  initHistoricoChart();
  loadDashboardData();
  setInterval(loadDashboardData, 30000);
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initDashboard);
} else {
  initDashboard();
}

function initGananciasChart() {
  const el = document.getElementById('gananciasChart');
  if (!el || !window.Chart) return;
  if (window.gananciasChart) return;

  window.gananciasChart = new Chart(el, {
    type: 'line',
    data: {
      labels: [],
      datasets: [
        {
          label: 'Hoy',
          data: [],
          borderColor: '#3498db',
          backgroundColor: 'rgba(52,152,219,0.15)',
          tension: 0.35,
          fill: true
        },
        {
          label: 'Ayer',
          data: [],
          borderColor: '#17a2b8',
          backgroundColor: 'rgba(23,162,184,0.10)',
          tension: 0.35,
          fill: true
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: { grid: { display: false } },
        y: { beginAtZero: true }
      }
    }
  });
}

function initCategoriasChart() {
  const el = document.getElementById('categoriasChart');
  if (!el || !window.Chart) return;
  if (window.categoriasChart) return;

  window.categoriasChart = new Chart(el, {
    type: 'doughnut',
    data: {
      labels: [],
      datasets: [{
        data: [],
        backgroundColor: [
          '#3498db', '#2ecc71', '#f39c12', '#e67e22',
          '#9b59b6', '#1abc9c', '#e74c3c', '#95a5a6'
        ],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom' } }
    }
  });
}

function initHistoricoChart() {
  const el = document.getElementById('historicoChart');
  if (!el || !window.Chart) return;
  if (window.historicoChart) return;

  window.historicoChart = new Chart(el, {
    type: 'bar',
    data: {
      labels: [],
      datasets: [{
        label: 'Ventas',
        data: [],
        backgroundColor: 'rgba(46, 204, 113, 0.6)',
        borderColor: '#2ecc71',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: { grid: { display: false } },
        y: { beginAtZero: true }
      }
    }
  });
}

function getEmpresaId() {
  // ideal: injectarlo desde blade con window.EMPRESA_ID (evitar cerrar script en comentarios)
  return window.EMPRESA_ID || null;
}

async function loadDashboardData() {
  const empresaId = getEmpresaId();
  const today = new Date().toISOString().slice(0,10);
  const ym = new Date().toISOString().slice(0,7);
  const baseParams = empresaId ? { empresa_id: empresaId } : {};

  const diarioUrl = buildUrl('/dashboard/diario', { ...baseParams, fecha: today });
  const mensualUrl = buildUrl('/dashboard/mensual', { ...baseParams, mes: ym });
  const catsUrl = buildUrl('/dashboard/categorias-mensual', { ...baseParams, mes: ym });
  const histUrl = buildUrl('/dashboard/historico-12m', baseParams);
  const topVendUrl = buildUrl('/dashboard/top-vendedores-mensual', { ...baseParams, mes: ym, meta: 100000 });

  const [
    diario,
    mensual,
    cats,
    hist,
    topVend
  ] = await Promise.all([
    fetchJsonSafe(diarioUrl),
    fetchJsonSafe(mensualUrl),
    fetchJsonSafe(catsUrl),
    fetchJsonSafe(histUrl),
    fetchJsonSafe(topVendUrl)
  ]);

  // Cards principales
  const ventasHoy = diario?.resumen?.ventas_netas ?? 0;
  const ticketsHoy = diario?.resumen?.tickets ?? 0;
  setTextMoney('gananciasHoy', ventasHoy);
  setText('ventasHoy', ticketsHoy);

  // 2) Mensual
  const ventasMes = mensual?.resumen?.ventas_netas ?? 0;
  setTextMoney('gananciasMensual', ventasMes);

  // 3) Serie horas => gananciasChart (Hoy vs Ayer simple)
  if (window.gananciasChart && diario?.serie_horas) {
    window.gananciasChart.data.labels = diario.serie_horas.labels;
    window.gananciasChart.data.datasets[0].data = diario.serie_horas.data;

    // Ayer: pide otro diario (si falla, solo no pinta ayer)
    const yesterday = new Date(Date.now() - 86400000).toISOString().slice(0,10);
    const diarioAyerUrl = buildUrl('/dashboard/diario', { ...baseParams, fecha: yesterday });
    const diarioAyer = await fetchJsonSafe(diarioAyerUrl);
    const ayerData = diarioAyer?.serie_horas?.data ?? new Array(diario.serie_horas.data.length).fill(0);
    window.gananciasChart.data.datasets[1].data = ayerData;
    window.gananciasChart.update();
  }

  // 4) Categorías => categoriasChart
  if (window.categoriasChart && cats?.labels) {
    window.categoriasChart.data.labels = cats.labels;
    window.categoriasChart.data.datasets[0].data = cats.data;
    window.categoriasChart.update();
  }

  // 5) Histórico 12 meses => historicoChart
  if (window.historicoChart && hist?.labels) {
    window.historicoChart.data.labels = hist.labels;
    window.historicoChart.data.datasets[0].data = hist.data;
    window.historicoChart.update();
  }

  // 6) Top productos (lista)
  renderTopProductos(diario?.top_productos ?? []);

  // 7) Top vendedores (tabla)
  renderTopVendedores(topVend?.data ?? [], topVend?.meta ?? 100000);

  // Footer quick stats (si no tienes tabla clientes/inventario aún, los dejas en 0)
  setText('ordenesHoy', ticketsHoy);
  // clientesActivos/itemsInventario/tasaExito los calculas cuando tengas endpoints
}

async function fetchJson(url) {
  const res = await fetch(url, { headers: { 'Accept': 'application/json' }});
  if (!res.ok) throw new Error(await res.text());
  const json = await res.json();
  if (json && json.ok === false) throw new Error(json.msg || 'Error');
  return json;
}

async function fetchJsonSafe(url) {
  try {
    return await fetchJson(url);
  } catch (e) {
    console.error('Dashboard fetch error:', url, e);
    return null;
  }
}

function setText(id, val) {
  const el = document.getElementById(id);
  if (el) el.textContent = val;
}

function setTextMoney(id, val) {
  const el = document.getElementById(id);
  if (el) el.textContent = Number(val || 0).toLocaleString('en-US', { minimumFractionDigits: 2 });
}

function renderTopProductos(rows) {
  const ul = document.getElementById('topProductos');
  if (!ul) return;
  if (!rows.length) {
    ul.innerHTML = `<li class="list-group-item px-0"><span class="text-sm text-secondary">Sin datos</span></li>`;
    return;
  }
  ul.innerHTML = rows.slice(0,5).map((p, i) => `
    <li class="list-group-item px-0">
      <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
          <span class="badge bg-gradient-primary me-3">${i+1}</span>
          <div>
            <h6 class="mb-0 text-sm">${escapeHtml(p.nombre)}</h6>
            <p class="text-xs text-secondary mb-0">${Number(p.cantidad || 0)} unidades</p>
          </div>
        </div>
        <div class="text-end">
          <h6 class="mb-0 text-sm text-success">$${Number(p.ventas||0).toLocaleString()}</h6>
          <p class="text-xs text-secondary mb-0">ventas</p>
        </div>
      </div>
    </li>
  `).join('');
}

function renderTopVendedores(rows, meta) {
  const tbody = document.getElementById('topVendedores');
  if (!tbody) return;

  if (!rows.length) {
    tbody.innerHTML = `<tr><td colspan="4" class="text-center text-secondary">Sin datos</td></tr>`;
    setText('vendedoresActivos', 0);
    setText('totalVendedores', 0);
    return;
  }

  // “Activos” = los que vendieron en el mes; “Total” si no tienes tabla users por ahora lo dejamos igual
  setText('vendedoresActivos', rows.length);
  setText('totalVendedores', rows.length);

  tbody.innerHTML = rows.map(v => {
    const ventas = Number(v.ventas || 0);
    const rendimiento = meta > 0 ? Math.round((ventas / meta) * 100) : 0;
    const bar = Math.min(rendimiento, 100);

    return `
      <tr>
        <td>
          <div class="d-flex align-items-center">
            <div class="avatar avatar-sm me-3">
              <span class="avatar-initial rounded-circle bg-gradient-primary">${escapeHtml((v.nombre||'V')[0])}</span>
            </div>
            <div><h6 class="mb-0 text-sm">${escapeHtml(v.nombre || 'Vendedor')}</h6></div>
          </div>
        </td>
        <td><p class="text-sm font-weight-bold mb-0">$${ventas.toLocaleString()}</p></td>
        <td><p class="text-sm font-weight-bold mb-0">$${Number(meta).toLocaleString()}</p></td>
        <td>
          <div class="d-flex align-items-center">
            <span class="me-2 text-sm font-weight-bold">${rendimiento}%</span>
            <div class="progress" style="width: 100px; height: 6px;">
              <div class="progress-bar bg-gradient-${rendimiento>=100?'success':rendimiento>=80?'warning':'danger'}"
                   role="progressbar" style="width:${bar}%"></div>
            </div>
          </div>
        </td>
      </tr>
    `;
  }).join('');
}

function escapeHtml(s) {
  return String(s ?? '').replace(/[&<>"']/g, m => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
  }[m]));
}

function buildUrl(path, params) {
  const qs = new URLSearchParams(params || {});
  const q = qs.toString();
  return q ? `${path}?${q}` : path;
}
</script>


    <style>
        .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .timeline-step {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
        
        .timeline-one-side .timeline-content {
            margin-left: 45px;
        }
        
        .chart-canvas {
            width: 100% !important;
        }
        
        .progress {
            height: 6px;
        }
        
        .avatar-initial {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }
        
        .icon-shape {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
        }
        
        .bg-gradient-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        }
        
        .bg-gradient-success {
            background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        }
        
        .bg-gradient-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        }
        
        .bg-gradient-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        }
        
        .bg-gradient-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }
        
        .text-primary { color: #3498db !important; }
        .text-success { color: #2ecc71 !important; }
        .text-warning { color: #f39c12 !important; }
        .text-info { color: #17a2b8 !important; }
        .text-danger { color: #e74c3c !important; }
    </style>
</x-layout>
