<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

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
            background-color: #5a3921;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            font-size: 1.2em;
        }
        .quantity-btn:hover {
            background-color:rgb(147, 132, 122);
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
            background-color: #5a3921;
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
            background-color:#3e2723;
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
</nav>

    <h2>Votre Panier</h2>
    <div id="panier-container">
        <p>Chargement du panier...</p>
    </div>
    <div id="total-price" class="total">Total : 0 DA</div>
    <button class="btn-commander" onclick="validerCommande()">Commander</button>

  

    
    <footer class="footer">
    <div class="footer-container">
        <div class="footer-column">
            <h3 class="footer-title">SyKabyle</h3>
            <p class="footer-text">Nous vous offrons les meilleures robes et accessoires kabyles depuis 2025.</p>
        </div>

        <div class="footer-column">
            <h5 class="footer-subtitle">Liens Utiles</h5>
            <ul class="footer-list">
                <li><a href="{{ route('accueil') }}" class="footer-link"><i class="fas fa-house me-1"></i>Accueil</a></li>
                <li><a href="{{ route('robes.index') }}" class="footer-link"><i class="fas fa-shirt me-1"></i>Nos Robes</a></li>
                <li><a href="{{ route('bijoux.index') }}" class="footer-link"><i class="fas fa-gem me-1"></i>Accessoires</a></li>
                <li><a href="{{ route('panier.index') }}" class="footer-link"><i class="fas fa-shopping-cart me-1"></i>Panier</a></li>
                <li><a href="{{ route('login') }}" class="footer-link"><i class="fas fa-sign-in-alt me-1"></i>Connexion</a></li>
                <li><a href="{{ route('register') }}" class="footer-link"><i class="fas fa-user-plus me-1"></i>Inscription</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h5 class="footer-subtitle">Contact</h5>
            <ul class="footer-list">
                <li><i class="fas fa-map-marker-alt me-2"></i>Centre commercial El-Hana, Béjaia</li>
                <li><i class="fas fa-phone me-2"></i>+213 000000000</li>
                <li><i class="fas fa-envelope me-2"></i>yasminemerabet404@gmail.com</li>
                <li><i class="fas fa-clock me-2"></i>Lun-Sam: 9h-19h</li>
            </ul>
        </div>
    </div>

    <div class="footer-divider"></div>

    <div class="footer-bottom">
        <div class="footer-copyright">
            <p>© 2025 SyKabyle. Tous droits réservés.</p>
        </div>
        <div class="footer-social">
            <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-icon"><i class="fab fa-x-twitter"></i></a>
        </div>
    </div>
</footer>
<style>

.footer {
    background-color:rgb(219, 218, 213);
    color: #5d4037;
    padding: 40px 0 20px;
    font-family: 'Poppins', sans-serif;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 0 20px;
}

.footer-column {
    flex: 1;
    min-width: 220px;
    margin-bottom: 30px;
    padding: 0 15px;
}

.footer-title {
    font-family: 'Dancing Script', cursive;
    font-size: 2.5rem;
    color: #8d6e63;
    font-weight: 700;
}

.footer-subtitle {
    font-size: 1.2rem;
    margin-bottom: 20px;
    font-weight: 500;
    color: #6d4c41;
}

.footer-text {
    line-height: 1.6;
    font-weight: 300;
}

.footer-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-list li {
    margin-bottom: 12px;
    line-height: 1.6;
    font-size: 0.95rem;
}

.footer-link {
    color: #5d4037;
    text-decoration: none;
    transition: all 0.3s;
}

.footer-link:hover {
    color: #3e2723;
    text-decoration: underline;
}

/* Ligne de séparation */
.footer-divider {
    border-top: 1px solid #d7ccc8;
    margin: 20px auto;
    max-width: 1160px;
}

/* Bas du footer */
.footer-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer-social {
    display: flex;
    gap: 15px;
}

.social-icon {
    color: #5d4037;
    font-size: 1.4rem;
    transition: color 0.3s;
}

.social-icon:hover {
    color: #3e2723;
}

/* Responsive */
@media (max-width: 768px) {
    .footer-column {
        flex: 100%;
        margin-bottom: 20px;
    }
    .footer-bottom {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
}
</style>
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


        async function validerCommande() {
    const panier = JSON.parse(localStorage.getItem('panier')) || [];
    console.log('Contenu du panier avant envoi:', JSON.stringify(panier, null, 2));

    if (panier.length === 0) {
        alert('Votre panier est vide !');
        return;
    }

    // Vérifier si l'utilisateur est authentifié
    const userIsAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
    if (!userIsAuthenticated) {
        // Afficher un message demandant à l'utilisateur de se connecter
        const confirmation = confirm("Vous devez être connecté pour passer une commande. Voulez-vous vous connecter maintenant ?");
        if (confirmation) {
            window.location.href = "/login";  // Redirige vers la page de connexion
        }
        return;
    }

    // Si l'utilisateur est authentifié, procéder à la commande
    const items = panier.map(item => {
        if (item.category === 'robes' || item.nom.includes('Robe')) {
            return {
                id: item.id,
                type: 'robe',
                quantite: item.quantite,
                prix: item.prix
            };
        } else {
            return {
                id: item.id,
                type: 'bijou',
                quantite: item.quantite,
                prix: item.prix
            };
        }
    });

    try {
        const response = await fetch('/commander', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ items })
        });

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Erreur serveur');
        }

        const data = await response.json();
        localStorage.removeItem('panier');
        window.location.href = `/confirmation-commande?reference=${data.reference}`;
    } catch (error) {
        alert(`Erreur: ${error.message}`);
    }
}

    </script>
</body>
</html>