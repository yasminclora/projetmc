<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commande_id',
        'montant',
        'methode',
        'reference',
        'statut',
        'details',
        'date_paiement'
    ];

    protected $casts = [
        'date_paiement' => 'datetime',
        'details' => 'array', // Pour stocker des données JSON
        'montant' => 'decimal:2'
    ];

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec la commande
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    // Méthodes pratiques
    public function estValide()
    {
        return $this->statut === 'valide';
    }

    public function marquerCommeValide(array $details = [])
    {
        $this->update([
            'statut' => 'valide',
            'date_paiement' => now(),
            'details' => $details
        ]);
    }
}