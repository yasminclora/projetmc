<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Robe extends Model
{
    //
    protected $table = 'robes';
    protected $fillable = ['nom', 'prix', 'description', 'image', 'category', 'quantite'];

}
