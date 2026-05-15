<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paiement extends Model
{
    protected $fillable = ['reservation_id', 'mode_paiement', 'statut', 'transaction_id'];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}