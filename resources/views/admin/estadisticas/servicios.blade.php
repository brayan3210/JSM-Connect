@extends('layouts.admin')

@section('title', 'Estadísticas de Servicios')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-chart-line"></i> Estadísticas de Servicios
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
                                        Total Servicios</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['total']) }}</div>
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
                                        Servicios Activos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['activos']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                                        Servicios Expirados</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['expirados']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                        Nuevos este mes</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['este_mes']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-plus fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos Principales -->
            <div class="row mb-4">
                <!-- Servicios por Mes -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-area"></i> Servicios Registrados por Mes
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow">
                                    <div class="dropdown-header">Opciones:</div>
                                    <a class="dropdown-item" href="#" onclick="descargarGrafico('serviciosPorMesChart')">
                                        <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Descargar Gráfico
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="serviciosPorMesChart" width="100%" height="40"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estado de Servicios -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie"></i> Estado de Servicios
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="estadoServiciosChart"></canvas>
                            </div>
                            <div class="mt-4 text-center small">
                                <span class="mr-2">
                                    <i class="fas fa-circle text-success"></i> Activos
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-circle text-danger"></i> Inactivos
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Servicios por Categoría y Tipos de Intercambio -->
            <div class="row mb-4">
                <!-- Servicios por Categoría -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-tags"></i> Servicios por Categoría
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="serviciosPorCategoriaChart" width="100%" height="50"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tipos de Intercambio -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-exchange-alt"></i> Tipos de Intercambio
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-doughnut">
                                <canvas id="tiposIntercambioChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Duración de Servicios -->
            <div class="row mb-4">
                <div class="col-xl-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-clock"></i> Distribución por Duración de Servicios
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="duracionServiciosChart" width="100%" height="50"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tablas de Datos -->
            <div class="row">
                <!-- Top Servicios Más Solicitados -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-star"></i> Servicios Más Solicitados
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($serviciosMasSolicitados->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Servicio</th>
                                                <th>Categoría</th>
                                                <th>Proveedor</th>
                                                <th>Solicitudes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($serviciosMasSolicitados as $index => $servicio)
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">{{ $index + 1 }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="font-weight-bold">{{ Str::limit($servicio->titulo, 30) }}</div>
                                                        <small class="text-success">
                                                            <i class="fas fa-exchange-alt me-1"></i>{{ $servicio->tipo_intercambio ?? 'No especificado' }}
                                                        </small>
                                                    </td>
                                                    <td>
                                                        @if($servicio->categoria)
                                                            <span class="badge bg-info">{{ $servicio->categoria->nombre }}</span>
                                                        @else
                                                            <span class="text-muted">Sin categoría</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($servicio->usuario)
                                                            {{ $servicio->usuario->nombre }}
                                                        @else
                                                            <span class="text-muted">Usuario eliminado</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-success">{{ $servicio->solicitudes_count }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay datos de solicitudes disponibles</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Resumen por Categorías -->
                <div class="col-xl-6 col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-list"></i> Resumen por Categorías
                            </h6>
                        </div>
                        <div class="card-body">
                            @if($serviciosPorCategoria->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Categoría</th>
                                                <th>Servicios</th>
                                                <th>Porcentaje</th>
                                                <th>Progreso</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($serviciosPorCategoria as $categoria)
                                                @php
                                                    $porcentaje = $estadisticas['total'] > 0 ? ($categoria->servicios_count / $estadisticas['total']) * 100 : 0;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="font-weight-bold">{{ $categoria->nombre }}</div>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary">{{ $categoria->servicios_count }}</span>
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
                                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay servicios por categorías disponibles</p>
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

    // Gráfico de Servicios por Mes
    const ctxMes = document.getElementById('serviciosPorMesChart').getContext('2d');
    new Chart(ctxMes, {
        type: 'line',
        data: {
            labels: [@foreach($meses as $mes)'{{ $mes }}',@endforeach],
            datasets: [{
                label: 'Servicios Registrados',
                data: [{{ implode(',', $totalesPorMes) }}],
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointBorderColor: 'rgba(78, 115, 223, 1)',
                pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                pointRadius: 4,
                pointHoverRadius: 6
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
                    displayColors: false
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(234, 236, 244, 1)',
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
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

    // Gráfico de Estado de Servicios
    const ctxEstado = document.getElementById('estadoServiciosChart').getContext('2d');
    new Chart(ctxEstado, {
        type: 'doughnut',
        data: {
            labels: ['Activos', 'Inactivos'],
            datasets: [{
                data: [{{ $serviciosActivos }}, {{ $serviciosInactivos }}],
                backgroundColor: ['#1cc88a', '#e74a3b'],
                hoverBackgroundColor: ['#17a673', '#e02d1b'],
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

    // Gráfico de Servicios por Categoría
    const ctxCategoria = document.getElementById('serviciosPorCategoriaChart').getContext('2d');
    new Chart(ctxCategoria, {
        type: 'bar',
        data: {
            labels: [@foreach($serviciosPorCategoria as $cat)'{{ $cat->nombre }}',@endforeach],
            datasets: [{
                label: 'Servicios',
                data: [@foreach($serviciosPorCategoria as $cat){{ $cat->servicios_count }},@endforeach],
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

    // Gráfico de Tipos de Intercambio
    const ctxTipos = document.getElementById('tiposIntercambioChart').getContext('2d');
    new Chart(ctxTipos, {
        type: 'doughnut',
        data: {
            labels: [@foreach($tiposIntercambio as $tipo)'{{ $tipo->tipo_intercambio }}',@endforeach],
            datasets: [{
                data: [@foreach($tiposIntercambio as $tipo){{ $tipo->cantidad }},@endforeach],
                backgroundColor: [
                    '#4e73df',
                    '#1cc88a', 
                    '#36b9cc',
                    '#f6c23e',
                    '#e74a3b',
                    '#6f42c1'
                ],
                hoverBackgroundColor: [
                    '#2e59d9',
                    '#17a673',
                    '#2c9faf',
                    '#dda20a',
                    '#e02d1b',
                    '#5a32a3'
                ],
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

    // Gráfico de Duración de Servicios
    const ctxDuracion = document.getElementById('duracionServiciosChart').getContext('2d');
    new Chart(ctxDuracion, {
        type: 'bar',
        data: {
            labels: [@foreach($duracionServicios as $duracion)'{{ $duracion->rango }}',@endforeach],
            datasets: [{
                label: 'Servicios',
                data: [@foreach($duracionServicios as $duracion){{ $duracion->cantidad }},@endforeach],
                backgroundColor: 'rgba(54, 185, 204, 0.8)',
                borderColor: 'rgba(54, 185, 204, 1)',
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

// Función para descargar gráficos
function descargarGrafico(chartId) {
    const canvas = document.getElementById(chartId);
    const url = canvas.toDataURL('image/png');
    const link = document.createElement('a');
    link.download = chartId + '.png';
    link.href = url;
    link.click();
}
</script>
@endsection 