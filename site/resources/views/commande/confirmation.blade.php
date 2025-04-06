<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Commande</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-green-600 mb-4">Commande Confirmée !</h1>
            
            <div class="mb-6">
                <p class="mb-2">Votre commande <strong class="text-blue-600">#{{ $reference ?? 'N/A' }}</strong> a bien été enregistrée.</p>
                <p>Un email de confirmation vous a été envoyé.</p>
            </div>

            <div class="border-t pt-4">
                <h2 class="text-lg font-semibold mb-2">Prochaines Étapes :</h2>
                <ul class="list-disc pl-5 space-y-1">
                    <li>Vous recevrez un email de confirmation</li>
                    <li>Notre équipe prépare votre commande</li>
                    <li>Suivi de livraison disponible dans votre espace client</li>
                </ul>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <a href="{{ route('commandes.show', $reference) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Voir ma commande
                </a>
                <a href="/" 
                   class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</body>
</html>