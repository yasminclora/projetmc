<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;

use App\Models\User;

class CommentaireController extends Controller
{
    // Ajouter un commentaire
    public function store(Request $request)
    {
        $request->validate([
            'commentaire' => 'required|max:500',
        ]);

        $commentaire = new Commentaire();
        $commentaire->commentaire = $request->commentaire;
        $commentaire->user_id = auth()->id();
        $commentaire->robe_id = $request->robe_id; // Assurez-vous de récupérer robe_id depuis la requête
        $commentaire->save();

        return redirect()->back()->with('success', 'Commentaire ajouté avec succès!');
    }

    // Afficher le formulaire pour modifier un commentaire
    public function edit(Commentaire $commentaire)
    {
        // Vérifier si l'utilisateur est autorisé à modifier ce commentaire
        if ($commentaire->user_id !== auth()->id()) {
            return redirect()->route('robe.details', $commentaire->robe_id)
                             ->with('error', 'Vous ne pouvez modifier que vos propres commentaires.');
        }

        return view('commentaires.edit', compact('commentaire'));
    }

    // Mettre à jour un commentaire
    public function update(Request $request, Commentaire $commentaire)
    {
        $request->validate([
            'commentaire' => 'required|max:500',
        ]);

        // Vérifier si l'utilisateur est autorisé à modifier ce commentaire
        if ($commentaire->user_id !== auth()->id()) {
            return redirect()->route('robe.details', $commentaire->robe_id)
                             ->with('error', 'Vous ne pouvez modifier que vos propres commentaires.');
        }

        $commentaire->commentaire = $request->commentaire;
        $commentaire->save();

        return redirect()->route('robe.details', $commentaire->robe_id)
                         ->with('success', 'Commentaire modifié avec succès!');
    }

    // Supprimer un commentaire
    public function destroy(Commentaire $commentaire)
    {
        // Vérifier si l'utilisateur est autorisé à supprimer ce commentaire
        if ($commentaire->user_id !== auth()->id()) {
            return redirect()->route('robe.details', $commentaire->robe_id)
                             ->with('error', 'Vous ne pouvez supprimer que vos propres commentaires.');
        }

        $commentaire->delete();

        return redirect()->route('robe.details', $commentaire->robe_id)
                         ->with('success', 'Commentaire supprimé avec succès!');
    }
}
