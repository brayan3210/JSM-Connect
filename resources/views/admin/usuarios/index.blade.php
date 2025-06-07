@extends('layouts.admin')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-3 col-md-4">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <div>
                    <h1 class="h3 mb-1 text-gray-800">
                        <i class="fas fa-users me-2 text-primary"></i>Gestión de Usuarios
                    </h1>
                    <p class="text-muted mb-0">Administra y supervisa todos los usuarios del sistema</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="location.reload()">
                        <i class="fas fa-sync-alt me-1"></i>Actualizar
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-download me-1"></i>Exportar
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2"></i>PDF</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Filtros y búsqueda -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-filter me-2"></i>Filtros de Búsqueda
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.usuarios.index') }}" id="filtrosForm">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="form-label">Buscar</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control" name="buscar" 
                                           placeholder="Nombre, email, documento..." 
                                           value="{{ request('buscar') }}">
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6 mb-3">
                                <label class="form-label">Género</label>
                                <select name="genero" class="form-select">
                                    <option value="">Todos</option>
                                    @foreach($generos as $genero)
                                        <option value="{{ $genero->genero }}" {{ request('genero') == $genero->genero ? 'selected' : '' }}>
                                            {{ $genero->genero }} ({{ $genero->total }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-6 mb-3">
                                <label class="form-label">Profesión</label>
                                <select name="profesion" class="form-select">
                                    <option value="">Todas</option>
                                    @foreach($profesiones->take(10) as $prof)
                                        <option value="{{ $prof->profesion }}" {{ request('profesion') == $prof->profesion ? 'selected' : '' }}>
                                            {{ Str::limit($prof->profesion ?: 'Sin especificar', 20) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-6 mb-3">
                                <label class="form-label">Estado</label>
                                <select name="estado" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                                    <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivos</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-12 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div class="btn-group w-100 d-flex" role="group">
                                    <button type="submit" class="btn btn-primary flex-fill">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary flex-fill">
                                        <i class="fas fa-times"></i> Limpiar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Usuarios</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $estadisticas['total'] }}">0</div>
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-users"></i> Registrados
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-success shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Usuarios Activos</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $estadisticas['activos'] }}">0</div>
                                    <div class="small text-success mt-1">
                                        <i class="fas fa-check-circle"></i> {{ number_format(($estadisticas['activos'] / max($estadisticas['total'], 1)) * 100, 1) }}%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-user-check text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-info shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Administradores</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $estadisticas['admins'] }}">0</div>
                                    <div class="small text-info mt-1">
                                        <i class="fas fa-shield-alt"></i> Con privilegios
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-user-shield text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2 card-hover">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Nuevos este mes</div>
                                    <div class="h4 mb-0 font-weight-bold text-gray-800 counter" data-target="{{ $estadisticas['nuevos_mes'] }}">0</div>
                                    <div class="small text-warning mt-1">
                                        <i class="fas fa-calendar-plus"></i> Registros recientes
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-user-plus text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de usuarios -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-table me-2"></i>Lista de Usuarios
                    </h6>
                    <div class="d-flex align-items-center">
                        <span class="text-muted me-3">{{ $usuarios->total() }} usuarios encontrados</span>
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-primary active" id="vistaTabla" title="Vista de tabla">
                                <i class="fas fa-table"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary" id="vistaCards" title="Vista de tarjetas">
                                <i class="fas fa-th-large"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($usuarios->count() > 0)
                        <!-- Vista de tabla -->
                        <div id="tablaUsuarios" class="table-responsive">
                            <table class="table table-hover" width="100%" cellspacing="0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Contacto</th>
                                        <th>Profesión</th>
                                        <th>Estado</th>
                                        <th>Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $usuario)
                                        <tr>
                                            <td class="text-center">
                                                <span class="badge bg-secondary">{{ $usuario->id_usuario }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-title bg-primary rounded-circle">
                                                            {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $usuario->nombre ?? 'Usuario' }} {{ $usuario->apellidos ?? '' }}</h6>
                                                        <small class="text-muted">
                                                            {{ $usuario->tipo_documento ?? 'Doc' }}: {{ $usuario->numero_documento ?? 'N/A' }}
                                                        </small>
                                                        <br>
                                                        <small class="text-muted">
                                                            @if($usuario->genero == 'Masculino')
                                                                <i class="fas fa-mars text-primary"></i> Masculino
                                                            @elseif($usuario->genero == 'Femenino')
                                                                <i class="fas fa-venus text-pink"></i> Femenino
                                                            @else
                                                                <i class="fas fa-genderless text-secondary"></i> {{ $usuario->genero ?? 'No especificado' }}
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <i class="fas fa-envelope text-primary"></i> 
                                                    <a href="mailto:{{ $usuario->email ?? '' }}">{{ $usuario->email ?? 'Sin email' }}</a>
                                                </div>
                                                @if($usuario->telefono)
                                                    <div class="mt-1">
                                                        <i class="fas fa-phone text-success"></i> 
                                                        <a href="tel:{{ $usuario->telefono }}">{{ $usuario->telefono }}</a>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($usuario->profesion)
                                                    <span class="badge bg-info">{{ Str::limit($usuario->profesion, 20) }}</span>
                                                @else
                                                    <span class="text-muted">No especificada</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($usuario->activo ?? true)
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle"></i> Activo
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-times-circle"></i> Inactivo
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($usuario->created_at)
                                                    <div>{{ $usuario->created_at->format('d/m/Y') }}</div>
                                                    <small class="text-muted">{{ $usuario->created_at->format('H:i') }}</small>
                                                @else
                                                    <span class="text-muted">No disponible</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.usuarios.show', $usuario) }}" 
                                                       class="btn btn-info btn-sm" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}" 
                                                       class="btn btn-warning btn-sm" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($usuario->activo ?? true)
                                                        <form method="POST" action="{{ route('admin.usuarios.desactivar', $usuario) }}" class="d-inline" onsubmit="return confirmarDesactivacionSync('{{ addslashes($usuario->nombre) }} {{ addslashes($usuario->apellidos) }}', '{{ addslashes($usuario->email) }}')">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Desactivar">
                                                                <i class="fas fa-user-slash"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form method="POST" action="{{ route('admin.usuarios.activar', $usuario) }}" class="d-inline" onsubmit="return confirmarActivacionSync('{{ addslashes($usuario->nombre) }} {{ addslashes($usuario->apellidos) }}', '{{ addslashes($usuario->email) }}')">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-success btn-sm" title="Activar">
                                                                <i class="fas fa-user-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Vista de tarjetas (oculta por defecto) -->
                        <div id="cardsUsuarios" class="row" style="display: none;">
                            @foreach($usuarios as $usuario)
                                <div class="col-xl-4 col-lg-6 col-md-12 mb-4">
                                    <div class="card h-100 shadow-sm card-hover">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar-lg me-3">
                                                    <div class="avatar-title bg-primary rounded-circle">
                                                        {{ strtoupper(substr($usuario->nombre ?? 'U', 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1">{{ $usuario->nombre ?? 'Usuario' }} {{ $usuario->apellidos ?? '' }}</h6>
                                                    <p class="text-muted mb-0">{{ $usuario->email ?? 'Sin email' }}</p>
                                                </div>
                                                <div>
                                                    @if($usuario->activo ?? true)
                                                        <span class="badge bg-success">Activo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactivo</span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-id-card"></i> {{ $usuario->numero_documento ?? 'N/A' }}
                                                </small>
                                                @if($usuario->telefono)
                                                    <small class="text-muted d-block">
                                                        <i class="fas fa-phone"></i> {{ $usuario->telefono }}
                                                    </small>
                                                @endif
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-briefcase"></i> {{ $usuario->profesion ?? 'No especificada' }}
                                                </small>
                                                <small class="text-muted d-block">
                                                    @if($usuario->genero == 'Masculino')
                                                        <i class="fas fa-mars text-primary"></i> Masculino
                                                    @elseif($usuario->genero == 'Femenino')
                                                        <i class="fas fa-venus text-pink"></i> Femenino
                                                    @else
                                                        <i class="fas fa-genderless text-secondary"></i> {{ $usuario->genero ?? 'No especificado' }}
                                                    @endif
                                                </small>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.usuarios.show', $usuario) }}" 
                                                       class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.usuarios.edit', $usuario) }}" 
                                                       class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                                <small class="text-muted align-self-center">
                                                    {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'N/A' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Paginación -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <p class="text-muted mb-0">
                                    Mostrando {{ $usuarios->firstItem() }} a {{ $usuarios->lastItem() }} 
                                    de {{ $usuarios->total() }} usuarios
                                </p>
                            </div>
                            <div>
                                {{ $usuarios->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5>No se encontraron usuarios</h5>
                            <p class="text-muted">Intenta ajustar los filtros de búsqueda.</p>
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-primary">
                                <i class="fas fa-refresh"></i> Ver todos los usuarios
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Estilos mejorados */
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }

    .card-hover {
        transition: all 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }

    .icon-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .counter {
        color: #5a5c69;
    }

    .avatar-sm {
        width: 35px;
        height: 35px;
    }
    .avatar-lg {
        width: 50px;
        height: 50px;
    }
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        width: 100%;
        height: 100%;
        font-size: 14px;
    }

    .table th {
        border-top: none;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .text-pink {
        color: #e91e63 !important;
    }

    .btn-group .btn {
        margin-right: 2px;
    }
    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animación de contadores
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000;
        const step = target / (duration / 16);
        let current = 0;
        
        const timer = setInterval(() => {
            current += step;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current).toLocaleString();
        }, 16);
    }

    // Inicializar contadores
    document.querySelectorAll('.counter').forEach(counter => {
        animateCounter(counter);
    });

    // Cambio de vista entre tabla y tarjetas
    const vistaTabla = document.getElementById('vistaTabla');
    const vistaCards = document.getElementById('vistaCards');
    const tablaUsuarios = document.getElementById('tablaUsuarios');
    const cardsUsuarios = document.getElementById('cardsUsuarios');

    if (vistaTabla && vistaCards && tablaUsuarios && cardsUsuarios) {
        vistaTabla.addEventListener('click', function() {
            tablaUsuarios.style.display = 'block';
            cardsUsuarios.style.display = 'none';
            vistaTabla.classList.add('active');
            vistaCards.classList.remove('active');
        });

        vistaCards.addEventListener('click', function() {
            tablaUsuarios.style.display = 'none';
            cardsUsuarios.style.display = 'block';
            vistaCards.classList.add('active');
            vistaTabla.classList.remove('active');
        });
    }

    // Auto-submit del formulario de filtros cuando cambian los selects
    const filtrosForm = document.getElementById('filtrosForm');
    if (filtrosForm) {
        const selects = filtrosForm.querySelectorAll('select');
        selects.forEach(select => {
            select.addEventListener('change', function() {
                filtrosForm.submit();
            });
        });
    }
});

// Funciones síncronas para confirmar acciones (compatibles con onsubmit)
function confirmarDesactivacionSync(nombre, email) {
    const mensaje = `¿Estás seguro de que deseas DESACTIVAR al usuario?\n\n` +
                   `Usuario: ${nombre}\n` +
                   `Email: ${email}\n\n` +
                   `⚠️ ADVERTENCIA:\n` +
                   `• El usuario no podrá iniciar sesión\n` +
                   `• Su perfil y servicios se ocultarán\n` +
                   `• Deberá ser reactivado manualmente\n\n` +
                   `¿Continuar con la desactivación?`;
    
    return confirm(mensaje);
}

function confirmarActivacionSync(nombre, email) {
    const mensaje = `¿Estás seguro de que deseas ACTIVAR al usuario?\n\n` +
                   `Usuario: ${nombre}\n` +
                   `Email: ${email}\n\n` +
                   `✅ CONFIRMACIÓN:\n` +
                   `• El usuario podrá iniciar sesión nuevamente\n` +
                   `• Su perfil y servicios serán visibles\n` +
                   `• Recuperará acceso completo a la plataforma\n\n` +
                   `¿Continuar con la activación?`;
    
    return confirm(mensaje);
}
</script>
@endsection 