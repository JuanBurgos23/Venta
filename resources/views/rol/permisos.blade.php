<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <nav class="navbar ..."></nav>
        <!-- Scripts -->
        @vite([ 'resources/js/app.js'])
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="mb-1">Gestión de Permisos a Pantallas</h4>
                        <p class="mb-0">Controla qué pantallas y funcionalidades puede acceder cada rol del sistema.</p>
                    </div>
                    <div class="d-flex align-items-center">
                        <form method="POST" action="{{ route('permisos.pantallas.sync') }}" class="me-3">
                            @csrf
                            <button class="btn btn-sm btn-outline-dark" type="submit">
                                <i class="fas fa-sync me-1"></i> Sincronizar pantallas
                            </button>
                        </form>
                        <div class="form-check form-switch me-3">
                            <input class="form-check-input" type="checkbox" id="toggleAllPermissions">
                            <label class="form-check-label" for="toggleAllPermissions">Ver todos los permisos</label>
                        </div>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#helpModal">
                            <i class="fas fa-question-circle me-1"></i> Ayuda
                        </button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-3 mb-4">
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Roles</p>
                                            <h5 class="font-weight-bolder mb-0">
                                                {{ $roles->count() }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                            <i class="fas fa-users text-lg opacity-10"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Pantallas Activas</p>
                                            <h5 class="font-weight-bolder mb-0">
                                                {{ $pantallasActivas }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                            <i class="fas fa-desktop text-lg opacity-10"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Permisos Asignados</p>
                                            <h5 class="font-weight-bolder mb-0">
                                                {{ $permisosAsignados }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                            <i class="fas fa-key text-lg opacity-10"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-capitalize font-weight-bold">Última Actualización</p>
                                            <h5 class="font-weight-bolder mb-0">
                                                {{ $ultimaActualizacion ? \Carbon\Carbon::parse($ultimaActualizacion)->format('Y-m-d H:i') : '—' }}
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end">
                                        <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                            <i class="fas fa-sync text-lg opacity-10"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Permissions Table -->
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6>Permisos por Rol</h6>
                            <div class="d-flex">
                                <div class="input-group input-group-outline me-2" style="width: 250px;">
                                    <label class="form-label">Buscar pantalla...</label>
                                    <input type="text" class="form-control" id="searchScreen">
                                </div>
                                <button class="btn btn-outline-primary btn-sm" id="expandAll">
                                    <i class="fas fa-expand-alt me-1"></i> Expandir Todo
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-4">Pantalla / Módulo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Descripción</th>
                                        @foreach($roles as $role)
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center" data-role-id="{{ $role->id }}">
                                            <div class="d-flex flex-column align-items-center">
                                                <span>{{ $role->nombre }}</span>
                                                <small class="text-xs text-muted">{{ $role->users_count ?? 0 }} usuarios</small>
                                            </div>
                                        </th>
                                        @endforeach
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modulos as $modulo)
                                        <tr class="parent-screen bg-gray-100">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <button class="btn btn-link btn-sm text-dark me-2 toggle-children" data-screen-id="mod-{{ $modulo->id }}">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </button>
                                                    <div>
                                                        <h6 class="mb-0 text-sm">{{ $modulo->nombre }}</h6>
                                                        <p class="text-xs text-secondary mb-0">Módulo</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center text-xs text-secondary">—</td>
                                            @foreach($roles as $role)
                                                <td class="text-center align-middle text-xs text-secondary">—</td>
                                            @endforeach
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-info toggle-module-permissions" data-screen-id="mod-{{ $modulo->id }}">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        @foreach($modulo->pantallas as $pantalla)
                                            <tr class="child-screen d-none" data-parent="mod-{{ $modulo->id }}">
                                                <td class="ps-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-desktop text-sm me-2 text-primary"></i>
                                                        <div>
                                                            <h6 class="mb-0 text-sm">{{ $pantalla->nombre }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $pantalla->route_name }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <p class="text-xs text-secondary mb-0">{{ $pantalla->uri }}</p>
                                                </td>
                                                @foreach($roles as $role)
                                                    @php
                                                        $has = isset($rolePermMap[$role->id][$pantalla->id]);
                                                    @endphp
                                                    <td class="text-center align-middle">
                                                        <div class="form-check form-switch d-inline-block">
                                                            <input class="form-check-input permission-checkbox"
                                                                   type="checkbox"
                                                                   data-role-id="{{ $role->id }}"
                                                                   data-screen-id="{{ $pantalla->id }}"
                                                                   {{ $has ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                @endforeach
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-link text-info"
                                                            data-bs-toggle="tooltip"
                                                            title="Ver detalles"
                                                            onclick="showScreenDetails({{ $pantalla->id }})">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h6>Acciones Rápidas por Rol</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                   
                                    @foreach($roles as $role)
                                    <div class="col-md-4 mb-3">
                                        <div class="card border">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $role->nombre }}</h6>
                                                <div class="d-grid gap-2">
                                                    <button class="btn btn-sm btn-outline-success toggle-all-permissions" 
                                                            data-role-id="{{ $role->id }}" 
                                                            data-action="grant">
                                                        <i class="fas fa-check-circle me-1"></i> Dar todos los permisos
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger toggle-all-permissions" 
                                                            data-role-id="{{ $role->id }}" 
                                                            data-action="revoke">
                                                        <i class="fas fa-times-circle me-1"></i> Quitar todos los permisos
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-info" 
                                                            onclick="showRoleSummary({{ $role->id }})">
                                                        <i class="fas fa-chart-pie me-1"></i> Ver resumen
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6>Resumen de Cambios</h6>
                                <button class="btn btn-sm btn-danger" id="clearChanges">
                                    <i class="fas fa-trash me-1"></i> Limpiar
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="changesList">
                                    <p class="text-muted text-center">No hay cambios pendientes</p>
                                </div>
                                <div class="d-grid mt-3">
                                    <button class="btn btn-success" id="saveAllChanges" disabled>
                                        <i class="fas fa-save me-1"></i> Guardar todos los cambios
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal: Screen Details -->
            <div class="modal fade" id="screenDetailsModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detalles de Pantalla</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="screenDetailsContent">
                            <!-- Content loaded via AJAX -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal: Role Summary -->
            <div class="modal fade" id="roleSummaryModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Resumen de Permisos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="roleSummaryContent">
                            <!-- Content loaded via AJAX -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal: Help -->
            <div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Ayuda - Gestión de Permisos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Instrucciones:</h6>
                            <ul>
                                <li>Los <strong>módulos</strong> (filas grises) agrupan pantallas relacionadas</li>
                                <li>Haz clic en <i class="fas fa-chevron-down"></i> para expandir/contraer un módulo</li>
                                <li>Usa los interruptores para dar/quitar permisos a cada rol</li>
                                <li>El botón "Todo" en módulos asigna todos los permisos de ese módulo</li>
                                <li>Los cambios se guardan automáticamente al cambiar un interruptor</li>
                            </ul>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Tip:</strong> Usa "Dar todos los permisos" para asignar rápidamente acceso completo a un rol.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const changes = new Set();
            const saveAllBtn = document.getElementById('saveAllChanges');
            const changesList = document.getElementById('changesList');
            
            // Toggle children visibility
            document.querySelectorAll('.toggle-children').forEach(button => {
                button.addEventListener('click', function() {
                    const screenId = this.getAttribute('data-screen-id');
                    const children = document.querySelectorAll(`.child-screen[data-parent="${screenId}"]`);
                    const icon = this.querySelector('i');
                    
                    children.forEach(child => {
                        child.classList.toggle('d-none');
                    });
                    
                    icon.classList.toggle('fa-chevron-down');
                    icon.classList.toggle('fa-chevron-up');
                });
            });
            
            // Expand all modules
            document.getElementById('expandAll').addEventListener('click', function() {
                document.querySelectorAll('.child-screen').forEach(child => {
                    child.classList.remove('d-none');
                });
                document.querySelectorAll('.toggle-children i').forEach(icon => {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                });
            });
            
            // Search functionality
            document.getElementById('searchScreen').addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                document.querySelectorAll('.parent-screen, .child-screen').forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.classList.remove('d-none');
                        // Expand parent if child matches
                        if (row.classList.contains('child-screen')) {
                            const parentId = row.getAttribute('data-parent');
                            const parent = document.querySelector(`.parent-screen [data-screen-id="${parentId}"]`);
                            if (parent) {
                                const parentRow = parent.closest('tr');
                                parentRow.classList.remove('d-none');
                                const toggleBtn = parentRow.querySelector('.toggle-children');
                                if (toggleBtn) {
                                    const children = document.querySelectorAll(`.child-screen[data-parent="${parentId}"]`);
                                    children.forEach(child => child.classList.remove('d-none'));
                                    toggleBtn.querySelector('i').classList.remove('fa-chevron-down');
                                    toggleBtn.querySelector('i').classList.add('fa-chevron-up');
                                }
                            }
                        }
                    } else if (row.classList.contains('parent-screen')) {
                        // Hide parent if no children match
                        const screenId = row.querySelector('.toggle-children')?.getAttribute('data-screen-id');
                        const children = Array.from(document.querySelectorAll(`.child-screen[data-parent="${screenId}"]`));
                        const anyChildVisible = children.some(child => 
                            child.textContent.toLowerCase().includes(searchTerm) && !child.classList.contains('d-none')
                        );
                        if (!anyChildVisible && searchTerm !== '') {
                            row.classList.add('d-none');
                        }
                    }
                });
            });
            
            // Permission checkbox change
            document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const roleId = this.getAttribute('data-role-id');
                    const screenId = this.getAttribute('data-screen-id');
                    const isChecked = this.checked;
                    const action = isChecked ? 'grant' : 'revoke';
                    
                    // Save change
                    savePermissionChange(roleId, screenId, action);
                    
                    // Update UI
                    updateChangeList(roleId, screenId, action);
                    updateParentStatus(screenId);
                });
            });
            
            // Toggle all permissions for a role
            document.querySelectorAll('.toggle-all-permissions').forEach(button => {
                button.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-role-id');
                    const action = this.getAttribute('data-action');
                    const isGrant = action === 'grant';
                    
                    // Show confirmation for revoke
                    if (!isGrant && !confirm('¿Estás seguro de quitar TODOS los permisos a este rol?')) {
                        return;
                    }
                    
                    // Get all checkboxes for this role
                    document.querySelectorAll(`.permission-checkbox[data-role-id="${roleId}"]`).forEach(checkbox => {
                        checkbox.checked = isGrant;
                        const screenId = checkbox.getAttribute('data-screen-id');
                        savePermissionChange(roleId, screenId, action);
                    });
                    
                    // Update UI
                    updateChangeListBulk(roleId, action);
                    saveAllBtn.disabled = false;
                });
            });
            
            // Toggle module permissions
            document.querySelectorAll('.toggle-module-permissions').forEach(button => {
                button.addEventListener('click', function() {
                    const screenId = this.getAttribute('data-screen-id');
                    const children = document.querySelectorAll(`.child-screen[data-parent="${screenId}"]`);
                    const checkboxes = [];
                    
                    children.forEach(child => {
                        child.querySelectorAll('.permission-checkbox').forEach(cb => checkboxes.push(cb));
                    });
                    
                    const allChecked = checkboxes.every(cb => cb.checked);
                    const newState = !allChecked;
                    
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = newState;
                        const roleId = checkbox.getAttribute('data-role-id');
                        const childScreenId = checkbox.getAttribute('data-screen-id');
                        const action = newState ? 'grant' : 'revoke';
                        
                        savePermissionChange(roleId, childScreenId, action);
                    });
                    
                    updateChangeListBulk(null, newState ? 'grant' : 'revoke', screenId);
                });
            });
            
            // Clear changes
            document.getElementById('clearChanges').addEventListener('click', function() {
                if (changes.size === 0) return;
                
                if (confirm('¿Estás seguro de limpiar todos los cambios pendientes?')) {
                    changes.clear();
                    changesList.innerHTML = '<p class="text-muted text-center">No hay cambios pendientes</p>';
                    saveAllBtn.disabled = true;
                }
            });
            
            // Save all changes
            saveAllBtn.addEventListener('click', function() {
                if (changes.size === 0) return;
                
                const changesArray = Array.from(changes);
                saveChangesToServer(changesArray);
            });
            
            // Toggle all permissions view
            document.getElementById('toggleAllPermissions').addEventListener('change', function() {
                const showAll = this.checked;
                document.querySelectorAll('.child-screen').forEach(child => {
                    if (showAll) {
                        child.classList.remove('d-none');
                    }
                });
            });
            
            // Functions
            function savePermissionChange(roleId, screenId, action) {
                const changeKey = `${roleId}_${screenId}`;
                if (action === 'grant') {
                    changes.add(JSON.stringify({
                        role_id: roleId,
                        screen_id: screenId,
                        action: 'attach'
                    }));
                } else {
                    changes.add(JSON.stringify({
                        role_id: roleId,
                        screen_id: screenId,
                        action: 'detach'
                    }));
                }
                saveAllBtn.disabled = false;
            }
            
            function updateChangeList(roleId, screenId, action) {
                if (changesList.querySelector('.text-muted')) {
                    changesList.innerHTML = '';
                }
                
                const screenRow = document.querySelector(`.permission-checkbox[data-screen-id="${screenId}"]`)?.closest('tr');
                const screenName = screenRow?.querySelector('h6')?.textContent || 'Pantalla';
                const roleName = document.querySelector(`th[data-role-id="${roleId}"] span`)?.textContent || 'Rol';
                
                const changeItem = document.createElement('div');
                changeItem.className = 'alert alert-sm alert-dismissible fade show mb-2';
                changeItem.innerHTML = `
                    <span class="fw-bold">${action === 'grant' ? '✓ Otorgado' : '✗ Revocado'}</span>: 
                    ${roleName} → ${screenName}
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                `;
                
                changesList.prepend(changeItem);
            }
            
            function updateChangeListBulk(roleId, action, moduleId = null) {
                if (changesList.querySelector('.text-muted')) {
                    changesList.innerHTML = '';
                }
                
                const actionText = action === 'grant' ? 'Otorgados todos' : 'Revocados todos';
                const target = roleId ? 
                    document.querySelector(`th[data-role-id="${roleId}"] span`)?.textContent || 'Rol' :
                    moduleId ? 
                    document.querySelector(`[data-screen-id="${moduleId}"]`)?.closest('td')?.querySelector('h6')?.textContent || 'Módulo' :
                    'Sistema';
                
                const changeItem = document.createElement('div');
                changeItem.className = 'alert alert-sm alert-warning alert-dismissible fade show mb-2';
                changeItem.innerHTML = `
                    <span class="fw-bold">${actionText} permisos</span> para: ${target}
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
                `;
                
                changesList.prepend(changeItem);
            }
            
            function updateParentStatus(screenId) {
                // Find parent and update its status badge
                const childRow = document.querySelector(`.child-screen [data-screen-id="${screenId}"]`)?.closest('tr');
                if (!childRow) return;
                
                const parentId = childRow.getAttribute('data-parent');
                const parentRow = document.querySelector(`.parent-screen [data-screen-id="${parentId}"]`)?.closest('tr');
                if (!parentRow) return;
                
                // Logic to update parent status would go here
                // This would typically involve checking all children's permissions
            }
            
            async function saveChangesToServer(changesArray) {
                try {
                    const response = await fetch('{{ route('permisos.pantallas.guardar') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ changes: changesArray.map(c => JSON.parse(c)) })
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        showToast('Cambios guardados exitosamente', 'success');
                        changes.clear();
                        changesList.innerHTML = '<p class="text-muted text-center">No hay cambios pendientes</p>';
                        saveAllBtn.disabled = true;
                    } else {
                        showToast('Error al guardar cambios', 'error');
                    }
                } catch (error) {
                    showToast('Error de conexión', 'error');
                }
            }
            
            function showScreenDetails(screenId) {
                fetch(`{{ url('/permisos-pantallas/pantalla') }}/${screenId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('screenDetailsContent').innerHTML = data.html;
                        new bootstrap.Modal(document.getElementById('screenDetailsModal')).show();
                    });
            }
            
            function showRoleSummary(roleId) {
                fetch(`{{ url('/permisos-pantallas/rol') }}/${roleId}/resumen`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('roleSummaryContent').innerHTML = data.html;
                        new bootstrap.Modal(document.getElementById('roleSummaryModal')).show();
                    });
            }
            
            function showToast(message, type = 'info') {
                // Implement toast notification
                alert(message); // Replace with actual toast implementation
            }
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <style>
        .parent-screen {
            background-color: #f8f9fa !important;
            border-left: 4px solid #3498db;
        }
        
        .child-screen {
            border-left: 4px solid #2ecc71;
        }
        
        .child-screen:hover {
            background-color: #f1f8ff;
        }
        
        .form-check-input:checked {
            background-color: #2ecc71;
            border-color: #2ecc71;
        }
        
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25);
        }
        
        .badge {
            font-size: 0.65em;
            padding: 0.35em 0.65em;
        }
        
        .permission-checkbox {
            width: 3em;
            height: 1.5em;
        }
        
        .table th {
            background-color: #f8f9fa;
            position: sticky;
            top: 0;
            z-index: 10;
        }
    </style>
</x-layout>
