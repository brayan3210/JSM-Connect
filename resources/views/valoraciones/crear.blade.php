@extends('layouts.app')

@section('title', 'Valorar Servicio')

@section('styles')
<style>
    .star-rating {
        direction: rtl;
        display: inline-block;
        padding: 20px;
    }
    
    .star-rating input[type=radio] {
        display: none;
    }
    
    .star-rating label {
        color: #bbb;
        font-size: 2.5rem;
        padding: 0;
        cursor: pointer;
        transition: all .3s ease-in-out;
    }
    
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input[type=radio]:checked ~ label {
        color: #f8d32b;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 mb-0 text-gray-800">Valorar Servicio</h2>
        <a href="{{ route('solicitudes.show', $solicitud) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Volver a la Solicitud
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Valora tu experiencia</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-briefcase fa-2x text-primary me-3"></i>
                            </div>
                            <div>
                                <h5>{{ $solicitud->servicio->titulo }}</h5>
                                <p class="text-muted mb-0">Proveedor: {{ $solicitud->usuarioProveedor->nombre }} {{ $solicitud->usuarioProveedor->apellidos }}</p>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Tu valoración ayuda a otros usuarios a tomar mejores decisiones y al proveedor a mejorar su servicio.
                        </div>
                    </div>

                    <form method="POST" action="{{ route('valoraciones.store') }}">
                        @csrf
                        <input type="hidden" name="id_solicitud" value="{{ $solicitud->id_solicitud }}">
                        
                        <div class="mb-4 text-center">
                            <label class="form-label d-block">¿Cómo calificarías este servicio? *</label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="puntuacion" value="5" {{ old('puntuacion') == 5 ? 'checked' : '' }} required/>
                                <label for="star5" title="Excelente"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" id="star4" name="puntuacion" value="4" {{ old('puntuacion') == 4 ? 'checked' : '' }}/>
                                <label for="star4" title="Muy bueno"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" id="star3" name="puntuacion" value="3" {{ old('puntuacion') == 3 ? 'checked' : '' }}/>
                                <label for="star3" title="Bueno"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" id="star2" name="puntuacion" value="2" {{ old('puntuacion') == 2 ? 'checked' : '' }}/>
                                <label for="star2" title="Regular"><i class="fas fa-star"></i></label>
                                
                                <input type="radio" id="star1" name="puntuacion" value="1" {{ old('puntuacion') == 1 ? 'checked' : '' }}/>
                                <label for="star1" title="Malo"><i class="fas fa-star"></i></label>
                            </div>
                            @error('puntuacion')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="comentario" class="form-label">Comentario (opcional)</label>
                            <textarea class="form-control @error('comentario') is-invalid @enderror" 
                                      id="comentario" name="comentario" rows="4">{{ old('comentario') }}</textarea>
                            @error('comentario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Comparte tu experiencia y aspectos a destacar del servicio.
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('solicitudes.show', $solicitud) }}" class="btn btn-light me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-star me-1"></i> Enviar Valoración
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animación para destacar las estrellas al seleccionar
        const stars = document.querySelectorAll('.star-rating input');
        const starsLabel = document.querySelectorAll('.star-rating label');
        
        stars.forEach(star => {
            star.addEventListener('change', function() {
                // Mostrar un pequeño mensaje de descripción según la valoración
                let mensaje = '';
                const rating = parseInt(this.value);
                
                switch(rating) {
                    case 5:
                        mensaje = 'Excelente - Superó mis expectativas';
                        break;
                    case 4:
                        mensaje = 'Muy bueno - Quedé satisfecho';
                        break;
                    case 3:
                        mensaje = 'Bueno - Cumplió lo básico';
                        break;
                    case 2:
                        mensaje = 'Regular - Algunos problemas';
                        break;
                    case 1:
                        mensaje = 'Malo - No lo recomendaría';
                        break;
                }
                
                // Crear o actualizar elemento para mostrar el mensaje
                let ratingDescription = document.getElementById('ratingDescription');
                if (!ratingDescription) {
                    ratingDescription = document.createElement('p');
                    ratingDescription.id = 'ratingDescription';
                    ratingDescription.className = 'mt-2 text-center';
                    document.querySelector('.star-rating').insertAdjacentElement('afterend', ratingDescription);
                }
                
                ratingDescription.textContent = mensaje;
                ratingDescription.className = 'mt-2 text-center ' + 
                    (rating >= 4 ? 'text-success' : (rating <= 2 ? 'text-danger' : 'text-warning'));
            });
        });
    });
</script>
@endsection 