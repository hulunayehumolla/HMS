<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    // Relation: a department has many staff
    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }
}
