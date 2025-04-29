<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bijoux - Boutique</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">


    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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

        .menu-buttons {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;

            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
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

        .bijoux-section {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 30px 0;
        }

        .bijoux-category {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            width: 100%;
        }

        .bijoux-card {
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

        .bijoux-card:hover {
            transform: scale(1.05);
        }

        .bijoux-card img {
            width: 100%;
            height: 500px;
            border-radius: 5px;
        }

        .bijoux-card h3 {
            font-size: 1.5em;
            color: saddlebrown;
            margin: 15px 0;
        }

        .bijoux-card .price {
            font-size: 1.2em;
            color: #333;
        }

        .btn{
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
        .btn:hover {
            background-color: #3e2723;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .btnactive {
            transform: translateY(0);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }


        .bijoux-card .btn-ajouter-panier {
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

        .bijoux-card .btn-ajouter-panier:hover {
            background-color: #3e2723;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        .bijoux-card .btn-ajouter-panier:active {
            transform: translateY(0);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #fff;
            margin-top: 50px;
        }

        @media (max-width: 900px) {
            .bijoux-card {
                width: 45%;
            }
        }

        @media (max-width: 600px) {
            .bijoux-card {
                width: 100%;
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





    <div class="menu-buttons">
        <button onclick="filterBijoux('sac')">Sacs</button>
        <button onclick="filterBijoux('parreur')">Bijoux</button>
    </div>

    <section id="bijoux-section">
        @foreach ($bijoux as $categorie => $listeBijoux)
            <div class="bijoux-category" id="{{ $categorie }}-category">
                @foreach ($listeBijoux as $bijou)
                    <div class="bijoux-card">
                        <img src="{{ asset('storage/' . $bijou->image) }}" alt="Image du bijou">
                        <h3>{{ $bijou->nom }}</h3>
                        <p>{{ $bijou->description }}</p>
                        <p class="price">{{ $bijou->prix }} DA</p>
                        <button class="btn-ajouter-panier" onclick="ajouterAuPanier({{ $bijou->id }}, '{{ $bijou->nom }}', '{{ $bijou->prix }}', '{{ asset('storage/' . $bijou->image) }}', {{ $bijou->user_id }},'{{ $bijou->quantite }}')">
                        <i class="fas fa-shopping-cart"></i>Ajouter panier
                        </button   >
  
                        <button class="btn-ajouter-panier">
  <a href="{{ route('bijou.detail', ['id' => $bijou->id]) }}" class="btn-ajouter-panier" style="text-decoration: none;">
    <i class="fas fa-comment"></i> Commenter
  </a>
</button>





 <!-- Bouton Signaler -->
<button onclick="document.getElementById('form-signal-{{ $bijou->id }}').style.display='block'" class="btn-ajouter-panier">
    <i class="fas fa-flag"></i> Signaler
</button>
<!-- Formulaire caché -->
<div id="form-signal-{{ $bijou->id }}" style="display: none; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 400px; margin-top: 10px;">
    <form action="{{ route('signalement.store', ['type' => 'bijou', 'id' => $bijou->id]) }}" method="POST" style="display: flex; flex-direction: column;">
        @csrf
        <label style="font-weight: bold; margin-bottom: 8px;">Motif :</label>
        <select name="motif" onchange="showCustomMotif(this, '{{ $bijou->id }}')" style="padding: 8px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 5px;">
            <option value="">-- Sélectionnez une raison --</option>
            <option value="Contenu inapproprié">Contenu inapproprié</option>
            <option value="Faux produit">Faux produit</option>
            <option value="Autre">Autre (préciser)</option>
        </select>

        <div id="custom-motif-{{ $bijou->id }}" style="display:none;">
            <input type="text" name="motif" placeholder="Votre raison personnalisée" style="padding: 8px; margin-bottom: 12px; border: 1px solid #ccc; border-radius: 5px;">
        </div>

        <button type="submit" style="background-color: #6d4c41; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; text-align: center;">
            Envoyer
        </button>
    </form>
</div>

<script>
function showCustomMotif(select, id) {
    const custom = document.getElementById('custom-motif-' + id);
    if (select.value === 'Autre') {
        custom.style.display = 'block';
        select.name = 'ignore_motif'; // pour que seul l'input texte compte
        custom.querySelector('input').name = 'motif';
    } else {
        custom.style.display = 'none';
        select.name = 'motif';
        custom.querySelector('input').name = 'ignore_motif';
    }
}
</script>

                    </div>
                @endforeach
            </div>
        @endforeach
    </section>




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

@auth
        // Passer l'ID de l'utilisateur connecté dans une variable JavaScript
        const currentUserId = {{ auth()->user()->id }};
    @else
        // Si l'utilisateur n'est pas authentifié, currentUserId sera null
        const currentUserId = null;
    @endauth

        function filterBijoux(category) {
            document.querySelectorAll('.bijoux-category').forEach(cat => {
                cat.style.display = cat.id.includes(category) ? 'flex' : 'none';
            });

            document.querySelectorAll('.menu-buttons button').forEach(button => {
                button.classList.remove('active');
            });
            document.querySelector(`.menu-buttons button[onclick="filterBijoux('${category}')"]`).classList.add('active');
        }

        function ajouterAuPanier(id, nom, prix, image, vendeurId,quantite) {

  // Vérifier si la quantité de la robe est 0
  if (quantite <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Quantité insuffisante',
            text: 'Cet accessoire est en rupture de stock et ne peut pas être ajoutée au panier.',
            timer: 2000,
            showConfirmButton: false,
        });
        return; // Empêcher l'ajout au panier si la quantité est 0 ou inférieure
    }

               // Vérifier si l'utilisateur est authentifié
    /* 
       if (currentUserId === null) {
              Swal.fire({
            icon: 'info',
            title: 'Connexion requise',
            text: 'Veuillez vous connecter pour ajouter des articles au panier',
            showCancelButton: true,
            confirmButtonText: 'Se connecter',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
        return; // Empêcher l'ajout au panier si l'utilisateur n'est pas connecté
        }
      // Vérifier si l'acheteur est le vendeur
      if (currentUserId === vendeurId) {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Vous ne pouvez pas acheter votre propre accessoire.',
                    timer: 2000,
                    showConfirmButton: false,
                });
                return; // Empêcher l'ajout au panier si l'utilisateur est le vendeur
    }
*/
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


        // Afficher les sacs par défaut au chargement de la page
        window.onload = () => filterBijoux('sac');





        
    </script>

</body>

</html>