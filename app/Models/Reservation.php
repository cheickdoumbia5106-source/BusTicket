<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'trajet_id', 'reference', 'statut', 'montant_total', 'date_reservation'
    ];

    protected $casts = [
        'date_reservation' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trajet(): BelongsTo
    {
        return $this->belongsTo(Trajet::class);
    }

    public function sieges(): BelongsToMany
    {
        return $this->belongsToMany(Siege::class, 'reservation_sieges')
            ->withPivot('prix_unitaire')
            ->withTimestamps();
    }

    public function paiement(): HasOne
    {
        return $this->hasOne(Paiement::class);
    }
}