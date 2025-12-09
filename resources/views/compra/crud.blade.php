<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav class="navbar ..."></nav>
        @vite(['resources/js/app.js'])

        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Listado de Compras</h5>
                            <small class="text-muted">Panel administrativo</small>
                        </div>
                        <a href="/compras/create" class="btn btn-primary btn-sm">Registrar Compra</a>
                    </div>

                    <div class="card-body">

                        {{-- Filtros --}}
                        <div class="mb-3">
                            <div class="row g-2 align-items-end">
                                <div class="col-md-4">
                                    <label class="form-label mb-1 small">Buscar (Proveedor / Nro. Factura / Nota)</label>
                                    <input type="text" id="search" class="form-control form-control-sm" placeholder="Ej: Proveedor SRL o 100-25">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label mb-1 small">Desde</label>
                                    <input type="date" id="from" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label mb-1 small">Hasta</label>
                                    <input type="date" id="to" class="form-control form-control-sm">
                                </div>
                                <div class="col-md-2">
                                    <button id="btnBuscar" class="btn btn-dark w-100">
                                        <i class="bx bx-search"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Tabla --}}

                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-striped align-middle">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th style="width: 80px;">#</th>
                                        <th>Proveedor</th>
                                        <th>Nro. Factura</th>
                                        <th>Fecha</th>
                                        <th>Almacén</th>
                                        <th class="text-end">Total</th>
                                        <th>Estado</th>
                                        <th style="width: 160px;" class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyCompras">
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">Cargando...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="compras-cards" class="d-md-none"></div>

                        {{-- Paginación --}}
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="small text-muted" id="pagerInfo">Mostrando 0 de 0</div>
                            <nav>
                                <ul class="pagination justify-content-center mt-3 mb-0" id="pager">
                                    <!-- botones generados por JS -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Ver Detalle --}}
            <div class="modal fade" id="modalVerCompra" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title">Detalle de Compra</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div id="detalleCompra">
                                <div class="text-center text-muted">Cargando detalle...</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Toast genérico (reutiliza tu función showToast) --}}
            <div class="bs-toast toast toast-placement-ex m-2 fade bg-primary top-0 end-0 hide" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">Mensaje aquí</div>
            </div>
        </div>
    </main>

    <style>
        .section-form { padding: 20px; border-radius: 12px; }
        .section-title { font-weight: 600; font-size: 1rem; margin-bottom: 15px; color: #344767; border-left: 4px solid #5e72e4; padding-left: 8px; }
    </style>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const tbody = document.getElementById("tbodyCompras");
        const pager = document.getElementById("pager");
        const pagerInfo = document.getElementById("pagerInfo");
    
        const search = document.getElementById("search");
        const from = document.getElementById("from");
        const to = document.getElementById("to");
        const btnBuscar = document.getElementById("btnBuscar");
        const cards = document.getElementById("compras-cards");
        const detalleCompra = document.getElementById("detalleCompra");
        const modalVerCompra = document.getElementById("modalVerCompra");
        const modalDetalle = modalVerCompra ? new bootstrap.Modal(modalVerCompra) : null;
    
        let currentPage = 1;
        let lastPage = 1;
    
        async function fetchCompras(page = 1) {
            currentPage = page;
            tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-4">Cargando...</td></tr>`;
    
            const params = new URLSearchParams({
                search: (search?.value || '').trim(),
                from: (from?.value || '').trim(),
                to: (to?.value || '').trim(),
                page: page
            });
    
            try {
                const res = await fetch(`/api/compras?${params.toString()}`);
                const json = await res.json();
    
                const rows = Array.isArray(json.data) ? json.data : [];
                const meta = json.meta || {};
                lastPage = meta.last_page || 1;

                renderRows(rows, meta);
                renderCards(rows, meta);
                renderPager(meta);
            } catch (e) {
                console.error(e);
                tbody.innerHTML = `<tr><td colspan="8" class="text-center text-danger py-4">Error al cargar compras.</td></tr>`;
            }
        }
    
        function renderRows(rows, meta) {
            if (!rows.length) {
                tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted py-4">Sin resultados.</td></tr>`;
                pagerInfo.textContent = `Mostrando 0 de 0`;
                if (cards) {
                    cards.innerHTML = `<div class="text-center text-muted py-4">Sin compras registradas.</div>`;
                }
                return;
            }
    
            tbody.innerHTML = rows.map((r, i) => {
                const id = r.id;
                const proveedor = r.proveedor || '—';
                const nroFactura = r.numero_factura || '—';
                const fecha = r.fecha || '—';
                const almacen = r.almacen_nombre || '—';
                const total = (Number(r.total) || 0).toFixed(2);
                const estado = (r.estado == 1) ? `<span class="badge bg-success">Activo</span>` : `<span class="badge bg-secondary">Anulado</span>`;
    
                const num = ((meta.from || 1) + i);
    
                return `
                    <tr id="row-${id}">
                        <td>${num}</td>
                        <td>${proveedor}</td>
                        <td>${nroFactura}</td>
                        <td>${fecha}</td>
                        <td>${almacen}</td>
                        <td class="text-end">${total}</td>
                        <td>${estado}</td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" data-id="${id}" data-action="toggle">Ver detalles</button>
                                <a class="btn btn-sm btn-outline-secondary" href="/compras/${id}/edit">Editar</a>
                                <button class="btn btn-sm btn-outline-danger" data-id="${id}" data-action="eliminar">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    <tr id="detail-${id}" class="d-none">
                        <td colspan="8" class="bg-light">
                            <div class="p-3 small text-muted">Cargando detalle...</div>
                        </td>
                    </tr>
                `;
            }).join('');
    
            const totalReg = meta.total || rows.length;
            const fromReg = meta.from || ( (currentPage - 1) * rows.length + 1 );
            const toReg = meta.to || (fromReg + rows.length - 1);
            pagerInfo.textContent = `Mostrando ${fromReg} - ${toReg} de ${totalReg}`;
        }

        function renderCards(rows, meta) {
            if (!cards) return;
            cards.innerHTML = '';
            rows.forEach((r, i) => {
                const estadoBadge = (r.estado == 1) ? `<span class="badge bg-success">Activo</span>` : `<span class="badge bg-secondary">Anulado</span>`;
                const card = document.createElement('div');
                card.className = 'card mb-2';
                card.innerHTML = `
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold">${r.proveedor || 'ƒ?"'}</div>
                                <div class="small text-muted">Factura: ${r.numero_factura || 'ƒ?"'}</div>
                                <div class="small text-muted">${r.fecha || ''}</div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">Bs/ ${(Number(r.total) || 0).toFixed(2)}</div>
                                ${estadoBadge}
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <div class="small text-muted">${r.almacen_nombre || 'ƒ?"'}</div>
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary" data-id="${r.id}" data-action="detalle">Detalles</button>
                                <a class="btn btn-sm btn-outline-secondary" href="/compras/${r.id}/edit">Editar</a>
                                <button class="btn btn-sm btn-outline-danger" data-id="${r.id}" data-action="eliminar">Eliminar</button>
                            </div>
                        </div>
                    </div>
                `;
                cards.appendChild(card);
            });
        }
    
        function renderPager(meta) {
            const cp = meta.current_page || 1;
            const lp = meta.last_page || 1;
    
            function pageBtn(p, label = p, active = false, disabled = false) {
                return `
                    <li class="page-item ${active ? 'active' : ''} ${disabled ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${p}">${label}</a>
                    </li>
                `;
            }
    
            let html = '';
            html += pageBtn(cp - 1, '&laquo;', false, cp <= 1);
    
            const start = Math.max(1, cp - 2);
            const end = Math.min(lp, cp + 2);
            for (let p = start; p <= end; p++) {
                html += pageBtn(p, p, p === cp);
            }
    
            html += pageBtn(cp + 1, '&raquo;', false, cp >= lp);
            pager.innerHTML = html;
        }
    
        pager.addEventListener('click', (e) => {
            if (e.target.matches('.page-link')) {
                e.preventDefault();
                const p = parseInt(e.target.getAttribute('data-page'), 10);
                if (!isNaN(p) && p >= 1 && p <= lastPage) fetchCompras(p);
            }
        });

        if (cards) {
            cards.addEventListener('click', (e) => {
                const btn = e.target.closest('button');
                if (!btn) return;
                const id = btn.getAttribute('data-id');
                const action = btn.getAttribute('data-action');

                if (action === 'detalle') {
                    verDetalleEnModal(id);
                }
                if (action === 'eliminar') {
                    eliminarCompra(id);
                }
            });
        }
    
        // Toggle detalle + eliminar
        tbody.addEventListener('click', async (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;
    
            const id = btn.getAttribute('data-id');
            const action = btn.getAttribute('data-action');
    
            if (action === 'toggle') {
                const trDetail = document.getElementById(`detail-${id}`);
                if (!trDetail) return;
    
                // si está oculto, mostrar y si no está cargado, traer datos
                const isHidden = trDetail.classList.contains('d-none');
                if (isHidden) {
                    if (!trDetail.dataset.loaded) {
                        trDetail.querySelector('td').innerHTML = `<div class="p-3 small text-muted">Cargando detalle...</div>`;
                        try {
                            const resp = await fetch(`/api/compras/${id}/detalles`);
                            const data = await resp.json();
                            trDetail.querySelector('td').innerHTML = renderDetalleTable(data.items || []);
                            trDetail.dataset.loaded = '1';
                        } catch (err) {
                            trDetail.querySelector('td').innerHTML = `<div class="p-3 text-danger">Error al cargar el detalle.</div>`;
                        }
                    }
                    trDetail.classList.remove('d-none');
                    btn.textContent = 'Ocultar detalles';
                } else {
                    trDetail.classList.add('d-none');
                    btn.textContent = 'Ver detalles';
                }
            }
    
            if (action === 'eliminar') {
                eliminarCompra(id);
            }
);
                    const data = await resp.json().catch(() => ({}));
                    if (resp.ok) {
                        showToast(data.message || 'Compra eliminada', 'success');
                        fetchCompras(currentPage);
                    } else {
                        showToast(data.message || 'No se pudo eliminar', 'danger');
                    }
                } catch (err) {
                    showToast('Error al eliminar la compra', 'danger');
                }
            }
        });
    
        function renderDetalleTable(items) {
            if (!items.length) {
                return `<div class="p-3 small text-muted">Sin ítems en esta compra.</div>`;
            }
            const rows = items.map((it, idx) => `
                <tr>
                    <td>${idx+1}</td>
                    <td>${it.codigo || '—'}</td>
                    <td>${it.producto || '—'}</td>
                    <td>${it.marca || '—'}</td>
                    <td>${it.modelo || '—'}</td>
                    <td>${it.lote || '—'}</td>
                    <td>${it.fecha_vencimiento || '—'}</td>
                    <td class="text-end">${Number(it.cantidad || 0).toFixed(2)}</td>
                    <td class="text-end">${Number(it.costo_unitario || 0).toFixed(2)}</td>
                    <td class="text-end">${Number(it.costo_total || 0).toFixed(2)}</td>
                </tr>
            `).join('');
    
            return `
                <div class="p-2">
                    <div class="fw-semibold mb-2">Detalle de ítems</div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Lote</th>
                                    <th>Vencimiento</th>
                                    <th class="text-end">Cantidad</th>
                                    <th class="text-end">Costo U.</th>
                                    <th class="text-end">Costo T.</th>
                                </tr>
                            </thead>
                            <tbody>${rows}</tbody>
                        </table>
                    </div>
                </div>
            `;
            }
    
        async function eliminarCompra(id) {
            if (!confirm('Eliminar esta compra? Esta accion es irreversible.')) return;
            try {
                const resp = await fetch(`/compras/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name=\"_token\"]').value
                    }
                });
                const data = await resp.json().catch(() => ({}));
                if (resp.ok) {
                    showToast(data.message || 'Compra eliminada', 'success');
                    fetchCompras(currentPage);
                } else {
                    showToast(data.message || 'No se pudo eliminar', 'danger');
                }
            } catch (err) {
                showToast('Error al eliminar la compra', 'danger');
            }
        }

        async function verDetalleEnModal(id) {
            if (!modalDetalle || !detalleCompra) return;
            detalleCompra.innerHTML = `<div class="text-center text-muted">Cargando detalle...</div>`;
            try {
                const resp = await fetch(`/api/compras/${id}/detalles`);
                const data = await resp.json();
                detalleCompra.innerHTML = renderDetalleTable(data.items || []);
                modalDetalle.show();
            } catch (err) {
                detalleCompra.innerHTML = `<div class="text-danger">Error al cargar el detalle.</div>`;
            }
        }

        // Toast helper (reutiliza tu estilo)
        window.showToast = function(message, type = "primary") {
            const toastEl = document.querySelector(".bs-toast");
            if (!toastEl) return alert(message);
            toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
            toastEl.querySelector(".toast-body").textContent = message;
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    
        // carga inicial
        fetchCompras(1);
    });
</script>
    
</x-layout>
