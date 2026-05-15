<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ville extends Model
{
    protected $fillable = ['nom', 'slug'];

    public function trajetsDepart(): HasMany
    {
        return $this->hasMany(Trajet::class, 'ville_depart_id');
    }

    public function trajetsArrivee(): HasMany
    {
        return $this->hasMany(Trajet::class, 'ville_arrivee_id');
    }
}