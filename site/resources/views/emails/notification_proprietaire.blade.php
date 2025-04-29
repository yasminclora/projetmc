{{-- resources/views/emails/notification_proprietaire.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Paiement reçu pour vos articles</title>
</head>
<body>
    <h2>Un client vient de payer vos articles !</h2>
    <p>Bonjour {{ $user->name }},</p>
    <p>Voici les détails de la commande :</p>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
                <th>Acheteur</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->article->nom }}</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ number_format($item->prix_unitaire, 2) }} DZD</td>
                    <td>{{ number_format($item->quantite * $item->prix_unitaire, 2) }} DZD</td>
                    <td>{{ $item->commande->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Vous pouvez voir la commande complète en cliquant sur le lien ci-dessous :</p>
    <p><a href="{{ url('/admin/commandes/'.$items->first()->commande_id) }}">Voir la commande</a></p>

    <p>Merci d'utiliser notre plateforme !</p>
</body>
</html>
