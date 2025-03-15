<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
  

    protected $fillable = ['user_id', 'categorie', 'articles', 'total', 'statut'];

    protected $casts = [
        'articles' => 'array', // Convertit JSON en tableau PHP
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
