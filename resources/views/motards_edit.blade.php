{{-- resources/views/motards_edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card p-4 shadow-sm">
                <h2 class="text-center mb-4">Modifier le Motard</h2>  
                <form method="POST" action="{{ route('motards.update', $motard->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <input class="form-control" name="nom" placeholder="Nom" value="{{ old('nom', $motard->nom) }}">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="prenom" placeholder="Prénom" value="{{ old('prenom', $motard->prenom) }}">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="telephone" placeholder="Téléphone" value="{{ old('telephone', $motard->telephone) }}">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="ligne" placeholder="Ligne" value="{{ old('ligne', $motard->ligne) }}">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="numero_tuteur" placeholder="Numéro du tuteur" value="{{ old('numero_tuteur', $motard->numero_tuteur) }}">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="matricule" placeholder="Matricule" value="{{ old('matricule', $motard->matricule) }}">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="base_stationnement" placeholder="Base de stationnement" value="{{ old('base_stationnement', $motard->base_stationnement) }}">
                    </div>

                    <div class="mb-3">
                        <label for="photo-input" class="form-label">Changer la photo (optionnel)</label>
                        <input 
                            class="form-control" 
                            type="file" 
                            name="photo" 
                            id="photo-input" 
                            accept="image/*"
                        >
                        {{-- Aperçu : on lui donne un ID pour pouvoir changer le src --}}
                        <img 
                            id="photo-preview" 
                            src="{{ $motard->photo ? asset('storage/' . $motard->photo) : '' }}" 
                            alt="Aperçu de la photo" 
                            class="mt-2 rounded" 
                            style="width:100px; height:100px; object-fit:cover; {{ $motard->photo ? '' : 'display:none;' }}"
                        >
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-warning">Mettre à jour</button>
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

<script>
    // Quand on choisit un nouveau fichier, on remplace l'aperçu
    document.getElementById('photo-input').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('photo-preview');
            preview.src = URL.createObjectURL(file);   // met à jour la source
            preview.style.display = 'block';           // assure qu'il est visible
        }
    });
</script>
@endsection
