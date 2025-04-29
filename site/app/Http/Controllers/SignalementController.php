<?php
namespace App\Http\Controllers;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robe;
use App\Models\Bijoux;
use App\Models\Commentaire;
use App\Models\Signalement;
use App\Models\User;
use App\Notifications\SignalementNotification;

class SignalementController extends Controller
{
    public function store(Request $request, $type, $id)
    {
        // Validation des données
        $request->validate([
            'motif' => 'nullable|string|max:255',
        ]);

        // Récupérer le modèle en fonction du type
        $modelClass = match ($type) {
            'bijou' => \App\Models\Bijoux::class,
            'robe' => \App\Models\Robe::class,
            'commentaire' => \App\Models\Commentaire::class,
            default => abort(404),
        };

        // Récupérer l'élément
        $item = $modelClass::findOrFail($id);

        // Créer le signalement
        $signalement = $item->signalements()->create([
            'user_id' => auth()->id(),
            'motif' => $request->motif,
        ]);

        // Notification au propriétaire de l'article (bijou ou robe)
        $owner = $item->user; // Assurez-vous que l'article a une relation 'user' pour accéder au propriétaire
        if ($owner) {
            // Envoi de la notification au propriétaire de l'article
            $owner->notify(new SignalementNotification($signalement));
        }

        // Notification à l'administrateur si nécessaire (vous pouvez supprimer cette partie si non requise)
        // $admin = User::where('admin', true)->first();
        // if ($admin) {
        //     $admin->notify(new SignalementNotification($signalement));
        // }

        // Retourner à la page précédente avec un message de succès
        return back()->with('success', 'Contenu signalé avec succès.');
    }


  // Afficher un signalement spécifique
  public function show($id)
{
    $signalement = Signalement::with(['user', 'signalable'])->findOrFail($id);

    return view('signalement.show', compact('signalement'));
}




public function supprimerArticle($id)
{
    $signalement = Signalement::findOrFail($id);
    $article = $signalement->signalable;

    if ($article) {
        // Supprimer tous les signalements liés à cet article
        Signalement::where('signalable_id', $article->id)
            ->where('signalable_type', get_class($article))
            ->delete();

        // Supprimer l'article lui-même
        $article->delete();
    }

    return back()->with('success', 'Article et signalements associés supprimés avec succès.');
}


// app/Http/Controllers/SignalementController.php
public function marquerVu($id)
{
    $signalement = Signalement::findOrFail($id);
    $signalement->vu = true;
    $signalement->save();

    return response()->json(['success' => true]);
}



}
