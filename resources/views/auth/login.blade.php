@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('styles')
<style>
    /* Animaciones para login */
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    /* Contenedor principal */
    .login-container {
        animation: slideInDown 0.8s ease-out;
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }

    /* Estilos de la tarjeta */
    .card {
        animation: fadeInScale 0.8s ease-out 0.3s both;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-radius: 1rem;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        padding: 2rem 1.5rem;
        border: none;
    }

    .card-body {
        padding: 2.5rem;
    }

    .card-footer {
        background: #f8fafc;
        border: none;
        padding: 1.5rem;
    }

    /* Estilos de formulario */
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: #374151;
        font-size: 0.95rem;
    }

    .form-label i {
        color: #6b7280;
        margin-right: 0.5rem;
    }

    .input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 3rem 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fff;
    }

    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        transform: translateY(-1px);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        padding-right: 3rem;
    }

    .form-control.is-invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    /* Iconos */
    .input-icon {
        position: absolute;
        right: 1rem;
        color: #9ca3af;
        transition: all 0.3s ease;
        cursor: pointer;
        z-index: 10;
    }

    .form-control:focus ~ .input-icon {
        color: #4f46e5;
        transform: scale(1.1);
    }

    .form-control.is-invalid ~ .input-icon {
        color: #ef4444;
    }

    /* Checkbox personalizado */
    .form-check {
        margin: 1.5rem 0;
    }

    .form-check-input {
        margin-top: 0.25rem;
    }

    .form-check-input:checked {
        background-color: #4f46e5;
        border-color: #4f46e5;
    }

    .form-check-label {
        margin-left: 0.5rem;
        color: #6b7280;
        font-size: 0.95rem;
    }

    /* Botones */
    .btn {
        transition: all 0.3s ease;
        font-weight: 600;
        padding: 0.875rem 2rem;
        border-radius: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        border: none;
        color: white;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    .btn-primary:disabled {
        background: #9ca3af;
        transform: none;
        box-shadow: none;
    }

    .btn-link {
        color: #4f46e5;
        font-weight: 500;
    }

    .btn-link:hover {
        color: #4338ca;
        text-decoration: none !important;
    }

    /* Mensajes de error */
    .invalid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #ef4444;
    }

    /* Animación de error */
    .error-shake {
        animation: shake 0.6s ease-in-out;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .login-container {
            padding: 1rem 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-header {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')

@php
    // Registrar visita para la página de login
    \App\Models\Visit::registrarVisita(request(), '/login');
@endphp

<div class="container-fluid">
    <div class="row justify-content-center login-container">
        <div class="col-11 col-sm-10 col-md-9 col-lg-7 col-xl-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h4 class="mb-2">
                        <i class="fas fa-sign-in-alt me-2" aria-hidden="true"></i>
                        Iniciar Sesión en JSM
                    </h4>
                    <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                        Accede a tu cuenta de servicios profesionales
                    </p>
                </div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        <!-- Campo de Email -->
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope" aria-hidden="true"></i>
                                Correo Electrónico
                            </label>
                            <div class="input-container">
                                <input id="email" 
                                       type="email" 
                                       class="form-control @error('email') is-invalid error-shake @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email" 
                                       autofocus 
                                       placeholder="ejemplo@correo.com"
                                       aria-describedby="email-help">
                                <i class="fas fa-envelope input-icon" aria-hidden="true"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert" id="email-help">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Campo de Contraseña -->
                        <div class="form-group">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock" aria-hidden="true"></i>
                                Contraseña
                            </label>
                            <div class="input-container">
                                <input id="password" 
                                       type="password" 
                                       class="form-control @error('password') is-invalid error-shake @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password" 
                                       placeholder="Tu contraseña segura"
                                       aria-describedby="password-help">
                                <i class="fas fa-eye input-icon toggle-password" 
                                   aria-hidden="true" 
                                   onclick="togglePassword()"
                                   title="Mostrar/Ocultar contraseña"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert" id="password-help">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Recordarme -->
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="remember" 
                                   id="remember" 
                                   {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Mantener mi sesión iniciada
                            </label>
                        </div>

                        <!-- Botón de envío -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2" aria-hidden="true"></i>
                                Iniciar Sesión
                            </button>
                        </div>

                        <!-- Enlace de recuperación -->
                        @if (Route::has('password.request'))
                            <div class="text-center">
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    <i class="fas fa-key me-1" aria-hidden="true"></i>
                                    ¿Olvidaste tu contraseña?
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
                
                <div class="card-footer text-center">
                    <p class="mb-0">
                        ¿No tienes una cuenta? 
                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                            <i class="fas fa-user-plus me-1" aria-hidden="true"></i>
                            Regístrate aquí
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Función para mostrar/ocultar contraseña
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.querySelector('.toggle-password');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
        toggleIcon.title = 'Ocultar contraseña';
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
        toggleIcon.title = 'Mostrar contraseña';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    
    // Manejo del envío del formulario
    form.addEventListener('submit', function() {
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Iniciando sesión...';
    });
    
    // Restaurar botón si hay errores
    if (document.querySelector('.invalid-feedback')) {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
        
        // Foco automático en el primer campo con error
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.focus();
        }
    }
    
    // Validación en tiempo real
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    
    // Validación de email
    emailInput.addEventListener('blur', function() {
        validateEmail(this);
    });
    
    emailInput.addEventListener('input', function() {
        if (this.value.length > 0) {
            validateEmail(this);
        }
    });
    
    // Validación de contraseña
    passwordInput.addEventListener('blur', function() {
        validatePassword(this);
    });
    
    function validateEmail(input) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const isValid = emailRegex.test(input.value.trim());
        
        if (input.value.trim() === '') {
            input.classList.remove('is-valid', 'is-invalid');
        } else if (isValid) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
    }
    
    function validatePassword(input) {
        if (input.value.trim() === '') {
            input.classList.remove('is-valid', 'is-invalid');
        } else if (input.value.length >= 6) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
    }
    
    // Mejoras de accesibilidad
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.form-group').classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.closest('.form-group').classList.remove('focused');
        });
    });
    
    // Animación de entrada
    const card = document.querySelector('.card');
    setTimeout(() => {
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    }, 100);
    
    console.log('✅ Funcionalidades de login inicializadas correctamente');
});
</script>
@endsection