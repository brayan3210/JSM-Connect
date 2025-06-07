@extends('layouts.app')

@section('title', 'Detalles de la Solicitud')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Detalles de la Solicitud</h1>
                <div>
                    @if(auth()->id() == $solicitud->id_usuario_solicitante)
                        <a href="{{ route('solicitudes.enviadas') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Volver a Enviadas
                        </a>
                    @else
                        <a href="{{ route('solicitudes.recibidas') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Volver a Recibidas
                        </a>
                    @endif
                </div>
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
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Detalles del Servicio -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="m-0 font-weight-bold">Información del Servicio</h5>
                        </div>
                        <div class="card-body">
                            <h4>{{ $solicitud->servicio->titulo }}</h4>
                            <p class="text-muted">
                                Categoría: <span class="badge bg-info">{{ $solicitud->servicio->categoria->nombre }}</span>
                            </p>
                            <hr>
                            <p>{!! nl2br(e($solicitud->servicio->descripcion)) !!}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0">${{ number_format($solicitud->servicio->precio, 2) }}</span>
                                <a href="{{ route('servicios.show', $solicitud->servicio) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye me-1"></i> Ver Servicio Completo
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detalles de la Solicitud -->
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="m-0 font-weight-bold">Detalles de la Solicitud</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <h6>Mensaje del solicitante:</h6>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0">{!! nl2br(e($solicitud->mensaje)) !!}</p>
                                </div>
                            </div>
                            
                            @if($solicitud->fecha_deseada)
                            <div class="mb-4">
                                <h6>Fecha deseada:</h6>
                                <p>{{ $solicitud->fecha_deseada->format('d/m/Y') }}</p>
                            </div>
                            @endif
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6>Estado actual:</h6>
                                    @php
                                        $badgeClass = [
                                            'pendiente' => 'bg-warning',
                                            'aceptada' => 'bg-success',
                                            'rechazada' => 'bg-danger',
                                            'completada' => 'bg-info',
                                            'cancelada' => 'bg-secondary'
                                        ][$solicitud->estado] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} fs-6">{{ ucfirst($solicitud->estado) }}</span>
                                </div>
                                <div class="col-md-6">
                                    <h6>Fecha de solicitud:</h6>
                                    <p>{{ $solicitud->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($solicitud->comentario_estado)
                            <div class="mb-4">
                                <h6>Comentario sobre el estado:</h6>
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0">{!! nl2br(e($solicitud->comentario_estado)) !!}</p>
                                </div>
                            </div>
                            @endif
                            
                            @if($solicitud->puntuacion)
                            <div class="mb-4">
                                <h6>Valoración del servicio:</h6>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="me-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $solicitud->puntuacion ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <span>({{ $solicitud->puntuacion }}/5)</span>
                                </div>
                                @if($solicitud->comentario_valoracion)
                                <div class="p-3 bg-light rounded">
                                    <p class="mb-0">{!! nl2br(e($solicitud->comentario_valoracion)) !!}</p>
                                </div>
                                @endif
                            </div>
                            @endif
                            
                            <!-- Acciones de la solicitud -->
                            <div class="mt-4">
                                <!-- Si el usuario es el solicitante -->
                                @if(auth()->id() == $solicitud->id_usuario_solicitante)
                                    <!-- Si está pendiente, puede cancelar -->
                                    @if($solicitud->estado == 'pendiente')
                                    <form action="{{ route('solicitudes.estado', $solicitud) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" value="cancelada">
                                        <div class="mb-3">
                                            <label for="comentario" class="form-label">Motivo de cancelación (opcional)</label>
                                            <textarea name="comentario" id="comentario" class="form-control" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-ban me-1"></i> Cancelar Solicitud
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <!-- Si está aceptada, puede marcar como completada -->
                                    @if($solicitud->estado == 'aceptada')
                                    <form action="{{ route('solicitudes.estado', $solicitud) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" value="completada">
                                        <div class="mb-3">
                                            <label for="comentario" class="form-label">Comentario (opcional)</label>
                                            <textarea name="comentario" id="comentario" class="form-control" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-check-double me-1"></i> Marcar como Completada
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <!-- Si está completada pero no valorada, puede valorar -->
                                    @if($solicitud->estado == 'completada' && !$solicitud->puntuacion)
                                    <form action="{{ route('solicitudes.valorar', $solicitud) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">¿Cómo calificarías este servicio?</label>
                                            <div class="star-rating d-flex mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="puntuacion" 
                                                           id="star{{ $i }}" value="{{ $i }}" required>
                                                    <label class="form-check-label" for="star{{ $i }}">{{ $i }}</label>
                                                </div>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="comentario_valoracion" class="form-label">Comentario (opcional)</label>
                                            <textarea name="comentario" id="comentario_valoracion" class="form-control" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-star me-1"></i> Enviar Valoración
                                        </button>
                                    </form>
                                    @endif
                                
                                <!-- Si el usuario es el proveedor -->
                                @elseif(auth()->id() == $solicitud->id_usuario_proveedor)
                                    <!-- Si está pendiente, puede aceptar o rechazar -->
                                    @if($solicitud->estado == 'pendiente')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <form action="{{ route('solicitudes.estado', $solicitud) }}" method="POST" class="mb-3">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="estado" value="aceptada">
                                                <div class="mb-3">
                                                    <label for="comentario_aceptar" class="form-label">Comentario (opcional)</label>
                                                    <textarea name="comentario" id="comentario_aceptar" class="form-control" rows="3"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fas fa-check me-1"></i> Aceptar Solicitud
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-6">
                                            <form action="{{ route('solicitudes.estado', $solicitud) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="estado" value="rechazada">
                                                <div class="mb-3">
                                                    <label for="comentario_rechazar" class="form-label">Motivo del rechazo (opcional)</label>
                                                    <textarea name="comentario" id="comentario_rechazar" class="form-control" rows="3"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-times me-1"></i> Rechazar Solicitud
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Si está aceptada, puede marcar como completada -->
                                    @if($solicitud->estado == 'aceptada')
                                    <form action="{{ route('solicitudes.estado', $solicitud) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="estado" value="completada">
                                        <div class="mb-3">
                                            <label for="comentario" class="form-label">Comentario (opcional)</label>
                                            <textarea name="comentario" id="comentario" class="form-control" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-info">
                                            <i class="fas fa-check-double me-1"></i> Marcar como Completada
                                        </button>
                                    </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- Información del Solicitante -->
                    @if(auth()->id() == $solicitud->id_usuario_proveedor)
                    <div class="card shadow mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="m-0 font-weight-bold">Información del Solicitante</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <i class="fas fa-user-circle fa-5x text-gray-300 mb-3"></i>
                                <h5>{{ $solicitud->usuario_solicitante->nombre }} {{ $solicitud->usuario_solicitante->apellidos }}</h5>
                                <p class="text-muted">{{ $solicitud->usuario_solicitante->profesion }}</p>
                            </div>
                            
                            <hr>
                            
                            <div class="mb-3">
                                <strong><i class="fas fa-envelope me-1"></i> Email:</strong>
                                <p>{{ $solicitud->usuario_solicitante->email }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong><i class="fas fa-phone me-1"></i> Teléfono:</strong>
                                <p>{{ $solicitud->usuario_solicitante->telefono }}</p>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('usuarios.show', $solicitud->usuario_solicitante) }}" class="btn btn-primary">
                                    <i class="fas fa-user me-1"></i> Ver Perfil Completo
                                </a>
                                <a href="{{ route('mensajes.conversacion', $solicitud->usuario_solicitante->id_usuario) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-comments me-1"></i> Enviar Mensaje
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Información del Proveedor -->
                    @if(auth()->id() == $solicitud->id_usuario_solicitante)
                    <div class="card shadow mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="m-0 font-weight-bold">Información del Proveedor</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <i class="fas fa-user-circle fa-5x text-gray-300 mb-3"></i>
                                <h5>{{ $solicitud->usuario_proveedor->nombre }} {{ $solicitud->usuario_proveedor->apellidos }}</h5>
                                <p class="text-muted">{{ $solicitud->usuario_proveedor->profesion }}</p>
                            </div>
                            
                            <hr>
                            
                            <div class="mb-3">
                                <strong><i class="fas fa-envelope me-1"></i> Email:</strong>
                                <p>{{ $solicitud->usuario_proveedor->email }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <strong><i class="fas fa-phone me-1"></i> Teléfono:</strong>
                                <p>{{ $solicitud->usuario_proveedor->telefono }}</p>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ route('usuarios.show', $solicitud->usuario_proveedor) }}" class="btn btn-primary">
                                    <i class="fas fa-user me-1"></i> Ver Perfil Completo
                                </a>
                                <a href="{{ route('mensajes.conversacion', $solicitud->usuario_proveedor->id_usuario) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-comments me-1"></i> Enviar Mensaje
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 