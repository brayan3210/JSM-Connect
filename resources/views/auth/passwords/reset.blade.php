@extends('layouts.app')

@section('title', 'Restablecer Contraseña')

@section('styles')
<style>
    :root {
        --primary-color: #104CFF;
        --primary-dark: #0940e6;
        --primary-darker: #0733cc;
        --success-color: #10b981;
        --error-color: #ef4444;
        --warning-color: #f59e0b;
        --text-dark: #1e293b;
        --text-gray: #475569;
        --border-color: #e5e7eb;
        --bg-light: #f8fafc;
    }

    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-50px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    .reset-container {
        animation: slideInDown 0.8s ease-out;
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        padding: 2rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    .card {
        animation: fadeInScale 0.8s ease-out 0.3s both;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 20px 40px rgba(16, 76, 255, 0.1);
        border-radius: 1.5rem;
        overflow: hidden;
        background: white;
        max-width: 500px;
        width: 100%;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(16, 76, 255, 0.15);
    }

    .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 3rem 2rem;
        border: none;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .icon-container {
        background: rgba(255, 255, 255, 0.15);
        width: 80px;
        height: 80px;
        border-radius: 20px;
        margin: 0 auto 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .icon-container i {
        font-size: 2.5rem;
        color: white;
    }

    .card-header h1 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .card-header .subtitle {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 400;
    }

    .card-body {
        padding: 3rem 2rem;
        background: white;
    }

    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
    }

    .form-label i {
        color: var(--primary-color);
        margin-right: 0.5rem;
    }

    .input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .form-control {
        width: 100%;
        padding: 1rem 3.5rem 1rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 0.75rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: white;
        color: var(--text-dark);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(16, 76, 255, 0.1);
        transform: translateY(-1px);
    }

    .form-control.is-invalid {
        border-color: var(--error-color);
    }

    .form-control:disabled {
        background-color: #f3f4f6;
        opacity: 0.7;
    }

    .input-icon {
        position: absolute;
        right: 1rem;
        color: #9ca3af;
        transition: all 0.3s ease;
        z-index: 10;
        font-size: 1.2rem;
        cursor: pointer;
    }

    .form-control:focus ~ .input-icon {
        color: var(--primary-color);
        transform: scale(1.1);
    }

    .form-control.is-invalid ~ .input-icon {
        color: var(--error-color);
    }

    .password-toggle {
        cursor: pointer;
        user-select: none;
    }

    .password-strength {
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }

    .strength-bar {
        height: 4px;
        background: var(--border-color);
        border-radius: 2px;
        overflow: hidden;
        margin-top: 0.5rem;
    }

    .strength-fill {
        height: 100%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .strength-weak { width: 25%; background: var(--error-color); }
    .strength-fair { width: 50%; background: var(--warning-color); }
    .strength-good { width: 75%; background: #3b82f6; }
    .strength-strong { width: 100%; background: var(--primary-color); }

    .invalid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: var(--error-color);
        font-weight: 500;
    }

    .error-shake {
        animation: shake 0.6s ease-in-out;
    }

    .btn {
        transition: all 0.3s ease;
        font-weight: 600;
        padding: 1rem 2rem;
        border-radius: 0.75rem;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 76, 255, 0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-darker) 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 76, 255, 0.3);
    }

    .btn-link {
        color: var(--primary-color);
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-link:hover {
        color: var(--primary-dark);
        text-decoration: none;
        transform: translateY(-1px);
    }

    .alert {
        border-radius: 0.75rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.5rem;
        border: none;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
    }

    .card-footer {
        background: var(--bg-light);
        border: none;
        padding: 2rem;
        text-align: center;
    }

    .card-footer .text-muted {
        color: var(--text-gray) !important;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .reset-container {
            padding: 1rem;
        }
        
        .card-header,
        .card-body {
            padding: 2rem 1.5rem;
        }
        
        .card-header h1 {
            font-size: 1.75rem;
        }
    }
</style>
@endsection

@section('content')
<div class="reset-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="icon-container">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h1>Nueva Contraseña</h1>
                        <p class="subtitle">Establece una nueva contraseña segura para tu cuenta</p>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}" id="reset-form">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i>
                                    Correo Electrónico
                                </label>
                                
                                <div class="input-container">
                                    <input id="email" 
                                           type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ $email ?? old('email') }}" 
                                           required 
                                           autocomplete="email" 
                                           autofocus
                                           readonly>
                                    
                                    <i class="input-icon fas fa-envelope"></i>
                                </div>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="form-label">
                                    <i class="fas fa-key"></i>
                                    Nueva Contraseña
                                </label>
                                
                                <div class="input-container">
                                    <input id="password" 
                                           type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Ingresa tu nueva contraseña">
                                    
                                    <i class="input-icon password-toggle fas fa-eye" onclick="togglePassword('password')"></i>
                                </div>

                                <div class="password-strength" id="password-strength" style="display: none;">
                                    <div class="strength-bar">
                                        <div class="strength-fill" id="strength-fill"></div>
                                    </div>
                                    <small id="strength-text" class="text-muted"></small>
                                </div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="form-label">
                                    <i class="fas fa-check"></i>
                                    Confirmar Contraseña
                                </label>
                                
                                <div class="input-container">
                                    <input id="password-confirm" 
                                           type="password" 
                                           class="form-control" 
                                           name="password_confirmation" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Confirma tu nueva contraseña">
                                    
                                    <i class="input-icon password-toggle fas fa-eye" onclick="togglePassword('password-confirm')"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100" id="submit-btn">
                                    <i class="fas fa-save me-2"></i>
                                    Restablecer Contraseña
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        <p class="text-muted mb-0">
                            ¿Recordaste tu contraseña? 
                            <a href="{{ route('login') }}" class="btn-link">
                                <i class="fas fa-sign-in-alt"></i>
                                Iniciar Sesión
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reset-form');
    const submitBtn = document.getElementById('submit-btn');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password-confirm');
    const strengthContainer = document.getElementById('password-strength');
    const strengthFill = document.getElementById('strength-fill');
    const strengthText = document.getElementById('strength-text');

    // Toggle password visibility
    window.togglePassword = function(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling;
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    };

    // Password strength checker
    function checkPasswordStrength(password) {
        let strength = 0;
        let feedback = [];

        if (password.length >= 8) strength += 1;
        else feedback.push('mínimo 8 caracteres');

        if (/[a-z]/.test(password)) strength += 1;
        else feedback.push('una minúscula');

        if (/[A-Z]/.test(password)) strength += 1;
        else feedback.push('una mayúscula');

        if (/[0-9]/.test(password)) strength += 1;
        else feedback.push('un número');

        if (/[^A-Za-z0-9]/.test(password)) strength += 1;
        else feedback.push('un símbolo');

        return { strength, feedback };
    }

    // Update password strength indicator
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        if (password.length > 0) {
            strengthContainer.style.display = 'block';
            const { strength, feedback } = checkPasswordStrength(password);
            
            // Remove all strength classes
            strengthFill.className = 'strength-fill';
            
            // Add appropriate strength class
            if (strength <= 1) {
                strengthFill.classList.add('strength-weak');
                strengthText.textContent = 'Débil - Necesita: ' + feedback.join(', ');
                strengthText.style.color = '#ef4444';
            } else if (strength <= 2) {
                strengthFill.classList.add('strength-fair');
                strengthText.textContent = 'Regular - Necesita: ' + feedback.join(', ');
                strengthText.style.color = '#f59e0b';
            } else if (strength <= 3) {
                strengthFill.classList.add('strength-good');
                strengthText.textContent = 'Buena - Necesita: ' + feedback.join(', ');
                strengthText.style.color = '#3b82f6';
            } else {
                strengthFill.classList.add('strength-strong');
                strengthText.textContent = 'Excelente - Contraseña segura';
                strengthText.style.color = '#104CFF';
            }
        } else {
            strengthContainer.style.display = 'none';
        }
        
        // Check password confirmation
        if (confirmInput.value && confirmInput.value !== password) {
            confirmInput.classList.add('is-invalid');
        } else {
            confirmInput.classList.remove('is-invalid');
        }
    });

    // Check password confirmation
    confirmInput.addEventListener('input', function() {
        if (this.value && this.value !== passwordInput.value) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        if (passwordInput.value !== confirmInput.value) {
            e.preventDefault();
            confirmInput.classList.add('is-invalid');
            return;
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Restableciendo...';
    });

    // Error animation
    @if($errors->any())
        document.querySelector('.card').classList.add('error-shake');
        setTimeout(() => {
            document.querySelector('.card').classList.remove('error-shake');
        }, 600);
    @endif
});
</script>
@endsection 