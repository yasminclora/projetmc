<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanierController extends Controller
{
   // Affiche la page du panier
   public function index()
   {
       return view('panier');
   }




    // Ajouter un produit au panier (si on veut gérer avec la session Laravel)
    public function ajouter(Request $request)
    {
        $produit = [
            'id' => $request->id,
            'nom' => $request->nom,
            'prix' => $request->prix,
            'image' => $request->image,
            'quantite' => 1
        ];

        $panier = session()->get('panier', []);
        
        if (isset($panier[$produit['id']])) {
            $panier[$produit['id']]['quantite']++;
        } else {
            $panier[$produit['id']] = $produit;
        }

        session()->put('panier', $panier);
        return response()->json(['message' => 'Produit ajouté au panier']);
    }

    // Supprimer un produit du panier
    public function retirer($id)
    {
        $panier = session()->get('panier', []);

        if (isset($panier[$id])) {
            unset($panier[$id]);
            session()->put('panier', $panier);
        }

        return response()->json(['message' => 'Produit retiré du panier']);
    }

    // Vider complètement le panier
    public function vider()
    {
        session()->forget('panier');
        return response()->json(['message' => 'Panier vidé']);
    }


}
