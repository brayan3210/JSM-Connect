@extends('layouts.app')

@section('title', 'Completa tu perfil - Categorías de interés')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary bg-gradient text-white">
                    <h4 class="mb-0">Completa tu perfil - Paso 2 de 3</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="progress mb-4" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 66%;" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h5>¿Qué servicios te interesan?</h5>
                        <p class="text-muted">Selecciona las categorías de servicios que te gustaría encontrar en la plataforma.</p>
                    </div>

                    <form method="POST" action="{{ route('onboarding.interests.store') }}">
                        @csrf
                        
                        @if($categorias->count() > 0)
                            <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                                @foreach($categorias as $categoria)
                                    <div class="col">
                                        <div class="card h-100 border-light hover-card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input 
                                                        class="form-check-input" 
                                                        type="checkbox" 
                                                        name="categorias[]" 
                                                        id="categoria{{ $categoria->id_categoria }}" 
                                                        value="{{ $categoria->id_categoria }}"
                                                        @if(old('categorias') && in_array($categoria->id_categoria, old('categorias'))) checked @endif
                                                    >
                                                    <label class="form-check-label w-100" for="categoria{{ $categoria->id_categoria }}">
                                                        <h6 class="card-title mb-2">{{ $categoria->nombre }}</h6>
                                                        @if($categoria->descripcion)
                                                            <p class="card-text small text-muted">{{ $categoria->descripcion }}</p>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @error('categorias')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No hay categorías disponibles en este momento. Por favor, contacta con el administrador.
                            </div>
                        @endif
                        
                        <div class="alert alert-info">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle fa-2x me-3"></i>
                                </div>
                                <div>
                                    <h6 class="alert-heading">¿Por qué pedimos esta información?</h6>
                                    <p class="mb-0">Conocer tus intereses nos permite mostrarte los servicios y profesionales más relevantes para ti.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                Completar más tarde
                            </a>
                            <div>
                                <a href="{{ route('onboarding.preferences') }}" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-arrow-left me-1"></i> Anterior
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Continuar <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .hover-card:hover {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>
@endsection 