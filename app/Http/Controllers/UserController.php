<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Staff;
use App\Models\PasswordResetCode;
use App\Models\Departmet_TeamLeader;
use App\Models\Colleg_Director;

use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;

use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user', ['only' => ['changePassword','updatePassword']]);
        $this->middleware('permission:edit-user-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display Users (Staff)
     */
    public function index(Request $request): View
    {
        $users = User::join('staff', 'staff.staff_id', '=', 'users.username')
            ->select(
                'users.*',
                'staff.first_name',
                'staff.middle_name',
                'staff.last_name'
            )
            ->get();

        return view('users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Ajax: Get Departments
     */
    public function getUserDepartment(Request $request)
    {
        $departments = Departmet_TeamLeader::where('coll_dir_Id', $request->collegeId)
            ->orderBy('dept_team_Name', 'asc')
            ->get();

        return response()->json([
            'departments' => $departments
        ]);
    }

    /**
     * View Student Users
     */
    public function viewStudetUser(Request $request)
    {
        $colleges = Colleg_Director::all()->sortBy('coll_dir_Name');

        if (empty($request->studentDepartment) || empty($request->studentCollege)) {
            return view('users.studentUser', ['colleges' => $colleges]);
        }

        $users = User::join('students','students.stud_Id','=','users.username')
            ->where('stud_coll_Id','=',$request->studentCollege)
            ->where('stud_dept_Id','=',$request->studentDepartment)
            ->select('users.*','students.stud_Fname','students.stud_Mname','students.stud_Lname')
            ->get();

        return view('users.studentUser', [
            'users' => $users,
            'colleges' => $colleges,
        ]);
    }

    /**
     * Show Create Form
     */
    public function create(): View
    {
        $colleges = Colleg_Director::all()->sortBy('coll_dir_Name');
        $departments = Departmet_TeamLeader::all()
            ->sortBy('dept_team_Name')
            ->groupBy('coll_dir_Id');

        return view('users.create', [
            'roles' => Role::pluck('name')->all(),
            'colleges' => $colleges,
            'departments' => $departments
        ]);
    }

    /**
     * Store New User (Staff)
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        // Create Staff
        $staff = Staff::create([
            'staff_id'  => $request->userId,
            'first_name'  => $request->userFname,
            'middel_name' => $request->userMname,
            'last_name'   => $request->userLname,
        ]);

        // Create User
        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'status'   => "1",
            'profileable_type' => Staff::class,
            'profileable_id'   => $staff->id,
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->withSuccess('New user is added successfully.');
    }

    /**
     * Redirect show
     */
    public function show(User $user): RedirectResponse
    {
        return redirect()->route('users.index');
    }

    /**
     * Edit User
     */
    public function edit(User $user): View
    {
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        $staff = Staff::where('staff_id', $user->username)->first();

        return view('users.edit', [
            'user' => $user,
            'employee' => $staff,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update User Status
     */
    public function updateUserStatus(Request $request, User $user)
    {
        if (!in_array($request->status, [0, 1])) {
            return response()->json(['success' => false, 'message' => 'Invalid status value.'], 400);
        }

        $user->status = $request->status;
        $user->failed_attempts = 0;
        $user->save();

        PasswordResetCode::where('email', $user->email)
            ->update(['code' => "", 'no_changes' => 0]);

        return response()->json(['success' => true]);
    }

    /**
     * Update Role
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->syncRoles($request->roles);

        return redirect()->route('users.index')
            ->withSuccess('User Role is updated successfully.');
    }

    /**
     * Change Password View
     */
    public function changePassword(User $user)
    {
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('users.changePassword', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

    /**
     * Update Password
     */
    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);

        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->withSuccess('Password updated successfully.');
    }

    /**
     * Delete User
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();

        return redirect()->route('users.index')
            ->withSuccess('User is deleted successfully.');
    }
}
