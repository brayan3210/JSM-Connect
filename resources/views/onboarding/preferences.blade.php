@extends('layouts.app')

@section('title', 'Completa tu perfil - Preferencias')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary bg-gradient text-white">
                    <h4 class="mb-0">Completa tu perfil - Paso 1 de 3</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="progress mb-4" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h5>¡Bienvenido/a, {{ auth()->user()->nombre }}!</h5>
                        <p class="text-muted">Para personalizar tu experiencia, cuéntanos sobre tus pasatiempos y hobbies.</p>
                    </div>

                    <form method="POST" action="{{ route('onboarding.preferences.store') }}">
                        @csrf
                        
                        <div id="preferencias-container">
                            <div class="preferencia-item mb-3">
                                <div class="card border-light">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <input type="text" name="hobbies[]" class="form-control @error('hobbies.0') is-invalid @enderror" placeholder="Ej: Fotografía" required>
                                                @error('hobbies.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <textarea name="descripciones[]" class="form-control @error('descripciones.0') is-invalid @enderror" placeholder="Breve descripción..." rows="2" required></textarea>
                                                @error('descripciones.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-link text-danger eliminar-preferencia d-none">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <button type="button" id="agregar-preferencia" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-plus-circle me-1"></i> Agregar otra preferencia
                            </button>
                        </div>
                        
                        <div class="alert alert-info">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle fa-2x me-3"></i>
                                </div>
                                <div>
                                    <h6 class="alert-heading">¿Por qué pedimos esta información?</h6>
                                    <p class="mb-0">Tus hobbies y pasatiempos nos ayudan a conectarte con personas que comparten tus intereses y te mostrar servicios más relevantes para ti.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                Completar más tarde
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Continuar <i class="fas fa-arrow-right ms-1"></i>
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
        const container = document.getElementById('preferencias-container');
        const agregar = document.getElementById('agregar-preferencia');
        
        // Actualizar botones de eliminar
        function actualizarBotonesEliminar() {
            const items = container.querySelectorAll('.preferencia-item');
            items.forEach((item, index) => {
                const btn = item.querySelector('.eliminar-preferencia');
                if (items.length > 1) {
                    btn.classList.remove('d-none');
                } else {
                    btn.classList.add('d-none');
                }
            });
        }
        
        // Agregar nueva preferencia
        agregar.addEventListener('click', function() {
            const items = container.querySelectorAll('.preferencia-item');
            const newItem = items[0].cloneNode(true);
            
            // Limpiar valores
            newItem.querySelectorAll('input, textarea').forEach(input => {
                input.value = '';
                input.classList.remove('is-invalid');
                
                // Actualizar nombres para indexación correcta
                const name = input.getAttribute('name');
                if (name) {
                    const nameBase = name.replace(/\[\d+\]$/, '');
                    input.setAttribute('name', `${nameBase}[]`);
                }
            });
            
            // Eliminar mensajes de error
            newItem.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
            
            // Agregar evento al botón de eliminar
            const eliminar = newItem.querySelector('.eliminar-preferencia');
            eliminar.addEventListener('click', function() {
                newItem.remove();
                actualizarBotonesEliminar();
            });
            
            container.appendChild(newItem);
            actualizarBotonesEliminar();
        });
        
        // Configurar botones de eliminar existentes
        document.querySelectorAll('.eliminar-preferencia').forEach(btn => {
            btn.addEventListener('click', function() {
                this.closest('.preferencia-item').remove();
                actualizarBotonesEliminar();
            });
        });
        
        actualizarBotonesEliminar();
    });
</script>
@endsection 