@extends('layouts.app')

@section('title', 'Crear Nuevo Servicio de Intercambio')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Crear Nuevo Servicio de Intercambio</h2>
        <a href="{{ route('servicios.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver a Servicios
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Información del Servicio de Intercambio</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('servicios.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título del servicio *</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                                   id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="id_categoria" class="form-label">Categoría *</label>
                            <select class="form-select @error('id_categoria') is-invalid @enderror" 
                                    id="id_categoria" name="id_categoria" required>
                                <option value="">Selecciona una categoría</option>
                                @foreach($categorias as $categoria)
                                    <option value="{{ $categoria->id_categoria }}" 
                                            {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                                        {{ $categoria->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="mt-2">
                                <span class="text-muted small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Elige la categoría que mejor describa tu servicio de intercambio.
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción detallada *</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" name="descripcion" rows="5" required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <span class="text-muted small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Describe con detalle lo que ofreces para intercambio, incluye alcance y limitaciones.
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tipo_intercambio" class="form-label">Tipo de Intercambio *</label>
                            <select class="form-select @error('tipo_intercambio') is-invalid @enderror" 
                                    id="tipo_intercambio" name="tipo_intercambio" required>
                                <option value="">Selecciona el tipo de intercambio</option>
                                <option value="Tiempo por Tiempo" {{ old('tipo_intercambio') == 'Tiempo por Tiempo' ? 'selected' : '' }}>
                                    Tiempo por Tiempo
                                </option>
                                <option value="Servicio por Servicio" {{ old('tipo_intercambio') == 'Servicio por Servicio' ? 'selected' : '' }}>
                                    Servicio por Servicio
                                </option>
                                <option value="Habilidad por Habilidad" {{ old('tipo_intercambio') == 'Habilidad por Habilidad' ? 'selected' : '' }}>
                                    Habilidad por Habilidad
                                </option>
                                <option value="Conocimiento por Conocimiento" {{ old('tipo_intercambio') == 'Conocimiento por Conocimiento' ? 'selected' : '' }}>
                                    Conocimiento por Conocimiento
                                </option>
                                <option value="Flexible" {{ old('tipo_intercambio') == 'Flexible' ? 'selected' : '' }}>
                                    Flexible (Acepto diferentes tipos)
                                </option>
                            </select>
                            @error('tipo_intercambio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <span class="text-muted small">
                                    <i class="fas fa-exchange-alt me-1"></i>
                                    Define qué tipo de intercambio buscas a cambio de tu servicio.
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion_intercambio" class="form-label">Descripción del Intercambio *</label>
                            <textarea class="form-control @error('descripcion_intercambio') is-invalid @enderror" 
                                      id="descripcion_intercambio" name="descripcion_intercambio" rows="3" required>{{ old('descripcion_intercambio') }}</textarea>
                            @error('descripcion_intercambio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <span class="text-muted small">
                                    <i class="fas fa-handshake me-1"></i>
                                    Especifica qué esperas recibir a cambio: tiempo, actividades específicas, etc.
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="duracion_dias" class="form-label">Duración del Servicio (días) *</label>
                            <select class="form-select @error('duracion_dias') is-invalid @enderror" 
                                    id="duracion_dias" name="duracion_dias" required>
                                <option value="">Selecciona la duración</option>
                                <option value="1" {{ old('duracion_dias') == '1' ? 'selected' : '' }}>1 día</option>
                                <option value="3" {{ old('duracion_dias') == '3' ? 'selected' : '' }}>3 días</option>
                                <option value="7" {{ old('duracion_dias') == '7' ? 'selected' : '' }}>7 días (1 semana)</option>
                                <option value="14" {{ old('duracion_dias') == '14' ? 'selected' : '' }}>14 días (2 semanas)</option>
                                <option value="30" {{ old('duracion_dias') == '30' ? 'selected' : '' }}>30 días (1 mes)</option>
                                <option value="60" {{ old('duracion_dias') == '60' ? 'selected' : '' }}>60 días (2 meses)</option>
                                <option value="90" {{ old('duracion_dias') == '90' ? 'selected' : '' }}>90 días (3 meses)</option>
                                <option value="0" {{ old('duracion_dias') == '0' ? 'selected' : '' }}>Sin límite de tiempo</option>
                            </select>
                            @error('duracion_dias')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-2">
                                <span class="text-muted small">
                                    <i class="fas fa-clock me-1"></i>
                                    <strong>¡Importante!</strong> El servicio se eliminará automáticamente cuando cumpla exactamente el tiempo seleccionado. 
                                    Si pones 3 días, el servicio estará disponible exactamente 3 días y luego expirará automáticamente.
                                </span>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input @error('disponible') is-invalid @enderror" 
                                       type="checkbox" id="disponible" name="disponible" value="1" 
                                       {{ old('disponible', '1') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="disponible">
                                    Servicio disponible para intercambio
                                </label>
                                @error('disponible')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="alert alert-info mb-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle fa-2x me-3"></i>
                                </div>
                                <div>
                                    <h6 class="alert-heading">Sistema de Intercambio</h6>
                                    <p class="mb-0">Al publicar este servicio de intercambio, estás aceptando el intercambio de tiempo por actividad. 
                                    Los usuarios podrán proponerte intercambios de servicios, tiempo o conocimientos. El servicio se eliminará automáticamente 
                                    cuando cumpla el tiempo de duración especificado. Asegúrate de responder a las propuestas de intercambio de manera oportuna.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('servicios.index') }}" class="btn btn-light me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Publicar Servicio de Intercambio
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 