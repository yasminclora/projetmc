<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une robe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2 class="text-center mb-4">Ajouter une nouvelle robe</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- ✅ Formulaire principal (avec enctype pour l'upload d'images) -->
        <form action="{{ route('robes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nom -->
            <div class="mb-3">
                <label for="nom" class="form-label fw-bold">Nom de la robe</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <!-- Prix -->
            <div class="mb-3">
                <label for="prix" class="form-label fw-bold">Prix (DZD)</label>
                <input type="number" name="prix" class="form-control" step="0.01" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label for="description" class="form-label fw-bold">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <!-- Image (Correction ici) -->
            <div class="mb-3">
                <label for="image" class="form-label fw-bold">Image</label>
                <input type="file" name="image" class="form-control" required>
            </div>

            <!-- Catégorie -->
            <div class="mb-3">
                <label for="category" class="form-label fw-bold">Catégorie</label>
                <select name="category" class="form-control" required>
                    <option value="simple">Simple</option>
                    <option value="fete">Fête</option>
                    <option value="mariee">Mariée</option>
                </select>
            </div>

            <!-- Quantité -->
            <div class="mb-3">
                <label for="quantite" class="form-label fw-bold">Quantité en stock</label>
                <input type="number" name="quantite" class="form-control" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Ajouter</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
