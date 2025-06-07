@extends('layouts.app')

@section('title', $servicio->titulo)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Detalles del Servicio de Intercambio</h2>
        <div>
            <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver a Servicios
            </a>
            @if($servicio->id_usuario == auth()->user()->id_usuario)
                <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-info ms-2">
                    <i class="fas fa-edit me-1"></i> Editar Servicio
                </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4 {{ $servicio->hasExpired() ? 'border-danger' : '' }}">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $servicio->titulo }}</h6>
                    <div>
                        @if($servicio->hasExpired())
                            <span class="badge bg-danger">Expirado</span>
                        @elseif($servicio->disponible)
                            <span class="badge bg-success">Disponible</span>
                        @else
                            <span class="badge bg-secondary">No disponible</span>
                        @endif
                        
                        @if($servicio->fecha_expiracion && !$servicio->hasExpired())
                            @php
                                $diasRestantes = $servicio->getDaysUntilExpiration();
                            @endphp
                            @if($diasRestantes <= 3)
                                <span class="badge bg-warning ms-1">⏰ {{ $diasRestantes }} días restantes</span>
                            @else
                                <span class="badge bg-info ms-1">⏰ {{ $diasRestantes }} días restantes</span>
                            @endif
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($servicio->hasExpired())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            <strong>Servicio Expirado:</strong> Este servicio ha cumplido su tiempo límite y ya no está disponible.
                        </div>
                    @endif
                    
                    <div class="mb-4">
                        <h5>Descripción</h5>
                        <p>{!! nl2br(e($servicio->descripcion)) !!}</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-tag me-1"></i> Categoría
                                    </h6>
                                    <p class="card-text">{{ $servicio->categoria->nombre }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-calendar-alt me-1"></i> Tiempo de Publicación
                                    </h6>
                                    <p class="card-text">
                                        @if($servicio->duracion_dias == 0)
                                            Sin límite de tiempo
                                        @else
                                            {{ $servicio->duracion_dias }} {{ $servicio->duracion_dias == 1 ? 'día' : 'días' }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Tipo de Intercambio</h5>
                        <div class="card border-left-success shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Modalidad de Intercambio
                                        </div>
                                        <div class="h5 mb-2 font-weight-bold text-gray-800">
                                            <i class="fas fa-exchange-alt me-2"></i>{{ $servicio->tipo_intercambio }}
                                        </div>
                                        @if($servicio->descripcion_intercambio)
                                            <div class="text-sm text-gray-600">
                                                <strong>Descripción:</strong> {{ $servicio->descripcion_intercambio }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-handshake fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-calendar-plus me-1"></i> Fecha de Publicación
                                    </h6>
                                    <p class="card-text">
                                        {{ $servicio->created_at->format('d/m/Y H:i') }}
                                        <br><small class="text-muted">{{ $servicio->created_at->diffForHumans() }}</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-hourglass-half me-1"></i> Estado del Tiempo
                                    </h6>
                                    <p class="card-text">
                                        @if($servicio->hasExpired())
                                            <span class="text-danger">
                                                <i class="fas fa-times-circle me-1"></i>Expirado
                                            </span>
                                        @elseif($servicio->fecha_expiracion)
                                            @php
                                                $diasRestantes = $servicio->getDaysUntilExpiration();
                                                $horasRestantes = \Carbon\Carbon::now()->diffInHours($servicio->fecha_expiracion);
                                            @endphp
                                            @if($diasRestantes == 0)
                                                <span class="text-warning">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>{{ $horasRestantes }} horas restantes
                                                </span>
                                            @elseif($diasRestantes <= 3)
                                                <span class="text-warning">
                                                    <i class="fas fa-clock me-1"></i>{{ $diasRestantes }} días restantes
                                                </span>
                                            @else
                                                <span class="text-success">
                                                    <i class="fas fa-check-circle me-1"></i>{{ $diasRestantes }} días restantes
                                                </span>
                                            @endif
                                            <br><small class="text-muted">Expira: {{ $servicio->fecha_expiracion->format('d/m/Y H:i') }}</small>
                                        @else
                                            <span class="text-info">
                                                <i class="fas fa-infinity me-1"></i>Sin límite de tiempo
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(auth()->user()->id_usuario != $servicio->id_usuario && $servicio->disponible && !$servicio->hasExpired())
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Solicitar este Servicio de Intercambio</h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Recuerda:</strong> Este es un sistema de intercambio de tiempo por actividad. 
                            Describe claramente qué puedes ofrecer a cambio del servicio solicitado.
                        </div>
                        <form method="POST" action="{{ route('solicitudes.store') }}">
                            @csrf
                            <input type="hidden" name="id_servicio" value="{{ $servicio->id_servicio }}">
                            <input type="hidden" name="id_usuario_proveedor" value="{{ $servicio->id_usuario }}">
                            
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">¿Qué puedes ofrecer a cambio?</label>
                                <textarea class="form-control @error('mensaje') is-invalid @enderror" 
                                          id="mensaje" name="mensaje" rows="4" required 
                                          placeholder="Describe detalladamente qué actividad, servicio o tiempo puedes intercambiar...">{{ old('mensaje') }}</textarea>
                                @error('mensaje')
                                    <div class="invalid-feedback">{{ $errors->first('mensaje') }}</div>
                                @enderror
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i> Proponer Intercambio
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($servicio->hasExpired())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Este servicio ha expirado y ya no está disponible para intercambio.
                </div>
            @elseif(!$servicio->disponible)
                <div class="alert alert-warning">
                    <i class="fas fa-pause-circle me-1"></i>
                    Este servicio no está disponible actualmente.
                </div>
            @endif
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Proveedor del Servicio</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-user-circle fa-5x text-gray-300 mb-3"></i>
                        <h5>{{ $servicio->usuario->nombre }} {{ $servicio->usuario->apellidos }}</h5>
                        <p class="text-muted">{{ $servicio->usuario->profesion }}</p>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <strong><i class="fas fa-envelope me-1"></i> Email:</strong>
                        <p>{{ $servicio->usuario->email }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <strong><i class="fas fa-phone me-1"></i> Teléfono:</strong>
                        <p>{{ $servicio->usuario->telefono }}</p>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('usuarios.show', $servicio->usuario) }}" class="btn btn-primary">
                            <i class="fas fa-user me-1"></i> Ver Perfil Completo
                        </a>
                        @if(auth()->check() && auth()->user()->id_usuario != $servicio->id_usuario)
                            <a href="{{ route('mensajes.conversacion', $servicio->usuario->id_usuario) }}" class="btn btn-outline-primary">
                                <i class="fas fa-comments me-1"></i> Enviar Mensaje
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Otros Servicios del Proveedor</h6>
                </div>
                <div class="card-body">
                    @if($otrosServicios->isEmpty())
                        <p class="text-center text-muted">No hay otros servicios disponibles.</p>
                    @else
                        <div class="list-group">
                            @foreach($otrosServicios as $otroServicio)
                                <a href="{{ route('servicios.show', $otroServicio) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ Str::limit($otroServicio->titulo, 40) }}</h6>
                                        @if($otroServicio->hasExpired())
                                            <span class="badge bg-danger">Expirado</span>
                                        @elseif($otroServicio->disponible)
                                            <span class="badge bg-success">Disponible</span>
                                        @else
                                            <span class="badge bg-secondary">No disponible</span>
                                        @endif
                                    </div>
                                    <p class="mb-1">{{ Str::limit($otroServicio->descripcion, 60) }}</p>
                                    <small class="text-success">
                                        <i class="fas fa-exchange-alt me-1"></i>{{ $otroServicio->tipo_intercambio }}
                                    </small>
                                </a>
                            @endforeach
                        </div>
                        
                        @if($otrosServicios->count() >= 5)
                            <div class="text-center mt-3">
                                <a href="{{ route('servicios.index', ['usuario' => $servicio->id_usuario]) }}" class="btn btn-sm btn-outline-primary">
                                    Ver todos los servicios
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 