<?php

namespace App\Http\Controllers;

use App\Models\Bijoux;
use Illuminate\Http\Request;
use App\Models\Commentaire;
use App\Models\User;

class BijouxController extends Controller
{
    public function index()
    {
        $bijoux = [
           
            'sac' => Bijoux::where('type', 'sac')->get(),
            'parreur' => Bijoux::where('type', 'parreur')->get(),

        ];

        return view('bijoux', compact('bijoux'));
    
        
    }

    

    public function create()
    {
        return view('ajouter-bijoux'); // Assure-toi que la vue existe bien
    }
    




    public function store(Request $request) {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantite' => 'required|integer|min:1',
            'type' => 'required|string',
        ]);
    
        $imagePath = $request->file('image')->store('images', 'public');
    
        Bijoux::create([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'image' => $imagePath,
            'quantite' => $request->quantite,
            'type' => $request->type,


            'user_id' => auth()->id(),
        ]);
    
        return back()->with('success', 'Bijou ajouté avec succès');
    }



   

    public function update(Request $request, $id)
    {
        $bijoux = Bijoux::findOrFail($id);
        $bijoux->update($request->all());
        return $bijoux;
    }

    public function destroy($id)
    {
        return Bijoux::destroy($id);
    }



// Méthode pour afficher les détails de la robe avec les commentaires
public function show($id)
{
    $bijoux = Bijoux::findOrFail($id);
    $commentaires = $bijoux->commentaires()->with('user')->get();
    return view('bijou.detail', compact('bijoux', 'commentaires'));
}

// Ajouter un commentaire
public function addComment(Request $request, $id)
{
    $request->validate([
        'commentaire' => 'required|string|max:1000',
    ]);

    $bijoux = Bijoux::findOrFail($id);
    $bijoux->commentaires()->create([
        'user_id' => auth()->id(),
        'commentaire' => $request->commentaire,
    ]);

    return redirect()->route('bijou.detail', $id)->with('success', 'Commentaire ajouté !');
}

// Modifier un commentaire
public function editComment($id)
{
    $commentaire = Commentaire::findOrFail($id);
    
    // Assurez-vous que l'utilisateur est le propriétaire du commentaire
    if (auth()->user()->id != $commentaire->user_id) {
        return redirect()->back()->with('error', 'Vous n\'avez pas la permission de modifier ce commentaire.');
    }

    return view('commentaires.edit', compact('commentaire'));
}

// Mettre à jour un commentaire
public function updateComment(Request $request, $id)
{
    $request->validate([
        'commentaire' => 'required|string|max:1000',
    ]);

    $commentaire = Commentaire::findOrFail($id);

    // Assurez-vous que l'utilisateur est le propriétaire du commentaire
    if (auth()->user()->id != $commentaire->user_id) {
        return redirect()->back()->with('error', 'Vous n\'avez pas la permission de modifier ce commentaire.');
    }

    $commentaire->update([
        'commentaire' => $request->commentaire,
    ]);

    $robe = $commentaire->commentable;
    return redirect()->route('bijou.detail', ['id' => $robe->id])
                     ->with('success', 'Commentaire modifié avec succès.');
}

// Supprimer un commentaire
public function destroyComment($id)
{
    $commentaire = Commentaire::findOrFail($id);

    // Assurez-vous que l'utilisateur est le propriétaire du commentaire
    if (auth()->user()->id != $commentaire->user_id) {
        return redirect()->back()->with('error', 'Vous n\'avez pas la permission de supprimer ce commentaire.');
    }

    $commentaire->delete();

    return redirect()->back()->with('success', 'Commentaire supprimé !');
}
}