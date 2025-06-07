@extends('layouts.app')

@section('title', 'Acceso Denegado')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center">
                <div class="error mx-auto" data-text="403">403</div>
                <p class="lead text-gray-800 mb-5">{{ $message ?? 'Acceso Denegado' }}</p>
                <p class="text-gray-500 mb-0">Parece que intentaste acceder a una página restringida.</p>
                <a href="{{ route('dashboard') }}">&larr; Volver al Dashboard</a>
            </div>
        </div>
    </div>
</div>

<style>
.error {
    color: #5a5c69;
    font-size: 7rem;
    position: relative;
    line-height: 1;
    width: 12.5rem;
}

.error:before {
    content: attr(data-text);
    position: absolute;
    left: 0;
    top: 0;
    color: #eee;
    width: 100%;
    height: 100%;
    overflow: hidden;
    z-index: -1;
}
</style>
@endsection 