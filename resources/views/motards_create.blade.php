{{-- resources/views/motards_create.blade.php --}}

@extends('layouts.app') {{-- Étend le layout principal pour récupérer le header, footer, etc. --}}

@section('content') {{-- Débute la section "content" du layout --}}

    @if ($errors->any()) {{-- Si la validation a généré des erreurs --}}
        <div class="alert alert-danger"> {{-- Boîte d’alerte rouge --}}
            <ul class="mb-0"> {{-- Liste sans marge inférieure --}}
                @foreach ($errors->all() as $error) {{-- Parcourt chaque message d’erreur --}}
                    <li>{{ $error }}</li> {{-- Affiche le message d’erreur --}}
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container py-5"> {{-- Conteneur Bootstrap avec padding vertical --}}
        <div class="row justify-content-center"> {{-- Centre horizontalement la colonne --}}
            <div class="col-md-8 col-lg-6"> {{-- Taille de la colonne sur md et lg --}}
                <div class="card p-4 shadow-sm"> {{-- Carte blanche avec ombre et padding --}}
                    <h2 class="text-center mb-4">Ajouter un Motard</h2> {{-- Titre centré --}}

                    <form 
                        method="POST" 
                        action="{{ route('motards.store') }}" {{-- URL pour stocker via la route nommée motards.store --}}
                        enctype="multipart/form-data" {{-- Nécessaire pour envoyer un fichier --}}
                    >
                        @csrf {{-- Jeton CSRF pour la sécurité du formulaire --}}

                        {{-- Champ Nom --}}
                        <div class="mb-3"> {{-- Marge inférieure --}}
                            <input 
                                class="form-control"  {{-- Style Bootstrap --}}
                                name="nom"           {{-- Nom du champ envoyé au contrôleur --}}
                                placeholder="Nom"    {{-- Texte d’aide --}}
                                value="{{ old('nom') }}" {{-- Récupère l’ancienne saisie après erreur --}}
                            >
                        </div>

                        {{-- Champ Prénom --}}
                        <div class="mb-3">
                            <input 
                                class="form-control" 
                                name="prenom" 
                                placeholder="Prénom" 
                                value="{{ old('prenom') }}"
                            >
                        </div>

                        {{-- Champ Téléphone --}}
                        <div class="mb-3">
                            <input 
                                class="form-control" 
                                name="telephone" 
                                placeholder="Téléphone" 
                                value="{{ old('telephone') }}"
                            >
                        </div>

                        {{-- Champ Ligne --}}
                        <div class="mb-3">
                            <input 
                                class="form-control" 
                                name="ligne" 
                                placeholder="Ligne" 
                                value="{{ old('ligne') }}"
                            >
                        </div>

                        {{-- Champ Numéro du tuteur --}}
                        <div class="mb-3">
                            <input 
                                class="form-control" 
                                name="numero_tuteur" 
                                placeholder="Numéro du tuteur" 
                                value="{{ old('numero_tuteur') }}"
                            >
                        </div>

                        {{-- Champ Matricule --}}
                        <div class="mb-3">
                            <input 
                                class="form-control" 
                                name="matricule" 
                                placeholder="Matricule" 
                                value="{{ old('matricule') }}"
                            >
                        </div>

                        {{-- Champ Base de stationnement --}}
                        <div class="mb-3">
                            <input 
                                class="form-control" 
                                name="base_stationnement" 
                                placeholder="Base de stationnement" 
                                value="{{ old('base_stationnement') }}"
                            >
                        </div>

                        {{-- Input fichier pour la photo --}}
                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo du motard</label> {{-- Étiquette --}}
                            <input
                                class="form-control"   {{-- Style Bootstrap --}}
                                type="file"            {{-- Type fichier --}}
                                name="photo"           {{-- Nom du champ --}}
                                id="photo"             {{-- ID pour JS --}}
                                accept="image/*"       {{-- N’accepte que les images --}}
                            >
                        </div>

                        {{-- Aperçu de l’image sélectionnée --}}
                        <div class="mb-3 text-center">
                            <img 
                                id="preview-image"               {{-- ID pour JS --}}
                                src=""                           {{-- src vide par défaut --}}
                                alt="Aperçu de la photo"         {{-- Texte alternatif --}}
                                style="                          {{-- Styles en ligne pour limiter la taille --}}
                                    max-width: 200px;
                                    max-height: 200px;
                                    display: none;              {{-- Caché tant qu’aucune image --}}
                                    border-radius: 8px; 
                                    box-shadow: 0 0 8px rgba(0,0,0,0.2);
                                "
                            >
                        </div>

                        {{-- Bouton de soumission --}}
                        <div class="d-grid">
                            <button class="btn btn-primary">Enregistrer</button> {{-- Bouton bleu --}}
                        </div>
                    </form>

                </div> {{-- Fin de la carte --}}
            </div> <!-- Fin colonne -->
        </div> <!-- Fin row -->
    </div> <!-- Fin container -->

    {{-- Style de fond global --}}
    <style>
        body {
            background-color: steelblue; /* Fond bleu acier */
        }
    </style>

    {{-- Script JS pour afficher l’aperçu d’image --}}
    <script>
        // Sélectionne l’input de type file
        document.getElementById('photo').addEventListener('change', function(event) {
            const [file] = event.target.files;         // Récupère le premier fichier
            if (file) {                                // Si un fichier est sélectionné
                const preview = document.getElementById('preview-image'); // L’élément <img>
                preview.src = URL.createObjectURL(file); // Génère l’URL temporaire
                preview.style.display = 'block';         // Affiche l’image
            }
        });
    </script>
@endsection {{-- Fin de la section content --}}
