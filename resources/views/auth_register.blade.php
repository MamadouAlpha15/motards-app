@extends('layouts.app')

@section('content')

<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow w-100 mx-2" style="max-width: 500px;">
        <h3 class="text-center mt-4">Créer un Administrateur</h3>

        {{-- Message de succès --}}
        @if (session('success'))
            <div class="alert alert-success mx-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Erreurs de validation --}}
        @if ($errors->any())
            <div class="alert alert-danger mx-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulaire --}}
        <form method="POST" action="{{ route('user.store') }}" class="px-4 pb-4">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email</label>
                <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
            </div>

            {{-- Mot de passe --}}
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            {{-- Confirmation mot de passe --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            {{-- Bouton --}}
            <button type="submit" class="btn btn-success w-100">S'inscrire</button>
        </form>
    </div>
</div>

{{-- Style responsive --}}
<style>
    body {
        background-image: url('{{ asset('storage/photos/Login.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
    }

    @media (max-width: 576px) {
        .card {
            margin: 20px;
            padding: 10px;
        }

        h3 {
            font-size: 1.3rem;
        }
    }
</style>

@endsection
