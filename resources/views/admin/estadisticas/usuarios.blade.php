@extends('layouts.admin')

@section('title', 'Estadísticas de Usuarios')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-3 col-md-4">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-lg-9 col-md-8">
            <!-- Header -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-users me-2 text-primary"></i>Estadísticas de Usuarios
                    </h1>
                    <p class="text-muted mb-0">Análisis detallado de la base de usuarios registrados</p>
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

            <!-- Métricas principales -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Usuarios</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $totalUsuarios }}">0</div>
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-arrow-up"></i> Registrados
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
                                        Usuarios Activos</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $usuariosActivos }}">0</div>
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-check-circle"></i> {{ number_format(($usuariosActivos / max($totalUsuarios, 1)) * 100, 1) }}%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-user-check text-white"></i>
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
                                        Usuarios Inactivos</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $usuariosInactivos }}">0</div>
                                    <div class="small text-warning mt-1">
                                        <i class="fas fa-exclamation-triangle"></i> {{ number_format(($usuariosInactivos / max($totalUsuarios, 1)) * 100, 1) }}%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-user-times text-white"></i>
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
                                        Promedio Mensual</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ round($totalUsuarios / 12) }}">0</div>
                                    <div class="small text-info mt-1">
                                        <i class="fas fa-calendar-alt"></i> Registros/mes
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-chart-line text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos de análisis -->
            <div class="row mb-4">
                <!-- Registros por mes -->
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-area me-2"></i>Registros por Mes (Últimos 12 meses)
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow">
                                    <a class="dropdown-item" href="#" onclick="descargarGrafico('registrosChart')">
                                        <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Descargar gráfico
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="registrosChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Distribución por género -->
                <div class="col-xl-4 col-lg-5 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie me-2"></i>Distribución por Género
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow">
                                    <a class="dropdown-item" href="{{ route('admin.estadisticas.genero') }}">
                                        <i class="fas fa-chart-bar fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Ver detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="generoChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                @foreach($usuariosPorGenero as $index => $genero)
                                    <span class="mr-3">
                                        <i class="fas fa-circle" style="color: {{ ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'][$index] ?? '#e74a3b' }}"></i> 
                                        {{ $genero->genero }} ({{ $genero->total }})
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tablas de datos -->
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
                                                <th>%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topProfesiones->take(8) as $index => $profesion)
                                                @php
                                                    $porcentaje = $totalUsuarios > 0 ? ($profesion->total / $totalUsuarios) * 100 : 0;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="ranking-badge ranking-{{ min($index + 1, 3) }}">
                                                            {{ $index + 1 }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="font-weight-bold">{{ Str::limit($profesion->profesion ?: 'Sin especificar', 30) }}</div>
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
                                                        <small class="text-muted">{{ number_format($porcentaje, 1) }}%</small>
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

                <!-- Usuarios recientes -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user-plus me-2"></i>Usuarios Recientes
                            </h6>
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-users me-1"></i>Ver Todos
                            </a>
                        </div>
                        <div class="card-body">
                            @if($usuariosRecientes && $usuariosRecientes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Profesión</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($usuariosRecientes->take(8) as $usuario)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm me-3">
                                                                <div class="avatar-title bg-primary rounded-circle">
                                                                    {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold">{{ $usuario->nombre ?? 'Usuario' }} {{ $usuario->apellidos ?? '' }}</div>
                                                                <small class="text-muted">{{ $usuario->email ?? 'Sin email' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">{{ Str::limit($usuario->profesion ?: 'Sin especificar', 20) }}</span>
                                                    </td>
                                                    <td>
                                                        @if($usuario->created_at)
                                                            <div>{{ $usuario->created_at->format('d/m/Y') }}</div>
                                                            <small class="text-muted">{{ $usuario->created_at->format('H:i') }}</small>
                                                        @else
                                                            <small class="text-muted">Sin fecha</small>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($usuario->activo ?? true)
                                                            <span class="badge bg-success">
                                                                <i class="fas fa-check-circle"></i> Activo
                                                            </span>
                                                        @else
                                                            <span class="badge bg-warning">
                                                                <i class="fas fa-pause-circle"></i> Inactivo
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-user-plus fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay usuarios recientes disponibles</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Análisis adicional -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar me-2"></i>Análisis de Tendencias
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <div class="border-left-primary p-3 bg-light rounded">
                                        <h6 class="text-primary mb-2">
                                            <i class="fas fa-trending-up me-2"></i>Crecimiento
                                        </h6>
                                        <p class="mb-1">Registros últimos 30 días: <strong>{{ $registrosPorMes->take(1)->sum('total') }}</strong></p>
                                        <p class="mb-0 text-muted">Promedio diario: {{ number_format($registrosPorMes->take(1)->sum('total') / 30, 1) }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="border-left-success p-3 bg-light rounded">
                                        <h6 class="text-success mb-2">
                                            <i class="fas fa-users me-2"></i>Actividad
                                        </h6>
                                        <p class="mb-1">Tasa de actividad: <strong>{{ number_format(($usuariosActivos / max($totalUsuarios, 1)) * 100, 1) }}%</strong></p>
                                        <p class="mb-0 text-muted">{{ $usuariosActivos }} de {{ $totalUsuarios }} usuarios</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-3">
                                    <div class="border-left-info p-3 bg-light rounded">
                                        <h6 class="text-info mb-2">
                                            <i class="fas fa-chart-pie me-2"></i>Diversidad
                                        </h6>
                                        <p class="mb-1">Géneros registrados: <strong>{{ $usuariosPorGenero->count() }}</strong></p>
                                        <p class="mb-0 text-muted">Profesiones únicas: {{ $topProfesiones->count() }}</p>
                                    </div>
                                </div>
                            </div>
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
    /* Estilos mejorados */
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

    .chart-area, .chart-pie {
        position: relative;
        height: 300px;
        width: 100%;
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

    .avatar-sm {
        width: 35px;
        height: 35px;
    }
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        width: 100%;
        height: 100%;
        font-size: 14px;
    }

    .progress {
        background-color: #e9ecef;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración global de Chart.js
    Chart.defaults.font.family = 'Nunito Sans, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto';
    Chart.defaults.color = '#858796';

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

    // Gráfico de registros por mes
    const ctxRegistros = document.getElementById('registrosChart').getContext('2d');
    const mesesLabels = [
        @foreach($registrosPorMes as $registro)
            '{{ $registro->mes }}',
        @endforeach
    ];
    const registrosData = [
        @foreach($registrosPorMes as $registro)
            {{ $registro->total }},
        @endforeach
    ];

    new Chart(ctxRegistros, {
        type: 'line',
        data: {
            labels: mesesLabels,
            datasets: [{
                label: 'Registros',
                data: registrosData,
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: 'rgba(255, 255, 255, 1)',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255,255,255,.9)',
                    titleColor: '#6e707e',
                    bodyColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    cornerRadius: 10
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(234, 236, 244, 1)',
                        drawBorder: false
                    },
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return Number.isInteger(value) ? value : '';
                        }
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });

    // Gráfico de distribución por género
    const ctxGenero = document.getElementById('generoChart').getContext('2d');
    const generoLabels = [
        @foreach($usuariosPorGenero as $genero)
            '{{ $genero->genero }}',
        @endforeach
    ];
    const generoData = [
        @foreach($usuariosPorGenero as $genero)
            {{ $genero->total }},
        @endforeach
    ];

    new Chart(ctxGenero, {
        type: 'doughnut',
        data: {
            labels: generoLabels,
            datasets: [{
                data: generoData,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#e02d1b'],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(255,255,255,.9)',
                    titleColor: '#6e707e',
                    bodyColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    cornerRadius: 10,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '65%',
            animation: {
                animateRotate: true,
                duration: 2000
            }
        }
    });

    // Función para descargar gráfico
    window.descargarGrafico = function(chartId) {
        const canvas = document.getElementById(chartId);
        const url = canvas.toDataURL('image/png');
        const a = document.createElement('a');
        a.href = url;
        a.download = chartId + '_estadisticas.png';
        a.click();
    };

    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection 