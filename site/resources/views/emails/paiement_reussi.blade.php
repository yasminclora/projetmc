<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Paiement confirmé</title>
</head>
<body>
    <h2>Paiement confirmé !</h2>
    <p>Bonjour {{ $user->name }}, merci pour votre paiement.</p>

    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Article</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->article_nom }}</td>
                    <td>{{ number_format($item->prix_unitaire, 2) }} DZD</td>
                    <td>{{ $item->quantite }}</td>
                    <td>{{ number_format($item->quantite * $item->prix_unitaire, 2) }} DZD</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total payé :</strong> {{ number_format($items->sum(fn($i) => $i->quantite * $i->prix_unitaire), 2) }} DZD</p>

    <p>Merci pour votre confiance.<br>L’équipe Sykabyle</p>
</body>
</html>
