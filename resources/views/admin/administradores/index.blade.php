@extends('layouts.admin')

@section('title', 'Gestión de Usuarios Administradores')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-user-shield"></i> Gestión de Usuarios Administradores
                </h1>
                <a href="{{ route('admin.administradores.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i> Crear Administrador
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Administradores</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['total']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Activos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['activos']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Inactivos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['inactivos']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Nuevos este mes</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($estadisticas['nuevos_mes']) }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-plus fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.administradores.index') }}">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="buscar" class="form-label">Buscar</label>
                                <input type="text" class="form-control" id="buscar" name="buscar" 
                                       value="{{ request('buscar') }}" 
                                       placeholder="Nombre, email, documento...">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado">
                                    <option value="">Todos</option>
                                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                                    <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="genero" class="form-label">Género</label>
                                <select class="form-select" id="genero" name="genero">
                                    <option value="">Todos</option>
                                    <option value="Masculino" {{ request('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ request('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="Otro" {{ request('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    <option value="Prefiero no decir" {{ request('genero') == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search me-1"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('admin.administradores.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-times me-1"></i> Limpiar Filtros
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de Administradores -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>Lista de Administradores ({{ $administradores->total() }} total)
                    </h6>
                </div>
                <div class="card-body">
                    @if($administradores->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Avatar</th>
                                        <th>Información Personal</th>
                                        <th>Contacto</th>
                                        <th>Estado</th>
                                        <th>Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($administradores as $admin)
                                        <tr class="{{ !$admin->activo ? 'table-warning' : '' }}">
                                            <td class="text-center">
                                                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" 
                                                     style="width: 40px; height: 40px; font-size: 16px;">
                                                    {{ strtoupper(substr($admin->nombre, 0, 1)) }}{{ strtoupper(substr($admin->apellidos, 0, 1)) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">{{ $admin->nombre }} {{ $admin->apellidos }}</div>
                                                <small class="text-muted">{{ $admin->tipo_documento }}: {{ $admin->numero_documento }}</small><br>
                                                <small class="text-muted">{{ $admin->profesion }}</small><br>
                                                <span class="badge bg-info">{{ $admin->genero }}</span>
                                            </td>
                                            <td>
                                                <div><i class="fas fa-envelope me-1"></i> {{ $admin->email }}</div>
                                                <div><i class="fas fa-phone me-1"></i> {{ $admin->telefono }}</div>
                                            </td>
                                            <td class="text-center">
                                                @if($admin->activo)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ $admin->created_at ? $admin->created_at->format('d/m/Y') : 'N/A' }}</div>
                                                <small class="text-muted">{{ $admin->created_at ? $admin->created_at->format('H:i') : '' }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.administradores.show', $admin) }}" 
                                                       class="btn btn-info btn-sm" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.administradores.edit', $admin) }}" 
                                                       class="btn btn-warning btn-sm" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($admin->id_usuario !== auth()->user()->id_usuario)
                                                        <form method="POST" action="{{ route('admin.administradores.toggle-status', $admin) }}" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" 
                                                                    class="btn btn-{{ $admin->activo ? 'secondary' : 'success' }} btn-sm" 
                                                                    title="{{ $admin->activo ? 'Desactivar' : 'Activar' }}"
                                                                    onclick="return confirm('¿Estás seguro de {{ $admin->activo ? 'desactivar' : 'activar' }} este administrador?')">
                                                                <i class="fas fa-{{ $admin->activo ? 'ban' : 'check' }}"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <small class="text-muted">
                                    Mostrando {{ $administradores->firstItem() }} a {{ $administradores->lastItem() }} 
                                    de {{ $administradores->total() }} resultados
                                </small>
                            </div>
                            <div>
                                {{ $administradores->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No se encontraron administradores</h5>
                            <p class="text-muted">No hay administradores que coincidan con los filtros aplicados.</p>
                            <a href="{{ route('admin.administradores.create') }}" class="btn btn-primary">
                                <i class="fas fa-user-plus me-1"></i> Crear Primer Administrador
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .table-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .avatar {
        font-weight: bold;
    }
    .btn-group .btn {
        margin-right: 2px;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endsection