<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Spatie\Permission\Traits\HasRoles;
class Employee extends Model
{
    use HasFactory,HasRoles;
    protected $fillable=[
            'emp_Id',
            'emp_Fname',
            'emp_Mname',
            'emp_Lname',
            'emp_Sex',
            'emp_Phone',
            'emp_Nationality',
            'emp_rankId',
            'emp_As',
            'emp_coll_dirId',
            'emp_dept_teamId',
            'emp_Status' // active or inactive study Leave
       ];

    protected $table="employees";


    public function user()
    {
        return $this->morphOne(User::class, 'profileable');
    }
}
