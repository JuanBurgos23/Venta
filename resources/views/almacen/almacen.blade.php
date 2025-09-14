<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
      <nav class="navbar ..."></nav>
      @vite(['resources/js/app.js'])
  
      <div class="container-fluid py-4">
        <div class="col-12">
          <div class="container py-4">
            <h3>Almacenes</h3>
  
            <div class="mb-3 row g-2">
              <div class="col-md-6">
                <input type="text" id="search" class="form-control" placeholder="Buscar por nombre o sucursal..." autocomplete="off">
              </div>
              <div class="col-md-6 text-end">
                <div class="d-flex justify-content-end mb-3">
                  <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAlmacen" id="btnNuevoAlmacen">
                    <i class="bx bx-plus"></i> Nuevo Almacén
                  </button>
                </div>
              </div>
            </div>
  
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="almacenes-table">
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
                  <tr><td colspan="5" class="text-center">Cargando...</td></tr>
                </tbody>
              </table>
            </div>
  
            <nav><ul class="pagination justify-content-center" id="almacenes-pagination"></ul></nav>
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
          <div class="position-fixed top-0 end-0 p-3" style="z-index: 1080">
            <div class="toast bs-toast text-white bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="d-flex">
                <div class="toast-body">...</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
            </div>
          </div>
  
          <script>
          document.addEventListener("DOMContentLoaded", function () {
            // Helpers
            const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            function showToast(message, type='primary'){
              const toastEl = document.querySelector('.bs-toast');
              toastEl.className = `bs-toast toast m-2 fade bg-${type} text-white show`;
              toastEl.querySelector('.toast-body').textContent = message;
              const toast = new bootstrap.Toast(toastEl);
              toast.show();
            }
            function highlight(text, term) {
              if (!term) return text ?? '';
              const safe = (text ?? '').toString();
              return safe.replace(new RegExp(`(${term})`, 'gi'), '<mark>$1</mark>');
            }
  
            // Estado tabla
            const tableBody  = document.getElementById('almacenes-body');
            const pagination = document.getElementById('almacenes-pagination');
            const searchInput= document.getElementById('search');
            const tableHeaders = document.querySelectorAll('#almacenes-table th[data-column]');
            let currentPage = 1, sortColumn = '', sortDirection = 'asc', currentSearch = '';
  
            // Fetch
            async function fetchAlmacenes(page=1, search='', sortCol='', sortDir='') {
              try {
                const url = new URL(`{{ route('almacen.fetch') }}`, window.location.origin);
                url.searchParams.set('page', page);
                if (search)  url.searchParams.set('search', search);
                if (sortCol) url.searchParams.set('sort', sortCol);
                if (sortDir) url.searchParams.set('direction', sortDir);
  
                const res  = await fetch(url.toString(), { headers: { 'Accept': 'application/json' }});
                const data = await res.json();
  
                tableBody.innerHTML = '';
                if (!data.data || data.data.length === 0) {
                  tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Sin almacenes</td></tr>';
                  pagination.innerHTML = '';
                  return;
                }
  
                data.data.forEach(a => {
                  // Estado legible
                  const estadoTxt = (+a.estado === 1) ? 'Activo' : 'Inactivo';
  
                  tableBody.insertAdjacentHTML('beforeend', `
                    <tr data-id="${a.id}"
                        data-sucursal-id="${a.sucursal_id}"
                        data-sucursal-nombre="${a.sucursal?.nombre ?? ''}"
                        data-nombre="${a.nombre ?? ''}"
                        data-estado="${a.estado ?? 1}">
                      <td>${a.id}</td>
                      <td>${highlight(a.nombre ?? '', search)}</td>
                      <td>${highlight(a.sucursal?.nombre ?? '-', search)}</td>
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
                  <li class="page-item ${data.current_page===1?'disabled':''}">
                    <a href="#" class="page-link" data-page="${data.current_page-1}">Anterior</a>
                  </li>`;
                for (let i=1;i<=totalPages;i++){
                  pagHtml += `<li class="page-item ${i===data.current_page?'active':''}">
                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                  </li>`;
                }
                pagHtml += `
                  <li class="page-item ${data.current_page===totalPages?'disabled':''}">
                    <a href="#" class="page-link" data-page="${data.current_page+1}">Siguiente</a>
                  </li>`;
                pagination.innerHTML = pagHtml;
  
                document.querySelectorAll('#almacenes-pagination a').forEach(a=>{
                  a.addEventListener('click', (e)=>{
                    e.preventDefault();
                    const page = parseInt(a.dataset.page);
                    if (page>=1 && page<=totalPages && page!==currentPage){
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
            searchInput.addEventListener('keyup', function(){
              currentSearch = this.value.trim();
              currentPage = 1;
              fetchAlmacenes(currentPage, currentSearch, sortColumn, sortDirection);
            });
  
            // Ordenar
            tableHeaders.forEach(th=>{
              th.addEventListener('click', ()=>{
                const col = th.dataset.column;
                if (!col) return;
                if (sortColumn === col) sortDirection = (sortDirection==='asc') ? 'desc' : 'asc';
                else { sortColumn = col; sortDirection = 'asc'; }
                fetchAlmacenes(currentPage, currentSearch, sortColumn, sortDirection);
              });
            });
  
            // Modal Crear
            const modalEl = document.getElementById('modalAlmacen');
            const modal   = new bootstrap.Modal(modalEl);
            const form    = document.getElementById('formAlmacen');
            const modalTitle = document.getElementById('modalAlmacenTitle');
  
            document.getElementById('btnNuevoAlmacen').addEventListener('click', ()=>{
              form.reset();
              document.getElementById('almacen_id').value = '';
              // estado por defecto activo
              document.getElementById('estado').value = '1';
              modalTitle.textContent = 'Nuevo Almacén';
            });
  
            function openEditFromRow(row){
              form.reset();
              document.getElementById('almacen_id').value  = row.dataset.id;
              document.getElementById('sucursal_id').value = row.dataset.sucursalId || '';
              document.getElementById('nombre').value      = row.dataset.nombre || '';
              document.getElementById('estado').value      = row.dataset.estado || '1';
              modalTitle.textContent = 'Editar Almacén';
              modal.show();
            }
  
            // Click en editar/eliminar
            tableBody.addEventListener('click', (e)=>{
              const row = e.target.closest('tr[data-id]');
              if (!row) return;
  
              // Editar
              if (e.target.classList.contains('btn-edit')){
                openEditFromRow(row);
              }
  
              // Eliminar
              if (e.target.classList.contains('btn-delete')){
                const id = row.dataset.id;
                Swal.fire({
                  title: '¿Eliminar almacén?',
                  text: 'Se marcará como inactivo (borrado lógico).',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonText: 'Sí, eliminar',
                  cancelButtonText: 'Cancelar'
                }).then(async (result)=>{
                  if (!result.isConfirmed) return;
                  try{
                    const res = await fetch(`{{ url('almacen') }}/${id}`, {
                      method: 'DELETE',
                      headers: { 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' }
                    });
                    const data = await res.json();
                    showToast(data.message ?? 'Eliminado', data.status==='success'?'success':'danger');
                    fetchAlmacenes(currentPage, currentSearch, sortColumn, sortDirection);
                  }catch(err){
                    console.error(err);
                    showToast('Error al eliminar', 'danger');
                  }
                });
              }
            });
  
            // Guardar (crear/actualizar)
            form.addEventListener('submit', async (e)=>{
              e.preventDefault();
              const id = document.getElementById('almacen_id').value;
              const url = id ? `{{ url('almacen') }}/${id}` : `{{ route('almacen.store') }}`;
              const method = 'POST';
              const fd = new FormData(form);
              if (id) fd.append('_method', 'PUT');
  
              try{
                const res = await fetch(url, {
                  method,
                  headers: { 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' },
                  body: fd
                });
  
                const data = await res.json();
                if (data.status === 'success'){
                  showToast(data.message || 'Guardado', 'success');
                  modal.hide();
                  fetchAlmacenes(currentPage, currentSearch, sortColumn, sortDirection);
                }else{
                  showToast(data.message || 'Error de validación', 'danger');
                  const errs = data.errors || {};
                  const list = document.getElementById('formErrorsList');
                  const box  = document.getElementById('formErrors');
                  list.innerHTML = '';
                  if (Object.keys(errs).length){
                    box.classList.remove('d-none');
                    Object.values(errs).forEach(arr=>{
                      const li = document.createElement('li');
                      li.textContent = arr[0];
                      list.appendChild(li);
                    });
                  } else {
                    box.classList.add('d-none');
                  }
                }
              }catch(err){
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
  