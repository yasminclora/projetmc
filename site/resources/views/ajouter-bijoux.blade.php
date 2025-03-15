<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un bijou</title>
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
        <h2 class="text-center mb-4">Ajouter un bijou</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('bijoux.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nom -->
            <div class="mb-3">
                <label for="nom" class="form-label fw-bold">Nom du bijou</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <!-- Prix -->
            <div class="mb-3">
                <label for="prix" class="form-label fw-bold">Prix (DZD)</label>
                <input type="number" name="prix" class="form-control" step="0.01" required>
            </div>

            <!-- Type -->
            <div class="mb-3">
                <label for="type" class="form-label fw-bold">Type de bijou</label>
                <select name="type" class="form-control" required>
                   <option value="sac">Sac</option>
                    <option value="parreur">Parreur</option>

                    
                </select>
            </div>

            <!-- Quantité -->
            <div class="mb-3">
                <label for="quantite" class="form-label fw-bold">Quantité en stock</label>
                <input type="number" name="quantite" class="form-control" min="1" required>
            </div>

            <!-- Image -->
            <div class="mb-3">
                <label for="image" class="form-label fw-bold">Image du bijou</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Ajouter</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
