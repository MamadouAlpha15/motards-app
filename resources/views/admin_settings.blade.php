@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Paramètres du compte administrateur</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input class="form-control" type="email" name="email" value="{{ old('email', $admin->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Nouveau mot de passe (laissez vide pour ne pas changer)</label>
            <input class="form-control" type="password" name="password">
        </div>

        <div class="mb-3">
            <label>Confirmer le mot de passe</label>
            <input class="form-control" type="password" name="password_confirmation">
        </div>

        <button class="btn btn-primary">Mettre à jour</button>
        
        <a href="/liste" class="btn btn-success">Retour a la page motard</a>
    </form>
</div>
@endsection
