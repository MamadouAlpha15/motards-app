<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Motards')</title> {{-- Titre de l'onglet (défaut : "Motards") --}}
    <meta name="viewport" content="width=device-width, initial-scale=1"> {{-- Responsive sur mobile --}}

    {{-- 📦 Importation de Bootstrap pour le style --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif; /* Police principale */
        }
        header {
            background-color: #212529; /* Fond sombre */
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        main {
            padding: 30px 15px; /* Marges autour du contenu principal */
        }
        footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            padding: 20px;
        }
        .commune-banner {
            background:rgba(13, 213, 253, 0.76); /* Fond bleu */
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>
<body>

{{-- 🧩 Bloc HEADER (visible sauf si $hideHeader est défini dans la vue) --}}
@if (!isset($hideHeader))
<header>

 {{-- 🌍 Affichage du nom de la commune (admin connecté OU superadmin avec ?commune=...) --}}
    @php
        $communeSlug = request()->query('commune'); // slug dans l'URL
        $commune = $communeSlug
            ? \App\Models\Commune::where('slug', $communeSlug)->first()
            : (Auth::user()->commune ?? null); // sinon on prend la commune liée à l'utilisateur
    @endphp

    {{-- 🎯 Si une commune est trouvée, on l'affiche dans une bannière --}}
    @if($commune)
        <div class="commune-banner">
            🏘️ Commune : {{ $commune->nom }}
        </div>
    @endif


    {{-- ✅ Si un utilisateur est connecté --}}
    @if(Auth::check())
    <div class="d-flex justify-content-end align-items-center gap-2 me-3 mb-2">
        
        {{-- ➕ Le bouton "Créer un Admin" est visible seulement si c'est un super admin et pas sur la page "register" --}}
        @if (Auth::user()->is_super_admin && !Request::is('register'))
            <a href="{{ route('register') }}" class="btn btn-sm btn-success">
                <i class="fas fa-user-plus"></i> Créer un Admin
            </a>
        @endif

        {{-- 🔓 Bouton pour se déconnecter --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-sm btn-danger">Déconnexion</button>
        </form>
    </div>
    @endif

    {{-- ⚙️ Lien vers les paramètres admin (uniquement pour les admins) --}}
    @if(auth()->check() && auth()->user()->is_admin && !Request::is('register'))
        <a href="{{ route('admin.settings') }}" class="text-white">Paramètres Admin</a>
    @endif

    {{-- 🏷️ Titre de la page --}}
    <h1>Gestion des Motards</h1>

    {{-- 🔙 Bouton retour (uniquement visible pour le super admin quand il est dans une commune) --}}
@if(Auth::check() && Auth::user()->is_super_admin && request()->has('commune'))
    <div class="d-flex justify-content-center my-4">
        <a href="{{ route('communes.choix') }}" class="btn btn-warning btn-lg shadow-sm px-4">
            ⬅ Retour à la liste des communes
        </a>
    </div>
@endif



   
    {{-- 🔽 Menu déroulant pour choisir une commune (uniquement visible dans la page choix-commune pour superadmin) --}}
    @if(Auth::check() && Auth::user()->is_super_admin && Request::is('choix-commune'))
    <div class="dropdown mt-3">
        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
            Choisir une commune
        </button>
        <ul class="dropdown-menu">
            @foreach(\App\Models\Commune::all() as $c)
                <li>
                    <a class="dropdown-item" href="{{ route('motards.index', ['commune' => $c->slug]) }}">
                        {{ $c->nom }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

</header>
@endif

{{-- 🧾 Contenu principal (inclus dans chaque vue avec @section('content')) --}}
<main class="p-0 m-0 w-100">
    @yield('content')
</main>

{{-- 🦶 Pied de page --}}
<footer>
    &copy; {{ date('Y') }} - Projet Motards QR Code
</footer>

{{-- 📦 Scripts nécessaires : Bootstrap + FontAwesome --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</body>
</html>
