@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg p-4 w-100" style="max-width: 450px;">
        <h4 class="text-center text-success mb-4">🔁 Réinitialiser le mot de passe</h4>

        {{-- Affichage des erreurs --}}
        @if ($errors->any())
            <div class="alert alert-danger text-center">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Formulaire de réinitialisation --}}
        <form method="POST" action="{{ route('password.reset') }}">
            @csrf

            {{-- Champ : Nouveau mot de passe --}}
            <div class="mb-3">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" class="form-control" required placeholder="••••••••">
            </div>

            {{-- Champ : Confirmation --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required placeholder="••••••••">
            </div>

            {{-- Bouton --}}
            <button type="submit" class="btn btn-success w-100">Réinitialiser</button>
        </form>

        {{-- Lien retour login --}}
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none">← Retour à la connexion</a>
        </div>
    </div>
</div>
@endsection
