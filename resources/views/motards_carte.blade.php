
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte du Motard</title>
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }

        .carte {
            width: 212.4px;
            height: 324px;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            font-family: Arial, sans-serif;
            margin: auto;
        }

        .carte img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .carte .nom {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .carte .matricule {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }

        .carte .qr {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    <div class="carte">  
        <img src="{{ asset('storage/' . $motard->photo) }}" alt="Photo du motard">
        <div class="nom">{{ $motard->prenom }} {{ $motard->nom }}</div>
        <div class="matricule">Matricule : {{ $motard->matricule }}</div>
        <div class="qr">
            {!! QrCode::size(50)->generate(route('motards.show', $motard->slug)) !!}
            <br>
            <br>
             <strong>Ligne: {{ $motard->ligne }}
                <br>
                <br>
             {{ $motard->base_stationnement }}</strong> 
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">Imprimer</button>
    </div>

</body>
</html>
