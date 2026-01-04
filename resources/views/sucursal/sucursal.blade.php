<x-layout bodyClass="g-sidenav-show bg-gray-200">
  <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @vite(['resources/js/app.js'])

    <div class="container-fluid p-2">
      <div class="col-12">
        <div class="card my-2">
          <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="mb-0">Sucursales</h5>
            <div class="d-flex gap-2 flex-wrap">
              <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalSucursal" id="btnNuevaSucursal">
                <i class="bx bx-plus-circle"></i> Nueva Sucursal
              </button>
            </div>
          </div>

          <div class="card-body">

          <div class="mb-3 row g-2">
            <div class="col-md-6">
              <input type="text" id="search" class="form-control" placeholder="Buscar por código, nombre, email o teléfono..." autocomplete="off">
            </div>
          </div>

          <div class="table-responsive d-none d-md-block">
            <table class="table table-striped align-middle" id="sucursales-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th data-column="codigo">Código</th>
                  <th data-column="nombre">Nombre</th>
                  <th data-column="telefono">Teléfono</th>
                  <th data-column="email">Correo</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody id="sucursales-body">
                <tr>
                  <td colspan="7" class="text-center">Cargando...</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div id="sucursales-cards" class="d-md-none"></div>

          <nav>
            <ul class="pagination justify-content-center mt-3" id="sucursales-pagination"></ul>
          </nav>
        </div>
        </div>

        {{-- Modal Crear/Editar Sucursal --}}
        <div class="modal fade" id="modalSucursal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <form id="formSucursal">
                @csrf
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title" id="modalSucursalTitle">Nueva Sucursal</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="sucursal_id">

                  <div class="row g-3">

                    <div class="col-md-3">
                      <label class="form-label">Código</label>
                      <input type="text" class="form-control" id="codigo" name="codigo" required>
                    </div>
                    <div class="col-md-5">
                      <label class="form-label">Nombre</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="col-md-4">
                      <label class="form-label">Teléfono</label>
                      <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Correo</label>
                      <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Activa</label>
                      <select class="form-select" id="activa" name="activa">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Dirección</label>
                      <input type="text" class="form-control" id="direccion" name="direccion">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Ciudad</label>
                      <input type="text" class="form-control" id="ciudad" name="ciudad">
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Departamento</label>
                      <input type="text" class="form-control" id="departamento" name="departamento">
                    </div>
                  </div>

                  <div class="alert alert-danger d-none mt-3" id="formErrors">
                    <ul class="mb-0" id="formErrorsList"></ul>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                  <button class="btn btn-primary" id="btnGuardarSucursal" type="submit">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>


        <script>
          document.addEventListener("DOMContentLoaded", function() {
            // --- Helpers
            const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function showToast(message, type = "primary") {
              const toastEl = document.querySelector(".bs-toast");
              toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
              toastEl.querySelector(".toast-body").textContent = message;
              const toast = new bootstrap.Toast(toastEl);
              toast.show();
            }

            function highlight(text, term) {
              if (!term) return text ?? '';
              const safe = (text ?? '').toString();
              return safe.replace(new RegExp(`(${term})`, 'gi'), '<mark>$1</mark>');
            }

            // --- Estado tabla
            const tableBody = document.getElementById('sucursales-body');
            const pagination = document.getElementById('sucursales-pagination');
            const searchInput = document.getElementById('search');
            const tableHeaders = document.querySelectorAll('#sucursales-table th[data-column]');
            let currentPage = 1,
              sortColumn = '',
              sortDirection = 'asc',
              currentSearch = '';

            // --- Fetch
            async function fetchSucursales(page = 1, search = '', sortCol = '', sortDir = '') {
              try {
                const url = new URL(`{{ route('sucursal.fetch') }}`, window.location.origin);
                url.searchParams.set('page', page);
                if (search) url.searchParams.set('search', search);
                if (sortCol) url.searchParams.set('sort', sortCol);
                if (sortDir) url.searchParams.set('direction', sortDir);

                const res = await fetch(url.toString(), {
                  headers: {
                    'Accept': 'application/json'
                  }
                });
                const data = await res.json();

                tableBody.innerHTML = '';
                if (!data.data || data.data.length === 0) {
                  tableBody.innerHTML = '<tr><td colspan="7" class="text-center">Sin sucursales</td></tr>';
                  pagination.innerHTML = '';
                  return;
                }

                data.data.forEach(s => {
                  tableBody.insertAdjacentHTML('beforeend', `
                    <tr data-id="${s.id}"
                        data-empresa-id="${s.empresa_id}"
                        data-codigo="${s.codigo ?? ''}"
                        data-nombre="${s.nombre ?? ''}"
                        data-telefono="${s.telefono ?? ''}"
                        data-email="${s.email ?? ''}"
                        data-direccion="${s.direccion ?? ''}"
                        data-ciudad="${s.ciudad ?? ''}"
                        data-departamento="${s.departamento ?? ''}"
                        data-activa="${s.activa ?? (s.estado==1?1:0)}">
                      <td>${s.id}</td>
                      <td>${highlight(s.codigo ?? '', search)}</td>
                      <td>${highlight(s.nombre ?? '', search)}</td>
                      <td>${highlight(s.telefono ?? '', search)}</td>
                      <td>${highlight(s.email ?? '', search)}</td>
                      <td>${highlight(s.empresa?.nombre ?? '-', search)}</td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-warning btn-edit">Editar</button>
                        <button class="btn btn-sm btn-danger btn-delete">Eliminar</button>
                      </td>
                    </tr>
                  `);
                });

                // Paginación
                const totalPages = data.last_page;
                let pagHtml = `
                  <li class="page-item ${data.current_page===1?'disabled':''}">
                    <a href="#" class="page-link" data-page="${data.current_page-1}">Anterior</a>
                  </li>`;
                for (let i = 1; i <= totalPages; i++) {
                  pagHtml += `<li class="page-item ${i===data.current_page?'active':''}">
                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                  </li>`;
                }
                pagHtml += `
                  <li class="page-item ${data.current_page===totalPages?'disabled':''}">
                    <a href="#" class="page-link" data-page="${data.current_page+1}">Siguiente</a>
                  </li>`;
                pagination.innerHTML = pagHtml;

                document.querySelectorAll('#sucursales-pagination a').forEach(a => {
                  a.addEventListener('click', (e) => {
                    e.preventDefault();
                    const page = parseInt(a.dataset.page);
                    if (page >= 1 && page <= totalPages && page !== currentPage) {
                      currentPage = page;
                      fetchSucursales(currentPage, currentSearch, sortColumn, sortDirection);
                    }
                  });
                });
              } catch (err) {
                console.error(err);
                showToast('Error al cargar sucursales', 'danger');
              }
            }

            // Inicial
            fetchSucursales();

            // Buscar
            searchInput.addEventListener('keyup', function() {
              currentSearch = this.value.trim();
              currentPage = 1;
              fetchSucursales(currentPage, currentSearch, sortColumn, sortDirection);
            });

            // Ordenar
            tableHeaders.forEach(th => {
              th.addEventListener('click', () => {
                const col = th.dataset.column;
                if (!col) return;
                if (sortColumn === col) sortDirection = (sortDirection === 'asc') ? 'desc' : 'asc';
                else {
                  sortColumn = col;
                  sortDirection = 'asc';
                }
                fetchSucursales(currentPage, currentSearch, sortColumn, sortDirection);
              });
            });

            // Modal Crear
            const modalEl = document.getElementById('modalSucursal');
            const modal = new bootstrap.Modal(modalEl);
            const form = document.getElementById('formSucursal');
            const modalTitle = document.getElementById('modalSucursalTitle');

            document.getElementById('btnNuevaSucursal').addEventListener('click', () => {
              form.reset();
              document.getElementById('sucursal_id').value = '';
              modalTitle.textContent = 'Nueva Sucursal';
            });

            function openEditFromRow(row) {
              form.reset();
              document.getElementById('sucursal_id').value = row.dataset.id;
              document.getElementById('empresa_id').value = row.dataset.empresaId || '';
              document.getElementById('codigo').value = row.dataset.codigo || '';
              document.getElementById('nombre').value = row.dataset.nombre || '';
              document.getElementById('telefono').value = row.dataset.telefono || '';
              document.getElementById('email').value = row.dataset.email || '';
              document.getElementById('direccion').value = row.dataset.direccion || '';
              document.getElementById('ciudad').value = row.dataset.ciudad || '';
              document.getElementById('departamento').value = row.dataset.departamento || '';
              document.getElementById('activa').value = row.dataset.activa || '1';
              modalTitle.textContent = 'Editar Sucursal';
              modal.show();
            }

            // Click en editar/eliminar
            tableBody.addEventListener('click', (e) => {
              const row = e.target.closest('tr[data-id]');
              if (!row) return;

              // Editar
              if (e.target.classList.contains('btn-edit')) {
                openEditFromRow(row);
              }

              // Eliminar
              if (e.target.classList.contains('btn-delete')) {
                const id = row.dataset.id;
                Swal.fire({
                  title: '¿Eliminar sucursal?',
                  text: 'Se marcará como inactiva/borrada.',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Sí, eliminar',
                  cancelButtonText: 'Cancelar'
                }).then(async (result) => {
                  if (!result.isConfirmed) return;
                  try {
                    const res = await fetch(`{{ url('sucursal') }}/${id}`, {
                      method: 'DELETE',
                      headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                      }
                    });
                    const data = await res.json();
                    showToast(data.message ?? 'Eliminado', data.status === 'success' ? 'success' : 'danger');
                    fetchSucursales(currentPage, currentSearch, sortColumn, sortDirection);
                  } catch (err) {
                    console.error(err);
                    showToast('Error al eliminar', 'danger');
                  }
                });
              }
            });

            // Guardar (crear/actualizar)
            form.addEventListener('submit', async (e) => {
              e.preventDefault();
              const id = document.getElementById('sucursal_id').value;
              const url = id ? `{{ url('sucursal') }}/${id}` : `{{ route('sucursal.store') }}`;
              const method = id ? 'POST' : 'POST';
              const fd = new FormData(form);
              if (id) fd.append('_method', 'PUT');

              try {
                const res = await fetch(url, {
                  method,
                  headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                  },
                  body: fd
                });

                const data = await res.json();
                if (data.status === 'success') {
                  showToast(data.message || 'Guardado', 'success');
                  modal.hide();
                  fetchSucursales(currentPage, currentSearch, sortColumn, sortDirection);
                } else {
                  showToast(data.message || 'Error de validación', 'danger');
                  // Errores detallados (opcional)
                  const errs = data.errors || {};
                  const list = document.getElementById('formErrorsList');
                  const box = document.getElementById('formErrors');
                  list.innerHTML = '';
                  if (Object.keys(errs).length) {
                    box.classList.remove('d-none');
                    Object.values(errs).forEach(arr => {
                      const li = document.createElement('li');
                      li.textContent = arr[0];
                      list.appendChild(li);
                    });
                  } else {
                    box.classList.add('d-none');
                  }
                }
              } catch (err) {
                console.error(err);
                showToast('Error al guardar', 'danger');
              }
            });
          });
        </script>
      </div>
    </div>
  </main>
</x-layout>
