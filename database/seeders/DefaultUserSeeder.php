<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
class DefaultUserSeeder extends Seeder
{
    
    public function run(): void
    {
        // Creating Super Admin User


          Role::firstOrCreate(['name' => 'Super Admin']);
           Role::firstOrCreate(['name' => 'Admin']);

                $employee = Employee::create([
                     'emp_Id' =>"inu1224",
                     'emp_Fname' =>"Ahmed",
                     'emp_Mname'=>"Mohamed",
                     'emp_Lname'=>"Kemal",
                     'emp_coll_dirId'=>"cet",
                     'emp_dept_teamId'=>"cs",
                      'emp_Status'=>"Active",
                    ]);
     
            

            $Admin = User::create([
                'email' =>"ahmedpg08@gmail.com",
                'username' =>"inu1224" ,
                'password' => Hash::make(strtolower("inu1224")."123#"),
                'status' => "1",
                'profileable_type' => Employee::class,
                'profileable_id' => $employee->id,
           ]);

           $Admin->assignRole('Admin');



         $employee2 = Employee::create([
                     'emp_Id' =>"inu1373",
                     'emp_Fname' =>"Andualem",
                     'emp_Mname'=>"Muche",
                     'emp_Lname'=>"Gobezie",
                     'emp_coll_dirId'=>"cet",
                     'emp_dept_teamId'=>"cs",
                     'emp_Status'=>"Active",
                    ]);
     
            
                  
            $superAdmin = User::create([
                 'email' =>"andualem1164@gmail.com" ,
                 'username' =>"inu1373" ,
                 'password' => Hash::make(strtolower("inu1373")."123#"),
                 'status' => "1",
                 'profileable_type' => Employee::class,
                 'profileable_id' => $employee2->id,
           ]);
            $superAdmin->assignRole('Super Admin');




        $superAdmin->givePermissionTo([
                 'create-role',
                'edit-role',
                'delete-role',
                'create-user',
                'edit-user',
                'edit-user-status',
                'edit-user-role',
                'delete-user',
             ]);
            

           /* $admin->assignRole('Admin');*/
        


   
    }
}
