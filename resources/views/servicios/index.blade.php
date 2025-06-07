@extends('layouts.app')

@section('title', 'Servicios de Intercambio Disponibles')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Servicios de Intercambio Disponibles</h2>
        <a href="{{ route('servicios.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Nuevo Servicio de Intercambio
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('servicios.index') }}" method="GET" id="filtroForm">
                        <div class="mb-3">
                            <label for="buscar" class="form-label">Buscar</label>
                            <input type="text" class="form-control" id="buscar" name="buscar" 
                                   value="{{ request('buscar') }}" placeholder="Título, descripción...">
                        </div>
                        
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-select" id="categoria" name="categoria">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}" 
                                            {{ request('categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tiempo_restante" class="form-label">Tiempo restante</label>
                            <select class="form-select" id="tiempo_restante" name="tiempo_restante">
                                <option value="">Cualquier tiempo</option>
                                <option value="urgente" {{ request('tiempo_restante') == 'urgente' ? 'selected' : '' }}>
                                    Urgente (menos de 3 días)
                                </option>
                                <option value="pronto" {{ request('tiempo_restante') == 'pronto' ? 'selected' : '' }}>
                                    Próximo a expirar (menos de 7 días)
                                </option>
                                <option value="tiempo" {{ request('tiempo_restante') == 'tiempo' ? 'selected' : '' }}>
                                    Con tiempo (más de 7 días)
                                </option>
                                <option value="sin_limite" {{ request('tiempo_restante') == 'sin_limite' ? 'selected' : '' }}>
                                    Sin límite de tiempo
                                </option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="solo_disponibles" 
                                       name="disponible" value="1" {{ request('disponible') ? 'checked' : '' }}>
                                <label class="form-check-label" for="solo_disponibles">
                                    Solo disponibles
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="excluir_expirados" 
                                       name="excluir_expirados" value="1" {{ request('excluir_expirados', '1') ? 'checked' : '' }}>
                                <label class="form-check-label" for="excluir_expirados">
                                    Excluir expirados
                                </label>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                            <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Limpiar Filtros</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($servicios->isEmpty())
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search fa-3x text-gray-300 mb-3"></i>
                        <h4>No se encontraron servicios de intercambio</h4>
                        <p class="text-muted">Prueba a cambiar los filtros de búsqueda o crea un nuevo servicio de intercambio.</p>
                        <a href="{{ route('servicios.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus-circle me-1"></i> Crear Servicio de Intercambio
                        </a>
                    </div>
                </div>
            @else
                <div class="row">
                    @foreach($servicios as $servicio)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow h-100 {{ $servicio->hasExpired() ? 'border-danger' : '' }}">
                                <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-start">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        {{ Str::limit($servicio->titulo, 40) }}
                                    </h6>
                                    <div class="text-end">
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
                                            <br>
                                            @if($diasRestantes <= 1)
                                                <span class="badge bg-danger mt-1">⏰ {{ $diasRestantes }} día</span>
                                            @elseif($diasRestantes <= 3)
                                                <span class="badge bg-warning mt-1">⏰ {{ $diasRestantes }} días</span>
                                            @else
                                                <span class="badge bg-info mt-1">⏰ {{ $diasRestantes }} días</span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="small text-muted mb-2">
                                        <i class="fas fa-tag me-1"></i> {{ $servicio->categoria->nombre }}
                                    </p>
                                    <p class="small mb-3">{{ Str::limit($servicio->descripcion, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge bg-success">
                                                <i class="fas fa-exchange-alt me-1"></i> Intercambio
                                            </span>
                                            <p class="small text-muted mb-0 mt-1">
                                                <i class="fas fa-clock me-1"></i> {{ $servicio->duracion_estimada ?? 'No especificada' }}
                                            </p>
                                        </div>
                                        <div>
                                            <a href="{{ route('servicios.show', $servicio) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($servicio->id_usuario == auth()->user()->id_usuario)
                                                <a href="{{ route('servicios.edit', $servicio) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i> Por: 
                                            <a href="{{ route('usuarios.show', $servicio->usuario) }}">
                                                {{ $servicio->usuario->nombre }} {{ $servicio->usuario->apellidos }}
                                            </a>
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-plus me-1"></i> {{ $servicio->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $servicios->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
// Auto-ejecutar comando de limpieza cada 5 minutos (opcional, para demo)
setInterval(function() {
    fetch('/admin/services/clean-expired', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    }).catch(error => console.log('Limpieza automática:', error));
}, 300000); // 5 minutos
</script>
@endsection 