@extends('layouts.app')

@section('title', 'Mis Preferencias')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ $usuario->nombre }} {{ $usuario->apellidos }}</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-7x text-primary"></i>
                </div>
                <h6 class="card-subtitle mb-2 text-muted">{{ $usuario->profesion }}</h6>
                <p class="card-text"><i class="fas fa-phone me-2"></i> {{ $usuario->telefono }}</p>
                <p class="card-text"><i class="fas fa-envelope me-2"></i> {{ $usuario->email }}</p>
            </div>
        </div>
        
        <div class="list-group mt-4 shadow">
            <a href="{{ route('perfil.show') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-user me-2"></i> Mi Perfil
            </a>
            <a href="{{ route('perfil.edit') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-edit me-2"></i> Editar Información
            </a>
            <a href="{{ route('perfil.preferencias') }}" class="list-group-item list-group-item-action active">
                <i class="fas fa-heart me-2"></i> Mis Preferencias
            </a>
            <a href="{{ route('perfil.especialidades') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-star me-2"></i> Mis Especialidades
            </a>
            <a href="{{ route('perfil.descargar') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-download me-2"></i> Descargar Mis Datos
            </a>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Mis Preferencias</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarPreferenciaModal">
                    <i class="fas fa-plus-circle me-1"></i> Agregar Preferencia
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                    <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i> ¿Por qué configurar tus preferencias?</h5>
                    <p class="mb-0">Tus preferencias nos ayudan a mostrarte servicios que podrían interesarte y a conectarte con usuarios con intereses similares, mejorando tu experiencia en la plataforma.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                
                @if($preferencias->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                        <h5>No has agregado preferencias todavía</h5>
                        <p class="text-muted">Agregar tus preferencias e intereses ayuda a personalizar tu experiencia en la plataforma.</p>
                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#agregarPreferenciaModal">
                            <i class="fas fa-plus-circle me-1"></i> Agregar Mi Primera Preferencia
                        </button>
                    </div>
                @else
                    <div class="row">
                        @foreach($preferencias as $preferencia)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="card-title mb-0">{{ $preferencia->hobby }}</h5>
                                            <div>
                                                <button type="button" class="btn btn-sm btn-info editar-preferencia me-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#editarPreferenciaModal"
                                                    data-id="{{ $preferencia->id }}"
                                                    data-hobby="{{ $preferencia->hobby }}"
                                                    data-descripcion="{{ $preferencia->descripcion }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger eliminar-preferencia" 
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#eliminarPreferenciaModal"
                                                    data-id="{{ $preferencia->id }}"
                                                    data-hobby="{{ $preferencia->hobby }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <p class="card-text">{{ $preferencia->descripcion }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">Categorías Recomendadas Según Tus Preferencias</h5>
            </div>
            <div class="card-body">
                @if($categoriasRecomendadas->isEmpty())
                    <p class="text-center text-muted">Agrega preferencias para recibir recomendaciones personalizadas de categorías.</p>
                @else
                    <div class="row">
                        @foreach($categoriasRecomendadas as $categoria)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body text-center">
                                        <i class="fas fa-tag fa-2x text-primary mb-3"></i>
                                        <h6 class="card-title">{{ $categoria->nombre }}</h6>
                                        <p class="card-text small">{{ $categoria->descripcion }}</p>
                                        <a href="{{ route('buscar', ['categoria' => $categoria->id]) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-search me-1"></i> Explorar Servicios
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Preferencia -->
<div class="modal fade" id="agregarPreferenciaModal" tabindex="-1" aria-labelledby="agregarPreferenciaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarPreferenciaModalLabel">Agregar Nueva Preferencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('perfil.preferencias.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="hobby" class="form-label">Hobby o Interés</label>
                        <input type="text" id="hobby" name="hobby" class="form-control" required>
                        <div class="form-text">Ej: Deportes, Música, Arte, Tecnología, etc.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Describe este interés</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                        <div class="form-text">Explica más sobre este hobby o interés y por qué te gusta.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Preferencia</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Preferencia -->
<div class="modal fade" id="editarPreferenciaModal" tabindex="-1" aria-labelledby="editarPreferenciaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarPreferenciaModalLabel">Editar Preferencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarPreferencia" method="POST" action="{{ route('perfil.preferencias.update', 0) }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editar_preferencia_id" name="preferencia_id">
                    
                    <div class="mb-3">
                        <label for="editar_hobby" class="form-label">Hobby o Interés</label>
                        <input type="text" id="editar_hobby" name="hobby" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editar_descripcion" class="form-label">Describe este interés</label>
                        <textarea id="editar_descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Preferencia</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Preferencia -->
<div class="modal fade" id="eliminarPreferenciaModal" tabindex="-1" aria-labelledby="eliminarPreferenciaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarPreferenciaModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminarPreferencia" method="POST" action="{{ route('perfil.preferencias.destroy', 0) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" id="eliminar_preferencia_id" name="preferencia_id">
                    <p>¿Estás seguro de que deseas eliminar la preferencia <strong id="eliminar_nombre_preferencia"></strong>?</p>
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
        // Editar preferencia
        const editButtons = document.querySelectorAll('.editar-preferencia');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const hobby = this.getAttribute('data-hobby');
                const descripcion = this.getAttribute('data-descripcion');
                
                document.getElementById('editar_preferencia_id').value = id;
                document.getElementById('editar_hobby').value = hobby;
                document.getElementById('editar_descripcion').value = descripcion;
                
                // Actualizar la URL del formulario
                const form = document.getElementById('formEditarPreferencia');
                const baseUrl = "{{ route('perfil.preferencias.update', 0) }}";
                const newUrl = baseUrl.replace('/0', '/' + id);
                form.setAttribute('action', newUrl);
            });
        });
        
        // Eliminar preferencia
        const deleteButtons = document.querySelectorAll('.eliminar-preferencia');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const hobby = this.getAttribute('data-hobby');
                
                document.getElementById('eliminar_preferencia_id').value = id;
                document.getElementById('eliminar_nombre_preferencia').textContent = hobby;
                
                // Actualizar la URL del formulario
                const form = document.getElementById('formEliminarPreferencia');
                const baseUrl = "{{ route('perfil.preferencias.destroy', 0) }}";
                const newUrl = baseUrl.replace('/0', '/' + id);
                form.setAttribute('action', newUrl);
            });
        });
    });
</script>
@endsection 