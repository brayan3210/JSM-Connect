@extends('layouts.app')

@section('title', 'Solicitudes Enviadas')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Solicitudes Enviadas</h1>
                <a href="{{ route('solicitudes.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="card shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Todas las solicitudes enviadas</h5>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filtrar por estado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.enviadas') }}">Todos</a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.enviadas', ['estado' => 'pendiente']) }}">Pendientes</a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.enviadas', ['estado' => 'aceptada']) }}">Aceptadas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.enviadas', ['estado' => 'rechazada']) }}">Rechazadas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.enviadas', ['estado' => 'completada']) }}">Completadas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.enviadas', ['estado' => 'cancelada']) }}">Canceladas</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($enviadas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Servicio</th>
                                        <th>Proveedor</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enviadas as $solicitud)
                                        <tr>
                                            <td>{{ $solicitud->servicio->titulo }}</td>
                                            <td>{{ $solicitud->usuario_proveedor->nombre }} {{ $solicitud->usuario_proveedor->apellidos }}</td>
                                            <td>{{ $solicitud->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = [
                                                        'pendiente' => 'bg-warning',
                                                        'aceptada' => 'bg-success',
                                                        'rechazada' => 'bg-danger',
                                                        'completada' => 'bg-info',
                                                        'cancelada' => 'bg-secondary'
                                                    ][$solicitud->estado] ?? 'bg-secondary';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ ucfirst($solicitud->estado) }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('solicitudes.show', $solicitud) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                
                                                @if($solicitud->estado === 'pendiente')
                                                <form action="{{ route('solicitudes.estado', $solicitud) }}" method="POST" class="mt-1">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="estado" value="cancelada">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-ban me-1"></i> Cancelar
                                                    </button>
                                                </form>
                                                @endif
                                                
                                                @if($solicitud->estado === 'completada' && !$solicitud->puntuacion)
                                                <button type="button" class="btn btn-sm btn-warning mt-1" data-bs-toggle="modal" data-bs-target="#valorarModal{{ $solicitud->id_solicitud }}">
                                                    <i class="fas fa-star me-1"></i> Valorar
                                                </button>
                                                
                                                <!-- Modal Valorar -->
                                                <div class="modal fade" id="valorarModal{{ $solicitud->id_solicitud }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Valorar servicio</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('solicitudes.valorar', $solicitud) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Puntuación</label>
                                                                        <div class="star-rating">
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="puntuacion" id="star1{{ $solicitud->id_solicitud }}" value="1" required>
                                                                                <label class="form-check-label" for="star1{{ $solicitud->id_solicitud }}">1</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="puntuacion" id="star2{{ $solicitud->id_solicitud }}" value="2">
                                                                                <label class="form-check-label" for="star2{{ $solicitud->id_solicitud }}">2</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="puntuacion" id="star3{{ $solicitud->id_solicitud }}" value="3">
                                                                                <label class="form-check-label" for="star3{{ $solicitud->id_solicitud }}">3</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="puntuacion" id="star4{{ $solicitud->id_solicitud }}" value="4">
                                                                                <label class="form-check-label" for="star4{{ $solicitud->id_solicitud }}">4</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input" type="radio" name="puntuacion" id="star5{{ $solicitud->id_solicitud }}" value="5">
                                                                                <label class="form-check-label" for="star5{{ $solicitud->id_solicitud }}">5</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="comentario{{ $solicitud->id_solicitud }}" class="form-label">Comentario</label>
                                                                        <textarea class="form-control" id="comentario{{ $solicitud->id_solicitud }}" name="comentario" rows="3"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                    <button type="submit" class="btn btn-primary">Enviar valoración</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $enviadas->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <img src="{{ asset('images/empty.svg') }}" alt="No hay solicitudes" class="img-fluid mb-3" style="max-height: 150px;">
                            <h5>No has enviado solicitudes</h5>
                            <p class="text-muted">Cuando solicites un servicio, aparecerá aquí.</p>
                            <a href="{{ route('buscar') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-search me-1"></i> Buscar servicios
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 