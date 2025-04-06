<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robes - Boutique</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<style>
    /* Style global */
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

    nav .onglet a:hover {
        color: saddlebrown;
    }

    .onglet a.active {
        color: saddlebrown;
        border-bottom: 2px solid saddlebrown;
    }

    .menu-buttons {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .menu-buttons button {
        background-color: #6d4c41;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 1em;
        margin: 0 10px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .menu-buttons button:hover {
        background-color: #3e2723;
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
    }

    .menu-buttons button:active {
        transform: translateY(0);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .menu-buttons button.active {
        background-color: #3e2723;
        border-bottom: 2px solid saddlebrown;
    }

    /* Style des cartes de robes */
    .robe-section {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin: 30px 0;
    }

    .robe-category {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
    }

    .robe-card {
        width: 30%;
        padding: 20px;
        text-align: center;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        transition: transform 0.3s ease;
        margin-bottom: 20px;
        box-sizing: border-box;
    }

    .robe-card:hover {
        transform: scale(1.05);
    }

    .robe-card img {
        width: 100%;
        height: auto;
        border-radius: 5px;
    }

    .robe-card h3 {
        font-size: 1.5em;
        color: saddlebrown;
        margin: 15px 0;
    }

    .robe-card .price {
        font-size: 1.2em;
        color: #333;
    }

    .robe-card .btn-ajouter-panier {
        background-color: #6d4c41;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 1em;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .robe-card .btn-ajouter-panier:hover {
        background-color: #3e2723;
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
    }

    .robe-card .btn-ajouter-panier:active {
        transform: translateY(0);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    footer {
        text-align: center;
        padding: 10px;
        background-color: #fff;
        margin-top: 50px;
    }

    /* Media queries */
    @media (max-width: 1200px) {
        .robe-card {
            width: 30%;
        }
    }

    @media (max-width: 900px) {
        .robe-card {
            width: 45%;
        }
    }

    @media (max-width: 600px) {
        .robe-card {
            width: 100%;
        }

        nav .onglet ul {
            flex-direction: column;
            align-items: center;
        }

        nav .onglet li {
            margin-bottom: 10px;
        }

        .menu-buttons {
            flex-direction: column;
            align-items: center;
        }

        .menu-buttons button {
            margin-bottom: 10px;
        }
    }
</style>

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
</nav>

    <div class="menu-buttons">
        <button onclick="filterRobes('simple')">Robes Simples</button>
        <button onclick="filterRobes('fete')">Robes de Fête</button>
        <button onclick="filterRobes('elegante')">Robes Élégantes</button>
    </div>

    <section id="robe-section">
        @foreach ($robes as $categorie => $listeRobes)
        <div class="robe-category" id="{{ $categorie }}-category">
            @foreach ($listeRobes as $robe)
            <div class="robe-card">
                <img src="{{ asset('storage/' . $robe->image) }}" alt="Image de la robe">
                <h3>{{ $robe->nom }}</h3>
                <p>{{ $robe->description }}</p>
                <p class="price">{{ $robe->prix }} DA</p>
                <button class="btn-ajouter-panier" onclick="ajouterAuPanier({{ $robe->id }}, '{{ $robe->nom }}', '{{ $robe->prix }}', '{{ asset('storage/' . $robe->image) }}', {{ $robe->user_id }})">
    Ajouter au panier
</button>

            </div>
            @endforeach
        </div>
        @endforeach
    </section>

    <footer>
        <p>&copy; 2025 Boutique de Robes. Tous droits réservés.</p>
    </footer>

    <script>
        function filterRobes(category) {
            document.querySelectorAll('.robe-category').forEach(cat => {
                cat.style.display = cat.id.includes(category) ? 'flex' : 'none';
            });

            document.querySelectorAll('.menu-buttons button').forEach(button => {
                button.classList.remove('active');
            });
            document.querySelector(`.menu-buttons button[onclick="filterRobes('${category}')"]`).classList.add('active');
        }

        function ajouterAuPanier(id, nom, prix, image, vendeurId) {
    // Récupérer l'ID de l'utilisateur connecté (que vous passez depuis le backend)
    const currentUserId = @auth {{ auth()->user()->id }} @endauth;
    // Vous pouvez utiliser cette syntaxe pour obtenir l'ID du vendeur dans le backend

    // Vérifier si l'acheteur est le vendeur
    if (currentUserId === vendeurId) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Vous ne pouvez pas acheter votre propre robe.',
            timer: 2000,
            showConfirmButton: false,
        });
        return; // Empêcher l'ajout au panier si l'utilisateur est le vendeur
    }

    // Si ce n'est pas l'article du vendeur, on continue normalement
    let panier = JSON.parse(localStorage.getItem('panier')) || [];
    let item = panier.find(item => item.id === id);

    if (item) {
        item.quantite += 1;
    } else {
        panier.push({ id, nom, prix, image, quantite: 1 });
    }

    localStorage.setItem('panier', JSON.stringify(panier));
    alert(`${nom} ajouté au panier !`);
}

        window.onload = () => filterRobes('simple');
    </script>
</body>

</html>