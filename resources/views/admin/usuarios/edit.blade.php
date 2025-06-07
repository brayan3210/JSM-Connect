@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Editar Usuario</h1>
                <div>
                    <a href="{{ route('admin.usuarios.show', $usuario) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Ver Detalles
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="font-weight-bold">¡Hay errores en el formulario!</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-edit"></i> Información del Usuario
                    </h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Información Personal -->
                            <div class="col-lg-6">
                                <h5 class="mb-3 text-gray-800">
                                    <i class="fas fa-user-circle"></i> Datos Personales
                                </h5>
                                
                                <div class="form-group mb-3">
                                    <label for="nombre" class="form-label font-weight-bold">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                           id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="apellidos" class="form-label font-weight-bold">Apellidos <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('apellidos') is-invalid @enderror" 
                                           id="apellidos" name="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" required>
                                    @error('apellidos')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="tipo_documento" class="form-label font-weight-bold">Tipo de Documento <span class="text-danger">*</span></label>
                                            <select class="form-select @error('tipo_documento') is-invalid @enderror" 
                                                    id="tipo_documento" name="tipo_documento" required>
                                                <option value="Cédula de Ciudadanía" {{ old('tipo_documento', $usuario->tipo_documento) == 'Cédula de Ciudadanía' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                                <option value="Cédula de Extranjería" {{ old('tipo_documento', $usuario->tipo_documento) == 'Cédula de Extranjería' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                                <option value="Pasaporte" {{ old('tipo_documento', $usuario->tipo_documento) == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                                <option value="Tarjeta de Identidad" {{ old('tipo_documento', $usuario->tipo_documento) == 'Tarjeta de Identidad' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                                            </select>
                                            @error('tipo_documento')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="numero_documento" class="form-label font-weight-bold">Número de Documento <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('numero_documento') is-invalid @enderror" 
                                                   id="numero_documento" name="numero_documento" value="{{ old('numero_documento', $usuario->numero_documento) }}" required>
                                            @error('numero_documento')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="genero" class="form-label font-weight-bold">Género <span class="text-danger">*</span></label>
                                    <select class="form-select @error('genero') is-invalid @enderror" 
                                            id="genero" name="genero" required>
                                        <option value="Masculino" {{ old('genero', $usuario->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('genero', $usuario->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Otro" {{ old('genero', $usuario->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                        <option value="Prefiero no decir" {{ old('genero', $usuario->genero) == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                                    </select>
                                    @error('genero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="profesion" class="form-label font-weight-bold">Profesión <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('profesion') is-invalid @enderror" 
                                           id="profesion" name="profesion" value="{{ old('profesion', $usuario->profesion) }}" required>
                                    @error('profesion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Información de Contacto -->
                            <div class="col-lg-6">
                                <h5 class="mb-3 text-gray-800">
                                    <i class="fas fa-address-book"></i> Información de Contacto
                                </h5>
                                
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label font-weight-bold">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="telefono" class="form-label font-weight-bold">Teléfono <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('telefono') is-invalid @enderror" 
                                           id="telefono" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" required>
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr class="my-4">
                                
                                <h5 class="mb-3 text-gray-800">
                                    <i class="fas fa-key"></i> Cambiar Contraseña (Opcional)
                                </h5>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> 
                                    Deja estos campos vacíos si no deseas cambiar la contraseña.
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password" class="form-label font-weight-bold">Nueva Contraseña</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label font-weight-bold">Confirmar Nueva Contraseña</label>
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle"></i>
                                    Los campos marcados con <span class="text-danger">*</span> son obligatorios
                                </small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Información Adicional
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="font-weight-bold text-gray-800">Estado Actual:</label>
                                <p>
                                    @if($usuario->activo)
                                        <span class="badge badge-success badge-pill">
                                            <i class="fas fa-check-circle"></i> Activo
                                        </span>
                                    @else
                                        <span class="badge badge-danger badge-pill">
                                            <i class="fas fa-times-circle"></i> Inactivo
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="font-weight-bold text-gray-800">Tipo de Usuario:</label>
                                <p>
                                    @if($usuario->es_admin)
                                        <span class="badge badge-warning badge-pill">
                                            <i class="fas fa-user-shield"></i> Administrador
                                        </span>
                                    @else
                                        <span class="badge badge-info badge-pill">
                                            <i class="fas fa-user"></i> Usuario Regular
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="font-weight-bold text-gray-800">Fecha de Registro:</label>
                                <p class="text-gray-600">
                                    {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'No disponible' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Validación del formulario
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('password_confirmation');
        
        // Validación de contraseñas
        function validatePasswords() {
            if (passwordField.value && confirmPasswordField.value) {
                if (passwordField.value !== confirmPasswordField.value) {
                    confirmPasswordField.setCustomValidity('Las contraseñas no coinciden');
                } else {
                    confirmPasswordField.setCustomValidity('');
                }
            }
        }
        
        passwordField.addEventListener('input', validatePasswords);
        confirmPasswordField.addEventListener('input', validatePasswords);
    });
</script>
@endsection 