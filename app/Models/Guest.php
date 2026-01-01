<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table = 'guests';

    protected $fillable = [
        'guest_id_type',
        'guest_id_number',
        'guest_fname',
        'guest_mname',
        'guest_lname',
        'guest_sex',
        'guest_phone',
        'guest_email',
        'guest_country',
        'guest_region',
        'guest_town',
        'guest_reg_date',
        'guest_reg_by',
    ];

    protected $casts = [
        'guest_reg_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Accessors (Optional)
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim("{$this->guest_fname} {$this->guest_mname} {$this->guest_lname}");
    }
}
