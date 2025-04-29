<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #1a252f;
            --accent-color: #3498db;
            --sidebar-bg: #2c3e50;
            --navbar-bg: #ffffff;
            --hover-color: #34495e;
            --active-color: #3498db;
            --text-light: #ecf0f1;
            --text-dark: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: var(--text-dark);
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            padding: 1.5rem 0;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            padding: 0 1.5rem 1.5rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-brand .logo-icon {
            font-size: 1.8rem;
            color: var(--accent-color);
            margin-right: 10px;
        }

        .sidebar-brand .logo-text {
            font-size: 1.4rem;
            font-weight: 700;
            color: white;
        }

        .sidebar-menu {
            padding: 0 1rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: var(--hover-color);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu a i {
            font-size: 1.1rem;
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Navbar Styles */
        .main-navbar {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            height: 70px;
            background: var(--navbar-bg);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            z-index: 900;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            justify-content: space-between;
        }

        .nav-item {
            margin-left: 1.5rem;
            position: relative;
        }

        .nav-icon {
            font-size: 1.3rem;
            color: #7f8c8d;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-icon:hover {
            color: var(--accent-color);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger-color);
            color: white;
            border-radius: 50%;
            padding: 3px 7px;
            font-size: 0.65rem;
            font-weight: bold;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            border: 2px solid var(--accent-color);
        }

        .user-name {
            font-weight: 600;
            color: var(--text-dark);
            margin-right: 5px;
        }

        .dropdown-menu {
            border: none;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 0;
            margin-top: 10px;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-size: 0.9rem;
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: var(--accent-color);
        }

        .dropdown-item i {
            margin-right: 8px;
            width: 18px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 280px;
            padding: 90px 2rem 2rem;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
            background-color: white;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0;
            color: var(--text-dark);
        }

        /* Dashboard specific styles */
        .dashboard-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card h5 {
            color: var(--primary-color);
        }

        .section {
            display: none;
        }

        /* Stats specific styles */
        .stat-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-card .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 1.5rem;
        }

        .chart-container {
            padding: 1rem;
            position: relative;
            height: 250px;
            width: 100%;
        }

        .badge-purple {
            background-color: #9b59b6;
            color: white;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-navbar {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .navbar-toggler {
                display: block;
                margin-right: 1rem;
            }
        }


   

    </style>
</head>

<body>

@auth
    @if(Auth::user()->role === 'admin')
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="logo-icon"><i class="fas fa-cog"></i></div>
            <div class="logo-text">Administration</div>
        </div>

        <div class="sidebar-menu">
            <a href="#" class="active" onclick="afficherSection('dashboard')">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>

            <a href="#" onclick="afficherSection('robes')">
                <i class="fas fa-tshirt"></i>
                <span>Robes</span>
            </a>

            <a href="#" onclick="afficherSection('bijoux')">
                <i class="fas fa-gem"></i>
                <span>Accessoires</span>
            </a>

            <a href="#" onclick="afficherSection('commandes')">
                <i class="fas fa-shopping-bag"></i>
                <span>Commandes</span>
            </a>

            <a href="#" onclick="afficherSection('utilisateur')">
                <i class="fas fa-user-circle"></i>
                <span>Utilisateurs</span>
            </a>

            <a href="#" onclick="afficherSection('statistiques')">
                <i class="fas fa-chart-bar"></i>
                <span>Statistiques</span>
            </a>

            <a href="#" onclick="afficherSection('revenus')">
    <i class="fas fa-money-bill-wave"></i>
    <span>Revenus</span>
</a>



<a href="#" onclick="afficherSection('signal')" class="d-flex align-items-center">
    <i class="fas fa-flag"></i>
    <span>Signalement</span>
    @php
        $nonVus = $signalements->where('vu', 0); // Filtrer les signalements non vus
    @endphp
    @if($nonVus->count() > 0)
        <span id="notif-count" class="badge bg-danger ms-2">{{ $nonVus->count() }}</span>
    @endif
</a>





        </div>
    </div>

    <!-- Navbar -->
    <nav class="main-navbar">
        <div>



</div>

        </div> <!-- Empty div for spacing -->
        <div class="d-flex align-items-center">
           
            <div class="nav-item dropdown">
                <div class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3498db&color=fff" class="user-avatar">
                    <i class="fas fa-chevron-down"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
     
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Dashboard Section -->
        <div id="section-dashboard" class="section">
            <h2 class="mb-4">Tableau de Bord Administrateur</h2>

            <div class="row">
                <div class="col-md-4">
                    <div class="card dashboard-card" onclick="afficherSection('robes')">
                        <div class="card-body text-center">
                            <i class="fas fa-tshirt fa-3x mb-3" style="color: #3498db;"></i>
                            <h5>Robes</h5>
                            <p class="mb-0">{{ $robes->count() }} produits</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card dashboard-card" onclick="afficherSection('bijoux')">
                        <div class="card-body text-center">
                            <i class="fas fa-gem fa-3x mb-3" style="color: #e74c3c;"></i>
                            <h5>Accessoires</h5>
                            <p class="mb-0">{{ $bijoux->count() }} produits</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card dashboard-card" onclick="afficherSection('commandes')">
                        <div class="card-body text-center">
                            <i class="fas fa-shopping-bag fa-3x mb-3" style="color: #2ecc71;"></i>
                            <h5>Commandes</h5>
                            <p class="mb-0">{{ $commandes->count() }} commandes</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card dashboard-card" onclick="afficherSection('utilisateur')">
                        <div class="card-body text-center">
                            <i class="fas fa-user-circle fa-3x mb-3" style="color: #2ecc71;"></i>
                            <h5>Utilisateurs</h5>
                            <p class="mb-0">{{ $users->count() }} utilisateurs</p>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="card dashboard-card" onclick="afficherSection('signal')">
                        <div class="card-body text-center">

                     
                            <i class="fas fa-flag fa-3x mb-3" style="color: #2ecc71;"></i>
                            <h5>Signal</h5>
                            <p class="mb-0">{{ $signalements->count() }} signal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Robes Section -->
        <div id="section-robes" class="section mt-4" style="display:none;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Gestion des Robes</h2>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Nom</th>
                                    <th>Prix</th>
                                    <th>Description</th>
                                    <th>Catégorie</th>
                                    <th>Stock</th>
                                    <th>Ajouté par</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($robes as $robe)
                                <tr>
                                    <td>
                                        @if($robe->image)
                                            <img src="{{ asset('storage/' . $robe->image) }}" alt="{{ $robe->nom }}" width="50" class="img-thumbnail">
                                        @else
                                            <span class="badge bg-secondary">Pas d'image</span>
                                        @endif
                                    </td>
                                    <td>{{ $robe->nom }}</td>
                                    <td>{{ number_format($robe->prix, 2, ',', ' ') }} DA</td>
                                    <td>{{ Str::limit($robe->description, 50) }}</td>
                                    <td><span class="badge bg-primary">{{ ucfirst($robe->category) }}</span></td>
                                    <td>{{ $robe->quantite }}</td>
                                    <td>
                                        @if($robe->user)
                                            {{ $robe->user->email }}
                                        @else
                                            <span class="text-muted">Utilisateur inconnu</span>
                                        @endif
                                    </td>

                                    <td>
                <div class="d-flex gap-2">
                    <!-- Bouton Modifier -->
                    <button class="btn btn-sm btn-warning" 
                            onclick="toggleEditForm('robe', {{ $robe->id }})">
                        <i class="fas fa-edit"></i>
                    </button>


                     <!-- Bouton Supprimer -->
                     <form action="{{ route('admin.robes.destroy', $robe->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette robe ?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </td>

                                </tr>


<!-- Formulaire de modification (caché par défaut) -->
<tr id="edit-form-robe-{{ $robe->id }}" style="display: none;">
            <td colspan="8">
                <form action="{{ route('admin.robes.update', $robe->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label>Nom</label>
                            <input type="text" name="nom" value="{{ $robe->nom }}" class="form-control" required>
                        </div>
                        <div class="col-md-2">
                            <label>Prix (DA)</label>
                            <input type="number" name="prix" value="{{ $robe->prix }}" class="form-control" required>
                            </div>
                        <div class="col-md-2">
                            <label>Catégorie</label>
                            <select name="category" class="form-select">
                                <option value="simple" {{ $robe->category == 'simple' ? 'selected' : '' }}>Simple</option>
                                <option value="fete" {{ $robe->category == 'fete' ? 'selected' : '' }}>Fête</option>
                                <option value="mariee" {{ $robe->category == 'mariee' ? 'selected' : '' }}>Mariée</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Stock</label>
                            <input type="number" name="quantite" value="{{ $robe->quantite }}" class="form-control" required>
                            </div>


                            <div class="col-md-3">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control">
                            <small class="text-muted">Laissez vide pour garder l'image actuelle</small>
                        </div>
                        <div class="col-md-12">
                            <label>Description</label>
                            <textarea name="description" class="form-control">{{ $robe->description }}</textarea>
                        </div>


                        <div class="col-md-12 d-flex gap-2 mt-2">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Enregistrer
                            </button>


                            <button type="button" class="btn btn-secondary" 
                                    onclick="toggleEditForm('robe', {{ $robe->id }})">
                                <i class="fas fa-times"></i> Annuler
                            </button>
                        </div>
                    </div>
                </form>
                </td>
                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

       



        <!-- Bijoux Section -->
<div id="section-bijoux" class="section mt-4" style="display:none;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestion des Accessoires</h2>
       
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Type</th>
                            <th>Ajouté par</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bijoux as $bijou)
                        <tr>
                            <td>
                                @if($bijou->image)
                                    <img src="{{ asset('storage/' . $bijou->image) }}" alt="{{ $bijou->nom }}" width="50" class="img-thumbnail">
                                @else
                                    <span class="badge bg-secondary">Pas d'image</span>
                                @endif
                            </td>
                            <td>{{ $bijou->nom }}</td>
                            <td>{{ number_format($bijou->prix, 2, ',', ' ') }} DA</td>
                            <td>{{ $bijou->quantite }}</td>
                            <td><span class="badge bg-info">{{ ucfirst($bijou->type) }}</span></td>
                            <td>
                                @if($bijou->user)
                                    {{ $bijou->user->email }}
                                @else
                                    <span class="text-muted">Utilisateur inconnu</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Bouton Modifier -->
                                    <button class="btn btn-sm btn-warning" 
                                            onclick="toggleEditForm('bijou', {{ $bijou->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <!-- Bouton Supprimer -->
                                    <form action="{{ route('admin.bijoux.destroy', $bijou->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet accessoire ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Formulaire de modification (caché par défaut) -->
                        <tr id="edit-form-bijou-{{ $bijou->id }}" style="display: none;">
                            <td colspan="7">
                                <form action="{{ route('admin.bijoux.update', $bijou->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label>Nom</label>
                                            <input type="text" name="nom" value="{{ $bijou->nom }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Prix (DA)</label>
                                            <input type="number" name="prix" value="{{ $bijou->prix }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Type</label>
                                            <select name="type" class="form-select">
                                                <option value="sac" {{ $bijou->type == 'sac' ? 'selected' : '' }}>Sac</option>
                                                <option value="parreur" {{ $bijou->type == 'parreur' ? 'selected' : '' }}>Parure</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>Stock</label>
                                            <input type="number" name="quantite" value="{{ $bijou->quantite }}" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Image</label>
                                            <input type="file" name="image" class="form-control">
                                            <small class="text-muted">Laissez vide pour garder l'image actuelle</small>
                                        </div>
                                        <div class="col-md-12 d-flex gap-2 mt-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-check"></i> Enregistrer
                                            </button>
                                            <button type="button" class="btn btn-secondary" 
                                                    onclick="toggleEditForm('bijou', {{ $bijou->id }})">
                                                <i class="fas fa-times"></i> Annuler
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

        <!-- Commandes Section -->
        <div id="section-commandes" class="section mt-4" style="display:none;">
            <h2 class="mb-4">Liste des Commandes</h2>
            
            @if($commandes->isEmpty())
                <div class="alert alert-info">Aucune commande pour le moment.</div>
            @else
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>N° Commande</th>
                                        <th>Date</th>
                                        <th>Client</th>
                                        <th>Total</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commandes as $commande)
                                    <tr>
                                        <td>#{{ $commande->id }}</td>
                                        <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $commande->user->email ?? 'Client inconnu' }}</td>
                                        <td>{{ number_format($commande->total, 2, ',', ' ') }} DA</td>
                                        <td>
                                            <span class="badge 
                                                @if($commande->statut == 'en_attente') bg-warning
                                                @elseif($commande->statut == 'validee') bg-success
                                                @elseif($commande->statut == 'refusee') bg-danger
                                                @elseif($commande->statut == 'payee') bg-info
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Section Utilisateurs -->
        <div id="section-utilisateur" class="section mt-4" style="display:none;">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 text-dark">Gestion des Utilisateurs</h4>
                    
                </div>
                
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3 px-3">ID</th>
                                    <th class="py-3 px-3">Nom</th>
                                    <th class="py-3 px-3">Prénom</th>
                                    <th class="py-3 px-3">Email</th>
                                    <th class="py-3 px-3">Adresse</th>
                                    <th class="py-3 px-3">Image</th>
                                    <th class="py-3 px-3">Rôle</th>
                                    <th class="py-3 px-3">Inscription</th>
                                    <th class="py-3 px-3 text-end">Actions</th>
                                </tr>
                            </thead>

                            @if($users->isEmpty())
                                <tbody>
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="alert alert-info mb-0">Aucun utilisateur pour le moment.</div>
                                        </td>
                                    </tr>
                                </tbody>
                            @else
                                <tbody>
                                    @foreach($users as $user)
                                    <tr class="align-middle">
                                        <td class="px-3">{{ $user->id }}</td>
                                        <td class="px-3">{{ $user->name }}</td>
                                        <td class="px-3">{{ $user->prenom }}</td>
                                        <td class="px-3">{{ $user->email }}</td>
                                        <td class="px-3">{{ $user->adresse }}</td>
                                        <td class="px-3">
                                            <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}" width="50" class="img-thumbnail">
                                        </td>
                                        <td class="px-3">
                                            <span class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                                                {{ $user->role ?? 'Utilisateur' }}
                                            </span>
                                        </td>
                                        <td class="px-3">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-3 text-end">
    <!-- Bouton Modifier -->
    <button class="btn btn-sm btn-outline-warning" onclick="toggleFormModification({{ $user->id }})">
        <i class="fas fa-edit"></i> Modifier
    </button>
    
    <!-- Bouton Supprimer -->
    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger" 
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
            <i class="fas fa-trash"></i> Supprimer
        </button>
    </form>
</td>
                                    </tr>
                                    <!-- Formulaire de modification -->
                                    <tr id="form-modif-{{ $user->id }}" style="display: none;">
                                        <td colspan="9" class="p-3 bg-light">
                                            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white p-3 rounded">
                                                @csrf
                                                @method('PUT')
                                                <div class="row g-3 align-items-center">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Nom</label>
                                                        <input type="text" name="name" value="{{ $user->name }}" 
                                                               class="form-control" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" name="email" value="{{ $user->email }}" 
                                                               class="form-control" required>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Rôle</label>
                                                        <select name="role" class="form-select">
                                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Utilisateur</option>
                                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2 d-flex align-items-end gap-2">
                                                        <button type="submit" class="btn btn-success flex-grow-1">
                                                            <i class="fas fa-check me-1"></i> Valider
                                                        </button>
                                                        <button type="button" class="btn btn-danger flex-grow-1" 
                                                                onclick="toggleFormModification({{ $user->id }})">
                                                            <i class="fas fa-times me-1"></i> Annuler
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>




        
        <!-- Statistiques Section -->
        <div id="section-statistiques" class="section mt-4" style="display:none;">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Statistiques Générales</h2>
            </div>

            <!-- Cartes de statistiques -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x mb-3" style="color: #3498db;"></i>
                            <h5>Utilisateurs</h5>
                            <p class="mb-0">{{ $users->count() }} utilisateurs</p>
                            <div class="mt-2">
                                <span class="badge bg-primary">Admin: {{ $users->where('role', 'admin')->count() }}</span>
                                <span class="badge bg-secondary ms-1">Clients: {{ $users->where('role', 'user')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body text-center">
                            <i class="fas fa-shopping-cart fa-3x mb-3" style="color: #e74c3c;"></i>
                            <h5>Commandes</h5>
                            <p class="mb-0">{{ $commandes->count() }} commandes</p>
                            <div class="mt-2">
                                <span class="badge bg-primary">Validées: {{ $commandes->where('statut', 'validee')->count() }}</span>
                                <span class="badge bg-warning ms-1">En attente: {{ $commandes->where('statut', 'en_attente')->count() }}</span>
                                <span class="badge bg-danger ">Refusées: {{ $commandes->where('statut', 'refusee')->count() }}</span>
                                <span class="badge bg-primary ">Payées: {{ $commandes->where('statut', 'payee')->count() }}</span>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card stat-card">
                        <div class="card-body text-center">
                            <i class="fas fa-boxes fa-3x mb-3" style="color: #2ecc71;"></i>
                            <h5>Produits</h5>
                            <p class="mb-0">{{ $robes->count() + $bijoux->count() }} produits</p>
                            <div class="mt-2">
                            <span class="badge bg-info">Accessoires: {{ $bijoux->count() }}</span>

                                <span class="badge bg-info">Robes: {{ $robes->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphiques -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card stat-card">
                        <div class="card-header">
                            <h5 class="mb-0">Activité des utilisateurs</h5>
                        </div>
                        <div class="card-body chart-container">
                            <canvas id="userActivityChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card stat-card">
                        <div class="card-header">
                            <h5 class="mb-0">Statut des commandes</h5>
                        </div>
                        <div class="card-body chart-container">
                            <canvas id="orderStatusChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tableau des meilleurs clients -->
            <div class="card stat-card">
                <div class="card-header">
                    <h5 class="mb-0">Top 5 des clients</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Client</th>
                                    <th>Commandes</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                             <!-- Affichage des top clients -->
@foreach($topClients as $index => $client)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <div class="d-flex align-items-center">
            <img src="{{ asset('storage/' . $client->image) }}" alt="{{ $client->name }}" width="40" class="rounded-circle me-2">
            <div>
                <strong>{{ $client->name }} {{ $client->prenom }}</strong>
                <small class="text-muted d-block">{{ $client->email }}</small>
            </div>
        </div>
    </td>
    <td>{{ $client->commandes_count }}</td>
    
</tr>
@endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>








        <div id="section-revenus" class="section mt-4" style="display:none;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-money-bill-wave me-2"></i>
         Total commandes par Utilisateur
        </h2>
        <div class="badge bg-primary">
            {{ $revenues->count() }} utilisateurs
        </div>
    </div>

    @if($revenues->isEmpty())
        <div class="alert alert-info">
            Aucun revenu à afficher pour le moment.
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Utilisateur</th>
                                <th class="text-end">Commandes</th>
                                <th class="text-end">Revenu Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenues as $index => $revenue)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $revenue['user']->image ? asset('storage/'.$revenue['user']->image) : 'https://ui-avatars.com/api/?name='.$revenue['user']->name.'&background=random' }}" 
                                             class="rounded-circle me-2" 
                                             width="40" 
                                             height="40"
                                             style="object-fit: cover">
                                        <div>
                                            <div>{{ $revenue['user']->name }}</div>
                                            <small class="text-muted">{{ $revenue['user']->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <span class="badge bg-info rounded-pill px-2 py-1">
                                        {{ $revenue['orders_count'] }}
                                    </span>
                                </td>
                                <td class="text-end font-weight-bold text-success">
                                    {{ number_format($revenue['total_revenue'], 0, ',', ' ') }} DA
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

       
    @endif


    <h2 class="mb-0">
            <i class="fas fa-money-bill-wave me-2"></i>
            Payer Vendeur
        </h2>


        <div class="text-end mt-4 px-3">
    <form action="{{ route('admin.payerParArticle') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">
            <i class="fas fa-coins me-1"></i> Payer chaque utilisateur selon ses articles
        </button>
    </form>
</div>

<div class="mt-4">
    <h4>Utilisateurs Payés</h4>
    <ul class="list-group">
        @foreach($users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $user->name }} ({{ $user->email }})
                <span class="badge bg-success">{{ number_format($user->solde, 0, ',', ' ') }} DA</span>
            </li>
        @endforeach
    </ul>
</div>


</div>
   




<div id="section-signal" class="section mt-4" style="display:none;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Signalements par Utilisateur
        </h2>
        <div class="badge bg-primary" id="notif-total">
            {{ $signalements->count() }} signalements
        </div>
    </div>

    @if($signalements->isNotEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th>Utilisateur</th>
                                <th>Motif</th>
                                <th>Élément signalé</th>
                                <th>Article signalé</th>
                                <th>Vu</th> <!-- Nouvelle colonne Vu -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($signalements as $index => $signalement)
                            <tr class="{{ $signalement->vu ? 'vue' : '' }}" data-id="{{ $signalement->id }}">

                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $signalement->user->name ?? 'Inconnu' }}</td>
                                    <td>{{ $signalement->motif }}</td>
                                    <td>
                                        {{ $signalement->signalable->nom ?? 'Nom non disponible' }}
                                        <small class="text-muted d-block">
                                            {{ class_basename($signalement->signalable_type) }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($signalement->signalable && $signalement->signalable->image)
                                            <img src="{{ asset('storage/' . $signalement->signalable->image) }}" 
                                                 alt="Image de l'article signalé" 
                                                 class="img-fluid rounded shadow-sm" 
                                                 style="max-width: 100px;">
                                        @else
                                            <span class="text-muted">Image non disponible</span>
                                        @endif
                                    </td>
                                    <td>
    <button class="btn btn-sm btn-{{ $signalement->vu ? 'success' : 'warning' }}" 
            onclick="marquerVu({{ $signalement->id }})">
        {{ $signalement->vu ? 'Vu' : 'Marquer comme lu' }}
    </button>
</td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            @if(strtolower($signalement->motif) === 'contenu inapproprié')
                                                <form action="{{ route('signalement.supprimerArticle', $signalement->id) }}" method="POST" onsubmit="return confirm('Supprimer cet article ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Aucun signalement à afficher pour le moment.
        </div>
    @endif
</div>
</div>


<script>
function marquerVu(id) {
    fetch(`/signalements/${id}/marquer-vu`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
    }).then(response => {
        if (response.ok) {
            location.reload(); // ou mettre à jour le bouton dynamiquement
        } else {
            alert('Erreur lors du traitement.');
        }
    });
}
</script>

   

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>




        // Fonction pour générer les graphiques
        function generateCharts() {
            // Données pour le graphique d'activité des utilisateurs (top 5 clients)
            const userActivityData = {
                labels: {!! json_encode($topClients->pluck('name')) !!},
                datasets: [{
                    label: 'Nombre de commandes',
                    data: {!! json_encode($topClients->pluck('commandes_count')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            };

            // Données pour le graphique des statuts de commande
            const orderStatusData = {
                labels: ['Validées', 'En attente', 'Refusées','payee'],
                datasets: [{
                    data: [
                        {{ $commandes->where('statut', 'validee')->count() }},
                        {{ $commandes->where('statut', 'en_attente')->count() }},
                        {{ $commandes->where('statut', 'refusee')->count() }},
                        {{ $commandes->where('statut', 'payee')->count() }}
                    ],
                    backgroundColor: [
                        'rgba(41, 8, 94, 0.7)',
                        'rgba(241, 196, 15, 0.7)',
                        'rgba(231, 76, 60, 0.7)',
                        'rgba(30, 125, 21, 0.7)',

                    ],
                    borderColor: [
                        'rgba(6, 35, 133, 0.7)',
                        'rgb(241, 196, 15)',
                        'rgb(231, 76, 60)',
                        'rgba(46, 204, 113, 0.7)',

                    ],
                    borderWidth: 1
                }]
            };

            // Graphique d'activité des utilisateurs
            new Chart(
                document.getElementById('userActivityChart'),
                {
                    type: 'bar',
                    data: userActivityData,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Nombre de commandes'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Utilisateurs'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Commandes: ' + context.raw;
                                    }
                                }
                            }
                        }
                    }
                }
            );

            // Graphique des statuts de commande
            new Chart(
                document.getElementById('orderStatusChart'),
                {
                    type: 'doughnut',
                    data: orderStatusData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const value = context.raw;
                                        const percentage = Math.round((value / total) * 100);
                                        return `${context.label}: ${value} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                }
            );
        }

        // Fonction pour afficher/masquer les sections
        function afficherSection(section) {
            document.querySelectorAll('.section').forEach(div => div.style.display = 'none');
            document.getElementById('section-' + section).style.display = 'block';
            
            // Mettre à jour le menu actif
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.classList.remove('active');
            });
            document.querySelector(`.sidebar-menu a[onclick="afficherSection('${section}')"]`).classList.add('active');

            // Si c'est la section statistiques, générer les graphiques
            if(section === 'statistiques') {
                generateCharts();
            }
        }

        function toggleFormModification(userId) {
            const form = document.getElementById(`form-modif-${userId}`);
            form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
            
            // Scroll vers le formulaire si on l'affiche
            if(form.style.display === 'table-row') {
                form.scrollIntoView({behavior: 'smooth', block: 'nearest'});
            }
        }

        function afficherFormAjout() {
            // À implémenter selon vos besoins
            alert("Fonctionnalité d'ajout à implémenter");
        }

        // Afficher la section dashboard par défaut
        document.addEventListener('DOMContentLoaded', function() {
            afficherSection('dashboard');
        });




// Dans la section <script> de votre vue
function toggleEditForm(type, id) {
    const form = document.getElementById(`edit-form-${type}-${id}`);
    form.style.display = form.style.display === 'none' ? 'table-row' : 'none';
    
    // Scroll vers le formulaire si on l'affiche
    if(form.style.display === 'table-row') {
        form.scrollIntoView({behavior: 'smooth', block: 'nearest'});
    }
}










    </script>

@endif
@endauth

</body>
</html>