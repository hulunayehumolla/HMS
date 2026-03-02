<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class PatientController extends Controller
{
        public function index(Request $request)
        {
            $query = Patient::query();

            // Live search by name, ID, phone
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%$search%")
                      ->orWhere('middle_name', 'like', "%$search%")
                      ->orWhere('last_name', 'like', "%$search%")
                      ->orWhere('patient_id', 'like', "%$search%")
                      ->orWhere('phone', 'like', "%$search%");
                });
            }

            // Filter by gender
            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            // Filter by insurance user
            if ($request->filled('is_insurance_user')) {
                $query->where('is_insurance_user', $request->is_insurance_user);
            }

            // Filter by referred
            if ($request->filled('is_referred')) {
                $query->where('is_referred', $request->is_referred);
            }

            // Filter by blood type
            if ($request->filled('blood_type')) {
                $query->where('blood_type', $request->blood_type);
            }

            $patients = $query->latest()->paginate(10);

            // Keep filters for blade
            $filters = $request->only(['search','gender','is_insurance_user','is_referred','blood_type']);


            $path = public_path('formData/countries.json');
            $json = file_get_contents($path);
            $countries = json_decode($json, true);

             $path2 = public_path('formData/ethiopia_admin.json');
            $json2 = file_get_contents($path2);
            $ethiopian_admins = json_decode($json2, true);


            return view('patients.index', compact('patients','filters','countries','ethiopian_admins'));
        }
    

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        Patient::create($validated);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient Registered Successfully.');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $this->validateData($request, $patient->id);

        $patient->update($validated);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient Updated Successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return back()->with('success', 'Patient Deleted Successfully.');
    }

    private function validateData(Request $request, $id = null)
    {

        //dd($request);
        return $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'age' => 'nullable|numeric',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'country' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'zone' => 'nullable|string|max:255',
            'woreda' => 'nullable|string|max:255',
            'kebele' => 'nullable|string|max:255',
            'blood_type' => 'nullable|string|max:10',
            'is_referred' => 'nullable|boolean',
            'is_insurance_user' => 'nullable|boolean',
            'referred_from' => 'nullable|string|max:255',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
        ]);
    }
}