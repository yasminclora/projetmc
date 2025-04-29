<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Bijoux;

use Illuminate\Database\Eloquent\Factories\HasFactory;



class Signalement extends Model
{
    protected $fillable = [
        'user_id',
        'signalable_id',
        'signalable_type',
        'motif',
        'vu',
    ];

    // Relation polymorphique
    public function signalable()
    {
        return $this->morphTo();
    }

    // Relation avec l'utilisateur (si tu veux savoir qui a signalé)
    public function user()
    {
        return $this->belongsTo(User::class);
    }




// Signalement.php
public function robe()
{
    return $this->belongsTo(Robe::class);
}

public function bijou()
{
    return $this->belongsTo(Bijoux::class);
}

public function commentaire()
{
    return $this->belongsTo(Commentaire::class);
}




}

