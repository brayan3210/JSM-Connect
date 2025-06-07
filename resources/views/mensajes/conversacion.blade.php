@extends('layouts.app')

@section('title', 'Conversación con ' . $usuario->nombre . ' ' . $usuario->apellidos)

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Mensajes</h1>
                <div>
                    <a href="{{ route('mensajes.recibidos') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>
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
                <!-- Lista de contactos -->
                <div class="col-md-4 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-header">
                            <h5 class="mb-0">Contactos</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($contactos as $contacto)
                                    <a href="{{ route('mensajes.conversacion', $contacto) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $contacto->id_usuario == $usuario->id_usuario ? 'active' : '' }}">
                                        <div>
                                            <div class="fw-bold">{{ $contacto->nombre }} {{ $contacto->apellidos }}</div>
                                            <small class="text-muted">{{ $contacto->profesion ?: 'Usuario' }}</small>
                                        </div>
                                        @if($contacto->mensajes_no_leidos > 0)
                                            <span class="badge rounded-pill bg-primary">{{ $contacto->mensajes_no_leidos }}</span>
                                        @endif
                                    </a>
                                @empty
                                    <div class="list-group-item text-center text-muted py-3">
                                        No tienes conversaciones
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Conversación actual -->
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-header bg-light">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 16px;">
                                            {{ substr($usuario->nombre, 0, 1) }}{{ substr($usuario->apellidos, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">{{ $usuario->nombre }} {{ $usuario->apellidos }}</h5>
                                        <p class="text-muted small mb-0">{{ $usuario->profesion ?: 'Usuario' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <small id="chat-status" class="text-muted me-2">Tiempo real activado</small>
                                    <div id="chat-indicator" class="spinner-border spinner-border-sm text-success d-none" role="status">
                                        <span class="visually-hidden">Actualizando...</span>
                                    </div>
                                    <button id="toggle-chat-refresh" class="btn btn-sm btn-outline-success ms-2">
                                        <i class="fas fa-sync-alt me-1"></i> <span id="chat-toggle-text">Pausar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="chat-messages-container" class="chat-messages p-3" style="height: 400px; overflow-y: auto;">
                                @foreach($mensajes as $mensaje)
                                    <div class="mb-3 d-flex {{ $mensaje->id_remitente == Auth::user()->id_usuario ? 'justify-content-end' : 'justify-content-start' }}">
                                        <div class="chat-message {{ $mensaje->id_remitente == Auth::user()->id_usuario ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 75%; border-radius: 15px; padding: 10px 15px;">
                                            <div>{{ $mensaje->contenido }}</div>
                                            <div class="text-end">
                                                <small class="{{ $mensaje->id_remitente == Auth::user()->id_usuario ? 'text-white-50' : 'text-muted' }}">
                                                    {{ $mensaje->fecha_envio->format('H:i') }}
                                                    @if($mensaje->id_remitente == Auth::user()->id_usuario)
                                                        @if($mensaje->leido)
                                                            <i class="fas fa-check-double ms-1"></i>
                                                        @else
                                                            <i class="fas fa-check ms-1"></i>
                                                        @endif
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer bg-white">
                            <form action="{{ route('mensajes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_destinatario" value="{{ $usuario->id_usuario }}">
                                <div class="input-group">
                                    <input type="text" name="contenido" class="form-control" placeholder="Escribe un mensaje..." required>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let chatRefreshInterval;
    let isChatRefreshActive = true;
    let lastMessageCount = {{ $mensajes->count() }};
    
    const chatContainer = document.getElementById('chat-messages-container');
    const chatStatus = document.getElementById('chat-status');
    const chatIndicator = document.getElementById('chat-indicator');
    const toggleButton = document.getElementById('toggle-chat-refresh');
    const toggleText = document.getElementById('chat-toggle-text');
    
    // Scroll al final
    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
    
    scrollToBottom();
    
    // Auto-refresh SOLO para actualizar mensajes (NO para enviar)
    function updateChatMessages() {
        if (!isChatRefreshActive) return;
        
        chatIndicator.classList.remove('d-none');
        
        fetch(`{{ route('mensajes.conversacion.ajax', $usuario) }}`)
        .then(response => response.json())
        .then(data => {
            if (data.messages_count !== lastMessageCount) {
                chatContainer.innerHTML = data.html;
                lastMessageCount = data.messages_count;
                scrollToBottom();
            }
            chatIndicator.classList.add('d-none');
            chatStatus.textContent = 'Última actualización: ' + new Date().toLocaleTimeString();
        })
        .catch(error => {
            console.error('Error al actualizar chat:', error);
            chatIndicator.classList.add('d-none');
        });
    }
    
    // Toggle auto-refresh
    function toggleChatRefresh() {
        isChatRefreshActive = !isChatRefreshActive;
        
        if (isChatRefreshActive) {
            toggleText.textContent = 'Pausar';
            chatStatus.textContent = 'Tiempo real activado';
            toggleButton.classList.remove('btn-outline-secondary');
            toggleButton.classList.add('btn-outline-success');
            startChatRefresh();
        } else {
            toggleText.textContent = 'Activar';
            chatStatus.textContent = 'Tiempo real pausado';
            toggleButton.classList.remove('btn-outline-success');
            toggleButton.classList.add('btn-outline-secondary');
            if (chatRefreshInterval) {
                clearInterval(chatRefreshInterval);
            }
        }
    }
    
    function startChatRefresh() {
        if (chatRefreshInterval) {
            clearInterval(chatRefreshInterval);
        }
        chatRefreshInterval = setInterval(updateChatMessages, 2000);
    }
    
    // Event listener
    toggleButton.addEventListener('click', toggleChatRefresh);
    
    // Iniciar auto-refresh
    if (isChatRefreshActive) {
        startChatRefresh();
    }
    
    // Pausar cuando no visible
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (chatRefreshInterval) {
                clearInterval(chatRefreshInterval);
            }
        } else {
            if (isChatRefreshActive) {
                startChatRefresh();
            }
        }
    });
    
    // Limpiar al salir
    window.addEventListener('beforeunload', function() {
        if (chatRefreshInterval) {
            clearInterval(chatRefreshInterval);
        }
    });
});
</script>

<style>
#chat-indicator {
    width: 1rem;
    height: 1rem;
}

#chat-status {
    font-size: 0.875rem;
    min-width: 120px;
    text-align: right;
}

.chat-message {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.chat-messages::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}
</style>
@endsection 