<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class newPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions grouped by their categories
    $permissions = [
            'User Management' => [
                'create-role',
                'edit-role',
                'delete-role',
                'create-user',
                'edit-user',
                'edit-user-status',
                'edit-user-role',
                'delete-user',
               ],

            'News Management' =>[   
                 'create-news',
                 'update-news',
                 'delete-news',
            ],

              'Room Management' =>[   
                 'add-rooms',
                 'update-rooms',
                 'delete-rooms',
            ],

             'database' => [
                'take-backup',
              ],

        ];

        // Loop through each group and create permissions with the groupName
        foreach ($permissions as $groupName => $permissionList) {
            foreach ($permissionList as $permission) {
                Permission::firstOrCreate(
                    ['name' => $permission], // Find or create by name
                    ['groupName' => $groupName] // Add the groupName column
                );
            }
        }
    }
}
