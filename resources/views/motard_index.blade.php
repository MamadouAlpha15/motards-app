@extends('layouts.app')
{{-- On utilise le layout principal layouts.app --}}

@section('content')
{{-- Début du contenu spécifique de la page --}}

{{-- Importation des icônes Bootstrap --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="motards-container p-4">
    {{-- Conteneur principal avec padding --}}

    <h2 class="text-center mb-5">Liste des Motards</h2>

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('motards.index') }}" class="mb-5">
        {{-- Formulaire de recherche par nom, ligne, matricule ou stationnement --}}
        <div class="input-group shadow">
            <input type="text" name="recherche" class="form-control" placeholder="Rechercher..." value="{{ request('recherche') }}">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Rechercher
            </button>

            {{-- Bouton Annuler si une recherche est en cours --}}
            @if(request('recherche'))
                <a href="{{ route('motards.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i> Annuler
                </a>
            @endif
        </div>
    </form>

    <!-- Message résultat de recherche -->
    @if($recherche)
        {{-- Si une recherche a été effectuée, afficher un message --}}
        <div class="alert alert-info text-center shadow-sm rounded p-3 mb-4">
            Résultats de recherche pour : <strong>{{ $recherche }}</strong>
        </div>
    @endif

    <!-- Bouton Ajouter un motard -->
    <div class="text-end mb-4">
        <a href="{{ route('motards.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Ajouter
        </a>
    </div>

    <!-- Liste des motards -->
    @if($motardsParLigne->isEmpty())
        {{-- Message si aucun motard trouvé --}}
        <div class="alert alert-warning text-center p-4 shadow-sm rounded">
            @switch($typeRecherche)
                @case('nom')
                    Aucun motard trouvé avec ce <strong>nom ou prénom</strong>.
                    @break
                @case('ligne')
                    Aucun motard trouvé pour la <strong>ligne</strong> saisie.
                    @break
                @case('matricule')
                    Aucun motard trouvé avec ce <strong>matricule</strong>.
                    @break
                @case('base_stationnement')
                    Aucun motard trouvé avec ce <strong>stationnement</strong>.
                    @break
                @default
                    Aucun motard trouvé correspondant à <strong>"{{ $recherche }}"</strong>.
            @endswitch
        </div>
    @else
        {{-- Sinon, afficher la liste des motards groupés par ligne --}}
        @foreach($motardsParLigne as $ligne => $motards)
            <h3 class="mb-4 text-primary">
                Ligne {{ $ligne }} - {{ $motards->first()->base_stationnement ?? 'Station inconnue' }}
            </h3>

            <div class="table-responsive-motards mb-5">
                <table class="table table-hover table-striped align-middle rounded shadow-sm overflow-hidden">
                    {{-- En-tête du tableau --}}
                    <thead class="table-primary">
                        <tr>
                            <th>Nom</th>
                            <th class="border-start">Stationnement</th>
                            <th class="text-center border-start">Carte Motard (Photo, QR Code, Actions)</th>
                        </tr>
                    </thead>

                    {{-- Corps du tableau --}}
                    <tbody>
                        @foreach($motards as $motard)
                            <tr>
                                {{-- Nom complet --}}
                                <td>{{ $motard->prenom }} {{ $motard->nom }}</td>

                                {{-- Base de stationnement --}}
                                <td class="border-start">{{ $motard->base_stationnement }}</td>

                                {{-- Carte du motard --}}
                                <td class="text-center border-start">
                                    <div class="motard-card bg-light p-3 rounded shadow d-inline-block">
                                        {{-- Photo --}}
                                        <img src="{{ asset('storage/' . $motard->photo) }}" alt="photo"
                                             class="img-thumbnail mb-2" style="width: 110px; height: 110px; object-fit: cover;">

                                        {{-- Nom --}}
                                        <div style="font-size: 0.95rem;"><strong>{{ $motard->prenom }} {{ $motard->nom }}</strong></div>

                                        {{-- Matricule --}}
                                        <div class="text-muted" style="font-size: 0.85rem;">{{ $motard->matricule }}</div>

                                        {{-- QR Code --}}
                                        <div class="mt-2">
                                            {!! QrCode::size(70)->generate(route('motards.show', $motard->slug)) !!}
                                        </div>

                                        {{-- Boutons d'actions --}}
                                        <div class="mt-3 d-flex flex-wrap justify-content-center gap-2">
                                            {{-- Voir la fiche --}}
                                            <a href="{{ route('motards.show', $motard->slug) }}" target="_blank" class="btn btn-info btn-sm no-print">
                                                <i class="bi bi-eye"></i> Voir
                                            </a>

                                            {{-- Imprimer la carte --}}
                                            <a href="{{ route('motards.carte', $motard->slug) }}" target="_blank" class="btn btn-primary btn-sm no-print">
                                                <i class="bi bi-printer"></i> Imprimer
                                            </a>

                                            {{-- Modifier --}}
                                            <a href="{{ route('motards.edit', $motard->id) }}" class="btn btn-warning btn-sm no-print">
                                                <i class="bi bi-pencil-square"></i> Modifier
                                            </a>

                                            {{-- Supprimer --}}
                                            <form action="{{ route('motards.destroy', $motard->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm no-print" onclick="return confirm('Voulez-vous vraiment supprimer ce motard ?')">
                                                    <i class="bi bi-trash"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @endforeach
    @endif

</div>
{{-- Fin du conteneur motards --}}
@endsection

{{-- Début du CSS personnalisé --}}
@push('styles')
<style>
    /* Fond général de la page */
    body {
        background: linear-gradient(to right, #dfe9f3, #ffffff);
        background-attachment: fixed;
    }

    /* Style du conteneur principal */
    .motards-container {
        background: rgba(255, 255, 255, 0.9);
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin: 20px;
        padding: 20px;
    }

    /* Cartes des motards */
    .motard-card {
        width: 220px;
        background: rgba(255,255,255,0.95);
    }

    /* Ligne de séparation entre colonnes */
    .border-start {
        border-left: 2px solid #dee2e6;
    }

    /* Cacher les boutons à l'impression */
    @media print {
        .no-print {
            display: none !important;
        }
    }

    /* Adaptation mobile */
    @media (max-width: 768px) {
        .table-responsive-motards {
            overflow-x: auto;
        }
        .motard-card {
            width: 100% !important;
        }
        .motard-card img {
            width: 100px;
            height: 100px;
        }
        .motard-card .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .motard-card div {
            font-size: 0.9rem;
        }
        h3 {
            font-size: 1.2rem;
        }
    }

    /* Style des boutons avec animation hover */
    .btn {
        transition: all 0.3s ease;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    }
    .btn:active {
        transform: scale(0.95);
    }
    .btn:hover {
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6),
                    0 0 30px rgba(0, 123, 255, 0.4),
                    0 0 45px rgba(0, 123, 255, 0.2);
    }
</style>
@endpush
