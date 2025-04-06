<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    
    // Afficher le profil de l'utilisateur
    public function show()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }




    // Afficher le formulaire de modification du profil
    public function edit()
    {
        $user = Auth::user();
        return view('edit', compact('user'));
    }

    // Mettre à jour le profil de l'utilisateur
    public function update(Request $request)
    {
        $user = Auth::user();

        // Valider les données du formulaire
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Mettre à jour les informations de l'utilisateur
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profil mis à jour avec succès !');
    }


 

}