<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    use HasFactory;

    protected $table = 'laboratorys';
  /*  //protected $primaryKey = 'laboratory_id';*/
  /* // public $incrementing = false;
    protected $keyType = 'string'; // ✅ FIXED (was int)*/

    protected $fillable = [
        'laboratory_id',
        'qualification',
        'license_number',
        ];

    /**
     * Doctor belongs to Staff
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'laboratory_id', 'staff_id');
    }
}