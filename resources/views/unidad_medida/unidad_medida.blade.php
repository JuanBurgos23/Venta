<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
      @vite(['resources/js/app.js'])
  
      <div class="container-fluid py-4">
        <div class="col-12">
          <div class="container py-4">
            <h3>Unidades de Medida</h3>
  
            <div class="mb-3 row g-2">
              <div class="col-md-6">
                <input type="text" id="search" class="form-control" placeholder="Buscar por nombre..." autocomplete="off">
              </div>
              <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUM" id="btnNuevaUM">
                  <i class="bx bx-plus"></i> Nueva Unidad
                </button>
              </div>
            </div>
  
            <div class="table-responsive">
              <table class="table table-striped table-hover" id="um-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th data-column="nombre">Nombre</th>
                    <th data-column="estado">Estado</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody id="um-body">
                  <tr><td colspan="4" class="text-center">Cargando...</td></tr>
                </tbody>
              </table>
            </div>
  
            <nav><ul class="pagination justify-content-center" id="um-pagination"></ul></nav>
          </div>
  
          {{-- Modal Crear/Editar UM --}}
          <div class="modal fade" id="modalUM" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <form id="formUM">
                  @csrf
                  <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalUMTitle">Nueva Unidad</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" id="um_id">
                    <div class="mb-3">
                      <label class="form-label">Nombre</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Estado</label>
                      <select class="form-select" id="estado" name="estado">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                      </select>
                    </div>
  
                    <div class="alert alert-danger d-none" id="formErrorsUM">
                      <ul class="mb-0" id="formErrorsListUM"></ul>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                    <button class="btn btn-primary" id="btnGuardarUM" type="submit">Guardar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
  
          {{-- Toast --}}
          <div class="position-fixed top-0 end-0 p-3" style="z-index:1080">
            <div class="toast bs-toast text-white bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="d-flex">
                <div class="toast-body">...</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
              </div>
            </div>
          </div>
  
          <script>
          document.addEventListener("DOMContentLoaded", function () {
            const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const tableBody = document.getElementById('um-body');
            const pagination = document.getElementById('um-pagination');
            const searchInput = document.getElementById('search');
            const form = document.getElementById('formUM');
            const modalEl = document.getElementById('modalUM');
            const modal = new bootstrap.Modal(modalEl);
            const modalTitle = document.getElementById('modalUMTitle');
  
            let currentPage = 1, sortColumn = '', sortDirection = 'asc', currentSearch = '';
  
            function showToast(message, type='primary'){
              const toastEl = document.querySelector('.bs-toast');
              toastEl.className = `bs-toast toast m-2 fade bg-${type} text-white show`;
              toastEl.querySelector('.toast-body').textContent = message;
              new bootstrap.Toast(toastEl).show();
            }
  
            async function fetchUM(page=1, search=''){
              try{
                const url = new URL(`{{ route('unidad_medida.fetch') }}`, window.location.origin);
                url.searchParams.set('page', page);
                if (search) url.searchParams.set('search', search);
  
                const res = await fetch(url, { headers: { 'Accept': 'application/json' }});
                const data = await res.json();
  
                tableBody.innerHTML = '';
                if (!data.data || data.data.length === 0){
                  tableBody.innerHTML = '<tr><td colspan="4" class="text-center">Sin registros</td></tr>';
                  pagination.innerHTML = '';
                  return;
                }
  
                data.data.forEach(row => {
                  tableBody.insertAdjacentHTML('beforeend', `
                    <tr data-id="${row.id}" data-nombre="${row.nombre}" data-estado="${row.estado}">
                      <td>${row.id}</td>
                      <td>${row.nombre ?? ''}</td>
                      <td>${+row.estado === 1 ? 'Activo' : 'Inactivo'}</td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-warning btn-edit">Editar</button>
                        <button class="btn btn-sm btn-danger btn-delete">Eliminar</button>
                      </td>
                    </tr>
                  `);
                });
  
                const totalPages = data.last_page;
                let pagHtml = `
                  <li class="page-item ${data.current_page===1?'disabled':''}">
                    <a href="#" class="page-link" data-page="${data.current_page-1}">Anterior</a>
                  </li>`;
                for(let i=1;i<=totalPages;i++){
                  pagHtml += `<li class="page-item ${i===data.current_page?'active':''}">
                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                  </li>`;
                }
                pagHtml += `
                  <li class="page-item ${data.current_page===totalPages?'disabled':''}">
                    <a href="#" class="page-link" data-page="${data.current_page+1}">Siguiente</a>
                  </li>`;
                pagination.innerHTML = pagHtml;
  
                document.querySelectorAll('#um-pagination a').forEach(a=>{
                  a.addEventListener('click', e=>{
                    e.preventDefault();
                    const page = parseInt(a.dataset.page);
                    if (page>=1 && page<=totalPages && page!==currentPage){
                      currentPage = page;
                      fetchUM(currentPage, currentSearch);
                    }
                  });
                });
  
              }catch(err){
                console.error(err);
                showToast('Error al cargar', 'danger');
              }
            }
  
            // Init
            fetchUM();
  
            // Buscar
            searchInput.addEventListener('keyup', function(){
              currentSearch = this.value.trim();
              currentPage = 1;
              fetchUM(currentPage, currentSearch);
            });
  
            // Abrir modal nuevo
            document.getElementById('btnNuevaUM').addEventListener('click', ()=>{
              form.reset();
              document.getElementById('um_id').value = '';
              document.getElementById('estado').value = '1';
              document.getElementById('formErrorsUM').classList.add('d-none');
              modalTitle.textContent = 'Nueva Unidad';
            });
  
            function openEditFromRow(row){
              form.reset();
              document.getElementById('um_id').value = row.dataset.id;
              document.getElementById('nombre').value = row.dataset.nombre || '';
              document.getElementById('estado').value = row.dataset.estado || '1';
              document.getElementById('formErrorsUM').classList.add('d-none');
              modalTitle.textContent = 'Editar Unidad';
              modal.show();
            }
  
            tableBody.addEventListener('click', e=>{
              const row = e.target.closest('tr[data-id]');
              if (!row) return;
  
              if (e.target.classList.contains('btn-edit')){
                openEditFromRow(row);
              }
  
              if (e.target.classList.contains('btn-delete')){
                const id = row.dataset.id;
                if (!confirm('¿Eliminar unidad de medida?')) return;
                fetch(`{{ url('unidad-medida') }}/${id}`, {
                  method: 'DELETE',
                  headers: { 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' }
                })
                .then(r=>r.json())
                .then(d=>{
                  showToast(d.message || 'Eliminado', d.status==='success'?'success':'danger');
                  fetchUM(currentPage, currentSearch);
                })
                .catch(()=>showToast('Error al eliminar','danger'));
              }
            });
  
            form.addEventListener('submit', e=>{
              e.preventDefault();
              const id = document.getElementById('um_id').value;
              const url = id ? `{{ url('unidad-medida') }}/${id}` : `{{ route('unidad_medida.store') }}`;
              const fd = new FormData(form);
              if (id) fd.append('_method','PUT');
  
              fetch(url, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept':'application/json' },
                body: fd
              })
              .then(r=>r.json())
              .then(d=>{
                if (d.status === 'success'){
                  showToast(d.message || 'Guardado', 'success');
                  modal.hide();
                  fetchUM(currentPage, currentSearch);
                } else {
                  showToast(d.message || 'Error', 'danger');
                  const errs = d.errors || {};
                  const box = document.getElementById('formErrorsUM');
                  const list = document.getElementById('formErrorsListUM');
                  list.innerHTML = '';
                  if (Object.keys(errs).length){
                    box.classList.remove('d-none');
                    Object.values(errs).forEach(arr=>{
                      const li=document.createElement('li');
                      li.textContent = arr[0];
                      list.appendChild(li);
                    });
                  } else {
                    box.classList.add('d-none');
                  }
                }
              })
              .catch(()=>showToast('Error al guardar','danger'));
            });
          });
          </script>
        </div>
      </div>
    </main>
  </x-layout>
  