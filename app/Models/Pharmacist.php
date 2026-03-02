<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacist extends Model
{
    use HasFactory;

    protected $table = 'Pharmacists';
  /*  protected $primaryKey = 'pharmacist_id';*/
  /*  public $incrementing = false;
    protected $keyType = 'string'; // ✅ FIXED (was int)*/

    protected $fillable = [
        'pharmacist_id',
        'qualification',
        'license_number',
        ];

    /**
     * Doctor belongs to Staff
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'pharmacist_id', 'staff_id');
    }
}