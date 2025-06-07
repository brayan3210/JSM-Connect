@extends('layouts.app')

@section('title', 'Mis Mensajes')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Mensajes</h2>
        <div>
            <a href="{{ route('mensajes.crear') }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> Nuevo Mensaje
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Conversaciones</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="filtroConversaciones" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Filtrar
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="filtroConversaciones">
                            <li><a class="dropdown-item" href="{{ route('mensajes.index') }}">Todas</a></li>
                            <li><a class="dropdown-item" href="{{ route('mensajes.index', ['filtro' => 'no_leidos']) }}">No leídos</a></li>
                            <li><a class="dropdown-item" href="{{ route('mensajes.index', ['filtro' => 'servicios']) }}">Por servicios</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="input-group border-bottom">
                        <input type="text" class="form-control border-0" id="buscarConversacion" 
                               placeholder="Buscar conversación..." aria-label="Buscar conversación">
                        <button class="btn btn-outline-secondary border-0" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    
                    <div class="list-group list-group-flush overflow-auto" style="max-height: 500px;">
                        @if($conversaciones->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-comments fa-3x text-gray-300 mb-3"></i>
                                <h5>No tienes conversaciones</h5>
                                <p class="text-muted">Comienza a enviar mensajes para ver aquí tus conversaciones.</p>
                            </div>
                        @else
                            @foreach($conversaciones as $conversacion)
                                <a href="{{ route('mensajes.conversacion', $conversacion->id_usuario) }}" 
                                   class="list-group-item list-group-item-action py-3 px-4 {{ $conversacion->id_usuario == $idUsuarioActivo ? 'active' : '' }}">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">
                                            {{ $conversacion->nombre }} {{ $conversacion->apellidos }}
                                            @if($conversacion->no_leidos > 0)
                                                <span class="badge bg-danger ms-1">{{ $conversacion->no_leidos }}</span>
                                            @endif
                                        </h6>
                                        <small>{{ $conversacion->fecha_ultimo_mensaje->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1 text-truncate">{{ $conversacion->ultimo_mensaje }}</p>
                                    @if($conversacion->id_solicitud)
                                        <small class="text-muted">
                                            <i class="fas fa-tag me-1"></i> 
                                            Solicitud: {{ Str::limit($conversacion->titulo_servicio, 25) }}
                                        </small>
                                    @endif
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    @if($usuarioDestinatario)
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="m-0 font-weight-bold text-primary">
                                    {{ $usuarioDestinatario->nombre }} {{ $usuarioDestinatario->apellidos }}
                                </h6>
                                <small class="text-muted">{{ $usuarioDestinatario->email }}</small>
                            </div>
                            <div>
                                <a href="{{ route('perfil.show', $usuarioDestinatario) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-user me-1"></i> Ver perfil
                                </a>
                                @if($solicitudAsociada)
                                    <a href="{{ route('solicitudes.show', $solicitudAsociada) }}" class="btn btn-sm btn-outline-info ms-2">
                                        <i class="fas fa-tag me-1"></i> Ver solicitud
                                    </a>
                                @endif
                            </div>
                        </div>
                    @else
                        <h6 class="m-0 font-weight-bold text-primary">Mensajes</h6>
                    @endif
                </div>
                <div class="card-body">
                    @if(!$usuarioDestinatario)
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-4x text-gray-300 mb-3"></i>
                            <h4>Selecciona una conversación</h4>
                            <p class="text-muted">Elige una conversación de la lista o inicia una nueva.</p>
                            <a href="{{ route('mensajes.crear') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-edit me-1"></i> Nuevo Mensaje
                            </a>
                        </div>
                    @else
                        <div class="chat-messages overflow-auto mb-4" id="chatMessages" style="height: 400px;">
                            @if($mensajes->isEmpty())
                                <div class="text-center py-5">
                                    <i class="fas fa-comments fa-3x text-gray-300 mb-3"></i>
                                    <h5>No hay mensajes en esta conversación</h5>
                                    <p class="text-muted">Envía un mensaje para iniciar la conversación.</p>
                                </div>
                            @else
                                @foreach($mensajes as $mensaje)
                                    <div class="chat-message mb-3 {{ $mensaje->id_remitente == auth()->id() ? 'text-end' : '' }}">
                                        <div class="d-inline-block p-3 rounded-3 
                                            {{ $mensaje->id_remitente == auth()->id() ? 'bg-primary text-white' : 'bg-light' }} 
                                            {{ $mensaje->id_remitente == auth()->id() ? 'rounded-end-0' : 'rounded-start-0' }}"
                                            style="max-width: 75%;">
                                            <div>{{ $mensaje->contenido }}</div>
                                            <div class="text-{{ $mensaje->id_remitente == auth()->id() ? 'white' : 'muted' }} mt-1" style="font-size: 0.75rem;">
                                                {{ $mensaje->fecha_envio->format('d/m/Y H:i') }}
                                                @if($mensaje->id_remitente == auth()->id())
                                                    <i class="fas fa-check-double ms-1 {{ $mensaje->leido ? 'text-info' : '' }}"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <form method="POST" action="{{ route('mensajes.enviar') }}" id="formEnviarMensaje">
                            @csrf
                            <input type="hidden" name="id_destinatario" value="{{ $usuarioDestinatario->id_usuario }}">
                            @if($solicitudAsociada)
                                <input type="hidden" name="id_solicitud" value="{{ $solicitudAsociada->id_solicitud }}">
                            @endif
                            
                            <div class="input-group">
                                <textarea class="form-control @error('contenido') is-invalid @enderror" 
                                          id="contenido" name="contenido" rows="2" placeholder="Escribe tu mensaje aquí..."
                                          required>{{ old('contenido') }}</textarea>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                                
                                @error('contenido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll al final del chat
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Filtrar conversaciones
        const inputBuscar = document.getElementById('buscarConversacion');
        if (inputBuscar) {
            inputBuscar.addEventListener('input', function() {
                const texto = this.value.toLowerCase();
                const conversaciones = document.querySelectorAll('.list-group-item');
                
                conversaciones.forEach(item => {
                    const nombre = item.querySelector('h6').textContent.toLowerCase();
                    const mensaje = item.querySelector('p').textContent.toLowerCase();
                    
                    if (nombre.includes(texto) || mensaje.includes(texto)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection 