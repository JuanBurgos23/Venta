
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100">
        <!-- Scripts -->
        @vite([ 'resources/js/app.js'])
        <!-- End Navbar -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="venta-loader" id="venta-loader" aria-hidden="true">
              <div class="venta-loader-card">
                  <svg stroke="hsl(228, 97%, 42%)" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="venta-loader-icon" aria-label="Cargando" role="img"><g><circle cx="12" cy="12" r="9.5" fill="none" stroke-width="3" stroke-linecap="round"><animate attributeName="stroke-dasharray" dur="1.5s" calcMode="spline" values="0 150;42 150;42 150;42 150" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/><animate attributeName="stroke-dashoffset" dur="1.5s" calcMode="spline" values="0;-16;-59;-59" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/></circle><animateTransform attributeName="transform" type="rotate" dur="2s" values="0 12 12;360 12 12" repeatCount="indefinite"/></g></svg>
                  <div class="venta-loader-text" id="venta-loader-text">Cargando...</div>
              </div>
        </div>
        <script>
        // Ajusta según tu app. Si no usas auth()->user(), pasa la empresa por $empresa->id.
            window.EMPRESA_ID = {{ auth()->user()->id_empresa ?? 'null' }};
        </script>
        <div class="container-fluid p-3 importar-shell">
            <div class="col-12">
                <div class="card my-2">
                    <div class="card-body p-5">
                    <!-- ======= Importador masivo de productos ======= -->
                    <div id="importador-productos">

                        <!-- Toolbar -->
                        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                        <h5 class="mb-0 me-auto fw-bold">Importación masiva de productos</h5>
                        <div class="alert alert-primary" role="alert">
                            <p>Aquí puedes registrar todos tus productos de una sola vez subiendo un archivo Excel en el formato establecido, primera descarga la plantilla de ejemplo
                            <hr>
                            <p class="mb-0">Una vez cargado tu archivo con tus productos estos se visualizarán en la tabla inferior, puedes cargar un nuevo archivo y la tabla se cargará nuevamente. Una vez valides tus productos puedes guardarlos para
                                poder realizar ventas.</p>
                            <hr>
                            <p class="mb-0">
                                <strong>Nota:</strong><br>
                                - Tome en cuenta que debe marcar si los productos que se esta improtando son inventariables y tambien especificar el tipo de producto<br>

                            </p>
                        </div>
                        <!-- Controles globales -->
                        <div class="d-flex flex-wrap align-items-center gap-3 me-3">

                            <!-- Tipo de productos -->
                            <div class="d-flex align-items-center">
                            <label for="tipo-producto-select" class="me-2 mb-0 small text-muted">Tipo de productos</label>
                            <select id="tipo-producto-select" class="form-select form-select-sm" style="min-width:220px">
                                <option value="1" selected>Producto terminado</option>
                                <option value="2">Materia prima</option>
                            </select>
                            </div>
                        
                            <!-- Inventariables -->
                            <div class="form-check form-switch d-flex align-items-center">
                            <input class="form-check-input" type="checkbox" id="inventariable-switch" checked>
                            <label class="form-check-label ms-2 small" for="inventariable-switch">
                                Inventariables
                                <span id="inventariable-badge" class="badge bg-success ms-1">Sí</span>
                            </label>
                            </div>
                        
                        </div>
  
                    
                        <button id="btn-descargar-plantilla" class="btn btn-sm btn-primary">
                            <i class="fa fa-download me-1"></i> Descargar plantilla
                        </button>
                        
                    
                        <label class="btn btn-sm btn-secondary mb-0">
                            <input id="file-input" type="file" accept=".xlsx,.xls,.csv" hidden />
                            <i class="fa fa-upload me-1"></i> Seleccionar archivo
                        </label>
                    
                        <button id="btn-limpiar" class="btn btn-sm btn-dark">
                            <i class="fa fa-eraser me-1"></i> Limpiar
                        </button>
                    
                        <button id="btn-guardar" class="btn btn-sm btn-success" disabled>
                            <i class="fa fa-save me-1"></i> Guardar / Registrar
                        </button>
                        </div>
                    
                        <!-- Zona de arrastre -->
                        <div id="dropzone" class="border border-2 border-dashed rounded p-4 text-center mb-3 bg-light">
                        <div class="small text-muted">Arrastra tu archivo aquí o usa “Seleccionar archivo”.</div>
                        <div class="mt-2"><span class="badge bg-secondary">.xlsx</span> <span class="badge bg-secondary">.xls</span> <span class="badge bg-secondary">.csv</span></div>
                        </div>
                    
                        <!-- Resumen / Estado -->
                        <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
                        <div class="badge bg-primary" id="badge-total">Total: 0</div>
                        <div class="badge bg-success" id="badge-validas">Válidas: 0</div>
                        <div class="badge bg-danger" id="badge-erroneas">Con errores: 0</div>
                        <div class="ms-auto small text-muted" id="archivo-nombre">Sin archivo</div>
                        </div>
                    
                        <!-- Tabla editable -->
                        <div class="table-responsive" style="max-height: 55vh; overflow: auto;">
                            <table id="tabla-preview" class="table table-sm table-hover align-middle">
                                <thead id="thead-preview" class="table-secondary position-sticky top-0"></thead>
                                <tbody id="tbody-preview"></tbody>
                              </table>
                        </div>
                    
                        <!-- Pie con ayuda -->
                        <div class="mt-3 small text-muted">
                        <strong>Notas:</strong> Los campos numéricos aceptan decimales con punto. La fecha de vencimiento admite formatos
                        <code>YYYY-MM-DD</code> o <code>DD/MM/YYYY</code>. Edita directamente en las celdas antes de guardar.
                        </div>
                    </div>
                    
                    <!-- ======= Estilos locales ======= -->
                    <style>
                        #dropzone {
                        border-style: dashed !important;
                        transition: background-color .2s ease, border-color .2s ease;
                        }
                        #dropzone.dragover {
                        background-color: #e9f5ff;
                        border-color: #0d6efd !important;
                        }
                        #tabla-preview td[contenteditable="true"] {
                        outline: none;
                        cursor: text;
                        }
                        #tabla-preview td.is-invalid {
                        background: #ffe8e8 !important;
                        border-bottom: 1px solid #dc3545 !important;
                        }
                        #tabla-preview td.is-warning {
                        background: #fff7e6 !important;
                        border-bottom: 1px dashed #fd7e14 !important;
                        }
                        .action-btn {
                        border: none;
                        background: transparent;
                        padding: .25rem .35rem;
                        }
                        .action-btn:hover { opacity: .8; }
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
                    
                    <!-- ======= Dependencias (SheetJS para leer Excel) ======= -->
                    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
                    
                    <!-- ======= Lógica ======= -->
                    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
                    <script>
                        const setupProductoImportar = () => {
                        (function () {
                        // ========== Configuración de columnas (alineado al back) ==========
                        const columnas = [
                        { key: 'codigo',         header: 'CÓDIGO',        required: true },
                        { key: 'nombre',         header: 'NOMBRE',        required: true },

                        { key: 'descripcion',    header: 'DESCRIPCIÓN' },
                        { key: 'marca',          header: 'MARCA' },
                        { key: 'modelo',         header: 'MODELO' },
                        { key: 'origen',         header: 'ORIGEN' },

                        // Catálogos por nombre (el back los resuelve a IDs)
                        { key: 'unidad',         header: 'UNIDAD' },               // → unidad_medida_id      // → tipo_producto_id
                        { key: 'categoria',      header: 'CATEGORÍA' },            // → categoria_id
                        { key: 'subcategoria',   header: 'SUBCATEGORÍA' },         // → subcategoria_id
                        { key: 'proveedor',      header: 'PROVEEDOR' },            // → proveedor_id

                        // Económicos usados en producto:
                        { key: 'precio',         header: 'PRECIO', type: 'number', min: 0 },
                        ];


                        // Endpoint (Laravel)
                        const urlGuardar = "{{ route('productos.importar.store', [], false) ?? '/api/productos/importar' }}";
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                        // ========== Referencias DOM ==========
                        const fileInput     = document.getElementById('file-input');
                        const dropzone      = document.getElementById('dropzone');
                        const thead         = document.getElementById('thead-preview');
                        const tbody         = document.getElementById('tbody-preview');
                        const btnDescargar  = document.getElementById('btn-descargar-plantilla');
                        const btnGuardar    = document.getElementById('btn-guardar');
                        const btnLimpiar    = document.getElementById('btn-limpiar');
                        const badgeTotal    = document.getElementById('badge-total');
                        const badgeValidas  = document.getElementById('badge-validas');
                        const badgeErroneas = document.getElementById('badge-erroneas');
                        const archivoNombre = document.getElementById('archivo-nombre');
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

                        let datos = []; // array de objetos plano

                        // ========== Helpers ==========
                        function toNumber(v) {
                            if (v === '' || v == null) return null;
                            const n = Number(String(v).toString().replace(',', '.'));
                            return Number.isFinite(n) ? n : NaN;
                        }
                        function parseDateFlexible(v) {
                            if (!v) return null;
                            if (v instanceof Date) return v.toISOString().slice(0,10);
                            const s = String(v).trim();
                            // YYYY-MM-DD
                            if (/^\d{4}-\d{2}-\d{2}$/.test(s)) return s;
                            // DD/MM/YYYY
                            const m = s.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
                            if (m) {
                            const [_, d, mo, y] = m;
                            return `${y}-${mo.padStart(2,'0')}-${d.padStart(2,'0')}`;
                            }
                            return null;
                        }
                        function validarRow(row) {
                            const errores = {};
                            for (const col of columnas) {
                                const val = row[col.key];
                                if (col.required && (!val || String(val).trim() === '')) {
                                errores[col.key] = 'Requerido';
                                continue;
                                }
                                if (col.type === 'number') {
                                const n = toNumber(val);
                                if (val !== null && val !== '' && Number.isNaN(n)) {
                                    errores[col.key] = 'Numérico';
                                    continue;
                                }
                                if (n != null && col.min != null && n < col.min) {
                                    errores[col.key] = `>= ${col.min}`;
                                    continue;
                                }
                                }
                        }
                        return errores;
                        }

                        function refrescarBadges() {
                            const tot = datos.length;
                            let err = 0;
                            for (const r of datos) if (Object.keys(r.__errors || {}).length) err++;
                            const val = tot - err;
                            badgeTotal.textContent   = `Total: ${tot}`;
                            badgeValidas.textContent = `Válidas: ${val < 0 ? 0 : val}`;
                            badgeErroneas.textContent= `Con errores: ${err}`;
                            btnGuardar.disabled = (tot === 0 || err > 0);
                        }

                        // ========== Render Encabezado Dinámico ==========
                        function renderHeader() {
                            thead.innerHTML = '';
                            const tr = document.createElement('tr');

                            const thIndex = document.createElement('th');
                            thIndex.style.minWidth = '60px';
                            thIndex.textContent = '#';
                            tr.appendChild(thIndex);

                            for (const col of columnas) {
                            const th = document.createElement('th');
                            th.textContent = col.header;
                            tr.appendChild(th);
                            }

                            const thAcc = document.createElement('th');
                            thAcc.style.minWidth = '110px';
                            thAcc.textContent = 'Acciones';
                            tr.appendChild(thAcc);

                            thead.appendChild(tr);
                        }

                        // ========== Render Filas ==========
                        function crearCeldaEditable(value, rowIndex, key) {
                            const td = document.createElement('td');
                            td.contentEditable = "true";
                            td.textContent = value ?? '';
                            td.addEventListener('blur', () => {
                            datos[rowIndex][key] = td.textContent.trim();
                            datos[rowIndex].__errors = validarRow(datos[rowIndex]);
                            pintarFila(rowIndex);
                            refrescarBadges();
                            });
                            return td;
                        }
                        function pintarFila(i) {
                            const tr = tbody.querySelector(`tr[data-index="${i}"]`);
                            if (!tr) return;
                            const row = datos[i];
                            const errors = row.__errors || {};
                            // children: [#, ...columns, acciones]
                            [...tr.children].forEach((td, idx) => {
                            if (idx === 0 || idx === tr.children.length - 1) return;
                            const key = columnas[idx-1]?.key;
                            td.classList.remove('is-invalid','is-warning');
                            if (key && errors[key]) td.classList.add('is-invalid');
                            });
                        }
                        function renderBody() {
                            tbody.innerHTML = '';
                            datos.forEach((row, i) => {
                            const tr = document.createElement('tr');
                            tr.dataset.index = i;

                            const tdIndex = document.createElement('td');
                            tdIndex.textContent = i + 1;
                            tdIndex.className = 'text-muted';
                            tr.appendChild(tdIndex);

                            for (const col of columnas) {
                                tr.appendChild(crearCeldaEditable(row[col.key], i, col.key));
                            }

                            const tdAcc = document.createElement('td');
                            tdAcc.innerHTML = `
                                <button class="action-btn text-danger" title="Eliminar" data-action="del"><i class="fa fa-trash"></i></button>
                                <button class="action-btn text-primary" title="Duplicar" data-action="dup"><i class="fa fa-copy"></i></button>
                            `;
                            tdAcc.addEventListener('click', (e) => {
                                const btn = e.target.closest('button');
                                if (!btn) return;
                                const action = btn.dataset.action;
                                if (action === 'del') {
                                datos.splice(i,1);
                                renderBody();
                                refrescarBadges();
                                }
                                if (action === 'dup') {
                                const copy = { ...datos[i] };
                                delete copy.__errors;
                                datos.splice(i+1, 0, copy);
                                datos[i+1].__errors = validarRow(datos[i+1]);
                                renderBody();
                                refrescarBadges();
                                }
                            });
                            tr.appendChild(tdAcc);

                            tbody.appendChild(tr);
                            pintarFila(i);
                            });
                        }
                        function render() {
                            renderHeader();
                            renderBody();
                            refrescarBadges();
                        }

                        // ========== Lectura de archivo ==========
                        function leerArchivo(file) {
                            showLoader('Cargando archivo...');
                            archivoNombre.textContent = file.name;
                            const reader = new FileReader();
                            reader.onload = (e) => {
                            const data = new Uint8Array(e.target.result);
                            const workbook = XLSX.read(data, { type: 'array' });
                            const sheet = workbook.Sheets[workbook.SheetNames[0]];
                            let rows = XLSX.utils.sheet_to_json(sheet, { defval: '', raw: true });

                            // Normaliza headers esperados -> admite mayúsculas/minúsculas
                            const mapKeys = {};
                            const lowerToKey = {};
                            columnas.forEach(c => lowerToKey[c.header.toLowerCase()] = c.key);

                            if (rows.length > 0) {
                                const first = rows[0];
                                Object.keys(first).forEach(h => {
                                const key = lowerToKey[String(h).toLowerCase().trim()];
                                if (key) mapKeys[h] = key;
                                });
                            }

                            datos = rows.map(r => {
                                const obj = {};
                                columnas.forEach(c => {
                                const from = Object.keys(mapKeys).find(h => mapKeys[h] === c.key);
                                obj[c.key] = from ? r[from] : '';
                                });
                                obj.__errors = validarRow(obj);
                                return obj;
                            });

                            render();
                            hideLoader();
                            };
                            reader.readAsArrayBuffer(file);
                        }

                        // ========== Drag & drop / eventos ==========
                        dropzone.addEventListener('dragover', (e) => { e.preventDefault(); dropzone.classList.add('dragover'); });
                        dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
                        dropzone.addEventListener('drop', (e) => {
                            e.preventDefault();
                            dropzone.classList.remove('dragover');
                            const file = e.dataTransfer.files?.[0];
                            if (file) leerArchivo(file);
                        });

                        fileInput.addEventListener('change', (e) => {
                            const file = e.target.files?.[0];
                            if (file) leerArchivo(file);
                            fileInput.value = '';
                        });

                        btnLimpiar.addEventListener('click', () => {
                            showLoader('Limpiando...');
                            datos = [];
                            archivoNombre.textContent = 'Sin archivo';
                            render();
                            hideLoader();
                        });

                        btnDescargar.addEventListener('click', () => {
                            showLoader('Generando plantilla...');
                            const headers = columnas.map(c => c.header);
                            const ejemplo = columnas.map(c => {
                                switch (c.key) {
                                case 'codigo':        return '';
                                case 'nombre':        return '';
                                case 'unidad':        return '';
                                case 'categoria':     return '';
                                case 'subcategoria':  return '';
                                case 'proveedor':     return '';
                                case 'precio':        return '';
                                default:              return '';
                                }
                            });

                            const ws = XLSX.utils.aoa_to_sheet([headers, ejemplo]);
                            const wb = XLSX.utils.book_new();
                            XLSX.utils.book_append_sheet(wb, ws, 'Plantilla');
                            const wbout = XLSX.write(wb, { bookType: 'xlsx', type: 'array' });
                            const blob = new Blob([wbout], { type: 'application/octet-stream' });
                            const a = document.createElement('a');
                            a.href = URL.createObjectURL(blob);
                            a.download = 'Plantilla_Productos.xlsx';
                            a.click();
                            URL.revokeObjectURL(a.href);
                            hideLoader();
                        });


                        btnGuardar.addEventListener('click', async () => {
                            if (!Array.isArray(datos) || datos.length === 0) {
                                await Swal.fire({
                                    icon: 'warning',
                                    title: 'Nada que guardar',
                                    text: 'Primero importa o agrega al menos un producto.',
                                    confirmButtonText: 'Entendido'
                                });
                                return;
                            }

                            // Leer select y switch antes de enviar
                            const tipoProductoGlobal  = String(tipoProductoSelect.value || '1'); // "1" o "2"
                            const inventariableGlobal = inventariableSwitch.checked ? 1 : 0;

                            // Confirmación con resumen
                            const confirm = await Swal.fire({
                                title: '¿Deseas guardar la importación?',
                                html: `
                                    <div class="text-start">
                                        <p>Se enviarán <b>${datos.length}</b> registros al servidor.</p>
                                        <p><b>Tipo de productos:</b> ${tipoProductoGlobal === '1' ? 'Producto terminado' : 'Materia prima'}</p>
                                        <p><b>Inventariables:</b> ${inventariableGlobal ? 'Sí' : 'No'}</p>
                                    </div>
                                `,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Sí, guardar',
                                cancelButtonText: 'Cancelar'
                            });

                            if (!confirm.isConfirmed) return;

                            // Prepara payload limpio
                            const payload = datos.map(r => {
                                const clean = {};
                                columnas.forEach(col => {
                                    let v = r[col.key];
                                    if (col.type === 'number') {
                                        const n = toNumber(v);
                                        v = (v === '' || v == null) ? null : (Number.isFinite(n) ? n : null);
                                    }
                                    clean[col.key] = v;
                                });
                                return clean;
                            });

                            // Deshabilita botón y spinner
                            btnGuardar.disabled = true;
                            btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

                            // Loader modal
                            showLoader('Guardando...');
                            const loader = Swal.fire({
                                title: 'Guardando...',
                                html: 'Estamos registrando tus productos. Por favor espera.',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                didOpen: () => Swal.showLoading()
                            });

                            try {
                                 const res = await fetch(urlGuardar, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'Accept': 'application/json',
                                        ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {})
                                    },
                                    body: JSON.stringify({
                                        id_empresa: window.EMPRESA_ID,
                                        tipo_producto_global: tipoProductoGlobal,
                                        inventariable_global: inventariableGlobal,
                                        items: payload
                                    })
                                });

                                if (!res.ok) {
                                    const t = await res.text();
                                    throw new Error(t || `Error HTTP ${res.status}`);
                                }

                                let data = {};
                                try { data = await res.json(); } catch { /* deja data vacío */ }

                                Swal.close(); // cierra loader

                                if (data && data.ok === false) {
                                    await Swal.fire({
                                        icon: 'error',
                                        title: 'No se pudo guardar',
                                        text: data.msg || 'El servidor reportó un error al registrar.',
                                    });
                                    return;
                                }

                                const htmlResumen = `
                                    <div class="text-start">
                                        <p><b>Registros enviados:</b> ${payload.length}</p>
                                        <p><b>Tipo de productos:</b> ${tipoProductoGlobal === '1' ? 'Producto terminado' : 'Materia prima'}</p>
                                        <p><b>Inventariables:</b> ${inventariableGlobal ? 'Sí' : 'No'}</p>
                                        ${typeof data.insertados !== 'undefined' ? `<p><b>Insertados:</b> ${data.insertados}</p>` : ''}
                                        ${typeof data.actualizados !== 'undefined' ? `<p><b>Actualizados:</b> ${data.actualizados}</p>` : ''}
                                        ${Array.isArray(data.errores) && data.errores.length
                                            ? `<p class="text-danger"><b>Errores:</b> ${data.errores.length}</p>`
                                            : ''}
                                    </div>
                                `.trim();
                                hideLoader();
                                await Swal.fire({
                                    icon: 'success',
                                    title: 'Importación completada',
                                    html: htmlResumen || 'Se registraron los productos correctamente.',
                                    confirmButtonText: 'Listo'
                                });

                                // Limpia y refresca
                                datos = [];
                                render();

                            } catch (err) {
                                console.error(err);
                                Swal.close();
                                hideLoader();
                                await Swal.fire({
                                    icon: 'error',
                                    title: 'Error al guardar',
                                    html: `<pre style="white-space:pre-wrap;text-align:left">${(err && err.message) || err}</pre>`
                                });
                            } finally {
                                btnGuardar.disabled = false;
                                btnGuardar.innerHTML = '<i class="fa fa-save me-1"></i> Guardar / Registrar';
                                hideLoader();
                            }
                        });




                            // Render inicial
                            render();
                        })();
                        const tipoProductoSelect   = document.getElementById('tipo-producto-select');
                        const inventariableSwitch  = document.getElementById('inventariable-switch');
                        const inventariableBadge   = document.getElementById('inventariable-badge');

                        inventariableSwitch.addEventListener('change', () => {
                        if (inventariableSwitch.checked) {
                            inventariableBadge.textContent = 'Sí';
                            inventariableBadge.classList.remove('bg-danger');
                            inventariableBadge.classList.add('bg-success');
                        } else {
                            inventariableBadge.textContent = 'No';
                            inventariableBadge.classList.remove('bg-success');
                            inventariableBadge.classList.add('bg-danger');
                        }
                        });
                        };

                        const handleProductoImportarLoad = () => {
                            const root = document.getElementById('importador-productos');
                            if (!root) return;
                            if (root.dataset.productoImportarInit === '1') return;
                            root.dataset.productoImportarInit = '1';
                            setupProductoImportar();
                        };

                        document.addEventListener('turbo:load', handleProductoImportarLoad);
                        document.addEventListener('DOMContentLoaded', handleProductoImportarLoad);
                    </script>

  
                    </div>
                </div>
            </div>
        </div>
    </main>
    <style>
        .importar-shell .card-body {
            padding: 1rem 1.25rem;
        }

        #importador-productos {
            padding: 0.25rem;
        }

        #tipo-producto-select {
            border-radius: .5rem;
            }
            .form-check-input:checked {
            background-color: #198754; /* verde suave para el switch ON */
            border-color: #198754;
            }
    </style>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>
