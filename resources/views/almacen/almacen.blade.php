<x-layout bodyClass="g-sidenav-show bg-gray-200">
  <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <nav class="navbar ..."></nav>
    @vite(['resources/js/app.js'])

    <div class="container-fluid py-4">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="mb-0">Almacenes</h5>
            <div class="d-flex gap-2 flex-wrap">
              <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAlmacen" id="btnNuevoAlmacen">
                <i class="bx bx-plus-circle"></i> Nuevo AlmacǸn
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="row g-2 mb-3">
              <div class="col-md-6">
                <input type="text" id="search" class="form-control" placeholder="Buscar por nombre o sucursal..." autocomplete="off">
              </div>
            </div>

          <div class="table-responsive d-none d-md-block">
            <table class="table table-striped align-middle" id="almacenes-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th data-column="nombre">Nombre</th>
                  <th data-column="sucursal">Sucursal</th>
                  <th data-column="estado">Estado</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody id="almacenes-body">
                <tr>
                  <td colspan="5" class="text-center">Cargando...</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div id="almacenes-cards" class="d-md-none"></div>

          <nav>
            <ul class="pagination justify-content-center mt-3" id="almacenes-pagination"></ul>
          </nav>
        </div>
        </div>

        {{-- Modal Crear/Editar Almacén --}}
        <div class="modal fade" id="modalAlmacen" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <form id="formAlmacen">
                @csrf
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title" id="modalAlmacenTitle">Nuevo Almacén</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="almacen_id">

                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Sucursal</label>
                      <select class="form-select" id="sucursal_id" name="sucursal_id" required>
                        <option value="">Seleccione sucursal...</option>
                        @isset($sucursal)
                        @foreach($sucursal as $s)
                        <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                        @endforeach
                        @endisset
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Nombre</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="col-md-6">
                      <label class="form-label">Estado</label>
                      <select class="form-select" id="estado" name="estado">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                      </select>
                    </div>
                  </div>

                  <div class="alert alert-danger d-none mt-3" id="formErrors">
                    <ul class="mb-0" id="formErrorsList"></ul>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                  <button class="btn btn-primary" id="btnGuardarAlmacen" type="submit">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        {{-- Toast --}}


        <script>
          document.addEventListener("DOMContentLoaded", function() {
            // Helpers
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

            // Estado tabla
            const tableBody = document.getElementById('almacenes-body');
            const pagination = document.getElementById('almacenes-pagination');
            const searchInput = document.getElementById('search');
            const tableHeaders = document.querySelectorAll('#almacenes-table th[data-column]');
            let currentPage = 1,
              sortColumn = '',
              sortDirection = 'asc',
              currentSearch = '';

            // Fetch de almacenes
            async function fetchAlmacenes(page = 1, search = '', sortCol = '', sortDir = '') {
              try {
                const url = new URL(`{{ route('almacen.fetch') }}`, window.location.origin);
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
                  tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Sin almacenes</td></tr>';
                  pagination.innerHTML = '';
                  return;
                }
                // Renderizamos cada almacén
                data.data.forEach(a => {
                  const estadoTxt = (+a.estado === 1) ? 'Activo' : 'Inactivo';
                  const sucursalNombre = a.sucursal_nombre ?? '-';

                  tableBody.insertAdjacentHTML('beforeend', `
<tr data-id="${a.id}"
    data-sucursal-id="${a.sucursal_id}"
    data-nombre="${a.nombre ?? ''}"
    data-estado="${a.estado ?? 1}">
  <td>${a.id}</td>
  <td>${highlight(a.nombre ?? '', search)}</td>
  <td>${highlight(sucursalNombre, search)}</td>
  <td>${estadoTxt}</td>
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
<li class="page-item ${data.current_page === 1 ? 'disabled' : ''}">
  <a href="#" class="page-link" data-page="${data.current_page - 1}">Anterior</a>
</li>`;

                for (let i = 1; i <= totalPages; i++) {
                  pagHtml += `<li class="page-item ${i === data.current_page ? 'active' : ''}">
  <a href="#" class="page-link" data-page="${i}">${i}</a>
</li>`;
                }

                pagHtml += `
<li class="page-item ${data.current_page === totalPages ? 'disabled' : ''}">
  <a href="#" class="page-link" data-page="${data.current_page + 1}">Siguiente</a>
</li>`;

                pagination.innerHTML = pagHtml;

                // Agregar eventos a los enlaces de paginación
                document.querySelectorAll('#almacenes-pagination a').forEach(a => {
                  a.addEventListener('click', (e) => {
                    e.preventDefault();
                    const page = parseInt(a.dataset.page);
                    if (page >= 1 && page <= totalPages && page !== currentPage) {
                      currentPage = page;
                      fetchAlmacenes(currentPage, currentSearch, sortColumn, sortDirection);
                    }
                  });
                });

              } catch (err) {
                console.error(err);
                showToast('Error al cargar almacenes', 'danger');
              }
            }

            // Inicial
            fetchAlmacenes();


            // Buscar
            searchInput.addEventListener('keyup', function() {
              currentSearch = this.value.trim();
              currentPage = 1;
              fetchAlmacenes(currentPage, currentSearch, sortColumn, sortDirection);
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
                fetchAlmacenes(currentPage, currentSearch, sortColumn, sortDirection);
              });
            });

            // Modal Crear
            const modalEl = document.getElementById('modalAlmacen');
            const modal = new bootstrap.Modal(modalEl);
            const form = document.getElementById('formAlmacen');
            const modalTitle = document.getElementById('modalAlmacenTitle');

            document.getElementById('btnNuevoAlmacen').addEventListener('click', () => {
              form.reset();
              document.getElementById('almacen_id').value = '';
              // estado por defecto activo
              document.getElementById('estado').value = '1';
              modalTitle.textContent = 'Nuevo Almacén';
            });

            function openEditFromRow(row) {
              form.reset();
              document.getElementById('almacen_id').value = row.dataset.id;
              document.getElementById('sucursal_id').value = row.dataset.sucursalId || '';
              document.getElementById('nombre').value = row.dataset.nombre || '';
              document.getElementById('estado').value = row.dataset.estado || '1';
              modalTitle.textContent = 'Editar Almacén';
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
                  title: '¿Eliminar almacén?',
                  text: 'Se marcará como inactivo (borrado lógico).',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Sí, eliminar',
                  cancelButtonText: 'Cancelar'
                }).then(async (result) => {
                  if (!result.isConfirmed) return;
                  try {
                    const res = await fetch(`{{ url('almacen') }}/${id}`, {
                      method: 'DELETE',
                      headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json'
                      }
                    });
                    const data = await res.json();
                    showToast(data.message ?? 'Eliminado', data.status === 'success' ? 'success' : 'danger');
                    fetchAlmacenes(currentPage, currentSearch, sortColumn, sortDirection);
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
              const id = document.getElementById('almacen_id').value;
              const url = id ? `{{ url('almacen') }}/${id}` : `{{ route('almacen.store') }}`;
              const method = 'POST';
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
                  fetchAlmacenes(currentPage, currentSearch, sortColumn, sortDirection);
                } else {
                  showToast(data.message || 'Error de validación', 'danger');
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

