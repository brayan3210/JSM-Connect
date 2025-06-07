@extends('layouts.admin')

@section('title', 'Estadísticas por Categorías')

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
                        <i class="fas fa-tags text-primary"></i> Estadísticas por Categorías
                    </h1>
                    <p class="text-muted">Análisis detallado de servicios por categoría</p>
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
                                        Categorías Activas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCategorias }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tags fa-2x text-gray-300"></i>
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
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalServicios }}</div>
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
                                        Promedio por Categoría</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $totalCategorias > 0 ? round($totalServicios / $totalCategorias, 1) : 0 }}
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
                                        Categoría Líder</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $categorias->count() > 0 ? $categorias->first()->servicios_count : 0 }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-crown fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos -->
            <div class="row mb-4">
                <!-- Gráfico de Barras -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar me-2"></i>Servicios por Categoría
                            </h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow">
                                    <a class="dropdown-item" href="#" onclick="descargarGrafico('categoriasChart')">
                                        <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Descargar
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-bar">
                                <canvas id="categoriasChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráfico de Pastel -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-pie me-2"></i>Distribución Porcentual
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-pie pt-4 pb-2">
                                <canvas id="distribucionChart"></canvas>
                            </div>
                            <div class="mt-3 text-center small">
                                @foreach($categorias->take(5) as $index => $categoria)
                                    <span class="mr-2 d-inline-block mb-1">
                                        <i class="fas fa-circle" style="color: {{ ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'][$index] ?? '#6c757d' }}"></i> 
                                        {{ Str::limit($categoria->nombre, 15) }}
                                    </span>
                                @endforeach
                                @if($categorias->count() > 5)
                                    <small class="text-muted d-block mt-2">+ {{ $categorias->count() - 5 }} más</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Datos Detallada -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table me-2"></i>Detalle Completo por Categorías
                    </h6>
                    <div class="card-header-actions">
                        <button class="btn btn-sm btn-outline-primary" onclick="buscarEnTabla()">
                            <i class="fas fa-search me-1"></i>Buscar
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="buscarCategoria" class="form-control" placeholder="Buscar categoría...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="categoriasTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Ranking</th>
                                    <th>Categoría</th>
                                    <th>Descripción</th>
                                    <th>Servicios</th>
                                    <th>Especialistas</th>
                                    <th>Solicitudes</th>
                                    <th>Participación</th>
                                    <th>Estado</th>
                                    <th>Rendimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $index => $categoria)
                                    @php
                                        $porcentaje = $totalServicios > 0 ? ($categoria->servicios_count / $totalServicios) * 100 : 0;
                                        $rendimiento = $categoria->servicios_count > 0 && $categoria->solicitudes_count > 0 ? 
                                                     ($categoria->solicitudes_count / $categoria->servicios_count) : 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="ranking-badge ranking-{{ min($index + 1, 5) }}">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded me-2 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-tag"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $categoria->nombre }}</strong>
                                                    <div class="small text-muted">ID: {{ $categoria->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted" data-bs-toggle="tooltip" title="{{ $categoria->descripcion }}">
                                                {{ Str::limit($categoria->descripcion ?: 'Sin descripción', 40) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $categoria->servicios_count }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $categoria->especialistas_count }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-warning">{{ $categoria->solicitudes_count }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                    <div class="progress-bar bg-primary" role="progressbar" 
                                                         style="width: {{ $porcentaje }}%" 
                                                         data-bs-toggle="tooltip" 
                                                         title="{{ number_format($porcentaje, 1) }}%">
                                                    </div>
                                                </div>
                                                <small class="text-muted">{{ number_format($porcentaje, 1) }}%</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($categoria->activo)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Activa
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times-circle"></i> Inactiva
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($rendimiento > 2)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-arrow-up"></i> Alto
                                                </span>
                                            @elseif($rendimiento > 1)
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-arrow-right"></i> Medio
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-arrow-down"></i> Bajo
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

            <!-- Análisis de Tendencias -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-trophy me-2"></i>Top 5 Categorías
                            </h6>
                        </div>
                        <div class="card-body">
                            @foreach($categorias->take(5) as $index => $categoria)
                                @php
                                    $colors = ['primary', 'success', 'info', 'warning', 'danger'];
                                    $color = $colors[$index] ?? 'secondary';
                                @endphp
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="ranking-badge ranking-{{ $index + 1 }} me-3">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $categoria->nombre }}</h6>
                                            <small class="text-muted">{{ $categoria->servicios_count }} servicios</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="h5 mb-0 text-{{ $color }}">
                                            {{ $totalServicios > 0 ? number_format(($categoria->servicios_count / $totalServicios) * 100, 1) : 0 }}%
                                        </div>
                                        <small class="text-muted">del total</small>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-3">
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-line me-2"></i>Estadísticas Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 border-end">
                                    <div class="h4 text-primary mb-1">
                                        {{ $categorias->where('activo', true)->count() }}
                                    </div>
                                    <div class="small text-muted">Categorías Activas</div>
                                </div>
                                <div class="col-6">
                                    <div class="h4 text-success mb-1">
                                        {{ $categorias->sum('especialistas_count') }}
                                    </div>
                                    <div class="small text-muted">Total Especialistas</div>
                                </div>
                            </div>
                            <hr>
                            <div class="row text-center">
                                <div class="col-6 border-end">
                                    <div class="h4 text-info mb-1">
                                        {{ $categorias->sum('solicitudes_count') }}
                                    </div>
                                    <div class="small text-muted">Total Solicitudes</div>
                                </div>
                                <div class="col-6">
                                    <div class="h4 text-warning mb-1">
                                        {{ $categorias->avg('servicios_count') ? number_format($categorias->avg('servicios_count'), 1) : 0 }}
                                    </div>
                                    <div class="small text-muted">Promedio Servicios</div>
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
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }

    .chart-bar, .chart-pie {
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

    // Gráfico de Barras
    const ctxCategorias = document.getElementById('categoriasChart').getContext('2d');
    new Chart(ctxCategorias, {
        type: 'bar',
        data: {
            labels: [@foreach($categorias as $categoria)'{{ Str::limit($categoria->nombre, 20) }}',@endforeach],
            datasets: [{
                label: 'Servicios',
                data: [@foreach($categorias as $categoria){{ $categoria->servicios_count }},@endforeach],
                backgroundColor: 'rgba(78, 115, 223, 0.8)',
                borderColor: 'rgba(78, 115, 223, 1)',
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
                    cornerRadius: 10
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

    // Gráfico de Pastel
    const ctxDistribucion = document.getElementById('distribucionChart').getContext('2d');
    new Chart(ctxDistribucion, {
        type: 'doughnut',
        data: {
            labels: [@foreach($categorias->take(10) as $categoria)'{{ Str::limit($categoria->nombre, 15) }}',@endforeach],
            datasets: [{
                data: [@foreach($categorias->take(10) as $categoria){{ $categoria->servicios_count }},@endforeach],
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                    '#6f42c1', '#e83e8c', '#fd7e14', '#20c997', '#6c757d'
                ],
                hoverBackgroundColor: [
                    '#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#e02d1b',
                    '#59359a', '#d91a72', '#fd6600', '#17a2b8', '#545b62'
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
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '60%',
            animation: {
                animateRotate: true,
                duration: 2000
            }
        }
    });

    // Función de búsqueda en tabla
    window.buscarEnTabla = function() {
        const input = document.getElementById('buscarCategoria');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('categoriasTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            const tdCategoria = tr[i].getElementsByTagName('td')[1];
            if (tdCategoria) {
                const txtValue = tdCategoria.textContent || tdCategoria.innerText;
                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    };

    // Búsqueda en tiempo real
    document.getElementById('buscarCategoria').addEventListener('keyup', buscarEnTabla);

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
    link.download = chartId + '_' + new Date().toISOString().slice(0,10) + '.png';
    link.href = url;
    link.click();
}
</script>
@endsection 