<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Robe;
use App\Models\Bijoux;
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
    



     public function show($id)
    {
        $robe = Robe::findOrFail($id);
        return view('robe-detail', compact('robe'));
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

    

}
