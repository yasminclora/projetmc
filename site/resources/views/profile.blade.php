@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
      <!-- Barre latérale à gauche -->
<!-- Barre latérale à gauche -->
<div class="col-md-4 col-lg-3 p-0 bg-white text-dark" style="height: 100vh;">
    <div class="d-flex flex-column align-items-start p-3">
        <!-- Titre de la section à gauche -->
        <h5 class="mb-4">Mon Compte</h5>


        

        <!-- Boutons de navigation avec icônes -->
        <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('profile')">
    @if(Auth::user()->image)
        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Profile Image" class="rounded-circle" width="100" height="100">
    @else
        <i class="fas fa-user-circle" style="font-size: 100px; color: black;"></i>
    @endif
    Profil
</button>


        <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('mesCommandes')">
            <i class="fas fa-box"></i> Mes Commandes
        </button>


         <!-- Notifications Commandes Validées -->
<button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('notificationProp')" id="notificationPropBtn">
    <i class="fas fa-bell"></i> Notification validée
    @if(auth()->user()->unreadNotifications->where('type', 'App\Notifications\CommandeValideeNotification')->count())
        <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\CommandeValideeNotification')->count() }}</span>
    @endif
</button>


        <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" id="vendeurSwitch" onchange="toggleVendeurMode()" />
            <label class="form-check-label" for="vendeurSwitch" id="vendeurSwitchLabel">Activer le mode vendeur</label>
        </div>
        <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('ajouterRobe')" id="ajouterRobeBtn" style="display: none;">
            <i class="fas fa-tshirt"></i> Ajouter robe
        </button>
        <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('ajouterBijou')" id="ajouterBijouBtn" style="display: none;">
            <i class="fas fa-gem"></i> Ajouter accessoire
        </button>
       

      
  <!-- Notifications Commandes Reçues -->
  <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('notificationRecu')" id="notificationRecuBtn" style="display: none;">
                    <i class="fas fa-bell"></i>Notification Reçu
                    @if(auth()->user()->unreadNotifications->where('type', 'App\Notifications\NotificationProprietaireCommande')->count())
                        <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\NotificationProprietaireCommande')->count() }}</span>
                    @endif
                </button>

        <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('commandesRecues')" id="commandesRecuesBtn" style="display: none;">
            <i class="fas fa-box-open"></i> Commandes reçues
        </button>
        <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('mesArticles')" id="mesArticlesBtn" style="display: none;">
            <i class="fas fa-clipboard-list"></i> Voir mes articles
        </button>

        <!-- Déconnexion -->
        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); 
                    localStorage.removeItem('panier'); 
                    document.getElementById('logout-form').submit();" 
           class="btn btn-logout w-100 mt-4">
            Se déconnecter
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>

        <!-- Section principale à droite -->
<!-- Section principale à droite -->
<div class="col-md-8 col-lg-7 p-4" id="content-section">
            <!-- Profil utilisateur -->
 <!-- Profil utilisateur -->
 <div id="profile-section" style="display: block;">
    <h2 class="mb-3">Profil de {{ Auth::user()->name }}</h2>
    <div class="p-4 bg-white rounded shadow-sm border d-flex justify-content-between align-items-start">

        <div>
            <p class="mb-2"><strong>Nom :</strong> {{ Auth::user()->name }}</p>
            <p class="mb-2"><strong>Prenom :</strong> {{ Auth::user()->prenom }}</p>
            <p class="mb-2"><strong>Email :</strong> {{ Auth::user()->email }}</p>

            @if(Auth::user()->adresse)
                <p class="mb-2"><strong>Adresse :</strong> {{ Auth::user()->adresse }}</p>
            @endif

            @if(Auth::user()->telephone && preg_match('/^(05|06|07)[0-9]{8}$/', Auth::user()->telephone))
                <p class="mb-2"><strong>Numéro de téléphone :</strong> {{ Auth::user()->telephone }}</p>
            @endif
        </div>

        @if(Auth::user()->image)
            <div class="ms-4">
                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="Image de profil" width="120" class="rounded">
            </div>
        @endif
    </div>

    <!-- Bouton de modification -->
    <a href="javascript:void(0);" onclick="toggleEditProfile()" class="btn btn-maroon mt-3">
        <i class="fas fa-user-edit"></i> Modifier le profil
    </a>
</div>


<!-- Formulaire de modification de profil (au départ caché) -->
<div id="edit-profile-section" style="display: none;">
    <h3 class="mb-3">Modifier le Profil</h3>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm border">
        @csrf
        @method('PUT')

        <!-- Nom et Prénom -->
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" value="{{ Auth::user()->nom }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" value="{{ Auth::user()->prenom }}" class="form-control" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" required>
        </div>

        <!-- Adresse -->
        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" name="adresse" value="{{ Auth::user()->adresse }}" class="form-control">
        </div>

        <!-- Numéro de téléphone -->
        <div class="mb-3">
    <label for="telephone" class="form-label">Numéro de téléphone</label>
    <input type="tel" name="telephone" value="{{ Auth::user()->telephone }}"
        class="form-control"
        pattern="^0[5-7][0-9]{8}$"
        title="Le numéro doit commencer par 05, 06 ou 07 et contenir exactement 10 chiffres.">
</div>


        <!-- Image de Profil -->
        <div class="mb-3">
            <label for="image" class="form-label">Image de profil</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-maroon w-100">
            <i class="fas fa-save"></i> Sauvegarder les modifications
        </button>
    </form>
</div>



            <!-- Mes commandes -->
            <div id="mesCommandes-section" style="display: none;">
                <h2 class="mb-3">Mes Commandes</h2>
                <a href="{{ route('mes_commandes') }}" class="btn btn-maroon">
                    <i class="fas fa-eye"></i> Voir mes commandes
                </a>
            </div>



            <!-- Notifications Commandes Validées -->
<div id="notificationProp-section" style="display: none;">
    <h2 class="mb-3">Notifications Commandes Validées</h2>
    <a href="{{ route('notifications.validated', ['type' => 'App\Notifications\CommandeValideeNotification']) }}" class="btn btn-maroon">
        <i class="fas fa-bell"></i> Voir les Notifications
    </a>
</div>


            <!-- Notifications Commandes Reçues -->
            <div id="notificationRecu-section" style="display: none;">
                <h2 class="mb-3">Notifications Commandes Reçues</h2>
                <a href="{{ route('notifications.received', ['type' => 'App\Notifications\NotificationProprietaireCommande']) }}" class="btn btn-maroon">
                    <i class="fas fa-bell"></i> Voir les Notifications
                </a>
            </div>


            <!-- Ajouter une robe -->
            <div id="ajouterRobe-section" style="display: none;">
                <h3 class="mb-3">Ajouter une robe</h3>
                <form action="{{ route('robes.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm border">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de la robe</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="prix" class="form-label">Prix (DZD)</label>
                        <input type="number" name="prix" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Catégorie</label>
                        <select name="category" class="form-control" required>
                            <option value="simple">Simple</option>
                            <option value="fete">Fête</option>
                            <option value="mariee">Mariée</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" name="quantite" class="form-control" min="1" required>
                    </div>
                    <button type="submit" class="btn btn-maroon w-100">
                        <i class="fas fa-plus"></i> Ajouter
                    </button>
                </form>
            </div>

            <!-- Ajouter un accessoire -->
            <div id="ajouterBijou-section" style="display: none;">
                <h3 class="mb-3">Ajouter un accessoire</h3>
                <form action="{{ route('bijoux.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm border">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom de l'accessoire</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="prix" class="form-label">Prix (DZD)</label>
                        <input type="number" name="prix" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type d'accessoire</label>
                        <select name="type" class="form-control" required>
                            <option value="sac">Sac</option>
                            <option value="parreur">Parreur</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantite" class="form-label">Quantité</label>
                        <input type="number" name="quantite" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image de l'accessoire</label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-maroon w-100">
                        <i class="fas fa-plus"></i> Ajouter
                    </button>
                </form>
            </div>



            
            <!-- Commandes reçues -->
            <div id="commandesRecues-section" style="display: none;">
                <h2 class="mb-3">Commandes reçues</h2>
                <a href="{{ route('commandes_recues') }}" class="btn btn-maroon">
                    <i class="fas fa-box-open"></i> Voir les commandes reçues
                </a>
            </div>



 

            <!-- Voir mes articles -->
            <div id="mesArticles-section" style="display: none;">
                <h2 class="mb-3">Mes Articles</h2>
                <a href="{{ route('mes_articles') }}" class="btn btn-maroon">
                    <i class="fas fa-eye"></i> Voir mes articles
                </a>
            </div>
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

<script>


 // Fonction pour afficher/masquer le formulaire d'édition
 function toggleEditProfile() {
        var profileSection = document.getElementById('profile-section');
        var editProfileSection = document.getElementById('edit-profile-section');
        
        // Masquer le profil et afficher le formulaire de modification
        profileSection.style.display = 'none';
        editProfileSection.style.display = 'block';
    }

    function showSection(sectionId) {
        // Masquer toutes les sections
        const sections = document.querySelectorAll('#content-section > div');
        sections.forEach(section => section.style.display = 'none');
        
        // Afficher la section cliquée
        const sectionToShow = document.getElementById(sectionId + '-section');
        if (sectionToShow) {
            sectionToShow.style.display = 'block';
        }
        
        // Mettre en surbrillance le bouton actif
        const buttons = document.querySelectorAll('.menu-btn');
        buttons.forEach(button => button.classList.remove('active'));
        const activeButton = document.querySelector(`.menu-btn[onclick="showSection('${sectionId}')"]`);
        if (activeButton) {
            activeButton.classList.add('active');
        }
    }

    function isVendeurModeActive() {
        return localStorage.getItem('vendeurMode') === 'true';
    }

    function toggleVendeurMode() {
        const isChecked = document.getElementById('vendeurSwitch').checked;
        localStorage.setItem('vendeurMode', isChecked);
        updateVendeurUI();
    }

    function updateVendeurUI() {
    const isActive = isVendeurModeActive();
    document.getElementById('vendeurSwitch').checked = isActive;
    document.getElementById('vendeurSwitchLabel').textContent = isActive ? 'Désactiver le mode vendeur' : 'Activer le mode vendeur';

    // Affichage des boutons liés au mode vendeur
    document.getElementById('ajouterRobeBtn').style.display = isActive ? 'block' : 'none';
    document.getElementById('ajouterBijouBtn').style.display = isActive ? 'block' : 'none';
    
    document.getElementById('notificationRecuBtn').style.display = isActive ? 'block' : 'none';
    document.getElementById('commandesRecuesBtn').style.display = isActive ? 'block' : 'none';

    document.getElementById('mesArticlesBtn').style.display = isActive ? 'block' : 'none';
}


    document.addEventListener('DOMContentLoaded', () => {
        // Assurer que le mode vendeur est désactivé au départ
      
        updateVendeurUI();
        showSection('profile'); // Afficher le profil par défaut
    });
</script>

<style>


#notifications-section {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
}

.list-group-item {
    border: 1px solid #ddd;
    margin-bottom: 10px;
}

.list-group-item p {
    margin: 0;
}

    .btn-maroon {
        border: none;
        background-color: transparent;
        color: #6d4c41;
        font-size: 16px;
        text-align: left;
    }

    .btn-maroon:hover {
        background-color: #6d4c41;
        cursor: pointer;
    }
   
    /* Style pour les boutons de menu */
    .menu-btn {
        border: none;
        background-color: transparent;
        color: #6d4c41;
        font-size: 16px;
        text-align: left;
    }

    /* Agrandir la barre latérale */
#sidebar {
    width: 350px; /* Définit une largeur personnalisée */
}

@media (max-width: 768px) {
    #sidebar {
        width: 100%; /* Sur les petits écrans, occupe toute la largeur */
    }
}


    .menu-btn:hover {
        background-color: #f5f5f5;
        cursor: pointer;
    }

    .menu-btn.active {
        background-color: #6d4c41;
        color: white;
    }

    /* Style du bouton de déconnexion */
    .btn-logout {
        border: none;
        background-color: #d9534f;
        color: white;
        font-size: 16px;
        text-align: left;
        padding: 10px;
        border-radius: 5px;
    }

    .btn-logout:hover {
        background-color: #c9302c;
        cursor: pointer;
    }
</style>

@endsection
