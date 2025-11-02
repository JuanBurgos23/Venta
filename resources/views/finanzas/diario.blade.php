<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <!-- Scripts base -->
        @vite(['resources/js/app.js'])
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row g-3 align-items-end mb-3">
                <div class="col-lg-7">
                    <h4 class="mb-0">Reporte diario de ganancias</h4>
                    <div class="text-muted small">Resumen financiero del día por empresa</div>
                </div>
                <div class="col-lg-5">
                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label mb-1 small">Fecha</label>
                            <input id="f-fecha" type="date" value="{{ now()->toDateString() }}" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label mb-1 small">Almacén</label>
                            <select id="f-almacen" class="form-select form-select-sm">
                                <option value="">Todos</option>
                                {{-- (Opcional) Cargado por JS si tienes endpoint de almacenes --}}
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
                            <div class="text-muted small">Monto total facturado</div>
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
                            <div class="text-muted small">Cantidad y ticket promedio</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top productos -->
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-header d-flex align-items-center">
                    <div>
                        <div class="fw-semibold">Top productos del día</div>
                        <div class="text-muted small">Ordenado por ventas (importe)</div>
                    </div>
                    <div class="ms-auto">
                        <button id="btn-exportar-csv" class="btn btn-outline-secondary btn-sm">
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
                    <div id="top-empty" class="text-center text-muted small py-4 d-none">Sin datos para la fecha seleccionada.</div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Contexto (ajusta si tu auth/empresa es distinta)
        window.APP = {
            routes: {
                finanzasDiario: "{{ route('finanzas.diario') }}",
                // Si ya tienes un endpoint para listar almacenes, setéalo aquí:
            },
            empresaId: {{ auth()->user()->id_empresa ?? 'null' }}
        };
    </script>

    <script>
    (function (){
        const fmt = n => Number(n ?? 0).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});

        const elVentasBrutas = document.getElementById('kpi-ventas-brutas');
        const elCogs         = document.getElementById('kpi-cogs');
        const elUtilidad     = document.getElementById('kpi-utilidad');
        const elTickets      = document.getElementById('kpi-tickets');
        const elTicketProm   = document.getElementById('kpi-ticket-promedio');

        const tbTop          = document.getElementById('tb-top');
        const topEmpty       = document.getElementById('top-empty');

        const fFecha         = document.getElementById('f-fecha');
        const fAlmacen       = document.getElementById('f-almacen');
        const btnAplicar     = document.getElementById('btn-aplicar');

        // (Opcional) cargar almacenes si tienes endpoint
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
            params.set('fecha', fFecha.value || '{{ now()->toDateString() }}');
            if (window.APP.empresaId) params.set('empresa_id', window.APP.empresaId);
            if (fAlmacen.value) params.set('almacen_id', fAlmacen.value);

            const url = `${window.APP.routes.finanzasDiario}?${params.toString()}`;
            try {
                const res = await fetch(url);
                if (!res.ok) throw new Error(await res.text());
                const json = await res.json();
                if (!json.ok) throw new Error(json.msg || 'Error en el reporte');

                renderKPIs(json.resumen);
                renderTop(json.top_productos || []);
            } catch (e) {
                console.error(e);
                renderKPIs(null);
                renderTop([]);
                alert('No se pudo cargar el reporte diario.');
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
                    <td class="text-end fw-semibold">$ ${fmt(it.ventas ?? 0)}</td>
                `;
                tbTop.appendChild(tr);
            });
        }

        function exportCSV() {
            const rows = [['#','Producto','Cantidad','Ventas']];
            tbTop.querySelectorAll('tr').forEach(tr => {
                const tds = tr.querySelectorAll('td');
                rows.push([
                    (tds[0]?.textContent || '').trim(),
                    (tds[1]?.textContent || '').trim(),
                    (tds[2]?.textContent || '').trim(),
                    (tds[3]?.textContent || '').replace(/[^\d,.-]/g,'').trim()
                ]);
            });
            const csv = rows.map(r => r.map(c => /[",;\n]/.test(c) ? `"${c.replace(/"/g,'""')}"` : c).join(',')).join('\n');
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const a = document.createElement('a');
            a.href = URL.createObjectURL(blob);
            a.download = `reporte_diario_${fFecha.value || 'hoy'}.csv`;
            a.click();
            URL.revokeObjectURL(a.href);
        }

        document.getElementById('btn-exportar-csv')?.addEventListener('click', exportCSV);
        btnAplicar.addEventListener('click', cargarDatos);

        // init
        cargarAlmacenes();
        cargarDatos();
    })();
    </script>

    <!-- Template Customizer va fuera de main y slot -->
</x-layout>
