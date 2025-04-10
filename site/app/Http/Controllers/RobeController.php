<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Robe;
use App\Models\Bijoux;
use App\Models\Commentaire;
use App\Models\User;
use Illuminate\Http\Request;

class RobeController extends Controller
{
    public function index()
    {
        $robes = [
            'simple' => Robe::where('category', 'simple')->get(),
            'fete' => Robe::where('category', 'fete')->get(),
            'elegante' => Robe::where('category', 'mariee')->get()
        ];
    
        return view('robes', compact('robes'));
    }
    

 


    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'category' => 'required|in:simple,fete,mariee',
            'quantite' => 'required|integer|min:1',
        ]);
    
        $imagePath = $request->file('image')->store('images', 'public');
    
        Robe::create([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'image' => $imagePath,
            'description' => $request->description,
            'category' => $request->category,
            'quantite' => $request->quantite,
            'user_id' => auth()->id(),
        ]);
    
        return back()->with('success', 'Robe ajoutée avec succès');
    }
    



     


  public function update(Request $request, $id)
{
    $robe = Robe::findOrFail($id);
    $robe->update($request->all());
    
    return redirect()->route('admin')->with('success', 'Robe mise à jour avec succès.');
}


    public function destroy($id)
    {
        Robe::destroy($id);
        return redirect()->route('robes.index')->with('success', 'Robe supprimée avec succès.');
    }











    public function adminIndex()
    {
        $robes = Robe::all();
        return view('admin', compact('robes'));
    }








    public function adminUpdate(Request $request, $id)
{
    $robe = Robe::findOrFail($id);

    // Validation des données
    $request->validate([
        'nom' => 'required|string|max:255',
        'prix' => 'required|numeric',
        'description' => 'nullable|string',
        'category' => 'required|in:simple,fete,mariee',
        'quantite' => 'required|integer|min:1',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Mise à jour des données
    $robe->nom = $request->nom;
    $robe->prix = $request->prix;
    $robe->description = $request->description;
    $robe->category = $request->category;
    $robe->quantite = $request->quantite;

    // Gestion de l'image (si une nouvelle est fournie)
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $robe->image = $imagePath;
    }

    $robe->save();

    return redirect()->route('robes.index')->with('success', 'Robe mise à jour avec succès.');
}

public function adminDestroy($id)
{
    $robe = Robe::findOrFail($id);
    $robe->delete();

    return redirect()->route('robes.index')->with('success', 'Robe supprimée avec succès.');
}

    



// Méthode pour afficher les détails de la robe avec les commentaires
public function show($id)
{
    $robe = Robe::findOrFail($id);
    $commentaires = $robe->commentaires()->with('user')->get();
    return view('robes.detail', compact('robe', 'commentaires'));
}

// Ajouter un commentaire
public function addComment(Request $request, $id)
{
    $request->validate([
        'commentaire' => 'required|string|max:1000',
    ]);

    $robe = Robe::findOrFail($id);
    $robe->commentaires()->create([
        'user_id' => auth()->id(),
        'commentaire' => $request->commentaire,
    ]);

    return redirect()->route('robes.detail', $id)->with('success', 'Commentaire ajouté !');
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
    return redirect()->route('robes.detail', ['id' => $robe->id])
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
