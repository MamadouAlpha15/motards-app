@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 400px;">
    <h3>Connexion</h3>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
        </div>
        <button type="submit" class="btn btn-dark">Connexion</button>
    </form>
    <style>
    body {
        background-image: url('{{ asset('storage/photos/Login.jpg') }}');

        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
    }

    .card {
        background-color: rgba(255, 255, 255, 0.9); /* Pour lisibilité */
        padding: 20px;
        border-radius: 10px;
    }
</style>

</div>
@endsection
