<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                        <h5 class="mb-0">Empresas Registradas</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalRegistrarEmpresa">
                                <i class="bx bx-plus-circle"></i> Registrar Empresa
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <input type="text" id="search" class="form-control" placeholder="Buscar empresa por cualquier campo..." autocomplete="off">
                            </div>
                        </div>

                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-striped align-middle" id="empresas-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Logotipo</th>

                                    <th data-column="nombre">Nombre</th>
                                    <th data-column="telefono">Teléfono</th>
                                    <th data-column="correo">Correo</th>
                                    <th data-column="direccion">Dirección</th>
                                    <th data-column="nit">NIT</th>
                                    <th>QR</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="empresas-body">
                                <tr>
                                    <td colspan="9" class="text-center">Cargando...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="empresas-cards" class="d-md-none"></div>

                    <nav>
                        <ul class="pagination justify-content-center mt-3" id="empresas-pagination"></ul>
                    </nav>
                    </div>
                </div>

                <!-- Modal registrar empresa -->
                <div class="modal fade" id="modalRegistrarEmpresa" tabindex="-1" aria-labelledby="modalRegistrarEmpresaLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="modalRegistrarEmpresaLabel">Registrar Empresa</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <form id="formRegistrarEmpresa" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" id="telefono" name="telefono">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="correo" class="form-label">Correo</label>
                                            <input type="email" class="form-control" id="correo" name="correo">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" id="direccion" name="direccion">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nit" class="form-label">NIT</label>
                                            <input type="text" class="form-control" id="nit" name="nit">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="logo" class="form-label">Logo (opcional)</label>
                                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                                            <div id="previewLogo" style="display:none;">
                                                <img id="previewLogoImg" class="img-thumbnail" style="max-height:100px;cursor:pointer">
                                                <button type="button" id="btnQuitarLogo" class="btn btn-sm btn-danger mt-1">Quitar</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="qr" class="form-label">QR (opcional)</label>
                                            <input type="file" class="form-control" id="qr" name="qr" accept="image/*">
                                            <div id="previewQr" style="display:none;">
                                                <img id="previewQrImg" class="img-thumbnail" style="max-height:100px;cursor:pointer">
                                                <button type="button" id="btnQuitarQr" class="btn btn-sm btn-danger mt-1">Quitar</button>
                                            </div>
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

                <!-- Modal editar empresa -->
                <div class="modal fade" id="modalEditarEmpresa" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <form id="formEditarEmpresa" enctype="multipart/form-data">
                                <div class="modal-header ">
                                    <h5 class="modal-title" id="modalEditarEmpresaLabel">Editar Empresa</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="id" id="editar-id">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="editar-nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" name="nombre" id="editar-nombre" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-telefono" class="form-label">Teléfono</label>
                                            <input type="text" class="form-control" name="telefono" id="editar-telefono">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-correo" class="form-label">Correo</label>
                                            <input type="email" class="form-control" name="correo" id="editar-correo">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-direccion" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" name="direccion" id="editar-direccion">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-nit" class="form-label">NIT</label>
                                            <input type="text" class="form-control" name="nit" id="editar-nit">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-logo" class="form-label">Logo (opcional)</label>
                                            <input type="file" class="form-control" name="logo" id="editar-logo" accept="image/*">
                                            <div id="editPreviewLogo" style="display:none;">
                                                <img id="editLogoPreviewImg" class="img-thumbnail" style="max-height:100px;cursor:pointer">
                                                <button type="button" id="btnQuitarLogoEdit" class="btn btn-sm btn-danger mt-1">Quitar</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="editar-qr" class="form-label">QR (opcional)</label>
                                            <input type="file" class="form-control" name="qr" id="editar-qr" accept="image/*">
                                            <div id="editPreviewQr" style="display:none;">
                                                <img id="editQrPreviewImg" class="img-thumbnail" style="max-height:100px;cursor:pointer">
                                                <button type="button" id="btnQuitarQrEdit" class="btn btn-sm btn-danger mt-1">Quitar</button>
                                            </div>
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
                <!-- Modal de preview -->
                <div class="modal fade" id="imagePreviewModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content bg-transparent border-0 shadow-none">
                            <div class="modal-body text-center">
                                <img id="previewImage" src="" alt="Preview" class="img-fluid rounded shadow">
                            </div>
                        </div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    const storageBaseUrl = "{{ asset('logos_empresas') }}";
                </script>
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

                        // --- Tabla de empresas
                        const tableBody = document.getElementById('empresas-body');
                        const pagination = document.getElementById('empresas-pagination');
                        const searchInput = document.getElementById('search');
                        const tableHeaders = document.querySelectorAll('#empresas-table th[data-column]');

                        let currentPage = 1;
                        let sortColumn = '';
                        let sortDirection = 'asc';
                        let currentSearch = '';

                        function highlight(text, term) {
                            if (!term) return text;
                            return text.replace(new RegExp(`(${term})`, 'gi'), '<mark>$1</mark>');
                        }

                        function fetchEmpresas(page = 1, search = '', sortCol = '', sortDir = '') {
                            fetch(`{{ route('empresa.fetch') }}?page=${page}&search=${search}&sort=${sortCol}&direction=${sortDir}`)
                                .then(res => res.json())
                                .then(data => {
                                    tableBody.innerHTML = '';

                                    if (!data.data || data.data.length === 0) {
                                        tableBody.innerHTML = '<tr><td colspan="8" class="text-center">No hay empresas registradas</td></tr>';
                                        pagination.innerHTML = '';
                                        return;
                                    }

                                    data.data.forEach((empresa, index) => {
                                        const logoUrl = empresa.logo ? `/storage/${empresa.logo}` : '';
                                        const qrUrl = empresa.qr ? `/storage/${empresa.qr}` : '';

                                        tableBody.innerHTML += `
                    <tr data-id="${empresa.id}">
                        <td>${highlight(empresa.id, search)}</td>
                        <td>
                            ${logoUrl ? `<img src="${logoUrl}" class="logo-thumb" style="width:50px;height:50px;cursor:pointer" onclick="openImagePreview('${logoUrl}')">` : '-'}
                        </td>
                        <td>${highlight(empresa.nombre, search)}</td>
                        <td>${highlight(empresa.telefono ?? '-', search)}</td>
                        <td>${highlight(empresa.correo ?? '-', search)}</td>
                        <td>${highlight(empresa.direccion ?? '-', search)}</td>
                        <td>${highlight(empresa.nit ?? '-', search)}</td>
                        <td>
                            ${qrUrl ? `<img src="${qrUrl}" class="qr-thumb" style="width:50px;height:50px;cursor:pointer" onclick="openImagePreview('${qrUrl}')">` : '-'}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary btn-editar" data-id="${empresa.id}">Editar</button>
                            <button class="btn btn-sm btn-danger btn-eliminar" data-id="${empresa.id}">Eliminar</button>
                        </td>
                    </tr>
                `;
                                    });

                                    // Función única para abrir el modal con cualquier imagen (logo o QR)
                                    window.openImagePreview = function(url) {
                                        document.getElementById('previewImage').src = url;
                                        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
                                        modal.show();
                                    };

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

                                    document.querySelectorAll('#empresas-pagination a').forEach(a => {
                                        a.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            const page = parseInt(this.dataset.page);
                                            if (page >= 1 && page <= totalPages && page !== currentPage) {
                                                currentPage = page;
                                                fetchEmpresas(currentPage, currentSearch, sortColumn, sortDirection);
                                            }
                                        });
                                    });
                                })
                                .catch(err => showToast('Error al cargar empresas', 'danger'));
                        }

                        // Inicial
                        fetchEmpresas();

                        // Buscar
                        searchInput.addEventListener('keyup', function() {
                            currentSearch = this.value;
                            currentPage = 1;
                            fetchEmpresas(currentPage, currentSearch, sortColumn, sortDirection);
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
                                fetchEmpresas(currentPage, currentSearch, sortColumn, sortDirection);
                            });
                        });

                        // Previsualizar logo
                        document.getElementById('logo').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            const previewDiv = document.getElementById('previewLogo');
                            const previewImg = document.getElementById('previewLogoImg');
                            if (file) {
                                previewDiv.style.display = 'block';
                                previewImg.src = URL.createObjectURL(file);
                            }
                        });

                        // Previsualizar QR
                        document.getElementById('qr').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            const previewDiv = document.getElementById('previewQr');
                            const previewImg = document.getElementById('previewQrImg');
                            if (file) {
                                previewDiv.style.display = 'block';
                                previewImg.src = URL.createObjectURL(file);
                            }
                        });

                        // Quitar logo
                        document.getElementById('btnQuitarLogo').addEventListener('click', function() {
                            document.getElementById('logo').value = '';
                            const previewDiv = document.getElementById('previewLogo');
                            const previewImg = document.getElementById('previewLogoImg');
                            previewDiv.style.display = 'none';
                            previewImg.src = '';
                        });

                        // Quitar QR
                        document.getElementById('btnQuitarQr').addEventListener('click', function() {
                            document.getElementById('qr').value = '';
                            const previewDiv = document.getElementById('previewQr');
                            const previewImg = document.getElementById('previewQrImg');
                            previewDiv.style.display = 'none';
                            previewImg.src = '';
                        });

                        // Enviar formulario
                        const form = document.getElementById('formRegistrarEmpresa');
                        form.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(form);

                            fetch("{{ route('empresa.store') }}", {
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
                                        document.getElementById('previewLogo').style.display = 'none';
                                        document.getElementById('previewLogoImg').src = '';
                                        document.getElementById('previewQr').style.display = 'none';
                                        document.getElementById('previewQrImg').src = '';
                                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalRegistrarEmpresa'));
                                        modal.hide();
                                        fetchEmpresas(1, currentSearch, sortColumn, sortDirection);
                                    }
                                })
                                .catch(err => showToast('Error al registrar empresa', 'danger'));
                        });

                        // --- Editar empresa
                        // Abrir modal de edición
                        // --- Editar empresa
                        tableBody.addEventListener('click', function(e) {
                            if (e.target.classList.contains('btn-editar')) {
                                const id = e.target.dataset.id;

                                fetch(`/empresa/${id}/edit`)
                                    .then(res => res.json())
                                    .then(data => {
                                        // Llenar campos
                                        document.getElementById('editar-id').value = data.id;
                                        document.getElementById('editar-nombre').value = data.nombre;
                                        document.getElementById('editar-telefono').value = data.telefono ?? '';
                                        document.getElementById('editar-correo').value = data.correo ?? '';
                                        document.getElementById('editar-direccion').value = data.direccion ?? '';
                                        document.getElementById('editar-nit').value = data.nit ?? '';

                                        // Previsualizar logo
                                        const previewDiv = document.getElementById('editPreviewLogo');
                                        const previewImg = document.getElementById('editLogoPreviewImg');
                                        if (data.logo) {
                                            previewDiv.style.display = 'block';
                                            previewImg.src = `/storage/${data.logo}`;
                                        } else {
                                            previewDiv.style.display = 'none';
                                            previewImg.src = '';
                                        }

                                        // Previsualizar QR
                                        const previewDivQr = document.getElementById('editPreviewQr');
                                        const previewImgQr = document.getElementById('editQrPreviewImg');
                                        if (data.qr) {
                                            previewDivQr.style.display = 'block';
                                            previewImgQr.src = `/storage/${data.qr}`;
                                        } else {
                                            previewDivQr.style.display = 'none';
                                            previewImgQr.src = '';
                                        }

                                        // Abrir modal
                                        const modal = new bootstrap.Modal(document.getElementById('modalEditarEmpresa'));
                                        modal.show();
                                    });
                            }
                        });

                        // Cambiar logo en edición
                        document.getElementById('editar-logo').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            const previewDiv = document.getElementById('editPreviewLogo');
                            const previewImg = document.getElementById('editLogoPreviewImg');
                            if (file) {
                                previewDiv.style.display = 'block';
                                previewImg.src = URL.createObjectURL(file);
                            }
                        });

                        // Cambiar QR en edición
                        document.getElementById('editar-qr').addEventListener('change', function(e) {
                            const file = e.target.files[0];
                            const previewDivQr = document.getElementById('editPreviewQr');
                            const previewImgQr = document.getElementById('editQrPreviewImg');
                            if (file) {
                                previewDivQr.style.display = 'block';
                                previewImgQr.src = URL.createObjectURL(file);
                            }
                        });

                        // Quitar logo
                        document.getElementById('btnQuitarLogoEdit').addEventListener('click', function() {
                            document.getElementById('editar-logo').value = '';
                            const previewDiv = document.getElementById('editPreviewLogo');
                            const previewImg = document.getElementById('editLogoPreviewImg');
                            previewDiv.style.display = 'none';
                            previewImg.src = '';
                        });

                        // Quitar QR
                        document.getElementById('btnQuitarQrEdit').addEventListener('click', function() {
                            document.getElementById('editar-qr').value = '';
                            const previewDivQr = document.getElementById('editPreviewQr');
                            const previewImgQr = document.getElementById('editQrPreviewImg');
                            previewDivQr.style.display = 'none';
                            previewImgQr.src = '';
                        });

                        // --- Submit de edición
                        const formEditar = document.getElementById('formEditarEmpresa');
                        formEditar.addEventListener('submit', function(e) {
                            e.preventDefault();
                            const formData = new FormData(formEditar);
                            const id = formData.get('id');
                            formData.append('_method', 'PUT');

                            fetch(`/empresa/${id}`, {
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
                                        formEditar.reset();
                                        const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarEmpresa'));
                                        modal.hide();
                                        fetchEmpresas(currentPage, currentSearch, sortColumn, sortDirection); // recarga tabla
                                    }
                                })
                                .catch(err => showToast('Error al actualizar empresa', 'danger'));
                        });

                    });
                </script>
            </div>
        </div>
    </main>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>
