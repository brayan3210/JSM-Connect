@extends('layouts.admin')

@section('title', 'Gestión de Logs')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-3 col-md-4">
            @include('layouts.admin-sidebar')
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
                <h1 class="h3 mb-2 mb-md-0 text-gray-800">
                    <i class="fas fa-file-alt me-2"></i>Gestión de Logs
                </h1>
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <button type="button" class="btn btn-sm" style="background-color: #104CFF; color: white;" 
                            data-bs-toggle="modal" data-bs-target="#limpiarModal">
                        <i class="fas fa-trash-alt"></i> Limpiar Logs
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Estadísticas generales -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #0D6EFD;">
                                        Total Usuarios</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsuarios }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Total Logs</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLogs }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Con Actividad</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $usuariosConLogs }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card shadow h-100 py-2" style="border-left: 4px solid #104CFF;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: #104CFF;">
                                        Logs Hoy</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $logsHoy }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #0D6EFD;">
                        <i class="fas fa-filter me-2"></i>Filtros de búsqueda
                    </h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.logs.index') }}">
                        <div class="row g-3">
                            <div class="col-md-4 col-sm-6">
                                <label for="buscar" class="form-label">Buscar usuario</label>
                                <input type="text" name="buscar" id="buscar" class="form-control" 
                                       value="{{ request('buscar') }}" placeholder="Nombre, email...">
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label for="tipo_usuario" class="form-label">Tipo de usuario</label>
                                <select name="tipo_usuario" id="tipo_usuario" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="admin" {{ request('tipo_usuario') == 'admin' ? 'selected' : '' }}>Administradores</option>
                                    <option value="usuario" {{ request('tipo_usuario') == 'usuario' ? 'selected' : '' }}>Usuarios</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <label for="con_logs" class="form-label">Actividad</label>
                                <select name="con_logs" id="con_logs" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="si" {{ request('con_logs') == 'si' ? 'selected' : '' }}>Con logs</option>
                                    <option value="no" {{ request('con_logs') == 'no' ? 'selected' : '' }}>Sin logs</option>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6 d-flex align-items-end">
                                <button type="submit" class="btn w-100" style="background-color: #104CFF; color: white;">
                                    <i class="fas fa-search"></i> <span class="d-none d-sm-inline">Filtrar</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lista de usuarios -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #0D6EFD;">
                        <i class="fas fa-users me-2"></i>Usuarios del Sistema ({{ $usuarios->total() }} encontrados)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Usuario</th>
                                    <th class="d-none d-md-table-cell">Email</th>
                                    <th class="d-none d-lg-table-cell">Tipo</th>
                                    <th>Logs</th>
                                    <th class="d-none d-lg-table-cell">Último Acceso</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($usuarios as $usuario)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 40px; height: 40px; font-size: 16px; background-color: {{ $usuario->es_admin ? '#ffc107' : '#0D6EFD' }};">
                                                    <i class="fas {{ $usuario->es_admin ? 'fa-user-shield' : 'fa-user' }}"></i>
                                                </div>
                                                <div>
                                                    <strong>{{ $usuario->nombre }} {{ $usuario->apellidos }}</strong>
                                                    @if(!$usuario->activo)
                                                        <br><small class="badge" style="background-color: #104CFF; color:white;">Inactivo</small>
                                                    @endif
                                                    <div class="d-md-none mt-1">
                                                        <small class="text-muted">{{ $usuario->email }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            {{ $usuario->email }}
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            @if($usuario->es_admin)
                                                <span class="badge" style="background-color: #ffc107; color: #000;">
                                                    <i class="fas fa-user-shield me-1"></i>Administrador
                                                </span>
                                            @else
                                                <span class="badge badge-info">
                                                    <i class="fas fa-user me-1"></i>Usuario
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($usuario->logs_count > 0)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check me-1"></i>{{ $usuario->logs_count }}
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-minus me-1"></i>0
                                                </span>
                                            @endif
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            @if($usuario->ultimo_log)
                                                <div>
                                                    <strong>{{ $usuario->ultimo_log->format('d/m/Y') }}</strong><br>
                                                    <small class="text-muted">{{ $usuario->ultimo_log->format('H:i') }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted">Nunca</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($usuario->logs_count > 0)
                                                <a href="{{ route('admin.logs.show', $usuario) }}" 
                                                   class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i> <span class="d-none d-sm-inline">Ver Logs</span>
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            No se encontraron usuarios con los filtros aplicados.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $usuarios->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para limpiar logs -->
<div class="modal fade" id="limpiarModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-trash-alt me-2"></i>Limpiar Logs Antiguos
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.logs.limpiar') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>¡Atención!</strong> Esta acción no se puede deshacer.
                    </div>
                    <p>Se eliminarán todos los logs anteriores al período seleccionado:</p>
                    <div class="mb-3">
                        <label for="meses" class="form-label">Eliminar logs anteriores a:</label>
                        <select name="meses" id="meses" class="form-control" required>
                            <option value="">Seleccionar período</option>
                            <option value="1">1 mes</option>
                            <option value="2">2 meses</option>
                            <option value="3">3 meses</option>
                            <option value="6">6 meses</option>
                            <option value="12">1 año</option>
                        </select>
                    </div>
                    <p class="text-muted small">
                        <i class="fas fa-info-circle me-1"></i>
                        Esta operación mantendrá los logs más recientes y eliminará solo los antiguos.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn" style="background-color: #104CFF; color: white;">
                        <i class="fas fa-trash-alt me-1"></i>Limpiar Logs
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 