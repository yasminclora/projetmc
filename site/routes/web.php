<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RobeController;
use App\Http\Controllers\BijouxController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;

use App\Http\Controllers\AdminController;

// 🏠 Route pour l'accueil





use App\Http\Controllers\ProfileController;

// Afficher le profil
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');

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






use App\Http\Controllers\AccueilController;

Route::get('/', [AccueilController::class, 'index']);


Route::get('/search', [AccueilController::class, 'search'])->name('search');



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










// 🛍️ Routes pour les robes
Route::get('/robe', [RobeController::class, 'index'])->name('robes.index');

Route::get('/robe/create', function () {
    return view('ajouter-robe');
})->name('robes.create');

Route::post('/robe', [RobeController::class, 'store'])->name('robes.store');
Route::get('/robe/{id}', [RobeController::class, 'show'])->name('robes.show');


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













//interface pour inserer des robe a la bdd
Route::get('/ajouter-robe', function () {
    return view('ajouter-robe');
})->name('robes.create');



//interface pour inserer des bijoux a la bdd
Route::get('/ajouter-bijoux', function () {
    return view('ajouter-bijoux'); // Assure-toi que le fichier est bien dans resources/views
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');






