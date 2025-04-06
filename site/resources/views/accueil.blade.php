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

           /* Hover effect for buttons */
   
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
                        <i class="fas fa-gem"></i> Accessoires
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


    <section class="search-section" style="margin: 30px auto; text-align: center;">
    <form action="{{ route('accueil.search') }}" method="GET" style="display: inline-block; background-color: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <label for="type">Type :</label>
        <select name="type" id="type" required>
            <option value="">Choisir</option>
            <option value="robe">Robe</option>
            <option value="bijoux">Bijoux</option>
        </select>

        <label for="category">Catégorie :</label>
        <select name="category" id="category">
            <option value="">Toutes</option>
        </select>

        <label for="max_price">Prix max :</label>
        <input type="number" name="max_price" id="max_price" placeholder="ex: 5000" required>

        <button type="submit" style="background-color: saddlebrown; color: white; border: none; padding: 8px 15px; border-radius: 5px;">
            <i class="fas fa-search"></i> Rechercher
        </button>
    </form>

    <!-- Afficher le bouton "Annuler" si des résultats sont présents -->
    @if(isset($results) && count($results) > 0)
        <form action="{{ route('accueil') }}" method="GET" style="display: inline-block; margin-left: 10px;">
            <button type="submit" style="background-color: #f5f5f5; color: saddlebrown; border: 2px solid saddlebrown; padding: 8px 15px; border-radius: 5px; display: flex; align-items: center;">
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
                        onclick="ajouterAuPanier({{ $article->id }}, '{{ $article->nom }}', {{ $article->prix }}, '{{ asset('storage/' . $article->image) }}')">
                    Ajouter au panier
                </button>
            </div>
        @endforeach
    </div>
   
@endif

<!-- Affichage des articles récents -->
<h1>Articles récents</h1>
<div class="produits">
    @foreach ($recentArticles as $article)
        <div class="produit">
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->nom }}">
            <h3>{{ $article->nom }}</h3>
            <p>Prix: {{ $article->prix }} DA</p>
            <button class="btn-ajouter-panier" 
        onclick="ajouterAuPanier({{ $article->id }}, '{{ $article->nom }}', {{ $article->prix }}, '{{ asset('storage/' . $article->image) }}', {{ $article->user_id }})">
    Ajouter au panier
</button>

        </div>
    @endforeach
</div>



<!-- Ajout des boutons "Voir Robe" et "Voir Bijoux" dans des boîtes -->
<div style="display: flex; justify-content: center; gap: 20px; margin-top: 30px;">
    <div style="background-color: #f5f5f5; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 200px; text-align: center;">
        <a href="/robe" style="background-color: saddlebrown; color: white; padding: 15px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: background-color 0.3s, transform 0.3s; font-size: 16px;">
            Voir Robes
        </a>
    </div>
    <div style="background-color: #f5f5f5; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 200px; text-align: center;">
        <a href="/bijoux" style="background-color: saddlebrown; color: white; padding: 15px 25px; border-radius: 8px; text-decoration: none; font-weight: bold; transition: background-color 0.3s, transform 0.3s; font-size: 16px;">
            Voir Bijoux
        </a>
    </div>
</div>

    <!-- Inclure SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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

    function ajouterAuPanier(id, nom, prix, image, vendeurId) {
    let panier = JSON.parse(localStorage.getItem('panier')) || [];
    
    // Vérifiez si l'acheteur est le vendeur
    const currentUserId = @auth {{ auth()->user()->id }} @endauth;

    if (currentUserId === vendeurId) {
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: 'Vous ne pouvez pas acheter votre propre article.',
            timer: 2000,
            showConfirmButton: false,
        });
        return; // Empêche l'ajout au panier si l'acheteur est le vendeur
    }

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


</script>

</body>
</html>