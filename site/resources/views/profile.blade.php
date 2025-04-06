@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Barre latérale à gauche -->
        <div class="col-md-3 col-lg-2 p-0 bg-white text-dark" style="height: 100vh;">
            <div class="d-flex flex-column align-items-start p-3">
                <!-- Titre de la section à gauche -->
                <h5 class="mb-4">Mon Compte</h5>

                <!-- Boutons de navigation avec icônes -->
                <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('profile')">
                    <i class="fas fa-user-circle"></i> Profil
                </button>
                <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('mesCommandes')">
                    <i class="fas fa-box"></i> Mes Commandes
                </button>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="vendeurSwitch" onchange="toggleVendeurMode()" />
                    <label class="form-check-label" for="vendeurSwitch" id="vendeurSwitchLabel">Activer le mode vendeur</label>
                </div>
                <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('ajouterRobe')" id="ajouterRobeBtn" style="display: none;">
                    <i class="fas fa-tshirt"></i> Ajouter une robe
                </button>
                <button class="btn btn-white w-100 mb-3 menu-btn" onclick="showSection('ajouterBijou')" id="ajouterBijouBtn" style="display: none;">
                    <i class="fas fa-gem"></i> Ajouter un accessoire
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
        <div class="col-md-9 col-lg-10 p-4" id="content-section">
            <!-- Profil utilisateur -->
            <div id="profile-section" style="display: none;">
                <h2 class="mb-3">Profil de {{ Auth::user()->name }}</h2>
                <div class="p-4 bg-white rounded shadow-sm border">
                    <p class="mb-2"><strong>Nom :</strong> {{ Auth::user()->name }}</p>
                    <p class="mb-0"><strong>Email :</strong> {{ Auth::user()->email }}</p>
                    <a href="{{ route('edit') }}" class="btn btn-maroon mt-3">
                        <i class="fas fa-user-edit"></i> Modifier le profil
                    </a>
                </div>
            </div>

            <!-- Mes commandes -->
            <div id="mesCommandes-section" style="display: none;">
                <h2 class="mb-3">Mes Commandes</h2>
                <a href="{{ route('mes_commandes') }}" class="btn btn-maroon">
                    <i class="fas fa-eye"></i> Voir mes commandes
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

<script>
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

        document.getElementById('ajouterRobeBtn').style.display = isActive ? 'block' : 'none';
        document.getElementById('ajouterBijouBtn').style.display = isActive ? 'block' : 'none';
        document.getElementById('commandesRecuesBtn').style.display = isActive ? 'block' : 'none';
        document.getElementById('mesArticlesBtn').style.display = isActive ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Assurer que le mode vendeur est désactivé au départ
        localStorage.setItem('vendeurMode', 'false');
        updateVendeurUI();
        showSection('profile'); // Afficher le profil par défaut
    });
</script>

<style>
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
