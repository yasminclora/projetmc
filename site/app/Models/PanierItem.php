<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PanierItem extends Model
{
    protected $fillable = [
        'panier_id', 
        'quantite', 
        'prix_unitaire',
        'article_id',
        'article_type'
    ];

    public function panier(): BelongsTo
    {
        return $this->belongsTo(Panier::class);
    }

    public function article()
    {
        return $this->morphTo();
    }

    public function getTypeAttribute(): string
    {
        return match($this->article_type) {
            'App\Models\Robe' => 'robe',
            'App\Models\Bijoux' => 'bijou',
            default => 'inconnu'
        };
    }





}