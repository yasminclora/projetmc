<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Signalement Reçu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fafafa;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
        }
        h2 {
            color: #c0392b;
        }
        p {
            margin-bottom: 10px;
        }
        .article-info {
            background-color: #f5f5f5;
            padding: 10px;
            border-left: 4px solid #3498db;
            margin-top: 15px;
            border-radius: 5px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #3498db;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nouveau signalement reçu</h2>

        <!-- Vérification si l'utilisateur est authentifié -->
        <p><strong>Signalé par :</strong> {{ $signalement->user ? $signalement->user->name : 'Visiteur non connecté' }}</p>

        <p><strong>Motif :</strong> {{ $signalement->motif }}</p>
        <p><strong>Date :</strong> {{ $signalement->created_at->format('d/m/Y H:i') }}</p>

        @if($article)
        <div class="article-info">
            <h3>Détails de l'article signalé :</h3>
            <p><strong>Nom :</strong> {{ $article->nom ?? $article->titre ?? 'Sans nom' }}</p>
            <p><strong>Description :</strong> {{ $article->description ?? 'Aucune description' }}</p>
            @if(isset($article->prix))
                <p><strong>Prix :</strong> {{ $article->prix }} DA</p>
            @endif
        </div>
        @endif

    </div>
</body>
</html>
