<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trajet extends Model
{
    protected $fillable = [
        'ville_depart_id', 'ville_arrivee_id', 'bus_id',
        'date_depart', 'heure_depart', 'heure_arrivee', 'prix'
    ];

    protected $casts = [
        'date_depart' => 'date',
        'heure_depart' => 'datetime:H:i',
        'heure_arrivee' => 'datetime:H:i',
    ];

    public function villeDepart(): BelongsTo
    {
        return $this->belongsTo(Ville::class, 'ville_depart_id');
    }

    public function villeArrivee(): BelongsTo
    {
        return $this->belongsTo(Ville::class, 'ville_arrivee_id');
    }

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function getPlacesLibresAttribute(): int
    {
        $reservees = $this->reservations()
            ->where('statut', 'confirmee')
            ->with('sieges')
            ->get()
            ->sum(fn($r) => $r->sieges->count());
        
        return $this->bus->nombre_places - $reservees;
    }
}