@php 
// Cacher l'en-tête du site si cette variable est utilisée dans layouts.app
$hideHeader = true; 
@endphp

@extends('layouts.app')

@section('content')

<style>
    /* Couleur de fond générale de la page */
    body {
        background-color: #f8fafc;
    }

    /* Style de la carte du motard */
    .motard-card {
        max-width: 400px;
        margin: 40px auto;
        background-color: #ffffff;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
        text-align: center;
    }

    /* Style pour l'icône de validation (check vert) */
    .check-icon {
        width: 60px;
        margin-bottom: 15px;
    }

    /* Cadre pour la photo du motard */
    .photo-wrapper {
        width: 100%;
        max-width: 160px;
        height: 160px;
        border-radius: 12px;
        overflow: hidden;
        margin: 0 auto 20px;
        border: 3px solid #e2e8f0;
    }

    /* Image du motard dans le cadre */
    .photo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Bloc contenant toutes les informations du motard */
    .motard-info {
        text-align: left;
        margin-top: 20px;
    }

    /* Style d'un élément d'information */
    .motard-info .item {
        background-color: #f1f5f9;
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 10px;
        word-wrap: break-word;
    }

    /* Texte en gras pour les libellés (Nom:, Prénom:, etc.) */
    .motard-info .item strong {
        display: inline-block;
        min-width: 130px;
    }

    /* Adaptation pour écran mobile */
    @media (max-width: 576px) {
        .motard-card {
            padding: 15px;
        }

        .motard-info .item strong {
            display: block;
            margin-bottom: 5px;
        }

        .photo-wrapper {
            height: auto;
        }
    }
</style>

<div class="container py-4">

    <!-- Lien vers le site d'information des motards -->
    <div class="text-center mb-3">
        <a href="{{ route('motards.pub') }}" class="btn btn-warning">Voir le site d'Informations</a>
    </div>

    <!-- Carte contenant toutes les informations du motard -->
    <div class="motard-card">

        <!-- ✅ Affiche une icône verte pour montrer que c'est validé -->
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/50/Yes_Check_Circle.svg/1024px-Yes_Check_Circle.svg.png" alt="check" class="check-icon">

        <!-- ✅ Affiche la photo du motard dans un cadre -->
        <div class="photo-wrapper">
            <img src="{{ asset('storage/' . $motard->photo) }}" alt="Photo du motard">
        </div>

        <!-- ✅ Titre principal -->
        <h4 class="mb-1">Détails du Taxi Motard</h4>

        <!-- ✅ Texte indiquant que le motard est en règle -->
        <p class="text-success">Ce taxi motard est en règle.</p>

        <!-- ✅ Affiche toutes les informations du motard -->
        <div class="motard-info">
            <div class="item"><strong>Nom :</strong> {{ $motard->nom }}</div>
            <div class="item"><strong>Prénom :</strong> {{ $motard->prenom }}</div>
            <div class="item"><strong>Téléphone :</strong> {{ $motard->telephone }}</div>
            <div class="item"><strong>Ligne :</strong> {{ $motard->ligne }}</div>
            <div class="item"><strong>Numéro tuteur :</strong> {{ $motard->numero_tuteur }}</div>
            <div class="item"><strong>Matricule :</strong> {{ $motard->matricule }}</div>
            <div class="item"><strong>Base de stationnement habituel :</strong> {{ $motard->base_stationnement }}</div>
        </div>
    </div>
</div>

@endsection
