@extends('layouts.admin')

@section('title', 'Detalles del Usuario')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Detalles del Usuario</h1>
                <div>
                    <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Información Personal -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Información Personal</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Acciones:</div>
                                    <a class="dropdown-item" href="{{ route('admin.usuarios.edit', $usuario) }}">
                                        <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Editar Usuario
                                    </a>
                                    @if($usuario->activo)
                                        <form method="POST" action="{{ route('admin.usuarios.desactivar', $usuario) }}" class="d-inline" onsubmit="return confirmarDesactivacionUsuario('{{ addslashes($usuario->nombre) }} {{ addslashes($usuario->apellidos) }}', '{{ addslashes($usuario->email) }}')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-user-slash fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Desactivar
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.usuarios.activar', $usuario) }}" class="d-inline" onsubmit="return confirmarActivacionUsuario('{{ addslashes($usuario->nombre) }} {{ addslashes($usuario->apellidos) }}', '{{ addslashes($usuario->email) }}')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="dropdown-item text-success">
                                                <i class="fas fa-user-check fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Activar
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="font-weight-bold text-gray-800">Nombre Completo:</label>
                                        <p class="text-gray-600">{{ $usuario->nombre }} {{ $usuario->apellidos }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="font-weight-bold text-gray-800">Documento:</label>
                                        <p class="text-gray-600">{{ $usuario->tipo_documento }}: {{ $usuario->numero_documento }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="font-weight-bold text-gray-800">Email:</label>
                                        <p class="text-gray-600">{{ $usuario->email }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="font-weight-bold text-gray-800">Teléfono:</label>
                                        <p class="text-gray-600">{{ $usuario->telefono }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="font-weight-bold text-gray-800">Género:</label>
                                        <p class="text-gray-600">{{ $usuario->genero }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="font-weight-bold text-gray-800">Profesión:</label>
                                        <p class="text-gray-600">{{ $usuario->profesion ?? 'No especificada' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="font-weight-bold text-gray-800">Estado:</label>
                                        <p>
                                            @if($usuario->activo)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-danger">Inactivo</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="mb-3">
                                        <label class="font-weight-bold text-gray-800">Fecha de Registro:</label>
                                        <p class="text-gray-600">{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'No disponible' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas del Usuario -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Estadísticas</h6>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center mb-3">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Servicios Ofrecidos</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $servicios->total() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            
                            <div class="row no-gutters align-items-center mb-3">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Solicitudes Recibidas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $solicitudesRecibidas->total() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-inbox fa-2x text-gray-300"></i>
                                </div>
                            </div>
                            
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Solicitudes Realizadas</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $solicitudesEnviadas->total() }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-paper-plane fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Servicios Ofrecidos -->
            @if($servicios->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Servicios Ofrecidos</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($servicios as $servicio)
                                <tr>
                                    <td>{{ $servicio->titulo }}</td>
                                    <td>
                                        @if($servicio->categoria)
                                            <span class="badge badge-info">{{ $servicio->categoria->nombre }}</span>
                                        @else
                                            <span class="text-muted">Sin categoría</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($servicio->precio, 0, ',', '.') }}</td>
                                    <td>
                                        @if($servicio->disponible)
                                            <span class="badge badge-success">Disponible</span>
                                        @else
                                            <span class="badge badge-danger">No disponible</span>
                                        @endif
                                    </td>
                                    <td>{{ $servicio->created_at ? $servicio->created_at->format('d/m/Y') : 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $servicios->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Solicitudes Recientes -->
            @if($solicitudesRecibidas->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Solicitudes Recibidas Recientes</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Servicio</th>
                                    <th>Solicitante</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($solicitudesRecibidas as $solicitud)
                                <tr>
                                    <td>{{ $solicitud->servicio ? $solicitud->servicio->titulo : 'Servicio eliminado' }}</td>
                                    <td>{{ $solicitud->usuario ? $solicitud->usuario->nombre : 'Usuario eliminado' }}</td>
                                    <td>
                                        @switch($solicitud->estado)
                                            @case('pendiente')
                                                <span class="badge badge-warning">Pendiente</span>
                                                @break
                                            @case('aceptada')
                                                <span class="badge badge-success">Aceptada</span>
                                                @break
                                            @case('rechazada')
                                                <span class="badge badge-danger">Rechazada</span>
                                                @break
                                            @case('completada')
                                                <span class="badge badge-info">Completada</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $solicitud->estado }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $solicitud->created_at ? $solicitud->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $solicitudesRecibidas->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Funciones para confirmar activación/desactivación de usuario
    function confirmarDesactivacionUsuario(nombre, email) {
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

    function confirmarActivacionUsuario(nombre, email) {
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

    // Confirmación general para acciones
    function confirmarAccion(mensaje) {
        return confirm(mensaje);
    }
</script>
@endsection 