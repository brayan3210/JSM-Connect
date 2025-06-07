@extends('layouts.app')

@section('title', 'Registro')

@section('styles')
<style>
    /* Animaciones para registro */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes progressBar {
        from { width: 0%; }
        to { width: var(--progress-width); }
    }

    /* Contenedor principal */
    .register-container {
        animation: slideInUp 0.8s ease-out;
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }

    /* Estilos de la tarjeta */
    .card {
        animation: fadeInScale 0.8s ease-out 0.2s both;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        border-radius: 1rem;
        overflow: hidden;
    }

    .card:hover {
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

    /* Progress bar para el formulario */
    .form-progress {
        height: 6px;
        background: #e5e7eb;
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 2rem;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .form-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%);
        border-radius: 3px;
        transition: all 0.4s ease;
        position: relative;
    }

    .form-progress-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Estilos de formulario */
    .form-group {
        margin-bottom: 1.5rem;
        opacity: 0;
        transform: translateX(-20px);
        animation: slideInLeft 0.6s ease-out forwards;
    }

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }
    .form-group:nth-child(4) { animation-delay: 0.4s; }
    .form-group:nth-child(5) { animation-delay: 0.5s; }
    .form-group:nth-child(6) { animation-delay: 0.6s; }

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
        width: 1rem;
        text-align: center;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 0.25rem;
    }

    .input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 0.875rem 3rem 0.875rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fff;
    }

    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        transform: translateY(-1px);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-control.is-valid, .form-select.is-valid {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    /* Iconos de validación */
    .input-icon {
        position: absolute;
        right: 1rem;
        color: #9ca3af;
        transition: all 0.3s ease;
        z-index: 10;
        pointer-events: none;
    }

    .form-control:focus ~ .input-icon,
    .form-select:focus ~ .input-icon {
        color: #4f46e5;
        transform: scale(1.1);
    }

    .form-control.is-valid ~ .input-icon,
    .form-select.is-valid ~ .input-icon {
        color: #10b981;
    }

    .form-control.is-invalid ~ .input-icon,
    .form-select.is-invalid ~ .input-icon {
        color: #ef4444;
    }

    /* Sección de términos mejorada */
    .terms-section {
        margin: 2rem 0;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 1rem;
        border: 2px solid #e5e7eb;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .form-check {
        margin-bottom: 1rem;
        padding: 1rem;
        background: #ffffff;
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .form-check:hover {
        border-color: #c7d2fe;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.1);
    }

    .form-check-input {
        margin-top: 0.25rem;
        margin-right: 0.75rem;
        width: 1.2rem;
        height: 1.2rem;
        border: 2px solid #d1d5db;
        transition: all 0.3s ease;
    }

    .form-check-input:checked {
        background-color: #4f46e5;
        border-color: #4f46e5;
        transform: scale(1.1);
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-check-label {
        color: #374151;
        font-size: 0.95rem;
        line-height: 1.6;
        cursor: pointer;
    }

    .form-check-label a {
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
    }

    .form-check-label a:hover {
        text-decoration: underline;
        transform: translateY(-1px);
    }

    .form-check-label .text-primary {
        color: #4f46e5 !important;
    }

    .form-check-label .text-success {
        color: #10b981 !important;
    }

    /* Estilos para modales */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    }

    .modal-header {
        border-radius: 1rem 1rem 0 0;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 2rem;
        max-height: 60vh;
        overflow-y: auto;
    }

    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .section {
        padding: 1rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .section:last-child {
        border-bottom: none;
    }

    .text-justify {
        text-align: justify;
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
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.6s ease;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
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
        font-weight: 500;
    }

    .valid-feedback {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: #10b981;
        font-weight: 500;
    }

    /* Tooltips para ayuda */
    .help-tooltip {
        position: relative;
        cursor: help;
        margin-left: 0.5rem;
        color: #6b7280;
    }

    .help-tooltip::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: #1f2937;
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .help-tooltip::before {
        content: '';
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%) translateY(1px);
        border: 4px solid transparent;
        border-top-color: #1f2937;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .help-tooltip:hover::after,
    .help-tooltip:hover::before {
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .register-container {
            padding: 1rem 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-header {
            padding: 1.5rem;
        }
        
        .form-control, .form-select {
            padding: 0.75rem 2.5rem 0.75rem 0.875rem;
        }
    }
</style>
@endsection

@section('content')

@php
    // Registrar visita para la página de registro
    \App\Models\Visit::registrarVisita(request(), '/register');
@endphp

<div class="container-fluid">
    <div class="row justify-content-center register-container">
        <div class="col-11 col-md-10 col-lg-8 col-xl-7">
        <div class="card shadow">
                <div class="card-header text-center">
                    <h4 class="mb-2">
                        <i class="fas fa-user-plus me-2" aria-hidden="true"></i>
                        Registro en JSM
                    </h4>
                    <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                        Únete a nuestra plataforma de servicios profesionales
                    </p>
            </div>
                
            <div class="card-body">
                    <!-- Barra de progreso del formulario -->
                    <div class="form-progress">
                        <div class="form-progress-bar" id="form-progress" style="width: 0%;"></div>
                    </div>
                    
                    <form method="POST" action="{{ route('register') }}" novalidate>
                    @csrf

                        <!-- Nombres -->
                        <div class="row form-group">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    Nombre<span class="required">*</span>
                                </label>
                                <div class="input-container">
                                    <input id="nombre" 
                                           type="text" 
                                           class="form-control @error('nombre') is-invalid @enderror" 
                                           name="nombre" 
                                           value="{{ old('nombre') }}" 
                                           required 
                                           autocomplete="given-name" 
                                           autofocus 
                                           placeholder="Tu nombre"
                                           aria-describedby="nombre-help">
                                    <i class="fas fa-user input-icon" aria-hidden="true"></i>
                                </div>
                            @error('nombre')
                                    <span class="invalid-feedback" role="alert" id="nombre-help">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">
                                    <i class="fas fa-user" aria-hidden="true"></i>
                                    Apellidos<span class="required">*</span>
                                </label>
                                <div class="input-container">
                                    <input id="apellidos" 
                                           type="text" 
                                           class="form-control @error('apellidos') is-invalid @enderror" 
                                           name="apellidos" 
                                           value="{{ old('apellidos') }}" 
                                           required 
                                           autocomplete="family-name" 
                                           placeholder="Tus apellidos"
                                           aria-describedby="apellidos-help">
                                    <i class="fas fa-user input-icon" aria-hidden="true"></i>
                                </div>
                            @error('apellidos')
                                    <span class="invalid-feedback" role="alert" id="apellidos-help">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                        <!-- Documento -->
                        <div class="row form-group">
                            <div class="col-md-6 mb-3">
                                <label for="tipo_documento" class="form-label">
                                    <i class="fas fa-id-card" aria-hidden="true"></i>
                                    Tipo de Documento<span class="required">*</span>
                                </label>
                                <div class="input-container">
                                    <select id="tipo_documento" 
                                            class="form-select @error('tipo_documento') is-invalid @enderror" 
                                            name="tipo_documento" 
                                            required
                                            aria-describedby="tipo_documento-help">
                                <option value="" disabled {{ old('tipo_documento') ? '' : 'selected' }}>Seleccione...</option>
                                        <option value="Cédula" {{ old('tipo_documento') == 'Cédula' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                                <option value="Pasaporte" {{ old('tipo_documento') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                <option value="DNI" {{ old('tipo_documento') == 'DNI' ? 'selected' : '' }}>DNI</option>
                                <option value="Otro" {{ old('tipo_documento') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                                    <i class="fas fa-id-card input-icon" aria-hidden="true"></i>
                                </div>
                            @error('tipo_documento')
                                    <span class="invalid-feedback" role="alert" id="tipo_documento-help">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="numero_documento" class="form-label">
                                    <i class="fas fa-hashtag" aria-hidden="true"></i>
                                    Número de Documento<span class="required">*</span>
                                </label>
                                <div class="input-container">
                                    <input id="numero_documento" 
                                           type="text" 
                                           class="form-control @error('numero_documento') is-invalid @enderror" 
                                           name="numero_documento" 
                                           value="{{ old('numero_documento') }}" 
                                           required
                                           placeholder="Número de documento"
                                           aria-describedby="numero_documento-help">
                                    <i class="fas fa-hashtag input-icon" aria-hidden="true"></i>
                                </div>
                            @error('numero_documento')
                                    <span class="invalid-feedback" role="alert" id="numero_documento-help">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                        <!-- Género y Profesión -->
                        <div class="row form-group">
                            <div class="col-md-6 mb-3">
                                <label for="genero" class="form-label">
                                    <i class="fas fa-venus-mars" aria-hidden="true"></i>
                                    Género<span class="required">*</span>
                                </label>
                                <div class="input-container">
                                    <select id="genero" 
                                            class="form-select @error('genero') is-invalid @enderror" 
                                            name="genero" 
                                            required
                                            aria-describedby="genero-help">
                                <option value="" disabled {{ old('genero') ? '' : 'selected' }}>Seleccione...</option>
                                <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                <option value="Prefiero no decir" {{ old('genero') == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                            </select>
                                    <i class="fas fa-venus-mars input-icon" aria-hidden="true"></i>
                                </div>
                            @error('genero')
                                    <span class="invalid-feedback" role="alert" id="genero-help">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="profesion" class="form-label">
                                    <i class="fas fa-briefcase" aria-hidden="true"></i>
                                    Profesión<span class="required">*</span>
                                </label>
                                <div class="input-container">
                                    <input id="profesion" 
                                           type="text" 
                                           class="form-control @error('profesion') is-invalid @enderror" 
                                           name="profesion" 
                                           value="{{ old('profesion') }}" 
                                           required
                                           placeholder="Tu profesión u ocupación"
                                           aria-describedby="profesion-help">
                                    <i class="fas fa-briefcase input-icon" aria-hidden="true"></i>
                                </div>
                            @error('profesion')
                                    <span class="invalid-feedback" role="alert" id="profesion-help">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                        <!-- Email y Teléfono -->
                        <div class="row form-group">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope" aria-hidden="true"></i>
                                    Correo Electrónico<span class="required">*</span>
                                </label>
                                <div class="input-container">
                                    <input id="email" 
                                           type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required 
                                           autocomplete="email"
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
                            
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">
                                    <i class="fas fa-phone" aria-hidden="true"></i>
                                    Teléfono<span class="required">*</span>
                                </label>
                                <div class="input-container">
                                    <input id="telefono" 
                                           type="tel" 
                                           class="form-control @error('telefono') is-invalid @enderror" 
                                           name="telefono" 
                                           value="{{ old('telefono') }}" 
                                           required
                                           placeholder="+57 300 123 4567"
                                           aria-describedby="telefono-help">
                                    <i class="fas fa-phone input-icon" aria-hidden="true"></i>
                                </div>
                            @error('telefono')
                                    <span class="invalid-feedback" role="alert" id="telefono-help">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                        <!-- Contraseñas -->
                        <div class="row form-group">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock" aria-hidden="true"></i>
                                    Contraseña<span class="required">*</span>
                                    <span class="help-tooltip" data-tooltip="Mínimo 8 caracteres">
                                        <i class="fas fa-question-circle"></i>
                                    </span>
                                </label>
                                <div class="input-container">
                                    <input id="password" 
                                           type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Contraseña segura"
                                           aria-describedby="password-help">
                                    <i class="fas fa-lock input-icon" aria-hidden="true"></i>
                                </div>
                            @error('password')
                                    <span class="invalid-feedback" role="alert" id="password-help">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password-confirm" class="form-label">
                                    <i class="fas fa-lock" aria-hidden="true"></i>
                                    Confirmar Contraseña<span class="required">*</span>
                                </label>
                                <div class="input-container">
                                    <input id="password-confirm" 
                                           type="password" 
                                           class="form-control" 
                                           name="password_confirmation" 
                                           required 
                                           autocomplete="new-password"
                                           placeholder="Repite tu contraseña"
                                           aria-describedby="password-confirm-help">
                                    <i class="fas fa-lock input-icon" aria-hidden="true"></i>
                                </div>
                                <span class="valid-feedback" id="password-confirm-help" style="display: none;">
                                    Las contraseñas coinciden
                                </span>
                                <span class="invalid-feedback" id="password-mismatch-help" style="display: none;">
                                    Las contraseñas no coinciden
                                </span>
                            </div>
                        </div>

                        <!-- Términos y condiciones -->
                        <div class="terms-section">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="terms" 
                                       id="terms" 
                                       required
                                       aria-describedby="terms-help">
                                <label class="form-check-label" for="terms">
                                    <i class="fas fa-file-contract me-2 text-primary"></i>
                                    Acepto los <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" class="text-primary fw-bold">términos y condiciones</a> 
                                    y la <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal" class="text-primary fw-bold">política de privacidad</a> de JSM Connect
                                </label>
                                @error('terms')
                                    <span class="invalid-feedback d-block" role="alert" id="terms-help">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>

                            <div class="form-check mt-3">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="data_policy" 
                                       id="data_policy" 
                                       required
                                       aria-describedby="data-policy-help">
                                <label class="form-check-label" for="data_policy">
                                    <i class="fas fa-shield-alt me-2 text-success"></i>
                                    Acepto la <a href="{{ route('policy.data') }}" target="_blank" class="text-success fw-bold">política de tratamiento de datos personales</a>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-download me-1"></i>
                                        <a href="{{ route('policy.data.download') }}" class="text-muted text-decoration-none">Descargar PDF</a>
                                    </small>
                            </label>
                                @error('data_policy')
                                    <span class="invalid-feedback d-block" role="alert" id="data-policy-help">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                        <!-- Botón de envío -->
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2" aria-hidden="true"></i>
                                Crear mi cuenta
                            </button>
                        </div>
                        
                        <!-- Enlace de login -->
                        <div class="text-center">
                            <a class="btn btn-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1" aria-hidden="true"></i>
                                ¿Ya tienes una cuenta? Inicia sesión
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Términos y Condiciones -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="termsModalLabel">
                    <i class="fas fa-file-contract me-2"></i>
                    Términos y Condiciones de JSM Connect
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="terms-content">
                    <div class="section mb-4">
                        <h6 class="fw-bold text-primary">1. Aceptación de los Términos</h6>
                        <p class="text-justify">
                            Al registrarte y utilizar la plataforma JSM Connect, aceptas estar sujeto a estos términos y condiciones. 
                            Si no estás de acuerdo con alguno de estos términos, no debes utilizar nuestros servicios.
                        </p>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-primary">2. Descripción del Servicio</h6>
                        <p class="text-justify">
                            JSM Connect es una plataforma digital que facilita la conexión entre profesionales independientes 
                            y usuarios que requieren servicios especializados. Actuamos como intermediarios para facilitar 
                            estas conexiones, pero no somos parte directa de los contratos de servicios.
                        </p>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-primary">3. Registro de Usuario</h6>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Debes proporcionar información veraz y actualizada</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Eres responsable de mantener la confidencialidad de tu cuenta</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Debes notificar inmediatamente cualquier uso no autorizado</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Debe ser mayor de 18 años para registrarse</li>
                        </ul>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-primary">4. Responsabilidades del Usuario</h6>
                        <p class="text-justify">
                            Los usuarios se comprometen a utilizar la plataforma de manera responsable, respetando los derechos 
                            de otros usuarios y cumpliendo con todas las leyes aplicables. Está prohibido el uso de la plataforma 
                            para actividades ilegales o que puedan dañar a terceros.
                        </p>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-primary">5. Servicios y Transacciones</h6>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2"><i class="fas fa-info-circle text-info me-2"></i>Los contratos son directamente entre usuarios</li>
                            <li class="mb-2"><i class="fas fa-info-circle text-info me-2"></i>JSM Connect no garantiza la calidad de los servicios</li>
                            <li class="mb-2"><i class="fas fa-info-circle text-info me-2"></i>Las disputas deben resolverse entre las partes</li>
                            <li class="mb-2"><i class="fas fa-info-circle text-info me-2"></i>Mantenemos un sistema de valoraciones y comentarios</li>
                        </ul>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-primary">6. Limitación de Responsabilidad</h6>
                        <p class="text-justify">
                            JSM Connect actúa únicamente como facilitador. No somos responsables por la calidad, seguridad, 
                            legalidad o veracidad de los servicios ofrecidos por los usuarios. Nuestra responsabilidad se 
                            limita al funcionamiento técnico de la plataforma.
                        </p>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-primary">7. Terminación</h6>
                        <p class="text-justify">
                            Podemos suspender o terminar tu acceso a la plataforma en caso de violación de estos términos. 
                            Los usuarios también pueden cancelar su cuenta en cualquier momento desde su perfil.
                        </p>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-primary">8. Modificaciones</h6>
                        <p class="text-justify">
                            Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios serán 
                            notificados a través de la plataforma y entrarán en vigor 30 días después de su publicación.
                        </p>
                    </div>

                    <div class="section">
                        <h6 class="fw-bold text-primary">9. Contacto</h6>
                        <p class="text-justify">
                            Para consultas sobre estos términos, puedes contactarnos a través de 
                            <strong>jsmconect@gmail.com</strong> o mediante los canales disponibles en la plataforma.
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
                <button type="button" class="btn btn-primary" id="acceptTermsBtn">
                    <i class="fas fa-check me-2"></i>Acepto los Términos
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Política de Privacidad -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="privacyModalLabel">
                    <i class="fas fa-user-shield me-2"></i>
                    Política de Privacidad de JSM Connect
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="privacy-content">
                    <div class="section mb-4">
                        <h6 class="fw-bold text-info">1. Información que Recolectamos</h6>
                        <p class="text-justify">
                            Recolectamos información que nos proporcionas directamente, como tu nombre, correo electrónico, 
                            teléfono, profesión y otros datos necesarios para crear tu perfil en la plataforma.
                        </p>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-info">2. Uso de la Información</h6>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2"><i class="fas fa-dot-circle text-info me-2"></i>Facilitar conexiones entre usuarios</li>
                            <li class="mb-2"><i class="fas fa-dot-circle text-info me-2"></i>Mejorar nuestros servicios</li>
                            <li class="mb-2"><i class="fas fa-dot-circle text-info me-2"></i>Comunicaciones importantes de la plataforma</li>
                            <li class="mb-2"><i class="fas fa-dot-circle text-info me-2"></i>Cumplimiento de obligaciones legales</li>
                        </ul>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-info">3. Compartir Información</h6>
                        <p class="text-justify">
                            No vendemos ni alquilamos tu información personal. Solo compartimos información limitada necesaria 
                            para facilitar las conexiones entre usuarios de la plataforma y con tu consentimiento explícito.
                        </p>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-info">4. Seguridad de Datos</h6>
                        <p class="text-justify">
                            Implementamos medidas de seguridad técnicas y administrativas para proteger tu información personal 
                            contra acceso no autorizado, alteración, divulgación o destrucción.
                        </p>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-info">5. Tus Derechos</h6>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2"><i class="fas fa-user-cog text-info me-2"></i>Acceder a tu información personal</li>
                            <li class="mb-2"><i class="fas fa-user-cog text-info me-2"></i>Corregir datos inexactos</li>
                            <li class="mb-2"><i class="fas fa-user-cog text-info me-2"></i>Solicitar eliminación de tu cuenta</li>
                            <li class="mb-2"><i class="fas fa-user-cog text-info me-2"></i>Revocar consentimientos otorgados</li>
                        </ul>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-info">6. Cookies y Tecnologías Similares</h6>
                        <p class="text-justify">
                            Utilizamos cookies para mejorar tu experiencia en la plataforma, recordar tus preferencias y 
                            analizar el uso del sitio web. Puedes gestionar las cookies desde tu navegador.
                        </p>
                    </div>

                    <div class="section mb-4">
                        <h6 class="fw-bold text-info">7. Retención de Datos</h6>
                        <p class="text-justify">
                            Conservamos tu información personal solo durante el tiempo necesario para los fines establecidos 
                            o según lo requiera la ley. Cuando cierres tu cuenta, procederemos a eliminar tus datos personales.
                        </p>
                    </div>

                    <div class="section">
                        <h6 class="fw-bold text-info">8. Cambios a esta Política</h6>
                        <p class="text-justify">
                            Podemos actualizar esta política ocasionalmente. Te notificaremos sobre cambios significativos 
                            por correo electrónico o mediante aviso en la plataforma.
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cerrar
                </button>
                <button type="button" class="btn btn-info" id="acceptPrivacyBtn">
                    <i class="fas fa-check me-2"></i>Entiendo la Política
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del formulario
    const form = document.querySelector('form');
    const formFields = form.querySelectorAll('input[required], select[required]');
    const progressBar = document.getElementById('form-progress');
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    
    // Campos específicos
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password-confirm');
    const emailInput = document.getElementById('email');
    const termsCheckbox = document.getElementById('terms');
    const dataPolicyCheckbox = document.getElementById('data_policy');
    
    // Función para actualizar el progreso
    function updateProgress() {
        const totalFields = formFields.length;
        let filledFields = 0;
        
        formFields.forEach(field => {
            if (field.type === 'checkbox') {
                if (field.checked) filledFields++;
            } else if (field.value.trim() !== '') {
                filledFields++;
            }
        });
        
        const progress = (filledFields / totalFields) * 100;
        progressBar.style.width = progress + '%';
        
        // Cambiar color según el progreso
        if (progress === 100) {
            progressBar.style.background = 'linear-gradient(90deg, #10b981 0%, #059669 100%)';
        } else if (progress >= 75) {
            progressBar.style.background = 'linear-gradient(90deg, #06b6d4 0%, #0891b2 100%)';
        } else if (progress >= 50) {
            progressBar.style.background = 'linear-gradient(90deg, #f59e0b 0%, #d97706 100%)';
        } else {
            progressBar.style.background = 'linear-gradient(90deg, #4f46e5 0%, #7c3aed 100%)';
        }
    }
    
    // Función de validación para campos individuales
    function validateField(field) {
        const icon = field.parentElement.querySelector('.input-icon');
        let isValid = false;
        
        if (field.type === 'email') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            isValid = emailRegex.test(field.value.trim());
        } else if (field.type === 'tel') {
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]+$/;
            isValid = phoneRegex.test(field.value.trim()) && field.value.trim().length >= 10;
        } else if (field.type === 'password') {
            isValid = field.value.length >= 8;
        } else {
            isValid = field.checkValidity() && field.value.trim() !== '';
        }
        
        if (field.value.trim() === '') {
            field.classList.remove('is-valid', 'is-invalid');
            if (icon) {
                icon.className = icon.className.replace(/fa-check-circle|fa-exclamation-circle/, getOriginalIconClass(field));
            }
        } else if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
            if (icon) {
                icon.className = icon.className.replace(/fa-[\w-]+$/, 'fa-check-circle');
            }
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
            if (icon) {
                icon.className = icon.className.replace(/fa-[\w-]+$/, 'fa-exclamation-circle');
            }
        }
        
        return isValid;
    }
    
    // Función para obtener el icono original
    function getOriginalIconClass(field) {
        const iconMap = {
            'nombre': 'fa-user',
            'apellidos': 'fa-user',
            'tipo_documento': 'fa-id-card',
            'numero_documento': 'fa-hashtag',
            'genero': 'fa-venus-mars',
            'profesion': 'fa-briefcase',
            'email': 'fa-envelope',
            'telefono': 'fa-phone',
            'password': 'fa-lock',
            'password-confirm': 'fa-lock'
        };
        return iconMap[field.id] || 'fa-circle';
    }
    
    // Validación específica de contraseñas
    function validatePasswords() {
        const password = passwordInput.value;
        const confirmPassword = passwordConfirmInput.value;
        const confirmHelp = document.getElementById('password-confirm-help');
        const mismatchHelp = document.getElementById('password-mismatch-help');
        
        if (confirmPassword.length === 0) {
            confirmHelp.style.display = 'none';
            mismatchHelp.style.display = 'none';
            passwordConfirmInput.classList.remove('is-valid', 'is-invalid');
            return;
        }
        
        if (password === confirmPassword && password.length >= 8) {
            passwordConfirmInput.classList.remove('is-invalid');
            passwordConfirmInput.classList.add('is-valid');
            confirmHelp.style.display = 'block';
            mismatchHelp.style.display = 'none';
            
            const icon = passwordConfirmInput.parentElement.querySelector('.input-icon');
            if (icon) {
                icon.className = icon.className.replace(/fa-[\w-]+$/, 'fa-check-circle');
            }
        } else {
            passwordConfirmInput.classList.remove('is-valid');
            passwordConfirmInput.classList.add('is-invalid');
            confirmHelp.style.display = 'none';
            mismatchHelp.style.display = 'block';
            
            const icon = passwordConfirmInput.parentElement.querySelector('.input-icon');
            if (icon) {
                icon.className = icon.className.replace(/fa-[\w-]+$/, 'fa-exclamation-circle');
            }
        }
    }
    
    // Event listeners para validación en tiempo real
    formFields.forEach(field => {
        field.addEventListener('input', function() {
            updateProgress();
            if (this.value.length > 0) {
                validateField(this);
            }
        });
        
        field.addEventListener('blur', function() {
            if (this.value.trim() !== '') {
                validateField(this);
            }
        });
        
        field.addEventListener('change', updateProgress);
    });
    
    // Validación específica para contraseñas
    passwordInput.addEventListener('input', validatePasswords);
    passwordConfirmInput.addEventListener('input', validatePasswords);
    
    // Progreso inicial
    updateProgress();
    
    // Manejo del envío del formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isFormValid = true;
        let firstInvalidField = null;
        
        // Validar todos los campos
        formFields.forEach(field => {
            const isValid = validateField(field);
            if (!isValid && !firstInvalidField) {
                firstInvalidField = field;
                isFormValid = false;
            }
        });
        
        // Validar contraseñas
        if (passwordInput.value !== passwordConfirmInput.value) {
            isFormValid = false;
            if (!firstInvalidField) {
                firstInvalidField = passwordConfirmInput;
            }
        }
        
        // Validar términos
        if (!termsCheckbox.checked) {
            isFormValid = false;
            if (!firstInvalidField) {
                firstInvalidField = termsCheckbox;
            }
        }
        
        // Validar política de datos
        if (!dataPolicyCheckbox.checked) {
            isFormValid = false;
            if (!firstInvalidField) {
                firstInvalidField = dataPolicyCheckbox;
            }
        }
        
        if (isFormValid) {
            // Enviar formulario
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creando cuenta...';
            this.submit();
        } else {
            // Scroll al primer error
            if (firstInvalidField) {
                firstInvalidField.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'center' 
                });
                firstInvalidField.focus();
            }
        }
    });
    
    // Restaurar botón si hay errores del servidor
    if (document.querySelector('.invalid-feedback')) {
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
        
        // Foco en el primer campo con error
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.focus();
        }
    }
    
    // Mejoras de accesibilidad
    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('focus', function() {
            this.closest('.form-group').classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.closest('.form-group').classList.remove('focused');
        });
    });
    
    // Funcionalidad de modales
    const acceptTermsBtn = document.getElementById('acceptTermsBtn');
    const acceptPrivacyBtn = document.getElementById('acceptPrivacyBtn');
    const termsModal = new bootstrap.Modal(document.getElementById('termsModal'));
    const privacyModal = new bootstrap.Modal(document.getElementById('privacyModal'));
    
    // Aceptar términos desde el modal
    if (acceptTermsBtn) {
        acceptTermsBtn.addEventListener('click', function() {
            termsCheckbox.checked = true;
            termsCheckbox.dispatchEvent(new Event('change'));
            termsModal.hide();
            
            // Animación de confirmación
            const checkmark = termsCheckbox.closest('.form-check');
            checkmark.style.transform = 'scale(1.02)';
            checkmark.style.borderColor = '#10b981';
            setTimeout(() => {
                checkmark.style.transform = 'scale(1)';
                checkmark.style.borderColor = '#e5e7eb';
            }, 300);
            
            // Mostrar notificación
            showNotification('✅ Términos y condiciones aceptados', 'success');
        });
    }
    
    // Aceptar política de privacidad desde el modal
    if (acceptPrivacyBtn) {
        acceptPrivacyBtn.addEventListener('click', function() {
            // Solo cerrar el modal, no marcar checkbox automáticamente
            privacyModal.hide();
            showNotification('ℹ️ Política de privacidad revisada', 'info');
        });
    }
    
    // Función para mostrar notificaciones
    function showNotification(message, type = 'info') {
        // Mapear tipos de alerta
        const alertTypes = {
            'success': 'success',
            'info': 'info',
            'warning': 'warning',
            'error': 'danger'
        };
        
        const alertClass = alertTypes[type] || 'info';
        
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.className = `alert alert-${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 0.5rem;
        `;
        notification.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remover después de tiempo variable según tipo
        const timeout = type === 'warning' ? 4000 : 3000;
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, timeout);
    }
    
    // Validación adicional para checkboxes
    function validateCheckboxes() {
        const checkboxes = [termsCheckbox, dataPolicyCheckbox];
        let allValid = true;
        
        checkboxes.forEach(checkbox => {
            const formCheck = checkbox.closest('.form-check');
            
            if (!checkbox.checked) {
                formCheck.classList.add('border-danger');
                allValid = false;
            } else {
                formCheck.classList.remove('border-danger');
                formCheck.classList.add('border-success');
                setTimeout(() => {
                    formCheck.classList.remove('border-success');
                }, 2000);
            }
        });
        
        return allValid;
    }
    
    // Event listeners para checkboxes
    [termsCheckbox, dataPolicyCheckbox].forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateProgress();
            validateCheckboxes();
        });
    });
    
    // Prevenir envío del formulario si faltan checkboxes
    form.addEventListener('submit', function(e) {
        if (!validateCheckboxes()) {
            e.preventDefault();
            
            if (!termsCheckbox.checked) {
                showNotification('⚠️ Debes aceptar los términos y condiciones', 'warning');
                termsCheckbox.focus();
            } else if (!dataPolicyCheckbox.checked) {
                showNotification('⚠️ Debes aceptar la política de tratamiento de datos', 'warning');
                dataPolicyCheckbox.focus();
            }
            
            return false;
        }
    });

    console.log('✅ Funcionalidades de registro inicializadas correctamente');
});
</script>
@endsection 