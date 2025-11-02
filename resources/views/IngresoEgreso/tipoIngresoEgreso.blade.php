<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <!-- Scripts -->
        @vite([ 'resources/js/app.js'])
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between">
                        <h6 class="mb-2 mb-md-0">Tipos de Ingreso / Egreso</h6>
                        <div class="d-flex gap-2 w-100 w-md-auto">
                            <input id="globalSearch" class="form-control form-control-sm" placeholder="Buscar..." aria-label="Buscar">
                            <button id="btnNuevo" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevo">
                                <i class="fas fa-plus"></i> Nuevo
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Contenedor tabla para desktop -->
                        <div id="tableContainer" class="table-responsive d-none d-sm-block">
                            <table class="table table-striped table-hover" id="mainTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <!-- filas via JS -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Contenedor tarjetas para móvil -->
                        <div id="cardContainer" class="d-block d-sm-none">
                            <!-- cards via JS -->
                        </div>

                        <!-- Paginación y resumen -->
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between mt-3">
                            <div id="tableInfo" class="text-muted small">Mostrando 0 a 0 de 0 filas</div>

                            <nav aria-label="Paginación">
                                <ul class="pagination pagination-sm mb-0" id="pagination">
                                    <!-- items via JS -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Nuevo -->
        <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Tipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="formNuevo">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input name="nombre" id="nuevo_nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" id="nuevo_descripcion" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipo</label>
                                <select name="tipo" id="nuevo_tipo" class="form-select" required>
                                    <option value="ingreso">Ingreso</option>
                                    <option value="egreso">Egreso</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Estado</label>
                                <select name="estado" id="nuevo_estado" class="form-select">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar (abre con datos) -->
        <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Tipo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <form id="formEditar">
                        <input type="hidden" id="editar_id" name="id">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input name="nombre" id="editar_nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" id="editar_descripcion" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipo</label>
                                <select name="tipo" id="editar_tipo" class="form-select" required>
                                    <option value="ingreso">Ingreso</option>
                                    <option value="egreso">Egreso</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Estado</label>
                                <select name="estado" id="editar_estado" class="form-select">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // -------------------------------
            // Toast
            // -------------------------------
            function showToast(message, type = "primary") {
                const toastEl = document.querySelector(".bs-toast");
                if (!toastEl) return;
                toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide show`;
                toastEl.querySelector(".toast-body").textContent = message;
                new bootstrap.Toast(toastEl).show();
            }

            // -------------------------------
            // Config y elementos
            // -------------------------------
            const perPage = 5;
            let currentPage = 1;
            let totalRows = 0;
            let lastSearch = '';

            const tableBody = document.getElementById('tableBody');
            const cardContainer = document.getElementById('cardContainer');
            const tableInfo = document.getElementById('tableInfo');
            const pagination = document.getElementById('pagination');
            const globalSearch = document.getElementById('globalSearch');

            const modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevo'));
            const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));

            const formNuevo = document.getElementById('formNuevo');
            const modalNuevoEl = document.getElementById('modalNuevo');
            const formEditar = document.getElementById('formEditar');
            const modalEditarEl = document.getElementById('modalEditar');

            // -------------------------------
            // Helper: debounce
            // -------------------------------
            function debounce(fn, ms) {
                let t;
                return function(...args) {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, args), ms);
                }
            }

            // -------------------------------
            // Escape HTML
            // -------------------------------
            function escapeHtml(text) {
                return String(text || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            // -------------------------------
            // Fetch y render
            // -------------------------------
            async function fetchRows(page = 1, search = '') {
                currentPage = page;
                lastSearch = search;
                try {
                    const res = await fetch(`/tipo_ingreso_egreso/fetch?page=${page}&per_page=${perPage}&search=${encodeURIComponent(search)}`);
                    if (!res.ok) throw new Error('Server returned ' + res.status);
                    const json = await res.json();
                    renderRows(json.data || []);
                    totalRows = json.total ?? 0;
                    renderPagination(json.current_page ?? page, json.per_page ?? perPage, totalRows);
                } catch (err) {
                    console.error('Error fetchRows:', err);
                    showToast('No se pudo cargar la información', 'danger');
                }
            }

            function renderRows(rows) {
                tableBody.innerHTML = '';
                cardContainer.innerHTML = '';

                rows.forEach(r => {
                    // Tabla
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
        <td>${r.id}</td>
        <td>${escapeHtml(r.nombre)}</td>
        <td>${escapeHtml(r.descripcion ?? '')}</td>
        <td class="text-capitalize">${escapeHtml(r.tipo)}</td>
        <td>${r.estado == 1 ? 'Activo' : 'Inactivo'}</td>
        <td class="text-end">
            <div class="btn-group" role="group">
                <button class="btn btn-sm btn-outline-primary btn-edit" data-id="${r.id}">
                    <i class="menu-icon icon-base bx bx-edit"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${r.id}">
                    <i class="menu-icon icon-base bx bx-trash"></i>
                </button>
            </div>
        </td>`;
                    tableBody.appendChild(tr);

                    // Cards (responsive)
                    const card = document.createElement('div');
                    card.className = 'card mb-2 d-md-none';
                    card.innerHTML = `
        <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="fw-bold">${escapeHtml(r.nombre)}</div>
                    <div class="text-muted small">${escapeHtml(r.tipo)} • ${r.estado == 1 ? 'Activo' : 'Inactivo'}</div>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-primary btn-edit" data-id="${r.id}">
                        <i class="menu-icon icon-base bx bx-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${r.id}">
                        <i class="menu-icon icon-base bx bx-trash"></i>
                    </button>
                </div>
            </div>
            <p class="mt-2 mb-0 small text-muted">${escapeHtml(r.descripcion ?? '')}</p>
        </div>`;
                    cardContainer.appendChild(card);
                });


                const start = (currentPage - 1) * perPage + 1;
                const end = Math.min(currentPage * perPage, totalRows);
                tableInfo.textContent = totalRows === 0 ? 'Mostrando 0 a 0 de 0 filas' : `Mostrando ${start} a ${end} de ${totalRows} filas`;

                // Delegación
                document.querySelectorAll('.btn-edit').forEach(b => b.addEventListener('click', onEditClick));
                document.querySelectorAll('.btn-delete').forEach(b => b.addEventListener('click', onDeleteClick));
            }

            function renderPagination(current, per, total) {
                pagination.innerHTML = '';
                const totalPages = Math.max(1, Math.ceil(total / per));

                function addPage(n, label = null, active = false, disabled = false) {
                    const li = document.createElement('li');
                    li.className = 'page-item ' + (active ? 'active' : '') + (disabled ? ' disabled' : '');
                    li.innerHTML = `<a class="page-link" href="#">${label ?? n}</a>`;
                    li.addEventListener('click', ev => {
                        ev.preventDefault();
                        if (disabled || currentPage === n) return;
                        fetchRows(n, lastSearch);
                    });
                    pagination.appendChild(li);
                }

                addPage(1, '«', false, current === 1);
                const start = Math.max(1, current - 2);
                const end = Math.min(totalPages, current + 2);
                for (let i = start; i <= end; i++) addPage(i, null, i === current);
                addPage(totalPages, '»', false, current === totalPages);
            }

            // -------------------------------
            // Handlers
            // -------------------------------
            async function onEditClick(e) {
                const id = e.currentTarget.dataset.id;
                try {
                    const res = await fetch(`/tipo_ingreso_egreso/${id}`);
                    const json = await res.json();
                    const row = json.data;
                    document.getElementById('editar_id').value = row.id;
                    document.getElementById('editar_nombre').value = row.nombre;
                    document.getElementById('editar_descripcion').value = row.descripcion ?? '';
                    document.getElementById('editar_tipo').value = row.tipo;
                    document.getElementById('editar_estado').value = row.estado;
                    modalEditar.show();
                } catch (err) {
                    console.error(err);
                    showToast('No se pudo cargar el registro', 'danger');
                }
            }

            function onDeleteClick(e) {
                const id = e.currentTarget.dataset.id;
                showToast('Eliminar aún no implementado', 'warning');
            }

            // -------------------------------
            // Crear
            // -------------------------------
            formNuevo.addEventListener('submit', async e => {
                e.preventDefault();
                const fd = new FormData(formNuevo);

                try {
                    const res = await fetch('/tipo_ingreso_egreso', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: fd
                    });
                    const json = await res.json();
                    if (res.ok && json.success) {
                        const modalInstance = bootstrap.Modal.getInstance(modalNuevoEl);
                        modalInstance.hide();
                        formNuevo.reset();

                        showToast('Creado correctamente', 'success');
                        fetchRows(1, lastSearch);
                    } else {
                        const msg = json.message || (json.errors ? Object.values(json.errors).flat().join(', ') : 'No se pudo crear');
                        showToast(msg, 'danger');
                    }
                } catch (err) {
                    console.error(err);
                    showToast('No se pudo conectar al servidor', 'danger');
                }
            });

            // -------------------------------
            // Editar
            // -------------------------------
            formEditar.addEventListener('submit', async e => {
                e.preventDefault();
                const id = document.getElementById('editar_id').value;

                const fd = new FormData(formEditar);

                try {
                    const res = await fetch(`/tipo_ingreso_egreso/${id}`, {
                        method: 'POST', // usar POST
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-HTTP-Method-Override': 'PUT' // override
                        },
                        body: fd
                    });

                    const json = await res.json();

                    if (res.ok && json.success) {
                        const modalInstance = bootstrap.Modal.getInstance(modalEditarEl);
                        modalInstance.hide();
                        formEditar.reset();

                        showToast('Actualizado correctamente', 'success');
                        fetchRows(currentPage, lastSearch);
                    } else {
                        const msg = json.message || (json.errors ? Object.values(json.errors).flat().join(', ') : 'No se pudo actualizar');
                        showToast(msg, 'danger');
                    }
                } catch (err) {
                    console.error(err);
                    showToast('No se pudo conectar al servidor', 'danger');
                }
            });

            // -------------------------------
            // Buscador
            // -------------------------------
            globalSearch.addEventListener('input', debounce(e => fetchRows(1, e.target.value.trim()), 400));

            // -------------------------------
            // Inicial
            // -------------------------------
            fetchRows(1);

        });
    </script>




</x-layout>