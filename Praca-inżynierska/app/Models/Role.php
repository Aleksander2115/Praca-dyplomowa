<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_name',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role');
    }
}
