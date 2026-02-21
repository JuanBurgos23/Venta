<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
                <div class="venta-loader" id="venta-loader" aria-hidden="true">
            <div class="venta-loader-card">
                <svg stroke="hsl(228, 97%, 42%)" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="venta-loader-icon" aria-label="Cargando" role="img"><g><circle cx="12" cy="12" r="9.5" fill="none" stroke-width="3" stroke-linecap="round"><animate attributeName="stroke-dasharray" dur="1.5s" calcMode="spline" values="0 150;42 150;42 150;42 150" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/><animate attributeName="stroke-dashoffset" dur="1.5s" calcMode="spline" values="0;-16;-59;-59" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/></circle><animateTransform attributeName="transform" type="rotate" dur="2s" values="0 12 12;360 12 12" repeatCount="indefinite"/></g></svg>
                <div class="venta-loader-text" id="venta-loader-text">Cargando...</div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Gestión de Usuarios</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
                            Crear Usuario
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <input type="text" id="search" class="form-control" placeholder="Buscar usuario...">
                            </div>
                            <div class="col-md-4">
                                <select id="filterRole" class="form-select">
                                    <option value="">-- Filtrar por rol --</option>
                                    @foreach ($roles as $rol)
                                    <option value="{{ $rol->nombre }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <table class="table table-bordered table-striped" id="tablaUsuarios">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Crear Usuario -->
        <div class="modal fade" id="modalCrear" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crear Usuario</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('usuarios.store') }}" method="POST" id="formCrear">
                            @csrf
                            @method('POST')
                            <div class="mb-3">
                                <label>Nombre</label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Contraseña</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Rol</label>
                                <select name="role" class="form-select">
                                    @foreach ($roles as $rol)
                                    <option value="{{ $rol->nombre }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Usuario -->
        <div class="modal fade" id="modalEditar" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Usuario</h5>
                    </div>
                    <div class="modal-body">
                        <form id="formEditar">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" id="edit_id">

                            <div class="mb-3">
                                <label>Nombre</label>
                                <input type="text" name="name" id="edit_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" id="edit_email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Contraseña (opcional)</label>
                                <input type="password" name="password" id="edit_password" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Rol</label>
                                <select name="role" id="edit_role" class="form-select">
                                    @foreach ($roles as $rol)
                                    <option value="{{ $rol->nombre }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>


    <script>
        const setupUsuarioPage = () => {
            const tbody = document.querySelector('#tablaUsuarios tbody');
            const search = document.getElementById('search');
            const filterRole = document.getElementById('filterRole');
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

            // Toast simple
            function showToast(message, type = 'primary') {
                const toastEl = document.querySelector('.bs-toast');
                toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
                toastEl.querySelector('.toast-body').textContent = message;
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }

            // Cargar usuarios
            function cargarUsuarios() {
                showLoader('Cargando Usuarios...');
                const url = "{{ route('usuarios.lista') }}?search=" + encodeURIComponent(search.value) + "&role=" + encodeURIComponent(filterRole.value);
                fetch(url, {
                        cache: 'no-store'
                    })
                    .then(res => res.json())
                    .then(data => {
                        tbody.innerHTML = '';
                        data.forEach(user => {
                            const roles = (user.roles || []).map(r => r.nombre).join(', ');
                            const tr = document.createElement('tr');
                            tr.setAttribute('data-id', user.id);
                            tr.innerHTML = `
                        <td>${user.id}</td>
                        <td>${escapeHtml(user.name)}</td>
                        <td>${escapeHtml(user.email)}</td>
                        <td>${escapeHtml(roles)}</td>
                        <td>
                            <button class="btn btn-warning btn-sm btn-editar" data-id="${user.id}">Editar</button>
                            <button class="btn btn-danger btn-sm btn-eliminar" data-id="${user.id}">Eliminar</button>
                        </td>`;

                            tbody.appendChild(tr);
                        });
                        hideLoader();
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Error al cargar usuarios', 'danger');
                    });
            }

            // Escapar HTML simple para evitar inyección en tabla
            function escapeHtml(text) {
                if (!text) return '';
                return text
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // Eventos búsqueda / filtro
            search.addEventListener('input', cargarUsuarios);
            filterRole.addEventListener('change', cargarUsuarios);

            // Delegación: abrir modal de edición al click en .btn-editar
            tbody.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-editar');
                if (!btn) return;

                const id = btn.dataset.id;
                const row = tbody.querySelector(`tr[data-id="${id}"]`);
                if (!row) return;

                // Rellenar modal con valores de la fila
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_name').value = row.children[1].textContent.trim();
                document.getElementById('edit_email').value = row.children[2].textContent.trim();
                document.getElementById('edit_password').value = ''; // limpiar
                const rolesText = row.children[3].textContent.trim();
                document.getElementById('edit_role').value = rolesText.split(', ')[0] || '';

                // Abrir modal (igual que tu guía)
                const modalEl = document.getElementById('modalEditar');
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            });

            // Delegación: eliminar botón (ejemplo)
            // Delegación: eliminar botón con SweetAlert2
            tbody.addEventListener('click', function(e) {
                const del = e.target.closest('.btn-eliminar');
                if (!del) return;

                const id = del.dataset.id;

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "Este usuario será marcado como Eliminado.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/usuarios/${id}`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: (() => {
                                    const fd = new FormData();
                                    fd.append('_method', 'DELETE'); // Laravel espera DELETE
                                    return fd;
                                })()
                            })
                            .then(res => res.json())
                            .then(data => {
                                showToast(data.message, data.status === 'success' ? 'success' : 'danger');
                                if (data.status === 'success') {
                                    cargarUsuarios();
                                    Swal.fire(
                                        'Eliminado',
                                        'El usuario ha sido marcado como Eliminado.',
                                        'success'
                                    );
                                }
                            })
                            .catch(() => showToast('Error al eliminar', 'danger'));
                    }
                });
            });


            // Envío del formulario de edición (igual que la guía)
            const formEditar = document.getElementById('formEditar');
            if (formEditar) {
                formEditar.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(formEditar);
                    const id = formData.get('id') || document.getElementById('edit_id').value;

                    // Añadimos _method=PUT para override
                    formData.append('_method', 'PUT');

                    fetch(`{{ url('usuarios') }}/${id}`, {
                            method: 'POST', // Laravel recibirá PUT via _method
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
                                // cerrar modal usando getInstance (como en tu guía)
                                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('modalEditar'));
                                if (modalInstance) {
                                    modalInstance.hide();
                                }
                                // recargar lista
                                cargarUsuarios();
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            showToast('Error al actualizar usuario', 'danger');
                        });
                });
            }

            // Primera carga
            cargarUsuarios();

            window.__usuarioReload = () => {
                cargarUsuarios();
            };
        };

        const handleUsuarioLoad = () => {
            const root = document.getElementById('tablaUsuarios');
            if (!root) return;
            if (root.dataset.usuarioInit === '1') {
                window.__usuarioReload?.();
                return;
            }
            root.dataset.usuarioInit = '1';
            setupUsuarioPage();
        };

        document.addEventListener('turbo:load', handleUsuarioLoad);
        document.addEventListener('DOMContentLoaded', handleUsuarioLoad);
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
