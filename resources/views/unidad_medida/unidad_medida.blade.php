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
      <div class="col-12">
        <div class="card shadow-sm mb-3">
          <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="mb-0">Unidades de Medida</h5>
            <div class="d-flex gap-2 flex-wrap">
              <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalUM" id="btnNuevaUM">
                <i class="bx bx-plus-circle"></i> Nueva Unidad
              </button>
            </div>
          </div>

          <div class="card-body">
            <div class="row g-2 mb-3">
              <div class="col-md-6">
                <input type="text" id="search" class="form-control" placeholder="Buscar por nombre..." autocomplete="off">
              </div>
            </div>

            <div class="table-responsive d-none d-md-block">
              <table class="table table-striped align-middle" id="um-table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th data-column="nombre">Nombre</th>
                    <th data-column="estado">Estado</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>
                <tbody id="um-body">
                  <tr>
                    <td colspan="4" class="text-center">Cargando...</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div id="um-cards" class="d-md-none"></div>

            <nav>
              <ul class="pagination justify-content-center mt-3" id="um-pagination"></ul>
            </nav>
          </div>
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

        <script>
          const setupUnidadMedidaPage = () => {
            const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const tableBody = document.getElementById('um-body');
            const pagination = document.getElementById('um-pagination');
            const searchInput = document.getElementById('search');
            const form = document.getElementById('formUM');
            const modalEl = document.getElementById('modalUM');
            const modal = new bootstrap.Modal(modalEl);
            const modalTitle = document.getElementById('modalUMTitle');
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

            let currentPage = 1,
              sortColumn = '',
              sortDirection = 'asc',
              currentSearch = '';

            function showToast(message, type = "primary") {
              const toastEl = document.querySelector(".bs-toast");
              toastEl.className = `bs-toast toast toast-placement-ex m-2 fade bg-${type} top-0 end-0 hide`;
              toastEl.querySelector(".toast-body").textContent = message;
              const toast = new bootstrap.Toast(toastEl);
              toast.show();
            }

            async function fetchUM(page = 1, search = '') {
              try {
                showLoader('Cargando...');

                const url = new URL(`{{ route('unidad_medida.fetch') }}`, window.location.origin);
                url.searchParams.set('page', page);
                if (search) url.searchParams.set('search', search);

                const res = await fetch(url, {
                  headers: {
                    'Accept': 'application/json'
                  }
                });
                const data = await res.json();
                
                tableBody.innerHTML = '';
                if (!data.data || data.data.length === 0) {
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

                document.querySelectorAll('#um-pagination a').forEach(a => {
                  a.addEventListener('click', e => {
                    e.preventDefault();
                    const page = parseInt(a.dataset.page);
                    if (page >= 1 && page <= totalPages && page !== currentPage) {
                      currentPage = page;
                      fetchUM(currentPage, currentSearch);
                    }
                  });
                });

              } catch (err) {
                console.error(err);
                showToast('Error al cargar', 'danger');
              } finally {
                hideLoader();
              }
            }

            // Init
            fetchUM();

            // Buscar
            searchInput.addEventListener('keyup', function() {
              currentSearch = this.value.trim();
              currentPage = 1;
              fetchUM(currentPage, currentSearch);
            });

            // Abrir modal nuevo
            document.getElementById('btnNuevaUM').addEventListener('click', () => {
              form.reset();
              document.getElementById('um_id').value = '';
              document.getElementById('estado').value = '1';
              document.getElementById('formErrorsUM').classList.add('d-none');
              modalTitle.textContent = 'Nueva Unidad';
            });

            function openEditFromRow(row) {
              form.reset();
              document.getElementById('um_id').value = row.dataset.id;
              document.getElementById('nombre').value = row.dataset.nombre || '';
              document.getElementById('estado').value = row.dataset.estado || '1';
              document.getElementById('formErrorsUM').classList.add('d-none');
              modalTitle.textContent = 'Editar Unidad';
              modal.show();
            }

            tableBody.addEventListener('click', e => {
              const row = e.target.closest('tr[data-id]');
              if (!row) return;

              if (e.target.classList.contains('btn-edit')) {
                openEditFromRow(row);
              }

              if (e.target.classList.contains('btn-delete')) {
                const id = row.dataset.id;
                if (!confirm('¿Eliminar unidad de medida?')) return;
                showLoader('Eliminando...');  
                fetch(`{{ url('unidad-medida') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                      'X-CSRF-TOKEN': CSRF,
                      'Accept': 'application/json'
                    }
                  })
                  .then(r => r.json())
                  .then(d => {
                    showToast(d.message || 'Eliminado', d.status === 'success' ? 'success' : 'danger');
                    hideLoader();
                    fetchUM(currentPage, currentSearch);
                  })
                  .catch(() => {
                    showToast('Error al eliminar', 'danger');
                    hideLoader();
                  });
              }
            });

            form.addEventListener('submit', e => {
              e.preventDefault();
              const id = document.getElementById('um_id').value;
              const url = id ? `{{ url('unidad-medida') }}/${id}` : `{{ route('unidad_medida.store') }}`;
              const fd = new FormData(form);
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
                  showLoader('Cargando...');
                  if (d.status === 'success') {
                    showToast(d.message || 'Guardado', 'success');
                    hideLoader();
                    modal.hide();
                    fetchUM(currentPage, currentSearch);
                  } else {
                    showToast(d.message || 'Error', 'danger');
                    hideLoader();
                    const errs = d.errors || {};
                    const box = document.getElementById('formErrorsUM');
                    const list = document.getElementById('formErrorsListUM');
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

            window.__unidadMedidaReload = () => {
              fetchUM(1, currentSearch);
            };
          };

          const handleUnidadMedidaLoad = () => {
            const root = document.getElementById('um-table');
            if (!root) return;
            if (root.dataset.unidadMedidaInit === '1') {
              if (typeof window.__unidadMedidaReload === 'function') {
                window.__unidadMedidaReload();
              }
              return;
            }
            root.dataset.unidadMedidaInit = '1';
            setupUnidadMedidaPage();
          };

          document.addEventListener('turbo:load', handleUnidadMedidaLoad);
          document.addEventListener('DOMContentLoaded', handleUnidadMedidaLoad);
        </script>
      </div>
    </div>
  </main>
</x-layout>

<style>
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
  .compact-main {
    padding-top: 6px !important;
    padding-left: 8px !important;
    padding-right: 8px !important;
  }
              


</style>
