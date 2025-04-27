<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte du Motard</title>

    <style>
        /* Ne pas afficher les éléments avec la classe "no-print" lorsqu'on imprime */
        @media print {
            .no-print {
                display: none;
            }
        }

        /* Style de la carte motard */
        .carte {
            width: 212.4px; /* Largeur d'une carte type badge */
            height: 324px;   /* Hauteur d'une carte type badge */
            border: 1px solid #ccc; /* Bordure grise */
            padding: 20px; /* Marge intérieure */
            border-radius: 12px; /* Bords arrondis */
            text-align: center; /* Centrer le contenu */
            font-family: Arial, sans-serif; /* Police de caractères */
            margin: auto; /* Centre la carte horizontalement */
        }

        /* Style pour la photo du motard */
        .carte img {
            width: 120px; /* Largeur de l'image */
            height: 120px; /* Hauteur de l'image */
            object-fit: cover; /* Remplir sans déformer */
            border-radius: 6px; /* Coins arrondis pour l'image */
            margin-bottom: 10px; /* Espace en dessous de la photo */
        }

        /* Style du nom du motard */
        .carte .nom {
            font-size: 18px; /* Taille du texte */
            font-weight: bold; /* Texte en gras */
            margin-bottom: 5px; /* Petit espace sous le nom */
        }

        /* Style du matricule du motard */
        .carte .matricule {
            font-size: 14px; /* Taille du texte */
            color: #555; /* Couleur grise */
            margin-bottom: 10px; /* Espace en dessous du matricule */
        }

        /* Espace pour le QR Code */
        .carte .qr {
            margin-top: 10px; /* Marge en haut */
        }
    </style>
</head>

<body>

    <!-- Bloc principal contenant la carte -->
    <div class="carte">  
        {{-- Affiche la photo du motard --}}
        <img src="{{ asset('storage/' . $motard->photo) }}" alt="Photo du motard">

        {{-- Affiche le nom complet du motard --}}
        <div class="nom">{{ $motard->prenom }} {{ $motard->nom }}</div>

        {{-- Affiche le matricule du motard --}}
        <div class="matricule">Matricule : {{ $motard->matricule }}</div>

        {{-- Génération du QR Code avec les infos du motard --}}
        <div class="qr">
            {!! QrCode::size(50)->generate(route('motards.show', $motard->slug)) !!}
            <br><br>

            {{-- Ligne et base de stationnement du motard --}}
            <strong>
                Ligne: {{ $motard->ligne }}<br><br>
                {{ $motard->base_stationnement }}
            </strong>
        </div>
    </div>

    <!-- Bouton pour imprimer la carte -->
    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">Imprimer</button>
    </div>

</body>
</html>
