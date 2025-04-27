@extends('layouts.app') 
{{-- On utilise la structure de base layouts.app --}}

@section('content')
{{-- Début du contenu de la page --}}

<div class="container">
    <h3>Paramètres du compte administrateur</h3>

    {{-- Si un message de succès existe dans la session, on l'affiche --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulaire pour mettre à jour l'email et/ou le mot de passe --}}
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf {{-- Protection contre les attaques CSRF (obligatoire dans les formulaires POST) --}}

        {{-- Champ Email --}}
        <div class="mb-3">
            <label>Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email', $admin->email) }}" required>
            {{-- Affiche l'email actuel ou conserve la valeur saisie si erreur --}}
        </div>

        {{-- Champ Nouveau Mot de passe --}}
        <div class="mb-3">
            <label>Nouveau mot de passe (laissez vide pour ne pas changer)</label>
            <input class="form-control" type="password" name="password">
            {{-- Permet de saisir un nouveau mot de passe (optionnel) --}}
        </div>

        {{-- Champ Confirmation Mot de passe --}}
        <div class="mb-3">
            <label>Confirmer le mot de passe</label>
            <input class="form-control" type="password" name="password_confirmation">
            {{-- Confirmation du nouveau mot de passe --}}
        </div>

        {{-- Bouton pour envoyer le formulaire --}}
        <button class="btn btn-primary">Mettre à jour</button>

        {{-- Bouton pour retourner à la page liste des motards --}}
        <a href="/liste" class="btn btn-success">Retour à la page motard</a>
    </form>
</div>

@endsection
{{-- Fin du contenu --}}
