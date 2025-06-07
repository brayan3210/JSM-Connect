@extends('layouts.app')

@section('title', 'Buscar Servicios')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">Buscar Servicios</h1>
            
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Filtros de Búsqueda</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('buscar') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="q" class="form-label">Buscar</label>
                                <input type="text" class="form-control" id="q" name="q" placeholder="Título o descripción" value="{{ request('q') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select class="form-select" id="categoria" name="categoria">
                                    <option value="">Todas las categorías</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}" {{ request('categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="precio_min" class="form-label">Precio mínimo</label>
                                        <input type="number" class="form-control" id="precio_min" name="precio_min" min="0" step="0.01" value="{{ request('precio_min') }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="precio_max" class="form-label">Precio máximo</label>
                                        <input type="number" class="form-control" id="precio_max" name="precio_max" min="0" step="0.01" value="{{ request('precio_max') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('buscar') }}" class="btn btn-outline-secondary me-2">Limpiar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Buscar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Resultados</h5>
                    <span class="text-muted">{{ $servicios->total() }} servicios encontrados</span>
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
                                                <small class="text-muted">
                                                    <i class="fas fa-user me-1"></i> {{ $servicio->usuario->nombre }} {{ $servicio->usuario->apellidos }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-top-0">
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('usuarios.show', $servicio->usuario) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-user me-1"></i> Ver Perfil
                                                </a>
                                                <a href="{{ route('servicios.show', $servicio) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye me-1"></i> Ver Detalles
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $servicios->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="{{ asset('images/no-results.svg') }}" alt="Sin resultados" class="img-fluid mb-3" style="max-height: 150px">
                            <h5>No se encontraron servicios</h5>
                            <p class="text-muted">Intenta con otros criterios de búsqueda</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 