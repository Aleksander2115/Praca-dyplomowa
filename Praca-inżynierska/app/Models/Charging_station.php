<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'number_of_chargers',
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
}
