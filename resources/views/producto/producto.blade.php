<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <!-- jQuery (Select2 depende de jQuery) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-container {
            z-index: 20000 !important;
        }
    </style>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        @vite(['resources/js/app.js'])
            <div class="venta-loader" id="venta-loader" aria-hidden="true">
              <div class="venta-loader-card">
                  <svg stroke="hsl(228, 97%, 42%)" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="venta-loader-icon" aria-label="Cargando" role="img"><g><circle cx="12" cy="12" r="9.5" fill="none" stroke-width="3" stroke-linecap="round"><animate attributeName="stroke-dasharray" dur="1.5s" calcMode="spline" values="0 150;42 150;42 150;42 150" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/><animate attributeName="stroke-dashoffset" dur="1.5s" calcMode="spline" values="0;-16;-59;-59" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/></circle><animateTransform attributeName="transform" type="rotate" dur="2s" values="0 12 12;360 12 12" repeatCount="indefinite"/></g></svg>
                  <div class="venta-loader-text" id="venta-loader-text">Cargando...</div>
              </div>
            </div>
        <div class="container-fluid py-4">
            <div class="card my-4">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                    <h5 class="mb-0">Gestión de Productos</h5>
                    <button class="btn btn-primary btn-sm" id="btn-new-product">
                        <i class="bx bx-plus-circle"></i> Nuevo Producto
                    </button>
                </div>

                <div class="card-body">
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <input type="text" id="search-input" class="form-control" placeholder="Buscar producto...">
                        </div>
                    </div>

                    <div class="table-responsive d-none d-md-block">
                        <table class="table table-striped align-middle" id="products-table">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Subcategoría</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Imagen</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <div id="products-cards" class="d-md-none"></div>

                    <nav>
                        <ul class="pagination justify-content-center mt-3" id="pagination"></ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Modal Producto -->
        <div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form id="product-form" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-title">Nuevo Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="product-id" name="id">

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Código</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="2"></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="marca" name="marca">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Modelo</label>
                                    <input type="text" class="form-control" id="modelo" name="modelo">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Origen</label>
                                    <input type="text" class="form-control" id="origen" name="origen">
                                </div>
                            </div>

                            <div class="row">
                                <!-- Categoría -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Categoría</label>
                                    <select class="select2 form-select form-select-lg" id="categoria-select" name="categoria_id" style="width:100%;">

                                    </select>
                                </div>
                                <!-- Subcategoría -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Subcategoría</label>
                                    <select class="select2 form-select form-select-lg" id="subcategoria-select" name="subcategoria_id" style="width:100%;">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Inventario</label>
                                <select class="form-select" name="inventariable" id="inventariable">
                                    <option value="1">Inventariable</option>
                                    <option value="0">No inventariable</option>
                                </select>
                            </div>



                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Precio</label>
                                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                                </div>
                            </div>

                            <!-- Dropzone -->
                            <div class="col-12">
                                <div class="card">
                                    <h6 class="card-header">Imagen del producto</h6>
                                    <div class="card-body">
                                        <div action="/upload" class="dropzone needsclick" id="dropzone-basic">
                                            <div class="dz-message needsclick">
                                                Arrastra o haz clic para subir la imagen
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </main>
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
    <script>
        const setupProductoPage = () => {
            // ==========================
            // Variables
            // ==========================
            const tableBody = document.querySelector("#products-table tbody");
            const paginationEl = document.querySelector("#pagination");
            const categoriaSelect = document.getElementById("categoria-select");
            const subcategoriaSelect = document.getElementById("subcategoria-select");
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

            let currentPage = 1;
            let searchTerm = "";
            let dropzone;
            loadProducts(searchTerm);
            initDropzone();
            // ==========================
            // Toast
            // ==========================
            function showToast(message, type = "primary") {
                const toastEl = document.querySelector(".bs-toast");
                if (!toastEl) return;
                toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide show`;
                toastEl.querySelector(".toast-body").textContent = message;
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }

            // ==========================
            // Cargar productos
            // ==========================
            function loadProducts(page = 1) {
                showLoader("Cargando productos...");
                fetch(`/productos?page=${page}&search=${searchTerm}`)
                    .then(res => res.json())
                    .then(data => {
                        tableBody.innerHTML = "";
                        if (!data.data || data.data.length === 0) {
                            tableBody.innerHTML = "<tr><td colspan='8' class='text-center'>No hay productos</td></tr>";
                            paginationEl.innerHTML = "";
                            return;
                        }

                        data.data.forEach(p => {
                            const tr = document.createElement("tr");
                            tr.innerHTML = `
        <td>${p.codigo ?? '-'}</td>
        <td>${p.nombre}</td>
        <td>${p.categoria ? p.categoria.nombre : '-'}</td>
        <td>${p.subcategoria ? p.subcategoria.nombre : '-'}</td>
        <td>${p.precio}</td>
        <td>${p.stock_actual ?? '-'}</td>
        <td>${p.image ? `<img src="${p.image}" class="img-thumbnail" style="width:50px;">` : '-'}</td>
        <td>
            <button class="btn btn-sm btn-warning btn-edit" data-id="${p.id}">
                <i class="bx bx-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger btn-delete" data-id="${p.id}">
                <i class="bx bx-trash"></i>
            </button>
        </td>
    `;
                            tableBody.appendChild(tr);
                        });


                        // Paginación
                        paginationEl.innerHTML = "";
                        for (let i = 1; i <= data.last_page; i++) {
                            const li = document.createElement("li");
                            li.className = `page-item ${i === data.current_page ? 'active' : ''}`;
                            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                            li.addEventListener("click", (e) => {
                                e.preventDefault();
                                currentPage = i;
                                loadProducts(i);
                            });
                            paginationEl.appendChild(li);
                        }

                        document.querySelectorAll(".btn-edit").forEach(btn => {
                            btn.addEventListener("click", () => editProduct(btn.dataset.id));
                        });
                        hideLoader();
                    })
                    .catch(err => {
                        console.error(err);
                        tableBody.innerHTML = "<tr><td colspan='8' class='text-center text-danger'>Error cargando productos</td></tr>";
                        hideLoader();
                    });
            }

            // ==========================
            // Buscador
            // ==========================
            document.getElementById("search-input").addEventListener("keyup", (e) => {
                searchTerm = e.target.value;
                loadProducts(1);
            });

            // ==========================
            // Reset Form
            // ==========================
            function resetForm() {
                document.getElementById("product-form").reset();
                document.getElementById("product-id").value = "";
                $("#categoria-select").val(null).trigger("change");
                $("#subcategoria-select").val(null).trigger("change");
                if (dropzone) dropzone.removeAllFiles();
                const dzMsg = document.querySelector("#dropzone-basic .dz-message");
                if (dzMsg) dzMsg.style.display = "block";
            }

            // ==========================
            // Inicializar Dropzone con template personalizado
            // ==========================
            function initDropzone() {
                if (dropzone) return; // ya está inicializado

                Dropzone.autoDiscover = false;
                dropzone = new Dropzone("#dropzone-basic", {
                    url: "/fake-upload",
                    autoProcessQueue: false,
                    maxFiles: 1,
                    acceptedFiles: "image/*",
                    addRemoveLinks: true,
                    dictRemoveFile: "Eliminar archivo",
                    previewsContainer: "#dropzone-basic",
                    previewTemplate: `
<div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
    <div class="dz-details">
        <div class="dz-thumbnail">
            <img data-dz-thumbnail="" alt="">
            <span class="dz-nopreview">No preview</span>
            <div class="dz-success-mark"></div>
            <div class="dz-error-mark"></div>
            <div class="dz-error-message"><span data-dz-errormessage=""></span></div>
            <div class="progress">
                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress="" style="width: 0%;"></div>
            </div>
        </div>
        <div class="dz-filename" data-dz-name=""></div>
        <div class="dz-size" data-dz-size=""><strong></strong> KB</div>
    </div>
</div>
        `,
                    init: function() {
                        this.on("addedfile", function(file) {
                            const dzMsg = document.querySelector("#dropzone-basic .dz-message");
                            if (dzMsg) dzMsg.style.display = "none";
                        });
                        this.on("uploadprogress", function(file, progress) {
                            const bar = file.previewElement.querySelector(".progress-bar");
                            if (bar) bar.style.width = progress + "%";
                        });
                        this.on("removedfile", function(file) {
                            const dzMsg = document.querySelector("#dropzone-basic .dz-message");
                            if (dzMsg) dzMsg.style.display = "block";
                        });
                    }
                });
            }

            // ==========================
            // Nuevo producto
            // ==========================
            document.getElementById("btn-new-product").addEventListener("click", () => {
                resetForm();
                document.getElementById("modal-title").textContent = "Nuevo Producto";
                new bootstrap.Modal(document.getElementById("productModal")).show();
                setTimeout(initDropzone, 200);
            });

            // ==========================
            // Editar producto
            // ==========================
            function editProduct(id) {
                fetch(`/productos/${id}`)
                    .then(res => {
                        if (!res.ok) throw new Error("Error HTTP " + res.status);
                        return res.json();
                    })
                    .then(p => {
                        // Limpiar formulario y Dropzone
                        document.getElementById("product-form").reset();
                        dropzone.removeAllFiles(true);

                        // Rellenar campos
                        document.getElementById("modal-title").textContent = "Editar Producto";
                        document.getElementById("product-id").value = p.id;
                        document.getElementById("codigo").value = p.codigo ?? "";
                        document.getElementById("nombre").value = p.nombre ?? "";
                        document.getElementById("descripcion").value = p.descripcion ?? "";
                        document.getElementById("marca").value = p.marca ?? "";
                        document.getElementById("modelo").value = p.modelo ?? "";
                        document.getElementById("origen").value = p.origen ?? "";
                        document.getElementById("precio").value = p.precio ?? "";
                        $("#categoria-select").val(p.categoria_id).trigger("change");
                        $("#subcategoria-select").val(p.subcategoria_id).trigger("change");
                        $("#inventariable").val(p.inventariable ? "1" : "0");
                        // Cargar subcategorías de esa categoría
                        fetch(`/subcategorias/byCategoria/${p.categoria_id}`)
                            .then(res => res.json())
                            .then(subs => {
                                const $sub = $("#subcategoria-select");
                                $sub.empty();

                                subs.forEach(s => {
                                    const option = new Option(s.nombre, s.id, false, false);
                                    $sub.append(option);
                                });

                                // Setear la subcategoría seleccionada
                                $sub.val(p.subcategoria_id).trigger("change");
                            })
                            .catch(err => console.error("Error cargando subcategorías:", err));
                        // Abrir modal
                        const productModal = new bootstrap.Modal(document.getElementById("productModal"));
                        productModal.show();

                        // Mock file Dropzone
                        if (p.foto) {
                            let mockFile = {
                                name: "Imagen actual",
                                size: 12345
                            };
                            dropzone.emit("addedfile", mockFile);
                            dropzone.emit("thumbnail", mockFile, `/storage/${p.foto}`);
                            dropzone.emit("complete", mockFile);
                            dropzone.files.push(mockFile);

                            const dzMsg = document.querySelector("#dropzone-basic .dz-message");
                            if (dzMsg) dzMsg.style.display = "none";
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showToast("Error cargando producto para editar: " + err.message, "danger");
                    });
            }

            // ==========================
            // Guardar producto
            // ==========================
            document.getElementById("product-form").addEventListener("submit", function(e) {
                e.preventDefault();

                const id = document.getElementById("product-id").value;
                const url = id ? `/productos/update/${id}` : `/productos/store`;

                const formData = new FormData();
                formData.append("codigo", document.getElementById("codigo").value);
                formData.append("nombre", document.getElementById("nombre").value);
                formData.append("descripcion", document.getElementById("descripcion").value);
                formData.append("marca", document.getElementById("marca").value);
                formData.append("modelo", document.getElementById("modelo").value);
                formData.append("origen", document.getElementById("origen").value);
                formData.append("precio", document.getElementById("precio").value);
                formData.append("categoria_id", $("#categoria-select").val());
                formData.append("subcategoria_id", $("#subcategoria-select").val());
                formData.append("inventariable", $("#inventariable").val());

                // Solo agrega imagen si hay un archivo
                if (dropzone && dropzone.getAcceptedFiles().length > 0) {
                    formData.append("foto", dropzone.getAcceptedFiles()[0]);
                }

                Swal.fire({
                    title: id ? "¿Está seguro de actualizar este producto?" : "¿Registrar nuevo producto?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Sí, continuar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        showLoader("Guardando producto...");
                        fetch(url, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    showToast(data.message, "success");
                                    // Ocultar modal
                                    const modal = bootstrap.Modal.getInstance(document.getElementById("productModal"));
                                    if (modal) modal.hide();
                                    hideLoader();
                                    // Recargar tabla
                                    loadProducts(currentPage);
                                    // Limpiar Dropzone
                                    if (dropzone) dropzone.removeAllFiles();
                                } else {
                                    showToast(data.message || "Error al guardar producto", "danger");
                                    hideLoader();
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                showToast("Hubo un problema al guardar el producto.", "danger");
                                hideLoader();
                            });
                    }
                });
            });
            document.addEventListener("click", function(e) {
                if (e.target.closest(".btn-delete")) {
                    const id = e.target.closest(".btn-delete").dataset.id;

                    Swal.fire({
                        title: "¿Está seguro de eliminar este producto?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Sí, eliminar",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            showLoader("Eliminando producto...");
                            fetch(`/productos/delete/${id}`, {
                                    method: "POST",
                                    headers: {
                                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        showToast(data.message, "success");
                                        loadProducts(currentPage); // recargar tabla
                                    } else {
                                        showToast(data.message || "Error al eliminar producto", "danger");
                                    }
                                    hideLoader();
                                })
                                .catch(err => {
                                    console.error(err);
                                    showToast("Hubo un problema al eliminar el producto.", "danger");
                                    hideLoader();
                                });
                        }
                    });
                }
            });


            // ==========================
            // Inicializar Select2 con placeholder
            // ==========================
            $(categoriaSelect).select2({
                placeholder: "Seleccione una categoría",
                allowClear: true,
                width: '100%',
                dropdownParent: $("#productModal") // si está dentro de un modal
            });

            $(subcategoriaSelect).select2({
                placeholder: "Seleccione una subcategoría",
                allowClear: true,
                width: '100%',
                dropdownParent: $("#productModal")
            });

            // ==========================
            // Cargar categorías con fetch
            // ==========================
            fetch("/categorias/list")
                .then(res => res.json())
                .then(data => {
                    // Limpiar opciones actuales
                    categoriaSelect.innerHTML = '<option></option>'; // placeholder
                    data.forEach(cat => {
                        const option = new Option(cat.nombre, cat.id, false, false);
                        categoriaSelect.appendChild(option);
                    });

                    // Refrescar Select2 para mostrar nuevas opciones
                    $(categoriaSelect).trigger('change.select2');
                })
                .catch(err => console.error("Error cargando categorías:", err));

            // ==========================
            // Al cambiar categoría -> cargar subcategorías
            // ==========================
            $(categoriaSelect).on("change", function() {
                const categoriaId = this.value;

                // Limpiar subcategoría
                subcategoriaSelect.innerHTML = '<option></option>';
                $(subcategoriaSelect).val(null).trigger('change.select2');

                if (!categoriaId) return;

                fetch(`/subcategorias/byCategoria/${categoriaId}`)
                    .then(res => res.json())
                    .then(data => {
                        data.forEach(sub => {
                            const option = new Option(sub.nombre, sub.id, false, false);
                            subcategoriaSelect.appendChild(option);
                        });
                        // Refrescar Select2 de subcategorías
                        $(subcategoriaSelect).trigger('change.select2');
                    })
                    .catch(err => console.error("Error cargando subcategorías:", err));
            });

            // ==========================
            // Cargar tabla inicial
            // ==========================
            loadProducts(currentPage);

            window.__productosReload = () => {
                loadProducts(1);
            };
        };

        const handleProductoLoad = () => {
            const root = document.getElementById('products-table');
            if (!root) return;
            if (root.dataset.productoInit === '1') {
                if (typeof window.__productosReload === 'function') {
                    window.__productosReload();
                }
                return;
            }
            root.dataset.productoInit = '1';
            setupProductoPage();
        };

        document.addEventListener('turbo:load', handleProductoLoad);
        document.addEventListener('DOMContentLoaded', handleProductoLoad);
    </script>

</x-layout>
