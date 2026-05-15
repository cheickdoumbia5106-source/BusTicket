<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bus extends Model
{
    protected $fillable = ['nom', 'compagnie', 'nombre_places'];

    public function trajets(): HasMany
    {
        return $this->hasMany(Trajet::class);
    }

    public function sieges(): HasMany
    {
        return $this->hasMany(Siege::class);
    }
}