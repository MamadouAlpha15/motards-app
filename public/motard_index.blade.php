@extends('layouts.app')

@section('content')

<h2>Liste des Motards</h2>

<!-- Formulaire de recherche -->
<form method="GET" action="{{ route('motards.index') }}" class="mb-4">
    <div class="input-group">
        <input type="text" name="recherche" class="form-control" placeholder="Rechercher par nom, ligne, matricule " value="{{ request('recherche') }}">
        <button type="submit" class="btn btn-primary">Rechercher</button>
        @if(request('recherche'))
            <a href="{{ route('motards.index') }}" class="btn btn-secondary">Annuler</a>
        @endif
    </div>
</form>

<a href="{{ route('motards.create') }}" class="btn btn-success mb-3">Ajouter</a>

@if($motardsParLigne->isEmpty())
    <div class="alert alert-warning text-center">
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
            @default
                Aucun motard trouvé correspondant à <strong>"{{ $recherche }}"</strong>.
        @endswitch
    </div>
@else
    @foreach($motardsParLigne as $ligne => $motards)
        <h3>Ligne {{ $ligne}} - {{ $motards->first()->base_stationnement ?? 'Station inconnue' }}</h3>

        <div class="table-responsive-motards">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Stationnement</th>
                        <th class="text-center">Carte Motard (Photo, QR Code, Actions)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($motards as $motard)
                        <tr>
                            <td>{{ $motard->prenom }} {{ $motard->nom }}</td>
                            <td>{{ $motard->base_stationnement }}</td>
                            <td class="text-center">
                                <div class="motard-card" style="border: 1px solid #ccc; padding: 10px; border-radius: 10px; width: fit-content; margin: auto;">
                                    {{-- Photo --}}
                                    <img src="{{ asset('storage/' . $motard->photo) }}" alt="photo"
                                         style="width: 100px; height: 100px; border-radius: 4px; object-fit: cover; margin-bottom: 8px;">

                                    {{-- Nom --}}
                                    <div><strong>{{ $motard->prenom }} {{ $motard->nom }}</strong></div>

                                    {{-- Matricule --}}
                                    <div><strong>{{ $motard->matricule }}</strong></div>

                                    {{-- QR Code --}}
                                    <div style="margin-top: 8px;">
                                        {!! QrCode::size(80)->generate(route('motards.show', $motard->slug)) !!}
                                    </div>

                                    {{-- Boutons --}}
                                    <div class="mt-2 d-flex justify-content-center flex-wrap gap-1">
                                        <a href="{{ route('motards.show', $motard->slug) }}" target="_blank" class="btn btn-info btn-sm no-print">Voir</a>
                                        <a href="{{ route('motards.carte', $motard->slug) }}" target="_blank" class="btn btn-primary btn-sm no-print">Imprimer la carte</a>
                                        <a href="{{ route('motards.edit', $motard->id) }}" class="btn btn-warning btn-sm no-print">Modifier</a>

                                        <form action="{{ route('motards.destroy', $motard->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm no-print" onclick="return confirm('Voulez-vous vraiment supprimer ce motard ?')">Supprimer</button>
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

@endsection

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }

    /* Responsive pour les cartes de motards */
    @media (max-width: 768px) {
        .table-responsive-motards {
            overflow-x: auto;
        }

        .motard-card {
            width: 100% !important;
        }

        .motard-card img {
            width: 80px;
            height: 80px;
        }

        .motard-card .btn {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .motard-card div {
            font-size: 0.9rem;
        }

        h3 {
            font-size: 1.1rem;
        }
    }
</style>
@endpush
