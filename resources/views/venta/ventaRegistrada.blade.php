<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->


        <div class="container-fluid py-4">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex flex-column flex-md-row gap-2 align-items-md-center justify-content-between">
                            <div class="d-flex gap-2 align-items-center flex-wrap">
                                <h5 class="mb-0">Listado de Ventas</h5>
                                <small class="text-muted"> — Panel administrativo</small>
                            </div>

                            <div class="d-flex gap-2 align-items-center flex-wrap">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Busqueda</span>
                                    <input id="global-search" class="form-control" placeholder="Buscar por cliente, código, usuario..." />
                                </div>

                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">Desde</span>
                                    <input type="date" id="filter-from" class="form-control" />
                                    <span class="input-group-text">Hasta</span>
                                    <input type="date" id="filter-to" class="form-control" />
                                </div>

                                <div>
                                    <select id="filter-status" class="form-select form-select-sm">
                                        <option value="">Todos</option>
                                        <option value="Registrado">Registrado</option>
                                        <option value="Pagado">Pagado</option>
                                        <option value="Pendiente">Pendiente</option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" id="ventas-table">
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
                        </div>

                        <div class="card-footer d-flex justify-content-between align-items-center">
                            <div id="result-count" class="text-muted">—</div>
                            <nav>
                                <ul class="pagination pagination-sm mb-0" id="ventas-pagination"></ul>
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
        document.addEventListener('DOMContentLoaded', () => {
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

            // Inicializar fechas (hoy)
            const today = new Date().toISOString().slice(0, 10);
            filterFrom.value = today;
            filterTo.value = today;
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
                            <button class="btn btn-sm btn-outline-secondary btn-print" data-id="${v.id}" title="Imprimir"><i class="bx bx-printer"></i></button>
                            ${v.estado !== 'Anulado' ? `<button class="btn btn-sm btn-outline-danger btn-anular" data-id="${v.id}" title="Anular"><i class="bx bx-x"></i></button>` : ''}
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
        });
    </script>
</x-layout>