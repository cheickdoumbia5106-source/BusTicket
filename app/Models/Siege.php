<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Siege extends Model
{
    protected $fillable = ['bus_id', 'numero_siege', 'rang', 'colonne'];

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'reservation_sieges')
            ->withPivot('prix_unitaire')
            ->withTimestamps();
    }
}