<?php

namespace App\Http\Controllers;

use App\Models\Robe;
use App\Models\Bijoux;
use App\Models\Commande;
use App\Models\CommandeItem;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Signalement;


class AdminController extends Controller
{



    public function dashboard()
{
    $topClients = User::where('role', 'user')
        ->withCount(['commandes as commandes_count' => function($query) {
            $query->where('statut', 'payee');
        }])
        ->withSum(['commandes as total_depense' => function($query) {
            $query->where('statut', 'payee');
        }], 'total')
        ->withMax(['commandes as derniere_commande' => function($query) {
            $query->where('statut', 'payee');
        }], 'created_at')
        ->having('commandes_count', '>', 0)
        ->orderByDesc('total_depense')
        ->limit(5)
        ->get(['id', 'name', 'prenom', 'email', 'image']);

        // Chargement optimisé des autres données
        return view('admin.dashboard', [
            'robes' => Robe::with('user:id,name')->select('id', 'nom', 'prix', 'image', 'user_id')->get(),
            'bijoux' => Bijou::with('user:id,name')->select('id', 'nom', 'prix', 'image', 'user_id')->get(),
            'commandes' => Commande::with('user:id,name,email')
                ->select('id', 'user_id', 'total', 'statut', 'created_at')
                ->latest()
                ->get(),
            'users' => User::select('id', 'name', 'email', 'role', 'created_at')->get(),
            'topClients' => $topClients
        ]);
    }
    
    public function show()
    {
        $user = Auth::user()->only('id', 'name', 'email', 'image', 'created_at');
        return view('admin.profile', compact('user'));
    }
    
    /**
     * Affiche le tableau de bord administrateur.
     */
   
     public function index()
     {
         // Récupérer les robes
         $robes = Robe::with('user')->get();
         
         // Récupérer les bijoux
         $bijoux = Bijoux::with('user')->get();
         
         // Récupérer les commandes
         $commandes = Commande::all();
         
         // Meilleurs clients (toutes commandes)
         $topClients = User::where('role', 'user')
             ->withCount(['commandes'])
             ->withSum(['commandes as commandes_total' => function($query) {
                 $query->where('statut', 'payee');
             }], 'total')
             ->orderByDesc('commandes_total')
             ->take(5)
             ->get();
     
         // Revenus par utilisateur (commandes payées seulement)
         $revenues = User::with(['commandes' => function($query) {
             $query->where('statut', 'payee');
         }])
         ->get()
         ->map(function($user) {
             return [
                 'user' => $user,
                 'total_revenue' => $user->commandes->sum('total') ?? 0, // Valeur par défaut 0
                 'orders_count' => $user->commandes->count()
             ];
         })
         ->sortByDesc('total_revenue')
         ->values();
     
         // Récupérer tous les signalements avec les relations user et signalable
         $signalements = Signalement::with('user')->get();
         
         // Récupérer tous les utilisateurs
         $users = User::all();
     
         // Passer les données à la vue
         return view('ad', compact(
             'robes', 
             'bijoux', 
             'commandes', 
             'users', 
             'topClients',
             'revenues',
             'signalements'  // Ajouter la variable signalements
         ));
     }
     
     
    /**
     * Stocke une nouvelle robe.
     */
    public function storeRobe(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|in:simple,fete,mariee',
            'quantite' => 'required|integer|min:1',
        ]);

        // Stockage de l'image
        $imagePath = $request->file('image')->store('images', 'public');

        // Création de la robe
        Robe::create([
            'nom' => $request->nom,
            'prix' => $request->prix,
            'description' => $request->description,
            'image' => $imagePath,
            'category' => $request->category,
            'quantite' => $request->quantite,
        ]);

        return redirect()->route('admin')->with('success', 'Robe ajoutée avec succès.');
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

        return redirect()->route('admin')->with('success', 'Robe mise à jour avec succès.');
    }

    /**
     * Supprime une robe.
     */
    public function destroyRobe($id)
    {
        Robe::destroy($id);
        return redirect()->route('admin')->with('success', 'Robe supprimée avec succès.');
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

        return redirect()->route('admin')->with('success', 'Bijou ajouté avec succès.');
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

        return redirect()->route('admin')->with('success', 'Bijou mis à jour avec succès.');
    }

    /**
     * Supprime un bijou.
     */
    public function destroyBijoux($id)
    {
        Bijoux::destroy($id);
        return redirect()->route('admin')->with('success', 'Bijou supprimé avec succès.');
    }



    public function updateCommande(Request $request, Commande $commande)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,validee,refusee'
        ]);
        
        $commande->update(['statut' => $request->statut]);
        
        return back()->with('success', 'Statut mis à jour');
    }









    // Dans AdminController
public function updateUser(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,'.$user->id,
        'role' => 'nullable|in:user,admin'
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role ?? 'user'
    ]);

    return redirect()->route('admin')->with('success', 'Utilisateur mis à jour avec succès.');
}







public function destroyUser(User $user)
{
    // Empêcher la suppression de l'admin principal si nécessaire
    if ($user->id === 1) {
        return redirect()->route('admin')->with('error', 'Impossible de supprimer cet utilisateur.');
    }

    try {
        // Commencer une transaction
        DB::beginTransaction();

        // 1. Supprimer les éléments du panier de l'utilisateur
        $user->paniers()->delete();

        // 2. Supprimer les commandes associées (si nécessaire)
        $user->commandes()->delete();

        // 3. Supprimer d'autres relations si elles existent
        // $user->autresRelations()->delete();

        // 4. Finalement supprimer l'utilisateur
        $user->delete();

        // Valider la transaction
        DB::commit();

        return redirect()->route('admin')->with('success', 'Utilisateur supprimé avec succès.');
    } catch (\Exception $e) {
        // Annuler en cas d'erreur
        DB::rollBack();
        return redirect()->route('admin')->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
    }
}


public function payerParArticle()
{
    // Récupérer tous les articles commandés (robes et bijoux) dont la commande est payée et non encore versée
    $items = CommandeItem::whereHas('commande', function ($q) {
        $q->where('statut', 'payee');
    })->where('paiement', '!=', 'verse') // éviter de les repayer
      ->get();

    $paiements = [];

    foreach ($items as $item) {
        // article = robe ou bijou (relation morphTo)
        $article = $item->article;

        if (!$article || !$article->user) {
            continue; // sécurité
        }

        $vendeur = $article->user;

        // Initialiser si nécessaire
        if (!isset($paiements[$vendeur->id])) {
            $paiements[$vendeur->id] = [
                'user' => $vendeur,
                'montant' => 0,
                'items' => []
            ];
        }

        // Ajouter le montant
        $paiements[$vendeur->id]['montant'] += $item->article_prix;
        $paiements[$vendeur->id]['items'][] = $item;
    }

    // Appliquer les paiements
    foreach ($paiements as $data) {
        $vendeur = $data['user'];
        $montant = $data['montant'];

        $vendeur->solde += $montant;
        $vendeur->save();

        // Marquer les items comme versés
        foreach ($data['items'] as $item) {
            $item->paiement = 'verse';
            $item->save();
        }
    }

    return back()->with('success', 'Chaque utilisateur a été payé selon ses articles vendus.');
}



}