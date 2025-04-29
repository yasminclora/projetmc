<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandeItem extends Model
{
    protected $fillable = [
        'commande_id',
        'article_id',
        'article_type',
        'article_nom',
        'article_prix',
        'article_image',
        'quantite',
        'prix_unitaire'
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function article()
    {
        return $this->morphTo();
    }

    

    // Dans le modèle CommandeItem
public function robe()
{
    return $this->belongsTo(Robe::class, 'article_id');
}

public function bijou()
{
    return $this->belongsTo(Bijou::class, 'article_id');
}


}