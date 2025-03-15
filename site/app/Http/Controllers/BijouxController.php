<?php

namespace App\Http\Controllers;

use App\Models\Bijoux;
use Illuminate\Http\Request;

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
        ]);
    
        return back()->with('success', 'Bijou ajouté avec succès');
    }



    public function show($id)
    {
        return Bijoux::findOrFail($id);
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
}