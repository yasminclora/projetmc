<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vos Commandes</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <div class="container">
        <h2>Vos Commandes</h2>

        @if($commandes->isEmpty())
            <p>Aucune commande passée.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Catégorie</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($commandes as $commande)
                    <tr>
                        <td>{{ $commande->id }}</td>
                        <td>{{ ucfirst($commande->categorie) }}</td>
                        <td>{{ number_format($commande->total, 2) }} DA</td>
                        <td>{{ ucfirst($commande->statut) }}</td>
                        <td>{{ $commande->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('commandes.show', $commande->id) }}" class="btn btn-info">Voir</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</body>
</html>
