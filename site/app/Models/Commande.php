<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Commande extends Model
{
  

   // app/Models/Commande.php
protected $fillable = [
    'user_id', 'reference', 'statut', 'total'
];


// Optionnel : Pour une meilleure gestion des statuts
public static $statuts = [
    'en_attente' => 'attente',
    'payee' => 'Payée',
    'expediee' => 'Expédiée',
    'annulee' => 'Annulée',
    'livree' => 'Livrée'
];

public function items()
{
    return $this->hasMany(CommandeItem::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
