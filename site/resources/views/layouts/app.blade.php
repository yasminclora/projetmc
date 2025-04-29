<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
   

    <title>Boutique de Robes Kabyle et accessoires</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
       .brand-title {
    font-family: 'Dancing Script', cursive;
    /* Alternative: 'Dancing Script' pour un style plus cursif */
    font-weight: 700;
    font-size: 2.2rem;
    color: #5a3921; /* Brun soutenu */
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    letter-spacing: 0.5px;
    margin: 0;
    padding: 10px 0;
}

body {
            font-family: 'Georgia', 'Times New Roman', Times, serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #fff;
            border-bottom: 2px solid #ccc;
        }

        nav h1 {
            color: saddlebrown;
            font-family: 'Playfair Display', serif;
            font-size: 30px;
        }

        nav .onglet ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
        }

        nav .onglet li {
            margin-right: 20px;
        }

        nav .onglet a {
            text-decoration: none;
            color: tan;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav .onglet a:hover,
        .onglet a.active {
            color: saddlebrown;
            border-bottom: 2px solid saddlebrown;
        }



        /* Bouton de déconnexion */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .dropdown-item {
            color: #8B4513; /* Marron foncé */
            transition: background-color 0.3s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #8B4513; /* Marron foncé */
        }

        /* Contenu principal */
        main {
            padding: 20px;
        }





    </style>
</head>
<body>
    
<nav>
<img src="{{ asset('images/fon.png') }}" 
     alt="SyKabyle - Boutique de bijoux kabyles" 
     class="logo"
     width="350" 
     height="120">
     
     <h1 class="brand-title">Boutique de Robes Kabyle et Accessoires</h1>
    <div class="onglet">
    <ul>
    <li>
        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Accueil
        </a>
    </li>
    <li>
        <a href="/robe" class="{{ request()->is('robe') ? 'active' : '' }}">
            <i class="fas fa-tshirt"></i> Robes
        </a>
    </li>
    <li>
        <a href="/bijoux" class="{{ request()->is('bijoux') ? 'active' : '' }}">
            <i class="fas fa-gem"></i> Accessoires
        </a>
    </li>
    <li>
        <a href="/panier" class="{{ request()->is('panier') ? 'active' : '' }}">
            <i class="fas fa-shopping-cart"></i> Panier
        </a>
    </li>
    <!-- Lien "Profil" visible uniquement pour les utilisateurs connectés -->
    @auth
        <li>
            <a href="{{ route('profile.show') }}" class="{{ request()->is('profile') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Profil
            </a>
        </li>
    @endauth

    <!-- Lien "Se connecter" visible uniquement pour les utilisateurs non connectés -->
    @guest
        <li>
            <a href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </a>
        </li>
    @endguest
</ul>
    </div>


            <!-- Menu déroulant pour les utilisateurs connectés -->
            @auth
               
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Déconnexion') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                 
            @endauth
        </nav>

        <!-- Contenu principal -->
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>