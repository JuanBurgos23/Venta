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
                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-pills flex-column flex-md-row mb-3" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-cuenta-tab" data-bs-toggle="pill" data-bs-target="#tab-cuenta" type="button" role="tab">Cuenta</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-password-tab" data-bs-toggle="pill" data-bs-target="#tab-password" type="button" role="tab">Contraseña</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab-cuenta">
                                <h5 class="card-header">Perfil Detalles</h5>
                                <!-- Account -->
                                <div class="card-body">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                       
                                        <form action="{{ route('profile.update') }}" id="formAccountSettings" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('patch')
                                            <div class="button-wrapper">
                                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                    <span class="d-none d-sm-block">Cambiar foto de perfil</span>
                                                    <input type="file" id="upload" name="profile_photo" class="account-file-input" hidden accept="image/png, image/jpeg" />
                                                </label>
                                                <button type="button" id="resetAvatar" class="btn btn-outline-secondary account-image-reset mb-4">
                                                    <span class="d-none d-sm-block">Resetear Foto</span>
                                                </button>
                                            </div>
                                    </div>
                                </div>
                                <hr class="my-0" />
                                <br>
                                <br>
                                <div class="card mb-6">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    id="nombre"
                                                    name="nombre"
                                                    value="{{auth()->user()->name}}" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="paterno" class="form-label">Paterno</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    id="paterno"
                                                    name="paterno"
                                                    value="{{auth()->user()->paterno ?? 'Sin Dato'}}" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="materno" class="form-label">Materno</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    id="materno"
                                                    name="materno"
                                                    value="{{auth()->user()->materno ?? 'Sin Dato'}}" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label for="email" class="form-label">Correo</label>
                                                <input
                                                    class="form-control"
                                                    type="text"
                                                    id="email"
                                                    name="email"
                                                    value="{{ auth()->user()->email }}"
                                                    placeholder="john.doe@example.com" />
                                            </div>

                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-primary me-2">Guardar</button>
                                            <button type="reset" class="btn btn-outline-secondary">Cancelar</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- /Account 

                                <div class="card">
                                    <h5 class="card-header">Eliminar cuenta</h5>
                                    <div class="card-body">
                                        <div class="mb-3 col-12 mb-0">
                                            <div class="alert alert-warning">
                                                <h6 class="alert-heading fw-bold mb-1">¿Estás seguro de que deseas eliminar tu cuenta?</h6>
                                                <p class="mb-0">Una vez que elimines tu cuenta, no hay vuelta atrás. Por favor, asegúrate.</p>
                                            </div>
                                        </div>
                                        <form action="{{ route('profile.destroy') }}" id="formAccountDeactivation">
                                            @csrf
                                            @method('delete')
                                            <div class="form-check mb-3">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="accountActivation"
                                                    id="accountActivation" />
                                                <label class="form-check-label" for="accountActivation">Confirmo la desactivación de mi cuenta</label>
                                            </div>
                                            <button type="submit" class="btn btn-danger deactivate-account">Desactivar cuenta</button>
                                        </form>
                                    </div>
                                </div>
                            </div>-->
                            </div>
                            <!-- Contraseña -->
                            <div class="tab-pane fade" id="tab-password">
                                <div class="card">
                                    <h5 class="card-header">Cambiar Contraseña</h5>
                                    <div class="card-body">
                                        <form action="{{ route('profile.password') }}" method="POST" id="formChangePassword">
                                            @csrf
                                            @method('patch')

                                            <!-- Contraseña Actual -->
                                            <div class="mb-3 position-relative">
                                                <label for="current_password" class="form-label">Contraseña Actual</label>
                                                <input type="password" name="current_password" id="current_password" class="form-control form-control-sm" required>
                                                <span class="toggle-password" data-target="current_password" style="position:absolute; right:10px; top:38px; cursor:pointer;">
                                                    <i class="bx bx-show"></i>
                                                </span>
                                            </div>

                                            <!-- Nueva Contraseña -->
                                            <div class="mb-3 position-relative">
                                                <label for="new_password" class="form-label">Nueva Contraseña</label>
                                                <input type="password" name="new_password" id="new_password" class="form-control form-control-sm" required>
                                                <span class="toggle-password" data-target="new_password" style="position:absolute; right:10px; top:38px; cursor:pointer;">
                                                    <i class="bx bx-show"></i>
                                                </span>
                                                <div class="form-text text-muted">
                                                    Debe tener al menos 8 caracteres, una letra mayúscula y un número.
                                                </div>
                                            </div>

                                            <!-- Confirmar Nueva Contraseña -->
                                            <div class="mb-3 position-relative">
                                                <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control form-control-sm" required>
                                                <span class="toggle-password" data-target="new_password_confirmation" style="position:absolute; right:10px; top:38px; cursor:pointer;">
                                                    <i class="bx bx-show"></i>
                                                </span>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-sm">Actualizar Contraseña</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.querySelectorAll('.toggle-password').forEach(el => {
                                    el.addEventListener('click', () => {
                                        const target = document.getElementById(el.dataset.target);
                                        if (target.type === 'password') {
                                            target.type = 'text';
                                            el.innerHTML = '<i class="bx bx-hide"></i>';
                                        } else {
                                            target.type = 'password';
                                            el.innerHTML = '<i class="bx bx-show"></i>';
                                        }
                                    });
                                });

                                // Validación simple antes de enviar
                                document.getElementById('formChangePassword').addEventListener('submit', function(e) {
                                    const newPass = document.getElementById('new_password').value;
                                    const pattern = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
                                    if (!pattern.test(newPass)) {
                                        e.preventDefault();
                                        alert('La nueva contraseña debe tener al menos 8 caracteres, una letra mayúscula y un número.');
                                    }
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // --- Toast Bootstrap ---
                    function showToast(message, type = 'primary') {
                        const toastEl = document.querySelector('.bs-toast');
                        toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
                        toastEl.querySelector('.toast-body').textContent = message;
                        const toast = new bootstrap.Toast(toastEl);
                        toast.show();
                    }

                    @if(session('success'))
                    showToast("{{ session('success') }}", 'success');
                    @endif

                    @if($errors -> any())
                    let errorMsg = '';
                    @foreach($errors -> all() as $error)
                    errorMsg += "{{ $error }}\n";
                    @endforeach
                    showToast(errorMsg.trim(), 'danger');
                    @endif
                });
            </script>

            <script>
                const uploadedAvatar = document.getElementById('uploadedAvatar');
                const uploadInput = document.getElementById('upload');
                const resetButton = document.getElementById('resetAvatar');
                const defaultAvatar = "{{ asset('assets/img/avatars/cat4.gif') }}";

                // Vista previa al subir
                uploadInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        uploadedAvatar.src = URL.createObjectURL(file);
                    }
                });

                // Resetear avatar con confirmación
                resetButton.addEventListener('click', function() {
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Se eliminará tu foto de perfil y se usará el avatar por defecto.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                            confirmButton: 'btn btn-danger me-2',
                            cancelButton: 'btn btn-secondary'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch("{{ route('user.resetAvatar') }}", {
                                    method: "DELETE",
                                    headers: {
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                        "Accept": "application/json",
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        uploadInput.value = '';
                                        uploadedAvatar.src = data.defaultAvatar;

                                        // Mostrar toast
                                        const toastEl = document.querySelector('.bs-toast');
                                        toastEl.querySelector('.toast-body').textContent = "Avatar eliminado correctamente";
                                        toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-success top-0 end-0 hide`;
                                        const toast = new bootstrap.Toast(toastEl);
                                        toast.show();
                                    } else {
                                        Swal.fire('Error', 'No se pudo eliminar el avatar.', 'error');
                                    }
                                })
                                .catch(() => Swal.fire('Error', 'Error de conexión con el servidor.', 'error'));
                        }
                    });
                });
            </script>

    </main>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>