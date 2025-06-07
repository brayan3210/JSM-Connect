<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex align-items-center mb-4">
            <div class="flex-shrink-0">
                <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 20px; background-color: #104CFF;">
                    <i class="fas fa-user-shield"></i>
                </div>
            </div>
            <div class="ms-3">
                <h5 class="mb-0">{{ auth()->user()->nombre }}</h5>
                <p class="text-muted small mb-0">Administrador</p>
            </div>
        </div>
        
        <hr>
        
        <div class="list-group list-group-flush">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
            
            <div class="my-2 sidebar-heading text-uppercase text-muted small px-3">Gestión</div>
            
            <a href="{{ route('admin.usuarios.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                <i class="fas fa-users me-2"></i> Usuarios
            </a>
            <a href="{{ route('admin.categorias.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                <i class="fas fa-folder me-2"></i> Categorías
            </a>
            <a href="{{ route('admin.administradores.create') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.administradores.create') ? 'active' : '' }}">
                <i class="fas fa-user-plus me-2"></i> Crear Usuario Administrador
            </a>
            <a href="{{ route('admin.administradores.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.administradores.*') && !request()->routeIs('admin.administradores.create') ? 'active' : '' }}">
                <i class="fas fa-user-shield me-2"></i> Gestión de Usuarios Administradores
            </a>
            
            <div class="my-2 sidebar-heading text-uppercase text-muted small px-3">Estadísticas</div>
            
            <a href="{{ route('admin.estadisticas.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.estadisticas.index') ? 'active' : '' }}">
                <i class="fas fa-chart-line me-2"></i> Resumen General
            </a>
            <a href="{{ route('admin.estadisticas.usuarios') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.estadisticas.usuarios') ? 'active' : '' }}">
                <i class="fas fa-user-chart me-2"></i> Estadísticas de Usuarios
            </a>
            <a href="{{ route('admin.estadisticas.genero') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.estadisticas.genero') ? 'active' : '' }}">
                <i class="fas fa-venus-mars me-2"></i> Distribución por Género
            </a>
            <a href="{{ route('admin.estadisticas.profesiones') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.estadisticas.profesiones') ? 'active' : '' }}">
                <i class="fas fa-user-graduate me-2"></i> Estadísticas por Profesión
            </a>
            <a href="{{ route('admin.estadisticas.categorias') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.estadisticas.categorias') ? 'active' : '' }}">
                <i class="fas fa-tags me-2"></i> Estadísticas por Categoría
            </a>
            <a href="{{ route('admin.estadisticas.servicios') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.estadisticas.servicios') ? 'active' : '' }}">
                <i class="fas fa-briefcase me-2"></i> Estadísticas de Servicios
            </a>
            
            <div class="my-2 sidebar-heading text-uppercase text-muted small px-3">Sistema</div>
            
            <a href="{{ route('admin.logs.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.logs.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt me-2"></i> Logs del Sistema
            </a>
        </div>
        
        <hr>
        
        <div class="d-grid">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm w-100" style="background-color: #104CFF; color: white; border: none;">
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
        color: #104CFF;
        border-color: #dee2e6;
    }
</style>
@endsection 