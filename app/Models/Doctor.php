<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';
    protected $primaryKey = 'doctor_id';
    public $incrementing = false;
    protected $keyType = 'string'; // ✅ FIXED (was int)

    protected $fillable = [
        'doctor_id',
        'specialization',
        'qualification',
        'license_number',
        'consultation_fee'
    ];

    /**
     * Doctor belongs to Staff
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'doctor_id', 'staff_id');
    }
}