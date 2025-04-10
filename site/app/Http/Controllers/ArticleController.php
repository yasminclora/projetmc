<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robe;
use App\Models\Bijoux;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{


    public function __construct()
{
    $this->middleware('auth');
}



    public function index()
    {

        // Récupérer les robes et bijoux ajoutés par l'utilisateur connecté
        $robes = Robe::where('user_id', Auth::id())->get();
        $bijoux = Bijoux::where('user_id', Auth::id())->get();

        return view('articles', compact('robes', 'bijoux'));
    }





    /**
     * Met à jour une robe.
     */
    public function updateRobe(Request $request, $id)
    {
        $robe = Robe::findOrFail($id);
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'category' => 'required|in:simple,fete,mariee',
            'quantite' => 'required|integer|min:1',
        ]);

        // Mise à jour de l'image si une nouvelle est fournie
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $robe->image = $imagePath;
        }

        // Mise à jour des autres champs
        $robe->update($request->except('image'));

        return redirect()->route('user')->with('success', 'Robe mise à jour avec succès.');
    }

    /**
     * Supprime une robe.
     */
    public function destroyRobe($id)
    {
        Robe::destroy($id);
        return redirect()->route('user')->with('success', 'Robe supprimée avec succès.');
    }

    /**
     * Stocke un nouveau bijou.
     */
    public function storeBijoux(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'type' => 'required|in:sac,parreur',
            'quantite' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Stockage de l'image
        $imagePath = $request->file('image')->store('images', 'public');

        // Création du bijou
        Bijoux::create([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'type' => $request->type,
            'quantite' => $request->quantite,
            'image' => $imagePath,
        ]);

        return redirect()->route('user')->with('success', 'Bijou ajouté avec succès.');
    }





    /**
     * Met à jour un bijou.
     */
    public function updateBijoux(Request $request, $id)
    {
        $bijoux = Bijoux::findOrFail($id);
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'type' => 'required|in:sac,parreur',
            'quantite' => 'required|integer|min:1',
        ]);

        // Mise à jour de l'image si une nouvelle est fournie
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $bijoux->image = $imagePath;
        }

        // Mise à jour des autres champs
        $bijoux->update($request->except('image'));

        return redirect()->route('user')->with('success', 'Bijou mis à jour avec succès.');
    }

    /**
     * Supprime un bijou.
     */
    public function destroyBijoux($id)
    {
        Bijoux::destroy($id);
        return redirect()->route('user')->with('success', 'Bijou supprimé avec succès.');
    }
}
