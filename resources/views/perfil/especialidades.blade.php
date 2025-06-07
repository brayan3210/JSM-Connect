@extends('layouts.app')

@section('title', 'Mis Especialidades')

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
            <a href="{{ route('perfil.preferencias') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-heart me-2"></i> Mis Preferencias
            </a>
            <a href="{{ route('perfil.especialidades') }}" class="list-group-item list-group-item-action active">
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
                <h5 class="card-title mb-0">Mis Especialidades</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarEspecialidadModal">
                    <i class="fas fa-plus-circle me-1"></i> Agregar Especialidad
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if($especialidades->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                        <h5>No has agregado especialidades todavía</h5>
                        <p class="text-muted">Agrega tus habilidades y especialidades para destacar entre los proveedores de servicios.</p>
                        <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#agregarEspecialidadModal">
                            <i class="fas fa-plus-circle me-1"></i> Agregar Mi Primera Especialidad
                        </button>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Categoría</th>
                                    <th>Descripción</th>
                                    <th>Años de Experiencia</th>
                                    <th>Tarifa (hora)</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($especialidades as $especialidad)
                                <tr>
                                    <td>{{ $especialidad->nombre }}</td>
                                    <td>{{ Str::limit($especialidad->pivot->descripcion, 50) }}</td>
                                    <td>{{ $especialidad->pivot->experiencia_anios }} años</td>
                                    <td>${{ $especialidad->pivot->tarifa_hora }}</td>
                                    <td>
                                        @if($especialidad->pivot->disponible)
                                            <span class="badge bg-success">Disponible</span>
                                        @else
                                            <span class="badge bg-secondary">No disponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info editar-especialidad" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editarEspecialidadModal"
                                            data-id="{{ $especialidad->id_categoria }}"
                                            data-categoria="{{ $especialidad->id_categoria }}"
                                            data-descripcion="{{ $especialidad->pivot->descripcion }}"
                                            data-experiencia="{{ $especialidad->pivot->experiencia_anios }}"
                                            data-tarifa="{{ $especialidad->pivot->tarifa_hora }}"
                                            data-disponible="{{ $especialidad->pivot->disponible ? '1' : '0' }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger eliminar-especialidad"
                                            data-bs-toggle="modal"
                                            data-bs-target="#eliminarEspecialidadModal"
                                            data-id="{{ $especialidad->id_categoria }}"
                                            data-nombre="{{ $especialidad->nombre }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">¿Por qué agregar especialidades?</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="text-center">
                            <i class="fas fa-search fa-3x text-primary mb-3"></i>
                            <h6>Mayor Visibilidad</h6>
                            <p class="small text-muted">Aumenta tus posibilidades de ser encontrado por usuarios que buscan tus servicios.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="text-center">
                            <i class="fas fa-handshake fa-3x text-primary mb-3"></i>
                            <h6>Clientes Ideales</h6>
                            <p class="small text-muted">Atrae a clientes que buscan específicamente tus habilidades y especialidades.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                            <h6>Mayor Demanda</h6>
                            <p class="small text-muted">Expande tus oportunidades de negocio al mostrar la diversidad de tus habilidades.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Agregar Especialidad -->
<div class="modal fade" id="agregarEspecialidadModal" tabindex="-1" aria-labelledby="agregarEspecialidadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarEspecialidadModalLabel">Agregar Nueva Especialidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('perfil.especialidades.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="categoria_id" class="form-label">Categoría</label>
                        <select id="categoria_id" name="categoria_id" class="form-select" required>
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción de tu especialidad</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                        <div class="form-text">Describe brevemente tu experiencia y habilidades en esta categoría.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="experiencia_anios" class="form-label">Años de Experiencia</label>
                        <input type="number" id="experiencia_anios" name="experiencia_anios" class="form-control" min="0" max="50" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tarifa_hora" class="form-label">Tarifa por Hora ($)</label>
                        <input type="number" id="tarifa_hora" name="tarifa_hora" class="form-control" min="1" step="0.01" required>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="disponible" name="disponible" value="1" checked>
                        <label class="form-check-label" for="disponible">Disponible para nuevos proyectos</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Especialidad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Especialidad -->
<div class="modal fade" id="editarEspecialidadModal" tabindex="-1" aria-labelledby="editarEspecialidadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarEspecialidadModalLabel">Editar Especialidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarEspecialidad" method="POST" action="{{ route('perfil.especialidades.update') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="editar_especialidad_id" name="especialidad_id">
                    
                    <div class="mb-3">
                        <label for="editar_categoria_id" class="form-label">Categoría</label>
                        <select id="editar_categoria_id" name="categoria_id" class="form-select" required>
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editar_descripcion" class="form-label">Descripción de tu especialidad</label>
                        <textarea id="editar_descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editar_experiencia_anios" class="form-label">Años de Experiencia</label>
                        <input type="number" id="editar_experiencia_anios" name="experiencia_anios" class="form-control" min="0" max="50" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editar_tarifa_hora" class="form-label">Tarifa por Hora ($)</label>
                        <input type="number" id="editar_tarifa_hora" name="tarifa_hora" class="form-control" min="1" step="0.01" required>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="editar_disponible" name="disponible" value="1">
                        <label class="form-check-label" for="editar_disponible">Disponible para nuevos proyectos</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar Especialidad</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Eliminar Especialidad -->
<div class="modal fade" id="eliminarEspecialidadModal" tabindex="-1" aria-labelledby="eliminarEspecialidadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarEspecialidadModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEliminarEspecialidad" method="POST" action="{{ route('perfil.especialidades.destroy', 0) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" id="eliminar_especialidad_id" name="especialidad_id">
                    <p>¿Estás seguro de que deseas eliminar la especialidad <strong id="eliminar_nombre_especialidad"></strong>?</p>
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
        // Editar especialidad
        const editButtons = document.querySelectorAll('.editar-especialidad');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const categoria = this.getAttribute('data-categoria');
                const descripcion = this.getAttribute('data-descripcion');
                const experiencia = this.getAttribute('data-experiencia');
                const tarifa = this.getAttribute('data-tarifa');
                const disponible = this.getAttribute('data-disponible');
                
                document.getElementById('editar_especialidad_id').value = id;
                document.getElementById('editar_categoria_id').value = categoria;
                document.getElementById('editar_descripcion').value = descripcion;
                document.getElementById('editar_experiencia_anios').value = experiencia;
                document.getElementById('editar_tarifa_hora').value = tarifa;
                document.getElementById('editar_disponible').checked = disponible === '1';
            });
        });
        
        // Eliminar especialidad
        const deleteButtons = document.querySelectorAll('.eliminar-especialidad');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                
                document.getElementById('eliminar_especialidad_id').value = id;
                document.getElementById('eliminar_nombre_especialidad').textContent = nombre;
                
                // Actualizar la URL del formulario
                const form = document.getElementById('formEliminarEspecialidad');
                const newUrl = "{{ route('perfil.especialidades.destroy', '') }}/" + id;
                form.setAttribute('action', newUrl);
            });
        });
    });
</script>
@endsection 