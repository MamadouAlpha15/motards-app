<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Impression des Motards Sélectionnés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }
        .carte-motard {
            width: 250px;
            margin: 10px;
            border: 2px solid #0d6efd;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            background: #f8f9fa;
        }
        .photo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="text-center mb-4">
        <button onclick="window.print()" class="btn btn-primary no-print">
            <i class="bi bi-printer"></i> Imprimer Tout
        </button>
    </div>

    <div class="d-flex flex-wrap justify-content-center">
        @foreach($motards as $motard)
            <div class="carte-motard shadow-sm">
                <img src="{{ asset('storage/' . $motard->photo) }}" class="photo" alt="Photo de {{ $motard->prenom }}">
                <h5 class="mt-2">{{ $motard->prenom }} {{ $motard->nom }}</h5>
                <p class="text-muted">{{ $motard->matricule }}</p>
                <div class="mt-2">
                    {!! QrCode::size(80)->generate(route('motards.show', $motard->slug)) !!}
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
