<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Plataforma de Servicios') }} - @yield('title', 'Conectando Profesionales y Clientes')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Accessibility Styles -->
    <link rel="stylesheet" href="{{ asset('css/accessibility.css') }}">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: #4f46e5;
        }
        
        .main-container {
            flex: 1;
        }
        
        .btn-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
        }
        
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
        }
        
        footer {
            background-color: #212529;
            color: #f8f9fa;
            padding: 2rem 0;
            margin-top: auto;
        }
        
        .badge-primary {
            background-color: #4f46e5;
        }
        
        .alert-success {
            background-color: #d1fae5;
            border-color: #a7f3d0;
            color: #047857;
        }
        
        .alert-danger {
            background-color: #fee2e2;
            border-color: #fecaca;
            color: #b91c1c;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(79, 70, 229, 0.05);
        }
        
        .nav-link.active {
            color: #4f46e5 !important;
            font-weight: 500;
        }
        
        .form-control:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 0.25rem rgba(79, 70, 229, 0.25);
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Skip Links for Accessibility -->
    <a href="#main-content" class="skip-link">Saltar al contenido principal</a>
    <a href="#accessibility-menu" class="skip-link">Herramientas de accesibilidad</a>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-handshake me-2"></i>JSM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @else
                        @if(auth()->user()->esAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-chart-line me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}" href="{{ route('admin.usuarios.index') }}">
                                    <i class="fas fa-users me-1"></i>Usuarios
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}" href="{{ route('admin.categorias.index') }}">
                                    <i class="fas fa-tags me-1"></i>Categorías
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.estadisticas.*') ? 'active' : '' }}" href="{{ route('admin.estadisticas.index') }}">
                                    <i class="fas fa-chart-pie me-1"></i>Estadísticas
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="fas fa-home me-1"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('servicios.*') ? 'active' : '' }}" href="{{ route('servicios.index') }}">
                                    <i class="fas fa-briefcase me-1"></i>Mis Servicios
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('solicitudes.*') ? 'active' : '' }}" href="{{ route('solicitudes.index') }}">
                                    <i class="fas fa-clipboard-list me-1"></i>Solicitudes
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('mensajes.*') ? 'active' : '' }}" href="{{ route('mensajes.index') }}">
                                    <i class="fas fa-envelope me-1"></i>Mensajes
                                    @php
                                        $noLeidos = auth()->user()->mensajesRecibidos()->where('leido', false)->count();
                                    @endphp
                                    @if($noLeidos > 0)
                                        <span class="badge rounded-pill bg-danger">{{ $noLeidos }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('buscar') ? 'active' : '' }}" href="{{ route('buscar') }}">
                                    <i class="fas fa-search me-1"></i>Buscar
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->nombre }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                @if(!auth()->user()->esAdmin())
                                    <li>
                                        <a class="dropdown-item" href="{{ route('perfil.show') }}">
                                            <i class="fas fa-user me-1"></i>Mi Perfil
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('perfil.preferencias') }}">
                                            <i class="fas fa-heart me-1"></i>Mis Preferencias
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('perfil.especialidades') }}">
                                            <i class="fas fa-star me-1"></i>Mis Especialidades
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-1"></i>Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container py-4">
        <div class="container" id="main-content">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>{{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>Se han encontrado errores en el formulario
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center text-lg-start">
        <div class="container p-4">
            <div class="row">
                <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
                    <h5 class="text-uppercase">JSM</h5>
                    <p>
                        Conectando profesionales y clientes a través de una plataforma simple, segura y eficiente.
                        Encuentra el servicio que necesitas o comparte tus habilidades con quienes las requieren.
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Enlaces</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-decoration-none text-white">Inicio</a>
                        </li>
                        @guest
                            <li class="mb-2">
                                <a href="{{ route('login') }}" class="text-decoration-none text-white">Iniciar Sesión</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('register') }}" class="text-decoration-none text-white">Registrarse</a>
                            </li>
                        @else
                            <li class="mb-2">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-white">Dashboard</a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ route('perfil.show') }}" class="text-decoration-none text-white">Mi Perfil</a>
                            </li>
                        @endguest
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase">Contacto</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <a href="mailto:info@plataforma.com" class="text-decoration-none text-white">
                                <i class="fas fa-envelope me-2"></i>info@plataforma.com
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="tel:+123456789" class="text-decoration-none text-white">
                                <i class="fas fa-phone me-2"></i>+1 (234) 567-89
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="#" class="text-decoration-none text-white">
                                <i class="fas fa-map-marker-alt me-2"></i>Ciudad, País
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © {{ date('Y') }} Copyright:
            <a class="text-white text-decoration-none" href="{{ route('home') }}">JSM</a>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (for specific functionality) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Accessibility JavaScript -->
    <script src="{{ asset('js/accessibility.js') }}"></script>
    
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
    
    @yield('scripts')
</body>
</html> 