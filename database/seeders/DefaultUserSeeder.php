<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DefaultUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Admin']);

        // Create Permissions FIRST
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'edit-user-status',
            'edit-user-role',
            'delete-user',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Users data
        $users = [
            [
                'role' => 'Admin',
                'staff' => [
                    'staff_id' => 'inu1224',
                    'first_name' => 'Ahmed',
                    'middle_name' => 'Mohamed',
                    'last_name' => 'Kemal',
                    'gender' => 'male',
                    'status' => 'Active',
                    'country_name' => 'Ethiopia',
                    'region_name' => 'Amhara',
                    'phone' => '094564545547',
                    'employment_type' => 'Permanent',
                    'salary' => '5600',
                    'email' => 'ahmedpg08@gmail.com',
                ],
                'user' => [
                    'email' => 'ahmedpg08@gmail.com',
                    'username' => 'inu1224',
                ],
            ],
            [
                'role' => 'Super Admin',
                'staff' => [
                    'staff_id' => 'inu1373',
                    'first_name' => 'Andualem',
                    'middle_name' => 'Muche',
                    'last_name' => 'Gobezie',
                    'gender' => 'male',
                    'status' => 'Active',
                    'country_name' => 'Ethiopia',
                    'region_name' => 'Amhara',
                    'phone' => '09456677900',
                    'employment_type' => 'Permanent',
                    'salary' => '5600',
                     'email' => 'andualem1164@gmail.com',
                ],
                'user' => [
                    'email' => 'andualem1164@gmail.com',
                    'username' => 'inu1373',
                ],
            ],
            [
                'role' => 'Admin',
                'staff' => [
                    'staff_id' => 'inu506',
                    'first_name' => 'Aberham',
                    'middle_name' => 'Sewnet',
                    'last_name' => 'Kassa',
                    'gender' => 'male',
                    'status' => 'Active',
                    'country_name' => 'Ethiopia',
                    'region_name' => 'Amhara',
                    'phone' => '09456679867',
                    'employment_type' => 'Permanent',
                    'salary' => '5600',
                    'email' => 'seab22245@gmail.com',
                ],
                'user' => [
                    'email' => 'seab22245@gmail.com',
                    'username' => 'inu506',
                ],
            ],
            [
                'role' => 'Super Admin',
                'staff' => [
                    'staff_id' => 'inu4160',
                    'first_name' => 'Hulunayehu',
                    'middle_name' => 'Molla',
                    'last_name' => 'Yilak',
                    'gender' => 'male',
                    'status' => 'Active',
                    'country_name' => 'Ethiopia',
                    'region_name' => 'Amhara',
                    'phone' => '09456677000',
                    'employment_type' => 'Permanent',
                    'salary' => '5600',
                    'email' => 'kulumolla211@gmail.com',


                ],
                'user' => [
                    'email' => 'kulumolla217@gmail.com',
                    'username' => 'inu416',
                ],
            ],
        ];

        foreach ($users as $data) {

            $staff = Staff::firstOrCreate(
                ['staff_id' => $data['staff']['staff_id']],
                $data['staff']
            );

            $user = User::firstOrCreate(
                ['email' => $data['user']['email']],
                [
                    'username' => $data['user']['username'],
                    'password' => Hash::make(strtolower($data['user']['username']) . '123#'),
                    'status' => '1',
                    'profileable_type' => Staff::class,
                    'profileable_id' => $staff->id,
                ]
            );

            $user->syncRoles([$data['role']]);
        }

        // Give Super Admin ALL permissions
        $superAdmin = User::where('email', 'kulumolla21@gmail.com')->first();

        if ($superAdmin) {
            $superAdmin->syncPermissions($permissions);
        }
    }
}
