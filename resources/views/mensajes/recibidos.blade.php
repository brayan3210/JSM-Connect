@extends('layouts.app')

@section('title', 'Mensajes Recibidos')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Mensajes Recibidos</h1>
                <div>
                    <a href="{{ route('mensajes.enviados') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-paper-plane me-1"></i> Enviados
                    </a>
                </div>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Bandeja de entrada</h5>
                    <div class="d-flex align-items-center">
                        <small id="refresh-status" class="text-muted me-2">Tiempo real activado</small>
                        <div id="refresh-indicator" class="spinner-border spinner-border-sm text-success d-none" role="status">
                            <span class="visually-hidden">Actualizando...</span>
                        </div>
                        <button id="toggle-auto-refresh" class="btn btn-sm btn-outline-success ms-2">
                            <i class="fas fa-sync-alt me-1"></i> <span id="toggle-text">Pausar</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="mensajes-container">
                        @if($mensajes->count() > 0)
                            <div class="list-group" id="mensajes-list">
                                @foreach($mensajes as $mensaje)
                                    <a href="{{ route('mensajes.conversacion', $mensaje->remitente) }}" class="list-group-item list-group-item-action {{ !$mensaje->leido ? 'fw-bold' : '' }}">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $mensaje->remitente->nombre }} {{ $mensaje->remitente->apellidos }}</h6>
                                            <small>{{ $mensaje->fecha_envio->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-1">{{ Str::limit($mensaje->contenido, 100) }}</p>
                                        @if(!$mensaje->leido)
                                            <span class="badge bg-primary">Nuevo</span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                            
                            <div class="d-flex justify-content-center mt-4" id="pagination-container">
                                {{ $mensajes->links() }}
                            </div>
                        @else
                            <div class="text-center py-4">
                                <img src="{{ asset('images/empty-inbox.svg') }}" alt="No hay mensajes" class="img-fluid mb-3" style="max-height: 150px;">
                                <h5>No tienes mensajes recibidos</h5>
                                <p class="text-muted">Cuando recibas mensajes, aparecerán aquí.</p>
                            </div>
                        @endif
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
    let autoRefreshInterval;
    let isAutoRefreshActive = true;
    let currentPage = {{ $mensajes->currentPage() }};
    
    const refreshStatus = document.getElementById('refresh-status');
    const refreshIndicator = document.getElementById('refresh-indicator');
    const toggleButton = document.getElementById('toggle-auto-refresh');
    const toggleText = document.getElementById('toggle-text');
    const mensajesContainer = document.getElementById('mensajes-container');
    
    // Función para actualizar mensajes
    function updateMensajes() {
        if (!isAutoRefreshActive) return;
        
        // Mostrar indicador de carga
        refreshIndicator.classList.remove('d-none');
        refreshStatus.textContent = 'Actualizando...';
        
        // Realizar petición AJAX
        fetch(`{{ route('mensajes.recibidos.ajax') }}?page=${currentPage}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            // Actualizar el contenido
            mensajesContainer.innerHTML = data.html;
            
            // Reattach event listeners para paginación si hay mensajes
            if (data.has_messages) {
                attachPaginationListeners();
            }
            
            // Actualizar contador en navbar si existe
            updateNavbarBadge(data.unread_count);
            
            // Ocultar indicador y actualizar status
            refreshIndicator.classList.add('d-none');
            refreshStatus.textContent = 'Última actualización: ' + new Date().toLocaleTimeString();
            
            // Efecto visual sutil para mostrar que se actualizó
            mensajesContainer.style.opacity = '0.8';
            setTimeout(() => {
                mensajesContainer.style.opacity = '1';
            }, 200);
        })
        .catch(error => {
            console.error('Error al actualizar mensajes:', error);
            refreshIndicator.classList.add('d-none');
            refreshStatus.textContent = 'Error en la actualización';
        });
    }
    
    // Función para actualizar badge en navbar
    function updateNavbarBadge(unreadCount) {
        const navbarBadge = document.querySelector('.nav-link .badge');
        if (navbarBadge) {
            if (unreadCount > 0) {
                navbarBadge.textContent = unreadCount;
                navbarBadge.style.display = '';
            } else {
                navbarBadge.style.display = 'none';
            }
        }
    }
    
    // Función para manejar clics en paginación
    function attachPaginationListeners() {
        const paginationLinks = document.querySelectorAll('#pagination-container a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = new URL(this.href);
                const page = url.searchParams.get('page');
                if (page) {
                    currentPage = parseInt(page);
                    updateMensajes();
                }
            });
        });
    }
    
    // Función para toggle del auto-refresh
    function toggleAutoRefresh() {
        isAutoRefreshActive = !isAutoRefreshActive;
        
        if (isAutoRefreshActive) {
            // Activar auto-refresh
            toggleText.textContent = 'Pausar';
            refreshStatus.textContent = 'Tiempo real activado';
            toggleButton.classList.remove('btn-outline-secondary');
            toggleButton.classList.add('btn-outline-success');
            
            // Iniciar interval
            startAutoRefresh();
        } else {
            // Pausar auto-refresh
            toggleText.textContent = 'Activar';
            refreshStatus.textContent = 'Tiempo real pausado';
            toggleButton.classList.remove('btn-outline-success');
            toggleButton.classList.add('btn-outline-secondary');
            
            // Limpiar interval
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
            }
        }
    }
    
    // Función para iniciar auto-refresh
    function startAutoRefresh() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
        
        // Actualizar cada 2 segundos para tiempo real
        autoRefreshInterval = setInterval(updateMensajes, 2000);
    }
    
    // Event listeners
    toggleButton.addEventListener('click', toggleAutoRefresh);
    
    // Attach inicial de listeners de paginación
    attachPaginationListeners();
    
    // Iniciar auto-refresh
    if (isAutoRefreshActive) {
        startAutoRefresh();
    }
    
    // Pausar auto-refresh cuando la página no está visible
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            if (autoRefreshInterval) {
                clearInterval(autoRefreshInterval);
            }
        } else {
            if (isAutoRefreshActive) {
                startAutoRefresh();
            }
        }
    });
    
    // Limpiar interval al salir de la página
    window.addEventListener('beforeunload', function() {
        if (autoRefreshInterval) {
            clearInterval(autoRefreshInterval);
        }
    });
    
    // Actualización manual al hacer doble-click en el botón de sync
    toggleButton.addEventListener('dblclick', function() {
        if (isAutoRefreshActive) {
            updateMensajes();
        }
    });
});
</script>

<style>
/* Transición suave para el contenedor de mensajes */
#mensajes-container {
    transition: opacity 0.3s ease-in-out;
}

/* Estilo para el indicador de refresh */
#refresh-indicator {
    width: 1rem;
    height: 1rem;
}

/* Hover effect para el botón de toggle */
#toggle-auto-refresh:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}

/* Estilo para status text */
#refresh-status {
    font-size: 0.875rem;
    min-width: 150px;
    text-align: right;
}

/* Animación para mensajes nuevos */
.list-group-item.fw-bold {
    background-color: #f8f9ff;
    border-left: 4px solid #0d6efd;
}

.badge {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}
</style>
@endsection 