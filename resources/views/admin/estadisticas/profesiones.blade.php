@extends('layouts.admin')

@section('title', 'Estadísticas por Profesiones')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-user-tie text-primary"></i> Estadísticas por Profesiones
                    </h1>
                    <p class="text-muted">Análisis detallado de usuarios por profesión</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.estadisticas.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-download"></i> Exportar
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                        </ul>
                    </div>
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
                                        Total Profesiones</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProfesiones }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-briefcase fa-2x text-gray-300"></i>
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
                                        Usuarios con Profesión</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsuarios }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                        Promedio por Profesión</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $totalProfesiones > 0 ? round($totalUsuarios / $totalProfesiones, 1) : 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
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
                                        Profesión Más Popular</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $profesiones->count() > 0 ? $profesiones->first()->total : 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row mb-4">
                <!-- Gráfico de Barras Horizontal -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar me-2"></i>Top 15 Profesiones
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="profesionesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Distribución de Categorías -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie me-2"></i>Distribución Top 8
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="distribucionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla Detallada -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table me-2"></i>Listado Completo de Profesiones
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Ranking</th>
                                    <th>Profesión</th>
                                    <th>Usuarios</th>
                                    <th>Participación</th>
                                    <th>Categoría</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profesiones as $index => $profesion)
                                    @php
                                        $porcentaje = $totalUsuarios > 0 ? ($profesion->total / $totalUsuarios) * 100 : 0;
                                        $categoria = '';
                                        if($profesion->total >= 50) $categoria = 'Alta';
                                        elseif($profesion->total >= 20) $categoria = 'Media';
                                        elseif($profesion->total >= 5) $categoria = 'Baja';
                                        else $categoria = 'Muy Baja';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="ranking-badge ranking-{{ min($index + 1, 5) }}">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $profesion->profesion ?: 'Sin especificar' }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $profesion->total }}</span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-primary" role="progressbar" 
                                                     style="width: {{ $porcentaje }}%">
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ number_format($porcentaje, 1) }}%</small>
                                        </td>
                                        <td class="text-center">
                                            @if($categoria == 'Alta')
                                                <span class="badge bg-success">{{ $categoria }}</span>
                                            @elseif($categoria == 'Media')
                                                <span class="badge bg-warning">{{ $categoria }}</span>
                                            @elseif($categoria == 'Baja')
                                                <span class="badge bg-info">{{ $categoria }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $categoria }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }

    .chart-bar, .chart-pie {
        position: relative;
        height: 350px;
        width: 100%;
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

    // Gráfico de Barras Horizontal
    const ctxProfesiones = document.getElementById('profesionesChart').getContext('2d');
    const profesionesLabels = [
        @foreach($profesiones->take(15) as $profesion)
            '{{ Str::limit($profesion->profesion ?: "Sin especificar", 20) }}',
        @endforeach
    ];
    const profesionesData = [
        @foreach($profesiones->take(15) as $profesion)
            {{ $profesion->total }},
        @endforeach
    ];

    new Chart(ctxProfesiones, {
        type: 'bar',
        data: {
            labels: profesionesLabels,
            datasets: [{
                label: 'Usuarios',
                data: profesionesData,
                backgroundColor: 'rgba(54, 185, 204, 0.8)',
                borderColor: 'rgba(54, 185, 204, 1)',
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(234, 236, 244, 1)',
                        drawBorder: false
                    },
                    ticks: {
                        beginAtZero: true
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Gráfico de Pastel
    const ctxDistribucion = document.getElementById('distribucionChart').getContext('2d');
    const distribucionLabels = [
        @foreach($profesiones->take(8) as $profesion)
            '{{ Str::limit($profesion->profesion ?: "Sin especificar", 15) }}',
        @endforeach
    ];
    const distribucionData = [
        @foreach($profesiones->take(8) as $profesion)
            {{ $profesion->total }},
        @endforeach
    ];

    new Chart(ctxDistribucion, {
        type: 'doughnut',
        data: {
            labels: distribucionLabels,
            datasets: [{
                data: distribucionData,
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', 
                    '#e74a3b', '#6f42c1', '#e83e8c', '#fd7e14'
                ],
                hoverBackgroundColor: [
                    '#2e59d9', '#17a673', '#2c9faf', '#dda20a', 
                    '#e02d1b', '#59359a', '#d91a72', '#fd6600'
                ],
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
                }
            },
            cutout: '60%'
        }
    });
});
</script>
@endsection 