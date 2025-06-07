@extends('layouts.admin')

@section('title', 'Detalles del Administrador')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-user-shield"></i> Detalles del Administrador
                </h1>
                <div>
                    <a href="{{ route('admin.administradores.edit', $administrador) }}" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-1"></i> Editar
                    </a>
                    <a href="{{ route('admin.administradores.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Volver a Lista
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Información Básica -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user me-2"></i>Información Personal
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Nombres:</label>
                                    <p class="text-muted mb-0">{{ $administrador->nombre }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Apellidos:</label>
                                    <p class="text-muted mb-0">{{ $administrador->apellidos }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Tipo de Documento:</label>
                                    <p class="text-muted mb-0">{{ $administrador->tipo_documento }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Número de Documento:</label>
                                    <p class="text-muted mb-0">{{ $administrador->numero_documento }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Género:</label>
                                    <p class="text-muted mb-0">
                                        <span class="badge bg-info">{{ $administrador->genero }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Profesión:</label>
                                    <p class="text-muted mb-0">{{ $administrador->profesion }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-envelope me-2"></i>Información de Contacto
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-envelope me-1"></i>Correo Electrónico:
                                    </label>
                                    <p class="text-muted mb-0">
                                        <a href="mailto:{{ $administrador->email }}" class="text-decoration-none">
                                            {{ $administrador->email }}
                                        </a>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-phone me-1"></i>Teléfono:
                                    </label>
                                    <p class="text-muted mb-0">
                                        <a href="tel:{{ $administrador->telefono }}" class="text-decoration-none">
                                            {{ $administrador->telefono }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas y Estado -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-chart-bar me-2"></i>Estado de la Cuenta
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                 style="width: 80px; height: 80px; font-size: 30px;">
                                {{ strtoupper(substr($administrador->nombre, 0, 1)) }}{{ strtoupper(substr($administrador->apellidos, 0, 1)) }}
                            </div>
                            
                            <h5 class="card-title">{{ $administrador->nombre }} {{ $administrador->apellidos }}</h5>
                            
                            <div class="mb-3">
                                @if($administrador->activo)
                                    <span class="badge bg-success fs-6">
                                        <i class="fas fa-check-circle me-1"></i>Cuenta Activa
                                    </span>
                                @else
                                    <span class="badge bg-danger fs-6">
                                        <i class="fas fa-times-circle me-1"></i>Cuenta Inactiva
                                    </span>
                                @endif
                            </div>

                            @if($administrador->id_usuario !== auth()->user()->id_usuario)
                                <form method="POST" action="{{ route('admin.administradores.toggle-status', $administrador) }}" class="mb-3">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="btn btn-{{ $administrador->activo ? 'warning' : 'success' }} btn-sm"
                                            onclick="return confirm('¿Estás seguro de {{ $administrador->activo ? 'desactivar' : 'activar' }} este administrador?')">
                                        <i class="fas fa-{{ $administrador->activo ? 'ban' : 'check' }} me-1"></i>
                                        {{ $administrador->activo ? 'Desactivar' : 'Activar' }} Cuenta
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-calendar me-2"></i>Fechas Importantes
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user-plus me-1"></i>Registro:
                                </label>
                                <p class="text-muted mb-0">
                                    {{ $administrador->created_at ? $administrador->created_at->format('d/m/Y H:i') : 'No disponible' }}
                                </p>
                                @if($administrador->created_at)
                                    <small class="text-muted">
                                        Hace {{ $administrador->created_at->diffForHumans() }}
                                    </small>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-edit me-1"></i>Última Actualización:
                                </label>
                                <p class="text-muted mb-0">
                                    {{ $administrador->updated_at ? $administrador->updated_at->format('d/m/Y H:i') : 'No disponible' }}
                                </p>
                                @if($administrador->updated_at)
                                    <small class="text-muted">
                                        Hace {{ $administrador->updated_at->diffForHumans() }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-cogs me-2"></i>Acciones
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.administradores.edit', $administrador) }}" class="btn btn-outline-warning">
                                    <i class="fas fa-edit me-1"></i> Editar Información
                                </a>
                                <a href="{{ route('admin.administradores.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-list me-1"></i> Ver Todos los Administradores
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .avatar {
        font-weight: bold;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .badge {
        font-size: 0.875em;
    }
    .fw-bold {
        font-weight: 600;
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
