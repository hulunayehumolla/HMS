<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'registration_number',
        'type',
        'logo',
        'slogan',
        'email',
        'phone_number',
        'emergency_contact',
        'country',
        'zone',
        'woreda',
        'kebele',
        'zip_code',
        'capacity_beds',
        'is_active',
        'website'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity_beds' => 'integer'
    ];
}