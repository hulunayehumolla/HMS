<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestStayDetail extends Model
{
    protected $table = 'guest_stay_details';

    protected $fillable = [
        'reservation_id',
        'guest_id',
        'check_in_date',
        'check_out_date',
        'no_of_adults',
        'no_of_nights',
        'price_per_night',
        'tax',
        'discount',
        'advance_payment',
        'total_price',
        'payment_status',
        'payment_method',
        'recorded_by',
    ];

    protected $casts = [
        'check_in_date'      => 'date',
        'check_out_date'     => 'date',
        'price_per_night'    => 'decimal:2',
        'tax'                => 'decimal:2',
        'discount'           => 'decimal:2',
        'advance_payment'    => 'decimal:2',
        'total_price'        => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function reservation()
    {
        return $this->belongsTo(RoomReservation::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function getBalanceAttribute(): float
    {
        return (float) ($this->total_price - $this->advance_payment);
    }
}
