<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique en ligne</title>
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
    background-color: #fff;
    color: #333;
    text-align: center;
    height: 200px;
   
 
}

.titre-principal {
    font-size: 48px;
    font-weight: bold;
    color: #6d4c41; /* rouge foncé */
    text-shadow: 2px 2px 5px rgba(0,0,0,0.3);
    animation: titleSlide 5s infinite alternate;
}

.sous-titre {
    font-size: 20px;
    margin-top: 10px;
    color: #555;
}

@keyframes titleSlide {
    0% {
        letter-spacing: 2px;
        transform: scale(1);
    }
    100% {
        letter-spacing: 8px;
        transform: scale(1.05);
    }
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
            border-radius: 5px;
        }

        .produit {
            background-color: white;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            transition: transform 0.3s ease;
            margin-bottom: 20px;
            box-sizing: border-box;
            padding: 20px;
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

           /* Hover effect for buttons */


   

        
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

<header id="accueil">
    <div class="titre">
        <h1 class="titre-principal">SYKabyle,</h1>
        <h4 class="sous-titre">LE MEILLEUR Site d'achat de robe kabyle et Accessoires</h4>
    </div>
</header>



<section class="search-section" style="margin: 20px auto; text-align: center;">
    <h2 style="color: saddlebrown; font-size: 28px; margin-bottom: 20px;">
        <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i> Recherchez votre article
    </h2>

    <form action="{{ route('accueil.search') }}" method="GET"
        style="display: inline-block; width: 70%; background-color: rgb(252, 248, 247); padding: 25px; border-radius: 10px; box-shadow: 0 3px 6px rgba(0,0,0,0.1); text-align: left; font-size: 16px;">

        <div style="display: flex; justify-content: space-between; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;">
            <div style="flex: 1; min-width: 220px;">
                <label for="type" style="font-weight: bold; font-size: 18px;">
                    <i class="fas fa-tags" style="color: saddlebrown; margin-right: 5px;"></i> Type :
                </label><br>
                <select name="type" id="type" required style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; font-size: 16px;">
                    <option value="">Choisir</option>
                    <option value="robe">Robe</option>
                    <option value="bijoux">Accessoires</option>
                </select>
            </div>

            <div style="flex: 1; min-width: 220px;">
                <label for="category" style="font-weight: bold; font-size: 18px;">
                    <i class="fas fa-layer-group" style="color: saddlebrown; margin-right: 5px;"></i> Catégorie :
                </label><br>
                <select name="category" id="category" style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; font-size: 16px;">
                    <option value="">Toutes</option>
                </select>
            </div>

            <div style="flex: 1; min-width: 220px;">
                <label for="max_price" style="font-weight: bold; font-size: 18px;">
                    <i class="fas fa-coins" style="color: saddlebrown; margin-right: 5px;"></i> Prix max :
                </label><br>
                <input type="number" name="max_price" id="max_price" placeholder="ex: 5000" required 
                    style="width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; font-size: 16px;">
            </div>
        </div>

        <div style="text-align: center;">
            <button type="submit"
                style="background-color: saddlebrown; color: white; border: none; padding: 12px 25px; border-radius: 6px; font-size: 18px; cursor: pointer;">
                <i class="fas fa-search" style="margin-right: 6px;"></i> Rechercher
            </button>
        </div>
    </form>

    @if(isset($results) && count($results) > 0)
        <form action="{{ route('accueil') }}" method="GET" style="display: inline-block; margin-top: 20px;">
            <button type="submit"
                style="background-color: transparent; color: saddlebrown; border: 2px solid saddlebrown; padding: 10px 20px; border-radius: 6px; font-size: 16px; display: flex; align-items: center; margin: 0 auto; cursor: pointer;">
                <i class="fas fa-times" style="margin-right: 5px;"></i> Annuler la recherche
            </button>
        </form>
    @endif
</section>



<!-- Affichage des résultats de la recherche -->
@if(isset($results) && count($results) > 0)
    <h1>Résultats de la recherche</h1>
    <div class="produits">
        @foreach ($results as $article)
            <div class="produit">
                <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->nom }}">
                <h3>{{ $article->nom }}</h3>
                <p>Prix: {{ $article->prix }} DA</p>
                <button class="btn-ajouter-panier" 
    onclick="ajouterAuPanier({{ $article->id }}, '{{ $article->nom }}', {{ $article->prix }}, '{{ asset('storage/' . $article->image) }}', {{ $article->user_id }}, {{ $article->quantite }})">
    <i class="fas fa-shopping-cart"></i> Ajouter au panier

</button>



            </div>
        @endforeach
    </div>
   
@endif



<!-- Affichage des articles récents -->
<h1 style="text-align: center;">Articles récents</h1>

<div class="produits">
    @foreach ($recentArticles as $article)
        <div class="produit">
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->nom }}">
            <h3>{{ $article->nom }}</h3>
            <p>Prix: {{ $article->prix }} DA</p>
            <button class="btn-ajouter-panier" 
    onclick="ajouterAuPanier({{ $article->id }}, '{{ $article->nom }}', {{ $article->prix }}, '{{ asset('storage/' . $article->image) }}', {{ $article->user_id }}, {{ $article->quantite }})">
    <i class="fas fa-shopping-cart"></i> Ajouter panier

</button>


<!-- Bouton Signaler -->
<button class="btn-ajouter-panier" 
    onclick="document.getElementById('form-signal-{{ $article->id }}').style.display='block'">
    <i class="fas fa-flag"></i> Signaler
</button>

<!-- Formulaire caché de signalement -->
<div id="form-signal-{{ $article->id }}" style="display: none; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); width: 200px; margin-top: 10px;">
<form action="{{ route('signalement.store', ['type' => 'robe', 'id' => $article->id]) }}" method="POST" onsubmit="return prepareMotif({{ $article->id }})" style="display: flex; flex-direction: column;">
    @csrf
    <label style="font-weight: bold; margin-bottom: 8px;">Motif :</label>
    <select id="motif-select-{{ $article->id }}" onchange="showCustomMotif(this.value, {{ $article->id }})"
        style="padding: 8px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 5px;">
        <option value="">-- Sélectionnez une raison --</option>
        <option value="Contenu inapproprié">Contenu inapproprié</option>
        <option value="Faux produit">Faux produit</option>
        <option value="autre">Autre (préciser)</option>
    </select>

    <div id="custom-motif-div-{{ $article->id }}" style="display:none;">
        <input type="text" id="custom-motif-input-{{ $article->id }}" placeholder="Votre raison personnalisée"
            style="padding: 8px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 5px;">
    </div>

    <!-- Ce champ final sera envoyé -->
    <input type="hidden" name="motif" id="motif-final-{{ $article->id }}">

    <button type="submit" style="background-color: #6d4c41; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
        Envoyer
    </button>
</form>

<script>
function showCustomMotif(value, id) {
    const customDiv = document.getElementById('custom-motif-div-' + id);
    customDiv.style.display = (value === 'autre') ? 'block' : 'none';
}

function prepareMotif(id) {
    const select = document.getElementById('motif-select-' + id);
    const customInput = document.getElementById('custom-motif-input-' + id);
    const finalInput = document.getElementById('motif-final-' + id);

    if (select.value === 'autre') {
        finalInput.value = customInput.value;
    } else {
        finalInput.value = select.value;
    }

    return true;
}
</script>



</div>


        </div>
    @endforeach
</div>



<!-- Ajout des boutons "Voir Robe" et "Voir Bijoux" dans des boîtes -->
<div style="display: flex; flex-direction: column; align-items: center; gap: 30px; margin-top: 30px; margin-bottom: 50px;">
   
    <h1>Nos articles</h1>

    <div style="display: flex; gap: 20px;">
        <div style="background-color: #f5f5f5; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 200px; text-align: center;">
            <a href="/robe" style="background-color: saddlebrown; color: white; padding: 15px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: background-color 0.3s, transform 0.3s; font-size: 16px;">
                Voir Robes
            </a>
        </div>
        <div style="background-color: #f5f5f5; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 200px; text-align: center;">
            <a href="/bijoux" style="background-color: saddlebrown; color: white; padding: 15px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: background-color 0.3s, transform 0.3s; font-size: 16px;">
                Voir Accessoires
            </a>
        </div>
    </div>
</div>



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
    <!-- Inclure SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

@auth
        // Passer l'ID de l'utilisateur connecté dans une variable JavaScript
        const currentUserId = {{ auth()->user()->id }};
    @else
        // Si l'utilisateur n'est pas authentifié, currentUserId sera null
        const currentUserId = null;
    @endauth

    const typeSelect = document.getElementById('type');
    const categorySelect = document.getElementById('category');

    const options = {
        robe: [
            { value: '', text: 'Toutes' },
            { value: 'simple', text: 'Simple' },
            { value: 'fete', text: 'Fête' },
            { value: 'mariee', text: 'Élégante' }
        ],
        bijoux: [
            { value: '', text: 'Tous' },
            { value: 'parreur', text: 'parreur' },
            { value: 'sac', text: 'sac' }
        ]
    };

    typeSelect.addEventListener('change', function () {
        const selectedType = this.value;
        categorySelect.innerHTML = ''; // Vider les anciennes options

        if (options[selectedType]) {
            options[selectedType].forEach(opt => {
                const option = document.createElement('option');
                option.value = opt.value;
                option.textContent = opt.text;
                categorySelect.appendChild(option);
            });
        }
    });

    function ajouterAuPanier(id, nom, prix, image, vendeurId,quantite) {
          
          // Vérifier si la quantité est 0
    if (quantite === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Indisponible',
            text: 'Cet article est en rupture de stock.',
            timer: 2000,
            showConfirmButton: false,
        });
        return; // Empêcher l'ajout au panier si l'article est en rupture de stock
    }
        
           
           
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


</script>

</body>
</html>