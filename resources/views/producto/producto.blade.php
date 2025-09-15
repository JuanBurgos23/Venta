<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        @vite(['resources/js/app.js'])

        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-primary text-white">
                        <h5 class="mb-0">Registrar Producto</h5>
                    </div>
                    <div class="card-body">
                        <form id="formProducto" enctype="multipart/form-data">
                            @csrf

                            <!-- 🔹 Sección 1: Datos Básicos -->
                            <div class="section-form mb-4">
                                <h6 class="section-title">📌 Datos Básicos</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            placeholder="Ej: Laptop Dell Inspiron" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="codigo" class="form-label">Código</label>
                                        <input type="text" class="form-control" id="codigo" name="codigo"
                                            placeholder="Ej: PRD-001" required>
                                    </div>
                                </div>
                            </div>

                            <!-- 🔹 Sección 2: Clasificación -->
                            <div class="section-form mb-4">
                                <h6 class="section-title">📂 Clasificación</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="categoria_id" class="form-label">Categoría</label>
                                        <select class="form-select" id="categoria_id" name="categoria_id" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subcategoria_id" class="form-label">Subcategoría</label>
                                        <select class="form-select" id="subcategoria_id" name="subcategoria_id" required>
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tipo_producto_id" class="form-label">Tipo de Producto</label>
                                        <select class="form-select" id="tipo_producto_id" name="tipo_producto_id" >
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="unidad_medida_id" class="form-label">Unidad de Medida</label>
                                        <select class="form-select" id="unidad_medida_id" name="unidad_medida_id" >
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- 🔹 Sección 3: Detalles -->
                            <div class="section-form mb-4">
                                <h6 class="section-title">📝 Detalles del Producto</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="marca" class="form-label">Marca</label>
                                        <input type="text" class="form-control" id="marca" name="marca"
                                            placeholder="Ej: Dell">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="modelo" class="form-label">Modelo</label>
                                        <input type="text" class="form-control" id="modelo" name="modelo"
                                            placeholder="Ej: Inspiron 15">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="origen" class="form-label">Origen</label>
                                        <input type="text" class="form-control" id="origen" name="origen"
                                            placeholder="Ej: USA">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="tipo_precio_id" class="form-label">Tipo de Precio</label>
                                        <select class="form-select" id="tipo_precio_id" name="tipo_precio_id" >
                                            <option value="">Seleccione...</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                            placeholder="Escriba una breve descripción"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- 🔹 Sección 4: Inventario -->
                            <div class="section-form mb-4">
                                <h6 class="section-title">📦 Inventario</h6>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select class="form-select" id="estado" name="estado" required>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inventariable" class="form-label">¿Inventariable?</label>
                                        <select class="form-select" id="inventariable" name="inventariable" required>
                                            <option value="1">Sí</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- 🔹 Sección 5: Imagen -->
                            <div class="section-form mb-4">
                                <h6 class="section-title">🖼️ Imagen del Producto</h6>
                                <div class="image-upload text-center">
                                    <input type="file" class="form-control d-none" id="foto" name="foto"
                                        accept="image/*">
                                    <label for="foto" class="btn btn-outline-primary">Subir Imagen</label>
                                    <div class="preview-container mt-3">
                                        <img id="previewImagen" src="" class="img-thumbnail d-none"
                                            style="max-height: 200px;">
                                        <button type="button" id="removeImagen"
                                            class="btn btn-sm btn-danger mt-2 d-none">Quitar Imagen</button>
                                    </div>
                                </div>
                            </div>

                            <!-- 🔹 Botones -->
                            <div class="mt-4 d-flex justify-content-end">
                                <button type="reset" class="btn btn-light border me-2">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Guardar Producto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Estilos personalizados -->
    <style>
        .section-form {
            padding: 20px;
            border-radius: 12px;

        }

        .section-title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 15px;
            color: #344767;
            border-left: 4px solid #5e72e4;
            padding-left: 8px;
        }

        .image-upload {
            border: 2px dashed #5e72e4;
            padding: 20px;
            border-radius: 12px;

        }

        .image-upload:hover {

            cursor: pointer;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // -------------------- Imagen Previsualización --------------------
            const inputFoto = document.getElementById("foto");
            const preview = document.getElementById("previewImagen");
            const removeBtn = document.getElementById("removeImagen");

            if (inputFoto) {
                inputFoto.addEventListener("change", () => {
                    const file = inputFoto.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = e => {
                            preview.src = e.target.result;
                            preview.classList.remove("d-none");
                            removeBtn.classList.remove("d-none");
                        };
                        reader.readAsDataURL(file);
                    }
                });

                removeBtn.addEventListener("click", () => {
                    inputFoto.value = "";
                    preview.src = "";
                    preview.classList.add("d-none");
                    removeBtn.classList.add("d-none");
                });
            }

            // -------------------- Cargar datos dinámicos --------------------
            const categoriaSelect = document.getElementById("categoria_id");
            const subcategoriaSelect = document.getElementById("subcategoria_id");
            const tipoProductoSelect = document.getElementById("tipo_producto_id");
            const unidadMedidaSelect = document.getElementById("unidad_medida_id");
            const tipoPrecioSelect = document.getElementById("tipo_precio_id");

            // Función genérica para cargar datos en un select
            async function cargarOpciones(url, select, placeholder = "Seleccione...") {
                try {
                    const response = await fetch(url);
                    const data = await response.json();

                    select.innerHTML = `<option value="">${placeholder}</option>`;
                    data.forEach(item => {
                        select.innerHTML += `<option value="${item.id}">${item.nombre}</option>`;
                    });
                } catch (error) {
                    console.error("Error cargando datos:", error);
                }
            }

            // 🔹 Inicializar selects principales
            cargarOpciones("/api/categorias", categoriaSelect, "Seleccione una categoría");
            cargarOpciones("/api/tipos-producto", tipoProductoSelect, "Seleccione un tipo de producto");
            cargarOpciones("/api/unidades-medida", unidadMedidaSelect, "Seleccione una unidad");
            cargarOpciones("/api/tipos-precio", tipoPrecioSelect, "Seleccione un tipo de precio");

            // 🔹 Cargar subcategorías dinámicamente al seleccionar categoría
            if (categoriaSelect && subcategoriaSelect) {
                categoriaSelect.addEventListener("change", async (e) => {
                    const categoriaId = e.target.value;
                    if (categoriaId) {
                        await cargarOpciones(`/api/subcategorias/${categoriaId}`, subcategoriaSelect, "Seleccione una subcategoría");
                    } else {
                        subcategoriaSelect.innerHTML = `<option value="">Seleccione una subcategoría</option>`;
                    }
                });
            }
        });
        document.addEventListener("DOMContentLoaded", () => {
            const form = document.getElementById("formProducto");

            if (form) {
                form.addEventListener("submit", async (e) => {
                    e.preventDefault();

                    const formData = new FormData(form);

                    try {
                        const response = await fetch("/productos", {
                            method: "POST",
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                            }
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            showToast(data.message, "success");

                            // Opcional: limpiar formulario después de guardar
                            form.reset();
                            const preview = document.getElementById("previewImagen");
                            const removeBtn = document.getElementById("removeImagen");
                            if (preview) preview.classList.add("d-none");
                            if (removeBtn) removeBtn.classList.add("d-none");
                        } else {
                            let msg = data.message || "Error al registrar el producto.";
                            showToast(msg, "danger");
                        }
                    } catch (error) {
                        console.error("Error:", error);
                        showToast("Error inesperado al guardar el producto.", "danger");
                    }
                });
            }
        });

        // 👉 Tu función de toast ya definida
        function showToast(message, type = "primary") {
            const toastEl = document.querySelector(".bs-toast");
            toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
            toastEl.querySelector(".toast-body").textContent = message;
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    </script>
</x-layout>