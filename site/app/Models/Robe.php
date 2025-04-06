<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Robe extends Model
{
    //
    protected $table = 'robes';
    protected $fillable = ['nom', 'prix', 'description', 'image', 'category', 'quantite','user_id'];



    public function panierItems()
{
    return $this->morphMany(PanierItem::class, 'produit');
}

public function commandeItems()
{
    return $this->morphMany(CommandeItem::class, 'article');
}
}
