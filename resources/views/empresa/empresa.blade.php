<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        @vite(['resources/js/app.js'])

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Mi Empresa</h5>
                                <small class="text-muted">Visualiza y edita los datos de tu empresa</small>
                            </div>
                        </div>

                        <div class="card-body">
                            @if (!$empresa)
                                <div class="alert alert-warning mb-0">
                                    No hay una empresa asignada a tu usuario.
                                </div>
                            @else
                                <div class="row g-4">
                                    <div class="col-lg-4">
                                        <div class="card border h-100">
                                            <div class="card-header bg-light py-2">
                                                <h6 class="mb-0">Identidad Visual</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-4">
                                                    <label class="form-label small">Logo actual</label>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="logo-preview-box">
                                                            @if ($empresa->logo)
                                                                <img id="currentLogoImg" src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo actual">
                                                            @else
                                                                <span class="text-muted small">Sin logo</span>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <input type="file" class="form-control form-control-sm" id="logo" name="logo" accept="image/*">
                                                            <div id="newLogoPreview" class="mt-2 d-none">
                                                                <img id="newLogoImg" alt="Nuevo logo">
                                                                <button type="button" id="btnQuitarLogo" class="btn btn-sm btn-outline-danger mt-2">Quitar selección</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted d-block mt-1">Sube un nuevo logo para reemplazar el actual.</small>
                                                </div>

                                                <div>
                                                    <label class="form-label small">QR actual</label>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="qr-preview-box">
                                                            @if ($empresa->qr)
                                                                <img id="currentQrImg" src="{{ asset('storage/' . $empresa->qr) }}" alt="QR actual">
                                                            @else
                                                                <span class="text-muted small">Sin QR</span>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <input type="file" class="form-control form-control-sm" id="qr" name="qr" accept="image/*">
                                                            <div id="newQrPreview" class="mt-2 d-none">
                                                                <img id="newQrImg" alt="Nuevo QR">
                                                                <button type="button" id="btnQuitarQr" class="btn btn-sm btn-outline-danger mt-2">Quitar selección</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <small class="text-muted d-block mt-1">Sube un nuevo QR para reemplazar el actual.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        <div class="card border h-100">
                                            <div class="card-header bg-light py-2">
                                                <h6 class="mb-0">Datos de la Empresa</h6>
                                            </div>
                                            <div class="card-body">
                                                <form id="formEmpresa" enctype="multipart/form-data">
                                                    <input type="hidden" name="id" id="empresa-id" value="{{ $empresa->id }}">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Nombre</label>
                                                            <input type="text" class="form-control" name="nombre" id="empresa-nombre" value="{{ $empresa->nombre }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">NIT</label>
                                                            <input type="text" class="form-control" name="nit" id="empresa-nit" value="{{ $empresa->nit }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Teléfono</label>
                                                            <input type="text" class="form-control" name="telefono" id="empresa-telefono" value="{{ $empresa->telefono }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Correo</label>
                                                            <input type="email" class="form-control" name="correo" id="empresa-correo" value="{{ $empresa->correo }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Dirección</label>
                                                            <input type="text" class="form-control" name="direccion" id="empresa-direccion" value="{{ $empresa->direccion }}">
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-end mt-4">
                                                        <button type="submit" class="btn btn-primary">
                                                            Guardar cambios
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const setupEmpresaPage = () => {
            const form = document.getElementById('formEmpresa');
            if (!form) return;

            const logoInput = document.getElementById('logo');
            const qrInput = document.getElementById('qr');
            const newLogoPreview = document.getElementById('newLogoPreview');
            const newLogoImg = document.getElementById('newLogoImg');
            const newQrPreview = document.getElementById('newQrPreview');
            const newQrImg = document.getElementById('newQrImg');

            const showToast = (message, type = 'primary') => {
                const toastEl = document.querySelector('.bs-toast');
                if (!toastEl) return;
                toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
                toastEl.querySelector('.toast-body').textContent = message;
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            };

            const showPreview = (inputEl, previewWrap, previewImg) => {
                const file = inputEl.files[0];
                if (!file) {
                    previewWrap.classList.add('d-none');
                    previewImg.src = '';
                    return;
                }
                previewWrap.classList.remove('d-none');
                previewImg.src = URL.createObjectURL(file);
            };

            logoInput?.addEventListener('change', () => showPreview(logoInput, newLogoPreview, newLogoImg));
            qrInput?.addEventListener('change', () => showPreview(qrInput, newQrPreview, newQrImg));

            document.getElementById('btnQuitarLogo')?.addEventListener('click', () => {
                logoInput.value = '';
                showPreview(logoInput, newLogoPreview, newLogoImg);
            });

            document.getElementById('btnQuitarQr')?.addEventListener('click', () => {
                qrInput.value = '';
                showPreview(qrInput, newQrPreview, newQrImg);
            });

            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const formData = new FormData(form);
                const id = document.getElementById('empresa-id').value;
                formData.append('_method', 'PUT');

                if (logoInput?.files[0]) formData.append('logo', logoInput.files[0]);
                if (qrInput?.files[0]) formData.append('qr', qrInput.files[0]);

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
                        if (data.empresa?.logo && document.getElementById('currentLogoImg')) {
                            document.getElementById('currentLogoImg').src = `/storage/${data.empresa.logo}`;
                        }
                        if (data.empresa?.qr && document.getElementById('currentQrImg')) {
                            document.getElementById('currentQrImg').src = `/storage/${data.empresa.qr}`;
                        }
                        logoInput.value = '';
                        qrInput.value = '';
                        showPreview(logoInput, newLogoPreview, newLogoImg);
                        showPreview(qrInput, newQrPreview, newQrImg);
                    }
                })
                .catch(() => showToast('Error al actualizar empresa', 'danger'));
            });
        };

        const handleEmpresaLoad = () => {
            const root = document.getElementById('formEmpresa');
            if (!root) return;
            if (root.dataset.empresaInit === '1') return;
            root.dataset.empresaInit = '1';
            setupEmpresaPage();
        };

        document.addEventListener('turbo:load', handleEmpresaLoad);
        document.addEventListener('DOMContentLoaded', handleEmpresaLoad);
    </script>

    <style>
        .logo-preview-box,
        .qr-preview-box {
            width: 110px;
            height: 110px;
            border: 1px dashed #cbd3da;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            overflow: hidden;
        }

        .logo-preview-box img,
        .qr-preview-box img,
        #newLogoPreview img,
        #newQrPreview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        #newLogoPreview img,
        #newQrPreview img {
            width: 80px;
            height: 80px;
            border-radius: 0.4rem;
            border: 1px solid #e0e0e0;
        }
    </style>
</x-layout>
