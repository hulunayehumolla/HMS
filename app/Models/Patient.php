<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'patient_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'age',
        'date_of_birth',
        'phone',
        'email',
        'country',
        'region',
        'zone',
        'woreda',
        'kebele',
        'blood_type',
        'is_referred',
        'is_insurance_user',
        'referred_from',
        'emergency_contact_name',
        'emergency_contact_phone',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_referred' => 'boolean',
        'is_insurance_user' => 'boolean',
    ];

    /* ===================== ACCESSORS ===================== */

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function getCalculatedAgeAttribute()
    {
        if ($this->date_of_birth) {
            return Carbon::parse($this->date_of_birth)->age;
        }
        return $this->age;
    }

    /* ===================== AUTO PATIENT ID ===================== */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            if (!$patient->patient_id) {
                $patient->patient_id = 'PT-' . now()->format('Ymd') . '-' . rand(1000,9999);
            }

            if ($patient->date_of_birth) {
                $patient->age = Carbon::parse($patient->date_of_birth)->age;
            }
        });

        static::updating(function ($patient) {
            if ($patient->date_of_birth) {
                $patient->age = Carbon::parse($patient->date_of_birth)->age;
            }
        });
    }
}