@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">Dashboard</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Estadísticas Rápidas -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <i class="fas fa-briefcase fa-2x"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Servicios Activos</p>
                                    <h4 class="mb-0">{{ $estadisticas['servicios_activos'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <i class="fas fa-inbox fa-2x"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Solicitudes Recibidas</p>
                                    <h4 class="mb-0">{{ $estadisticas['solicitudes_pendientes'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <i class="fas fa-paper-plane fa-2x"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Solicitudes Enviadas</p>
                                    <h4 class="mb-0">{{ $estadisticas['solicitudes_enviadas_pendientes'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <i class="fas fa-star fa-2x"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0">Especialidades</p>
                                    <h4 class="mb-0">{{ $estadisticas['especialidades_count'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Servicios recientes -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Mis servicios de intercambio recientes</h5>
                    <a href="{{ route('servicios.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
                </div>
                <div class="card-body">
                    @if($serviciosOfrecidos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Servicio</th>
                                        <th>Categoría</th>
                                        <th>Tipo de Intercambio</th>
                                        <th>Tiempo Restante</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($serviciosOfrecidos as $servicio)
                                        <tr class="{{ $servicio->hasExpired() ? 'table-danger' : '' }}">
                                            <td>{{ $servicio->titulo }}</td>
                                            <td>{{ $servicio->categoria->nombre }}</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-exchange-alt me-1"></i>
                                                    {{ $servicio->tipo_intercambio }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($servicio->hasExpired())
                                                    <span class="badge bg-danger">Expirado</span>
                                                @elseif($servicio->fecha_expiracion)
                                                    @php
                                                        $diasRestantes = $servicio->getDaysUntilExpiration();
                                                    @endphp
                                                    @if($diasRestantes <= 3)
                                                        <span class="badge bg-warning">{{ $diasRestantes }} días</span>
                                                    @else
                                                        <span class="badge bg-info">{{ $diasRestantes }} días</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">Sin límite</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('servicios.show', $servicio) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <img src="{{ asset('images/empty-services.svg') }}" alt="No servicios" class="img-fluid mb-3" style="max-height: 150px">
                            <p>No tienes servicios de intercambio activos.</p>
                            <a href="{{ route('servicios.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle me-1"></i> Crear servicio de intercambio
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Servicios disponibles -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Servicios de intercambio disponibles</h5>
                    <a href="{{ route('buscar') }}" class="btn btn-sm btn-outline-primary">Buscar más</a>
                </div>
                <div class="card-body">
                    @if($serviciosRecientes->count() > 0)
                        <div class="row">
                            @foreach($serviciosRecientes as $servicio)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm {{ $servicio->hasExpired() ? 'border-danger' : '' }}">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $servicio->titulo }}</h6>
                                            <p class="card-text small text-muted">{{ Str::limit($servicio->descripcion, 80) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-info">{{ $servicio->categoria->nombre }}</span>
                                                <div class="text-end">
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-exchange-alt me-1"></i> Intercambio
                                                    </span>
                                                    @if($servicio->hasExpired())
                                                        <br><span class="badge bg-danger mt-1">Expirado</span>
                                                    @elseif($servicio->fecha_expiracion)
                                                        <br><small class="text-muted">{{ $servicio->getDaysUntilExpiration() }} días</small>
                                                    @endif
                                                </div>
                                            </div>
                                            <p class="small mt-2 mb-0">
                                                <i class="fas fa-user me-1"></i> {{ $servicio->usuario->nombre }} {{ $servicio->usuario->apellidos }}
                                            </p>
                                        </div>
                                        <div class="card-footer bg-white border-0 pt-0">
                                            <a href="{{ route('servicios.show', $servicio) }}" class="btn btn-sm btn-primary w-100">
                                                <i class="fas fa-info-circle me-1"></i> Ver detalles
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-3">
                            <p class="text-muted">No hay servicios de intercambio disponibles en este momento.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Solicitudes recibidas -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Solicitudes recibidas</h5>
                            <a href="{{ route('solicitudes.recibidas') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                        </div>
                        <div class="card-body">
                            @if($solicitudesRecibidas->count() > 0)
                                <div class="list-group">
                                    @foreach($solicitudesRecibidas as $solicitud)
                                        <a href="{{ route('solicitudes.show', $solicitud) }}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $solicitud->servicio->titulo }}</h6>
                                                <small class="text-muted">{{ $solicitud->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-1">De: {{ $solicitud->usuario_solicitante->nombre }} {{ $solicitud->usuario_solicitante->apellidos }}</p>
                                            <small class="text-muted">
                                                <span class="badge bg-warning">Pendiente</span>
                                            </small>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <p class="text-muted">No tienes solicitudes pendientes.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Solicitudes enviadas -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Solicitudes enviadas</h5>
                            <a href="{{ route('solicitudes.enviadas') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                        </div>
                        <div class="card-body">
                            @if($solicitudesEnviadas->count() > 0)
                                <div class="list-group">
                                    @foreach($solicitudesEnviadas as $solicitud)
                                        <a href="{{ route('solicitudes.show', $solicitud) }}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $solicitud->servicio->titulo }}</h6>
                                                <small class="text-muted">{{ $solicitud->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-1">Para: {{ $solicitud->usuario_proveedor->nombre }} {{ $solicitud->usuario_proveedor->apellidos }}</p>
                                            <small class="text-muted">
                                                <span class="badge bg-warning">Pendiente</span>
                                            </small>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <p class="text-muted">No tienes solicitudes enviadas pendientes.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Búsqueda rápida de servicios -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Búsqueda rápida de intercambios</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('buscar') }}" method="GET">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="query" class="form-label">Buscar servicios de intercambio</label>
                                    <input type="text" class="form-control" id="query" name="query" placeholder="¿Qué servicio de intercambio necesitas?">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label for="categoria" class="form-label">Categoría</label>
                                    <select class="form-select" id="categoria" name="categoria">
                                        <option value="">Todas las categorías</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label class="invisible">Buscar</label>
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search me-1"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 