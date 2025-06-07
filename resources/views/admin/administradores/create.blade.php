@extends('layouts.admin')

@section('title', 'Crear Usuario Administrador')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0" style="color: #104CFF;">
                    <i class="fas fa-user-plus me-2"></i> Crear Usuario Administrador
                </h1>
                <a href="{{ route('admin.administradores.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver a Lista
                </a>
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

            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="card shadow-lg border-0">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, #104CFF 0%, #0056b3 100%); color: white;">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="fas fa-user-shield me-2"></i>Información del Administrador
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('admin.administradores.store') }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre" class="form-label fw-bold">Nombre *</label>
                                        <input type="text" class="form-control custom-input @error('nombre') is-invalid @enderror" 
                                               id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                        @error('nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="apellidos" class="form-label fw-bold">Apellidos *</label>
                                        <input type="text" class="form-control custom-input @error('apellidos') is-invalid @enderror" 
                                               id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required>
                                        @error('apellidos')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_documento" class="form-label fw-bold">Tipo de Documento *</label>
                                        <select class="form-select custom-select @error('tipo_documento') is-invalid @enderror" 
                                                id="tipo_documento" name="tipo_documento" required>
                                            <option value="">Selecciona...</option>
                                            <option value="Cédula" {{ old('tipo_documento') == 'Cédula' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                            <option value="Tarjeta de Identidad" {{ old('tipo_documento') == 'Tarjeta de Identidad' ? 'selected' : '' }}>Tarjeta de Identidad</option>
                                            <option value="Cédula de Extranjería" {{ old('tipo_documento') == 'Cédula de Extranjería' ? 'selected' : '' }}>Cédula de Extranjería</option>
                                            <option value="Pasaporte" {{ old('tipo_documento') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                        </select>
                                        @error('tipo_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="numero_documento" class="form-label fw-bold">Número de Documento *</label>
                                        <input type="text" class="form-control custom-input @error('numero_documento') is-invalid @enderror" 
                                               id="numero_documento" name="numero_documento" value="{{ old('numero_documento') }}" required>
                                        @error('numero_documento')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="genero" class="form-label fw-bold">Género *</label>
                                        <select class="form-select custom-select @error('genero') is-invalid @enderror" 
                                                id="genero" name="genero" required>
                                            <option value="">Selecciona...</option>
                                            <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                            <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                            <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                            <option value="Prefiero no decir" {{ old('genero') == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                                        </select>
                                        @error('genero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="profesion" class="form-label fw-bold">Profesión *</label>
                                        <input type="text" class="form-control custom-input @error('profesion') is-invalid @enderror" 
                                               id="profesion" name="profesion" value="{{ old('profesion') }}" required
                                               placeholder="Ej: Administrador de Sistemas, Contador, etc.">
                                        @error('profesion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label fw-bold">Correo Electrónico *</label>
                                        <input type="email" class="form-control custom-input @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telefono" class="form-label fw-bold">Teléfono *</label>
                                        <input type="text" class="form-control custom-input @error('telefono') is-invalid @enderror" 
                                               id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                                        @error('telefono')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <hr class="my-4" style="border-color: #104CFF;">
                                <h6 class="mb-3" style="color: #104CFF;">
                                    <i class="fas fa-key me-2"></i>Configuración de Acceso
                                </h6>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label fw-bold">Contraseña *</label>
                                        <input type="password" class="form-control custom-input @error('password') is-invalid @enderror" 
                                               id="password" name="password" required>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">
                                            <small class="text-muted">Mínimo 8 caracteres, debe incluir letras mayúsculas, minúsculas y números.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label fw-bold">Confirmar Contraseña *</label>
                                        <input type="password" class="form-control custom-input" 
                                               id="password_confirmation" name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input custom-check @error('activo') is-invalid @enderror" 
                                               type="checkbox" id="activo" name="activo" value="1" 
                                               {{ old('activo', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="activo">
                                            Cuenta activa
                                            <br><small class="text-muted">El administrador podrá acceder al sistema inmediatamente</small>
                                        </label>
                                        @error('activo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="alert alert-warning border-warning">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-triangle fa-2x me-3" style="color: #856404;"></i>
                                        </div>
                                        <div>
                                            <h6 class="alert-heading">¡Importante!</h6>
                                            <p class="mb-0">Estás creando una cuenta de <strong>administrador</strong> con acceso completo al sistema. 
                                            Asegúrate de que la información sea correcta y que la persona tenga autorización para acceder 
                                            a las funciones administrativas.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('admin.administradores.index') }}" class="btn btn-light me-md-2 border">
                                        <i class="fas fa-times me-1"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary custom-btn">
                                        <i class="fas fa-save me-1"></i> Crear Administrador
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
    .custom-input, .custom-select {
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .custom-input:focus, .custom-select:focus {
        border-color: #104CFF;
        box-shadow: 0 0 0 0.2rem rgba(16, 76, 255, 0.25);
        outline: none;
    }
    
    .custom-btn {
        background: linear-gradient(135deg, #104CFF 0%, #0056b3 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 76, 255, 0.3);
    }
    
    .custom-btn:hover {
        background: linear-gradient(135deg, #0056b3 0%, #104CFF 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 76, 255, 0.4);
    }
    
    .custom-check:checked {
        background-color: #104CFF;
        border-color: #104CFF;
    }
    
    .custom-check:focus {
        box-shadow: 0 0 0 0.2rem rgba(16, 76, 255, 0.25);
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .form-label {
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .alert-warning {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
    }
    
    .btn-light {
        border: 2px solid #e3e6f0;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-light:hover {
        border-color: #104CFF;
        color: #104CFF;
        transform: translateY(-1px);
    }
    
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
        // Add animation class to form
        const form = document.querySelector('.card');
        if (form) {
            form.classList.add('animate-fade-in');
        }
        
        // Form validation feedback
        const inputs = document.querySelectorAll('.custom-input, .custom-select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() !== '') {
                    this.style.borderColor = '#28a745';
                } else if (this.hasAttribute('required')) {
                    this.style.borderColor = '#dc3545';
                }
            });
        });
        
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        
        if (passwordInput && confirmPasswordInput) {
            confirmPasswordInput.addEventListener('input', function() {
                if (this.value !== passwordInput.value) {
                    this.style.borderColor = '#dc3545';
                } else {
                    this.style.borderColor = '#28a745';
                }
            });
        }
});
</script>
@endsection
