<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $table = 'nurses';
    /*protected $primaryKey = 'nurse_id';
    public $incrementing = false;
    protected $keyType = 'string';*/ // ✅ FIXED (was int)

    protected $fillable = [
        'nurse_id',
        'specialization',
        'qualification',
        'shift_type',
        'nursing_level',
        'license_number',
        'ward_assigned'
    ];

    /**
     * Doctor belongs to Staff
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'nurse_id', 'staff_id');
    }
}