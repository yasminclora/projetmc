<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Commande #{{ $commande->id }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <div class="container">
        <h2>Détails de la Commande #{{ $commande->id }}</h2>

        <p><strong>Catégorie :</strong> {{ ucfirst($commande->categorie) }}</p>
        <p><strong>Total :</strong> {{ number_format($commande->total, 2) }} DA</p>
        <p><strong>Statut :</strong> {{ ucfirst($commande->statut) }}</p>
        <p><strong>Date :</strong> {{ $commande->created_at->format('d/m/Y') }}</p>

        <h3>Articles Commandés</h3>
        <ul>
            @foreach($commande->articles as $article)
                <li>
                    {{ $article['nom'] }} - {{ $article['quantite'] }} x {{ number_format($article['prix'], 2) }} DA
                    ({{ ucfirst($article['type']) }})
                </li>
            @endforeach
        </ul>

        <a href="{{ route('commandes.index') }}" class="btn btn-primary">Retour</a>
    </div>

</body>
</html>
