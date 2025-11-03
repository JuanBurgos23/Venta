<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        @vite(['resources/js/app.js'])

        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                        <h5 class="mb-0">Registro de Ingresos y Egresos</h5>
                        <div class="d-flex gap-2 flex-wrap">
                            <button id="btnCaja" class="btn btn-outline-secondary btn-sm">
                                <i class="bx bx-lock-open-alt"></i> Abrir/Cerrar Caja
                            </button>
                            <button id="btnNuevo" class="btn btn-primary btn-sm">
                                <i class="bx bx-plus-circle"></i> Nuevo
                            </button>
                        </div>
                    </div>

                    <div class="card-body">

                        <!-- Filtros -->
                        <div class="row g-2 mb-3">
                            <div class="col-md-4">
                                <input type="text" id="search" class="form-control" placeholder="Buscar...">
                            </div>
                            <div class="col-md-3">
                                <input type="date" id="fecha_inicio" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="date" id="fecha_fin" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <button id="btnFiltrar" class="btn btn-dark w-100">
                                    <i class="bx bx-search"></i> Filtrar
                                </button>
                            </div>
                        </div>

                        <!-- Tabla -->
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Motivo</th>
                                        <th>Descripción</th>
                                        <th>Monto</th>
                                        <th>Usuario</th>
                                        <th class="text-end">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody"></tbody>
                            </table>
                        </div>

                        <!-- Cards (modo móvil) -->
                        <div id="cardContainer" class="d-md-none"></div>

                        <!-- Paginación -->
                        <nav>
                            <ul id="pagination" class="pagination justify-content-center mt-3"></ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Crear/Editar -->
    <div class="modal fade" id="modalIngresoEgreso" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="formIngresoEgreso">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Registrar Ingreso/Egreso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="registro_id">

                        <div class="mb-3">
                            <label for="tipo_ingreso_egreso_id" class="form-label">Tipo</label>
                            <select id="tipo_ingreso_egreso_id" name="tipo_ingreso_egreso_id" class="form-select" required>
                                <option value="">Seleccione...</option>
                                @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo</label>
                            <input type="text" id="motivo" name="motivo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" step="0.01" id="monto" name="monto" class="form-control" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- 🔸 Modal de apertura de caja -->
    <div class="modal fade" id="modalAperturaCaja" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Apertura de Caja</h5>
                </div>
                <div class="modal-body">
                    <form id="formAperturaCaja">
                        <div class="mb-3">
                            <label for="fecha_apertura" class="form-label">Fecha y hora de apertura</label>
                            <input type="datetime-local" id="fecha_apertura" name="fecha_apertura" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="monto_inicial" class="form-label">Monto de apertura</label>
                            <input type="number" step="0.01" id="monto_inicial" name="monto_inicial" class="form-control" required>
                        </div>
                        <select name="sucursal_id" class="form-select">
                            @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnCancelarCaja">Cancelar</button>
                    <button type="submit" form="formAperturaCaja" class="btn btn-primary">Abrir caja</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Cierre de caja modal-->
    <div class="modal fade" id="modalCierreCaja" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Cierre de Caja</h5>
                </div>
                <div class="modal-body">
                    <form id="formCierreCaja">
                        <div class="mb-3">
                            <label for="fecha_apertura_cierre" class="form-label">Fecha y hora de apertura</label>
                            <input type="text" id="fecha_apertura_cierre" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="monto_inicial_cierre" class="form-label">Monto de apertura</label>
                            <input type="text" id="monto_inicial_cierre" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="fecha_cierre" class="form-label">Fecha y hora de cierre</label>
                            <input type="datetime-local" id="fecha_cierre" name="fecha_cierre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="monto_final" class="form-label">Monto de cierre</label>
                            <input type="number" id="monto_final" name="monto_final" class="form-control" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="observacion" class="form-label">Observaciones</label>
                            <textarea id="observacion" name="observacion" rows="3" class="form-control" placeholder="Observaciones sobre el cierre..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formCierreCaja" class="btn btn-danger">Cerrar Caja</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let currentPage = 1;
            let lastSearch = '';
            const tableBody = document.getElementById('tableBody');
            const cardContainer = document.getElementById('cardContainer');
            const btnNuevo = document.getElementById('btnNuevo');
            const btnCaja = document.getElementById('btnCaja');
            fetchRows();

            let cajaAbierta = false;
            let cajaActual = null;

            function showToast(message, type = "primary") {
                const toastEl = document.querySelector(".bs-toast");
                if (!toastEl) return;
                toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide show`;
                toastEl.querySelector(".toast-body").textContent = message;
                new bootstrap.Toast(toastEl).show();
            }
            const modalIngresoEgresoEl = document.getElementById('modalIngresoEgreso');
            const modalIngresoEgreso = new bootstrap.Modal(modalIngresoEgresoEl);

            // Cuando se hace clic en "Nuevo"
            btnNuevo.addEventListener('click', async () => {
                try {
                    // Verificar si hay una caja abierta
                    const res = await fetch('/caja/verificar');
                    const data = await res.json();

                    if (!data.activa) {
                        showToast('Debe abrir una caja antes de registrar ingresos o egresos.', 'danger');
                        return;
                    }

                    // Limpiar formulario y abrir modal
                    document.getElementById('formIngresoEgreso').reset();
                    document.getElementById('registro_id').value = '';

                    // Mostrar modal
                    modalIngresoEgreso.show();

                } catch (error) {
                    console.error('Error al verificar caja:', error);
                    showToast('No se pudo verificar el estado de la caja.', 'danger');
                }
            });
            
            // ✅ Verificar caja abierta desde el backend
            async function verificarCaja() {
                try {
                    const res = await fetch('/caja/verificar');
                    const json = await res.json();

                    cajaAbierta = json.activa;
                    cajaActual = json.caja ?? null;

                    if (!cajaAbierta) {
                        btnNuevo.classList.add('disabled');
                        btnNuevo.title = 'Debe abrir la caja primero';
                        btnCaja.innerHTML = `<i class="bx bx-lock-alt"></i> Abrir Caja`;
                        btnCaja.classList.remove('btn-danger');
                        btnCaja.classList.add('btn-success');
                    } else {
                        btnNuevo.classList.remove('disabled');
                        btnNuevo.title = '';
                        btnCaja.innerHTML = `<i class="bx bx-lock-open-alt"></i> Cerrar Caja`;
                        btnCaja.classList.remove('btn-success');
                        btnCaja.classList.add('btn-danger');
                    }
                } catch (err) {
                    console.error('Error al verificar caja:', err);
                    showToast('No se pudo verificar el estado de la caja', 'danger');
                }
            }

            // Inicializar modales de caja
            const modalAperturaCajaEl = document.getElementById('modalAperturaCaja');
            const modalCierreCajaEl = document.getElementById('modalCierreCaja');
            const modalAperturaCaja = new bootstrap.Modal(modalAperturaCajaEl);
            const modalCierreCaja = new bootstrap.Modal(modalCierreCajaEl);

            // ✅ Acción del botón principal de caja
            btnCaja.addEventListener('click', async () => {
                if (cajaAbierta) {
                    // Mostrar modal de cierre
                    const res = await fetch('/caja/verificar');
                    const data = await res.json();

                    if (data.activa) {
                        document.getElementById('fecha_apertura_cierre').value = new Date(data.caja.fecha_apertura).toLocaleString();
                        document.getElementById('monto_inicial_cierre').value = parseFloat(data.caja.monto_inicial).toFixed(2);
                        document.getElementById('fecha_cierre').value = new Date().toISOString().slice(0, 16);
                        modalCierreCaja.show();
                    } else {
                        showToast('No hay caja activa para cerrar.', 'danger');
                    }
                } else {
                    // Mostrar modal de apertura
                    document.getElementById('fecha_apertura').value = new Date().toISOString().slice(0, 16);
                    modalAperturaCaja.show();
                }
            });
            // ✅ Enviar formulario de apertura
            document.getElementById('formAperturaCaja').addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);
                try {
                    const res = await fetch('/caja/abrir', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await res.json();
                    if (data.success) {
                        showToast('Caja abierta correctamente', 'success');
                        modalAperturaCaja.hide();
                        cajaAbierta = true;
                        btnCaja.textContent = 'Cerrar Caja';
                        btnNuevo.disabled = false;
                    } else {
                        showToast(data.message || 'Error al abrir caja', 'danger');
                    }
                } catch (error) {
                    console.error(error);
                    showToast('Error en la conexión al abrir caja', 'danger');
                }
            });

            // ✅ Enviar formulario de cierre
            document.getElementById('formCierreCaja').addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);
                try {
                    const res = await fetch('/caja/cerrar', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });

                    const data = await res.json();
                    if (data.success) {
                        showToast('Caja cerrada correctamente', 'success');
                        modalCierreCaja.hide();
                        cajaAbierta = false;
                        btnCaja.textContent = 'Abrir Caja';
                        btnNuevo.disabled = true;
                    } else {
                        showToast(data.message || 'Error al cerrar caja', 'danger');
                    }
                } catch (error) {
                    console.error(error);
                    showToast('Error en la conexión al cerrar caja', 'danger');
                }
            });

            // ✅ Cargar registros (tabla dinámica)
            async function fetchRows(page = 1) {
                const params = new URLSearchParams({
                    page,
                    search: document.getElementById('search').value,
                    fecha_inicio: document.getElementById('fecha_inicio').value,
                    fecha_fin: document.getElementById('fecha_fin').value
                });

                const res = await fetch(`/ingreso-egreso/fetch?${params.toString()}`);
                const json = await res.json();

                tableBody.innerHTML = '';
                cardContainer.innerHTML = '';

                json.data.forEach(r => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td>${r.id}</td>
                    <td>${r.fecha}</td>
                    <td>${r.tipo_ingreso_egreso?.nombre ?? '-'}</td>
                    <td>${r.motivo}</td>
                    <td>${r.descripcion ?? ''}</td>
                    <td>${parseFloat(r.monto).toFixed(2)}</td>
                    <td>${r.usuario?.name ?? ''}</td>
                    <td class="text-end">
                       <button class="btn btn-sm btn-outline-primary me-1 btn-editar" data-id="${r.id}">
                        <i class="bx bx-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger me-1"><i class="bx bx-x-circle"></i></button>
                        <button class="btn btn-sm btn-outline-secondary"><i class="bx bx-printer"></i></button>
                    </td>
                `;
                    tableBody.appendChild(tr);

                    const card = document.createElement('div');
                    card.className = 'card mb-2';
                    card.innerHTML = `
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="fw-bold">${r.tipo_ingreso_egreso?.nombre ?? ''}</div>
                                <div class="text-muted small">${r.motivo} • ${r.fecha}</div>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-primary btn-editar" data-id="${r.id}">
                                <i class="bx bx-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bx bx-x-circle"></i></button>
                                <button class="btn btn-sm btn-outline-secondary"><i class="bx bx-printer"></i></button>
                            </div>
                        </div>
                        <p class="mt-2 mb-0 small text-muted">${r.descripcion ?? ''}</p>
                        <div class="fw-bold mt-1">Bs ${parseFloat(r.monto).toFixed(2)}</div>
                    </div>`;
                    cardContainer.appendChild(card);
                });
            }
            // Delegación de eventos para tabla
            tableBody.addEventListener('click', async (e) => {
                const btn = e.target.closest('.btn-editar');
                if (!btn) return;

                const id = btn.dataset.id;

                try {
                    const res = await fetch(`/ingreso-egreso/${id}`);
                    const data = await res.json();

                    if (data.success) {
                        document.getElementById('registro_id').value = data.registro.id;
                        document.getElementById('tipo_ingreso_egreso_id').value = data.registro.tipo_ingreso_egreso_id;
                        document.getElementById('motivo').value = data.registro.motivo;
                        document.getElementById('descripcion').value = data.registro.descripcion ?? '';
                        document.getElementById('monto').value = data.registro.monto;

                        document.getElementById('modalLabel').textContent = 'Editar Ingreso/Egreso';
                        modalIngresoEgreso.show();
                    } else {
                        showToast('No se pudo cargar el registro', 'danger');
                    }
                } catch (error) {
                    console.error(error);
                    showToast('Error al obtener datos del registro', 'danger');
                }
            });

            // Delegación de eventos para cards
            cardContainer.addEventListener('click', async (e) => {
                const btn = e.target.closest('.btn-editar');
                if (!btn) return;

                const id = btn.dataset.id;

                try {
                    const res = await fetch(`/ingreso-egreso/${id}`);
                    const data = await res.json();

                    if (data.success) {
                        document.getElementById('registro_id').value = data.registro.id;
                        document.getElementById('tipo_ingreso_egreso_id').value = data.registro.tipo_ingreso_egreso_id;
                        document.getElementById('motivo').value = data.registro.motivo;
                        document.getElementById('descripcion').value = data.registro.descripcion ?? '';
                        document.getElementById('monto').value = data.registro.monto;

                        document.getElementById('modalLabel').textContent = 'Editar Ingreso/Egreso';
                        modalIngresoEgreso.show();
                    } else {
                        showToast('No se pudo cargar el registro', 'danger');
                    }
                } catch (error) {
                    console.error(error);
                    showToast('Error al obtener datos del registro', 'danger');
                }
            });

            document.getElementById('formIngresoEgreso').addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                const id = document.getElementById('registro_id').value;

                const url = id ? `/ingreso_egreso_actualizar/${id}` : '/ingreso_egreso_registrar';
                const method = 'POST';

                try {
                    const res = await fetch(url, {
                        method,
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    });
                    const data = await res.json();

                    if (data.success) {
                        // Mostrar solo el toast de éxito
                        showToast('Registro guardado correctamente', 'success');
                        modalIngresoEgreso.hide();
                        e.target.reset();
                        await fetchRows(); // Recarga tabla sin generar toast de error
                    } else {
                        showToast(data.message || 'Error al guardar el registro', 'danger');
                    }
                } catch (error) {
                    console.error(error);
                    showToast('Error de conexión al guardar el registro', 'danger');
                }
            });
            const searchInput = document.getElementById('search');
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');

            function realizarBusqueda() {
                fetchRows(1);
            }

            // Al escribir en el buscador
            searchInput.addEventListener('input', realizarBusqueda);

            // Al cambiar fechas
            fechaInicio.addEventListener('change', realizarBusqueda);
            fechaFin.addEventListener('change', realizarBusqueda);

            // Al hacer clic en el botón filtrar
            document.getElementById('btnFiltrar').addEventListener('click', realizarBusqueda);

            // ✅ Cargar al iniciar
            verificarCaja();
            fetchRows();
        });
    </script>

</x-layout>