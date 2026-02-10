<div>
    <h6 class="mb-3">Rol: {{ $roleRow->nombre }}</h6>
    @if($pantallas->isEmpty())
        <p class="text-muted mb-0">Sin pantallas asignadas.</p>
    @else
        <ul class="list-group list-group-flush">
            @foreach($pantallas as $p)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $p->nombre }}</span>
                    <small class="text-muted">{{ $p->route_name }}</small>
                </li>
            @endforeach
        </ul>
    @endif
</div>
