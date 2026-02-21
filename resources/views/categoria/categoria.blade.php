{{-- resources/views/categoria/categoria_subcategoria.blade.php --}}
<x-layout bodyClass="g-sidenav-show bg-gray-200">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg compact-main">
    @vite(['resources/js/app.js'])
          <div class="venta-loader" id="venta-loader" aria-hidden="true">
              <div class="venta-loader-card">
                  <svg stroke="hsl(228, 97%, 42%)" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="venta-loader-icon" aria-label="Cargando" role="img"><g><circle cx="12" cy="12" r="9.5" fill="none" stroke-width="3" stroke-linecap="round"><animate attributeName="stroke-dasharray" dur="1.5s" calcMode="spline" values="0 150;42 150;42 150;42 150" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/><animate attributeName="stroke-dashoffset" dur="1.5s" calcMode="spline" values="0;-16;-59;-59" keyTimes="0;0.475;0.95;1" keySplines="0.42,0,0.58,1;0.42,0,0.58,1;0.42,0,0.58,1" repeatCount="indefinite"/></circle><animateTransform attributeName="transform" type="rotate" dur="2s" values="0 12 12;360 12 12" repeatCount="indefinite"/></g></svg>
                  <div class="venta-loader-text" id="venta-loader-text">Cargando...</div>
              </div>
          </div>
    <div class="container-fluid py-2 px-2">
      <div class="col-12 p-0">
        <div class="card shadow-sm">
          
          <div class="card-header">
            <h5 class="mb-0">Categorías & Subcategorías</h5>
          </div>
          <div class="card-body">

          <div class="row g-3">
            {{-- =================== CATEGORÍAS (Columna Izquierda) =================== --}}
            <div class="col-lg-6">
              <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <div class="w-50 me-2">
                    <input type="text" id="cat-search" class="form-control" placeholder="Buscar categorías..." autocomplete="off">
                  </div>
                  <button class="btn btn-primary" id="btnNuevaCat" data-bs-toggle="modal" data-bs-target="#modalCat">
                    <i class="bx bx-plus"></i> Nueva Categoría
                  </button>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover" id="cat-table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nombre</th>
                          <th>Descripción</th>
                          <th>Estado</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody id="cat-body">
                        <tr>
                          <td colspan="5" class="text-center">Cargando...</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <nav>
                    <ul class="pagination justify-content-center" id="cat-pagination"></ul>
                  </nav>
                </div>
              </div>
            </div>

            {{-- =================== SUBCATEGORÍAS (Columna Derecha) =================== --}}
            <div class="col-lg-6">
              <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center gap-2">
                    <span class="fw-semibold">Subcategorías de:</span>
                    <span id="cat-seleccionada" class="badge bg-label-primary">—</span>
                  </div>
                  <div class="d-flex align-items-center gap-2">
                    <input type="text" id="subcat-search" class="form-control" placeholder="Buscar subcategorías..." autocomplete="off" style="max-width: 250px;">
                    <button class="btn btn-secondary" id="btnRefrescarSub">Refrescar</button>
                    <button class="btn btn-primary" id="btnNuevaSub" data-bs-toggle="modal" data-bs-target="#modalSub" disabled>
                      <i class="bx bx-plus"></i> Nueva Subcategoría
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div class="alert alert-info py-2 mb-3" id="hintSubSel">
                    Selecciona una <strong>categoría</strong> de la lista de la izquierda para ver y gestionar sus subcategorías.
                  </div>

                  <div class="table-responsive">
                    <table class="table table-hover" id="subcat-table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nombre</th>
                          <th>Descripción</th>
                          <th>Estado</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody id="subcat-body">
                        <tr>
                          <td colspan="5" class="text-center">Sin datos</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <nav>
                    <ul class="pagination justify-content-center" id="subcat-pagination"></ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>

        {{-- =================== MODAL CATEGORÍA =================== --}}
        <div class="modal fade" id="modalCat" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form id="formCat">
                @csrf
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title" id="modalCatTitle">Nueva Categoría</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="cat_id">
                  <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="cat_nombre" name="nombre" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="cat_descripcion" name="descripcion">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select class="form-select" id="cat_estado" name="estado">
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                    </select>
                  </div>
                  <div class="alert alert-danger d-none" id="formErrorsCat">
                    <ul class="mb-0" id="formErrorsListCat"></ul>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                  <button class="btn btn-primary" id="btnGuardarCat" type="submit">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        {{-- =================== MODAL SUBCATEGORÍA =================== --}}
        <div class="modal fade" id="modalSub" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <form id="formSub">
                @csrf
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title" id="modalSubTitle">Nueva Subcategoría</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="sub_id">
                  <input type="hidden" id="sub_categoria_id">
                  <div class="mb-2">
                    <small class="text-muted">Categoría</small><br>
                    <span class="badge bg-label-primary" id="sub_categoria_nombre">—</span>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="sub_nombre" name="nombre" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <input type="text" class="form-control" id="sub_descripcion" name="descripcion">
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Estado</label>
                    <select class="form-select" id="sub_estado" name="estado">
                      <option value="1">Activo</option>
                      <option value="0">Inactivo</option>
                    </select>
                  </div>
                  <div class="alert alert-danger d-none" id="formErrorsSub">
                    <ul class="mb-0" id="formErrorsListSub"></ul>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                  <button class="btn btn-primary" id="btnGuardarSub" type="submit">Guardar</button>
                </div>
              </form>
            </div>
          </div>
        </div>


        <script>
          const setupCategoriaPage = () => {
            const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // ======== Helpers ========
            function showToast(message, type = 'primary') {
              const toastEl = document.querySelector(".bs-toast");
              if (!toastEl) return;
              toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide show`;
              toastEl.querySelector(".toast-body").textContent = message;
              const toast = new bootstrap.Toast(toastEl);
              toast.show();
            }
            const asInt = v => parseInt(v, 10) || 0;

            // ======== Estado global ========
            let CAT_PAGE = 1,
              CAT_SEARCH = '';
            let SUB_PAGE = 1,
              SUB_SEARCH = '';
            let CAT_ACTIVE_ID = null;
            let CAT_ACTIVE_NAME = null;

            // ======== DOM CATEGORÍAS ========
            const catBody = document.getElementById('cat-body');
            const catPag = document.getElementById('cat-pagination');
            const catSearch = document.getElementById('cat-search');
            const modalCat = new bootstrap.Modal(document.getElementById('modalCat'));
            const formCat = document.getElementById('formCat');
            const catTitle = document.getElementById('modalCatTitle');

            // ======== DOM SUBCATEGORÍAS ========
            const subBody = document.getElementById('subcat-body');
            const subPag = document.getElementById('subcat-pagination');
            const subSearch = document.getElementById('subcat-search');
            const btnNuevaSub = document.getElementById('btnNuevaSub');
            const btnRefrescarSub = document.getElementById('btnRefrescarSub');
            const hintSubSel = document.getElementById('hintSubSel');
            const catSelBadge = document.getElementById('cat-seleccionada');

            const modalSub = new bootstrap.Modal(document.getElementById('modalSub'));
            const formSub = document.getElementById('formSub');
            const subTitle = document.getElementById('modalSubTitle');
            const subCatIdInput = document.getElementById('sub_categoria_id');
            const subCatNameLabel = document.getElementById('sub_categoria_nombre');
            const loaderEl = document.getElementById('venta-loader');
            const loaderTextEl = document.getElementById('venta-loader-text');
            let loaderCount = 0;

            const showLoader = (text = 'Cargando...') => {
                loaderCount += 1;
                if (loaderTextEl) loaderTextEl.textContent = text;
                loaderEl?.classList.add('is-active');
                loaderEl?.setAttribute('aria-hidden', 'false');
            };

            const hideLoader = () => {
                loaderCount = Math.max(0, loaderCount - 1);
                if (loaderCount === 0) {
                    loaderEl?.classList.remove('is-active');
                    loaderEl?.setAttribute('aria-hidden', 'true');
                }
            };

            // ======================== FETCH CATEGORÍAS ========================
            async function fetchCategorias(page = 1, search = '') {
              try {
                                                showLoader('Cargando...');
                const url = new URL(`{{ route('categorias.fetch') }}`, window.location.origin);
                url.searchParams.set('page', page);
                if (search) url.searchParams.set('search', search);

                const res = await fetch(url, {
                  headers: {
                    'Accept': 'application/json'
                  }
                });
                const data = await res.json();

                catBody.innerHTML = '';
                if (!data.data || data.data.length === 0) {
                  catBody.innerHTML = '<tr><td colspan="5" class="text-center">Sin categorías</td></tr>';
                  catPag.innerHTML = '';
                  return;
                }

                data.data.forEach(c => {
                  catBody.insertAdjacentHTML('beforeend', `
                    <tr class="cat-row ${c.id==CAT_ACTIVE_ID?'table-primary':''}" data-id="${c.id}" data-nombre="${c.nombre}" data-descripcion="${c.descripcion??''}" data-estado="${c.estado}">
                      <td>${c.id}</td>
                      <td>${c.nombre??''}</td>
                      <td>${c.descripcion??''}</td>
                      <td>${+c.estado===1?'Activo':'Inactivo'}</td>
                      <td class="text-center">
                        <div class="btn-group">
                          <button class="btn btn-sm btn-outline-secondary btn-sub">Subcategorías</button>
                          <button class="btn btn-sm btn-warning btn-edit">Editar</button>
                          <button class="btn btn-sm btn-danger btn-del">Eliminar</button>
                        </div>
                      </td>
                    </tr>
                  `);
                });

                // paginación
                const totalPages = data.last_page;
                let html = `
                  <li class="page-item ${data.current_page===1?'disabled':''}">
                    <a href="#" class="page-link" data-page="${data.current_page-1}">Anterior</a>
                  </li>`;
                for (let i = 1; i <= totalPages; i++) {
                  html += `<li class="page-item ${i===data.current_page?'active':''}">
                    <a href="#" class="page-link" data-page="${i}">${i}</a>
                  </li>`;
                }
                html += `
                  <li class="page-item ${data.current_page===totalPages?'disabled':''}">
                    <a href="#" class="page-link" data-page="${data.current_page+1}">Siguiente</a>
                  </li>`;
                catPag.innerHTML = html;

                catPag.querySelectorAll('a').forEach(a => {
                  a.addEventListener('click', e => {
                    e.preventDefault();
                    const p = asInt(a.dataset.page);
                    if (p >= 1 && p <= totalPages && p !== CAT_PAGE) {
                      CAT_PAGE = p;
                      fetchCategorias(CAT_PAGE, CAT_SEARCH);
                    }
                  });
                });
                     hideLoader();
              } catch (e) {
                console.error(e);
                showToast('Error al cargar categorías', 'danger');
                  hideLoader();
              }
            }

            // ======================== FETCH SUBCATEGORÍAS ========================
            async function fetchSubcategorias(page = 1, search = '') {
              if (!CAT_ACTIVE_ID) {
                subBody.innerHTML = '<tr><td colspan="5" class="text-center">Seleccione una categoría</td></tr>';
                subPag.innerHTML = '';
                return;
              }
              try {
                  showLoader('Cargando subcategorías...');
                const url = new URL(`{{ route('subcategorias.fetch') }}`, window.location.origin);
                url.searchParams.set('page', page);
                url.searchParams.set('categoria_id', CAT_ACTIVE_ID);
                if (search) url.searchParams.set('search', search);

                const res = await fetch(url, {
                  headers: {
                    'Accept': 'application/json'
                  }
                });
                const data = await res.json();

                subBody.innerHTML = '';
                if (!data.data || data.data.length === 0) {
                  subBody.innerHTML = '<tr><td colspan="5" class="text-center">Sin subcategorías</td></tr>';
                  subPag.innerHTML = '';
                } else {
                  data.data.forEach(s => {
                    subBody.insertAdjacentHTML('beforeend', `
                      <tr class="sub-row" data-id="${s.id}" data-nombre="${s.nombre}" data-descripcion="${s.descripcion??''}" data-estado="${s.estado}">
                        <td>${s.id}</td>
                        <td>${s.nombre??''}</td>
                        <td>${s.descripcion??''}</td>
                        <td>${+s.estado===1?'Activo':'Inactivo'}</td>
                        <td class="text-center">
                          <div class="btn-group">
                            <button class="btn btn-sm btn-warning btn-edit-sub">Editar</button>
                            <button class="btn btn-sm btn-danger btn-del-sub">Eliminar</button>
                          </div>
                        </td>
                      </tr>
                    `);
                  });

                  const totalPages = data.last_page;
                  let html = `
                    <li class="page-item ${data.current_page===1?'disabled':''}">
                      <a href="#" class="page-link" data-page="${data.current_page-1}">Anterior</a>
                    </li>`;
                  for (let i = 1; i <= totalPages; i++) {
                    html += `<li class="page-item ${i===data.current_page?'active':''}">
                      <a href="#" class="page-link" data-page="${i}">${i}</a>
                    </li>`;
                  }
                  html += `
                    <li class="page-item ${data.current_page===totalPages?'disabled':''}">
                      <a href="#" class="page-link" data-page="${data.current_page+1}">Siguiente</a>
                    </li>`;
                  subPag.innerHTML = html;

                  subPag.querySelectorAll('a').forEach(a => {
                    a.addEventListener('click', e => {
                      e.preventDefault();
                      const p = asInt(a.dataset.page);
                      if (p >= 1 && p <= totalPages && p !== SUB_PAGE) {
                        SUB_PAGE = p;
                        fetchSubcategorias(SUB_PAGE, SUB_SEARCH);
                      }
                    });
                  });
                }
                      hideLoader();
              } catch (e) {
                console.error(e);
                showToast('Error al cargar subcategorías', 'danger');
                  hideLoader();
              }
            }

            // ======================== INIT ========================
            fetchCategorias();

            // ======================== BUSCAR ========================
            catSearch.addEventListener('keyup', function() {
              CAT_SEARCH = this.value.trim();
              CAT_PAGE = 1;
              fetchCategorias(CAT_PAGE, CAT_SEARCH);
            });
            subSearch.addEventListener('keyup', function() {
              SUB_SEARCH = this.value.trim();
              SUB_PAGE = 1;
              fetchSubcategorias(SUB_PAGE, SUB_SEARCH);
            });

            // ======================== NUEVA CATEGORÍA ========================
            document.getElementById('btnNuevaCat').addEventListener('click', () => {
              formCat.reset();
              document.getElementById('cat_id').value = '';
              document.getElementById('cat_estado').value = '1';
              document.getElementById('formErrorsCat').classList.add('d-none');
              catTitle.textContent = 'Nueva Categoría';
            });

            // ======================== CLICK EN FILA CATEGORÍA ========================
            catBody.addEventListener('click', (e) => {
              const row = e.target.closest('tr.cat-row');
              if (!row) return;

              // seleccionar para subcategorías
              if (e.target.classList.contains('btn-sub') || e.target.closest('.btn-sub')) {
                CAT_ACTIVE_ID = asInt(row.dataset.id);
                CAT_ACTIVE_NAME = row.dataset.nombre || '';
                // marcar visual
                catBody.querySelectorAll('tr').forEach(r => r.classList.remove('table-primary'));
                row.classList.add('table-primary');

                // activar UI subcategorías
                hintSubSel.classList.add('d-none');
                btnNuevaSub.disabled = false;
                catSelBadge.textContent = `${CAT_ACTIVE_ID} — ${CAT_ACTIVE_NAME}`;

                SUB_PAGE = 1;
                SUB_SEARCH = '';
                subSearch.value = '';
                fetchSubcategorias(SUB_PAGE, SUB_SEARCH);
                return;
              }

              // editar
              if (e.target.classList.contains('btn-edit')) {
                formCat.reset();
                document.getElementById('cat_id').value = row.dataset.id;
                document.getElementById('cat_nombre').value = row.dataset.nombre || '';
                document.getElementById('cat_descripcion').value = row.dataset.descripcion || '';
                document.getElementById('cat_estado').value = row.dataset.estado || '1';
                document.getElementById('formErrorsCat').classList.add('d-none');
                catTitle.textContent = 'Editar Categoría';
                modalCat.show();
                return;
              }

              // eliminar
              if (e.target.classList.contains('btn-del')) {
                const id = row.dataset.id;
                if (!confirm('¿Eliminar categoría?')) return;
                fetch(`{{ url('categorias') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                      'X-CSRF-TOKEN': CSRF,
                      'Accept': 'application/json'
                    }
                  })
                  .then(r => r.json())
                  .then(d => {
                    showToast(d.message || 'Eliminado', d.status === 'success' ? 'success' : 'danger');
                    // si borramos la activa, limpiar panel derecho
                    if (CAT_ACTIVE_ID && +CAT_ACTIVE_ID === +id) {
                      CAT_ACTIVE_ID = null;
                      CAT_ACTIVE_NAME = null;
                      btnNuevaSub.disabled = true;
                      catSelBadge.textContent = '—';
                      subBody.innerHTML = '<tr><td colspan="5" class="text-center">Sin datos</td></tr>';
                      subPag.innerHTML = '';
                      hintSubSel.classList.remove('d-none');
                    }
                    fetchCategorias(CAT_PAGE, CAT_SEARCH);
                  })
                  .catch(() => showToast('Error al eliminar', 'danger'));
              }
            });

            // ======================== GUARDAR CATEGORÍA ========================
            formCat.addEventListener('submit', (e) => {
              e.preventDefault();
              showLoader('Guardando...');
              const id = document.getElementById('cat_id').value;
              const url = id ? `{{ url('categorias') }}/${id}` : `{{ route('categorias.store') }}`;
              const fd = new FormData(formCat);
              if (id) fd.append('_method', 'PUT');

              fetch(url, {
                  method: 'POST',
                  headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                  },
                  body: fd
                })
                .then(r => r.json())
                .then(d => {
                  if (d.status === 'success') {
                    showToast(d.message || 'Guardado', 'success');
                    modalCat.hide();
                    hideLoader();
                    fetchCategorias(CAT_PAGE, CAT_SEARCH);
                  } else {
                    showToast(d.message || 'Error', 'danger');
                    const errs = d.errors || {};
                    const box = document.getElementById('formErrorsCat');
                    const list = document.getElementById('formErrorsListCat');
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
                })
                .catch(() => showToast('Error al guardar', 'danger'));
            });

            // ======================== NUEVA SUBCATEGORÍA ========================
            document.getElementById('btnNuevaSub').addEventListener('click', () => {
              if (!CAT_ACTIVE_ID) return;
              formSub.reset();
              document.getElementById('sub_id').value = '';
              document.getElementById('sub_estado').value = '1';
              document.getElementById('formErrorsSub').classList.add('d-none');
              subCatIdInput.value = CAT_ACTIVE_ID;
              subCatNameLabel.textContent = `${CAT_ACTIVE_ID} — ${CAT_ACTIVE_NAME}`;
              subTitle.textContent = 'Nueva Subcategoría';
            });

            // refrescar subcategorías
            btnRefrescarSub.addEventListener('click', () => {
              if (!CAT_ACTIVE_ID) return;
              fetchSubcategorias(SUB_PAGE, SUB_SEARCH);
            });

            // ======================== CLICK EN SUBCATEGORÍA ========================
            subBody.addEventListener('click', (e) => {
              const row = e.target.closest('tr.sub-row');
              if (!row) return;

              // editar
              if (e.target.classList.contains('btn-edit-sub')) {
                formSub.reset();
                document.getElementById('sub_id').value = row.dataset.id;
                document.getElementById('sub_nombre').value = row.dataset.nombre || '';
                document.getElementById('sub_descripcion').value = row.dataset.descripcion || '';
                document.getElementById('sub_estado').value = row.dataset.estado || '1';
                document.getElementById('formErrorsSub').classList.add('d-none');
                subCatIdInput.value = CAT_ACTIVE_ID;
                subCatNameLabel.textContent = `${CAT_ACTIVE_ID} — ${CAT_ACTIVE_NAME}`;
                subTitle.textContent = 'Editar Subcategoría';
                modalSub.show();
                return;
              }

              // eliminar
              if (e.target.classList.contains('btn-del-sub')) {
                const id = row.dataset.id;
                if (!confirm('¿Eliminar subcategoría?')) return;
                fetch(`{{ url('subcategorias') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                      'X-CSRF-TOKEN': CSRF,
                      'Accept': 'application/json'
                    }
                  })
                  .then(r => r.json())
                  .then(d => {
                    showToast(d.message || 'Eliminado', d.status === 'success' ? 'success' : 'danger');
                    fetchSubcategorias(SUB_PAGE, SUB_SEARCH);
                  })
                  .catch(() => showToast('Error al eliminar', 'danger'));
              }
            });

            // ======================== GUARDAR SUBCATEGORÍA ========================
            formSub.addEventListener('submit', (e) => {
              e.preventDefault();
              if (!CAT_ACTIVE_ID) return;

              const id = document.getElementById('sub_id').value;
              const url = id ? `{{ url('subcategorias') }}/${id}` : `{{ route('subcategorias.store') }}`;
              const fd = new FormData(formSub);
              if (id) fd.append('_method', 'PUT');
              // asegurar categoria_id
              fd.set('categoria_id', CAT_ACTIVE_ID);

              fetch(url, {
                  method: 'POST',
                  headers: {
                    'X-CSRF-TOKEN': CSRF,
                    'Accept': 'application/json'
                  },
                  body: fd
                })
                .then(r => r.json())
                .then(d => {
                  if (d.status === 'success') {
                    showToast(d.message || 'Guardado', 'success');
                    modalSub.hide();
                    fetchSubcategorias(SUB_PAGE, SUB_SEARCH);
                  } else {
                    showToast(d.message || 'Error', 'danger');
                    const errs = d.errors || {};
                    const box = document.getElementById('formErrorsSub');
                    const list = document.getElementById('formErrorsListSub');
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
                })
                .catch(() => showToast('Error al guardar', 'danger'));
            });

            window.__categoriaReload = () => {
              fetchCategorias(1, CAT_SEARCH);
              if (CAT_ACTIVE_ID) {
                fetchSubcategorias(1, SUB_SEARCH);
              }
            };
          };

          const handleCategoriaLoad = () => {
            const root = document.getElementById('cat-table');
            if (!root) return;
            if (root.dataset.categoriaInit === '1') {
              if (typeof window.__categoriaReload === 'function') {
                window.__categoriaReload();
              }
              return;
            }
            root.dataset.categoriaInit = '1';
            setupCategoriaPage();
          };

          document.addEventListener('turbo:load', handleCategoriaLoad);
          document.addEventListener('DOMContentLoaded', handleCategoriaLoad);
        </script>
      </div>
    </div>
  </main>
  <style>
  .compact-main {
    padding-top: 6px !important;
    padding-left: 8px !important;
    padding-right: 8px !important;
  }
  /* Loader overlay */
.venta-loader {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(15, 23, 42, 0.35);
    backdrop-filter: blur(2px);
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
}
.venta-loader.is-active {
    opacity: 1;
    pointer-events: all;
}
.venta-loader-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.venta-loader-icon {
    width: 36px;
    height: 36px;
}
.venta-loader-text {
    font-weight: 600;
    color: #1f2937;
}
[data-bs-theme="dark"] .venta-loader-card {
    background: #0f172a;
    color: #e5e7eb;
    border: 1px solid #1f2937;
}
[data-bs-theme="dark"] .venta-loader-text {
    color: #e5e7eb;
}

/* ===== Dark theme overrides ===== */
[data-bs-theme="dark"] {
    --primary-color: #e2e8f0;
    --secondary-color: #60a5fa;
    --accent-color: #3b82f6;
    --light-color: #122143;
    --medium-color: #1a2b46;
    --dark-color: #cbd5f5;
    --box-shadow: 0 6px 18px rgba(21, 26, 68, 0.35);
    --box-shadow-hover: 0 12px 26px rgba(20, 22, 75, 0.45);
}

[data-bs-theme="dark"] .venta-container {
    background: #0b1220;
}

[data-bs-theme="dark"] .venta-header,
[data-bs-theme="dark"] .venta-main-card {
    background: #1b2844;
    border-color: #1f2b3d;
}

[data-bs-theme="dark"] .venta-header h6,
[data-bs-theme="dark"] .search-header h4,
[data-bs-theme="dark"] .carrito-header h6,
[data-bs-theme="dark"] .section-title,
[data-bs-theme="dark"] .summary-label,
[data-bs-theme="dark"] .summary-value {
    color: #e5e7eb;
}

[data-bs-theme="dark"] .venta-header-info .info-item,
[data-bs-theme="dark"] .text-muted {
    color: #cbd5e1 !important;
}

[data-bs-theme="dark"] .venta-header .form-control-sm,
[data-bs-theme="dark"] .venta-header .form-select-sm,
[data-bs-theme="dark"] .search-box .form-control,
[data-bs-theme="dark"] .input-group-text {
    background: #0f172a;
    border-color: #1f2937;
    color: #e5e7eb;
}

[data-bs-theme="dark"] .venta-header .text-dark {
    color: #e5e7eb !important;
}

[data-bs-theme="dark"] .quick-client-card,
[data-bs-theme="dark"] .client-card {
    background: #0f172a;
    border-color: #1f2937;
}

[data-bs-theme="dark"] .quick-inline-input,
[data-bs-theme="dark"] .summary-inline-input {
    color: #e5e7eb;
    border-bottom-color: #334155;
}

[data-bs-theme="dark"] .summary-inline-input:focus,
[data-bs-theme="dark"] .quick-inline-input:focus {
    background: #0b1426;
}

[data-bs-theme="dark"] .carrito-section {
    background: transparent;
}

[data-bs-theme="dark"] .carrito-header {
    border-bottom-color: #1f2937;
}

[data-bs-theme="dark"] .input-group-pro label {
    color: #cbd5e1;
}

[data-bs-theme="dark"] .input-group-pro input,
[data-bs-theme="dark"] .input-group-pro select {
    background: #0f172a;
    border-color: #1f2937;
    color: #e5e7eb;
}

[data-bs-theme="dark"] .input-group-pro input:focus,
[data-bs-theme="dark"] .input-group-pro select:focus {
    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.2);
}

[data-bs-theme="dark"] .product-card-pro {
    background: #0f172a;
    border-color: #1f2937;
}

[data-bs-theme="dark"] .product-header-pro {
    background: #111827;
    border-bottom-color: #1f2937;
}

[data-bs-theme="dark"] .product-image-pro {
    background: #0b1426;
}

[data-bs-theme="dark"] .product-info-pro {
    color: #e5e7eb;
}

[data-bs-theme="dark"] .product-title-pro {
    color: #e5e7eb;
}

[data-bs-theme="dark"] .product-specs-pro {
    border-top-color: #1f2937;
}

[data-bs-theme="dark"] .spec-label-pro {
    color: #cbd5e1;
}

[data-bs-theme="dark"] .spec-value-pro {
    color: #e5e7eb;
}

[data-bs-theme="dark"] .price-unit-pro {
    color: #cbd5e1;
}
</style>
</x-layout>

