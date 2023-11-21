<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Charging_station extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'postcode',
        'city',
        'street',
        'street_number',
        'number_of_charging_points',
        'is_verified',
    ];

    /**
     * Get all of the queues for the Charging_station
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function queues(): HasMany
    {
        return $this->hasMany(Queue::class);
    }

    public function charging_points(): BelongsToMany
    {
        return $this->belongsToMany(Charging_point::class, 'charging_station_charging_point');
    }
}
