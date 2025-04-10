<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

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




public function user()
{
    return $this->belongsTo(User::class);
}

    public function commentaires()
    {
        return $this->morphMany(Commentaire::class, 'commentable');
    }
}

