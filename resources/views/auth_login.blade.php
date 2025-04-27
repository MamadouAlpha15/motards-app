@extends('layouts.app')
{{-- On utilise le layout principal "layouts.app" --}}

@section('content')
{{-- Début du contenu spécifique de cette page --}}

<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    {{-- Container centré verticalement et horizontalement --}}

    <div class="card shadow w-100" style="max-width: 400px;">
        {{-- Petite carte blanche pour le formulaire de connexion --}}
        <h3 class="text-center mb-4 mt-2">Connexion</h3>

        {{-- Si jamais il y a des erreurs (ex: mauvais email ou mot de passe), on les affiche ici --}}
        @if ($errors->any())
        <div class="alert alert-danger mx-2">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li> {{-- Affiche chaque erreur dans une liste --}}
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Formulaire de connexion --}}
        <form method="POST" action="{{ route('login') }}" class="px-3 pb-3">
            @csrf {{-- Sécurité CSRF obligatoire pour les formulaires POST --}}

            {{-- Champ Email --}}
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
                {{-- Input pour l'adresse email, autofocus = curseur directement ici --}}
            </div>

            {{-- Champ Mot de Passe --}}
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                {{-- Input pour le mot de passe --}}
            </div>

            {{-- Bouton de connexion --}}
            <button type="submit" class="btn btn-dark w-100">Connexion</button>
        </form>
    </div>
</div>

{{-- Style CSS pour la page de connexion --}}
<style>
    /* Style du fond avec une image */
    body {
        background-image: url('{{ asset('storage/photos/Login.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
    }

    /* Style de la carte du formulaire */
    .card {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
    }

    /* Adaptation sur petits écrans (téléphones) */
    @media (max-width: 576px) {
        .card {
            margin: 10px;
            padding: 10px;
        }

        h3 {
            font-size: 1.4rem;
        }
    }
</style>

@endsection
{{-- Fin du contenu spécifique --}}
