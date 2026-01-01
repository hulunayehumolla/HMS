<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\newPermissionSeeder;

class SeederController extends Controller
{
    public function runPermissionSeeder()
    {
        // Check if the authenticated user has the "Super Admin" role
        if (!auth()->user()->hasRole('Super Admin')) {
            abort(403, 'Unauthorized action.');
        }

        // Instantiate and run the seeder
        $seeder = new newPermissionSeeder();
        $seeder->run();

        // Redirect back with a success message
        return back()->with('success', 'New permissions have been seeded successfully!');
    }
}