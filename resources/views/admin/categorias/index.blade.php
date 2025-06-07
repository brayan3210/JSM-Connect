@extends('layouts.admin')

@section('title', 'Gestión de Categorías')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-tags"></i> Gestión de Categorías
                </h1>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal">
                    <i class="fas fa-plus-circle me-1"></i> Nueva Categoría
                </button>
            </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Categorías Disponibles</h6>
            <div class="input-group w-50">
                <input type="text" id="buscarCategoria" class="form-control" placeholder="Buscar categoría...">
                <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($categorias->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5>No hay categorías registradas</h5>
                    <p class="text-muted">Agrega categorías para que los usuarios puedan clasificar sus servicios.</p>
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal">
                        <i class="fas fa-plus-circle me-1"></i> Crear Primera Categoría
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="tablaCategorias" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Servicios</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->id_categoria }}</td>
                                    <td>{{ $categoria->nombre }}</td>
                                    <td>{{ Str::limit($categoria->descripcion, 100) }}</td>
                                    <td>{{ $categoria->servicios->count() }}</td>
                                    <td>
                                        @if($categoria->activo)
                                            <span class="badge bg-success">Activa</span>
                                        @else
                                            <span class="badge bg-danger">Inactiva</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info editar-categoria" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editarCategoriaModal"
                                            data-id="{{ $categoria->id_categoria }}"
                                            data-nombre="{{ $categoria->nombre }}"
                                            data-descripcion="{{ $categoria->descripcion }}"
                                            data-activo="{{ $categoria->activo ? '1' : '0' }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($categoria->servicios->isEmpty())
                                            <button type="button" class="btn btn-sm btn-danger eliminar-categoria"
                                                data-bs-toggle="modal"
                                                data-bs-target="#eliminarCategoriaModal"
                                                data-id="{{ $categoria->id_categoria }}"
                                                data-nombre="{{ $categoria->nombre }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-secondary" disabled data-bs-toggle="tooltip" data-bs-title="No se puede eliminar: tiene servicios asociados">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                        @if($categoria->activo)
                                            <form method="POST" action="{{ route('admin.categorias.desactivar', $categoria) }}" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-title="Desactivar">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.categorias.activar', $categoria) }}" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-title="Activar">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $categorias->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Crear Categoría -->
<div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearCategoriaModalLabel">Crear Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.categorias.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" checked>
                        <label class="form-check-label" for="activo">Activa</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Categoría</button>
                </div>
            </form>
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
            <form id="formEditarCategoria" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editar_nombre" class="form-label">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="editar_nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editar_descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="editar_descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="editar_activo" name="activo" value="1">
                        <label class="form-check-label" for="editar_activo">Activa</label>
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
            <form id="formEliminarCategoria" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar la categoría <strong id="eliminar_nombre_categoria"></strong>?</p>
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
        
        // Editar categoría
        const editButtons = document.querySelectorAll('.editar-categoria');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                const descripcion = this.getAttribute('data-descripcion');
                const activo = this.getAttribute('data-activo');
                
                document.getElementById('editar_nombre').value = nombre;
                document.getElementById('editar_descripcion').value = descripcion;
                document.getElementById('editar_activo').checked = activo === '1';
                
                // Actualizar la URL del formulario
                const form = document.getElementById('formEditarCategoria');
                form.setAttribute('action', `{{ url('admin/categorias') }}/${id}`);
            });
        });
        
        // Eliminar categoría
        const deleteButtons = document.querySelectorAll('.eliminar-categoria');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                
                document.getElementById('eliminar_nombre_categoria').textContent = nombre;
                
                // Actualizar la URL del formulario
                const form = document.getElementById('formEliminarCategoria');
                form.setAttribute('action', `{{ url('admin/categorias') }}/${id}`);
            });
        });
        
        // Búsqueda en tabla
        document.getElementById('buscarCategoria').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const table = document.getElementById('tablaCategorias');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const nombre = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
                const descripcion = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
                
                if (nombre.indexOf(searchText) > -1 || descripcion.indexOf(searchText) > -1) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    });
</script>
@endsection 