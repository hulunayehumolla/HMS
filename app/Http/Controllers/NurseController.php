<?php
namespace App\Http\Controllers;
use App\Models\Doctor;
use App\Models\Staff;
use App\Models\Nurse;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NurseController extends Controller
{
    // List Staff
    public function index(Request $request)
    {
        $departments = Department::all();
        $nurses = Nurse::with('staff')->get();
        $query = Staff::query();

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $staffs = $query->latest()->paginate(10);

      $stats = [
    'total' => Nurse::count(),
    'active' => Nurse::whereHas('staff', function ($q) { $q->where('status', 'Active'); })->count(),
    'inactive' => Nurse::whereHas('staff', function ($q) { $q->where('status', 'Inactive');})->count(),
              ];

        return view('nurse.index', compact('nurses','staffs', 'departments', 'stats'));
    }
/*
    // Show Create Form
    public function create()
    {
        $departments = Department::all();
        return view('staff.create', compact('departments'));
    }*/

    // Store Doctor
    public function store(Request $request)
{
    $request->validate([
        'department_id'   => 'nullable|exists:departments,id',
        'first_name'      => 'required|string|max:255',
        'middle_name'     => 'nullable|string|max:255',
        'last_name'       => 'required|string|max:255',
        'gender'          => 'required|in:Male,Female,Other',
        'date_of_birth'   => 'nullable|date',
        'country_name'    => 'nullable|string|max:255',
        'region_name'     => 'nullable|string|max:255',
        'zone_name'       => 'nullable|string|max:255',
        'kebele_name'     => 'nullable|string|max:255',
        'phone'           => 'nullable|string|max:20',
        'email'           => 'nullable|email|max:255|unique:staff,email',
        'address'         => 'nullable|string|max:255',
        'hire_date'       => 'nullable|date',
        'employment_type' => 'nullable|string|max:255',
        'salary'          => 'nullable|numeric',
        'status'          => 'required|in:Active,Inactive',
        'photo'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    DB::beginTransaction();

    try {

        $data = $request->except('photo');

        // Generate unique staff_id
        $data['staff_id'] = 'INU' . strtoupper(Str::random(4));

        // Upload photo
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                                    ->store('staff', 'public');
        }


       
        // Create staff
        $staff = Staff::create($data);

        /*create Doctor*/
     $data1 = $request->validate([
    'staff_id' => 'exists:staff,staff_id',
    'specialization' => 'required|string|max:255',
    'qualification' => 'nullable|string|max:255',
    'shift_type' => 'nullable|string|max:255',
    'nursing_level' => 'nullable|string|max:255',
    'license_number' => 'required|string|max:255',
    'ward_assigned' => 'numeric|required',
        ]);
       $doctor= Nurse::create([
        'nurse_id'=>$data['staff_id'],
        'specialization'=>$data1['specialization'],
        'qualification'=>$data1['qualification'],
        'shift_type'=>$data1['shift_type'],
        'nursing_level'=>$data1['nursing_level'],
        'license_number'=>$data1['license_number'],
        'ward_assigned'=>$data1['ward_assigned']
        ]);

        // Create user account
        $user = User::create([
            'email'            => $staff->email ?? strtolower($staff->first_name.'.'.$staff->last_name).'@gmail.com',
            'username'         => $staff->staff_id,
            'password'         => Hash::make(strtolower($staff->staff_id).'123#'),
            'status'           => 1,
            'profileable_type' => Staff::class,
            'profileable_id'   => $staff->id, // ✅ FIXED
        ]);

        $user->assignRole('staff');

        DB::commit();

        return response()->json([
            'success' => 'Staff and user account created successfully!'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        \Log::error('Staff creation failed: '.$e->getMessage());

        return response()->json([
            'error' => 'Staff and user account not created!'
        ], 500);
    }
}
    // Delete Staff
    public function destroy(Staff $staff)
    {
        DB::beginTransaction();
        try {
            if ($staff->photo) {
                Storage::disk('public')->delete($staff->photo);
            }

            $user = User::where('profileable_type', Staff::class)
                        ->where('profileable_id', $staff->staff_id)
                        ->first();

            if ($user) $user->delete();

            $staff->delete();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Staff deleted successfully!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}