<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique en ligne</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles globaux */
        body {
            font-family: Georgia, 'Times New Roman', Times, serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 10px;
        }

        /* Navigation */
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
        }

        nav .onglet li {
            display: inline-block;
            margin-right: 20px;
        }

        nav .onglet a {
            text-decoration: none;
            color: tan;
            font-weight: bold;
            transition: color 0.3s;
        }

        nav .onglet a:hover {
            color: saddlebrown;
        }

        .onglet a.active {
            color: saddlebrown;
            border-bottom: 2px solid saddlebrown;
        }

        /* Header */
        header {
            background-size: cover;
            color: white;
            padding: 120px 0;
            text-align: center;
            height: 300px;
            background: url('robefete/mot.jpg');
        }

        header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 50px;
            color: #6d4c41;
        }

        header h4 {
            margin-top: 10px;
            font-size: 35px;
            text-align: center;
            border-bottom: 1px solid #fff;
            color: #6d4c41;
        }

        /* Section Articles récents */
        .recent-section {
            margin-top: 50px;
            text-align: center;
        }

        .recent-section h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .produits {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        .produit {
            background-color: white;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .produit:hover {
            transform: scale(1.05);
        }

        .produit img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .produit h3 {
            font-size: 1.2em;
            margin-top: 10px;
        }

        .produit p {
            font-size: 1em;
            color: #777;
            margin: 10px 0;
        }

        .produit button {
            background-color: #6d4c41;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .produit button:hover {
            background-color: #3e2723;
            transform: scale(1.1);
        }

        /* Modale du panier */
        #panier-modal {
            display: none;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        #panier-modal h2 {
            margin-top: 0;
        }

        #panier-modal button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <nav>
        <h1>Boutique de Bijoux et Robes</h1>
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
                        <i class="fas fa-gem"></i> Bijoux
                    </a>
                </li>
                <li>
                    <a href="/panier" class="{{ request()->is('panier') ? 'active' : '' }}">
                        <i class="fas fa-shopping-cart"></i> Panier
                    </a>
                </li>
                @auth
                    <li>
                        <a href="{{ route('profile.show') }}" class="{{ request()->is('profile') ? 'active' : '' }}">
                            <i class="fas fa-user"></i> Profil
                        </a>
                    </li>
                @endauth
                @guest
                    <li>
                        <a href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Se connecter
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <header id="accueil">
        <div class="titre">
            <h1>SYKabyle,</h1>
        </div>
        <h4>LE MEILLEUR Site d'achat de robe kabyle et Bijoux</h4>
    </header>

    <!-- Section Articles récents -->
    <section class="recent-section">
        <h1>Articles récents</h1>
        <div class="produits">
            @foreach ($recentArticles as $article)
                <div class="produit" data-name="{{ $article->nom }}">
                    <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->nom }}">
                    <h3>{{ $article->nom }}</h3>
                    <p>Prix: {{ $article->prix }} DA</p>

                    @if ($article->type === 'robe')
                        <p>Catégorie: {{ $article->category }}</p>
                        <p>{{ $article->description }}</p>
                    @elseif ($article->type === 'bijoux')
                        <p>Type: {{ $article->type }}</p>
                    @endif

                    <button class="btn-ajouter-panier" 
                            onclick="ajouterAuPanier({{ $article->id }}, '{{ $article->nom }}', {{ $article->prix }}, '{{ asset('storage/' . $article->image) }}')">
                        Ajouter au panier
                    </button>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Modale pour afficher le panier -->
    <div id="panier-modal">
        <h2>Votre panier</h2>
        <div id="panier-contenu"></div>
        <button onclick="document.getElementById('panier-modal').style.display = 'none'">Fermer</button>
        <button onclick="viderPanier()">Vider le panier</button>
    </div>

    <!-- Inclure SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Fonction pour ajouter un article au panier
        function ajouterAuPanier(id, nom, prix, image) {
            let panier = JSON.parse(localStorage.getItem('panier')) || [];
            let item = panier.find(item => item.id === id);

            if (item) {
                item.quantite += 1;
            } else {
                panier.push({ id, nom, prix, image, quantite: 1 });
            }

            localStorage.setItem('panier', JSON.stringify(panier));
            Swal.fire({
                icon: 'success',
                title: 'Article ajouté !',
                text: `${nom} a été ajouté au panier.`,
                timer: 2000,
                showConfirmButton: false,
            });
        }

        // Fonction pour vider le panier
        function viderPanier() {
            localStorage.removeItem('panier');
            document.getElementById('panier-contenu').innerHTML = '';
            Swal.fire({
                icon: 'success',
                title: 'Panier vidé !',
                text: 'Votre panier a été vidé.',
                timer: 2000,
                showConfirmButton: false,
            });
        }
    </script>
</body>
</html>