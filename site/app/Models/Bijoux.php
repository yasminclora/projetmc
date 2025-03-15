<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bijoux extends Model
{
    //
    protected $table = 'bijouxes';
    protected $fillable = ['nom', 'prix', 'image', 'quantite', 'type'];

}
