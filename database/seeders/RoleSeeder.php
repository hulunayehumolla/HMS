<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $Quality_Director = Role::create(['name' => 'Quality Director']);
        $Colleg_Director = Role::create(['name' => 'College Director']);
        $Department = Role::create(['name' => 'Department']);
        $Employee = Role::create(['name' => 'Employee']);
        $Student = Role::create(['name' => 'Student']);


     $Colleg_Director->givePermissionTo([
            'generate report'
           
        ]);

    $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user'
        ]);

    $Colleg_Director->givePermissionTo([
            'performance approve',
            'performance reject',
            'evaluate performance',
            'view performance'
        ]);

    $Department->givePermissionTo([
            'assign course',
            'performance approve',
            'performance reject',
            'evaluate performance',
            'view performance'
        ]);


     $Employee->givePermissionTo([
            'view-course'
        ]);

    $Student->givePermissionTo([
            'view-course',
            'evalute teacher'
        ]);

    }
}
