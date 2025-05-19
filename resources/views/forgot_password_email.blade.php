@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4 w-100" style="max-width: 450px;">
        <h4 class="text-center mb-4 text-primary">🔐 Mot de passe oublié</h4>

        {{-- Affiche les erreurs --}}
        @if ($errors->any())
            <div class="alert alert-danger text-center">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" name="email" class="form-control" placeholder="ex: exemple@email.com" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Continuer
            </button>
        </form>

        {{-- Lien retour --}}
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none">← Retour à la connexion</a>
        </div>
    </div>
</div>
@endsection
