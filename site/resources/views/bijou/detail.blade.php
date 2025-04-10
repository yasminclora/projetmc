<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $bijoux->nom }} - Détails</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Lien vers la bibliothèque emoji-button -->
    <script src="https://cdn.jsdelivr.net/npm/emoji-button@4.5.0/dist/index.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/emoji-button@4.5.0/dist/index.css">

    <style>
        body {
            font-family: 'Georgia', 'Times New Roman', Times, serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: 20px;
        }

        .robe-detail-card {
            flex: 0 0 30%;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .robe-detail-card:hover {
            transform: scale(1.05);
        }

        .robe-detail-card img {
            width: 80%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .robe-detail-card h3 {
            font-size: 1.8em;
            color: saddlebrown;
            margin-bottom: 15px;
        }

        .robe-detail-card p {
            font-size: 1.1em;
            color: #333;
            margin-bottom: 15px;
        }

        .price {
            font-size: 1.3em;
            color: #333;
            margin-bottom: 20px;
        }

        .btn-ajouter-panier, .back-button {
            background-color: #6d4c41;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }

        .btn-ajouter-panier:hover, .back-button:hover {
            background-color: #3e2723;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        #commentaires {
            flex: 0 0 68%;
            margin-left: 20px;
        }

        .commentaire {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .commentaire p {
            font-size: 0.9em;
            color: #333;
            margin-bottom: 10px;
        }

        .commentaire .meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9em;
            color: #888;
            margin-bottom: 10px;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .commentaire .actions button {
            color: saddlebrown;
            background: none;
            border: none;
            cursor: pointer;
        }

        .commentaire .actions button:hover {
            text-decoration: underline;
        }

        .hidden-comment {
            display: none;
        }
    </style>
</head>
<body>

<a href="javascript:history.back()" class="back-button">Retour</a>

<section id="robe-detail" class="content">
    <div class="robe-detail-card">
        <img src="{{ asset('storage/' . $bijoux->image) }}" alt="Image de la bijou">
        <h3>{{ $bijoux->nom }}</h3>
        <p class="price">{{ $bijoux->prix }} DA</p>
        <button class="btn-ajouter-panier" onclick="ajouterAuPanier({{ $bijoux->id }}, '{{ $bijoux->nom }}', '{{ $bijoux->prix }}', '{{ asset('storage/' . $bijoux->image) }}', {{ $bijoux->user_id }})">
            Ajouter au panier
        </button>
    </div>

    <div id="commentaires">
        <h3>Commentaires</h3>

        <div id="liste-commentaires">
            @foreach($commentaires as $index => $commentaire)
                <div class="commentaire {{ $index >= 4 ? 'hidden-comment' : '' }}" id="commentaire-{{ $commentaire->id }}">
                    <div class="meta">
                        <strong>{{ $commentaire->user->name }}</strong>
                        <span>{{ $commentaire->created_at->format('d/m/Y à H:i') }}</span>
                    </div>

                    <p class="texte-original">{{ $commentaire->commentaire }}</p>
                    <div class="translated" id="translation-{{ $commentaire->id }}"></div>

                    <div class="actions">
                        <button onclick="traduireCommentaire('{{ $commentaire->commentaire }}', {{ $commentaire->id }})">Traduire</button>
                        @if(auth()->user() && auth()->user()->id == $commentaire->user_id)
                            <button onclick="toggleEditForm({{ $commentaire->id }})">Modifier</button>
                            <form id="edit-form-{{ $commentaire->id }}" action="{{ route('commentaires.update', $commentaire->id) }}" method="POST" style="display:none;">
                                @csrf @method('PUT')
                                <textarea name="commentaire">{{ $commentaire->commentaire }}</textarea>
                                <button type="submit">Sauvegarder</button>
                                <button type="button" onclick="toggleEditForm({{ $commentaire->id }})">Annuler</button>
                            </form>
                            <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer ce commentaire ?')">Supprimer</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($commentaires->count() > 4)
            <div style="text-align: center; margin-top: 10px;">
                <button id="toggle-commentaires" onclick="toggleCommentaires()" class="btn-ajouter-panier">
                    Voir plus ↓
                </button>
            </div>
        @endif

        <div id="commentaire-form" style="margin-top: 20px;">
            @auth
                <form action="{{ route('commentaires.store', $bijoux->id) }}" method="POST">
                    @csrf
                    <textarea name="commentaire" id="commentaire" placeholder="Écrivez un commentaire..." required></textarea>
                   
                    <button type="submit" class="btn-ajouter-panier">Ajouter un commentaire</button>
                </form>
            @else
                <p>Vous devez être connecté pour commenter.</p>
            @endauth
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    @auth
        const currentUserId = {{ auth()->user()->id }};
    @else
        const currentUserId = null;
    @endauth

    function toggleEditForm(commentaireId) {
        const form = document.getElementById('edit-form-' + commentaireId);
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function toggleCommentaires() {
        const hidden = document.querySelectorAll('.hidden-comment');
        const btn = document.getElementById('toggle-commentaires');

        hidden.forEach(comment => {
            comment.style.display = (comment.style.display === 'none' || comment.style.display === '') ? 'block' : 'none';
        });

        // Changer le texte du bouton
        if (btn.innerText.includes("plus")) {
            btn.innerText = "Voir moins ↑";
        } else {
            btn.innerText = "Voir plus ↓";
        }
    }

    function traduireCommentaire(commentaire, id) {
        // Fonction pour diviser le texte en morceaux de taille maximale autorisée (ex : 500 caractères)
        function chunkText(text, chunkSize) {
            const chunks = [];
            for (let i = 0; i < text.length; i += chunkSize) {
                chunks.push(text.slice(i, i + chunkSize));
            }
            return chunks;
        }

        const isFrench = /[a-zA-Z]/.test(commentaire) === false;

        const fromLang = isFrench ? 'fr' : 'en';
        const toLang = isFrench ? 'en' : 'fr';

        const chunks = chunkText(commentaire, 500);

        async function traduireChunks(chunks) {
            let traductionComplete = '';
            for (const chunk of chunks) {
                const res = await fetch("https://api.mymemory.translated.net/get?q=" + encodeURIComponent(chunk) + "&langpair=" + fromLang + "|" + toLang)
                    .then(response => response.json())
                    .catch(err => {
                        console.error("Erreur de traduction:", err);
                        return { responseData: { translatedText: "Erreur de traduction." } };
                    });

                traductionComplete += res.responseData.translatedText;
            }

            document.getElementById("translation-" + id).innerText = traductionComplete;
        }

        traduireChunks(chunks);
    }


    function ajouterAuPanier(id, nom, prix, image, vendeurId) {


// Vérifier si l'utilisateur est authentifié
if (currentUserId === null) {
Swal.fire({
 icon: 'warning',
 title: 'Connexion requise',
 text: 'Vous devez être connecté pour ajouter des articles au panier.',
 showConfirmButton: true,
});
return; // Empêcher l'ajout au panier si l'utilisateur n'est pas connecté
}
// Vérifier si l'acheteur est le vendeur
if (currentUserId === vendeurId) {
 Swal.fire({
     icon: 'error',
     title: 'Erreur',
     text: 'Vous ne pouvez pas acheter votre propre accessoire.',
     timer: 2000,
     showConfirmButton: false,
 });
 return; // Empêcher l'ajout au panier si l'utilisateur est le vendeur
}

// Si ce n'est pas l'article du vendeur, on continue normalement
let panier = JSON.parse(localStorage.getItem('panier')) || [];
let item = panier.find(item => item.id === id);

if (item) {
item.quantite += 1;
} else {
panier.push({ id, nom, prix, image, quantite: 1 });
}

localStorage.setItem('panier', JSON.stringify(panier));
alert(`${nom} ajouté au panier !`);
}

   
</script>
</body>
</html>
