<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'room_type',
        'room_status',
        'room_class',
        'room_size',
        'room_price',
        'room_is_cleaned',
        'room_services',
        'room_photos',
    ];

    protected $casts = [
        'room_price'      => 'decimal:2',
        'room_is_cleaned' => 'boolean',
        'room_services'   => 'array',
        'room_photos'     => 'array',
    ];

    /* Scopes for smart filtering */
    public function scopeAvailable($query)
    {
        return $query->where('room_status', 'available');
    }

    public function scopeClass($query, $class)
    {
        return $query->where('room_class', $class);
    }


    public function reservations()
    {
        return $this->hasMany(RoomReservation::class);
    }

    // Optional: current booking
    public function currentReservation()
    {
        return $this->hasOne(RoomReservation::class)
            ->where('room_res_status', 'confirmed');
    }
}

