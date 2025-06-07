@extends('layouts.admin')

@section('title', 'Dashboard de Administración')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-3 col-md-4">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-lg-9 col-md-8">
            <!-- Header con bienvenida y tiempo real -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-tachometer-alt me-2 text-primary"></i>Dashboard de Administración
                    </h1>
                    <p class="text-muted mb-0">
                        <i class="fas fa-calendar-day me-1"></i>{{ now()->format('l, j F Y') }} • 
                        <span id="reloj">{{ now()->format('H:i:s') }}</span>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-1"></i>Actualizar
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-download me-1"></i>Exportar
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Estadísticas principales con animaciones -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Usuarios Registrados</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $estadisticas['total_usuarios'] }}">0</div>
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-arrow-up"></i> +12% este mes
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-success shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Servicios Activos</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $estadisticas['total_servicios'] }}">0</div>
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-arrow-up"></i> +8% este mes
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-briefcase text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-info shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Solicitudes Procesadas</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $estadisticas['total_solicitudes'] }}">0</div>
                                    <div class="small text-info mt-1">
                                        <i class="fas fa-arrow-right"></i> 95% completadas
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-handshake text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Categorías Disponibles</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $estadisticas['total_categorias'] }}">0</div>
                                    <div class="small text-warning mt-1">
                                        <i class="fas fa-check-circle"></i> Todas activas
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-tags text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de datos tabulares mejorada -->
            <div class="row">
                <!-- Top profesiones -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-briefcase me-2"></i>Top Profesiones
                            </h6>
                            <a href="{{ route('admin.estadisticas.profesiones') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-chart-line me-1"></i>Ver Todas
                            </a>
                        </div>
                        <div class="card-body">
                            @if($topProfesiones && $topProfesiones->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Rango</th>
                                                <th>Profesión</th>
                                                <th>Usuarios</th>
                                                <th>Progreso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topProfesiones->take(5) as $index => $profesion)
                                                @php
                                                    $porcentaje = $estadisticas['total_usuarios'] > 0 ? ($profesion->total / $estadisticas['total_usuarios']) * 100 : 0;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="ranking-badge ranking-{{ $index + 1 }}">
                                                            {{ $index + 1 }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="font-weight-bold">{{ Str::limit($profesion->profesion ?: 'Sin especificar', 25) }}</div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success">{{ $profesion->total }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="progress" style="height: 8px;">
                                                            <div class="progress-bar bg-primary" role="progressbar" 
                                                                 style="width: {{ $porcentaje }}%" 
                                                                 data-bs-toggle="tooltip" 
                                                                 title="{{ number_format($porcentaje, 1) }}%">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay datos de profesiones disponibles</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Últimos usuarios registrados -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user-plus me-2"></i>Últimos Usuarios Registrados
                            </h6>
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-users me-1"></i>Ver Todos
                            </a>
                        </div>
                        <div class="card-body">
                            @if($ultimosUsuarios && $ultimosUsuarios->count() > 0)
                                <div class="users-list">
                                    @foreach($ultimosUsuarios->take(5) as $usuario)
                                        <div class="user-item">
                                            <div class="user-avatar">
                                                <div class="avatar-circle bg-{{ $usuario->es_admin ? 'warning' : 'primary' }}">
                                                    {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="user-info">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="user-details">
                                                        <h6 class="user-name mb-1">{{ $usuario->nombre ?? 'Usuario' }} {{ $usuario->apellidos ?? '' }}</h6>
                                                        <p class="user-email text-muted mb-1">{{ $usuario->email ?? 'Sin email' }}</p>
                                                        <div class="user-meta d-flex align-items-center">
                                                            @if($usuario->es_admin)
                                                                <span class="badge bg-warning me-2">
                                                                    <i class="fas fa-shield-alt"></i> Admin
                                                                </span>
                                                            @else
                                                                <span class="badge bg-info me-2">
                                                                    <i class="fas fa-user"></i> Usuario
                                                                </span>
                                                            @endif
                                                            <small class="text-muted">{{ $usuario->profesion ?: 'Sin profesión' }}</small>
                                                        </div>
                                                    </div>
                                                    <div class="user-date text-end">
                                                        @if($usuario->created_at)
                                                            <small class="text-muted d-block fw-bold">{{ $usuario->created_at->format('d/m/Y') }}</small>
                                                            <small class="text-muted">{{ $usuario->created_at->format('H:i') }}</small>
                                                        @else
                                                            <small class="text-muted">Sin fecha</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state text-center py-4">
                                    <div class="empty-icon mb-3">
                                        <i class="fas fa-user-plus fa-3x text-muted"></i>
                                    </div>
                                    <h5 class="empty-title text-muted">No hay usuarios recientes</h5>
                                    <p class="empty-text text-muted mb-0">Los usuarios registrados aparecerán aquí</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Estilos mejorados para el dashboard */
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }

    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .counter {
        color: #5a5c69;
    }

    .ranking-badge {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        font-size: 12px;
    }
    .ranking-1 { background: linear-gradient(45deg, #ffd700, #ffed4e); }
    .ranking-2 { background: linear-gradient(45deg, #c0c0c0, #e5e7eb); }
    .ranking-3 { background: linear-gradient(45deg, #cd7f32, #d69e2e); }
    .ranking-4, .ranking-5 { background: linear-gradient(45deg, #4e73df, #36b9cc); }

    /* Estilos para la lista de usuarios - CORREGIDOS */
    .users-list {
        max-height: 400px;
        overflow-y: auto;
        padding-right: 5px;
    }
    
    .user-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.2rem;
        padding: 1rem;
        background: #f8f9fc;
        border-radius: 0.75rem;
        border: 1px solid #e3e6f0;
        transition: all 0.3s ease;
    }
    
    .user-item:hover {
        background: #ffffff;
        border-color: #4e73df;
        box-shadow: 0 0.25rem 0.75rem rgba(78, 115, 223, 0.15);
        transform: translateY(-2px);
    }
    
    .user-item:last-child {
        margin-bottom: 0;
    }
    
    .user-avatar {
        margin-right: 1rem;
        flex-shrink: 0;
    }
    
    .avatar-circle {
        width: 45px !important;
        height: 45px !important;
        border-radius: 50% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-weight: bold !important;
        color: white !important;
        font-size: 16px !important;
        text-transform: uppercase !important;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.1) !important;
        border: 3px solid #ffffff !important;
        line-height: 1 !important;
    }
    
    .bg-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%) !important;
    }
    
    .bg-warning {
        background: linear-gradient(135deg, #f6c23e 0%, #dda20a 100%) !important;
    }
    
    .user-info {
        flex: 1;
        min-width: 0;
    }
    
    .user-name {
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        color: #5a5c69 !important;
        margin-bottom: 0.25rem !important;
        line-height: 1.3 !important;
    }
    
    .user-email {
        font-size: 0.85rem !important;
        margin-bottom: 0.5rem !important;
        line-height: 1.2 !important;
    }
    
    .user-meta {
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .user-date {
        flex-shrink: 0;
        text-align: right;
        min-width: 80px;
    }
    
    .empty-state {
        padding: 2rem 1rem;
    }
    
    .empty-icon {
        opacity: 0.5;
    }
    
    .empty-title {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }
    
    .empty-text {
        font-size: 0.9rem;
    }

    .progress {
        background-color: #e9ecef;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
    }

    /* Animación del reloj */
    #reloj {
        font-family: 'Courier New', monospace;
        font-weight: bold;
        color: #4e73df;
    }

    /* Mejoras en badges */
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.25rem 0.5rem;
    }

    /* Scrollbar personalizado para la lista de usuarios */
    .users-list::-webkit-scrollbar {
        width: 4px;
    }
    
    .users-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    .users-list::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    .users-list::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reloj en tiempo real
    function actualizarReloj() {
        const ahora = new Date();
        const reloj = document.getElementById('reloj');
        if (reloj) {
            reloj.textContent = ahora.toLocaleTimeString();
        }
    }
    setInterval(actualizarReloj, 1000);

    // Animación de contadores
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString();
        }, 16);
    }

    // Inicializar contadores
    document.querySelectorAll('.counter').forEach(counter => {
        animateCounter(counter);
    });

    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection 