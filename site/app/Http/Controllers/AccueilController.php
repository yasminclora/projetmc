<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Robe; // Modèle Robe
use App\Models\Bijoux; // Modèle Bijoux

class AccueilController extends Controller
{
    public function index()
    {
        // Récupérer les 4 dernières robes et les 4 derniers bijoux
        $recentRobes = Robe::latest()->take(4)->get();
        $recentBijoux = Bijoux::latest()->take(4)->get();

        // Fusionner les deux collections
        $recentArticles = $recentRobes->merge($recentBijoux);

        // Passer les données à la vue
        return view('accueil', compact('recentArticles'));
    }

    public function search(Request $request)
    {
        // Récupérer les critères de recherche
        $type = $request->input('type'); // 'robe' ou 'bijoux'
        $category = $request->input('category'); // 'simple', 'fete', 'mariee'
        $maxPrice = $request->input('max_price'); // Prix maximum

        // Initialiser les résultats
        $results = [];

        // Rechercher en fonction du type et du prix
        if ($type === 'robe') {
            $query = Robe::where('prix', '<=', $maxPrice);
            if ($category) {
                $query->where('category', $category);
            }
            $results = $query->get();
        } elseif ($type === 'bijoux') {
            $results = Bijoux::where('prix', '<=', $maxPrice)->get();
        }

        // Retourner les résultats à la vue
        return view('accueil', [
            'results' => $results,
            'carouselImages' => [],
            'recentArticles' => []
        ]);
    }
}