<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Participant;
class Event extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'location',
        'start_at',
        'end_at',
        'qr_token',
        'status',
        'created_by',
    ];

    protected $casts = [
    'start_at' => 'datetime',
    'end_at' => 'datetime',
    ];

        public function admins()
    {
        return $this->belongsToMany(User::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants()
    {
            return $this->belongsToMany(
            Participant::class,
            'event_participants'
        )->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
