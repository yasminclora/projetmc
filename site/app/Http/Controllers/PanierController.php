<?php

namespace App\Http\Controllers;

use App\Models\{Panier, PanierItem, Robe, Bijoux};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PanierController extends Controller
{
    public function index()
    {
        $panier = Panier::firstOrCreate([
            'user_id' => Auth::id(),
            'statut' => 'actif'
        ], ['statut' => 'actif']);

        $panier->load(['items.produit']);

        return view('panier.index', compact('panier'));
    }

    public function ajouter(Request $request)
    {
        $request->validate([
            'produit_id' => 'required|integer',
            'type' => 'required|in:robe,bijou'
        ]);

        $panier = Panier::firstOrCreate([
            'user_id' => Auth::id(),
            'statut' => 'actif'
        ]);

        $produit = $request->type === 'robe'
            ? Robe::findOrFail($request->produit_id)
            : Bijoux::findOrFail($request->produit_id);

        PanierItem::updateOrCreate(
            [
                'panier_id' => $panier->id,
                'produit_type' => get_class($produit),
                'produit_id' => $produit->id
            ],
            [
                'quantite' => \DB::raw('quantite + 1'),
                'prix_unitaire' => $produit->prix
            ]
        );

        return back()->with('success', 'Produit ajouté au panier');
    }

    public function update(Request $request, PanierItem $item)
    {
        $request->validate([
            'action' => 'required|in:increase,decrease'
        ]);

        if ($request->action === 'increase') {
            $item->increment('quantite');
        } elseif ($item->quantite > 1) {
            $item->decrement('quantite');
        }

        return back();
    }

    public function remove(PanierItem $item)
    {
        $item->delete();
        return back()->with('success', 'Produit retiré du panier');
    }

    public function commander(Panier $panier)
    {
        $panier->update(['statut' => 'commandé']);
        
        // Ici vous pourriez ajouter :
        // - Création d'une commande
        // - Envoi d'email de confirmation
        // - Paiement, etc.

        return redirect()->route('confirmation')
            ->with('success', 'Commande validée avec succès');
    }
}