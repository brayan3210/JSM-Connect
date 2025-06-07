@extends('layouts.admin')

@section('title', 'Logs de ' . $usuario->nombre)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-3 col-md-4">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <h1 class="h3 mb-2 mb-md-0 text-gray-800">
                    Logs de {{ $usuario->nombre }} {{ $usuario->apellidos }}
                </h1>
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <a href="{{ route('admin.logs.export', $usuario) }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
                       class="btn btn-sm" style="background-color: #104CFF; color: white;">
                        <i class="fas fa-file-pdf"></i> Exportar PDF
                    </a>
                    <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            <!-- Información del usuario -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #0D6EFD;">Información del Usuario</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nombre:</strong> {{ $usuario->nombre }} {{ $usuario->apellidos }}</p>
                            <p><strong>Email:</strong> {{ $usuario->email }}</p>
                            <p><strong>Profesión:</strong> {{ $usuario->profesion ?? 'No especificada' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tipo:</strong> 
                                @if($usuario->es_admin)
                                    <span class="badge" style="background-color: #ffc107; color: #000;">Administrador</span>
                                @else
                                    <span class="badge badge-info">Usuario</span>
                                @endif
                            </p>
                            <p><strong>Estado:</strong> 
                                @if($usuario->activo)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge" style="background-color: #104CFF; color: white;">Inactivo</span>
                                @endif
                            </p>
                            <p><strong>Registro:</strong> {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estadísticas de logs -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #0D6EFD;">
                                        Total Logs</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['total'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Exitosos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['success'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Advertencias</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['warning'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card shadow h-100 py-2" style="border-left: 4px solid #104CFF;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #104CFF;">
                                        Errores</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $estadisticas['error'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #0D6EFD;">Filtros</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.logs.show', $usuario) }}">
                        <div class="row g-3">
                            <div class="col-md-4 col-sm-6">
                                <label for="tipo" class="form-label">Tipo de Log</label>
                                <select name="tipo" id="tipo" class="form-control">
                                    <option value="">Todos los tipos</option>
                                    <option value="success" {{ $tipo == 'success' ? 'selected' : '' }}>Exitosos</option>
                                    <option value="info" {{ $tipo == 'info' ? 'selected' : '' }}>Información</option>
                                    <option value="warning" {{ $tipo == 'warning' ? 'selected' : '' }}>Advertencias</option>
                                    <option value="error" {{ $tipo == 'error' ? 'selected' : '' }}>Errores</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label for="fecha_desde" class="form-label">Fecha desde</label>
                                <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" 
                                       value="{{ $fecha_desde }}">
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label for="fecha_hasta" class="form-label">Fecha hasta</label>
                                <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" 
                                       value="{{ $fecha_hasta }}">
                            </div>
                            <div class="col-md-2 col-sm-6 d-flex align-items-end">
                                <button type="submit" class="btn w-100" style="background-color: #0D6EFD; color: white;">
                                    <i class="fas fa-filter"></i> <span class="d-none d-sm-inline">Filtrar</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de logs -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #0D6EFD;">
                        Registro de Actividad ({{ $logs->total() }} registros)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha y Hora</th>
                                    <th>Acción</th>
                                    <th class="d-none d-md-table-cell">Descripción</th>
                                    <th class="d-none d-lg-table-cell">IP</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logs as $log)
                                    <tr>
                                        <td>
                                            <div class="text-nowrap">
                                                <strong>{{ $log->created_at ? $log->created_at->format('d/m/Y') : 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $log->created_at ? $log->created_at->format('H:i:s') : 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ $log->accion }}</strong>
                                            <div class="d-md-none mt-1">
                                                @switch($log->tipo)
                                                    @case('success')
                                                        <span class="badge badge-success">Exitoso</span>
                                                        @break
                                                    @case('info')
                                                        <span class="badge badge-info">Info</span>
                                                        @break
                                                    @case('warning')
                                                        <span class="badge badge-warning">Advertencia</span>
                                                        @break
                                                    @case('error')
                                                        <span class="badge" style="background-color: #104CFF; color: white;">Error</span>
                                                        @break
                                                    @default
                                                        <span class="badge badge-secondary">{{ $log->tipo }}</span>
                                                @endswitch
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            {{ Str::limit($log->descripcion, 50) }}
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <small>{{ $log->ip_address ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            @if($log->parametros || $log->descripcion)
                                                <button type="button" class="btn btn-sm btn-outline-info" 
                                                        data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id_log }}">
                                                    <i class="fas fa-info-circle"></i> <span class="d-none d-sm-inline">Ver</span>
                                                </button>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            No se encontraron logs con los filtros aplicados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $logs->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modales para detalles de logs -->
@foreach($logs as $log)
    @if($log->parametros || $log->descripcion)
        <div class="modal fade" id="logModal{{ $log->id_log }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del Log</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Información General:</h6>
                        <ul>
                            <li><strong>Acción:</strong> {{ $log->accion }}</li>
                            <li><strong>Fecha:</strong> {{ $log->created_at ? $log->created_at->format('d/m/Y H:i:s') : 'N/A' }}</li>
                            <li><strong>Tipo:</strong> 
                                @switch($log->tipo)
                                    @case('success')
                                        <span class="badge badge-success">Exitoso</span>
                                        @break
                                    @case('info')
                                        <span class="badge badge-info">Info</span>
                                        @break
                                    @case('warning')
                                        <span class="badge badge-warning">Advertencia</span>
                                        @break
                                    @case('error')
                                        <span class="badge" style="background-color: #104CFF; color: white;">Error</span>
                                        @break
                                    @default
                                        <span class="badge badge-secondary">{{ $log->tipo }}</span>
                                @endswitch
                            </li>
                            <li><strong>IP:</strong> {{ $log->ip_address ?? 'N/A' }}</li>
                            <li><strong>URL:</strong> {{ $log->url ?? 'N/A' }}</li>
                            <li><strong>Método:</strong> {{ $log->metodo_http ?? 'N/A' }}</li>
                        </ul>
                        
                        @if($log->descripcion)
                            <h6>Descripción:</h6>
                            <p class="bg-light p-3 rounded">{{ $log->descripcion }}</p>
                        @endif
                        
                        @if($log->parametros)
                            <h6>Parámetros:</h6>
                            <pre class="bg-light p-3 rounded">{{ json_encode($log->parametros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection 