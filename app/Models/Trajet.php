<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Trajet extends Model
{
    protected $fillable = [
        'ville_depart_id',
        'ville_arrivee_id',
        'bus_id',
        'date_depart',
        'heure_depart',
        'heure_arrivee',
        'prix',
    ];

    protected $casts = [
        'date_depart' => 'date',
        'heure_depart' => 'datetime',
        'heure_arrivee' => 'datetime',
    ];

    protected $appends = [
        'places_libres',
        'taux_occupation',
        'nom_complet'
    ];

    /**
     * Relation avec la ville de départ
     */
    public function villeDepart(): BelongsTo
    {
        return $this->belongsTo(Ville::class, 'ville_depart_id');
    }

    /**
     * Relation avec la ville d'arrivée
     */
    public function villeArrivee(): BelongsTo
    {
        return $this->belongsTo(Ville::class, 'ville_arrivee_id');
    }

    /**
     * Relation avec le bus
     */
    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }

    /**
     * Relation avec les réservations
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Accesseur pour le nombre de places libres
     */
    public function getPlacesLibresAttribute()
    {
        if (!$this->bus) {
            return 0;
        }

        $reservedSeats = $this->reservations()
            ->where('statut', 'confirmee')
            ->with('sieges')
            ->get()
            ->sum(fn($r) => $r->sieges->count());

        return max(0, $this->bus->nombre_places - $reservedSeats);
    }

    /**
     * Accesseur pour le taux d'occupation
     */
    public function getTauxOccupationAttribute()
    {
        if (!$this->bus || $this->bus->nombre_places == 0) {
            return 0;
        }

        $totalPlaces = $this->bus->nombre_places;
        $placesOccupees = $totalPlaces - $this->places_libres;
        
        return round(($placesOccupees / $totalPlaces) * 100);
    }

    /**
     * Accesseur pour le nom complet du trajet
     */
    public function getNomCompletAttribute()
    {
        return $this->villeDepart->nom . ' → ' . $this->villeArrivee->nom;
    }

    /**
     * Vérifie si le trajet a des places disponibles
     */
    public function hasAvailableSeats(): bool
    {
        return $this->places_libres > 0;
    }

    /**
     * Vérifie si le trajet est dans le futur
     */
    public function isUpcoming(): bool
    {
        $departureDateTime = Carbon::parse($this->date_depart)->setTimeFromTimeString(
            Carbon::parse($this->heure_depart)->format('H:i:s')
        );
        
        return $departureDateTime->isFuture();
    }

    /**
     * Vérifie si le trajet est passé
     */
    public function isPast(): bool
    {
        $departureDateTime = Carbon::parse($this->date_depart)->setTimeFromTimeString(
            Carbon::parse($this->heure_depart)->format('H:i:s')
        );
        
        return $departureDateTime->isPast();
    }

    /**
     * Scope pour les trajets à venir
     */
    public function scopeUpcoming($query)
    {
        return $query->where('date_depart', '>=', Carbon::now())
                     ->orWhere(function($q) {
                         $q->where('date_depart', '=', Carbon::now()->format('Y-m-d'))
                           ->where('heure_depart', '>=', Carbon::now()->format('H:i:s'));
                     });
    }

    /**
     * Scope pour les trajets passés
     */
    public function scopePast($query)
    {
        return $query->where('date_depart', '<', Carbon::now())
                     ->orWhere(function($q) {
                         $q->where('date_depart', '=', Carbon::now()->format('Y-m-d'))
                           ->where('heure_depart', '<', Carbon::now()->format('H:i:s'));
                     });
    }

    /**
     * Scope pour les trajets avec places disponibles
     */
    public function scopeWithAvailableSeats($query)
    {
        return $query->whereHas('bus', function($q) {
            $q->whereColumn('buses.nombre_places', '>', function($sub) {
                $sub->selectRaw('COUNT(*)')
                    ->from('reservations')
                    ->join('reservation_siege', 'reservations.id', '=', 'reservation_siege.reservation_id')
                    ->whereColumn('reservations.trajet_id', 'trajets.id')
                    ->where('reservations.statut', 'confirmee');
            });
        });
    }

    /**
     * Récupère le nombre total de réservations confirmées
     */
    public function getTotalReservationsCountAttribute()
    {
        return $this->reservations()
            ->where('statut', 'confirmee')
            ->count();
    }

    /**
     * Récupère le chiffre d'affaires généré par ce trajet
     */
    public function getChiffreAffairesAttribute()
    {
        return $this->reservations()
            ->where('statut', 'confirmee')
            ->sum('montant_total');
    }

    /**
     * Formate la date de départ
     */
    public function getDateDepartFormattedAttribute()
    {
        return Carbon::parse($this->date_depart)->format('d/m/Y');
    }

    /**
     * Formate l'heure de départ
     */
    public function getHeureDepartFormattedAttribute()
    {
        return Carbon::parse($this->heure_depart)->format('H:i');
    }

    /**
     * Formate l'heure d'arrivée
     */
    public function getHeureArriveeFormattedAttribute()
    {
        return Carbon::parse($this->heure_arrivee)->format('H:i');
    }

    /**
     * Calcule la durée du trajet
     */
    public function getDureeAttribute()
    {
        $depart = Carbon::parse($this->date_depart)->setTimeFromTimeString(
            Carbon::parse($this->heure_depart)->format('H:i:s')
        );
        
        $arrivee = Carbon::parse($this->date_depart)->setTimeFromTimeString(
            Carbon::parse($this->heure_arrivee)->format('H:i:s')
        );
        
        // Si l'heure d'arrivée est plus petite que l'heure de départ, on ajoute un jour
        if ($arrivee->lt($depart)) {
            $arrivee->addDay();
        }
        
        $difference = $depart->diff($arrivee);
        
        return $difference->format('%h h %i min');
    }

    /**
     * Vérifie si les villes de départ et d'arrivée sont différentes
     */
    public function validateDifferentCities(): bool
    {
        return $this->ville_depart_id !== $this->ville_arrivee_id;
    }

    /**
     * Vérifie si la date d'arrivée est après la date de départ
     */
    public function validateArrivalAfterDeparture(): bool
    {
        $departureDateTime = Carbon::parse($this->date_depart)->setTimeFromTimeString(
            Carbon::parse($this->heure_depart)->format('H:i:s')
        );
        
        $arrivalDateTime = Carbon::parse($this->date_depart)->setTimeFromTimeString(
            Carbon::parse($this->heure_arrivee)->format('H:i:s')
        );
        
        // Si l'heure d'arrivée est plus petite, on considère que c'est le lendemain
        if ($arrivalDateTime->lt($departureDateTime)) {
            $arrivalDateTime->addDay();
        }
        
        return $arrivalDateTime->gt($departureDateTime);
    }
}