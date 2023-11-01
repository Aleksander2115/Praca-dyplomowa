<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Queue extends Model
{
    use Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sign_up_time',
        'start_time',
        'end_time',
    ];

    /**
     * Get all of the users for the Queue
     *
     * @return \Illuminate\DatabUser\Eloquent\Relations\HasMany
     */
    public function users(): hasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the charging_station that owns the Queue
     *
     * @return \Illuminate\Charging_stationbase\Eloquent\Relations\BelongsTo
     */
    public function charging_station(): BelongsTo
    {
        return $this->belongsTo(Charging_station::class);
    }
}
