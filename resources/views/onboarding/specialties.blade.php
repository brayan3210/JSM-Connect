@extends('layouts.app')

@section('title', 'Completa tu perfil - Especialidades')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary bg-gradient text-white">
                    <h4 class="mb-0">Completa tu perfil - Paso 3 de 3</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="progress mb-4" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <h5>¿En qué áreas te especializas?</h5>
                        <p class="text-muted">Selecciona las categorías en las que ofreces servicios y completa la información requerida.</p>
                    </div>

                    <form method="POST" action="{{ route('onboarding.specialties.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            @if($categorias->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 5%"></th>
                                                <th>Categoría</th>
                                                <th>Descripción</th>
                                                <th style="width: 15%">Experiencia (años)</th>
                                                <th style="width: 15%">Tarifa ($/hora)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categorias as $categoria)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input 
                                                                class="form-check-input categoria-checkbox" 
                                                                type="checkbox" 
                                                                name="categorias[]" 
                                                                id="categoria{{ $categoria->id_categoria }}" 
                                                                value="{{ $categoria->id_categoria }}"
                                                                data-index="{{ $loop->index }}"
                                                                @if(old('categorias') && in_array($categoria->id_categoria, old('categorias')) || in_array($categoria->id_categoria, $usuarioCategorias ?? [])) checked @endif
                                                            >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="w-100" for="categoria{{ $categoria->id_categoria }}">
                                                            {{ $categoria->nombre }}
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <textarea 
                                                            name="descripciones[]" 
                                                            class="form-control @error('descripciones.' . $loop->index) is-invalid @enderror" 
                                                            rows="2" 
                                                            placeholder="Describe tus habilidades en esta área..."
                                                            data-index="{{ $loop->index }}"
                                                            @if(!old('categorias') || !in_array($categoria->id_categoria, old('categorias') ?? []) && !in_array($categoria->id_categoria, $usuarioCategorias ?? [])) disabled @endif
                                                        >{{ old('descripciones.' . $loop->index) }}</textarea>
                                                        @error('descripciones.' . $loop->index)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <input 
                                                            type="number" 
                                                            name="experiencia[]" 
                                                            class="form-control @error('experiencia.' . $loop->index) is-invalid @enderror" 
                                                            min="0" 
                                                            value="{{ old('experiencia.' . $loop->index, 0) }}"
                                                            data-index="{{ $loop->index }}"
                                                            @if(!old('categorias') || !in_array($categoria->id_categoria, old('categorias') ?? []) && !in_array($categoria->id_categoria, $usuarioCategorias ?? [])) disabled @endif
                                                        >
                                                        @error('experiencia.' . $loop->index)
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <span class="input-group-text">$</span>
                                                            <input 
                                                                type="number" 
                                                                name="tarifas[]" 
                                                                class="form-control @error('tarifas.' . $loop->index) is-invalid @enderror" 
                                                                min="0" 
                                                                step="0.01" 
                                                                value="{{ old('tarifas.' . $loop->index, 0) }}"
                                                                data-index="{{ $loop->index }}"
                                                                @if(!old('categorias') || !in_array($categoria->id_categoria, old('categorias') ?? []) && !in_array($categoria->id_categoria, $usuarioCategorias ?? [])) disabled @endif
                                                            >
                                                            @error('tarifas.' . $loop->index)
                                                                <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                @error('categorias')
                                    <div class="alert alert-danger mt-3">{{ $message }}</div>
                                @enderror
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    No hay categorías disponibles. Por favor, contacta con el administrador.
                                </div>
                            @endif
                        </div>
                        
                        <div class="alert alert-info">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle fa-2x me-3"></i>
                                </div>
                                <div>
                                    <h6 class="alert-heading">¿Por qué pedimos esta información?</h6>
                                    <p class="mb-0">Conocer tus especialidades nos permite mostrar tus servicios a los usuarios que están buscando lo que tú ofreces.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                Completar más tarde
                            </a>
                            <div>
                                <a href="{{ route('onboarding.interests') }}" class="btn btn-outline-primary me-2">
                                    <i class="fas fa-arrow-left me-1"></i> Anterior
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Finalizar <i class="fas fa-check ms-1"></i>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.categoria-checkbox');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const index = this.dataset.index;
                const fields = document.querySelectorAll(`[data-index="${index}"]`);
                
                fields.forEach(field => {
                    if (field !== this) {
                        field.disabled = !this.checked;
                        
                        if (!this.checked) {
                            if (field.tagName === 'TEXTAREA') {
                                field.value = '';
                            } else {
                                field.value = 0;
                            }
                        }
                    }
                });
            });
        });
    });
</script>
@endsection 