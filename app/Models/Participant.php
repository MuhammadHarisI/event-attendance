<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'identity_number',
        'name',
        'email',
        'phone',
        'institution',
    ];

    public function events()
    {
        return $this->belongsToMany(
            Event::class,
            'event_participants'
        )->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}