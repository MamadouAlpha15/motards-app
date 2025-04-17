@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card p-4 shadow" style="width: 100%; max-width: 500px;">
        <h2 class="text-center mb-4">Ajouter un Motard</h2>  
        <form method="POST" action="{{ route('motards.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-2">
                <input class="form-control" name="nom" placeholder="Nom">
            </div>
            <div class="mb-2">
                <input class="form-control" name="prenom" placeholder="Prénom">
            </div>
            <div class="mb-2">
                <input class="form-control" name="telephone" placeholder="Téléphone">
            </div>
            <div class="mb-2">
                <input class="form-control" name="ligne" placeholder="Ligne">
            </div>
            <div class="mb-2">
                <input class="form-control" name="numero_tuteur" placeholder="Numéro du tuteur">
            </div>
            <div class="mb-2">
                <input class="form-control" name="matricule" placeholder="Matricule">
            </div>
            <div class="mb-2">
                <input class="form-control" name="base_stationnement" placeholder="Base de stationnement">
            </div>
            <div class="mb-2">
                <input class="form-control" type="file" name="photo">
            </div>
            <div class="text-center">
                <button class="btn btn-primary w-100">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<style>
    body {
        background-color: steelblue;
    }
</style>
@endsection
