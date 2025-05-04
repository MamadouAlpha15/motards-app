{{-- resources/views/publicite.blade.php --}}
@extends('layouts.app')  {{-- Étend le layout principal situé dans resources/views/layouts/app.blade.php --}}

@php
    // Début d’un bloc PHP : on définit un tableau de noms de fichiers et un tableau de descriptions
    $mairePhotos = ['maire1.jpg', 'maire2.jpg', 'maire3.jpg', 'maire4.jpg'];
    $commentaires = [
        'Le maire en réunion avec nos motards, pour renforcer notre engagement commun.',
        'Visite officielle à la base centrale : confiance et collaboration.',
        'Sensibilisation à la sécurité routière, priorité de chaque instant.',
        'Échange avec les chefs de ligne : vision et solidarité.'
    ];
    shuffle($mairePhotos); // Mélange aléatoirement l’ordre des photos pour varier l’affichage
@endphp

@php $hideHeader = true; @endphp  {{-- Cache le header global du layout si nécessaire --}}

@section('content')  {{-- Début de la section "content" qui remplace @yield('content') dans le layout --}}

<style>
    /* ==== Fond général ultrajolie ==== */
    body {
        /* dégradé diagonal du haut-gauche vers le bas-droit */
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        min-height: 100vh;      /* s’assure que le body prend toute la hauteur */
        color: #333;            /* couleur du texte */
        margin: 0;              /* supprime marges par défaut du navigateur */
        padding: 0;             /* supprime padding par défaut du navigateur */
        box-sizing: border-box; /* inclut padding et border dans la taille des éléments */
    }

    /* ==== Header principal ==== */
    .site-header {
        background: linear-gradient(to right,rgb(28, 17, 153), #38ef7d); /* dégradé horizontal */
        padding: 0.5rem 1rem;            /* espace intérieur du header */
        display: flex;                   /* active le flexbox */
        flex-wrap: wrap;                 /* permet aux colonnes de passer à la ligne sur mobile */
        align-items: center;             /* centre verticalement les éléments */
        justify-content: space-between;  /* écarte les éléments aux extrémités */
        color: white;                    /* texte en blanc */
    }
    .site-header .left {
        text-align: center;              /* centre le texte/image horizontalement */
    }
    .site-header img.logo {
        height: 130px;                   /* fixe la hauteur du logo */
        margin-bottom: .5rem;             /* espace sous le logo */
        float: left;   
    }
    .site-header .title {
        font-size: 1.2rem;               /* taille du texte du titre */
        font-weight: bold;               /* texte en gras */
    }
    .site-header .right {
        text-align: center;              /* centre le contenu à droite */
    }
    .photo-row {
        display: flex;                   /* ligne d’images */
        gap: 1rem;                       /* espace entre chaque photo */
        justify-content: center;         /* centre les photos */
    }
    .photo-cadre {
        width: 120px;                    /* largeur de chaque photo */
        height: 120px;                   /* hauteur de chaque photo */
        object-fit: cover;               /* recadre l’image pour remplir le cadre */
        border: 3px solid white;         /* bordure blanche autour */
        border-radius: 8px;              /* coins arrondis */
        transition: transform .3s;       /* animation de zoom au survol */
    }
    .photo-cadre:hover {
        transform: scale(1.05);          /* zoom léger au survol */
    }
    .contact-link {
        display: inline-block;           /* agit comme un bouton en ligne */
        margin-top: .5rem;               /* espace au-dessus */
        padding: .5rem 1rem;             /* espace intérieur */
        background: rgba(255,255,255,0.2); /* fond semi-transparent */
        border-radius: 8px;              /* coins arrondis */
        color: white;                    /* texte blanc */
        text-decoration: none;           /* supprime le soulignement */
        transition: background .3s;      /* animation au survol */
    }
    .contact-link:hover {
        background: rgba(255,255,255,0.4); /* change l’opacité au survol */
    }

    /* ==== Section d'accueil ==== */
    .hero-section {
        /* image de fond fixe qui couvre tout l’élément */
        background-image: url('{{ asset("storage/photos/font.jpg") }}');
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
        height: 60vh;                    /* 60% de la hauteur de la fenêtre */
        display: flex;                   /* active flex pour centrer le titre */
        align-items: center;
        justify-content: center;
        text-shadow: 2px 2px 6px rgba(0,0,0,0.7); /* ombre autour du texte */
    }
    .hero-section h1 {
        color: white;                    /* texte en blanc */
        font-size: 3rem;                 /* très grand titre */
        margin: 0;                       /* supprime marges autour du h1 */
    }

    /* ==== Présentation ==== */
    .intro-text {
        max-width: 800px;                /* largeur max pour faciliter la lecture */
        margin: 2rem auto;               /* centré avec marge verticale */
        text-align: center;              /* texte centré */
        font-size: 1.1rem;               /* taille de police un peu plus grande */
    }

    /* ==== "Le Maire" ==== */
    .nos-formations-section {
        background: rgba(0,0,0,0.5);      /* fond sombre semi-transparent */
        padding: 3rem 1rem;               /* espace intérieur large */
        border-radius: 20px;              /* coins très arrondis */
        color: white;                     /* texte blanc */
    }
    .formation-box {
        margin-bottom: 2rem;              /* espace sous chaque carte */
    }
    .formation-img {
        width: 100%;                      /* prend toute la largeur de son parent */
        height: 200px;                    /* hauteur fixe */
        object-fit: cover;                /* recadre l’image proprement */
        border: 4px solid #1abc9c;        /* bordure colorée */
        border-radius: 8px;               /* coins arrondis */
        transition: transform .4s, box-shadow .4s; /* animation au survol */
    }
    .formation-img:hover {
        transform: scale(1.05);           /* zoom un peu plus grand */
        box-shadow: 0 0 20px rgba(26,188,156,0.6); /* ombre colorée */
    }
    .formation-box p {
        margin-top: .5rem;                /* petit espace au-dessus du texte */
        font-weight: bold;                /* texte en gras */
    }

    /* ==== Staffs / Groupe ==== */
    .staff-card {
        background: white;                /* fond blanc */
        padding: 1rem;                    /* espace intérieur */
        border-radius: 12px;              /* coins arrondis */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* légère ombre */
        text-align: center;               /* contenu centré */
    }
    .staff-card img {
    width: 100%;      /* l’image prend toute la largeur de son conteneur */
    height: 400px;     /* la hauteur s’ajuste proportionnellement */
    object-fit: cover;/* recadre proprement l’image si nécessaire */
    border-radius: 8px;
    margin-bottom: .5rem;
}
    .staff-card p {
        color: #555;                      /* texte gris foncé */
        font-size: .95rem;                /* taille légèrement réduite */
    }

    /* ==== Taxi Moto animé ==== */
    .animated-section {
        display: flex;                    /* affiche en ligne */
        justify-content: center;          /* centre horizontalement */
        align-items: center;              /* centre verticalement */
        gap: 2rem;                        /* espace entre les items */
        margin: 3rem 0;                   /* marge verticale */
        flex-wrap: wrap;                  /* passe à la ligne sur petits écrans */
    }
    .animated-text {
        font-size: 1.5rem;                /* taille du texte */
        font-weight: bold;                /* texte en gras */
        color: #1abc9c;                   /* couleur verte */
        animation: blinkText 2s infinite; /* animation de clignotement */
    }
    @keyframes blinkText {
        0%,100% { opacity: 0; transform: translateY(-10px); }
        50%     { opacity: 1; transform: translateY(0); }
    }
    .decorative-img {
        
        height: 180px;                    /* hauteur fixe */
        border-radius: 12px;              /* coins arrondis */
        box-shadow: 0 0 15px rgba(0,0,0,0.2); /* ombre légère */
    }

    /* ==== Section Guinée ==== */
    .guinee-section {
        text-align: center;               /* texte centré */
        margin: 3rem 0;                   /* marge verticale */
    }
    .guinee-text {
        max-width: 700px;                 /* largeur max pour la lecture */
        margin: 1rem auto;                /* centré horizontalement */
        font-size: 1.05rem;               /* taille de police confortable */
    }

    /* ==== Carrousel Chefs de Lignes ==== */
    .ligne-carousel-container {
        position: relative;               /* pour positionner les flèches */
        overflow: hidden;                 /* masque les parties dépassant */
        padding: 1rem 0;                  /* espace vertical */
    }
    .ligne-carousel {
        display: flex;                    /* ligne d’éléments */
        gap: 1rem;                        /* espace entre les cartes */
        overflow-x: auto;                 /* scroll horizontal */
        scroll-snap-type: x mandatory;    /* "snap" pour chaque carte */
        scrollbar-width: none;            /* masque la barre de scroll sous Firefox */
    }
    .ligne-carousel::-webkit-scrollbar {  /* masque la barre sous Chrome */
        display: none;
    }
    .ligne-card {
        min-width: 250px;                 /* largeur minimale de chaque carte */
        background: #f5f5f5;              /* fond gris clair */
        border-radius: 12px ;              /* coins arrondis */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* ombre légère */
        scroll-snap-align: start;         /* ancre au début du scroll-snap */
        text-align: center;               /* contenu centré */
        padding: 1rem;                    /* espace intérieur */
    }
    .ligne-card img {
        width: 100%;                      /* pleine largeur de la carte */
        height: 400px;                    /* hauteur fixe */
        object-fit: cover;                /* recadrage propre */
        border-radius: 8px;               /* coins arrondis */
        margin-bottom: .5rem;             /* espace sous l’image */
    }
    .chef-info h5,
    .chef-info p {
        margin: 0;                        /* supprime marges par défaut */
        font-size: .9rem;                 /* taille réduite */
        color: #333;                      /* texte gris foncé */
    }
    .carousel-btn {
        position: absolute;               /* positionné par rapport à .ligne-carousel-container */
        top: 50%;                         /* centre verticalement */
        transform: translateY(-50%);      /* ajuste exactement le centrage vertical */
        background: #1abc9c;              /* couleur verte */
        border: none;                     /* pas de bordure */
        color: white;                     /* flèche blanche */
        font-size: 1.5rem;                /* taille de la flèche */
        width: 2.5rem;                    /* largeur du bouton */
        height: 2.5rem;                   /* hauteur du bouton */
        border-radius: 50%;               /* rond */
        cursor: pointer;                  /* curseur pointeur */
        z-index: 1;                       /* passe devant le contenu */
    }
    .prev-btn { left: .5rem; }            /* bouton "précédent" à gauche */
    .next-btn { right: .5rem; }           /* bouton "suivant" à droite */
</style>

<div class="publicite-container">

    <!-- En-tête principal -->
    <div class="site-header">
        <!-- Colonne de gauche : logo + titre -->
        <div class="left">
            <img src="{{ asset('storage/photos/logo.jpg') }}" class="logo" alt="Logo">
            <div class="title">Centre d'information Motards</div>
        </div>
        <!-- Texte central : nom de la commune -->
        <h1 class="welcome-text">COMMUNE URBAINE DE DUBREKA</h1>
        <!-- Colonne droite dans le header -->
<div class="right col-12 col-md-4 text-center">
  <!-- on utilise d-flex + justify-content-center pour centrer -->
  <div class="d-flex justify-content-center mb-2">
    <img src="{{ asset('storage/photos/sadjo1.jpg') }}"
         class="photo-cadre mx-1"
         alt="Sadjo 1">
    <img src="{{ asset('storage/photos/sadjo2.jpg') }}"
         class="photo-cadre mx-1"
         alt="Sadjo 2">
  </div>
  <a href="mailto:sadjosow187@gmail.com" class="contact-link d-block mb-1">
    📧 sadjosow187@gmail.com
  </a>
  <div class="contact-phone">📞 +224 628 416 997</div>
</div>
    </div>

    <!-- Section "Hero" : image de fond + titre -->
    <div class="hero-section">
        <h1>Site d'information Motards Certifiée</h1>
    </div>

    <!-- Petit paragraphe d’introduction centré -->
    <p class="intro-text">
        Bienvenue dans votre guide ultime des motards de Dubréka !<br>
        Actualités exclusives, portraits de passionnés et conseils de pros : tout pour rouler en confiance.
    </p> <br>
    <p class="text-center">Chaque matin vous offre une nouvelle chance de vous réinventer : saisissez-la avec gratitude. Devenez le héros de votre propre aventure, avec pour seule limite l’horizon de votre imagination. La détermination que vous incarnez est capable de transformer l’impossible en possible, pas à pas. Avancez avec passion et confiance, et vous verrez que les résultats suivront naturellement. Vos talents sont uniques et précieux : n’hésitez pas à les partager généreusement avec le monde. Ne sous-estimez jamais le pouvoir d’un rêve alimenté par une action résolue. Vivez chaque instant avec intensité, présence et gratitude, car c’est là que résident les plus grands trésors. Poursuivez vos idées jusqu’au bout, elles sont l’expression vivante de votre potentiel illimité. L’optimisme, lorsqu’il est cultivé chaque jour, devient le moteur des plus belles réussites. Vous détenez entre vos mains le pouvoir de façonner l’avenir : prenez-en la mesure et agissez. Semez aujourd’hui les graines de vos succès de demain, en prenant soin de chaque détail. Osez prendre confiance en vous, car votre capacité à réussir est sans borne. Les plus belles victoires naissent souvent des défis les plus redoutables : souriez-leur. Accueillez chaque obstacle comme une occasion de vous fortifier et de faire valoir votre caractère. Donnez toujours le meilleur de vous-même, sans compromis, et vous brillerez de mille feux. Votre grande aventure commence maintenant : avancez avec cœur, courage et enthousiasme infini.</p>

    <!-- Section "Le Maire" -->
    <div class="nos-formations-section">
        <h2 class="text-center mb-5">Le Maire</h2>
        <div class="row justify-content-center">
            @foreach($mairePhotos as $i => $photo)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 formation-box">
                    <img src="{{ asset('storage/photos/'.$photo) }}" class="formation-img" alt="Photo du Maire">
                    <p>{{ $commentaires[$i] }}</p>
                </div>
            @endforeach
        </div>
    </div>
       <p class="text-center">Vos actes d’aujourd’hui constituent la fondation de l’avenir que vous construisez : choisissez-les avec soin et courage. Osez rêver grand et, surtout, osez agir maintenant pour que vos rêves ne restent pas de simples chimères. Votre détermination, solide comme une armure, est le super-pouvoir qui vous permettra de relever n’importe quel défi. Chaque revers que vous vivez est une leçon précieuse : accueillez-le, tirez-en la sagesse nécessaire et repartez plus fort que jamais. Écrivez votre histoire avec authenticité et audace, en mêlant passion et persévérance à chaque chapitre. La passion qui brûle dans votre cœur est cette étincelle capable d’enflammer votre route vers le succès. Osez sortir des sentiers battus, car c’est là, hors de votre zone de confort, que se cachent les plus grandes beautés. Ne mettez aucune limite à vos rêves : laissez-les vous guider vers des horizons infinis. Soyez fier de chaque petite avancée, car c’est l’accumulation de ces pas modestes qui conduit aux plus hautes montagnes. L’enthousiasme que vous portez est une force contagieuse : partagez-le et vous verrez votre entourage s’enflammer à son tour. Fixez-vous des objectifs ambitieux et poursuivez-les avec ferveur. La confiance en soi se forge comme un muscle : exercez-la, renforcez-la et observez-la grandir en puissance. Accueillez le changement comme un vieil ami : il est le compagnon fidèle de toute évolution durable. Célébrez chacune de vos réussites, même les plus modestes, car elles sont le signe tangible de vos efforts. La clarté de vos intentions est le fil d’or qui guide chacun de vos pas vers la réalisation. La persévérance rend possible l’extraordinaire là où beaucoup s’arrêtent à la première difficulté.</p>
    <!-- Section "Nos Staffs / Groupe" -->
    <h2 class="mt-5 mb-4 text-center" style="color:#1abc9c;">Nos Staffs / Groupe</h2>
    @php
        $staffs = [
            'commune2.jpg' => "Sécurité & Sérénité : nos motards veillent jour et nuit à votre tranquillité.",
            'commune3.jpg' => "Technique & Innovation : équipement toujours fiable pour tous les défis.",
            'commune4.jpg' => "Communication & Convivialité : chaque échange renforce notre communauté.",
            'commune5.jpg' => "Organisation & Dynamisme : événements parfaitement orchestrés.",
            'commune.jpg'  => "Ambiance & Passion : moments inoubliables et haute énergie.",
            'commune7.jpg' => "Logistique & Rapidité : transport des équipements sans retard.",
            'commune8.jpg' => "Solidarité & Encadrement : formation et soutien à chaque nouveau.",
        ];
    @endphp
    <div class="row gx-4 gy-4 justify-content-center">
        @foreach($staffs as $photo => $texte)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="staff-card">
                    <img src="{{ asset('storage/photos/'.$photo) }}" alt="Photo staff">
                    <p>{{ $texte }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Taxi Moto centré : colonne en mobile, ligne en desktop -->
<div class="d-flex flex-column flex-sm-row justify-content-center align-items-center text-center py-3">
  <!-- Sur mobile : marge en bas ; sur sm+ : plus d’espace à droite -->
  <div class="animated-text mb-2 mb-sm-0 me-sm-3">
    
  </div>

  <!-- L’image se centre automatiquement grâce à mx-auto et d-block -->
  <img src="{{ asset('storage/photos/moto.jpg') }}"
       class="decorative-img d-block mx-auto"
       alt="Taxi Moto">

  <!-- Sur mobile : marge en haut ; sur sm+ : plus d’espace à gauche -->
  <div class="animated-text mt-2 mt-sm-0 ms-sm-3">
    
  </div>
</div>
      <p class="text-center">Osez faire le premier pas avec confiance et détermination, car la magie de toute réussite naît toujours de ce simple geste qui brise la glace et ouvre la porte à des opportunités insoupçonnées. Chaque défi se présente à vous comme une occasion précieuse de sortir grandement de votre zone de confort et d’élever votre regard vers des sommets que vous n’auriez jamais imaginés. Croyez en vous et en la force incroyable qui sommeille au fond de votre cœur, car votre potentiel est une source inépuisable de ressources et de créativité. Chaque nouveau matin se lève comme une page blanche, prête à être remplie de vos actions, de votre passion et de vos rêves les plus audacieux. L’audace vous offre le cadeau précieux de franchir des seuils où la peur aurait préféré fermer toutes les portes : ouvrez-vous sans hésiter à l’inconnu. Souriez à la vie avec un enthousiasme contagieux, et vous verrez qu’elle vous rendra cette énergie positive décuplée à chaque instant. Alimentez vos rêves comme on entretient une flamme sacrée, sans jamais laisser la moindre étincelle s’éteindre au gré des doutes. La réussite, loin d’être un privilège réservé à quelques élus, appartient à ceux qui persévèrent avec constance, même quand tous les signaux semblent au rouge. Un pas, même modeste, constitue le point de départ d’une chaîne de succès : osez avancer aujourd’hui pour récolter les victoires de demain. Cultivez la confiance en vous comme on cultive un jardin : arrosez-la chaque jour, protégez-la des mauvaises herbes du doute et elle fleurira à l’infini. L’énergie positive que vous émettez attire les opportunités extraordinaires : soyez ce phare lumineux dans la nuit de l’incertitude. Chaque obstacle se transforme, entre vos mains, en un tremplin solide qui vous propulse vers un niveau supérieur de compétence et de fierté. Prenez conscience de la force infinie qui réside en vous, car rien n’est plus puissant que la volonté d’un esprit déterminé. La persévérance est la clé d’or qui déverrouille toutes les portes verrouillées par l’adversité : gardez-la toujours à portée de main. Respirez profondément, alignez votre esprit et votre cœur, puis foncez vers vos objectifs avec une clarté renouvelée. Transformez chacun de vos doutes en une source d’élan, un carburant qui propulse votre motivation toujours plus loin. Réveillez chaque jour votre potentiel endormi et laissez-le rayonner haut et fort.</p>
      
    <!-- Section "Guinée" -->
    <div class="guinee-section">
        <img src="{{ asset('storage/photos/G.webp') }}" class="decorative-img mb-3" alt="Guinée">
        <h2>Guinée</h2>
        <p class="guinee-text">
            Partez à la découverte de nos routes sinueuses et de panoramas grandioses.<br>
            Rejoignez la communauté, vivez l’aventure motarde !
        </p>
    </div>

    <!-- Section "Les Chefs De Lignes" avec carousel -->
    <h2 class="text-center my-5" style="color:#1abc9c;">Les Chefs De Lignes</h2>
    <p class="text-center mb-4">Contactez-les pour toute question ou assistance</p>
    <div class="ligne-carousel-container">
        <button class="carousel-btn prev-btn">&#10094;</button>
        <div class="ligne-carousel" id="ligneCarousel">
            @php
                $chefs = [
                    ['image'=>'chef1.jpg','nom'=>'Ibrahima Sory Kaba','tel'=>'624050405 / 623054077','poste'=>'Chef de la Ligne Centrale'],
                    ['image'=>'chef2.jpg','nom'=>'Amadou Djouldé Diallo','tel'=>'621969983 / 662725184','poste'=>'Chef Ligne Bleu (km36)'],
                    ['image'=>'chef3.jpg','nom'=>'Mamadou Oury Bah','tel'=>'628860901 / 662589520','poste'=>'Chef Ligne Tobolou'],
                    ['image'=>'chef4.jpg','nom'=>'Mamadou Saliou Sow','tel'=>'626033222','poste'=>'Chef Ligne Grand Moulin'],
                    ['image'=>'chef5.jpg','nom'=>'Amadou Daye Diallo','tel'=>'622114822 / 664341521','poste'=>'Chef Ligne T13'],
                    ['image'=>'chef6.jpg','nom'=>'Souleymane Sow','tel'=>'624241795','poste'=>'Chef Ligne Unie Diomant'],
                    ['image'=>'chef7.jpg','nom'=>'Souleymane Diallo','tel'=>'612524079','poste'=>'Chef Ligne Kalemah'],
                    ['image'=>'chef8.jpg','nom'=>'Mohamed Sylla','tel'=>'626892589 / 662308249','poste'=>'Chef Ligne Samatran'],
                    ['image'=>'chef9.jpg','nom'=>'Amadou Oury Bah','tel'=>'628146188','poste'=>'Chef Ligne T9'],
                    ['image'=>'chef10.jpg','nom'=>'Alhassane Diallo','tel'=>'622585568','poste'=>'Chef Adjoint T10'],
                    ['image'=>'chef11.jpg','nom'=>'Mamadou Samba Bah','tel'=>'626024802','poste'=>'Chef de Ligne Centrale (Adjoint)'],
                    ['image'=>'chef12.jpg','nom'=>'Mamadou Sanoussy Diallo','tel'=>'626876645','poste'=>'Chef Carrefour Georges'],
                    ['image'=>'chef13.jpg','nom'=>'Elhadj Thiouto Bah','tel'=>'622296354','poste'=>'Trésorier Bureau Communal'],
                    ['image'=>'chef14.jpg','nom'=>'Mamadou Yéro Bah','tel'=>'620029759','poste'=>'Chef Ligne Ansoumania (2ᵉ)'],
                ];
            @endphp
            @foreach($chefs as $c)
                <div class="ligne-card">
                    <img src="{{ asset('storage/photos/'.$c['image']) }}" alt="Photo {{ $c['nom'] }}">
                    <div class="chef-info">
                        <h5>{{ $c['nom'] }}</h5>
                        <p>{{ $c['poste'] }}</p>
                        <p><strong>{{ $c['tel'] }}</strong></p>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-btn next-btn">&#10095;</button>
    </div>

</div>

<!-- Scripts d’animation et carousel -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Fade-in des blocs "Le Maire"
    document.querySelectorAll('.formation-box').forEach(box => {
        const obs = new IntersectionObserver(
            ([entry]) => entry.isIntersecting && box.classList.add('show'),
            { threshold: .2 }
        );
        obs.observe(box);
    });
    // Commandes du carousel des chefs de lignes
    const carousel = document.getElementById('ligneCarousel');
    document.querySelector('.prev-btn').onclick = () => carousel.scrollBy({ left: -300, behavior: 'smooth' });
    document.querySelector('.next-btn').onclick = () => carousel.scrollBy({ left: 300, behavior: 'smooth' });
});
</script>

@endsection  {{-- Fin de la section "content" --}}
