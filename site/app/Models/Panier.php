<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Panier extends Model
{
    protected $fillable = ['user_id', 'statut'];
    
    public function items(): HasMany
    {
        return $this->hasMany(PanierItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalAttribute(): float
    {
        return $this->items->sum(function ($item) {
            return $item->quantite * $item->prix_unitaire;
        });
    }



}