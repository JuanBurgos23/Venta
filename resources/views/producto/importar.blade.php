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
                            <thead class="table-secondary position-sticky top-0">
                            <tr>
                                <th style="min-width: 60px;">#</th>
                                <th>CÓDIGO</th>
                                <th>NOMBRE</th>
                                <th>CATEGORÍA</th>
                                <th>UNIDAD</th>
                                <th class="text-end">COSTO</th>
                                <th class="text-end">P. MENOR</th>
                                <th class="text-end">P. MAYOR</th>
                                <th class="text-end">STOCK</th>
                                <th>LOTE</th>
                                <th>F. VENC.</th>
                                <th style="min-width: 110px;">Acciones</th>
                            </tr>
                            </thead>
                            <tbody id="tbody-preview">
                            <!-- filas dinámicas -->
                            </tbody>
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
                    <script>
                    (function () {
                        // ------------ Configuración ----------
                        const columnas = [
                        { key: 'codigo', header: 'CÓDIGO', required: true },
                        { key: 'nombre', header: 'NOMBRE', required: true },
                        { key: 'categoria', header: 'CATEGORÍA' },
                        { key: 'unidad', header: 'UNIDAD' },
                        { key: 'costo', header: 'COSTO', type: 'number', min: 0 },
                        { key: 'precio_menor', header: 'P. MENOR', type: 'number', min: 0 },
                        { key: 'precio_mayor', header: 'P. MAYOR', type: 'number', min: 0 },
                        { key: 'stock', header: 'STOCK', type: 'number', min: 0 },
                        { key: 'lote', header: 'LOTE' },
                        { key: 'fecha_venc', header: 'F. VENC.' },
                        ];
                    
                        // Ajusta esta URL a tu endpoint (Laravel)
                        const urlGuardar = "{{ route('productos.importar.store', [], false) ?? '/api/productos/importar' }}";
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    
                        // ------------ Referencias DOM ----------
                        const fileInput = document.getElementById('file-input');
                        const dropzone = document.getElementById('dropzone');
                        const tbody = document.getElementById('tbody-preview');
                        const btnDescargar = document.getElementById('btn-descargar-plantilla');
                        const btnGuardar = document.getElementById('btn-guardar');
                        const btnLimpiar = document.getElementById('btn-limpiar');
                        const badgeTotal = document.getElementById('badge-total');
                        const badgeValidas = document.getElementById('badge-validas');
                        const badgeErroneas = document.getElementById('badge-erroneas');
                        const archivoNombre = document.getElementById('archivo-nombre');
                    
                        let datos = []; // array de objetos plano
                    
                        // ------------ Utilidades ----------
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
                            const iso = `${y}-${mo.padStart(2,'0')}-${d.padStart(2,'0')}`;
                            return iso;
                        }
                        return null;
                        }
                        function validarRow(row) {
                        let errores = {};
                        columnas.forEach(col => {
                            const val = row[col.key];
                            if (col.required && (!val || String(val).trim() === '')) {
                            errores[col.key] = 'Requerido';
                            return;
                            }
                            if (col.type === 'number') {
                            const n = toNumber(val);
                            if (val !== null && val !== '' && Number.isNaN(n)) {
                                errores[col.key] = 'Numérico';
                                return;
                            }
                            if (n != null && col.min != null && n < col.min) {
                                errores[col.key] = `>= ${col.min}`;
                                return;
                            }
                            }
                            if (col.key === 'fecha_venc' && val) {
                            const iso = parseDateFlexible(val);
                            if (!iso) errores[col.key] = 'Fecha inválida';
                            else row[col.key] = iso; // normaliza
                            }
                            // Precio mayor < menor: warning, no error
                            if (col.key === 'precio_mayor') {
                            const pm = toNumber(row.precio_mayor);
                            const pn = toNumber(row.precio_menor);
                            if (Number.isFinite(pm) && Number.isFinite(pn) && pm < pn) {
                                errores.__warning = 'P. mayor < P. menor';
                            }
                            }
                        });
                        return errores;
                        }
                        function refrescarBadges() {
                        const tot = datos.length;
                        let err = 0;
                        datos.forEach(r => { if (Object.keys(r.__errors||{}).length && !r.__errors.__warning) err++; if (r.__errors && r.__errors.__warning && Object.keys(r.__errors).length>1) err++; });
                        const val = tot - err;
                        badgeTotal.textContent = `Total: ${tot}`;
                        badgeValidas.textContent = `Válidas: ${val < 0 ? 0 : val}`;
                        badgeErroneas.textContent = `Con errores: ${err}`;
                        btnGuardar.disabled = (tot === 0 || err > 0);
                        }
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
                        [...tr.children].forEach((td, idx) => {
                            if (idx === 0 || idx === tr.children.length - 1) return; // salta # y acciones
                            const key = columnas[idx-1]?.key;
                            td.classList.remove('is-invalid','is-warning');
                            if (key && errors[key]) td.classList.add('is-invalid');
                            if (errors.__warning && (!errors[key] || key==='precio_mayor')) td.classList.add('is-warning');
                        });
                        }
                        function render() {
                        tbody.innerHTML = '';
                        datos.forEach((row, i) => {
                            const tr = document.createElement('tr');
                            tr.dataset.index = i;
                    
                            // #
                            const tdIndex = document.createElement('td');
                            tdIndex.textContent = i + 1;
                            tdIndex.className = 'text-muted';
                            tr.appendChild(tdIndex);
                    
                            // celdas editables
                            columnas.forEach(col => {
                            tr.appendChild(crearCeldaEditable(row[col.key], i, col.key));
                            });
                    
                            // acciones
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
                                render();
                                refrescarBadges();
                            }
                            if (action === 'dup') {
                                const copy = {...datos[i]};
                                delete copy.__errors;
                                datos.splice(i+1, 0, copy);
                                datos[i+1].__errors = validarRow(datos[i+1]);
                                render();
                                refrescarBadges();
                            }
                            });
                            tr.appendChild(tdAcc);
                    
                            tbody.appendChild(tr);
                            pintarFila(i);
                        });
                        refrescarBadges();
                        }
                    
                        // ------------ Lectura de archivo ----------
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
                    
                        // ------------ Drag & drop ----------
                        dropzone.addEventListener('dragover', (e) => { e.preventDefault(); dropzone.classList.add('dragover'); });
                        dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
                        dropzone.addEventListener('drop', (e) => {
                        e.preventDefault();
                        dropzone.classList.remove('dragover');
                        const file = e.dataTransfer.files?.[0];
                        if (file) leerArchivo(file);
                        });
                    
                        // ------------ Eventos ----------
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
                        // Genera plantilla con headers y una fila de ejemplo
                        const headers = columnas.map(c => c.header);
                        const ejemplo = [
                            'SKU-001','Producto demo','Bebidas','UN', '10.50','14.00','12.00','50','L001','2026-12-31'
                        ];
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
                        // Prepara payload: limpia metadatos y convierte números
                        const payload = datos.map(r => {
                            const clean = {};
                            columnas.forEach(col => {
                            let v = r[col.key];
                            if (col.type === 'number') {
                                const n = toNumber(v);
                                v = (v === '' || v == null) ? null : (Number.isFinite(n) ? n : null);
                            }
                            if (col.key === 'fecha_venc') {
                                v = parseDateFlexible(v);
                            }
                            clean[col.key] = v;
                            });
                            return clean;
                        });
                    
                        btnGuardar.disabled = true;
                        btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';
                    
                        try {
                            const res = await fetch(urlGuardar, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                ...(csrfToken ? {'X-CSRF-TOKEN': csrfToken} : {})
                            },
                            body: JSON.stringify({ items: payload })
                            });
                    
                            if (!res.ok) {
                            const t = await res.text();
                            throw new Error(t || `Error HTTP ${res.status}`);
                            }
                    
                            // Puedes ajustar según tu backend {ok:true, insertados:n, duplicados:n, errores:[...]}
                            const data = await res.json().catch(()=> ({}));
                            alert('Importación completada ✅\n' + JSON.stringify(data, null, 2));
                            datos = [];
                            render();
                        } catch (err) {
                            console.error(err);
                            alert('No se pudo guardar. Revisa consola para más detalles.');
                        } finally {
                            btnGuardar.disabled = false;
                            btnGuardar.innerHTML = '<i class="fa fa-save me-1"></i> Guardar / Registrar';
                        }
                        });
                    
                        // Render inicial vacío
                        render();
                    })();
                    </script>
  
                </div>
            </div>
        </div>
    </main>

    <!-- Template Customizer va fuera de main y slot -->

</x-layout>