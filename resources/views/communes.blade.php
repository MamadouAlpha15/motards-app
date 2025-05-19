@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 fw-bold text-primary">🌍 Choisissez une Commune à Gérer</h2>
    <div class="text-end mb-4">
    <a href="{{ route('admin.liste') }}" class="btn btn-dark">
        <i class="bi bi-people"></i> Voir les Administrateurs
    </a>
</div>


    <div class="row justify-content-center">
        @foreach($communes as $commune)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <a href="{{ route('motards.index', ['commune' => $commune->slug]) }}" class="text-decoration-none">
                    <div class="card shadow-lg border-0 h-100 text-center hover-zoom">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title text-dark fw-bold">{{ $commune->nom }}</h5>
                            <p class="text-muted small">Voir les motards</p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

{{-- Style CSS --}}
<style>
    .hover-zoom {
        transition: transform 0.3s ease;
    }
    .hover-zoom:hover {
        transform: scale(1.05);
    }
</style>
@endsection
