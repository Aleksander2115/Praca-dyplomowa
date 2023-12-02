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

    public function charging_points(): BelongsToMany
    {
        return $this->belongsToMany(Charging_point::class, 'charging_station_charging_point');
    }
}
