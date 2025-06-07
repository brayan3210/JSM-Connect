@extends('layouts.app')

@section('title', $usuario->nombre . ' ' . $usuario->apellidos)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0">
                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 32px;">
                                {{ substr($usuario->nombre, 0, 1) }}{{ substr($usuario->apellidos, 0, 1) }}
                            </div>
                        </div>
                        <div class="ms-4">
                            <h2 class="mb-1">{{ $usuario->nombre }} {{ $usuario->apellidos }}</h2>
                            <p class="text-muted mb-2">{{ $usuario->profesion }}</p>
                            <p class="mb-0">
                                <i class="fas fa-user-clock me-1"></i> Miembro desde {{ $usuario->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactarModal">
                            <i class="fas fa-envelope me-1"></i> Contactar
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Especialidades -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Especialidades</h5>
                </div>
                <div class="card-body">
                    @if($usuario->especialidades->where('pivot.disponible', true)->count() > 0)
                        <div class="row">
                            @foreach($usuario->especialidades->where('pivot.disponible', true) as $especialidad)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $especialidad->nombre }}</h6>
                                            <p class="card-text small">{{ $especialidad->pivot->descripcion }}</p>
                                            <div class="d-flex justify-content-between">
                                                <span class="badge bg-info">{{ $especialidad->pivot->experiencia_anios }} años exp.</span>
                                                <span class="badge bg-primary">${{ number_format($especialidad->pivot->tarifa_hora, 2) }}/hora</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-muted">Este usuario no ha registrado especialidades disponibles.</p>
                    @endif
                </div>
            </div>
            
            <!-- Preferencias -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Preferencias e Intereses</h5>
                </div>
                <div class="card-body">
                    @if($usuario->preferencias->count() > 0)
                        <div class="row">
                            @foreach($usuario->preferencias as $preferencia)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $preferencia->hobby }}</h6>
                                            <p class="card-text small">{{ $preferencia->descripcion }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-muted">Este usuario no ha registrado preferencias o intereses.</p>
                    @endif
                </div>
            </div>
            
            <!-- Servicios -->
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Servicios Ofrecidos</h5>
                    <span class="badge bg-primary">{{ $servicios->total() }} servicios</span>
                </div>
                <div class="card-body">
                    @if($servicios->count() > 0)
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            @foreach($servicios as $servicio)
                                <div class="col">
                                    <div class="card h-100 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $servicio->titulo }}</h5>
                                            <p class="card-text text-muted small">
                                                <i class="fas fa-folder me-1"></i> {{ $servicio->categoria->nombre }}
                                            </p>
                                            <p class="card-text">{{ Str::limit($servicio->descripcion, 100) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-primary">${{ number_format($servicio->precio, 2) }}</span>
                                                @if($servicio->duracion_estimada)
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock me-1"></i> {{ $servicio->duracion_estimada }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0">
                                            <a href="{{ route('servicios.show', $servicio) }}" class="btn btn-primary w-100">
                                                <i class="fas fa-eye me-1"></i> Ver Detalles
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $servicios->links() }}
                        </div>
                    @else
                        <p class="text-center text-muted">Este usuario no tiene servicios disponibles actualmente.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Contacto -->
<div class="modal fade" id="contactarModal" tabindex="-1" aria-labelledby="contactarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactarModalLabel">Contactar a {{ $usuario->nombre }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('mensajes.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_destinatario" value="{{ $usuario->id_usuario }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="contenido" class="form-label">Mensaje</label>
                        <textarea class="form-control" id="contenido" name="contenido" rows="5" placeholder="Escribe tu mensaje..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Mensaje</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 