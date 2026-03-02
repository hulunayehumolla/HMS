<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::query();

        if ($request->status !== null && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $departments = $query->latest()->paginate(10);

        $stats = [
            'total' => Department::count(),
            'active' => Department::where('status', true)->count(),
            'inactive' => Department::where('status', false)->count(),
            'with_logo' => Department::whereNotNull('logo')->count(),
            'without_logo' => Department::whereNull('logo')->count()
        ];

        return view('departments.index', compact('departments', 'stats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:departments,name',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('departments', 'public');
        }

        Department::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Department created successfully!'
        ]);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully!'
        ]);
    }
    
}
