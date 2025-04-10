<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle commande reçue</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            color: #2c3e50;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .total {
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <h2 class="header">Nouvelle commande reçue</h2>
    
    <p>Bonjour {{ $user->name }},</p>
    
    <p>Vous avez reçu une nouvelle commande. Voici les détails :</p>
    
    <table>
        <thead>
            <tr>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($commande->items as $item)
                <tr>
                    <td>{{ $item->article_nom }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ number_format($item->prix_unitaire, 2) }} DA</td>
                    <td>{{ number_format($item->prix_unitaire * $item->quantite, 2) }} DA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">
        <p><strong>Référence commande:</strong> #{{ $commande->reference }}</p>
        <p><strong>Date:</strong> {{ $commande->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Total de la commande:</strong> {{ number_format($commande->total, 2) }} DA</p>
    </div>

    <div class="footer">
        <p>Merci de traiter cette commande dans les plus brefs délais.</p>
        <p>Cordialement,<br>L'équipe {{ config('app.name') }}</p>
    </div>
</body>
</html>
