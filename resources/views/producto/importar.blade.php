<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <!-- Scripts -->
        @vite([ 'resources/js/app.js'])
        <!-- End Navbar -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script>
        // Ajusta según tu app. Si no usas auth()->user(), pasa la empresa por $empresa->id.
        window.EMPRESA_ID = {{ auth()->user()->id_empresa ?? 'null' }};
        </script>
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card-body">
                    <!-- ======= Importador masivo de productos ======= -->
                    <div id="importador-productos">

                        <!-- Toolbar -->
                        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                        <h5 class="mb-0 me-auto fw-bold">Importación masiva de productos</h5>
                    
                        <button id="btn-descargar-plantilla" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-download me-1"></i> Descargar plantilla
                        </button>
                    
                        <label class="btn btn-sm btn-outline-secondary mb-0">
                            <input id="file-input" type="file" accept=".xlsx,.xls,.csv" hidden />
                            <i class="fa fa-upload me-1"></i> Seleccionar archivo
                        </label>
                    
                        <button id="btn-limpiar" class="btn btn-sm btn-outline-dark">
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
                    </style>
                    
                    <!-- ======= Dependencias (SheetJS para leer Excel) ======= -->
                    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
                    
                    <!-- ======= Lógica ======= -->
                    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
                    <script>
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
                        { key: 'unidad',         header: 'UNIDAD' },               // → unidad_medida_id
                        { key: 'tipo_producto',  header: 'TIPO PRODUCTO' },        // → tipo_producto_id
                        { key: 'categoria',      header: 'CATEGORÍA' },            // → categoria_id
                        { key: 'subcategoria',   header: 'SUBCATEGORÍA' },         // → subcategoria_id
                        { key: 'tipo_precio',    header: 'TIPO PRECIO' },          // → tipo_precio_id
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
                            datos = [];
                            archivoNombre.textContent = 'Sin archivo';
                            render();
                        });

                        btnDescargar.addEventListener('click', () => {
                            const headers = columnas.map(c => c.header);
                            const ejemplo = columnas.map(c => {
                                switch (c.key) {
                                case 'codigo':        return '';
                                case 'nombre':        return '';
                                case 'unidad':        return '';
                                case 'tipo_producto': return '';
                                case 'categoria':     return '';
                                case 'subcategoria':  return '';
                                case 'tipo_precio':   return '';
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
                        });


                        btnGuardar.addEventListener('click', async () => {
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

                            // Deshabilita botón y muestra spinner
                            btnGuardar.disabled = true;
                            btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';

                            try {
                                // 👇 ÚNICO fetch, con id_empresa
                                const res = await fetch(urlGuardar, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    ...(csrfToken ? {'X-CSRF-TOKEN': csrfToken} : {})
                                },
                                body: JSON.stringify({
                                    id_empresa: window.EMPRESA_ID,  // <-- importante
                                    items: payload
                                })
                                });

                                // Manejo de errores HTTP
                                if (!res.ok) {
                                const t = await res.text();
                                throw new Error(t || `Error HTTP ${res.status}`);
                                }

                                const data = await res.json().catch(() => ({}));

                                if (data && data.ok === false && data.msg) {
                                // Respuesta válida pero con error lógico del back (p.ej. 422)
                                alert(`❌ ${data.msg}`);
                                console.error('Respuesta de back:', data);
                                return;
                                }

                                alert('Importación completada ✅\n' + JSON.stringify(data, null, 2));
                                datos = [];
                                render(); // refresca tabla y badges
                            } catch (err) {
                                console.error(err);
                                alert('No se pudo guardar. Revisa consola para más detalles.');
                            } finally {
                                btnGuardar.disabled = false;
                                btnGuardar.innerHTML = '<i class="fa fa-save me-1"></i> Guardar / Registrar';
                            }
                        });


                        // Render inicial
                        render();
                        })();
                    </script>

  
                </div>
            </div>
        </div>
    </main>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>