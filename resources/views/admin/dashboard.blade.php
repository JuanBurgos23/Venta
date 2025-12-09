<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @vite(['resources/js/app.js'])

        <div class="container-fluid py-4">
            <div class="card my-4">
                <div class="card-header border-bottom-0 pb-0">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <h5 class="mb-0">Panel de Administración</h5>
                        <span class="text-muted small">Multiempresa & Suscripciones</span>
                    </div>
                    <ul class="nav nav-pills mt-3" id="adminTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="empresas-tab" data-bs-toggle="pill" data-bs-target="#empresas-pane" type="button" role="tab">Empresas</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="suscripciones-tab" data-bs-toggle="pill" data-bs-target="#suscripciones-pane" type="button" role="tab">Suscripciones</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reportes-tab" data-bs-toggle="pill" data-bs-target="#reportes-pane" type="button" role="tab">Reportes</button>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <!-- Empresas -->
                        <div class="tab-pane fade show active" id="empresas-pane" role="tabpanel">
                            <div class="row g-2 mb-3">
                                <div class="col-md-4">
                                    <input type="text" id="empresas-search" class="form-control" placeholder="Buscar empresa por nombre, NIT, correo...">
                                </div>
                                <div class="col-md-8 text-end">
                                    <button class="btn btn-primary btn-sm" id="btn-crear-empresa" data-bs-toggle="modal" data-bs-target="#modalEmpresa">
                                        <i class="bx bx-plus-circle"></i> Nueva Empresa
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive d-none d-md-block">
                                <table class="table table-striped align-middle" id="empresas-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>NIT</th>
                                            <th>Contacto</th>
                                            <th>Suscripción</th>
                                            <th>Vigencia</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <div id="empresas-cards" class="d-md-none"></div>
                            <nav>
                                <ul class="pagination justify-content-center mt-3" id="empresas-pagination"></ul>
                            </nav>
                        </div>

                        <!-- Suscripciones -->
                        <div class="tab-pane fade" id="suscripciones-pane" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-lg-4">
                                    <div class="card border h-100">
                                        <div class="card-header">
                                            <h6 class="mb-0">Crear Suscripción</h6>
                                        </div>
                                        <div class="card-body">
                                            <form id="form-suscripcion">
                                                <div class="mb-3">
                                                    <label class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="suscripcion-nombre" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="suscripcion-descripcion" rows="3"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary w-100">Guardar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="card border h-100">
                                        <div class="card-header d-flex align-items-center justify-content-between">
                                            <h6 class="mb-0">Lista de Suscripciones</h6>
                                            <input type="text" id="suscripciones-search" class="form-control form-control-sm w-auto" placeholder="Buscar...">
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-striped align-middle" id="suscripciones-table">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Nombre</th>
                                                            <th>Descripción</th>
                                                            <th class="text-end">Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                            <nav>
                                                <ul class="pagination justify-content-center mt-3" id="suscripciones-pagination"></ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reportes -->
                        <div class="tab-pane fade" id="reportes-pane" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h6>Resumen de Empresas</h6>
                                            <p class="text-muted small mb-1">Empresas registradas</p>
                                            <div id="stat-empresas" class="fs-4 fw-bold">-</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h6>Suscripciones Activas</h6>
                                            <p class="text-muted small mb-1">Empresas con suscripción vigente</p>
                                            <div id="stat-activas" class="fs-4 fw-bold">-</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h6>Por Vencer</h6>
                                            <p class="text-muted small mb-1">Suscripciones próximas a vencer</p>
                                            <div id="stat-vencer" class="fs-4 fw-bold">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card border mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Actividad reciente</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group" id="reportes-actividad">
                                        <li class="list-group-item text-muted">Sin datos aún.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Empresa -->
    <div class="modal fade" id="modalEmpresa" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="form-empresa">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEmpresaLabel">Editar Empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="empresa-id">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="empresa-nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIT</label>
                                <input type="text" class="form-control" id="empresa-nit">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="empresa-telefono">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Correo</label>
                                <input type="email" class="form-control" id="empresa-correo">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="empresa-direccion">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Asignar Suscripción -->
    <div class="modal fade" id="modalAsignar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="form-asignar">
                    <div class="modal-header">
                        <h5 class="modal-title">Asignar Suscripción</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="asignar-empresa-id">
                        <div class="mb-3">
                            <label class="form-label">Suscripción</label>
                            <select class="form-select" id="asignar-suscripcion" required></select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha inicio</label>
                            <input type="date" class="form-control" id="asignar-inicio" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Fecha fin</label>
                            <input type="date" class="form-control" id="asignar-fin">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const empresasTableBody = document.querySelector('#empresas-table tbody');
            const empresasPagination = document.getElementById('empresas-pagination');
            const empresasCards = document.getElementById('empresas-cards');
            const empresasSearch = document.getElementById('empresas-search');
            const suscripcionesTableBody = document.querySelector('#suscripciones-table tbody');
            const suscripcionesPagination = document.getElementById('suscripciones-pagination');
            const suscripcionesSearch = document.getElementById('suscripciones-search');
            const asignarSelect = document.getElementById('asignar-suscripcion');
            let empresasPage = 1;
            let suscripcionesPage = 1;

            function showToast(message, type = 'primary') {
                const toastEl = document.querySelector('.bs-toast');
                if (!toastEl) return;
                toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide show`;
                toastEl.querySelector('.toast-body').textContent = message;
                new bootstrap.Toast(toastEl).show();
            }

            // --- Empresas ---
            async function fetchEmpresas(page = 1) {
                const params = new URLSearchParams({
                    page,
                    search: empresasSearch.value || ''
                });
                const res = await fetch(`/admin/empresas/fetch?${params.toString()}`);
                const data = await res.json();
                renderEmpresas(data);
            }

            function renderEmpresas(data) {
                const rows = data.data || [];
                empresasTableBody.innerHTML = '';
                empresasCards.innerHTML = '';
                if (!rows.length) {
                    empresasTableBody.innerHTML = `<tr><td colspan="7" class="text-center text-muted py-3">Sin empresas</td></tr>`;
                    empresasCards.innerHTML = `<div class="card card-body text-center text-muted">Sin empresas</div>`;
                } else {
                    rows.forEach(e => {
                        const sus = e.suscripcion_actual ?? '-';
                        const vigencia = (e.fecha_inicio && e.fecha_fin) ? `${e.fecha_inicio} a ${e.fecha_fin}` : '-';
                        empresasTableBody.insertAdjacentHTML('beforeend', `
                            <tr data-id="${e.id}">
                                <td>${e.id}</td>
                                <td>${e.nombre ?? '-'}</td>
                                <td>${e.nit ?? '-'}</td>
                                <td>${e.telefono ?? '-'}<br><small class="text-muted">${e.correo ?? '-'}</small></td>
                                <td>${sus}</td>
                                <td>${vigencia}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary btn-edit-empresa" data-id="${e.id}"><i class="bx bx-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-success btn-asignar" data-id="${e.id}"><i class="bx bx-link"></i></button>
                                </td>
                            </tr>
                        `);

                        empresasCards.insertAdjacentHTML('beforeend', `
                            <div class="card mb-2" data-id="${e.id}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">${e.nombre ?? '-'}</h6>
                                            <div class="text-muted small">NIT: ${e.nit ?? '-'} · ${e.correo ?? '-'}</div>
                                            <div class="small">Suscripción: ${sus}</div>
                                            <div class="small text-muted">Vigencia: ${vigencia}</div>
                                        </div>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary btn-edit-empresa" data-id="${e.id}"><i class="bx bx-edit"></i></button>
                                            <button class="btn btn-sm btn-outline-success btn-asignar" data-id="${e.id}"><i class="bx bx-link"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                    });
                }
                renderPagination(empresasPagination, data, p => {
                    empresasPage = p;
                    fetchEmpresas(p);
                });
            }

            empresasPagination.addEventListener('click', (e) => {
                const page = e.target.dataset.page;
                if (page) {
                    e.preventDefault();
                    fetchEmpresas(Number(page));
                }
            });
            empresasSearch.addEventListener('input', () => fetchEmpresas(1));

            // Edit empresa (carga básica)
            document.addEventListener('click', (e) => {
                if (e.target.closest('.btn-edit-empresa')) {
                    const id = e.target.closest('.btn-edit-empresa').dataset.id;
                    fetch(`/empresa/${id}/edit`).then(r => r.json()).then(data => {
                        document.getElementById('empresa-id').value = data.id;
                        document.getElementById('empresa-nombre').value = data.nombre || '';
                        document.getElementById('empresa-nit').value = data.nit || '';
                        document.getElementById('empresa-telefono').value = data.telefono || '';
                        document.getElementById('empresa-correo').value = data.correo || '';
                        document.getElementById('empresa-direccion').value = data.direccion || '';
                        new bootstrap.Modal(document.getElementById('modalEmpresa')).show();
                    }).catch(() => showToast('No se pudo cargar la empresa', 'danger'));
                }

                if (e.target.closest('.btn-asignar')) {
                    const id = e.target.closest('.btn-asignar').dataset.id;
                    document.getElementById('asignar-empresa-id').value = id;
                    new bootstrap.Modal(document.getElementById('modalAsignar')).show();
                }
            });

            document.getElementById('form-empresa').addEventListener('submit', (ev) => {
                ev.preventDefault();
                const id = document.getElementById('empresa-id').value;
                const payload = {
                    nombre: document.getElementById('empresa-nombre').value,
                    nit: document.getElementById('empresa-nit').value,
                    telefono: document.getElementById('empresa-telefono').value,
                    correo: document.getElementById('empresa-correo').value,
                    direccion: document.getElementById('empresa-direccion').value,
                    _method: 'PUT'
                };
                fetch(`/empresa/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                }).then(r => r.json()).then(data => {
                    showToast(data.message || 'Guardado', data.status === 'success' ? 'success' : 'danger');
                    fetchEmpresas(empresasPage);
                    bootstrap.Modal.getInstance(document.getElementById('modalEmpresa'))?.hide();
                }).catch(() => showToast('Error al guardar empresa', 'danger'));
            });

            document.getElementById('form-asignar').addEventListener('submit', (ev) => {
                ev.preventDefault();
                const payload = {
                    empresa_id: document.getElementById('asignar-empresa-id').value,
                    suscripcion_id: asignarSelect.value,
                    fecha_inicio: document.getElementById('asignar-inicio').value,
                    fecha_fin: document.getElementById('asignar-fin').value,
                };
                fetch(`/empresa-suscripciones`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                }).then(r => r.json()).then(data => {
                    showToast(data.message || 'Asignado', data.status === 'success' ? 'success' : 'danger');
                    fetchEmpresas(empresasPage);
                    bootstrap.Modal.getInstance(document.getElementById('modalAsignar'))?.hide();
                }).catch(() => showToast('Error al asignar suscripción', 'danger'));
            });

            // --- Suscripciones ---
            async function fetchSuscripciones(page = 1) {
                const params = new URLSearchParams({
                    page,
                    search: suscripcionesSearch.value || ''
                });
                const res = await fetch(`/suscripciones/fetch?${params.toString()}`);
                const data = await res.json();
                renderSuscripciones(data);
                fillSuscripcionesSelect(data.data || []);
            }

            function renderSuscripciones(data) {
                const rows = data.data || [];
                suscripcionesTableBody.innerHTML = '';
                if (!rows.length) {
                    suscripcionesTableBody.innerHTML = `<tr><td colspan="4" class="text-center text-muted py-3">Sin suscripciones</td></tr>`;
                } else {
                    rows.forEach(s => {
                        suscripcionesTableBody.insertAdjacentHTML('beforeend', `
                            <tr data-id="${s.id}">
                                <td>${s.id}</td>
                                <td>${s.nombre}</td>
                                <td>${s.descripcion ?? '-'}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-primary btn-edit-sus" data-id="${s.id}"><i class="bx bx-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger btn-del-sus" data-id="${s.id}"><i class="bx bx-trash"></i></button>
                                </td>
                            </tr>
                        `);
                    });
                }
                renderPagination(suscripcionesPagination, data, p => {
                    suscripcionesPage = p;
                    fetchSuscripciones(p);
                });
            }

            function fillSuscripcionesSelect(list) {
                asignarSelect.innerHTML = `<option value="">Seleccione...</option>`;
                list.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.nombre;
                    asignarSelect.appendChild(opt);
                });
            }

            suscripcionesPagination.addEventListener('click', (e) => {
                const page = e.target.dataset.page;
                if (page) {
                    e.preventDefault();
                    fetchSuscripciones(Number(page));
                }
            });
            suscripcionesSearch.addEventListener('input', () => fetchSuscripciones(1));

            document.getElementById('form-suscripcion').addEventListener('submit', (ev) => {
                ev.preventDefault();
                const payload = {
                    nombre: document.getElementById('suscripcion-nombre').value,
                    descripcion: document.getElementById('suscripcion-descripcion').value,
                };
                fetch(`/suscripciones`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(payload)
                }).then(r => r.json()).then(data => {
                    showToast(data.message || 'Guardado', data.status === 'success' ? 'success' : 'danger');
                    if (data.status === 'success') {
                        ev.target.reset();
                        fetchSuscripciones(suscripcionesPage);
                    }
                }).catch(() => showToast('Error al guardar suscripción', 'danger'));
            });

            // Helpers
            function renderPagination(container, data, onClick) {
                const current = data.current_page || 1;
                const last = data.last_page || 1;
                container.innerHTML = '';
                if (last <= 1) return;
                const createLi = (p, label, disabled = false, active = false) => `
                    <li class="page-item ${disabled ? 'disabled' : ''} ${active ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${p}">${label}</a>
                    </li>`;
                container.insertAdjacentHTML('beforeend', createLi(current - 1, '&laquo;', current === 1));
                for (let i = Math.max(1, current - 2); i <= Math.min(last, current + 2); i++) {
                    container.insertAdjacentHTML('beforeend', createLi(i, i, false, i === current));
                }
        container.insertAdjacentHTML('beforeend', createLi(current + 1, '&raquo;', current === last));
                container.querySelectorAll('.page-link').forEach(a => {
                    a.addEventListener('click', ev => {
                        ev.preventDefault();
                        const p = Number(a.dataset.page);
                        if (p >= 1 && p <= last) onClick(p);
                    });
                });
            }

            // Inicial
            fetchEmpresas(empresasPage);
            fetchSuscripciones(suscripcionesPage);
        });
    </script>
</x-layout>
