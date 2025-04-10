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

    $items = CommandeItem::where('commande_id', $commandeId)
                ->whereHas('article', function ($query) {
                    $query->where('user_id', auth()->id());
                })->get();

    foreach ($items as $item) {
        $article = $item->article;
        $ancienStatut = $item->statut;
        $nouveauStatut = $request->statut;

        // Transition vers "validee" : diminuer stock
        if ($ancienStatut !== 'validee' && $nouveauStatut === 'validee') {
            if ($article->quantite >= $item->quantite) {
                $article->quantite -= $item->quantite;
                $article->save();
            } else {
                return back()->with('error', "Stock insuffisant pour l'article {$item->article_nom}.");
            }
        }

        // Transition depuis "validee" vers autre chose : restaurer stock
        if ($ancienStatut === 'validee' && $nouveauStatut !== 'validee') {
            $article->quantite += $item->quantite;
            $article->save();
        }

        // Mettre à jour le statut de l'article
        $item->statut = $nouveauStatut;
        $item->save();
        
    }

    // Mise à jour du statut global de la commande
    $commande = $items->first()->commande;

    $allValidated = $commande->items->every(function ($item) {
        return $item->statut === 'validee';
    });

    $commande->statut = $allValidated ? 'validee' : 'en_attente';
    $commande->save();

// Vérifie si la commande est validée
if ($commande->statut === 'validee') {

    // Notification à l'utilisateur qui a passé la commande
// Envoi de la notification de validation
$commande->user->notify(new CommandeValideeNotification($commande));

}
    return back()->with('success', 'Statut mis à jour et stock ajusté si nécessaire.');
}

    





}