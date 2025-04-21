@php
$mairePhotos = ['maire1.jpg', 'maire2.jpg', 'maire3.jpg', 'maire4.jpg'];
shuffle($mairePhotos); // Mélange les photos de manière aléatoire
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
        height: 300px;
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
    scroll-behavior: smooth;
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

<!-- Section Nos Responsables -->
<div class="nos-formations-section position-relative">
    <div class="container content-section text-center">
        <h2 class="mb-4"><strong>Le Maire</strong></h2>
        <div class="row justify-content-center">
            @foreach($mairePhotos as $photo)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 formation-box">
                <img src="{{ asset('storage/photos/' . $photo) }}" class="formation-img" alt="Formation">
            </div>
            @endforeach

            </div> <!-- Fin de la boucle des responsables -->

<!-- Nouvelle section des sponsors/publicités -->
<h2 class="mb-4 mt-5"><strong>Nos Staffs / Groupe</strong></h2>
<div class="row justify-content-center">
    @foreach(['commune2.jpg', 'commune3.jpg', 'commune4.jpg', 'commune5.jpg', 'commune.jpg', 'commune7.jpg','commune8.jpg','commune3.jpg'] as $pub)
    <div class="col-6 col-sm-4 col-md-3 mb-4">
        <div class="card shadow-sm border-0">
            <img src="{{ asset('storage/photos/' . $pub) }}" class="card-img-top" style="height: 300px;  object-fit: cover; border-radius: 12px; "  alt="Sponsor">
        </div>
    </div>
    
    @endforeach
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
<h1 class="text-center my-5" style="color: #1abc9c; font-weight: bold;">Les Chefs De Lignes</h1>

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
    const carousel = document.getElementById('ligneCarousel');
    const nextBtn = document.querySelector('.next-btn');
    const prevBtn = document.querySelector('.prev-btn');

    // Auto scroll toutes les 3s
    let scrollInterval = setInterval(() => {
        carousel.scrollBy({ left: 270, behavior: 'smooth' });
    }, 3000);

    // Stop scroll auto si souris entre
    carousel.addEventListener('mouseenter', () => clearInterval(scrollInterval));
    carousel.addEventListener('mouseleave', () => {
        scrollInterval = setInterval(() => {
            carousel.scrollBy({ left: 270, behavior: 'smooth' });
        }, 3000);
    });

    // Flèches manuelles
    nextBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: 270, behavior: 'smooth' });
    });

    prevBtn.addEventListener('click', () => {
        carousel.scrollBy({ left: -270, behavior: 'smooth' });
    });
</script>

@endsection
