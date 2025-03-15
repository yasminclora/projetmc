<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script>
        function afficherSection(section) {
            document.querySelectorAll('.section').forEach(div => div.style.display = 'none');
            document.getElementById('section-' + section).style.display = 'block';
        }

        function afficherForm(id) {
            document.getElementById('form-' + id).style.display = 'block';
        }

        function afficherFormBijoux(id) {
            document.getElementById('form-bijoux-' + id).style.display = 'block';
        }

        function annulerModification(id) {
            document.getElementById('form-' + id).style.display = 'none';
        }

        function annulerModificationBijoux(id) {
            document.getElementById('form-bijoux-' + id).style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Tableau de Bord Administrateur</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="card" onclick="afficherSection('robes')">
                    <div class="card-body text-center">
                        <h5>Robes</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" onclick="afficherSection('bijoux')">
                    <div class="card-body text-center">
                        <h5>Bijoux</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" onclick="afficherSection('commandes')">
                    <div class="card-body text-center">
                        <h5>Commandes</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Robes -->
        <div id="section-robes" class="section mt-4" style="display:none;">
            <h2>Gestion des Robes</h2>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#ajouterRobeModal">+ Ajouter une robe</button>

            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Description</th>
                        <th>Catégorie</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($robes as $robe)
                    <tr>
                        <td>
                            @if($robe->image)
                                <img src="{{ asset('storage/' . $robe->image) }}" alt="{{ $robe->nom }}" width="50">
                            @else
                                <p>Pas d'image</p>
                            @endif
                        </td>
                        <td>{{ $robe->nom }}</td>
                        <td>{{ $robe->prix }} DA</td>
                        <td>{{ $robe->description }}</td>
                        <td>{{ ucfirst($robe->category) }}</td>
                        <td>{{ $robe->quantite }}</td>
                        <td>
                            <form action="{{ route('admin.robes.destroy', $robe->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>

                            <button class="btn btn-warning btn-sm" onclick="afficherForm({{ $robe->id }})">Modifier</button>

                            <!-- Formulaire caché de modification -->
                            <form id="form-{{ $robe->id }}" action="{{ route('admin.robes.update', $robe->id) }}" method="POST" enctype="multipart/form-data" class="mt-2" style="display:none;">
                                @csrf
                                @method('PUT')
                                <div class="mb-2">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" value="{{ $robe->nom }}" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Prix (DZD)</label>
                                    <input type="number" name="prix" value="{{ $robe->prix }}" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="2">{{ $robe->description }}</textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Catégorie</label>
                                    <select name="category" class="form-control" required>
                                        <option value="simple" {{ $robe->category === 'simple' ? 'selected' : '' }}>Simple</option>
                                        <option value="fete" {{ $robe->category === 'fete' ? 'selected' : '' }}>Fête</option>
                                        <option value="mariee" {{ $robe->category === 'mariee' ? 'selected' : '' }}>Mariée</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Quantité en stock</label>
                                    <input type="number" name="quantite" value="{{ $robe->quantite }}" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">Valider</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="annulerModification({{ $robe->id }})">Annuler</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Section Bijoux -->
        <div id="section-bijoux" class="section mt-4" style="display:none;">
            <h2>Gestion des Bijoux</h2>
            <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#ajouterBijouxModal">+ Ajouter un bijou</button>

            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bijoux as $bijou)
                    <tr>
                        <td>
                            @if($bijou->image)
                                <img src="{{ asset('storage/' . $bijou->image) }}" alt="{{ $bijou->nom }}" width="50">
                            @else
                                <p>Pas d'image</p>
                            @endif
                        </td>
                        <td>{{ $bijou->nom }}</td>
                        <td>{{ $bijou->prix }} DA</td>
                        <td>{{ $bijou->quantite }}</td>
                        <td>{{ ucfirst($bijou->type) }}</td>
                        <td>
                            <form action="{{ route('admin.bijoux.destroy', $bijou->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>

                            <button class="btn btn-warning btn-sm" onclick="afficherFormBijoux({{ $bijou->id }})">Modifier</button>

                            <!-- Formulaire caché de modification -->
                            <form id="form-bijoux-{{ $bijou->id }}" action="{{ route('admin.bijoux.update', $bijou->id) }}" method="POST" enctype="multipart/form-data" class="mt-2" style="display:none;">
                                @csrf
                                @method('PUT')
                                <div class="mb-2">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="nom" value="{{ $bijou->nom }}" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Prix (DZD)</label>
                                    <input type="number" name="prix" value="{{ $bijou->prix }}" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Type</label>
                                    <select name="type" class="form-control" required>
                                        <option value="sac" {{ $bijou->type === 'sac' ? 'selected' : '' }}>Sac</option>
                                        <option value="parreur" {{ $bijou->type === 'parreur' ? 'selected' : '' }}>Parreur</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Quantité en stock</label>
                                    <input type="number" name="quantite" value="{{ $bijou->quantite }}" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">Valider</button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="annulerModificationBijoux({{ $bijou->id }})">Annuler</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Section Commandes -->
        <div id="section-commandes" class="section mt-4" style="display:none;">
            <h2>Liste des Commandes</h2>
            <p>Aucune commande pour le moment.</p>
        </div>
    </div>

    <!-- Modal : Formulaire d'ajout de robe -->
    <div class="modal fade" id="ajouterRobeModal" tabindex="-1" aria-labelledby="ajouterRobeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajouterRobeLabel">Ajouter une robe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.robes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prix (DZD)</label>
                            <input type="number" name="prix" class="form-control" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catégorie</label>
                            <select name="category" class="form-control" required>
                                <option value="simple">Simple</option>
                                <option value="fete">Fête</option>
                                <option value="mariee">Mariée</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantité en stock</label>
                            <input type="number" name="quantite" class="form-control" min="1" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal : Formulaire d'ajout de bijou -->
    <div class="modal fade" id="ajouterBijouxModal" tabindex="-1" aria-labelledby="ajouterBijouxLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ajouterBijouxLabel">Ajouter un bijou</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.bijoux.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prix (DZD)</label>
                            <input type="number" name="prix" class="form-control" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-control" required>
                                <option value="sac">Sac</option>
                                <option value="parreur">Parreur</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Quantité en stock</label>
                            <input type="number" name="quantite" class="form-control" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>