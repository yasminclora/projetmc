<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;

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
    
        $request->validate([
            'nom' => 'nullable|string|max:255',
            'prenom' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
'telephone' => [
    'nullable',
    'string',
    'max:20',
    'regex:/^(05|06|07)[0-9]{8}$/'
],            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profiles', 'public');
            $user->image = $imagePath;
        }
    
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->adresse = $request->adresse;
        $user->telephone = $request->telephone;
        $user->save();
    
        return view('profile', compact('user'));    }
    
 

}