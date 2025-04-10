<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Controller;
class Commentaire extends Model
{
    protected $fillable = ['user_id', 'commentable_id', 'commentable_type', 'commentaire'];

    // Relation polymorphique
    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
