<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        @vite(['resources/js/app.js'])
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <!-- Header + Filtros -->
            <div class="row g-3 align-items-end mb-3">
                <div class="col-lg-7">
                    <h4 class="mb-0">Ventas por producto</h4>
                    <div class="text-muted small">Detalle de ventas con costos, utilidades y totales</div>
                </div>
                <div class="col-lg-5">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label mb-1 small">Desde</label>
                            <input id="f-desde" type="date" value="{{ now()->toDateString() }}" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label mb-1 small">Hasta</label>
                            <input id="f-hasta" type="date" value="{{ now()->toDateString() }}" class="form-control form-control-sm">
                        </div>
                        <div class="col-12">
                            <label class="form-label mb-1 small">Producto (nombre contiene)</label>
                            <div class="input-group input-group-sm">
                                <input id="f-producto-q" type="text" class="form-control" placeholder="Ej: Coca, Galletas, etc.">
                                <button id="btn-limpiar-q" class="btn btn-outline-secondary">Limpiar</button>
                            </div>
                            {{-- Si quieres filtrar por ID exacto, agrega un select/autocomplete y setea #f-producto-id --}}
                            <input type="hidden" id="f-producto-id" value="">
                        </div>
                        <div class="col-12 text-end">
                            <button id="btn-aplicar" class="btn btn-sm btn-primary">
                                <i class="fa fa-filter me-1"></i> Aplicar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla -->
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex align-items-center">
                    <div>
                        <div class="fw-semibold">Resultados</div>
                        <div class="text-muted small">Se muestran las ventas dentro del rango seleccionado</div>
                    </div>
                    <div class="ms-auto">
                        <button id="btn-exportar" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-file-csv me-1"></i> Exportar CSV
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Producto</th>
                                    <th class="text-end">Cantidad</th>
                                    <th class="text-end">Precio unit.</th>
                                    <th class="text-end">Costo unit.</th>
                                    <th class="text-end">Precio total</th>
                                    <th class="text-end">Costo total</th>
                                    <th class="text-end">Utilidad unit.</th>
                                    <th class="text-end">Utilidad total</th>
                                </tr>
                            </thead>
                            <tbody id="tb-rows">
                                <!-- filas dinámicas -->
                            </tbody>
                            <tfoot class="table-light" id="tf-totales">
                                <tr>
                                    <th colspan="2" class="text-end">Totales:</th>
                                    <th class="text-end" id="t-cantidad">—</th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-end" id="t-precio">—</th>
                                    <th class="text-end" id="t-costo">—</th>
                                    <th></th>
                                    <th class="text-end" id="t-utilidad">—</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div id="empty" class="text-center text-muted small py-4 d-none">Sin datos para los filtros seleccionados.</div>
                </div>
            </div>
        </div>
    </main>

    <script>
        window.APP = {
            routes: {
                ventasProductoData: "{{ route('finanzas.vp.data') }}",
            },
            empresaId: {{ auth()->user()->id_empresa ?? 'null' }}
        };
    </script>

    <script>
    (function(){
        const fmt2 = n => Number(n ?? 0).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        const fmt4 = n => Number(n ?? 0).toLocaleString(undefined, {minimumFractionDigits: 4, maximumFractionDigits: 4});

        // Filtros
        const fDesde = document.getElementById('f-desde');
        const fHasta = document.getElementById('f-hasta');
        const fProdQ = document.getElementById('f-producto-q');
        const fProdId= document.getElementById('f-producto-id');
        const btnAplicar = document.getElementById('btn-aplicar');
        const btnLimpiarQ= document.getElementById('btn-limpiar-q');

        // Tabla
        const tb = document.getElementById('tb-rows');
        const empty = document.getElementById('empty');

        // Totales
        const tCantidad = document.getElementById('t-cantidad');
        const tPrecio   = document.getElementById('t-precio');
        const tCosto    = document.getElementById('t-costo');
        const tUtilidad = document.getElementById('t-utilidad');

        async function cargar() {
            const params = new URLSearchParams();
            params.set('from', fDesde.value || '{{ now()->toDateString() }}');
            params.set('to',   fHasta.value || '{{ now()->toDateString() }}');
            if (window.APP.empresaId) params.set('empresa_id', window.APP.empresaId);

            const q = fProdQ.value.trim();
            if (q) params.set('q', q);

            const pid = (fProdId.value || '').trim();
            if (pid) params.set('producto_id', pid);

            const url = `${window.APP.routes.ventasProductoData}?${params.toString()}`;
            try {
                const res = await fetch(url);
                if (!res.ok) throw new Error(await res.text());
                const json = await res.json();
                if (!json.ok) throw new Error(json.msg || 'Error en el reporte');

                renderTabla(json.data || []);
                renderTotales(json.totales || {});
            } catch (e) {
                console.error(e);
                renderTabla([]);
                renderTotales(null);
                alert('No se pudo cargar el reporte.');
            }
        }

        function renderTabla(items) {
            tb.innerHTML = '';
            if (!items.length) { empty.classList.remove('d-none'); return; }
            empty.classList.add('d-none');

            items.forEach(r => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${r.fecha_venta}</td>
                    <td class="fw-semibold">${r.producto}</td>
                    <td class="text-end">${fmt2(r.cantidad)}</td>
                    <td class="text-end">Bs ${fmt2(r.precio_unitario)}</td>
                    <td class="text-end">Bs ${fmt2(r.costo_unitario)}</td>
                    <td class="text-end fw-semibold">Bs ${fmt2(r.precio_total)}</td>
                    <td class="text-end">Bs ${fmt2(r.costo_total)}</td>
                    <td class="text-end Bs{r.utilidad_unit >= 0 ? 'text-success' : 'text-danger'}">
                        Bs ${fmt2(r.utilidad_unit)}
                    </td>
                    <td class="text-end Bs{r.utilidad_total >= 0 ? 'text-success fw-semibold' : 'text-danger fw-semibold'}">
                        Bs ${fmt2(r.utilidad_total)}
                    </td>
                `;
                tb.appendChild(tr);
            });
        }

        function renderTotales(t) {
            if (!t) {
                tCantidad.textContent = '—';
                tPrecio.textContent   = '—';
                tCosto.textContent    = '—';
                tUtilidad.textContent = '—';
                return;
            }
            tCantidad.textContent = fmt4(t.cantidad || 0);
            tPrecio.textContent   = 'Bs ' + fmt2(t.precio_total || 0);
            tCosto.textContent    = 'Bs ' + fmt2(t.costo_total || 0);
            tUtilidad.textContent = 'Bs ' + fmt2(t.utilidad_total || 0);
        }

        function exportCSV() {
            const headers = ['Fecha','Producto','Cantidad','Precio unit.','Costo unit.','Precio total','Costo total','Utilidad unit.','Utilidad total'];
            const rows = [headers];
            tb.querySelectorAll('tr').forEach(tr => {
                const cols = Array.from(tr.querySelectorAll('td')).map(td =>
                    td.textContent.trim().replace(/\s+/g,' ')
                );
                rows.push(cols);
            });
            // add totals row
            rows.push(['Totales','','',
                '', '',
                document.getElementById('t-precio').textContent,
                document.getElementById('t-costo').textContent,
                '', document.getElementById('t-utilidad').textContent
            ]);

            const csv = rows.map(r => r.map(c => /[",;\n]/.test(c) ? `"${c.replace(/"/g,'""')}"` : c).join(',')).join('\n');
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = `ventas_por_producto_${(new Date()).toISOString().slice(0,10)}.csv`;
            a.click();
            URL.revokeObjectURL(a.href);
        }

        document.getElementById('btn-aplicar').addEventListener('click', cargar);
        document.getElementById('btn-exportar').addEventListener('click', exportCSV);
        document.getElementById('btn-limpiar-q').addEventListener('click', () => { fProdQ.value=''; fProdId.value=''; });

        // init
        cargar();
    })();
    </script>
</x-layout>
