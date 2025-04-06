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
        $type = $request->input('type');
        $category = $request->input('category');
        $maxPrice = $request->input('max_price');
        
        $results = [];
    
        if ($type === 'robe') {
            $query = Robe::where('prix', '<=', $maxPrice);
            if ($category) {
                $query->where('category', $category);
            }
            $results = $query->get();
        } elseif ($type === 'bijoux') {
            $query = Bijoux::where('prix', '<=', $maxPrice);
            if ($category) {
                $query->where('type', $category);
            }
            $results = $query->get();
        }
    
        // Récupérer aussi les articles récents
        $recentRobes = Robe::latest()->take(4)->get();
        $recentBijoux = Bijoux::latest()->take(4)->get();
        $recentArticles = $recentRobes->merge($recentBijoux);
    
        return view('accueil', [
            'results' => $results,
            'recentArticles' => $recentArticles
        ]);
    }
    
}