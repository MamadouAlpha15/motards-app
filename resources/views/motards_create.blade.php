@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card p-4 shadow-sm">
                <h2 class="text-center mb-4">Ajouter un Motard</h2>
                <form method="POST" action="{{ route('motards.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <input class="form-control" name="nom" placeholder="Nom">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="prenom" placeholder="Prénom">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="telephone" placeholder="Téléphone">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="ligne" placeholder="Ligne">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="numero_tuteur" placeholder="Numéro du tuteur">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="matricule" placeholder="Matricule">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="base_stationnement" placeholder="Base de stationnement">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="file" name="photo">
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: steelblue;
    }
</style>
@endsection
