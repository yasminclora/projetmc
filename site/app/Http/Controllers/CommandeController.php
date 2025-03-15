<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Commande;

class CommandeController extends Controller
{
    // Afficher toutes les commandes
    public function index() {
        $commandes = Commande::where('user_id', Auth::id())->get();
        return view('commandes', compact('commandes'));
    }

    // Afficher les détails d'une commande
    public function show($id) {
        $commande = Commande::findOrFail($id);
        return view('detailcommande', compact('commande'));
    }




    public function store(Request $request)
    {
        $data = $request->validate([
            'articles' => 'required|array',
            'total' => 'required|numeric'
        ]);

        $commande = Commande::create([
            'id_utilisateur' => 1, // Remplace par Auth::id() si l'authentification est activée
            'articles' => json_encode($data['articles']),
            'total' => $data['total'],
            'statut' => 'en attente'
        ]);

        return response()->json(['success' => true, 'commande_id' => $commande->id]);
    }
    
}
