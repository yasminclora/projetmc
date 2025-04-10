<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Bijoux extends Model
{
    //
    protected $table = 'bijouxes';
    protected $fillable = ['nom', 'prix', 'image', 'quantite', 'type','user_id'];


    public function panierItems()
{
    return $this->morphMany(PanierItem::class, 'produit');
}

public function commandeItems()
{
    return $this->morphMany(CommandeItem::class, 'article');
}


public function user()
{
    return $this->belongsTo(User::class);
}


public function commentaires()
    {
        return $this->morphMany(Commentaire::class, 'commentable');
    }
}
