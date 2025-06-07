@extends('layouts.app')

@section('title', 'Editar Perfil')

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
            <a href="{{ route('perfil.show') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-user me-2"></i> Mi Perfil
            </a>
            <a href="{{ route('perfil.edit') }}" class="list-group-item list-group-item-action active">
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
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">Editar Información Personal</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('perfil.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $usuario->nombre) }}" required>
                            @error('nombre')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input id="apellidos" type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos" value="{{ old('apellidos', $usuario->apellidos) }}" required>
                            @error('apellidos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                            <select id="tipo_documento" class="form-select @error('tipo_documento') is-invalid @enderror" name="tipo_documento" required>
                                <option value="Cédula" {{ old('tipo_documento', $usuario->tipo_documento) == 'Cédula' ? 'selected' : '' }}>Cédula</option>
                                <option value="Pasaporte" {{ old('tipo_documento', $usuario->tipo_documento) == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                <option value="DNI" {{ old('tipo_documento', $usuario->tipo_documento) == 'DNI' ? 'selected' : '' }}>DNI</option>
                                <option value="Otro" {{ old('tipo_documento', $usuario->tipo_documento) == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('tipo_documento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="numero_documento" class="form-label">Número de Documento</label>
                            <input id="numero_documento" type="text" class="form-control @error('numero_documento') is-invalid @enderror" name="numero_documento" value="{{ old('numero_documento', $usuario->numero_documento) }}" required>
                            @error('numero_documento')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="genero" class="form-label">Género</label>
                            <select id="genero" class="form-select @error('genero') is-invalid @enderror" name="genero" required>
                                <option value="Masculino" {{ old('genero', $usuario->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('genero', $usuario->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="Otro" {{ old('genero', $usuario->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                <option value="Prefiero no decir" {{ old('genero', $usuario->genero) == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                            </select>
                            @error('genero')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="profesion" class="form-label">Profesión</label>
                            <input id="profesion" type="text" class="form-control @error('profesion') is-invalid @enderror" name="profesion" value="{{ old('profesion', $usuario->profesion) }}" required>
                            @error('profesion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $usuario->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono', $usuario->telefono) }}" required>
                            @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Nueva Contraseña <span class="text-muted">(opcional)</span></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                            <div class="form-text">Deja en blanco si no deseas cambiar la contraseña.</div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password-confirm" class="form-label">Confirmar Nueva Contraseña</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('perfil.show') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 