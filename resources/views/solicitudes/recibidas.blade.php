@extends('layouts.app')

@section('title', 'Solicitudes Recibidas')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Solicitudes Recibidas</h1>
                <a href="{{ route('solicitudes.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="card shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h5 class="mb-0">Todas las solicitudes recibidas</h5>
                        </div>
                        <div class="col-auto">
                            <div class="dropdown">
                                <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filtrar por estado
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.recibidas') }}">Todos</a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.recibidas', ['estado' => 'pendiente']) }}">Pendientes</a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.recibidas', ['estado' => 'aceptada']) }}">Aceptadas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.recibidas', ['estado' => 'rechazada']) }}">Rechazadas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.recibidas', ['estado' => 'completada']) }}">Completadas</a></li>
                                    <li><a class="dropdown-item" href="{{ route('solicitudes.recibidas', ['estado' => 'cancelada']) }}">Canceladas</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($recibidas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Servicio</th>
                                        <th>Solicitante</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recibidas as $solicitud)
                                        <tr>
                                            <td>{{ $solicitud->servicio->titulo }}</td>
                                            <td>{{ $solicitud->usuario_solicitante->nombre }} {{ $solicitud->usuario_solicitante->apellidos }}</td>
                                            <td>{{ $solicitud->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                @php
                                                    $badgeClass = [
                                                        'pendiente' => 'bg-warning',
                                                        'aceptada' => 'bg-success',
                                                        'rechazada' => 'bg-danger',
                                                        'completada' => 'bg-info',
                                                        'cancelada' => 'bg-secondary'
                                                    ][$solicitud->estado] ?? 'bg-secondary';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ ucfirst($solicitud->estado) }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('solicitudes.show', $solicitud) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> Ver
                                                </a>
                                                
                                                @if($solicitud->estado === 'pendiente')
                                                <div class="btn-group mt-1">
                                                    <form action="{{ route('solicitudes.estado', $solicitud) }}" method="POST" class="me-1">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="estado" value="aceptada">
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check me-1"></i> Aceptar
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('solicitudes.estado', $solicitud) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="estado" value="rechazada">
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-times me-1"></i> Rechazar
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif
                                                
                                                @if($solicitud->estado === 'aceptada')
                                                <form action="{{ route('solicitudes.estado', $solicitud) }}" method="POST" class="mt-1">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="estado" value="completada">
                                                    <button type="submit" class="btn btn-sm btn-info">
                                                        <i class="fas fa-check-double me-1"></i> Marcar como completada
                                                    </button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $recibidas->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <img src="{{ asset('images/empty.svg') }}" alt="No hay solicitudes" class="img-fluid mb-3" style="max-height: 150px;">
                            <h5>No has recibido ninguna solicitud</h5>
                            <p class="text-muted">Cuando alguien solicite tus servicios, aparecerá aquí.</p>
                            <a href="{{ route('servicios.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus-circle me-1"></i> Ofrecer un nuevo servicio
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 