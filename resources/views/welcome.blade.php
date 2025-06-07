@extends('layouts.app')

@section('title', 'Bienvenido')

@section('styles')
<style>
    /* Animaciones para la landing page */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
        opacity: 0;
    }

    .animate-fade-in-left {
        animation: fadeInLeft 0.8s ease-out forwards;
        opacity: 0;
    }

    .animate-fade-in-right {
        animation: fadeInRight 0.8s ease-out forwards;
        opacity: 0;
    }

    .animate-pulse {
        animation: pulse 2s infinite;
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .btn {
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
    }

    /* Contador de visitas mejorado y responsive */
    .visit-counter {
        position: fixed;
        bottom: 20px;
        left: 20px;
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
        z-index: 1000;
        font-size: 14px;
        max-width: 280px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .visit-counter:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 12px 35px rgba(79, 70, 229, 0.4);
        background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
    }

    .visit-counter:focus {
        outline: 3px solid #fbbf24;
        outline-offset: 2px;
    }

    .visit-counter h6 {
        margin: 0 0 12px 0;
        font-weight: 700;
        color: #ffffff;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        padding-bottom: 8px;
        display: flex;
        align-items: center;
        font-size: 15px;
    }

    .visit-counter h6 i {
        margin-right: 8px;
        color: #fbbf24;
    }

    .visit-stat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 8px 0;
        font-size: 13px;
        padding: 4px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .visit-stat:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .visit-stat span:first-child {
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    .visit-number {
        font-weight: 700;
        color: #fbbf24;
        font-size: 14px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        min-width: 50px;
        text-align: right;
    }

    /* Animaciones escalonadas */
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }
    .stagger-5 { animation-delay: 0.5s; }
    .stagger-6 { animation-delay: 0.6s; }

    /* Gradiente animado para el hero */
    .hero-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        background-size: 400% 400%;
        animation: gradientShift 8s ease infinite;
    }

    @keyframes gradientShift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Mejoras responsivas para contador de visitas */
    @media (max-width: 768px) {
        .visit-counter {
            bottom: 80px;
            left: 15px;
            right: 15px;
            max-width: calc(100% - 30px);
            font-size: 12px;
            padding: 12px 16px;
            position: fixed;
            transform: none;
        }
        
        .visit-counter:hover {
            transform: translateY(-3px) scale(1.01);
        }
        
        .visit-counter h6 {
            font-size: 13px;
            margin-bottom: 10px;
        }
        
        .visit-stat {
            font-size: 11px;
            margin: 6px 0;
        }
        
        .visit-number {
            font-size: 12px;
            min-width: 40px;
        }
    }

    @media (max-width: 480px) {
        .visit-counter {
            bottom: 70px;
            left: 10px;
            right: 10px;
            max-width: calc(100% - 20px);
            font-size: 11px;
            padding: 10px 12px;
        }
        
        .visit-counter h6 {
            font-size: 12px;
            margin-bottom: 8px;
        }
        
        .visit-stat {
            font-size: 10px;
            margin: 4px 0;
        }
        
        .visit-number {
            font-size: 11px;
            min-width: 35px;
        }
    }

    /* Ocultar en pantallas muy pequeñas para evitar obstruir contenido */
    @media (max-width: 360px) {
        .visit-counter {
            display: none;
        }
    }
</style>
@endsection

@section('content')

@php
    // Registrar visita y obtener estadísticas
    \App\Models\Visit::registrarVisita(request(), '/');
    $visitStats = \App\Models\Visit::getEstadisticas();
@endphp
<div class="row mb-5">
    <div class="col-lg-12 text-center">
        <h1 class="display-4 fw-bold mb-4 animate-fade-in-up">
            Conectamos a quienes <span class="text-primary">necesitan servicios</span> con <span class="text-primary">profesionales</span>
        </h1>
        <p class="lead animate-fade-in-up stagger-1">
            Nuestra plataforma facilita la conexión entre personas que necesitan soluciones y los profesionales capacitados para proveerlas.
        </p>
        <div class="mt-5 animate-fade-in-up stagger-2">
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-3 animate-pulse">
                    <i class="fas fa-user-plus me-2"></i>Regístrate Gratis
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg animate-pulse">
                    <i class="fas fa-tachometer-alt me-2"></i>Ir a mi Dashboard
                </a>
            @endguest
        </div>
    </div>
</div>

<div class="row mt-5 mb-5">
    <div class="col-lg-4 mb-4">
        <div class="card h-100 text-center p-4 animate-fade-in-left stagger-3">
            <div class="card-body">
                <div class="mb-4">
                    <i class="fas fa-user-plus fa-4x text-primary animate-float"></i>
                </div>
                <h3 class="card-title">Crea tu cuenta</h3>
                <p class="card-text">Regístrate y completa tu perfil con tus datos, preferencias y especialidades.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card h-100 text-center p-4 animate-fade-in-up stagger-4">
            <div class="card-body">
                <div class="mb-4">
                    <i class="fas fa-briefcase fa-4x text-primary animate-float" style="animation-delay: 1s;"></i>
                </div>
                <h3 class="card-title">Ofrece servicios</h3>
                <p class="card-text">Publica tus servicios o encuentra profesionales según tus necesidades.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="card h-100 text-center p-4 animate-fade-in-right stagger-5">
            <div class="card-body">
                <div class="mb-4">
                    <i class="fas fa-handshake fa-4x text-primary animate-float" style="animation-delay: 2s;"></i>
                </div>
                <h3 class="card-title">Conecta</h3>
                <p class="card-text">Gestiona solicitudes, comunícate con otros usuarios y completa transacciones.</p>
            </div>
        </div>
    </div>
</div>

<!-- Servicios Recientes -->
<div class="row my-5">
    <div class="col-lg-12 text-center">
        <h2 class="mb-4">Servicios Recientes</h2>
                                </div>

    @php
        $serviciosRecientes = \App\Models\Servicio::where('disponible', true)
            ->with(['usuario', 'categoria'])
            ->orderBy('id_servicio', 'desc')
            ->take(6)
            ->get();
    @endphp
    
    @foreach($serviciosRecientes as $servicio)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $servicio->titulo }}</h5>
                    <p class="card-text">{{ Str::limit($servicio->descripcion, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-info">{{ $servicio->categoria->nombre }}</span>
                        <strong class="text-primary">${{ number_format($servicio->precio, 2) }}</strong>
                                </div>
                    <p class="small mt-2 mb-0">
                        <i class="fas fa-user me-1"></i> {{ $servicio->usuario->nombre }} {{ $servicio->usuario->apellidos }}
                                    </p>
                                </div>
                <div class="card-footer bg-white border-0">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">
                            <i class="fas fa-sign-in-alt me-1"></i> Inicia sesión para ver detalles
                        </a>
                    @else
                        <a href="{{ route('servicios.show', $servicio) }}" class="btn btn-primary w-100">
                            <i class="fas fa-info-circle me-1"></i> Ver detalles
                        </a>
                    @endguest
                                </div>
                                </div>
                            </div>
    @endforeach
</div>

<div class="row my-5 py-5 bg-light rounded-3">
    <div class="col-lg-12 text-center">
        <h2 class="mb-4">Categorías de servicios disponibles</h2>
        <div class="row justify-content-center">
            @php
                $categorias = \App\Models\Categoria::where('activo', true)->take(8)->get();
            @endphp
            
            @foreach($categorias as $categoria)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-tag fa-2x mb-3 text-primary"></i>
                            <h5 class="card-title">{{ $categoria->nombre }}</h5>
                            <p class="card-text small text-muted">{{ Str::limit($categoria->descripcion, 60) }}</p>
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary">Ver servicios</a>
                            @else
                                <a href="{{ route('servicios.categoria', $categoria) }}" class="btn btn-sm btn-outline-primary">Ver servicios</a>
                            @endguest
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row my-5">
    <div class="col-lg-12 text-center">
        <h2 class="mb-5">¿Por qué elegir nuestra plataforma?</h2>
    </div>
    <div class="col-md-6 mb-4">
        <div class="d-flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle fa-2x text-primary me-3"></i>
            </div>
            <div>
                <h4>Conexiones confiables</h4>
                <p>Todas las cuentas son verificadas y los servicios cuentan con valoraciones de usuarios reales.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="d-flex">
            <div class="flex-shrink-0">
                <i class="fas fa-lock fa-2x text-primary me-3"></i>
            </div>
            <div>
                <h4>Seguridad</h4>
                <p>Tu información personal está segura y las transacciones son confidenciales.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="d-flex">
            <div class="flex-shrink-0">
                <i class="fas fa-heart fa-2x text-primary me-3"></i>
            </div>
            <div>
                <h4>Personalización</h4>
                <p>Define tus preferencias y especialidades para encontrar los servicios más relevantes.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="d-flex">
            <div class="flex-shrink-0">
                <i class="fas fa-comments fa-2x text-primary me-3"></i>
            </div>
            <div>
                <h4>Comunicación directa</h4>
                <p>Sistema de mensajería integrado para coordinación simple entre las partes.</p>
            </div>
        </div>
    </div>
</div>

<div class="row my-5 py-5 bg-primary text-white rounded-3">
    <div class="col-lg-8 mx-auto text-center">
        <h2 class="mb-4">¿Listo para comenzar?</h2>
        <p class="lead mb-4">Ya sea que estés buscando ofrecer tus servicios o encontrar a un profesional, nuestra plataforma te ayudará a conectar con las personas adecuadas.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">Únete Ahora</a>
        @else
            <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">Ir a mi Dashboard</a>
        @endguest
    </div>
</div>

<!-- Contador de Visitas -->
<div class="visit-counter" id="visit-counter" role="region" aria-label="Estadísticas de visitas">
    <h6>
        <i class="fas fa-chart-line me-2" aria-hidden="true"></i>
        Estadísticas de Visitas
    </h6>
    <div class="visit-stat">
        <span>Total de visitas:</span>
        <span class="visit-number" id="total-visits">{{ number_format($visitStats['total']) }}</span>
    </div>
    <div class="visit-stat">
        <span>Hoy:</span>
        <span class="visit-number" id="today-visits">{{ number_format($visitStats['hoy']) }}</span>
    </div>
    <div class="visit-stat">
        <span>Esta semana:</span>
        <span class="visit-number" id="week-visits">{{ number_format($visitStats['semana']) }}</span>
    </div>
    <div class="visit-stat">
        <span>Este mes:</span>
        <span class="visit-number" id="month-visits">{{ number_format($visitStats['mes']) }}</span>
    </div>
    <div class="visit-stat">
        <span>Páginas vistas:</span>
        <span class="visit-number" id="page-views">{{ number_format($visitStats['total_paginas_vistas']) }}</span>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación de contador con números
    function animateCounter(element, finalValue) {
        const startValue = 0;
        const duration = 2000;
        const increment = finalValue / (duration / 16);
        let currentValue = startValue;
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }
            element.textContent = Math.floor(currentValue).toLocaleString();
        }, 16);
    }

    // Animar contadores cuando se carga la página
    setTimeout(() => {
        const totalElement = document.getElementById('total-visits');
        const todayElement = document.getElementById('today-visits');
        const weekElement = document.getElementById('week-visits');
        const monthElement = document.getElementById('month-visits');
        const pageViewsElement = document.getElementById('page-views');
        
        if (totalElement) {
            animateCounter(totalElement, {{ $visitStats['total'] }});
        }
        if (todayElement) {
            animateCounter(todayElement, {{ $visitStats['hoy'] }});
        }
        if (weekElement) {
            animateCounter(weekElement, {{ $visitStats['semana'] }});
        }
        if (monthElement) {
            animateCounter(monthElement, {{ $visitStats['mes'] }});
        }
        if (pageViewsElement) {
            animateCounter(pageViewsElement, {{ $visitStats['total_paginas_vistas'] }});
        }
    }, 1000);

    // Efecto parallax sutil en el scroll
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.animate-float');
        
        parallaxElements.forEach((element, index) => {
            const speed = 0.5 + (index * 0.1);
            element.style.transform = `translateY(${scrolled * speed}px) translateY(-10px)`;
        });
    });

    // Intersection Observer para activar animaciones cuando los elementos son visibles
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, observerOptions);

    // Observar todos los elementos con animaciones
    document.querySelectorAll('[class*="animate-"]').forEach(el => {
        el.style.animationPlayState = 'paused';
        observer.observe(el);
    });

    // Mejorar la accesibilidad del contador
    const visitCounter = document.getElementById('visit-counter');
    if (visitCounter) {
        visitCounter.setAttribute('tabindex', '0');
        visitCounter.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                // Anunciar las estadísticas a lectores de pantalla
                const announcement = `Estadísticas de visitas: Total ${{{ $visitStats['total'] }}}, Hoy ${{{ $visitStats['hoy'] }}}, Esta semana ${{{ $visitStats['semana'] }}}, Este mes ${{{ $visitStats['mes'] }}}`;
                
                // Crear región live para anuncio
                let liveRegion = document.getElementById('stats-live-region');
                if (!liveRegion) {
                    liveRegion = document.createElement('div');
                    liveRegion.id = 'stats-live-region';
                    liveRegion.setAttribute('aria-live', 'polite');
                    liveRegion.className = 'sr-only';
                    document.body.appendChild(liveRegion);
                }
                liveRegion.textContent = announcement;
                
                setTimeout(() => {
                    liveRegion.textContent = '';
                }, 3000);
            }
        });
    }

    console.log('✅ Animaciones de landing page inicializadas');
});
</script>
@endsection

