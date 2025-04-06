<?php

namespace App\Http\Controllers;

use App\Models\{Commande, CommandeItem, Panier, Robe, Bijoux};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $reference = 'CMD-'.now()->format('YmdHis').Str::random(4);
        
        $validatedItems = [];
        $total = 0;
        
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

    return back()->with('success', 'Statut mis à jour et stock ajusté si nécessaire.');
}

    


}