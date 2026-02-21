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
                <h4 class="mb-1">Roles List</h4>
                <p class="mb-6">Un rol provee acceso a menús y funcionalidades predefinidas. Dependiendo del rol, un administrador puede limitar qué puede hacer cada usuario.</p>

                <!-- Role cards -->
                <div class="row g-6">

                    @foreach($roles as $role)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h6 class="fw-normal mb-0 text-body">Total {{ $role->users->count() }} usuarios</h6>
                                    <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                        @foreach($role->users->take(4) as $user)
                                        <li class="avatar pull-up" title="{{ $user->name }}">
                                            <img class="rounded-circle" src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('assets/img/avatars/cat4.gif') }}" alt="Avatar" />
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div class="role-heading">
                                        <h5 class="mb-1">{{ $role->nombre }}</h5>
                                        <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#editRoleModal{{ $role->id }}" class="role-edit-modal"><span>Editar Rol</span></a>
                                    </div>
                                    <a href="javascript:void(0);"><i class="icon-base bx bx-copy icon-md text-body-secondary"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Edit Role -->
                    <div class="modal fade" id="editRoleModal{{ $role->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    <div class="text-center mb-6">
                                        <h4 class="role-title mb-2">Editar Rol</h4>
                                        <p>Configura permisos para este rol</p>
                                    </div>
                                    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="row g-6">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="empresa_id" class="empresa-id-input" value="">

                                        <div class="col-12">
                                            <label class="form-label">Nombre del Rol</label>
                                            <input type="text" name="name" class="form-control" value="{{ $role->nombre }}" required>
                                        </div>

                                        <div class="col-12">
                                            <h5 class="mb-3">Permisos</h5>
                                            <div class="table-responsive">
                                                <table class="table table-flush-spacing mb-0 border-top">
                                                    <tbody>
                                                        @php
                                                            $asignadas = $rolePantallas[$role->id] ?? collect();
                                                        @endphp
                                                        @foreach($pantallas as $pantalla)
                                                        <tr>
                                                            <td>
                                                                {{ $pantalla->modulo_nombre ? $pantalla->modulo_nombre . ' - ' : '' }}{{ $pantalla->nombre }}
                                                            </td>
                                                            <td>
                                                                <div class="form-check d-flex justify-content-end">
                                                                    <input class="form-check-input" type="checkbox" name="pantallas[]" value="{{ $pantalla->id }}"
                                                                        {{ $asignadas->contains($pantalla->id) ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-12 text-center">
                                            <button type="submit" class="btn btn-success mt-3">Actualizar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Add New Role Card -->
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="card h-100">
                            <div class="row h-100">
                                <div class="col-sm-5">
                                    <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4 ps-6">
                                        <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/illustrations/lady-with-laptop-dark.png" class="img-fluid" width="120" />
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="card-body text-sm-end text-center ps-sm-0">
                                        <button data-bs-toggle="modal" data-bs-target="#addRoleModal" class="btn btn-sm btn-primary mb-4">Agregar Rol</button>
                                        <p class="mb-0">Añade un nuevo rol si aún no existe.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--/ Role cards -->

            </div>

            <!-- Modal Add Role -->
            <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-add-new-role">
                    <div class="modal-content">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">

                            <div class="text-center mb-6">
                                <h4 class="role-title mb-2">Agregar Nuevo Rol</h4>
                                <p>Asigna permisos al nuevo rol</p>

                            </div>
                            <form action="{{ route('roles.store') }}" method="POST" class="row g-6">
                                @csrf
                                <input type="hidden" name="empresa_id" class="empresa-id-input" value="">
                                <div class="col-12">
                                    <label class="form-label">Nombre del Rol</label>
                                    <input type="text" name="name" class="form-control" placeholder="Ej: Recepcionista" required>
                                </div>

                                <div class="col-12">
                                    <h5 class="mb-3">Permisos</h5>
                                    <div class="table-responsive">
                                        <table class="table table-flush-spacing mb-0 border-top">
                                            <tbody>
                                                @foreach($pantallas as $pantalla)
                                                <tr>
                                                    <td>
                                                        {{ $pantalla->modulo_nombre ? $pantalla->modulo_nombre . ' - ' : '' }}{{ $pantalla->nombre }}
                                                    </td>
                                                    <td>
                                                        <div class="form-check d-flex justify-content-end">
                                                            <input class="form-check-input" type="checkbox" name="pantallas[]" value="{{ $pantalla->id }}">
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-success mt-3">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <script>
        const setupRolPage = () => {
            const resolveEmpresaId = () => {
                try {
                    const data = JSON.parse(localStorage.getItem('empresaSuscripcion') || 'null');
                    return data?.empresa_id || data?.id_empresa || data?.empresa?.id || window.APP?.empresaId || null;
                } catch (e) {
                    return window.APP?.empresaId || null;
                }
            };

            const empresaId = resolveEmpresaId();
            if (!empresaId) return;

            document.querySelectorAll('.empresa-id-input').forEach(el => el.value = empresaId);
        };

        const handleRolLoad = () => {
            const root = document.querySelector('.empresa-id-input');
            if (!root) return;
            if (root.dataset.rolInit === '1') return;
            root.dataset.rolInit = '1';
            setupRolPage();
        };

        document.addEventListener('turbo:load', handleRolLoad);
        document.addEventListener('DOMContentLoaded', handleRolLoad);
    </script>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>
