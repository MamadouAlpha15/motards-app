<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Motards')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            
            font-family: Arial, sans-serif;
        }
        header {
            background-color: #212529;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
        main {
            padding: 30px 15px;
        }
        footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            padding: 20px;
        }
    </style>
</head>
<body>

    <!-- En-tête -->
    @if (!isset($hideHeader))
<header>
    @if(Auth::check())
        <div class="text-end me-3">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn btn-sm btn-danger">Déconnexion</button>
            </form>
        </div>
    @endif

    @if(auth()->check() && auth()->user()->is_admin)
        <a href="{{ route('admin.settings') }}">Paramètres Admin</a>
    @endif

    <h1>Gestion des Motards</h1>
</header>
@endif


<main class="p-0 m-0 w-100">
    @yield('content')
</main>


    <!-- Pied de page -->
    <footer>
        &copy; {{ date('Y') }} - Projet Motards QR Code
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</body>
</html>
