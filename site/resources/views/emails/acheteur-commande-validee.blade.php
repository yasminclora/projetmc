<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande validée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .total-price {
            font-weight: bold;
            font-size: 1.2em;
            margin-top: 20px;
        }

        .thank-you-message {
            margin-top: 30px;
            font-style: italic;
        }

        .header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <p class="header">Bonjour {{ $commande->user->name }},</p>
    <p>Nous avons le plaisir de vous informer que votre commande <strong>{{ $commande->reference }}</strong> a été validée.</p>
    <p>Vous pouvez maintenant vous attendre à la livraison de vos articles.</p>

    <!-- Tableau des informations de la commande -->
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($commande->items as $item)
                <tr>
                    <td>{{ $item->article_nom }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ $item->prix_unitaire }} DA</td>
                    <td>{{ $item->prix_unitaire * $item->quantite }} DA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Affichage du prix total -->
    <p class="total-price">Prix total : {{ $commande->total }} DA</p>

    <!-- Message de remerciement -->
    <p class="thank-you-message">Merci de votre achat !</p>

</body>
</html>
