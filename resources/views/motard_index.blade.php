{{-- resources/views/motard_index.blade.php --}}
@extends('layouts.app')

@section('content')

<!---afficha de l'utilisateur connecter !--->
@if(Auth::check())
    <div class="alert alert-info text-center fw-bold">
        Utilisateur connecté : {{ Auth::user()->email }}
    </div>
@endif


<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="motards-container p-4 shadow-lg rounded-4">
    <h2 class="text-center mb-5 fw-bold text-primary">🚀 Gestion des Motards 🚀</h2>

     <a href="{{route('admin.liste')}}" class="btn btn-secondary ">
        <i class="bi bi-people"></i> Voir les Administrateurs
    </a>
     <hr>
    {{-- Message de succès --}}
        @if (session('success'))
            <div class="alert alert-success mx-3">
                {{ session('success') }}
            </div>
        @endif
        
    <!-- Recherche -->
    <form method="GET" action="{{ route('motards.index') }}" class="mb-5">
        <div class="input-group shadow rounded">
            <input type="text" name="recherche" class="form-control form-control-lg"
                   placeholder="🔎 Rechercher un motard..." value="{{ request('recherche') }}">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-search"></i> Rechercher
            </button>
            @if(request('recherche'))
                <a href="{{ route('motards.index') }}" class="btn btn-secondary btn-lg">
                    <i class="bi bi-arrow-counterclockwise"></i> Annuler
                </a>
            @endif
        </div>
    </form>

    @if($recherche)
        <div class="alert alert-info text-center shadow-sm rounded p-3 mb-4">
            Résultats pour : <strong>{{ $recherche }}</strong>
        </div>
    @endif

    <!-- Ajouter -->
    <div class="text-end mb-4">
        <a href="{{ route('motards.create') }}" class="btn btn-success btn-lg shadow-sm">
            <i class="bi bi-plus-circle-dotted"></i> Ajouter un Motard
        </a>

    </div>

    <!-- CONTRÔLE SUPPRESSION SÉLECTIONNÉE & IMPRIMER -->
    <div class="d-flex align-items-center flex-wrap gap-4 mb-4">
        <!-- Formulaire bulk delete -->
        <form id="form-supprimer-selection"
              action="{{ route('motards.deleteSelected') }}"
              method="POST">
            @csrf
            @method('POST')
            <button type="submit"
                    class="btn btn-danger btn-lg shadow-sm"
                    onclick="return confirm('Confirmer la suppression des motards sélectionnés ?')">
                <i class="bi bi-trash3"></i> Supprimer la sélection
            </button>
        </form>

        <!-- Imprimer la sélection -->
        <a href="#" id="imprimer-selection" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-printer"></i> Imprimer la sélection
        </a>

        <!-- Sélectionner Tous (rattaché au même formulaire) -->
        <div class="form-check fs-5">
            <input form="form-supprimer-selection"
                   class="form-check-input"
                   type="checkbox"
                   id="select-all-header">
            <label class="form-check-label" for="select-all-header">
                Sélectionner Tous
            </label>
        </div>
    </div>

    @if($motardsParLigne->isEmpty())
        <div class="alert alert-warning text-center p-4 shadow-sm rounded">
            <!-- ton switch pour le message d'absence -->
            <!-- … -->
        </div>
    @else
        @foreach($motardsParLigne as $ligne => $motards)
            <h3 class="mb-4 mt-5 text-info fw-bold">
                🚦 Ligne {{ $ligne }} –
                {{ $motards->first()->base_stationnement ?? 'Station inconnue' }}
            </h3>

            <div class="table-responsive-motards mb-5">
                <table class="table table-hover table-bordered align-middle shadow-sm rounded-4 overflow-hidden">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>
                                <!-- Checkbox de sélection dans le header -->
                                <input id="select-all" type="checkbox">
                            </th>
                            <th>Nom</th>
                            <th class="border-start">Stationnement</th>
                            <th class="text-center border-start">Carte Motard</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($motards as $motard)
                            <tr>
                                <td>
                                    <!-- Chaqu'une de ces cases appartient au formulaire bulk delete -->
                                    <input form="form-supprimer-selection"
                                           type="checkbox"
                                           name="motards_selection[]"
                                           value="{{ $motard->id }}"
                                           class="checkbox-motard">
                                </td>
                                <td>{{ $motard->prenom }} {{ $motard->nom }}</td>
                                <td class="border-start">{{ $motard->base_stationnement }}</td>
                                <td class="text-center border-start">
                                    <div class="motard-card bg-light p-3 rounded shadow-sm d-inline-block">
                                        <img src="{{ asset('storage/' . $motard->photo) }}"
                                             alt="photo"
                                             class="img-thumbnail mb-2"
                                             style="width:110px;height:110px;object-fit:cover;">

                                        <div class="fw-bold">
                                            {{ $motard->prenom }} {{ $motard->nom }}
                                        </div>
                                        <div class="text-muted">{{ $motard->matricule }}</div>
                                        <div class="mt-2">
                                            {!! QrCode::size(70)->generate(route('motards.show', $motard->slug)) !!}
                                        </div>

                                        <div class="mt-3 d-flex flex-wrap justify-content-center gap-2">
                                            <!-- Inline delete reste dans son propre formulaire -->
                                            <a href="{{ route('motards.show', $motard->slug) }}"
                                               target="_blank"
                                               class="btn btn-outline-info btn-sm no-print">
                                                <i class="bi bi-eye"></i> Voir
                                            </a>
                                            <a href="{{ route('motards.carte', $motard->slug) }}"
                                               target="_blank"
                                               class="btn btn-outline-primary btn-sm no-print">
                                                <i class="bi bi-printer"></i> Imprimer
                                            </a>
                                            <a href="{{ route('motards.edit', $motard->id) }}"
                                               class="btn btn-outline-warning btn-sm no-print">
                                                <i class="bi bi-pencil-square"></i> Modifier
                                            </a>
                                            <form action="{{ route('motards.destroy', $motard->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-outline-danger btn-sm no-print"
                                                        onclick="return confirm('Supprimer ce motard ?')">
                                                    <i class="bi bi-trash3"></i> Supprimer
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

{{-- Scripts de sélection et impression --}}
<script>
    // Sélection “header”
    document.getElementById('select-all').addEventListener('change', function() {
        document.querySelectorAll('.checkbox-motard')
                .forEach(cb => cb.checked = this.checked);
        document.getElementById('select-all-header').checked = this.checked;
    });
    document.getElementById('select-all-header').addEventListener('change', function() {
        document.querySelectorAll('.checkbox-motard')
                .forEach(cb => cb.checked = this.checked);
        document.getElementById('select-all').checked = this.checked;
    });

    // Impression bulk
    document.getElementById('imprimer-selection').addEventListener('click', e => {
        e.preventDefault();
        let ids = Array.from(document.querySelectorAll('.checkbox-motard:checked'))
                       .map(cb => cb.value);
        if (!ids.length) { return alert('Veuillez sélectionner au moins un motard.'); }
        window.open("{{ route('motards.imprimerSelection') }}?ids=" + ids.join(','), '_blank');
    });
</script>

{{-- Script pour conserver la position de scroll après suppression --}}
<script>
    // Avant envoi du bulk-delete, on stocke la position
    document.getElementById('form-supprimer-selection')
      .addEventListener('submit', () => {
        sessionStorage.setItem('motardIndexScroll', window.scrollY);
      });

    // Avant chaque suppression individuelle, on stocke aussi la position
    document.querySelectorAll('.btn-outline-danger.btn-sm.no-print')
      .forEach(btn => {
        btn.addEventListener('click', () => {
          sessionStorage.setItem('motardIndexScroll', window.scrollY);
        });
      });

    // Au chargement, on restaure la position si elle existe
    window.addEventListener('load', () => {
      const pos = sessionStorage.getItem('motardIndexScroll');
      if (pos !== null) {
        window.scrollTo(0, parseInt(pos, 10));
        sessionStorage.removeItem('motardIndexScroll');
      }
    });
</script>

@endsection
