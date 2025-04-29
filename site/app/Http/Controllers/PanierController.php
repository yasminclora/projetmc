<?php

namespace App\Http\Controllers;

use App\Models\{Panier, PanierItem, Robe, Bijoux};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 

class PanierController extends Controller
{
    public function index()
{
    if (Auth::check()) {
        // Utilisateur authentifié : Utilisation d'un panier lié à l'utilisateur
        $panier = Panier::firstOrCreate([
            'user_id' => Auth::id(),
            'statut' => 'actif'
        ], ['statut' => 'actif']);

        // Charger les items du panier
        $panier->load(['items.produit']);
    } else {
        // Utilisateur non authentifié : Utilisation de la session pour stocker les articles du panier
        $panier = session()->get('panier', []);
    }

    return view('panier.index', compact('panier'));
}



public function ajouter(Request $request)
{
    $request->validate([
        'produit_id' => 'required|integer',
        'type' => 'required|in:robe,bijou'
    ]);

    if (Auth::check()) {
        $panier = Panier::firstOrCreate([
            'user_id' => Auth::id(),
            'statut' => 'actif'
        ]);
    } else {
        // Utilisateur non authentifié, panier en session
        $panier = session()->get('panier', []);
    }

    $produit = $request->type === 'robe'
        ? Robe::findOrFail($request->produit_id)
        : Bijoux::findOrFail($request->produit_id);

    // Gérer le panier dans la session si utilisateur non authentifié
    if (!Auth::check()) {
        $panier[] = [
            'produit_id' => $produit->id,
            'produit_type' => get_class($produit),
            'quantite' => 1,
            'prix_unitaire' => $produit->prix,
        ];
        session()->put('panier', $panier);
    } else {
        // Ajouter un produit dans le panier de l'utilisateur
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
    }

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
        if (Auth::check()) {
            $item->delete();
            return back()->with('success', 'Produit retiré du panier');
        } else {
            // Retirer un produit du panier pour un utilisateur non authentifié
            $panier = session()->get('panier', []);
            $key = array_search($item->produit_id, array_column($panier, 'produit_id'));
            if ($key !== false) {
                unset($panier[$key]);
                session()->put('panier', array_values($panier));
            }
            return back()->with('success', 'Produit retiré du panier');
        }
    }
    
    public function commander(Request $request)
    {
        if (!Auth::check()) {
            // Si l'utilisateur n'est pas authentifié, rediriger vers la page de connexion
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour valider votre commande.');
        }
    
        // Code pour valider la commande de l'utilisateur authentifié
        $panier = Panier::where('user_id', Auth::id())->where('statut', 'actif')->first();
        if ($panier) {
            $panier->update(['statut' => 'commandé']);
            return redirect()->route('confirmation')
                ->with('success', 'Commande validée avec succès');
        }
    
        return redirect()->route('panier')
            ->with('error', 'Le panier est vide ou il y a un problème avec votre commande.');
    }
    
}    