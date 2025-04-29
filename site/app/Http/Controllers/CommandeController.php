<?php

namespace App\Http\Controllers;

use App\Models\{Commande, CommandeItem, Panier, Robe, Bijoux};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Mail;

use App\Notifications\NotificationProprietaireCommande;
use App\Notifications\CommandeValideeNotification;

class CommandeController extends Controller
{
    



    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|integer',
            'items.*.quantite' => 'required|integer|min:1',
            'items.*.prix' => 'required|numeric|min:0',
            'items.*.nom' => 'sometimes|string', // Rendre optionnel
            'items.*.image' => 'sometimes|string' // Rendre optionnel
        ]);
    
        \DB::beginTransaction();
        try {
            $user = auth()->user();
            $reference = 'CMD-' . now()->format('YmdHis') . Str::random(4);
            
            $validatedItems = [];
            $total = 0;
    
            // Collect items and group them by owner (user)
            $itemsGroupedByOwner = [];
    
            foreach ($request->items as $item) {
                // Détermination du type d'article
                $type = $this->determineArticleType($item['id'], $item['nom'] ?? '');
                
                if ($type === 'robe') {
                    $article = Robe::where('id', $item['id'])
                        ->where('quantite', '>=', $item['quantite'])
                        ->lockForUpdate()
                        ->first();
                } else {
                    $article = Bijoux::where('id', $item['id'])
                        ->where('quantite', '>=', $item['quantite'])
                        ->lockForUpdate()
                        ->first();
                }
    
                if (!$article) {
                    throw new \Exception("L'article #{$item['id']} n'est plus disponible.");
                }
    
                // Add to items grouped by owner
                if (!isset($itemsGroupedByOwner[$article->user_id])) {
                    $itemsGroupedByOwner[$article->user_id] = [
                        'user' => $article->user,
                        'items' => [],
                        'total' => 0
                    ];
                }
    
                $itemsGroupedByOwner[$article->user_id]['items'][] = [
                    'article' => $article,
                    'data' => $item,
                    'type' => $type
                ];
    
                $itemsGroupedByOwner[$article->user_id]['total'] += $article->prix * $item['quantite'];
                $validatedItems[] = [
                    'article' => $article,
                    'data' => $item,
                    'type' => $type
                ];
    
                $total += $article->prix * $item['quantite'];
            }
    
            // Création de la commande
            $commande = Commande::create([
                'user_id' => $user->id,
                'reference' => $reference,
                'statut' => 'en_attente',
                'total' => $total
            ]);
    
            // Create CommandeItems
            foreach ($validatedItems as $item) {
                $article = $item['article'];
                $itemData = $item['data'];
                $type = $item['type'];
    
                CommandeItem::create([
                    'commande_id' => $commande->id,
                    'article_id' => $article->id,
                    'article_type' => $type === 'robe' ? Robe::class : Bijoux::class,
                    'article_nom' => $article->nom,
                    'article_image' => $article->image ?? null,
                    'article_prix' => $article->prix,
                    'quantite' => $itemData['quantite'],
                    'prix_unitaire' => $article->prix,
                    'statut' => 'en_attente', 
                ]);
            }
    
            // Send email notification for each owner
            foreach ($itemsGroupedByOwner as $ownerData) {
                $owner = $ownerData['user'];
                $commande = $commande; // Pass the whole commande object
                $owner->notify(new NotificationProprietaireCommande($commande));
            }
    
            \DB::commit();
    
            return response()->json([
                'success' => true,
                'reference' => $reference,
                'message' => 'Commande enregistrée'
            ]);
    
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    

protected function determineArticleType($id, $nom = '')
{
    if (Robe::where('id', $id)->exists()) return 'robe';
    if (Bijoux::where('id', $id)->exists()) return 'bijou';
    return stripos($nom, 'robe') !== false ? 'robe' : 'bijou';
}
    
    public function mesCommandes()
    {
        $commandes = Commande::where('user_id', auth()->id())
                            ->with(['items' => function($query) {
                                $query->orderBy('created_at', 'desc');
                            }])
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('commande.mes-commandes', compact('commandes'));
    }

    public function confirmation(Request $request)
    {
        return view('panier.confirmation', [
            'reference' => $request->reference
        ]);
    }



    public function commandesRecues()
    {
        $user = auth()->user();
        
        $commandes = Commande::whereHas('items', function($query) use ($user) {
            $query->where(function($q) use ($user) {
                $q->where('article_type', 'App\Models\Robe')
                  ->whereIn('article_id', Robe::where('user_id', $user->id)->pluck('id'));
            })->orWhere(function($q) use ($user) {
                $q->where('article_type', 'App\Models\Bijoux')
                  ->whereIn('article_id', Bijoux::where('user_id', $user->id)->pluck('id'));
            });
        })
        ->with(['items' => function($query) use ($user) {
            $query->where(function($q) use ($user) {
                $q->where('article_type', 'App\Models\Robe')
                  ->whereIn('article_id', Robe::where('user_id', $user->id)->pluck('id'));
            })->orWhere(function($q) use ($user) {
                $q->where('article_type', 'App\Models\Bijoux')
                  ->whereIn('article_id', Bijoux::where('user_id', $user->id)->pluck('id'));
            });
        }, 'user'])
        ->orderBy('created_at', 'desc')
        ->paginate(10);
    
        return view('commande.recues', compact('commandes'));
    }


  
public function updateStatutsParCommande(Request $request, $commandeId)
{
    $request->validate([
        'statut' => 'required|in:en_attente,validee,refusee',
    ]);

    \DB::beginTransaction();
    try {
        $user = auth()->user();
        $items = CommandeItem::where('commande_id', $commandeId)
                    ->whereHas('article', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    })
                    ->with(['article', 'commande'])
                    ->lockForUpdate()
                    ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'Aucun article trouvé pour cette commande.');
        }

        $commande = $items->first()->commande;
        $ruptureArticles = [];

        foreach ($items as $item) {
            $article = $item->article;
            $ancienStatut = $item->statut;
            $nouveauStatut = $request->statut;

            if ($nouveauStatut === 'validee') {
                if ($article->quantite < $item->quantite) {
                    // Stock insuffisant → refus automatique
                    $item->statut = 'refusee';
                    $item->save();

                    $ruptureArticles[] = "{$article->nom} (stock: {$article->quantite}, demandé: {$item->quantite})";
                    continue;
                }

                if ($ancienStatut !== 'validee') {
                    $article->quantite -= $item->quantite;
                    $article->save();
                }
            } elseif ($ancienStatut === 'validee' && $nouveauStatut !== 'validee') {
                // Restaurer le stock si on passe de "validee" à autre chose
                $article->quantite += $item->quantite;
                $article->save();
            }

            // Mise à jour du statut si pas rupture
            if ($article->quantite >= $item->quantite) {
                $item->statut = $nouveauStatut;
                $item->save();
            }
        }

        // Mise à jour du statut global de la commande
        $allItems = $commande->items;
        $allValidated = $allItems->every(fn($i) => $i->statut === 'validee');
        $allRefused = $allItems->every(fn($i) => $i->statut === 'refusee');

        $allAttente = $allItems->every(fn($i) => $i->statut === 'en_attente');
        if ($allValidated) {
            $commande->statut = 'validee';

            
            $commande->user->notify(new CommandeValideeNotification($commande));
        } elseif ($allRefused) {
            $commande->statut = 'refusee';
        }
        
    elseif ($allAttente) {
        $commande->statut = 'en_attente';
    }
    else {
            $commande->statut = 'validee';
        }


        // Nouvelle condition : si la commande est validée et tous les paiements sont faits
$allPayees = $allItems->every(fn($i) => $i->paiement === 'payee');
if ($commande->statut === 'validee' && $allPayees) {
    $commande->statut = 'payee';
}


        $commande->save();
        \DB::commit();

        if (!empty($ruptureArticles)) {
            $msg = "Rupture de stock pour les articles suivants :<br>" . implode('<br>', $ruptureArticles);
            return back()->with('error', $msg);
        }

        return back()->with('success', 'Statut mis à jour avec succès.');

    } catch (\Exception $e) {
        \DB::rollBack();
        return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }
}



    
} 