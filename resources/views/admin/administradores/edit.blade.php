@extends('layouts.admin')

@section('title', 'Editar Administrador')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fas fa-user-edit"></i> Editar Administrador
                </h1>
                <div>
                    <a href="{{ route('admin.administradores.show', $administrador) }}" class="btn btn-info me-2">
                        <i class="fas fa-eye me-1"></i> Ver Detalles
                    </a>
                    <a href="{{ route('admin.administradores.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Volver a Lista
                    </a>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>¡Error!</strong> Por favor corrige los siguientes problemas:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fas fa-user-shield me-2"></i>Editar Información del Administrador
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.administradores.update', $administrador) }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label">Nombre *</label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                               id="nombre" name="nombre" value="{{ old('nombre', $administrador->nombre) }}" required>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label">Apellidos *</label>
                                        <input type="text" class="form-control @error('apellidos') is-invalid @enderror" 
                                               id="apellidos" name="apellidos" value="{{ old('apellidos', $administrador->apellidos) }}" required>
                                        @error('apellidos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_documento" class="form-label">Tipo de Documento *</label>
                                        <select class="form-select @error('tipo_documento') is-invalid @enderror" 
                                                id="tipo_documento" name="tipo_documento" required>
                                            <option value="">Selecciona...</option>
                                            <option value="Cédula" {{ old('tipo_documento', $administrador->tipo_documento) == 'Cédula' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                            <option value="Tarjeta de Identidad" {{ old('tipo_documento', $administrador->tipo_documento) == 'Tarjeta de Identidad' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                                            <option value="Cédula de Extranjería" {{ old('tipo_documento', $administrador->tipo_documento) == 'Cédula de Extranjería' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                            <option value="Pasaporte" {{ old('tipo_documento', $administrador->tipo_documento) == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                        </select>
                                        @error('tipo_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="numero_documento" class="form-label">Número de Documento *</label>
                                        <input type="text" class="form-control @error('numero_documento') is-invalid @enderror" 
                                               id="numero_documento" name="numero_documento" value="{{ old('numero_documento', $administrador->numero_documento) }}" required>
                                        @error('numero_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="genero" class="form-label">Género *</label>
                                        <select class="form-select @error('genero') is-invalid @enderror" 
                                                id="genero" name="genero" required>
                                            <option value="">Selecciona...</option>
                                            <option value="Masculino" {{ old('genero', $administrador->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                            <option value="Femenino" {{ old('genero', $administrador->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                            <option value="Otro" {{ old('genero', $administrador->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                            <option value="Prefiero no decir" {{ old('genero', $administrador->genero) == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                                        </select>
                                        @error('genero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="profesion" class="form-label">Profesión *</label>
                                        <input type="text" class="form-control @error('profesion') is-invalid @enderror" 
                                               id="profesion" name="profesion" value="{{ old('profesion', $administrador->profesion) }}" required
                                               placeholder="Ej: Administrador de Sistemas, Contador, etc.">
                                        @error('profesion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Correo Electrónico *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $administrador->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label">Teléfono *</label>
                                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" 
                                               id="telefono" name="telefono" value="{{ old('telefono', $administrador->telefono) }}" required>
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-key me-2"></i>Cambiar Contraseña (Opcional)
                                </h6>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Deja estos campos vacíos si no deseas cambiar la contraseña actual.
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Nueva Contraseña</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <small>Mínimo 8 caracteres, debe incluir letras mayúsculas, minúsculas y números.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation">
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-toggle-on me-2"></i>Estado de la Cuenta
                                </h6>

                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input @error('activo') is-invalid @enderror" 
                                               type="checkbox" id="activo" name="activo" value="1" 
                                               {{ old('activo', $administrador->activo) == '1' ? 'checked' : '' }}
                                               @if($administrador->id_usuario === auth()->user()->id_usuario) disabled @endif>
                                        <label class="form-check-label" for="activo">
                                            <strong>Cuenta activa</strong>
                                            <br><small class="text-muted">El administrador podrá acceder al sistema</small>
                                            @if($administrador->id_usuario === auth()->user()->id_usuario)
                                                <br><small class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>No puedes cambiar tu propio estado</small>
                                            @endif
                                        </label>
                                        @error('activo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="alert alert-warning">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                                        </div>
                                        <div>
                                            <h6 class="alert-heading">¡Atención!</h6>
                                            <p class="mb-0">Estás modificando la información de un <strong>administrador</strong> del sistema. 
                                            Asegúrate de que los cambios sean correctos antes de guardar.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('admin.administradores.show', $administrador) }}" class="btn btn-light me-md-2">
                                        <i class="fas fa-times me-1"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Guardar Cambios
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

@section('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #104CFF;
        box-shadow: 0 0 0 0.2rem rgba(16, 76, 255, 0.25);
    }
    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeaa7;
    }
    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
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

    // Password validation
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    
    function validatePasswordMatch() {
        if (passwordField.value !== confirmPasswordField.value) {
            confirmPasswordField.setCustomValidity('Las contraseñas no coinciden');
        } else {
            confirmPasswordField.setCustomValidity('');
        }
    }
    
    passwordField.addEventListener('change', validatePasswordMatch);
    confirmPasswordField.addEventListener('keyup', validatePasswordMatch);
});
</script>
@endsection
