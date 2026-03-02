<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    /**
     * Show hospital profile form
     * Auto-load first hospital if exists
     */
    public function index()
    {
        $editHospital = Hospital::first(); // Load existing hospital if any

        return view('hospitals.index', compact('editHospital'));
    }


    /**
     * Store hospital (Only if none exists)
     */
    public function store(Request $request)
    {
        // Prevent multiple hospital records
        if (Hospital::exists()) {
            return redirect()
                ->route('hospitals.index')
                ->with('success', 'Hospital already exists. You can only update it.');
        }

        $validated = $this->validateData($request);

        // Handle Logo Upload
        if ($request->hasFile('logo')) {

            $folderPath = public_path('uploads/hospitals');

            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            $image = $request->file('logo');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->move($folderPath, $fileName);

            $validated['logo'] = 'uploads/hospitals/' . $fileName;
        }

        $validated['is_active'] = $request->boolean('is_active');

        Hospital::create($validated);

        return redirect()
            ->route('hospitals.index')
            ->with('success', 'Hospital Registered Successfully.');
    }


    /**
     * Update hospital profile
     */
    public function update(Request $request, Hospital $hospital)
    {
        $validated = $this->validateData($request, $hospital->id);

        if ($request->hasFile('logo')) {

            // Delete old logo
            if ($hospital->logo && file_exists(public_path($hospital->logo))) {
                unlink(public_path($hospital->logo));
            }

            $folderPath = public_path('uploads/hospitals');

            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0755, true);
            }

            $image = $request->file('logo');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->move($folderPath, $fileName);

            $validated['logo'] = 'uploads/hospitals/' . $fileName;
        }

        $validated['is_active'] = $request->boolean('is_active');

        $hospital->update($validated);

        return redirect()
            ->route('hospitals.index')
            ->with('success', 'Hospital Updated Successfully.');
    }


    /**
     * Optional: Delete hospital profile
     */
    public function destroy()
    {
        $hospital = Hospital::first();

        if (!$hospital) {
            return back()->with('success', 'No hospital record found.');
        }

        if ($hospital->logo && file_exists(public_path($hospital->logo))) {
            unlink(public_path($hospital->logo));
        }

        $hospital->delete();

        return redirect()
            ->route('hospitals.index')
            ->with('success', 'Hospital Deleted Successfully.');
    }


    /**
     * Validation Rules
     */
    private function validateData(Request $request, $id = null)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'nullable|unique:hospitals,registration_number,' . $id,
            'type' => 'required|string',
            'slogan' => 'nullable|string',
            'email' => 'required|email|unique:hospitals,email,' . $id,
            'phone_number' => 'required|string',
            'emergency_contact' => 'nullable|string',
            'country' => 'required|string',
            'zone' => 'required|string',
            'woreda' => 'required|string',
            'kebele' => 'required|string',
            'zip_code' => 'nullable|string',
            'capacity_beds' => 'nullable|integer|min:0',
            'website' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
    }
}