<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Georgia', serif;
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


        nav .onglet a:hover,
        .onglet a.active {
            color: saddlebrown;
            border-bottom: 2px solid saddlebrown;
        }

        .panier-section {
            margin-top: 30px;
        }
        .panier-card {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            border-radius: 10px;
        }
        .panier-card img {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .panier-card .details {
            flex-grow: 1;
            padding-left: 20px;
        }
        .panier-card .details h3 {
            font-size: 1.5em;
            color: saddlebrown;
            margin-bottom: 10px;
        }
        .panier-card .price {
            font-size: 1.2em;
            color: #333;
        }
        .quantity-control {
            display: flex;
            align-items: center;
        }
        .quantity-btn {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            font-size: 1.2em;
        }
        .quantity-btn:hover {
            background-color: #45a049;
        }
        .quantity-input {
            width: 40px;
            text-align: center;
            margin: 0 10px;
            font-size: 1.2em;
        }
        .btn-remove {
            background-color: #d32f2f;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        .btn-remove:hover {
            background-color: #c62828;
        }
        .total {
            font-size: 1.5em;
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
        .btn-commander {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.2em;
            display: block;
            margin: 20px auto;
        }
        .btn-commander:hover {
            background-color: #45a049;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #fff;
            margin-top: 50px;
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

    <h2>Votre Panier</h2>
    <div id="panier-container">
        <p>Chargement du panier...</p>
    </div>
    <div id="total-price" class="total">Total : 0 DA</div>
    <button class="btn-commander" onclick="validerCommande()">Commander</button>

    <footer>
        <p>&copy; 2025 Boutique de Robes et Bijoux. Tous droits réservés.</p>
    </footer>

    <script>
        // Afficher le panier au chargement de la page
        window.onload = afficherPanier;

        // Fonction pour afficher le panier
        function afficherPanier() {
            let panier = JSON.parse(localStorage.getItem('panier')) || [];
            let panierContainer = document.getElementById('panier-container');
            let totalPriceElement = document.getElementById('total-price');

            if (panier.length === 0) {
                panierContainer.innerHTML = "<p>Votre panier est vide.</p>";
                totalPriceElement.innerHTML = "Total : 0 DA";
                return;
            }

            let totalCommande = 0;
            let html = "";

            panier.forEach((item, index) => {
                let totalItem = item.prix * item.quantite;
                totalCommande += totalItem;

                html += `
                    <div class="panier-card">
                        <img src="${item.image.startsWith('http') ? item.image : '/storage/' + item.image}" alt="${item.nom}">
                        <div class="details">
                            <h3>${item.nom}</h3>
                            <p class="price">Prix unitaire : ${item.prix} DA</p>
                            <p class="price">Total : <span id="total-${index}">${totalItem}</span> DA</p>
                            <div class="quantity-control">
                                <button class="quantity-btn" onclick="changerQuantite(${index}, -1)">-</button>
                                <input type="text" class="quantity-input" id="quantite-${index}" value="${item.quantite}" readonly>
                                <button class="quantity-btn" onclick="changerQuantite(${index}, 1)">+</button>
                            </div>
                        </div>
                        <button class="btn-remove" onclick="retirerDuPanier(${index})">Supprimer</button>
                    </div>
                `;
            });

            totalPriceElement.innerHTML = `Total : ${totalCommande} DA`;
            panierContainer.innerHTML = html;
        }

        // Fonction pour changer la quantité d'un article
        function changerQuantite(index, variation) {
            let panier = JSON.parse(localStorage.getItem('panier')) || [];
            if (!panier[index]) return;

            panier[index].quantite += variation;
            if (panier[index].quantite < 1) panier[index].quantite = 1;

            localStorage.setItem('panier', JSON.stringify(panier));
            afficherPanier();
        }

        // Fonction pour retirer un article du panier
        function retirerDuPanier(index) {
            let panier = JSON.parse(localStorage.getItem('panier')) || [];
            panier.splice(index, 1);
            localStorage.setItem('panier', JSON.stringify(panier));
            afficherPanier();
        }

        // Fonction pour valider la commande
        function validerCommande() {
            let panier = JSON.parse(localStorage.getItem('panier')) || [];
            if (panier.length === 0) {
                alert("Votre panier est vide !");
                return;
            }

            let totalCommande = panier.reduce((total, item) => total + (item.prix * item.quantite), 0);

            fetch('/commander', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ articles: panier, total: totalCommande })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Commande enregistrée avec succès !");
                    localStorage.removeItem('panier'); // Vider le panier après validation
                    afficherPanier();
                } else {
                    alert("Erreur lors de l'enregistrement de la commande !");
                }
            })
            .catch(error => console.error('Erreur:', error));
        }
    </script>
</body>
</html>