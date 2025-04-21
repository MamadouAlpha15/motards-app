@php $hideHeader = true; @endphp

@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8fafc;
    }

    .motard-card {
        max-width: 400px;
        margin: 40px auto;
        background-color: #ffffff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        text-align: center;
        
        
    }

    .check-icon {
        width: 60px;
        margin-bottom: 15px;
    }

    .photo-wrapper {
        width: 160px;
        height: 160px;
        border-radius: 12px;
        overflow: hidden;
        margin: 0 auto 20px;
        border: 3px solid #e2e8f0;
    }

    .photo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .motard-info {
        text-align: left;
        margin-top: 20px;
    }

    .motard-info .item {
        background-color: #f1f5f9;
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .motard-info .item strong {
        display: inline-block;
        width: 130px;
    }
</style>
<a href="{{ route('motards.pub') }}" class="btn btn-warning">Voir le site d'Informations</a>


<div class="motard-card">
    <!-- ✅ Image verte de validation (lien direct) -->
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/50/Yes_Check_Circle.svg/1024px-Yes_Check_Circle.svg.png" alt="check" class="check-icon">

    <!-- Photo du motard -->
    <div class="photo-wrapper">
        <img src="{{ asset('storage/' . $motard->photo) }}" alt="Photo du motard" >
    </div>

    <!-- Titre -->
    <h4 class="mb-1">Détails du Taxi Motard</h4>
    <p class="text-success">Ce taxi motard est en règle.</p>

    <!-- Infos -->
    <div class="motard-info">
        <div class="item"><strong>Nom :</strong> {{ $motard->nom }}</div>
        <div class="item"><strong>Prénom :</strong> {{ $motard->prenom }}</div>
        <div class="item"><strong>Téléphone :</strong> {{ $motard->telephone }}</div>
        <div class="item"><strong>Ligne :</strong> {{ $motard->ligne }}</div>
        <div class="item"><strong>Numéro tuteur :</strong> {{ $motard->numero_tuteur }}</div>
        <div class="item"><strong>Matricule :</strong> {{ $motard->matricule }}</div>
        <div class="item"><strong>Base de stationnement habituel:</strong> {{ $motard->base_stationnement }}</div>
    </div>
</div>
@endsection
