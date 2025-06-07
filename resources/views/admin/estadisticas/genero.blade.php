@extends('layouts.admin')

@section('title', 'Estadísticas por Género')

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
                        <i class="fas fa-venus-mars text-primary"></i> Estadísticas por Género
                    </h1>
                    <p class="text-muted">Análisis de distribución de usuarios por género</p>
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
                                        Total Usuarios</div>
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
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Géneros Registrados</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $generos->count() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list fa-2x text-gray-300"></i>
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
                                        Género Mayoritario</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $generos->count() > 0 ? $generos->first()->total : 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-crown fa-2x text-gray-300"></i>
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
                                        Distribución Equilibrio</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        @php
                                            $maxPorcentaje = $totalUsuarios > 0 && $generos->count() > 0 ? 
                                                           ($generos->first()->total / $totalUsuarios) * 100 : 0;
                                        @endphp
                                        {{ number_format($maxPorcentaje, 1) }}%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos Principales -->
            <div class="row mb-4">
                <!-- Gráfico de Pastel Principal -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie me-2"></i>Distribución por Género
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow">
                                    <a class="dropdown-item" href="#" onclick="descargarGrafico('generoChart')">
                                        <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Descargar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="generoChart"></canvas>
                            </div>
                            <div class="mt-4 text-center">
                                @foreach($generos as $index => $genero)
                                    <div class="d-inline-block mx-2 mb-2">
                                        <i class="fas fa-circle" 
                                           style="color: {{ ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'][$index] ?? '#6c757d' }}"></i>
                                        <span class="small ml-1">
                                            {{ $genero->genero }} 
                                            <strong>({{ $genero->total }})</strong>
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Barras -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar me-2"></i>Comparativa por Cantidad
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="comparativaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de Datos por Género -->
            <div class="row mb-4">
                @foreach($generos as $index => $genero)
                    @php
                        $colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                        $colorClass = $colors[$index] ?? 'secondary';
                        $porcentaje = $totalUsuarios > 0 ? ($genero->total / $totalUsuarios) * 100 : 0;
                        
                        // Iconos por género
                        $iconos = [
                            'Masculino' => 'fa-mars',
                            'Femenino' => 'fa-venus',
                            'Otro' => 'fa-genderless',
                            'Prefiero no decir' => 'fa-question-circle'
                        ];
                        $icono = $iconos[$genero->genero] ?? 'fa-user';
                    @endphp
                    <div class="col-xl-{{ $generos->count() <= 2 ? '6' : ($generos->count() <= 4 ? '3' : '2') }} col-md-6 mb-4">
                        <div class="card border-left-{{ $colorClass }} shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-{{ $colorClass }} text-uppercase mb-1">
                                            {{ $genero->genero }}
                                        </div>
                                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $genero->total }}</div>
                                        <div class="small text-muted mt-2">
                                            {{ number_format($porcentaje, 1) }}% del total
                                        </div>
                                        <div class="progress mt-2" style="height: 4px;">
                                            <div class="progress-bar bg-{{ $colorClass }}" role="progressbar" 
                                                 style="width: {{ $porcentaje }}%">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas {{ $icono }} fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tabla Detallada -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table me-2"></i>Análisis Detallado por Género
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Posición</th>
                                    <th>Género</th>
                                    <th>Cantidad</th>
                                    <th>Porcentaje</th>
                                    <th>Representación Visual</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($generos as $index => $genero)
                                    @php
                                        $porcentaje = $totalUsuarios > 0 ? ($genero->total / $totalUsuarios) * 100 : 0;
                                        $colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                                        $colorClass = $colors[$index] ?? 'secondary';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="ranking-badge ranking-{{ min($index + 1, 5) }}">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-{{ $colorClass }} text-white rounded me-2 d-flex align-items-center justify-content-center">
                                                    @php
                                                        $iconos = [
                                                            'Masculino' => 'fa-mars',
                                                            'Femenino' => 'fa-venus',
                                                            'Otro' => 'fa-genderless',
                                                            'Prefiero no decir' => 'fa-question-circle'
                                                        ];
                                                        $icono = $iconos[$genero->genero] ?? 'fa-user';
                                                    @endphp
                                                    <i class="fas {{ $icono }}"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $genero->genero }}</strong>
                                                    <div class="small text-muted">Categoría de género</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-{{ $colorClass }} fs-6">{{ $genero->total }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="h6 text-{{ $colorClass }} mb-0">
                                                {{ number_format($porcentaje, 1) }}%
                                            </span>
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-{{ $colorClass }}" role="progressbar" 
                                                     style="width: {{ $porcentaje }}%" 
                                                     data-bs-toggle="tooltip" 
                                                     title="{{ $genero->total }} usuarios ({{ number_format($porcentaje, 1) }}%)">
                                                    <span class="small text-white">{{ $genero->total }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($porcentaje >= 40)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-chart-line"></i> Mayoritario
                                                </span>
                                            @elseif($porcentaje >= 30)
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-balance-scale"></i> Significativo
                                                </span>
                                            @elseif($porcentaje >= 10)
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-chart-pie"></i> Moderado
                                                </span>
                                            @else
                                                <span class="badge bg-info">
                                                    <i class="fas fa-chart-area"></i> Minoritario
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Análisis Estadístico -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-calculator me-2"></i>Análisis Estadístico
                            </h6>
                        </div>
                        <div class="card-body">
                            @php
                                $maxGenero = $generos->first();
                                $minGenero = $generos->last();
                                $diferencia = $maxGenero && $minGenero ? $maxGenero->total - $minGenero->total : 0;
                            @endphp
                            <div class="row text-center mb-3">
                                <div class="col-6 border-end">
                                    <div class="h4 text-success mb-1">{{ $maxGenero ? $maxGenero->genero : 'N/A' }}</div>
                                    <div class="small text-muted">Género Predominante</div>
                                    <div class="small text-success">{{ $maxGenero ? $maxGenero->total : 0 }} usuarios</div>
                                </div>
                                <div class="col-6">
                                    <div class="h4 text-info mb-1">{{ $minGenero ? $minGenero->genero : 'N/A' }}</div>
                                    <div class="small text-muted">Género Minoritario</div>
                                    <div class="small text-info">{{ $minGenero ? $minGenero->total : 0 }} usuarios</div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <div class="h4 text-warning mb-1">{{ $diferencia }}</div>
                                <div class="small text-muted">Diferencia entre mayor y menor</div>
                                @if($totalUsuarios > 0)
                                    <div class="small text-warning">
                                        {{ number_format(($diferencia / $totalUsuarios) * 100, 1) }}% de variación
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-line me-2"></i>Tendencias y Observaciones
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="text-primary">Distribución de Género:</h6>
                                @if($generos->count() >= 2)
                                    @php
                                        $diferenciaPorcentual = $totalUsuarios > 0 ? 
                                            abs($generos->first()->total - $generos->skip(1)->first()->total) / $totalUsuarios * 100 : 0;
                                    @endphp
                                    @if($diferenciaPorcentual <= 10)
                                        <p class="text-success mb-2">
                                            <i class="fas fa-check-circle"></i> 
                                            Distribución equilibrada entre géneros principales
                                        </p>
                                    @elseif($diferenciaPorcentual <= 30)
                                        <p class="text-warning mb-2">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            Distribución moderadamente desequilibrada
                                        </p>
                                    @else
                                        <p class="text-danger mb-2">
                                            <i class="fas fa-times-circle"></i> 
                                            Distribución significativamente desequilibrada
                                        </p>
                                    @endif
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <h6 class="text-primary">Diversidad:</h6>
                                @if($generos->count() >= 4)
                                    <p class="text-success mb-2">
                                        <i class="fas fa-star"></i> 
                                        Alta diversidad de géneros registrados
                                    </p>
                                @elseif($generos->count() >= 3)
                                    <p class="text-info mb-2">
                                        <i class="fas fa-thumbs-up"></i> 
                                        Buena diversidad de géneros
                                    </p>
                                @else
                                    <p class="text-warning mb-2">
                                        <i class="fas fa-info-circle"></i> 
                                        Diversidad limitada de géneros
                                    </p>
                                @endif
                            </div>

                            <div>
                                <h6 class="text-primary">Participación:</h6>
                                <p class="text-muted mb-0">
                                    El {{ number_format(($generos->take(2)->sum('total') / $totalUsuarios) * 100, 1) }}% 
                                    de usuarios pertenece a los dos géneros principales.
                                </p>
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
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
    .border-left-danger { border-left: 0.25rem solid #e74a3b !important; }
    .border-left-secondary { border-left: 0.25rem solid #6c757d !important; }

    .chart-pie, .chart-bar {
        position: relative;
        height: 300px;
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

    .avatar-sm {
        width: 35px;
        height: 35px;
        font-size: 0.875rem;
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

    // Gráfico de Pastel
    const ctxGenero = document.getElementById('generoChart').getContext('2d');
    new Chart(ctxGenero, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach($generos as $genero)'{{ $genero->genero }}',@endforeach
            ],
            datasets: [{
                data: [
                    @foreach($generos as $genero){{ $genero->total }},@endforeach
                ],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#6c757d'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#e02d1b', '#545b62'],
                borderWidth: 4,
                borderColor: '#ffffff',
                hoverOffset: 15
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
                    backgroundColor: 'rgba(255,255,255,.95)',
                    titleColor: '#6e707e',
                    bodyColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    cornerRadius: 15,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' usuarios (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '65%',
            animation: {
                animateRotate: true,
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });

    // Gráfico de Barras Comparativo
    const ctxComparativa = document.getElementById('comparativaChart').getContext('2d');
    new Chart(ctxComparativa, {
        type: 'bar',
        data: {
            labels: [
                @foreach($generos as $genero)'{{ $genero->genero }}',@endforeach
            ],
            datasets: [{
                label: 'Usuarios',
                data: [
                    @foreach($generos as $genero){{ $genero->total }},@endforeach
                ],
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(54, 185, 204, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)',
                    'rgba(108, 117, 125, 0.8)'
                ],
                borderColor: [
                    'rgba(78, 115, 223, 1)',
                    'rgba(28, 200, 138, 1)',
                    'rgba(54, 185, 204, 1)',
                    'rgba(246, 194, 62, 1)',
                    'rgba(231, 74, 59, 1)',
                    'rgba(108, 117, 125, 1)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
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
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed.y / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed.y + ' usuarios (' + percentage + '%)';
                        }
                    }
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
            },
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            }
        }
    });

    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Función para descargar gráficos
function descargarGrafico(chartId) {
    const canvas = document.getElementById(chartId);
    const url = canvas.toDataURL('image/png');
    const link = document.createElement('a');
    link.download = chartId + '_generos_' + new Date().toISOString().slice(0,10) + '.png';
    link.href = url;
    link.click();
}
</script>
@endsection 