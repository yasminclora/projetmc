<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RobeController;
use App\Http\Controllers\BijouxController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;

use App\Http\Controllers\AdminController;

// 🏠 Route pour l'accueil



Auth::routes();


use App\Http\Controllers\ProfileController;

// Afficher le profil
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');

Route::get('/ad', [AdminController::class, 'show'])->name('ad.show')->middleware('auth');





// Modifier le profil
Route::get('/edit', [ProfileController::class, 'edit'])->name('edit')->middleware('auth');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');


/*
Route::get('admin', [RobeController::class, 'adminIndex'])->name('admin');
//mise a jour d'une robe dans l'interface de l'admin

Route::put('/robe/{id}', [RobeController::class, 'update'])->name('robes.update');
*/



// Route pour le tableau de bord admin
Route::get('/admin', [AdminController::class, 'index'])->name('admin');




Route::get('/ad', [AdminController::class, 'index'])->name('ad');



use App\Http\Controllers\AccueilController;

Route::get('/', [AccueilController::class, 'index'])->name('accueil');
Route::get('/recherche', [AccueilController::class, 'search'])->name('accueil.search');



// Route pour afficher le tableau de bord administrateur
Route::get('/admin', [AdminController::class, 'index'])->name('admin');

// Routes pour les robes
Route::post('/admin/robes', [AdminController::class, 'storeRobe'])->name('admin.robes.store');
Route::put('/admin/robes/{id}', [AdminController::class, 'updateRobe'])->name('admin.robes.update');
Route::delete('/admin/robes/{id}', [AdminController::class, 'destroyRobe'])->name('admin.robes.destroy');

// Routes pour les bijoux
Route::post('/admin/bijoux', [AdminController::class, 'storeBijoux'])->name('admin.bijoux.store');
Route::put('/admin/bijoux/{id}', [AdminController::class, 'updateBijoux'])->name('admin.bijoux.update');
Route::delete('/admin/bijoux/{id}', [AdminController::class, 'destroyBijoux'])->name('admin.bijoux.destroy');






// Routes pour les commandes
Route::put('/admin/commandes/{commande}', [AdminController::class, 'updateCommande'])->name('admin.commandes.update');
//commandes recu pour chaque user 
Route::get('/commandes-recues', [CommandeController::class, 'commandesRecues'])
    ->name('commandes_recues')
    ->middleware('auth');


    //modifi statut pas user
    Route::put('/commandes/{id}/statut', [CommandeController::class, 'updateStatut'])
    ->name('commandes.update_statut')
    ->middleware('auth');


//robe detaul 
// routes/web.php

//comments pour robes

Route::get('robe/{id}', [RobeController::class, 'show'])->name('robes.detail');
Route::post('/robe/{id}/commentaire', [RobeController::class, 'addComment'])->name('robes.addComment');


Route::post('/robes/{id}/commentaires', [RobeController::class, 'addComment'])->name('commentaires.store');
Route::get('/commentaires/{id}/edit', [RobeController::class, 'editComment'])->name('commentaires.edit');
Route::put('/commentaires/{id}', [RobeController::class, 'updateComment'])->name('commentaires.update');
Route::delete('/commentaires/{id}', [RobeController::class, 'destroyComment'])->name('commentaires.destroy');


//comment pour bijou
Route::get('bijou/{id}', [BijouxController::class, 'show'])->name('bijou.detail');
Route::post('/bijou/{id}/commentaire', [BijouxController::class, 'addComment'])->name('bijou.addComment');


Route::post('/bijou/{id}/commentaires', [BijouxController::class, 'addComment'])->name('commentaires.store');
Route::get('/commentaires/{id}/edit', [BijouxController::class, 'editComment'])->name('commentaires.edit');
Route::put('/commentaires/{id}', [BijouxController::class, 'updateComment'])->name('commentaires.update');
Route::delete('/commentaires/{id}', [BijouxController::class, 'destroyComment'])->name('commentaires.destroy');




// 🛍️ Routes pour les robes
Route::get('/robe', [RobeController::class, 'index'])->name('robes.index');

Route::get('/robe/create', function () {
    return view('ajouter-robe');
})->name('robes.create');

Route::post('/robe', [RobeController::class, 'store'])->name('robes.store');


Route::delete('/robe/{id}', [RobeController::class, 'destroy'])->name('robes.destroy');

// 💎 Routes pour les bijoux
Route::get('/bijoux', [BijouxController::class, 'index'])->name('bijoux.index');
Route::get('/bijoux/create', function () {
    return view('ajouter-bijoux');
})->name('bijoux.create');
Route::post('/bijoux', [BijouxController::class, 'store'])->name('bijoux.store');

// 🛒 Routes pour le panier
Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
Route::delete('/panier/retirer/{id}', [PanierController::class, 'retirer'])->name('panier.retirer');
Route::delete('/panier/vider', [PanierController::class, 'vider'])->name('panier.vider');

// 📌 Utilisation des ressources pour les CRUD complets
Route::resource('robes', RobeController::class)->except(['create']); // `create` est déjà défini au-dessus
Route::resource('bijoux', BijouxController::class)->except(['create']);




Route::get('commandes', [CommandeController::class, 'index'])->name('commandes.index');
Route::get('commandes/{id}', [CommandeController::class, 'show'])->name('commandes.show');
Route::post('/commander', [CommandeController::class, 'store'])->name('commander');


// web.php (routes)
use App\Http\Controllers\NotificationController;
//notif cote acheteru

Route::get('/notifications/unread/count', [NotificationController::class, 'countUnread']);
Route::get('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');







Route::middleware('auth')->group(function () {
    Route::get('/notifications/validées', [NotificationController::class, 'showValidatedNotifications'])->name('notifications.validated');
    Route::get('/notifications/reçues', [NotificationController::class, 'showReceivedNotifications'])->name('notifications.received');
});



Route::put('/commande/{commande}/update-items-statut', [CommandeController::class, 'updateStatutsParCommande'])
    ->name('commande_items.update_statuts_par_commande');



use App\Http\Controllers\ArticleController;

Route::get('/mes-articles', [ArticleController::class, 'index'])->name('mes_articles');

Route::get('/mes-commandes', [App\Http\Controllers\CommandeController::class, 'mesCommandes'])
    ->name('mes_commandes')
    ->middleware('auth');

// Route pour afficher le tableau de bord utilisateur
Route::get('/articles', [ArticleController::class, 'index'])->name('user');


// Routes pour les robes
Route::post('/articles/robes', [ArticleController::class, 'storeRobe'])->name('user.robes.store');
Route::put('/articles/robes/{id}', [ArticleController::class, 'updateRobe'])->name('user.robes.update');
Route::delete('/articles/robes/{id}', [ArticleController::class, 'destroyRobe'])->name('user.robes.destroy');

// Routes pour les bijoux
Route::post('/articles/bijoux', [ArticleController::class, 'storeBijoux'])->name('user.bijoux.store');
Route::put('/articles/bijoux/{id}', [ArticleController::class, 'updateBijoux'])->name('user.bijoux.update');
Route::delete('/articles/bijoux/{id}', [ArticleController::class, 'destroyBijoux'])->name('user.bijoux.destroy');






//interface pour inserer des robe a la bdd
Route::get('/ajouter-robe', function () {
    return view('ajouter-robe');
})->name('robes.create');



//interface pour inserer des bijoux a la bdd
Route::get('/ajouter-bijoux', function () {
    return view('ajouter-bijoux'); // Assure-toi que le fichier est bien dans resources/views
});




Route::middleware(['auth'])->group(function () {
    // Panier
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/ajouter', [PanierController::class, 'ajouter'])->name('panier.ajouter');
    Route::post('/panier/{item}/update', [PanierController::class, 'update'])->name('panier.update');
    Route::delete('/panier/{item}/remove', [PanierController::class, 'remove'])->name('panier.remove');
    Route::post('/panier/commander', [PanierController::class, 'commander'])->name('panier.commander');
    
    // Confirmation
    Route::get('/confirmation', function () {
        return view('panier.confirmation');
    })->name('confirmation');
});


Route::post('/commander', [CommandeController::class, 'store'])->name('commander.store');
Route::get('/confirmation-commande', [CommandeController::class, 'confirmation'])->name('commande.confirmation');







