@extends('layouts.app')

@section('title', 'Detalles de Categoría')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Detalles de Categoría</h2>
        <div>
            <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver a Categorías
            </a>
            <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#editarCategoriaModal">
                <i class="fas fa-edit me-1"></i> Editar Categoría
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información de la Categoría</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-tag fa-5x text-primary mb-3"></i>
                        <h4>{{ $categoria->nombre }}</h4>
                        <span class="badge bg-{{ $categoria->activo ? 'success' : 'danger' }} mb-3">
                            {{ $categoria->activo ? 'Activa' : 'Inactiva' }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">Descripción:</h6>
                        <p>{{ $categoria->descripcion }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">Servicios Asociados:</h6>
                        <h3 class="font-weight-bold text-primary">{{ $categoria->servicios->count() }}</h3>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">Usuarios con esta Especialidad:</h6>
                        <h3 class="font-weight-bold text-primary">{{ $categoria->usuariosEspecialistas->count() }}</h3>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">Usuarios Interesados:</h6>
                        <h3 class="font-weight-bold text-primary">{{ $categoria->usuariosInteresados->count() }}</h3>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">Fecha de Creación:</h6>
                        <p>{{ $categoria->created_at ? $categoria->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">Última Actualización:</h6>
                        <p>{{ $categoria->updated_at ? $categoria->updated_at->format('d/m/Y H:i') : 'N/A' }}</p>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between">
                        @if($categoria->activo)
                            <form method="POST" action="{{ route('admin.categorias.desactivar', $categoria) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-ban me-1"></i> Desactivar
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('admin.categorias.activar', $categoria) }}">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check me-1"></i> Activar
                                </button>
                            </form>
                        @endif
                        
                        @if($categoria->servicios->isEmpty())
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarCategoriaModal">
                                <i class="fas fa-trash me-1"></i> Eliminar
                            </button>
                        @else
                            <button type="button" class="btn btn-secondary" disabled data-bs-toggle="tooltip" data-bs-title="No se puede eliminar: tiene servicios asociados">
                                <i class="fas fa-trash me-1"></i> Eliminar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Servicios en esta Categoría</h6>
                </div>
                <div class="card-body">
                    @if($servicios->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                            <h5>No hay servicios en esta categoría</h5>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Servicio</th>
                                        <th>Proveedor</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($servicios as $servicio)
                                        <tr>
                                            <td>{{ $servicio->titulo }}</td>
                                            <td>{{ $servicio->usuario->nombre }} {{ $servicio->usuario->apellidos }}</td>
                                            <td>${{ $servicio->precio }}</td>
                                            <td>
                                                @if($servicio->disponible)
                                                    <span class="badge bg-success">Disponible</span>
                                                @else
                                                    <span class="badge bg-danger">No disponible</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.servicios.show', $servicio) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            {{ $servicios->links() }}
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Especialistas en esta Categoría</h6>
                </div>
                <div class="card-body">
                    @if($especialistas->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5>No hay especialistas en esta categoría</h5>
                        </div>
                    @else
                        <div class="row">
                            @foreach($especialistas as $especialista)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-user-circle fa-3x text-primary"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h5 class="card-title mb-0">{{ $especialista->nombre }} {{ $especialista->apellidos }}</h5>
                                                    <p class="text-muted small mb-0">{{ $especialista->profesion }}</p>
                                                </div>
                                            </div>
                                            <p class="card-text small">
                                                <strong>Experiencia:</strong> {{ $especialista->pivot->experiencia_anios }} años<br>
                                                <strong>Tarifa:</strong> ${{ $especialista->pivot->tarifa_hora }}/hora<br>
                                                <strong>Disponibilidad:</strong> 
                                                @if($especialista->pivot->disponible)
                                                    <span class="badge bg-success">Disponible</span>
                                                @else
                                                    <span class="badge bg-secondary">No disponible</span>
                                                @endif
                                            </p>
                                            <div class="text-end mt-2">
                                                <a href="{{ route('admin.usuarios.show', $especialista) }}" class="btn btn-sm btn-outline-primary">
                                                    Ver Perfil
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-3">
                            {{ $especialistas->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Categoría -->
<div class="modal fade" id="editarCategoriaModal" tabindex="-1" aria-labelledby="editarCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarCategoriaModalLabel">Editar Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.categorias.update', $categoria) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $categoria->nombre }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3">{{ $categoria->descripcion }}</textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" {{ $categoria->activo ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">Activa</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Categoría -->
<div class="modal fade" id="eliminarCategoriaModal" tabindex="-1" aria-labelledby="eliminarCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarCategoriaModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.categorias.destroy', $categoria) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar la categoría <strong>{{ $categoria->nombre }}</strong>?</p>
                    <p class="text-danger">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    });
</script>
@endsection 