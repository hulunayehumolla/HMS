<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';
   // protected $primaryKey = 'staff_id';
    //public $incrementing = false;  // staff_id is string
    //protected $keyType = 'string';

    protected $fillable = [
        'staff_id',
        'department_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'date_of_birth',
        'country_name',
        'region_name',
        'zone_name',
        'kebele_name',
        'phone',
        'email',
        'address',
        'hire_date',
        'employment_type',
        'salary',
        'status',
        'photo',
    ];

    // Relationships
    /*hasOne(RelatedModel::class, foreign_key, local_key)*/
    public function doctor() {

     return $this->hasOne(Doctor::class, 'doctor_id', 'staff_id'); 
 }
    public function nurse() { 
        return $this->hasOne(Nurse::class, 'staff_id', 'staff_id'); 
    }
    public function pharmacist() { 
        return $this->hasOne(Pharmacist::class, 'staff_id', 'staff_id');
         }
    public function laboratory() {
     return $this->hasOne(Laboratory::class, 'staff_id', 'staff_id');
      }
    public function department() {
     return $this->belongsTo(Department::class, 'department_id');
      }

    public function user() {
     return $this->morphOne(User::class, 'profileable');
      }
}