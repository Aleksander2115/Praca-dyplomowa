<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Charging_point extends Model
{
    use Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type_of_electric_current',
        'plug_type',
        'power',
    ];

    public function charging_stations(): BelongsToMany
    {
        return $this->belongsToMany(Charging_station::class, 'charging_station_charging_point');
    }

        /**
     * Get all of the users for the Queue
     *
     * @return \Illuminate\DatabUser\Eloquent\Relations\HasMany
     */
    public function users(): hasMany
    {
        return $this->hasMany(User::class);
    }
}
