@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ $usuario->nombre }} {{ $usuario->apellidos }}</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-user-circle fa-7x text-primary"></i>
                </div>
                <h6 class="card-subtitle mb-2 text-muted">{{ $usuario->profesion }}</h6>
                <p class="card-text"><i class="fas fa-phone me-2"></i> {{ $usuario->telefono }}</p>
                <p class="card-text"><i class="fas fa-envelope me-2"></i> {{ $usuario->email }}</p>
            </div>
        </div>
        
        <div class="list-group mt-4 shadow">
            <a href="{{ route('perfil.show') }}" class="list-group-item list-group-item-action active">
                <i class="fas fa-user me-2"></i> Mi Perfil
            </a>
            <a href="{{ route('perfil.edit') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-edit me-2"></i> Editar Información
            </a>
            <a href="{{ route('perfil.preferencias') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-heart me-2"></i> Mis Preferencias
            </a>
            <a href="{{ route('perfil.especialidades') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-star me-2"></i> Mis Especialidades
            </a>
            <a href="{{ route('perfil.descargar') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-download me-2"></i> Descargar Mis Datos
            </a>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="card shadow mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Información Personal</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <p class="mb-0 text-muted">Tipo de Documento</p>
                        <p class="fw-bold">{{ $usuario->tipo_documento }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-0 text-muted">Número de Documento</p>
                        <p class="fw-bold">{{ $usuario->numero_documento }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-0 text-muted">Género</p>
                        <p class="fw-bold">{{ $usuario->genero }}</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <p class="mb-0 text-muted">Miembro desde</p>
                        <p class="fw-bold">{{ $usuario->created_at->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-8">
                        <p class="mb-0 text-muted">Estado de la cuenta</p>
                        <p class="fw-bold">
                            @if($usuario->activo)
                                <span class="badge bg-success">Activa</span>
                            @else
                                <span class="badge bg-danger">Inactiva</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Mis Especialidades</h5>
                <a href="{{ route('perfil.especialidades') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit me-1"></i> Gestionar
                </a>
            </div>
            <div class="card-body">
                @if($especialidades->isEmpty())
                    <p class="text-center text-muted">No has agregado especialidades todavía.</p>
                @else
                    <div class="row">
                        @foreach($especialidades as $especialidad)
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $especialidad->nombre }}</h6>
                                        <p class="card-text small">{{ $especialidad->pivot->descripcion }}</p>
                                        <div class="d-flex justify-content-between">
                                            <span class="badge bg-info">{{ $especialidad->pivot->experiencia_anios }} años exp.</span>
                                            <span class="badge bg-primary">${{ $especialidad->pivot->tarifa_hora }}/hora</span>
                                            @if($especialidad->pivot->disponible)
                                                <span class="badge bg-success">Disponible</span>
                                            @else
                                                <span class="badge bg-secondary">No disponible</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Mis Preferencias</h5>
                <a href="{{ route('perfil.preferencias') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-edit me-1"></i> Gestionar
                </a>
            </div>
            <div class="card-body">
                @if($preferencias->isEmpty())
                    <p class="text-center text-muted">No has agregado preferencias todavía.</p>
                @else
                    <div class="row">
                        @foreach($preferencias as $preferencia)
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $preferencia->hobby }}</h6>
                                        <p class="card-text small">{{ $preferencia->descripcion }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Mis Servicios</h5>
                <a href="{{ route('servicios.index') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-list me-1"></i> Ver Todos
                </a>
            </div>
            <div class="card-body">
                @if($servicios->isEmpty())
                    <p class="text-center text-muted">No has creado servicios todavía.</p>
                    <div class="text-center mt-3">
                        <a href="{{ route('servicios.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-1"></i> Crear Servicio
                        </a>
                    </div>
                @else
                    <div class="row">
                        @foreach($servicios as $servicio)
                            <div class="col-md-6 mb-3">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $servicio->titulo }}</h6>
                                        <p class="card-text small">{{ Str::limit($servicio->descripcion, 100) }}</p>
                                        <div class="d-flex justify-content-between">
                                            <span class="badge bg-info">{{ $servicio->categoria->nombre }}</span>
                                            <span class="badge bg-primary">${{ $servicio->precio }}</span>
                                            @if($servicio->disponible)
                                                <span class="badge bg-success">Disponible</span>
                                            @else
                                                <span class="badge bg-secondary">No disponible</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white border-0">
                                        <a href="{{ route('servicios.show', $servicio) }}" class="btn btn-sm btn-outline-primary">Ver Detalles</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card shadow">
            <div class="card-header bg-danger text-white">
                <h5 class="card-title mb-0">Desactivar Cuenta</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Si desactivas tu cuenta, tu perfil y servicios no serán visibles para otros usuarios. Podrás reactivar tu cuenta posteriormente contactando con el administrador.</p>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#desactivarCuentaModal">
                    <i class="fas fa-user-slash me-1"></i> Desactivar Mi Cuenta
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Desactivación de Cuenta -->
<div class="modal fade" id="desactivarCuentaModal" tabindex="-1" aria-labelledby="desactivarCuentaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="desactivarCuentaModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Desactivación de Cuenta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="desactivarCuentaForm" method="POST" action="{{ route('perfil.desactivar') }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                        <div>
                            <strong>¡Advertencia!</strong> Esta acción desactivará tu cuenta permanentemente.
                        </div>
                    </div>
                    
                    <p class="mb-3">Al desactivar tu cuenta:</p>
                    <ul class="text-muted mb-4">
                        <li>Tu perfil y servicios no serán visibles para otros usuarios</li>
                        <li>No podrás recibir nuevas solicitudes de servicios</li>
                        <li>Se cerrará tu sesión inmediatamente</li>
                        <li>Deberás contactar al administrador para reactivar tu cuenta</li>
                    </ul>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Para confirmar, ingresa tu contraseña:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required 
                                   placeholder="Tu contraseña actual">
                        </div>
                        <div class="invalid-feedback" id="password-error"></div>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="confirmDeactivation" required>
                        <label class="form-check-label fw-bold text-danger" for="confirmDeactivation">
                            Confirmo que deseo desactivar mi cuenta y entiendo las consecuencias
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger" id="btnDesactivar" disabled>
                        <i class="fas fa-user-slash me-1"></i>Sí, Desactivar Mi Cuenta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de Confirmación Final -->
<div class="modal fade" id="confirmacionFinalModal" tabindex="-1" aria-labelledby="confirmacionFinalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white text-center">
                <h5 class="modal-title w-100" id="confirmacionFinalModalLabel">
                    <i class="fas fa-exclamation-circle fs-1 d-block mb-2"></i>
                    ¿Estás completamente seguro?
                </h5>
            </div>
            <div class="modal-body text-center">
                <p class="mb-3"><strong>Esta es tu última oportunidad para cancelar.</strong></p>
                <p class="text-muted">Una vez desactivada, no podrás acceder a tu cuenta hasta contactar con el administrador.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left me-1"></i>No, Mantener Activa
                </button>
                <button type="button" class="btn btn-danger" id="btnConfirmarDesactivacion">
                    <i class="fas fa-check me-1"></i>Sí, Desactivar Definitivamente
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const confirmDeactivationCheckbox = document.getElementById('confirmDeactivation');
    const passwordInput = document.getElementById('password');
    const btnDesactivar = document.getElementById('btnDesactivar');
    const desactivarForm = document.getElementById('desactivarCuentaForm');
    const confirmacionFinalModal = new bootstrap.Modal(document.getElementById('confirmacionFinalModal'));
    const desactivarModal = bootstrap.Modal.getInstance(document.getElementById('desactivarCuentaModal'));

    // Habilitar/deshabilitar botón según checkbox y contraseña
    function updateButtonState() {
        const isChecked = confirmDeactivationCheckbox.checked;
        const hasPassword = passwordInput.value.trim().length > 0;
        btnDesactivar.disabled = !(isChecked && hasPassword);
    }

    confirmDeactivationCheckbox.addEventListener('change', updateButtonState);
    passwordInput.addEventListener('input', updateButtonState);

    // Interceptar el envío del formulario para mostrar confirmación final
    desactivarForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Ocultar el modal actual y mostrar confirmación final
        if (desactivarModal) {
            desactivarModal.hide();
        }
        
        setTimeout(() => {
            confirmacionFinalModal.show();
        }, 300);
    });

    // Manejar confirmación final
    document.getElementById('btnConfirmarDesactivacion').addEventListener('click', function() {
        // Mostrar loading
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Desactivando...';
        this.disabled = true;
        
        // Enviar formulario
        setTimeout(() => {
            desactivarForm.submit();
        }, 1000);
    });

    // Resetear formulario cuando se cierre el modal
    document.getElementById('desactivarCuentaModal').addEventListener('hidden.bs.modal', function() {
        desactivarForm.reset();
        updateButtonState();
        document.getElementById('password-error').textContent = '';
        passwordInput.classList.remove('is-invalid');
    });

    // Resetear confirmación final cuando se cierre
    document.getElementById('confirmacionFinalModal').addEventListener('hidden.bs.modal', function() {
        const btnConfirmar = document.getElementById('btnConfirmarDesactivacion');
        btnConfirmar.innerHTML = '<i class="fas fa-check me-1"></i>Sí, Desactivar Definitivamente';
        btnConfirmar.disabled = false;
        
        // Volver a mostrar el modal principal si es necesario
        setTimeout(() => {
            if (desactivarModal) {
                desactivarModal.show();
            } else {
                const modalElement = document.getElementById('desactivarCuentaModal');
                const newModal = new bootstrap.Modal(modalElement);
                newModal.show();
            }
        }, 300);
    });
});
</script>

@endsection 