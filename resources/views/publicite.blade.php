@php
    $mairePhotos = ['maire1.jpg', 'maire2.jpg', 'maire3.jpg', 'maire4.jpg'];
    $commentaires = [
        'Le maire en réunion avec les motards.',
        'Visite officielle du maire à la base centrale.',
        'Le maire lors de la journée de sécurité routière.',
        'Rencontre avec les chefs de ligne.'
    ];
    shuffle($mairePhotos); // Mélange les photos
@endphp


@php $hideHeader = true; @endphp

@extends('layouts.app')

@section('content')
<style>
    /* Section de l'image d'accueil */
    .hero-section {
        background-image: url('{{ asset('storage/photos/font.jpg') }}');
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
        height: 60vh;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-shadow: 2px 2px 4px #000;
    }

    .hero-section h1 {
        font-size: 3rem;
    }

    /* En-tête avec logo et photos */
    .site-header {
        background: linear-gradient(to right, #11998e, #38ef7d);
        color: white;
        padding: 0.5rem 1rem;
        top: 0;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .site-header .left {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .site-header img.logo {
        height: 130px;
        margin-bottom: 10px;
    }

    .site-header .title {
        font-weight: bold;
        color: white;
        font-size: 1.2rem;
    }

    /* Partie droite avec les deux images et le contact */
    .site-header .right {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .right .photo-row {
        display: flex;
        flex-direction: row;
        gap: 20px;
        flex-wrap: wrap; /* Assurer que les images se réorganisent sur les petits écrans */
        justify-content: center; /* Centrer les images */
    }

    .photo-cadre {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 0 10px rgba(255,255,255,0.6);
        transition: transform 0.3s ease;
    }

    .photo-cadre:hover {
        transform: scale(1.05);
    }

    /* Lien contact en bas des deux images */
    .contact-link {
        color: #ffffff;
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: bold;
        border: 2px solid #1abc9c;
        white-space: nowrap;
    }

    .contact-link:hover {
        background-color: #1abc9c;
        color: white;
        box-shadow: 0 0 15px #1abc9c;
    }

    .nos-formations-section {
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7));




        padding: 4rem 1rem;
        border-radius: 20px;
    }

    .formation-img {
    width: 300px;
    height: 300px;
    object-fit: cover;
    object-position: top; /* 👈 Centrage sur la tête */
    border: 4px solid #1abc9c;
    transition: transform 0.4s ease, box-shadow 0.4s ease;
}


    .formation-img:hover {
        transform: scale(1.1) rotate(1deg);
        box-shadow: 0 0 25px rgba(26, 188, 156, 0.6);
    }

    .formation-box {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease-in-out;
    }

    .formation-box.show {
        opacity: 1;
        transform: translateY(0);
        animation: fadeInUp 1s ease forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .formation-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 30px;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    /* Media Query pour les petits écrans */
    @media (max-width: 768px) {
        .site-header {
            flex-direction: column;
            gap: 10px;
        }

        .right .photo-row {
            justify-content: center;
        }

        .photo-cadre {
            width: 100px;
            height: 100px; /* Ajuste la taille des images sur petits écrans */
        }
    }

    .text-contact {
        color: black !important;
        font-weight: bold;
    }

    .welcome-text {
        color: blue;
        font-weight: bold;
    }

    

@keyframes slide-moto {
  0%   { transform: translateX(0); }
  50%  { transform: translateX(150px); } /* trajet vers la droite */
  100% { transform: translateX(0); }     /* retour */
}


<!-- Texte animé + image décorative -->
<style>
    .animated-section {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 30px;
        margin-top: 30px;
        margin-bottom: 60px;
        flex-wrap: wrap;
    }

    .animated-text {
        font-size: 1.5rem;
        font-weight: bold;
        color: #1abc9c;
        animation: blinkText 2s infinite;
        white-space: nowrap;
    }

    @keyframes blinkText {
        0%   { opacity: 0; transform: translateY(-10px); }
        50%  { opacity: 1; transform: translateY(0); }
        100% { opacity: 0; transform: translateY(10px); }
    }

    .decorative-img {
        height: 180px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }

    .ligne-carousel-container {
    position: relative;
    max-width: 100%;
    overflow: hidden;
    padding: 20px;
}

.ligne-carousel {
    display: flex;
    gap: 20px;
    transition: transform 0.5s ease;
    /* scroll-behavior: smooth; */ /* ← désactive le défilement fluide automatique */
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE 10+ */
}


.ligne-carousel::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}

.ligne-card {
    min-width: 250px;
    flex-shrink: 0;
    background-color: #f5f5f5;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
    scroll-snap-align: start;
    text-align: center;
    padding: 15px;
    transition: transform 0.3s;
}

.ligne-card:hover {
    transform: scale(1.05);
}

.ligne-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 10px;
}

.chef-info h5,
.chef-info p {
    margin: 0;
    font-size: 14px;
    color: #333;
}

.carousel-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: #1abc9c;
    border: none;
    color: white;
    font-size: 2rem;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 1;
}

.prev-btn {
    left: 10px;
}

.next-btn {
    right: 10px;
}

@media (max-width: 768px) {
    .ligne-card {
        min-width: 200px;
    }
}



</style>
   


<!-- En-tête -->
<div class="site-header">
    <!-- Logo centré avec texte -->
    <div class="left">
        <img src="{{ asset('storage/photos/logo.jpg') }}" class="logo" alt="Logo">
        <span class="title">Centre d'information Motards</span>
    </div>
   
    <h1 class="welcome-text">COMMUNE URBAINE DE DUBREKA</h1>

    <!-- Deux photos + contact dessous -->
    <div class="right">
        <div class="photo-row">
            <img src="{{ asset('storage/photos/sadjo1.jpg') }}" class="photo-cadre" alt="Image 1">
            <img src="{{ asset('storage/photos/sadjo2.jpg') }}" class="photo-cadre" alt="Image 2">
        </div>
        <!-- Contact placé sous les photos -->
        <a href="mailto:sadjosow187@gmail.com" class="contact-link text-contact">
            📧 sadjosow187@gmail.com
        </a>
        <p class="text-contact"><strong>Téléphone : +224 628416997</strong></p>
    </div>
</div>

<!-- Section fond fixe -->
<div class="hero-section">
    <h1>Site d'information Motards Certifiée</h1>
</div>

<p>
Bienvenue sur le site officiel des motards de la Commune Urbaine de Dubréka.  
Nous sommes fiers de représenter une communauté dynamique, disciplinée et engagée pour le bien-être de tous.  
Chaque jour, nos motards parcourent les routes avec courage et dévouement, veillant à la sécurité et à la fluidité de la circulation pour tous les citoyens.

Être motard à Dubréka, c’est bien plus qu’un simple métier : c’est une vocation, un engagement de cœur envers sa communauté.  
Nos équipes incarnent l’esprit de solidarité, de responsabilité et de respect qui font la fierté de notre commune.

Nous croyons en une jeunesse motivée, en des leaders exemplaires et en une société unie autour de valeurs fortes.  
Nos motards sont formés pour agir avec rapidité, rigueur et respect, que ce soit lors des grands événements officiels ou au quotidien dans les quartiers.

Chaque klaxon est un appel à la vigilance, chaque trajectoire un symbole de discipline et de respect des règles.  
Nous saluons le professionnalisme et l'esprit de famille qui animent chacun de nos motards.

Explorez ce site pour mieux connaître nos équipes, nos missions et nos engagements.  
Merci de votre visite et bonne découverte ! 🚀
</p>

<!-- Section Nos Responsables -->
<div class="nos-formations-section position-relative">
    <div class="container content-section text-center">
        <h2 class="mb-4"><strong>Le Maire</strong></h2>
        <div class="row justify-content-center">
        @foreach($mairePhotos as $index => $photo)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 formation-box">
        <img src="{{ asset('storage/photos/' . $photo) }}" class="formation-img" alt="Formation">
        <p class="mt-2 text-white text-center" style="font-weight:bold;">
            {{ $commentaires[$index] ?? 'Description non disponible' }}
        </p>
    </div>
@endforeach
<p>Hommage à Nos Motards
Les motards de la Commune Urbaine de Dubréka ne sont pas de simples conducteurs. Ils sont les gardiens du mouvement, les veilleurs du quotidien, ceux qui bravent le vent et la pluie pour transporter, protéger, guider et parfois même sauver. Leur rôle dépasse le guidon : ils sont des piliers sociaux, des relais entre les quartiers, des figures respectées dans nos rues.

Une discipline, une fierté
Chaque casque porté est un symbole de responsabilité. Chaque klaxon, un signal d’attention. Nos motards sont formés, encadrés et inspirés par un seul objectif : servir la population dans la dignité et le respect des règles. Leur présence rassure, leur organisation impressionne. Nous les saluons pour leur ponctualité, leur esprit d’équipe et leur sens élevé du devoir.

Unis comme un moteur bien réglé
Qu’il s’agisse d’encadrer une cérémonie officielle, de participer à une mission humanitaire, ou simplement de traverser les artères de la commune pour informer et sensibiliser, les motards sont toujours présents, solidaires et organisés. Ils roulent ensemble, se protègent mutuellement et veillent au bon déroulement de chaque activité. Leur devise : Ensemble, plus loin, plus fort.

Merci, chers motards
À tous les motards de notre commune, à ceux qui donnent sans compter, qui sillonnent nos routes de jour comme de nuit, nous vous disons MERCI. Votre courage, votre endurance et votre engagement sont une source d’inspiration. Nous sommes fiers de vous compter parmi les bâtisseurs silencieux mais puissants de Dubréka. Vous êtes nos moteurs humains.

Les Motards : Héros de Nos Routes
Nos motards sont les héros discrets de la Commune Urbaine de Dubréka. Jour après jour, ils sillonnent nos rues, portant non seulement leur passion pour la moto mais aussi une responsabilité immense. Ils sont les yeux et les oreilles de la communauté, veillant à la sécurité de tous tout en restant à l'écoute des besoins de la population. Leur rôle est essentiel, leur engagement inébranlable.

Une Passion au Service de la Communauté
Chaque motard incarne bien plus qu'un simple conducteur. Ils sont des ambassadeurs de la sécurité, des membres actifs qui participent à la bonne marche de notre commune. Ils sont là pour guider, transporter, et protéger. Que ce soit lors d’événements officiels, de missions urgentes ou d’activités de routine, leur présence est un gage de fiabilité et de réactivité.

Des Moto-Patrouilles pour Votre Sécurité
Les patrouilles de motards sont une partie intégrante du dispositif de sécurité publique. Grâce à leur mobilité et leur capacité à se faufiler dans les embouteillages, les motards peuvent rapidement intervenir en cas de besoin. Leur rôle est de maintenir l’ordre, faire respecter les règles, et assurer une présence visible dans les lieux publics et lors des événements communautaires. Leur travail n’est pas seulement une profession, c’est une vocation.

Un Engagement Sans Limites
Les motards de Dubréka sont des hommes et des femmes qui ne connaissent pas de limites. Qu’il pleuve, qu’il vente ou qu’il fasse une chaleur étouffante, ils sont toujours là, prêts à rouler pour la communauté. Leur courage, leur détermination et leur sens du devoir font d’eux des modèles pour les jeunes générations.

Nous Vous Rendons Hommage
À tous nos motards, vous êtes une partie intégrante de notre quotidien. Grâce à vous, nous nous sentons plus sûrs, plus connectés et plus engagés dans la vie communautaire. Vos efforts sont une source de respect et de gratitude. Nous vous rendons hommage et vous remercions pour tout ce que vous faites pour la Commune Urbaine de Dubréka.</p>
            </div> <!-- Fin de la boucle des responsables -->
        
<@php
    $staffs = [
        'commune2.jpg' => "Le groupe sécurité veille à la discipline et à la sécurité des événements organisés.
        
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.",
        
        'commune3.jpg' => "L’équipe technique assure le bon fonctionnement des équipements et du matériel. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.",
        
        'commune4.jpg' => "Les responsables des relations publiques communiquent avec les autorités et partenaires. 
        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.
Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea laboriosam architecto voluptate nihil. Ea maiores est nostrum illo, a tempore eveniet ex quis eum sint temporibus minus cumque soluta.",
        'commune5.jpg' => "Le staff d’organisation s’occupe des itinéraires et du timing des cortèges.
        ✅ Engagement communautaire
À Dubréka, chaque citoyen est un maillon essentiel de notre développement. Nos groupes de motards, nos encadreurs, nos staffs techniques et administratifs travaillent main dans la main pour bâtir une communauté forte, solidaire et innovante. Chaque événement, chaque sortie, chaque rencontre est une opportunité de renforcer les liens sociaux et de promouvoir la paix et la sécurité.

",
        'commune.jpg'  => "Les animateurs mettent de l’ambiance et motivent les motards lors des événements.
        ✅ Unis pour le progrès
Le progrès ne se mesure pas uniquement à travers les infrastructures, mais aussi par la qualité de l’unité qui règne au sein d’une commune. Nos équipes s’engagent quotidiennement pour faire rayonner la Commune Urbaine de Dubréka, en valorisant nos talents locaux, en formant les jeunes, et en assurant un cadre de vie digne et respectueux pour tous.",
        'commune7.jpg' => "L’équipe logistique transporte les outils, les supports et s’occupe des installations.",
        'commune8.jpg' => "Les encadreurs accompagnent les nouveaux et veillent à une bonne intégration.
        ✅ Le motard citoyen
Être motard à Dubréka, ce n’est pas seulement conduire une moto. C’est appartenir à un réseau de citoyens engagés, respectueux du code de la route, protecteurs des plus faibles et toujours disponibles pour servir la communauté. Par leur discipline et leur solidarité, nos motards incarnent les valeurs les plus nobles de la co",
        'commune3.jpg' => "Les superviseurs coordonnent les actions entre les groupes et interviennent si besoin."
    ];
@endphp

<h2 class="mb-4 mt-5 text-center"><strong>Nos Staffs / Groupe</strong></h2>
<div class="row justify-content-center">
    @foreach($staffs as $photo => $commentaire)
        <div class="col-6 col-sm-4 col-md-3 mb-4 d-flex flex-column align-items-center">
            <div class="card shadow-sm border-0 w-100">
                <img src="{{ asset('storage/photos/' . $photo) }}" class="card-img-top rounded" style="height: 300px; object-fit: cover;" alt="Staff">
            </div>
            <p class="mt-2 text-center small" style="max-width: 100%;">{{ $commentaire }}</p>
        </div>
    @endforeach
</div>

    <strong>Jolie N'est Ce Pas?</strong>
    <!-- Petite image décorative en bas -->
    <div class="animated-section text-center">
    <div class="animated-text">🚖 TAXI MOTO</div>
    <img src="{{ asset('storage/photos/moto.jpg') }}" alt="Décoration" class="decorative-img">
    <div class="animated-text">TAXI MOTO 🚖</div>
</div>


           
        </div>
    </div>
</div>
<div class="d-flex justify-content-center my-4">
    <img src="{{ asset('storage/photos/G.webp') }}" alt="Guinee" class="decorative-img">
    
</div>
<h1 class="text-center">Guinee</h1>

<p>L'Aventure et la Liberté : La Vie de Motard
Être motard, ce n’est pas seulement conduire une moto, c’est vivre une aventure quotidienne. Chaque route devient un nouveau défi, chaque virage une opportunité d’explorer. La liberté que procure la moto est incomparable, une sensation unique qui rapproche les motards de la route et du monde. Quand tu enfourches ta moto, tu deviens le maître de ton chemin, et rien n’est plus gratifiant.

Les Motards : Des Ambassadeurs de la Route
Les motards ne sont pas seulement des conducteurs ; ils sont des ambassadeurs de la route, prônant des valeurs de respect, de sécurité et de convivialité. En tant que motard, tu es un modèle pour tous ceux qui t’entourent. Ton comportement sur la route inspire, et ton respect des règles encourage les autres à faire de même. La moto n’est pas un simple moyen de transport, c’est un mode de vie, un engagement à préserver l’ordre et à défendre la sécurité sur nos routes.

Rester Fort dans les Moments Difficiles
La vie d’un motard n’est pas toujours simple. Parfois, les conditions de circulation peuvent être difficiles, parfois même dangereuses. Mais un vrai motard ne se laisse jamais abattre par les obstacles. Au contraire, ces moments sont une preuve de force et une occasion de se surpasser. Les motards savent que chaque défi est une chance de grandir et de devenir meilleur.

L'Esprit d'Équipe et la Fraternité des Motards
Les motards partagent plus qu'une passion, ils partagent une fraternité. En dehors des routes, un motard peut toujours compter sur un autre motard. La solidarité est au cœur de la communauté des motards. Dans chaque rencontre, il y a un esprit d’entraide, une volonté de s’entraider dans les moments difficiles. Que ce soit pour des conseils mécaniques, des astuces de conduite ou simplement pour partager un bon moment, les motards sont toujours là pour les autres.

La Route Est un Terrain de Jeu pour les Motards
La route n’est pas simplement un trajet d’un point A à un point B. Pour les motards, la route est un terrain de jeu, un lieu où chaque virage est une occasion de tester ses limites et de ressentir l’adrénaline. C’est dans cet environnement que les motards se sentent vivants, où leur passion et leur compétence sont mises à l’épreuve à chaque instant. Mais la route est aussi un terrain de respect, où les motards doivent être vigilants, responsables et toujours conscients des autres usagers.

Vivre sa Passion avec Intensité
Être motard, c’est vivre avec intensité. C’est ressentir chaque moment sur la route comme un instinct, une véritable passion. C’est donner tout ce que l’on a à chaque trajet, en cherchant toujours à se perfectionner et à vivre pleinement sa passion. La moto n’est pas seulement un hobby, c’est un art de vivre, une manière de se connecter à soi-même et au monde qui nous entoure.

</p>

<h1 class="text-center my-5" style="color: #1abc9c; font-weight: bold;">Les Chefs De Lignes</h1>
<p class="text-center">Pour Touts Besoin Veuillez Contacter les chefs de ligne </p>

<div class="ligne-carousel-container">
    <button class="carousel-btn prev-btn">&#10094;</button>

    <div class="ligne-carousel" id="ligneCarousel">
        @php
            $chefs = [
                ['image' => 'chef1.jpg', 'nom' => 'Ibrahima Sory Kaba', 'tel' => '624 05 04 05 /623 05 40 77', 'poste' => 'Chef de la Ligne Centrale'],
                ['image' => 'chef2.jpg', 'nom' => 'Amadou Djouldé Diallo', 'tel' => '621 96 99 83 /662 72 51 84', 'poste' => 'Chef de la Ligne Bleu Zone (km36)'],
                ['image' => 'chef3.jpg', 'nom' => 'Mamadou Oury Bah', 'tel' => '628 86 09 01 /662 58 95 20', 'poste' => 'Chef de la Ligne Tobolou'],
                ['image' => 'chef4.jpg', 'nom' => 'Mamadou Saliou Sow', 'tel' => '626 03 32 22', 'poste' => 'Chef de la Ligne Grand Moulin'],
                ['image' => 'chef5.jpg', 'nom' => 'Amadou Daye Diallo', 'tel' => '622 11 48 22 /664 34 15 21', 'poste' => 'Chef de la Ligne T13'],
                ['image' => 'chef6.jpg', 'nom' => 'Souleymane Sow', 'tel' => '624 24 17 95', 'poste' => 'Chef de la Ligne Unie Diomant'],
                ['image' => 'chef7.jpg', 'nom' => 'Souleymane Diallo', 'tel' => '612 52 40 79', 'poste' => 'Chef de la Ligne Kalemah'],
                ['image' => 'chef8.jpg', 'nom' => 'Mohamed Sylla', 'tel' => '626 89 25 89 /662 30 82 49 ', 'poste' => 'Chef de la Ligne Samatran'],
                ['image' => 'chef9.jpg', 'nom' => 'Amadou Oury Bah', 'tel' => '628 14 61 88', 'poste' => 'Chef de la Ligne T9'],
                ['image' => 'chef10.jpg', 'nom' => 'Alhassane Diallo', 'tel' => '622 58 55 68', 'poste' => 'Chef Adjoint T10'],
                ['image' => 'chef11.jpg', 'nom' => 'Mamadou Samba Bah', 'tel' => '626 02 48 02', 'poste' => 'Chef de la Ligne Centrale (Adjoint)'],
                ['image' => 'chef12.jpg', 'nom' => 'Mamadou Sanoussy Diallo', 'tel' => '626 87 66 45', 'poste' => 'Chef de la Ligne Carrefour Georges'],
                ['image' => 'chef13.jpg', 'nom' => 'Elhadj Thiouto Bah', 'tel' => '622 29 63 54', 'poste' => 'Tresorier de Bureau Communal'],
                ['image' => 'chef14.jpg', 'nom' => 'Mamadou Yéro Bah', 'tel' => '620 02 97 59', 'poste' => 'Chef de la Ligne Ansoumania (2ieme)'],
            ];
           
        @endphp

        @foreach($chefs as $chef)
        <div class="ligne-card">
            <img src="{{ asset('storage/photos/' . $chef['image']) }}" alt="{{ $chef['nom'] }}">
            <div class="chef-info">
                <h5>Nom : {{ $chef['nom'] }}</h5>
                <p>Téléphone : {{ $chef['tel'] }}</p>
                <p>{{ $chef['poste'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <button class="carousel-btn next-btn">&#10095;</button>
</div>




<!-- Animation des blocs -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const boxes = document.querySelectorAll('.formation-box');
        const showBoxes = () => {
            boxes.forEach(box => {
                const boxTop = box.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                if (boxTop < windowHeight - 100) {
                    box.classList.add('show');
                }
            });
        };
        window.addEventListener('scroll', showBoxes);
        showBoxes();
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const carousel = document.getElementById('ligneCarousel');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');

        prevBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: -300, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            carousel.scrollBy({ left: 300, behavior: 'smooth' });
        });
    });
</script>


@endsection
