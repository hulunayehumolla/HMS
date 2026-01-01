<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'service_type',
        'order_type',
        'room_table_id',
        'bar_section',
        'staff_id',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_table_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isRoomService(): bool
    {
        return $this->order_type === 'room_service';
    }

    public function isTakeAway(): bool
    {
        return $this->order_type === 'take_away';
    }

    public function isDiningIn(): bool
    {
        return $this->order_type === 'dining_in';
    }
}
