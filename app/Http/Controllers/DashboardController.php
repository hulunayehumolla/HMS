<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Nurse;
use App\Models\Laboratory;
use App\Models\Pharmacist;





class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Staff Statistics
        |--------------------------------------------------------------------------
        */
        $staffStats = [
            'total'     => Staff::count(),
/*            'active'    => Staff::where('status', 'Active')->count(),
            'inactive'  => Staff::where('status', 'Inactive')->count(),*/
        ];

        /*
        |--------------------------------------------------------------------------
        | System Statistics
        |--------------------------------------------------------------------------
        */
        $systemStats = [
            'patients'              => Patient::count(),
            'doctors'               => Doctor::count(),
            'department'            => Department::count(),
            'nurse'                 => Nurse::count(),
            'pharmacist'            =>Pharmacist::count(),
            'laboratory'            =>Laboratory::count(),
    /*        'appointments_total'    => Appointment::count(),
           'appointments_today'    => Appointment::whereDate('appointment_date', now())->count(),
            'appointments_pending'  => Appointment::where('status', 'Pending')->count(),*/
        ];

        /*
        |--------------------------------------------------------------------------
        | Dashboard Cards
        |--------------------------------------------------------------------------
        */
        $cards = [

            // Staff Cards
            [
                'label' => 'Total Staff',
                'value' => $staffStats['total'],
                'icon'  => 'fa-users',
                'bg'    => 'bg-dark text-white'
            ],
        /*    [
                'label' => 'Active Staff',
                'value' => $staffStats['active'],
                'icon'  => 'fa-user-check',
                'bg'    => 'bg-success text-white'
            ],*/
/*            [
                'label' => 'Inactive Staff',
                'value' => $staffStats['inactive'],
                'icon'  => 'fa-user-xmark',
                'bg'    => 'bg-danger text-white'
            ],*/

            // System Cards
            [
                'label' => ' Patients',
                'value' => $systemStats['patients'],
                'icon'  => 'fa-bed',
                'bg'    => 'bg-primary text-white'
            ],
            [
                'label' => ' Doctors',
                'value' => $systemStats['doctors'],
                'icon'  => 'fa-user-doctor',
                'bg'    => 'bg-info text-white'
            ],
            [
                'label' => 'Departments',
                'value' => $systemStats['department'],
                'icon'  => 'fa-sitemap',   // better for departments structure
                'bg'    => 'bg-primary text-white'
            ],
            [
                'label' => 'Nurses',
                'value' => $systemStats['nurse'],
                'icon'  => 'fa-user-nurse',  // correct nurse icon
                'bg'    => 'bg-warning text-dark'
            ],
            [
                'label' => 'Pharmacist',
                'value' => $systemStats['pharmacist'],
                'icon'  => 'fa-pills',   // perfect for pharmacy
                'bg'    => 'bg-success text-white'
            ],
            [
                'label' => 'Laboratory',
                'value' => $systemStats['laboratory'],
                'icon'  => 'fa-flask',   // perfect for lab
                'bg'    => 'bg-danger text-white'
            ],
        ];

        return view('dashboard', compact('cards'));
    }
}