<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        @vite(['resources/js/app.js'])
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row g-3 align-items-end mb-3">
                <div class="col-lg-7">
                    <h4 class="mb-0">Reporte mensual de ganancias</h4>
                    <div class="text-muted small">Resumen financiero del mes por empresa</div>
                </div>
                <div class="col-lg-5">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label mb-1 small">Mes</label>
                            <input id="f-mes" type="month" value="{{ now()->format('Y-m') }}" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label mb-1 small">Almacén</label>
                            <select id="f-almacen" class="form-select form-select-sm">
                                <option value="">Todos</option>
                                {{-- (Opcional) se carga por JS si habilitas endpoint --}}
                            </select>
                        </div>
                        <div class="col-12 text-end">
                            <button id="btn-aplicar" class="btn btn-sm btn-primary">
                                <i class="fa fa-filter me-1"></i> Aplicar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPIs -->
            <div class="row g-3">
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="text-muted text-uppercase small mb-1">Ventas brutas</div>
                            <div id="kpi-ventas-brutas" class="fs-3 fw-semibold">—</div>
                            <div class="text-muted small">Total facturado del mes</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="text-muted text-uppercase small mb-1">COGS</div>
                            <div id="kpi-cogs" class="fs-3 fw-semibold">—</div>
                            <div class="text-muted small">Costo de lo vendido</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="text-muted text-uppercase small mb-1">Utilidad bruta</div>
                            <div id="kpi-utilidad" class="fs-3 fw-semibold text-success">—</div>
                            <div class="text-muted small">Ventas netas - COGS</div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="text-muted text-uppercase small mb-1">Tickets / Promedio</div>
                            <div class="fs-3 fw-semibold">
                                <span id="kpi-tickets">—</span>
                                <span class="fs-6 fw-normal text-muted">(<span id="kpi-ticket-promedio">—</span>)</span>
                            </div>
                            <div class="text-muted small">Cantidad / ticket promedio</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla por día -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header d-flex align-items-center">
                    <div>
                        <div class="fw-semibold">Detalle por día</div>
                        <div class="text-muted small">Ventas, COGS y utilidad diaria</div>
                    </div>
                    <div class="ms-auto">
                        <button id="btn-exportar-dias" class="btn btn-outline-secondary btn-sm">
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
                                    <th class="text-end">Ventas</th>
                                    <th class="text-end">COGS</th>
                                    <th class="text-end">Utilidad</th>
                                </tr>
                            </thead>
                            <tbody id="tb-dias">
                                <!-- filas dinámicas -->
                            </tbody>
                        </table>
                    </div>
                    <div id="dias-empty" class="text-center text-muted small py-4 d-none">Sin datos para el mes seleccionado.</div>
                </div>
            </div>

            <!-- Top productos del mes -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header d-flex align-items-center">
                    <div>
                        <div class="fw-semibold">Top productos del mes</div>
                        <div class="text-muted small">Ordenado por ventas (importe)</div>
                    </div>
                    <div class="ms-auto">
                        <button id="btn-exportar-top" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-file-csv me-1"></i> Exportar CSV
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:70px;">#</th>
                                    <th>Producto</th>
                                    <th class="text-end">Cantidad</th>
                                    <th class="text-end">Ventas</th>
                                </tr>
                            </thead>
                            <tbody id="tb-top">
                                <!-- filas dinámicas -->
                            </tbody>
                        </table>
                    </div>
                    <div id="top-empty" class="text-center text-muted small py-4 d-none">Sin datos para el mes seleccionado.</div>
                </div>
            </div>
        </div>
    </main>

    <script>
        window.APP = {
            routes: {
                finanzasMensual: "{{ route('finanzas.mensual') }}",
            },
            empresaId: {{ auth()->user()->id_empresa ?? 'null' }}
        };
    </script>

    <script>
    (function (){
        const fmt = n => Number(n ?? 0).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});

        // KPIs
        const elVentasBrutas = document.getElementById('kpi-ventas-brutas');
        const elCogs         = document.getElementById('kpi-cogs');
        const elUtilidad     = document.getElementById('kpi-utilidad');
        const elTickets      = document.getElementById('kpi-tickets');
        const elTicketProm   = document.getElementById('kpi-ticket-promedio');

        // Tablas
        const tbDias   = document.getElementById('tb-dias');
        const diasEmpty= document.getElementById('dias-empty');
        const tbTop    = document.getElementById('tb-top');
        const topEmpty = document.getElementById('top-empty');

        // Filtros
        const fMes     = document.getElementById('f-mes');
        const fAlmacen = document.getElementById('f-almacen');
        const btnAplicar = document.getElementById('btn-aplicar');

        // (Opcional) cargar almacenes
        async function cargarAlmacenes() {
            if (!window.APP.routes.almacenes) return;
            try {
                const res = await fetch(window.APP.routes.almacenes);
                if (!res.ok) return;
                const data = await res.json();
                if (!Array.isArray(data)) return;
                data.forEach(a => {
                    const opt = document.createElement('option');
                    opt.value = a.id;
                    opt.textContent = a.nombre;
                    fAlmacen.appendChild(opt);
                });
            } catch(e) { console.warn('No se pudieron cargar almacenes', e); }
        }

        async function cargarDatos() {
            const params = new URLSearchParams();
            params.set('mes', fMes.value || '{{ now()->format('Y-m') }}');
            if (window.APP.empresaId) params.set('empresa_id', window.APP.empresaId);
            if (fAlmacen.value) params.set('almacen_id', fAlmacen.value);

            const url = `${window.APP.routes.finanzasMensual}?${params.toString()}`;
            try {
                const res = await fetch(url);
                if (!res.ok) throw new Error(await res.text());
                const json = await res.json();
                if (!json.ok) throw new Error(json.msg || 'Error en el reporte mensual');

                renderKPIs(json.resumen);
                renderDias(json.serie_dias || []);
                renderTop(json.top_productos || []);
            } catch (e) {
                console.error(e);
                renderKPIs(null);
                renderDias([]);
                renderTop([]);
                alert('No se pudo cargar el reporte mensual.');
            }
        }

        function renderKPIs(r) {
            if (!r) {
                elVentasBrutas.textContent = '—';
                elCogs.textContent         = '—';
                elUtilidad.textContent     = '—';
                elTickets.textContent      = '—';
                elTicketProm.textContent   = '—';
                return;
            }
            elVentasBrutas.textContent = 'Bs ' + fmt(r.ventas_brutas);
            elCogs.textContent         = 'Bs ' + fmt(r.cogs);
            elUtilidad.textContent     = 'Bs ' + fmt(r.utilidad_bruta);
            elTickets.textContent      = r.tickets ?? 0;
            elTicketProm.textContent   = 'Bs ' + fmt(r.ticket_promedio);
        }

        function renderDias(items) {
            tbDias.innerHTML = '';
            if (!items.length) { diasEmpty.classList.remove('d-none'); return; }
            diasEmpty.classList.add('d-none');

            let totV=0, totC=0, totU=0;
            items.forEach((it) => {
                totV += Number(it.ventas || 0);
                totC += Number(it.cogs || 0);
                totU += Number(it.utilidad || 0);

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${it.fecha}</td>
                    <td class="text-end">Bs ${fmt(it.ventas || 0)}</td>
                    <td class="text-end">Bs ${fmt(it.cogs || 0)}</td>
                    <td class="text-end fw-semibold">Bs ${fmt(it.utilidad || 0)}</td>
                `;
                tbDias.appendChild(tr);
            });

            // Fila total
            const trT = document.createElement('tr');
            trT.className = 'table-light';
            trT.innerHTML = `
                <td class="fw-semibold text-end">Totales del mes</td>
                <td class="text-end fw-semibold">Bs ${fmt(totV)}</td>
                <td class="text-end fw-semibold">Bs ${fmt(totC)}</td>
                <td class="text-end fw-semibold">Bs ${fmt(totU)}</td>
            `;
            tbDias.appendChild(trT);
        }

        function renderTop(items) {
            tbTop.innerHTML = '';
            if (!items.length) { topEmpty.classList.remove('d-none'); return; }
            topEmpty.classList.add('d-none');

            items.forEach((it, i) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="text-muted">${i+1}</td>
                    <td class="fw-semibold">${(it.nombre ?? '-')}</td>
                    <td class="text-end">${fmt(it.cantidad ?? 0)}</td>
                    <td class="text-end fw-semibold">Bs ${fmt(it.ventas ?? 0)}</td>
                `;
                tbTop.appendChild(tr);
            });
        }

        function exportCSV(selectorTBody, headers, filename) {
            const tb = document.querySelector(selectorTBody);
            const rows = [headers];
            tb.querySelectorAll('tr').forEach(tr => {
                const cols = Array.from(tr.querySelectorAll('td')).map(td =>
                    td.textContent.trim().replace(/\s+/g,' ')
                );
                rows.push(cols);
            });
            const csv = rows.map(r => r.map(c => /[",;\n]/.test(c) ? `"${c.replace(/"/g,'""')}"` : c).join(',')).join('\n');
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = filename;
            a.click();
            URL.revokeObjectURL(a.href);
        }

        document.getElementById('btn-exportar-dias')?.addEventListener('click', () => {
            exportCSV('#tb-dias', ['Fecha','Ventas','COGS','Utilidad'], `detalle_dias_${fMes.value}.csv`);
        });
        document.getElementById('btn-exportar-top')?.addEventListener('click', () => {
            exportCSV('#tb-top', ['#','Producto','Cantidad','Ventas'], `top_productos_${fMes.value}.csv`);
        });

        btnAplicar.addEventListener('click', cargarDatos);

        // init
        cargarAlmacenes();
        cargarDatos();
    })();
    </script>
</x-layout>
