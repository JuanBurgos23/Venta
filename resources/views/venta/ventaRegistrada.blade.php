<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
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
                                <h5 class="mb-0">Listado de Ventas</h5>
                                <small class="text-muted">Panel administrativo</small>
                            </div>
                            <a href="/venta" class="btn btn-primary btn-sm">Registrar venta</a>
                        </div>

                        <div class="card-body">
                            <div class="row g-2 mb-3">
                                <div class="col-md-4">
                                    <label class="form-label mb-1 small">Buscar</label>
                                    <input id="global-search" class="form-control form-control-sm" placeholder="Cliente, codigo, usuario..." />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mb-1 small">Desde</label>
                                    <input type="date" id="filter-from" class="form-control form-control-sm" />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mb-1 small">Hasta</label>
                                    <input type="date" id="filter-to" class="form-control form-control-sm" />
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label mb-1 small">Estado</label>
                                    <select id="filter-status" class="form-select form-select-sm">
                                        <option value="">Todos</option>
                                        <option value="Registrado">Registrado</option>
                                        <option value="Pagado">Pagado</option>
                                        <option value="Pendiente">Pendiente</option>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button class="btn btn-dark w-100" id="btnReload">
                                        <i class="bx bx-search"></i> Filtrar
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-striped align-middle mb-0" id="ventas-table">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th style="width:48px"></th>
                                            <th>Código</th>
                                            <th>Fecha</th>
                                            <th>Cliente</th>
                                            <th>Usuario</th>
                                            <th>Almacén</th>
                                            <th class="text-end">Total</th>
                                            <th class="text-center">Forma Pago</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ventas-body">
                                        <tr>
                                            <td colspan="10" class="text-center py-5">Cargando ventas...</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <td colspan="6" class="text-end fw-bold">Total visible:</td>
                                            <td class="text-end fw-bold" id="visible-total">Bs/ 0.00</td>
                                            <td colspan="3"></td>
                                        </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div id="ventas-cards" class="d-md-none"></div>
                    </div>

                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div id="result-count" class="text-muted">—</div>
                            <nav>
                                <ul class="pagination pagination-sm justify-content-center mb-0" id="ventas-pagination"></ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Estilos locales para animaciones y apariencia --}}
    <style>
        /* fila detalle colapsada */
        .detalle-row.collapsed {
            max-height: 0;
            overflow: hidden;
            transition: max-height 300ms ease;
            background: var(--bs-body-bg);
            /* se adapta a theme bootstrap */
        }

        /* fila detalle expandida */
        .detalle-row.open {
            max-height: 800px;
            /* suficiente para mostrar */
        }

        .detalle-row td {
            padding: 0;
            /* elimina padding extra */
        }

        .detalle-card {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            background: var(--bs-card-bg);
            color: var(--bs-body-color);
            border-radius: .5rem;
            border: 1px solid var(--bs-border-color);
        }

        .detalle-row .detalle-card {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
            background: var(--bs-card-bg);
            color: var(--bs-body-color);
            border-radius: .5rem;
            border: 1px solid var(--bs-border-color);
        }



        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* estilo de botón acción pequeño */
        .action-btn {
            min-width: 36px;
        }

        /* responsive tweaks */
        @media (max-width: 768px) {
            .card-header .input-group {
                width: 100%;
                margin-top: .5rem;
            }

            .card-header {
                gap: .5rem;
            }

            th:nth-child(5),
            td:nth-child(5) {
                display: none;
            }

            /* ocultar usuario en móvil para ahorrar espacio */
        }
    </style>

    {{-- Scripts --}}
    <script>
        const setupVentasRegistradas = () => {
            const CAN_ANULAR = @json(auth()->user()->can('ventas.eliminar'));
            // Config
            const LIST_URL = '/ventas/fetch'; // endpoint que debe devolver paginado { data: [...], current_page, last_page, total }
            const ANULAR_URL = id => `/venta/${id}/anular`; // endpoint PUT/POST que marca estado Eliminado
            const PRINT_URL = id => `/ventas/print/${id}`; // endpoint para imprimir/open print view
            const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Estado UI
            let salesCache = []; // ventas actuales (pagina)
            let currentPage = 1;
            let lastPage = 1;
            const perPage = 10;

            // Elementos
            const body = document.getElementById('ventas-body');
            const pagination = document.getElementById('ventas-pagination');
            const searchInput = document.getElementById('global-search');
            const filterFrom = document.getElementById('filter-from');
            const filterTo = document.getElementById('filter-to');
            const filterStatus = document.getElementById('filter-status');
            const visibleTotalEl = document.getElementById('visible-total');
            const resultCount = document.getElementById('result-count');
            const btnReload = document.getElementById('btnReload');
            const cardsContainer = document.getElementById('ventas-cards');
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
            // Inicializar fechas (hoy)
            const today = new Date();
            const todayLocal = new Date(today.getTime() - today.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
            filterFrom.value = todayLocal;
            filterTo.value = todayLocal;
            loadSales(1);
            // Debounce helper
            function debounce(fn, delay = 250) {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...args), delay);
                };
            }

            // Cargar ventas desde backend (paginated)
            async function loadSales(page = 1) {
                try {
                    showLoader('Cargando Ventas...');
                    const params = new URLSearchParams({
                        page,
                        per_page: perPage,
                        from: filterFrom.value,
                        to: filterTo.value,
                        status: filterStatus.value,
                        q: searchInput.value || ''
                    });
                    const res = await fetch(`${LIST_URL}?${params.toString()}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!res.ok) throw new Error('Error cargando ventas');
                    const payload = await res.json();

                    // payload expected to have: data, current_page, last_page, total
                    salesCache = payload.data || [];
                    currentPage = payload.current_page || 1;
                    lastPage = payload.last_page || 1;

                    renderTable();
                    renderPagination();
                     hideLoader();
                } catch (err) {
                    console.error(err);
                    body.innerHTML = `<tr><td colspan="10" class="text-center text-danger">Error cargando ventas</td></tr>`;
                }
            }

            // Render tabla según salesCache y filtros locales (filtrado en tiempo real para los inputs)
            function renderTable() {
                body.innerHTML = '';
                if (!salesCache.length) {
                    body.innerHTML = `<tr><td colspan="10" class="text-center py-4 text-muted">No hay ventas para el periodo seleccionado</td></tr>`;
                    visibleTotalEl.textContent = 'Bs/ 0.00';
                    resultCount.textContent = '0 ventas';
                    return;
                }

                // construye las filas
                let totalVisible = 0;
                salesCache.forEach((v) => {
                    // fila principal
                    const tr = document.createElement('tr');
                    tr.className = 'align-middle';
                    tr.dataset.id = v.id;

                    // expand toggle cell
                    const toggleId = `toggle-${v.id}`;
                    tr.innerHTML = `
                        <td class="text-center">
                            <button class="btn btn-sm btn-light action-btn toggle-detail" data-id="${v.id}" aria-expanded="false" title="Ver detalle">
                                <i class="bx bx-chevron-down"></i>
                            </button>
                        </td>
                        <td>${escapeHtml(v.codigo)}</td>
                        <td>${formatDateTime(v.fecha)}</td>
                        <td>${escapeHtml(v.cliente?.nombre ?? '-')}</td>
                        <td class="d-none d-md-table-cell">${escapeHtml(v.usuario?.name ?? '-')}</td>
                        <td>${escapeHtml(v.almacen?.nombre ?? '-')}</td>
                        <td class="text-end">Bs/ ${numberFormat(v.total)}</td>
                        <td class="text-center">${escapeHtml(v.forma_pago ?? '-')}</td>
                        <td class="text-center"><span class="badge bg-${v.estado === 'Anulado' ? 'danger' : (v.estado === 'Pagado' ? 'success' : 'secondary')}">${escapeHtml(v.estado)}</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-secondary btn-print" data-id="${v.id}" title="Imprimir"><i class="bx bx-printer"></i></button>
                            <button class="btn btn-sm btn-danger btn-anular" data-id="${v.id}" title="Anular"><i class="bx bx-x"></i></button>
                        </td>
                    `;
                    body.appendChild(tr);

                    // detalle row (oculto por defecto)
                    const detailTr = document.createElement('tr');
                    detailTr.className = 'detalle-row collapsed';
                    detailTr.dataset.parent = v.id;
                    detailTr.style.display = 'none'; // <-- importante, oculto completo
                    detailTr.innerHTML = `
                        <td colspan="10" style="padding:0;">
                            <div class="detalle-card p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>Detalle de Venta:</strong> ${escapeHtml(v.codigo)} — <small class="text-muted">${formatDateTime(v.fecha)}</small>
                                        <div class="text-muted">Cliente: ${escapeHtml(v.cliente?.nombre ?? '-')} · Usuario: ${escapeHtml(v.usuario?.name ?? '-')}</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">Total: Bs/ ${numberFormat(v.total)}</div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-sm mb-0">
                                        <thead>
                                            <tr class="text-muted small">
                                                <th>Producto</th><th>Cantidad</th><th>Unidad</th><th class="text-end">Precio U.</th><th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${ (v.detalles || []).map(d => `
                                                <tr>
                                                    <td>${escapeHtml(d.producto?.nombre ?? d.nombre ?? '-')}</td>
                                                    <td>${parseFloat(d.cantidad).toFixed(2)}</td>
                                                    <td>${escapeHtml(d.unidad_medida?.nombre ?? (d.unidad ?? '-'))}</td>
                                                    <td class="text-end">Bs/ ${numberFormat(d.precio_unitario)}</td>
                                                    <td class="text-end">Bs/ ${numberFormat(d.subtotal)}</td>
                                                </tr>
                                            `).join('') }
                                        </tbody>
                                    </table>
                                </div>

                                ${ v.observaciones ? `<div class="mt-2 text-muted"><strong>Observaciones:</strong> ${escapeHtml(v.observaciones)}</div>` : '' }
                            </div>
                        </td>
                    `;
                    body.appendChild(detailTr);

                    totalVisible += parseFloat(v.total || 0);
                });

                visibleTotalEl.textContent = `Bs/ ${numberFormat(totalVisible)}`;
                resultCount.textContent = `${salesCache.length} venta(s)`;
                attachRowEvents();
                renderCards();
            }

            // Cards para mÇüvil
            function renderCards() {
                if (!cardsContainer) return;
                cardsContainer.innerHTML = '';

                if (!salesCache.length) {
                    cardsContainer.innerHTML = `<div class="text-center text-muted py-4">No hay ventas para el periodo seleccionado</div>`;
                    return;
                }

                salesCache.forEach((v) => {
                    const card = document.createElement('div');
                    card.className = 'card mb-2';
                    card.innerHTML = `
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="fw-bold">${escapeHtml(v.codigo)}</div>
                                    <div class="text-muted small">${formatDateTime(v.fecha)}</div>
                                    <div class="small">${escapeHtml(v.cliente?.nombre ?? '-')}</div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">Bs/ ${numberFormat(v.total)}</div>
                                    <span class="badge bg-${v.estado === 'Anulado' ? 'danger' : (v.estado === 'Pagado' ? 'success' : 'secondary')}">${escapeHtml(v.estado)}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="small text-muted">${escapeHtml(v.forma_pago ?? '-')} · ${escapeHtml(v.almacen?.nombre ?? '-')}</div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-secondary btn-print" data-id="${v.id}"><i class="bx bx-printer"></i></button>
                                    ${CAN_ANULAR && v.estado !== 'Anulado' ? `<button class="btn btn-sm btn-outline-danger btn-anular" data-id="${v.id}"><i class="bx bx-x"></i></button>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                    cardsContainer.appendChild(card);
                });
            }

            // Attach event listeners to buttons in table
            function attachRowEvents() {
                document.querySelectorAll('.toggle-detail').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset.id;
                        const row = document.querySelector(`.detalle-row[data-parent="${id}"]`);
                        const card = row.querySelector('.detalle-card');
                        const expanded = btn.getAttribute('aria-expanded') === 'true';

                        btn.setAttribute('aria-expanded', !expanded);
                        btn.querySelector('i').className = expanded ? 'bx bx-chevron-down' : 'bx bx-chevron-up';

                        if (expanded) {
                            // cerrar
                            card.style.maxHeight = card.scrollHeight + "px"; // fuerza altura actual
                            requestAnimationFrame(() => {
                                card.style.maxHeight = "0";
                            });

                            // al terminar transición, ocultar fila por completo
                            card.addEventListener('transitionend', () => {
                                row.style.display = 'none';
                            }, {
                                once: true
                            });

                            row.classList.remove('open');
                            row.classList.add('collapsed');
                        } else {
                            // abrir
                            row.style.display = ''; // asegura que el tr sea visible
                            card.style.maxHeight = card.scrollHeight + "px"; // altura real
                            row.classList.remove('collapsed');
                            row.classList.add('open');

                            card.addEventListener('transitionend', () => {
                                if (row.classList.contains('open')) {
                                    card.style.maxHeight = "none"; // altura automática final
                                }
                            }, {
                                once: true
                            });
                        }
                    });
                });


                // Anular
                document.querySelectorAll('.btn-anular').forEach(btn => {
                    btn.onclick = async () => {
                        const id = btn.dataset.id;
                        if (!confirm(`¿Seguro que deseas anular la venta ${id}?`)) return;

                        try {
                            const res = await fetch(ANULAR_URL(id), {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': CSRF,
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    _method: 'PUT'
                                })
                            });
                            const json = await res.json();
                            if (res.ok && json.success) {
                                // eliminar localmente la venta de la tabla
                                salesCache = salesCache.filter(s => s.id != id);
                                renderTable();
                                showToast(json.message || 'Venta anulada', 'success');
                            } else {
                                showToast(json.message || 'Error al anular', 'danger');
                            }
                        } catch (err) {
                            console.error(err);
                            showToast('Error al anular la venta', 'danger');
                        }
                    };
                });

                // Imprimir
                document.querySelectorAll('.btn-print').forEach(btn => {
                    btn.onclick = () => {
                        const id = btn.dataset.id;
                        window.open(PRINT_URL(id), '_blank');
                    };
                });
            }

            // Eventos para cards (mÇüvil)
            if (cardsContainer) {
                cardsContainer.addEventListener('click', async (e) => {
                    const printBtn = e.target.closest('.btn-print');
                    const anularBtn = e.target.closest('.btn-anular');
                    if (printBtn) {
                        window.open(PRINT_URL(printBtn.dataset.id), '_blank');
                        return;
                    }
                    if (anularBtn) {
                        const id = anularBtn.dataset.id;
                        if (!confirm(`¶¨Seguro que deseas anular la venta ${id}?`)) return;
                        try {
                            const res = await fetch(ANULAR_URL(id), {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': CSRF,
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    _method: 'PUT'
                                })
                            });
                            const json = await res.json();
                            if (res.ok && json.success) {
                                salesCache = salesCache.filter(s => s.id != id);
                                renderTable();
                                showToast(json.message || 'Venta anulada', 'success');
                            } else {
                                showToast(json.message || 'Error al anular', 'danger');
                            }
                        } catch (err) {
                            console.error(err);
                            showToast('Error al anular la venta', 'danger');
                        }
                    }
                });
            }

            // Render paginación
            function renderPagination() {
                pagination.innerHTML = '';
                if (lastPage <= 1) return;
                // prev
                const prevLi = document.createElement('li');
                prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
                prevLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage-1}">Anterior</a>`;
                pagination.appendChild(prevLi);

                // pages (simple range around current)
                const start = Math.max(1, currentPage - 2);
                const end = Math.min(lastPage, currentPage + 2);
                for (let i = start; i <= end; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                    li.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
                    pagination.appendChild(li);
                }

                // next
                const nextLi = document.createElement('li');
                nextLi.className = `page-item ${currentPage === lastPage ? 'disabled' : ''}`;
                nextLi.innerHTML = `<a class="page-link" href="#" data-page="${currentPage+1}">Siguiente</a>`;
                pagination.appendChild(nextLi);

                // clicks
                pagination.querySelectorAll('a.page-link').forEach(a => {
                    a.addEventListener('click', (ev) => {
                        ev.preventDefault();
                        const p = Number(a.dataset.page);
                        if (!isNaN(p) && p >= 1 && p <= lastPage) loadSales(p);
                    });
                });
            }

            // Helpers
            function numberFormat(v) {
                return (Number(v) || 0).toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function formatDateTime(value) {
                if (!value) return '-';
                try {
                    const d = new Date(value);
                    return d.toLocaleString();
                } catch {
                    return value;
                }
            }

            function escapeHtml(s) {
                if (s === null || s === undefined) return '';
                return String(s)
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#39;');
            }

            // small toast (uses bootstrap toast if present)
            function showToast(msg, type = 'primary') {
                // create temporary toast element
                const toast = document.createElement('div');
                toast.className = `toast align-items-center text-white bg-${type} border-0`;
                toast.role = 'alert';
                toast.ariaLive = 'assertive';
                toast.ariaAtomic = 'true';
                toast.style.position = 'fixed';
                toast.style.top = '1rem';
                toast.style.right = '1rem';
                toast.style.zIndex = 9999;
                toast.innerHTML = `<div class="d-flex"><div class="toast-body">${escapeHtml(msg)}</div>
                                   <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
                document.body.appendChild(toast);
                const b = new bootstrap.Toast(toast, {
                    delay: 2500
                });
                b.show();
                toast.addEventListener('hidden.bs.toast', () => toast.remove());
            }

            // Eventos filtros (filtrado en servidor cuando cambies fecha/status/paginación)
            const reloadDebounced = debounce(() => loadSales(1), 300);
            filterFrom.addEventListener('change', () => reloadDebounced());
            filterTo.addEventListener('change', () => reloadDebounced());
            filterStatus.addEventListener('change', () => reloadDebounced());

            // búsqueda en tiempo real (si quieres que sea local: filtrar salesCache; pero aquí manda al servidor)
            searchInput.addEventListener('input', debounce(() => loadSales(1), 300));

            // reload button
            btnReload.addEventListener('click', () => loadSales(currentPage));

            // inicial
            loadSales(1);
        };

        const handleVentasRegistradasLoad = () => {
            const root = document.getElementById('ventas-body');
            if (!root) return;
            if (root.dataset.ventasRegistradasInit === '1') return;
            root.dataset.ventasRegistradasInit = '1';
            setupVentasRegistradas();
        };

        document.addEventListener('turbo:load', handleVentasRegistradasLoad);
        document.addEventListener('DOMContentLoaded', handleVentasRegistradasLoad);
    </script>
    <style>
        
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
