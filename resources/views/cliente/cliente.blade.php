<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <!-- Scripts -->
        @vite([ 'resources/js/app.js'])
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="mb-0">Clientes Registrados</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrarCliente">
                                <i class="bx bx-plus-circle"></i> Registrar Cliente
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <input type="text" id="search" class="form-control" placeholder="Buscar cliente por cualquier campo..." autocomplete="off">
                            </div>
                        </div>

                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-striped align-middle" id="clientes-table">
                            <thead>
                                <tr>
                                    <th>#</th> <!-- No sortable -->
                                    <th data-column="nombre_completo">Nombre Completo</th>
                                    <th data-column="ci">CI</th>
                                    <th data-column="telefono">Teléfono</th>
                                    <th data-column="correo">Correo</th>
                                    <th>Empresa</th> <!-- No sortable -->
                                    <th class="text-center">Acciones</th> <!-- No sortable -->
                                </tr>
                            </thead>
                            <tbody id="clientes-body">
                                <tr>
                                    <td colspan="6" class="text-center">Cargando...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="clientes-cards" class="d-md-none"></div>
                    <nav>
                        <ul class="pagination justify-content-center mt-3" id="clientes-pagination"></ul>
                    </nav>
                </div>
                </div>
                <!-- Modal registrar-->
                <div class="modal fade" id="modalRegistrarCliente" tabindex="-1" aria-labelledby="modalRegistrarClienteLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalRegistrarClienteLabel">Registrar Cliente</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <form id="formRegistrarCliente">
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="paterno" class="form-label">Apellido Paterno</label>
                                            <input type="text" class="form-control" id="paterno" name="paterno" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="materno" class="form-label">Apellido Materno</label>
                                            <input type="text" class="form-control" id="materno" name="materno">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="correo" class="form-label">Correo</label>
                                            <input type="email" class="form-control" id="correo" name="correo">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="ci" class="form-label">CI</label>
                                            <input type="text" class="form-control" id="ci" name="ci">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Registrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--modal para editar-->
                <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <form id="formEditarCliente">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Cliente</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="editar-id">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label>Nombre</label>
                                            <input type="text" class="form-control" name="nombre" id="editar-nombre" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Apellido Paterno</label>
                                            <input type="text" class="form-control" name="paterno" id="editar-paterno" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Apellido Materno</label>
                                            <input type="text" class="form-control" name="materno" id="editar-materno">
                                        </div>
                                        <div class="col-md-4">
                                            <label>CI</label>
                                            <input type="text" class="form-control" name="ci" id="editar-ci">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Teléfono</label>
                                            <input type="text" class="form-control" name="telefono" id="editar-telefono">
                                        </div>
                                        <div class="col-md-4">
                                            <label>Correo</label>
                                            <input type="email" class="form-control" name="correo" id="editar-correo">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {

                        // --- Toast
                        function showToast(message, type = 'primary') {
                            const toastEl = document.querySelector('.bs-toast');
                            toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
                            toastEl.querySelector('.toast-body').textContent = message;
                            const toast = new bootstrap.Toast(toastEl);
                            toast.show();
                        }

                        // --- Tabla de clientes
                        const tableBody = document.getElementById('clientes-body');
                        const pagination = document.getElementById('clientes-pagination');
                        const searchInput = document.getElementById('search');
                        const tableHeaders = document.querySelectorAll('#clientes-table th[data-column]');

                        let currentPage = 1;
                        let sortColumn = '';
                        let sortDirection = 'asc';
                        let currentSearch = '';

                        function highlight(text, term) {
                            if (!term) return text;
                            return text.replace(new RegExp(`(${term})`, 'gi'), '<mark>$1</mark>');
                        }

                        function fetchClientes(page = 1, search = '', sortCol = '', sortDir = '') {
                            fetch(`{{ route('clientes.fetch') }}?page=${page}&search=${search}&sort=${sortCol}&direction=${sortDir}`)
                                .then(res => res.json())
                                .then(data => {
                                    tableBody.innerHTML = '';

                                    if (!data.data || data.data.length === 0) {
                                        tableBody.innerHTML = '<tr><td colspan="6" class="text-center">No hay clientes registrados</td></tr>';
                                        pagination.innerHTML = '';
                                        return;
                                    }

                                    data.data.forEach((cliente, index) => {
                                        tableBody.innerHTML += `
                                        <tr data-id="${cliente.id}">
                                            <td>${highlight(cliente.id)}</td>
                                            <td>${highlight(cliente.nombre + ' ' + cliente.paterno + ' ' + cliente.materno, search)}</td>
                                            <td>${highlight(cliente.ci, search)}</td>
                                            <td>${highlight(cliente.telefono, search)}</td>
                                            <td>${highlight(cliente.correo, search)}</td>
                                            <td>${highlight(cliente.empresa ? cliente.empresa.nombre : '-', search)}</td>
                                            <td>
                                                <button class="btn btn-sm btn-primary btn-editar" data-id="${cliente.id}">Editar</button>
                                                <button class="btn btn-sm btn-danger btn-eliminar" data-id="${cliente.id}">Eliminar</button>
                                            </td>
                                        </tr>
                                    `;
                                    });

                                    // Paginación
                                    const totalPages = data.last_page;
                                    let pagHtml = `<li class="page-item ${data.current_page===1?'disabled':''}">
                                <a href="#" class="page-link" data-page="${data.current_page-1}">Anterior</a>
                               </li>`;
                                    for (let i = 1; i <= totalPages; i++) {
                                        pagHtml += `<li class="page-item ${i===data.current_page?'active':''}">
                                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                                </li>`;
                                    }
                                    pagHtml += `<li class="page-item ${data.current_page===totalPages?'disabled':''}">
                                <a href="#" class="page-link" data-page="${data.current_page+1}">Siguiente</a>
                            </li>`;
                                    pagination.innerHTML = pagHtml;

                                    document.querySelectorAll('#clientes-pagination a').forEach(a => {
                                        a.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            const page = parseInt(this.dataset.page);
                                            if (page >= 1 && page <= totalPages && page !== currentPage) {
                                                currentPage = page;
                                                fetchClientes(currentPage, currentSearch, sortColumn, sortDirection);
                                            }
                                        });
                                    });
                                })
                                .catch(err => showToast('Error al cargar clientes', 'danger'));
                        }

                        // Inicial
                        fetchClientes();

                        // Buscar
                        searchInput.addEventListener('keyup', function() {
                            currentSearch = this.value;
                            currentPage = 1;
                            fetchClientes(currentPage, currentSearch, sortColumn, sortDirection);
                        });

                        // Ordenamiento
                        tableHeaders.forEach(th => {
                            th.addEventListener('click', function() {
                                const col = this.dataset.column;
                                if (!col) return;
                                if (sortColumn === col) sortDirection = (sortDirection === 'asc') ? 'desc' : 'asc';
                                else {
                                    sortColumn = col;
                                    sortDirection = 'asc';
                                }
                                fetchClientes(currentPage, currentSearch, sortColumn, sortDirection);
                            });
                        });

                        // --- Registro de cliente
                        const form = document.getElementById('formRegistrarCliente');
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(form);

                            fetch("{{ route('clientes.store') }}", {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: formData
                                })
                                .then(res => res.json())
                                .then(data => {
                                    showToast(data.message, data.status === 'success' ? 'success' : 'danger');
                                    if (data.status === 'success') {
                                        form.reset();
                                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalRegistrarCliente'));
                                        modal.hide();
                                        fetchClientes(1, currentSearch, sortColumn, sortDirection);
                                    }
                                })
                                .catch(err => showToast('Error al registrar cliente', 'danger'));
                        });

                        // editar cliente
                        // --- Abrir modal de edición
                        tableBody.addEventListener('click', function(e) {
                            if (e.target.classList.contains('btn-editar')) {
                                const id = e.target.dataset.id;
                                const row = tableBody.querySelector(`tr[data-id="${id}"]`);
                                if (!row) return;

                                // Llenar modal
                                const nombres = row.children[1].textContent.trim().split(' ');
                                document.getElementById('editar-id').value = id;
                                document.getElementById('editar-nombre').value = nombres[0];
                                document.getElementById('editar-paterno').value = nombres[1] || '';
                                document.getElementById('editar-materno').value = nombres.slice(2).join(' ') || '';
                                document.getElementById('editar-ci').value = row.children[2].textContent.trim();
                                document.getElementById('editar-telefono').value = row.children[3].textContent.trim();
                                document.getElementById('editar-correo').value = row.children[4].textContent.trim();

                                // Abrir modal
                                const modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
                                modal.show();
                            }
                        });

                        const formEditar = document.getElementById('formEditarCliente');

                        formEditar.addEventListener('submit', function(e) {
                            e.preventDefault();

                            const formData = new FormData(formEditar);
                            const id = formData.get('id');

                            // Usar la misma estructura que el registro
                            fetch(`{{ url('clientes') }}/${id}`, {
                                    method: 'POST', // Laravel necesita POST con _method=PUT
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: (() => {
                                        formData.append('_method', 'PUT'); // Indicar que es PUT
                                        return formData;
                                    })()
                                })
                                .then(res => res.json())
                                .then(data => {
                                    showToast(data.message, data.status === 'success' ? 'success' : 'danger');

                                    if (data.status === 'success') {
                                        formEditar.reset();
                                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarCliente'));
                                        modal.hide();
                                        fetchClientes(currentPage, currentSearch, sortColumn, sortDirection);
                                    }
                                })
                                .catch(err => showToast('Error al editar cliente', 'danger'));
                        });
                        // --- Eliminar cliente (solo cambia estado a "Borrado")
                        tableBody.addEventListener('click', function(e) {
                            if (e.target.classList.contains('btn-eliminar')) {
                                const id = e.target.dataset.id;

                                Swal.fire({
                                    title: '¿Deseas marcar este cliente como Borrado?',
                                    text: "Esta acción no se puede deshacer fácilmente",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Sí, marcar como Borrado',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const formData = new FormData();
                                        formData.append('_method', 'PUT'); // Laravel lo interpretará como PUT
                                        formData.append('estado', 'Borrado');

                                        fetch(`{{ url('clientes') }}/${id}/delete`, {
                                                method: 'POST',
                                                headers: {
                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                },
                                                body: formData
                                            })
                                            .then(res => res.json())
                                            .then(data => {
                                                showToast(data.message, data.status === 'success' ? 'success' : 'danger');
                                                if (data.status === 'success') {
                                                    fetchClientes(currentPage, currentSearch, sortColumn, sortDirection);
                                                }
                                            })
                                            .catch(err => showToast('Error al eliminar cliente', 'danger'));
                                    }
                                });
                            }
                        });

                    });
                </script>
            </div>
        </div>
    </main>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>
