<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center mb-4">
            <div class="flex-shrink-0">
                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 20px;">
                    {{ substr(auth()->user()->nombre, 0, 1) }}{{ substr(auth()->user()->apellidos, 0, 1) }}
                </div>
            </div>
            <div class="ms-3">
                <h5 class="mb-0">{{ auth()->user()->nombre }} {{ auth()->user()->apellidos }}</h5>
                <p class="text-muted small mb-0">{{ auth()->user()->profesion }}</p>
            </div>
        </div>
        
        <hr>
        
        <div class="list-group list-group-flush">
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            
            <div class="my-2 sidebar-heading text-uppercase text-muted small px-3">Mi Perfil</div>
            
            <a href="{{ route('perfil.show') }}" class="list-group-item list-group-item-action {{ request()->routeIs('perfil.show') ? 'active' : '' }}">
                <i class="fas fa-user me-2"></i> Ver Perfil
            </a>
            <a href="{{ route('perfil.edit') }}" class="list-group-item list-group-item-action {{ request()->routeIs('perfil.edit') ? 'active' : '' }}">
                <i class="fas fa-edit me-2"></i> Editar Información
            </a>
            <a href="{{ route('perfil.preferencias') }}" class="list-group-item list-group-item-action {{ request()->routeIs('perfil.preferencias') ? 'active' : '' }}">
                <i class="fas fa-heart me-2"></i> Mis Preferencias
            </a>
            <a href="{{ route('perfil.especialidades') }}" class="list-group-item list-group-item-action {{ request()->routeIs('perfil.especialidades') ? 'active' : '' }}">
                <i class="fas fa-star me-2"></i> Mis Especialidades
            </a>
            
            <div class="my-2 sidebar-heading text-uppercase text-muted small px-3">Servicios</div>
            
            <a href="{{ route('servicios.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('servicios.index') ? 'active' : '' }}">
                <i class="fas fa-briefcase me-2"></i> Mis Servicios
            </a>
            <a href="{{ route('servicios.create') }}" class="list-group-item list-group-item-action {{ request()->routeIs('servicios.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle me-2"></i> Crear Servicio
            </a>
            <a href="{{ route('buscar') }}" class="list-group-item list-group-item-action {{ request()->routeIs('buscar') ? 'active' : '' }}">
                <i class="fas fa-search me-2"></i> Buscar Servicios
            </a>
            
            <div class="my-2 sidebar-heading text-uppercase text-muted small px-3">Solicitudes</div>
            
            <a href="{{ route('solicitudes.recibidas') }}" class="list-group-item list-group-item-action {{ request()->routeIs('solicitudes.recibidas') ? 'active' : '' }}">
                <i class="fas fa-inbox me-2"></i> Solicitudes Recibidas
            </a>
            <a href="{{ route('solicitudes.enviadas') }}" class="list-group-item list-group-item-action {{ request()->routeIs('solicitudes.enviadas') ? 'active' : '' }}">
                <i class="fas fa-paper-plane me-2"></i> Solicitudes Enviadas
            </a>
            
            <div class="my-2 sidebar-heading text-uppercase text-muted small px-3">Mensajes</div>
            
            <a href="{{ route('mensajes.recibidos') }}" class="list-group-item list-group-item-action {{ request()->routeIs('mensajes.recibidos') ? 'active' : '' }}">
                <i class="fas fa-envelope me-2"></i> Bandeja de Entrada
                @if(isset($mensajesNoLeidos) && $mensajesNoLeidos > 0)
                    <span class="badge bg-danger float-end">{{ $mensajesNoLeidos }}</span>
                @endif
            </a>
            <a href="{{ route('mensajes.enviados') }}" class="list-group-item list-group-item-action {{ request()->routeIs('mensajes.enviados') ? 'active' : '' }}">
                <i class="fas fa-paper-plane me-2"></i> Mensajes Enviados
            </a>
        </div>
        
        <hr>
        
        <div class="d-flex justify-content-between">
            <a href="{{ route('perfil.descargar') }}" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-download me-1"></i> Exportar Datos
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</div>

@section('styles')
<style>
    .sidebar-heading {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.05em;
    }
    
    .list-group-item-action {
        color: #4b5563;
        padding: 0.5rem 1rem;
    }
    
    .list-group-item-action:hover {
        background-color: #f3f4f6;
    }
    
    .list-group-item-action.active {
        background-color: #e9ecef;
        color: #1e40af;
        border-color: #dee2e6;
    }
</style>
@endsection 