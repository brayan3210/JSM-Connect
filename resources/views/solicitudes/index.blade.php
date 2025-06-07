@extends('layouts.app')

@section('title', 'Mis Solicitudes')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            @include('layouts.sidebar')
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">Mis Solicitudes</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Pestañas -->
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active" id="recibidas-tab" data-bs-toggle="tab" href="#recibidas">Solicitudes Recibidas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="enviadas-tab" data-bs-toggle="tab" href="#enviadas">Solicitudes Enviadas</a>
                </li>
            </ul>
            
            <!-- Contenido de pestañas -->
            <div class="tab-content">
                <!-- Solicitudes Recibidas -->
                <div class="tab-pane fade show active" id="recibidas">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Solicitudes Recibidas</h5>
                            <a href="{{ route('solicitudes.recibidas') }}" class="btn btn-sm btn-primary">Ver Todas</a>
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
                                            @foreach($recibidas->take(5) as $solicitud)
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
                                                        <a href="{{ route('solicitudes.show', $solicitud) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <p>No has recibido solicitudes.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Solicitudes Enviadas -->
                <div class="tab-pane fade" id="enviadas">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Solicitudes Enviadas</h5>
                            <a href="{{ route('solicitudes.enviadas') }}" class="btn btn-sm btn-primary">Ver Todas</a>
                        </div>
                        <div class="card-body">
                            @if($enviadas->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Servicio</th>
                                                <th>Proveedor</th>
                                                <th>Fecha</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($enviadas->take(5) as $solicitud)
                                                <tr>
                                                    <td>{{ $solicitud->servicio->titulo }}</td>
                                                    <td>{{ $solicitud->usuario_proveedor->nombre }} {{ $solicitud->usuario_proveedor->apellidos }}</td>
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
                                                        <a href="{{ route('solicitudes.show', $solicitud) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <p>No has enviado solicitudes.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 