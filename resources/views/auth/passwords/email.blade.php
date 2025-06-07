@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('styles')
<style>
    /* Reset y variables CSS */
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

    /* Animaciones */
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

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    /* Contenedor principal */
    .recovery-container {
        animation: slideInDown 0.8s ease-out;
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        padding: 2rem 0;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    }

    /* Estilos de la tarjeta */
    .card {
        animation: fadeInScale 0.8s ease-out 0.3s both;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 20px 40px rgba(16, 76, 255, 0.1);
        border-radius: 1.5rem;
        overflow: hidden;
        background: white;
        max-width: 480px;
        width: 100%;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(16, 76, 255, 0.15);
    }

    /* Header de la tarjeta */
    .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 3rem 2rem;
        border: none;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: repeating-linear-gradient(
            45deg,
            rgba(255,255,255,0.05),
            rgba(255,255,255,0.05) 1px,
            transparent 1px,
            transparent 30px
        );
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(1deg); }
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
        position: relative;
        z-index: 1;
    }

    .icon-container i {
        font-size: 2.5rem;
        color: white;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }

    .card-header h1 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .card-header .subtitle {
        font-size: 1rem;
        opacity: 0.9;
        font-weight: 400;
        position: relative;
        z-index: 1;
        text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    }

    /* Cuerpo de la tarjeta */
    .card-body {
        padding: 3rem 2rem;
        background: white;
    }

    /* Formulario */
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
        padding-right: 3rem;
    }

    .form-control.is-invalid:focus {
        border-color: var(--error-color);
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    /* Iconos */
    .input-icon {
        position: absolute;
        right: 1rem;
        color: #9ca3af;
        transition: all 0.3s ease;
        z-index: 10;
        font-size: 1.2rem;
    }

    .form-control:focus ~ .input-icon {
        color: var(--primary-color);
        transform: scale(1.1);
    }

    .form-control.is-invalid ~ .input-icon {
        color: var(--error-color);
    }

    /* Mensajes de error */
    .invalid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: var(--error-color);
        font-weight: 500;
    }

    /* Animación de error */
    .error-shake {
        animation: shake 0.6s ease-in-out;
    }

    /* Botones */
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

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-darker) 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 76, 255, 0.3);
    }

    .btn-primary:disabled {
        background: #9ca3af;
        transform: none;
        box-shadow: none;
        opacity: 0.7;
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

    /* Alertas */
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

    .alert-success i {
        margin-right: 0.5rem;
    }

    /* Footer de la tarjeta */
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

    /* Loading state */
    .btn-loading {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn-loading::after {
        content: '';
        width: 16px;
        height: 16px;
        margin-left: 8px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .recovery-container {
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
<div class="recovery-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <div class="icon-container">
                            <i class="fas fa-key"></i>
                        </div>
                        <h1>Recuperar Contraseña</h1>
                        <p class="subtitle">Te ayudamos a recuperar el acceso a tu cuenta</p>
                </div>
                
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle"></i>
                                {{ session('status') }}
                        </div>
                    @endif

                        <form method="POST" action="{{ route('password.email') }}" id="recovery-form">
                        @csrf

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
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email" 
                                       autofocus 
                                           placeholder="Ingresa tu correo electrónico">
                                    
                                    <i class="input-icon fas fa-envelope"></i>
                            </div>

                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary w-100" id="submit-btn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                Enviar Enlace de Recuperación
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
    const form = document.getElementById('recovery-form');
    const submitBtn = document.getElementById('submit-btn');
    const emailInput = document.getElementById('email');

    form.addEventListener('submit', function(e) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
    });
    
    emailInput.addEventListener('input', function() {
        const email = this.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });

    @if($errors->any())
        document.querySelector('.card').classList.add('error-shake');
        setTimeout(() => {
            document.querySelector('.card').classList.remove('error-shake');
        }, 600);
    @endif
});
</script>
@endsection 