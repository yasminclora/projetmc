@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Mes Articles</h2>

    <!-- Boutons pour basculer entre Robes et Bijoux -->
    <div class="text-center mb-4">
        <button class="btn btn-outline-primary btn-lg mx-2" onclick="showSection('robes')">👗 Voir les Robes</button>
        <button class="btn btn-outline-secondary btn-lg mx-2" onclick="showSection('bijoux')">💍 Voir les Bijoux</button>
    </div>

    <!-- Section Robes -->
    <div id="robes-section">
        <h3 class="text-primary text-center mb-3">👗 Robes</h3>
        <div class="row">
            @foreach ($robes as $robe)
                @if ($robe->user_id == Auth::id())
                    <div class="col-md-4">
                        <div class="card article-card">
                            <img src="{{ asset('storage/' . $robe->image) }}" class="card-img-top" alt="{{ $robe->nom }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $robe->nom }}</h5>
                                <p class="card-text"><strong>Prix :</strong> {{ $robe->prix }} DZD</p>
                                <p class="card-text"><strong>Quantite :</strong> {{ $robe->quantite }} </p>
                                <p class="card-text">{{ $robe->description }}</p>

                                <!-- Bouton Modifier -->
                                <button class="btn btn-warning btn-sm" onclick="afficherFormRobe({{ $robe->id }})">✏ Modifier</button>

                                <!-- Formulaire caché de modification -->
                                <form id="form-robe-{{ $robe->id }}" action="{{ route('user.robes.update', $robe->id) }}" method="POST" enctype="multipart/form-data" class="mt-2" style="display:none;">
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
                                    <button type="button" class="btn btn-danger btn-sm" onclick="annulerModificationRobe({{ $robe->id }})">Annuler</button>
                                </form>

                                <!-- Bouton Supprimer -->
                                <form action="{{ route('user.robes.destroy', $robe->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">🗑 Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <!-- Section Bijoux (cachée par défaut) -->
    <div id="bijoux-section" style="display: none;">
        <h3 class="text-secondary text-center mb-3">💍 Bijoux</h3>
        <div class="row">
            @foreach ($bijoux as $bijou)
                <div class="col-md-4">
                    <div class="card article-card">
                        <img src="{{ asset('storage/' . $bijou->image) }}" class="card-img-top" alt="{{ $bijou->nom }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $bijou->nom }}</h5>
                            <p class="card-text"><strong>Prix :</strong> {{ $bijou->prix }} DZD</p>
                            <p class="card-text"><strong>Quantite :</strong> {{ $bijou->quantite}} </p>
                            <!-- Bouton Modifier -->
                            <button class="btn btn-warning btn-sm" onclick="afficherFormBijoux({{ $bijou->id }})">✏ Modifier</button>

                            <!-- Formulaire caché de modification -->
                            <form id="form-bijoux-{{ $bijou->id }}" action="{{ route('user.bijoux.update', $bijou->id) }}" method="POST" enctype="multipart/form-data" class="mt-2" style="display:none;">
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

                            <!-- Bouton Supprimer -->
                            <form action="{{ route('user.bijoux.destroy', $bijou->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">🗑 Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Script JavaScript pour gérer l'affichage -->
<script>
    function showSection(section) {
        if (section === 'robes') {
            document.getElementById('robes-section').style.display = 'block';
            document.getElementById('bijoux-section').style.display = 'none';
        } else {
            document.getElementById('robes-section').style.display = 'none';
            document.getElementById('bijoux-section').style.display = 'block';
        }
    }

    function afficherFormRobe(id) {
        document.getElementById('form-robe-' + id).style.display = 'block';
    }

    function annulerModificationRobe(id) {
        document.getElementById('form-robe-' + id).style.display = 'none';
    }

    function afficherFormBijoux(id) {
        document.getElementById('form-bijoux-' + id).style.display = 'block';
    }

    function annulerModificationBijoux(id) {
        document.getElementById('form-bijoux-' + id).style.display = 'none';
    }
</script>

<!-- Styles CSS -->
<style>
    .article-card {
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .article-card:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card-img-top {
        height: 250px;
        object-fit: cover;
    }

    .btn-warning {
        background-color: #ffcc00;
        border: none;
    }

    .btn-danger {
        background-color: #ff4d4d;
        border: none;
    }
</style>
@endsection