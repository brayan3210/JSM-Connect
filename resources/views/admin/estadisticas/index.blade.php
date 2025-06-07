@extends('layouts.admin')

@section('title', 'Estadísticas Generales')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-chart-bar"></i> Estadísticas Generales
                </h1>
                <div class="btn-group">
                    <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fas fa-download"></i> Exportar
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel"></i> Excel</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf"></i> PDF</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-file-image"></i> Imagen</a></li>
                    </ul>
                </div>
            </div>

            <!-- Estadísticas Principales -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Usuarios</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['total_usuarios']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Servicios</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['total_servicios']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Solicitudes</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['total_solicitudes']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-handshake fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Categorías</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['total_categorias']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tags fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos Principales -->
            <div class="row mb-4">
                <!-- Usuarios por Género -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie"></i> Usuarios por Género
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="usuariosPorGeneroChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                @foreach($usuariosPorGenero as $genero)
                                    <span class="mr-2">
                                        <i class="fas fa-circle" style="color: {{ $loop->index == 0 ? '#4e73df' : ($loop->index == 1 ? '#1cc88a' : '#36b9cc') }}"></i> 
                                        {{ $genero->genero }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Profesiones -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar"></i> Top 10 Profesiones
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="topProfesionesChart" width="100%" height="50"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estados de Solicitudes y Top Categorías -->
            <div class="row mb-4">
                <!-- Estados de Solicitudes -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-doughnut"></i> Estados de Solicitudes
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-doughnut">
                                <canvas id="estadosSolicitudesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Categorías -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar"></i> Top Categorías Utilizadas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="topCategoriasChart" width="100%" height="50"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tablas de Datos -->
            <div class="row">
                <!-- Usuarios Recientes -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user-plus"></i> Usuarios Recientes
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($usuariosRecientes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Usuario</th>
                                                <th>Email</th>
                                                <th>Profesión</th>
                                                <th>Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($usuariosRecientes as $usuario)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm me-2">
                                                                <div class="avatar-title bg-primary rounded-circle">
                                                                    {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="font-weight-bold">{{ $usuario->nombre }} {{ $usuario->apellidos }}</div>
                                                                <small class="text-muted">{{ $usuario->genero }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $usuario->email }}</td>
                                                    <td>
                                                        @if($usuario->profesion)
                                                            <span class="badge bg-info">{{ Str::limit($usuario->profesion, 20) }}</span>
                                                        @else
                                                            <span class="text-muted">No especificada</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div>{{ $usuario->created_at->format('d/m/Y') }}</div>
                                                        <small class="text-muted">{{ $usuario->created_at->format('H:i') }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay usuarios recientes disponibles</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Resumen por Profesiones -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-briefcase"></i> Resumen por Profesiones
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($usuariosPorProfesion->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Profesión</th>
                                                <th>Usuarios</th>
                                                <th>Porcentaje</th>
                                                <th>Progreso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($usuariosPorProfesion as $profesion)
                                                @php
                                                    $porcentaje = $estadisticas['total_usuarios'] > 0 ? ($profesion->total / $estadisticas['total_usuarios']) * 100 : 0;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="font-weight-bold">{{ Str::limit($profesion->profesion, 25) }}</div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">{{ $profesion->total }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format($porcentaje, 1) }}%
                                                    </td>
                                                    <td>
                                                        <div class="progress" style="height: 20px;">
                                                            <div class="progress-bar bg-primary" role="progressbar" 
                                                                 style="width: {{ $porcentaje }}%" 
                                                                 aria-valuenow="{{ $porcentaje }}" 
                                                                 aria-valuemin="0" 
                                                                 aria-valuemax="100">
                                                                {{ number_format($porcentaje, 1) }}%
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .chart-area, .chart-pie, .chart-bar, .chart-doughnut {
        position: relative;
        height: 300px;
        width: 100%;
    }
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
    }
    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
    }
    .progress {
        background-color: #e9ecef;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
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

    // Gráfico de Usuarios por Género
    const ctxGenero = document.getElementById('usuariosPorGeneroChart').getContext('2d');
    new Chart(ctxGenero, {
        type: 'doughnut',
        data: {
            labels: [@foreach($usuariosPorGenero as $genero)'{{ $genero->genero }}',@endforeach],
            datasets: [{
                data: [@foreach($usuariosPorGenero as $genero){{ $genero->total }},@endforeach],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#e02d1b'],
                borderWidth: 2,
                borderColor: '#ffffff'
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
                    backgroundColor: 'rgba(255,255,255,.8)',
                    titleColor: '#6e707e',
                    bodyColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // Gráfico de Top Profesiones
    const ctxProfesiones = document.getElementById('topProfesionesChart').getContext('2d');
    new Chart(ctxProfesiones, {
        type: 'bar',
        data: {
            labels: [@foreach($topProfesiones->take(10) as $prof)'{{ Str::limit($prof->profesion, 15) }}',@endforeach],
            datasets: [{
                label: 'Usuarios',
                data: [@foreach($topProfesiones->take(10) as $prof){{ $prof->total }},@endforeach],
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false
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
                    backgroundColor: 'rgba(255,255,255,.8)',
                    titleColor: '#6e707e',
                    bodyColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 0
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
            }
        }
    });

    // Gráfico de Estados de Solicitudes
    const ctxEstados = document.getElementById('estadosSolicitudesChart').getContext('2d');
    new Chart(ctxEstados, {
        type: 'doughnut',
        data: {
            labels: [@foreach($estadosSolicitudes as $estado)'{{ ucfirst($estado->estado) }}',@endforeach],
            datasets: [{
                data: [@foreach($estadosSolicitudes as $estado){{ $estado->total }},@endforeach],
                backgroundColor: ['#f6c23e', '#1cc88a', '#e74a3b', '#36b9cc'],
                hoverBackgroundColor: ['#dda20a', '#17a673', '#e02d1b', '#2c9faf'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255,255,255,.8)',
                    titleColor: '#6e707e',
                    bodyColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '50%'
        }
    });

    // Gráfico de Top Categorías
    const ctxCategorias = document.getElementById('topCategoriasChart').getContext('2d');
    new Chart(ctxCategorias, {
        type: 'bar',
        data: {
            labels: [@foreach($topCategorias->take(8) as $cat)'{{ Str::limit($cat->nombre, 15) }}',@endforeach],
            datasets: [{
                label: 'Servicios',
                data: [@foreach($topCategorias->take(8) as $cat){{ $cat->total }},@endforeach],
                backgroundColor: 'rgba(28, 200, 138, 0.8)',
                borderColor: 'rgba(28, 200, 138, 1)',
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false
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
                    backgroundColor: 'rgba(255,255,255,.8)',
                    titleColor: '#6e707e',
                    bodyColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 0
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
            }
        }
    });
});
</script>
@endsection 