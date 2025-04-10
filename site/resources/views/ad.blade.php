<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

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
        </div>
    </div>

    <!-- Navbar -->
    <nav class="main-navbar">
        <div></div> <!-- Empty div for spacing -->
        <div class="d-flex align-items-center">
           
            <div class="nav-item dropdown">
                <div class="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3498db&color=fff" class="user-avatar">
                    <i class="fas fa-chevron-down"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                   
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Paramètres</a></li>
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
    </div>

   
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Fonctions pour afficher/masquer les sections
        function afficherSection(section) {
            document.querySelectorAll('.section').forEach(div => div.style.display = 'none');
            document.getElementById('section-' + section).style.display = 'block';
            
            // Mettre à jour le menu actif
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.classList.remove('active');
            });
            document.querySelector(`.sidebar-menu a[onclick="afficherSection('${section}')"]`).classList.add('active');
        }

       

      

        // Afficher la section dashboard par défaut
        document.addEventListener('DOMContentLoaded', function() {
            afficherSection('dashboard');
        });
    </script>
</body>
</html>