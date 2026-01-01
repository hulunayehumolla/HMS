<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Departmet_TeamLeader;
use App\Models\Colleg_Director;
use App\Models\Employee;
use App\Models\Student;
use App\Models\PasswordResetCode;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
        $this->middleware('permission:create-user', ['only' => ['create','store']]);
        $this->middleware('permission:edit-user', ['only' => ['changePassword','updatePassword']]);
        $this->middleware('permission:edit-user-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
    
      $users = User::join('employees', 'employees.emp_Id', '=', 'users.username')
        ->select(
            'users.*',
            'employees.emp_Fname',
            'employees.emp_Mname',
            'employees.emp_Lname'
        )
        ->get();
        return view('users.index', [
            'users' => $users,   
        ]);
     

    }

public function getUserDepartment(Request $request)
{
   $departments = Departmet_TeamLeader::where('coll_dir_Id', $request->collegeId)->orderBy('dept_team_Name', 'asc')->get();
    return response()->json([
        'departments' => $departments
    ]);
}

           
    public function viewStudetUser(Request $request){
         $colleges = Colleg_Director::all()->sortBy('coll_dir_Name');
          if(empty($request->studentDepartment) || empty($request->studentCollege)){
            return view('users.studentUser',['colleges'=>$colleges]);  
         }
         else{
         $users=User::join('students','students.stud_Id','=','users.username')
         ->where('stud_coll_Id','=',$request->studentCollege)
         ->where('stud_dept_Id','=',$request->studentDepartment)
         ->select('users.*','students.stud_Fname','students.stud_Mname','students.stud_Lname')->get();
         return view('users.studentUser', [
            'users' => $users,
            'colleges'=>$colleges,
         ]);
     }
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $colleges = Colleg_Director::all()->sortBy('coll_dir_Name');
        $departments = Departmet_TeamLeader::all()->sortBy('dept_team_Name')->groupBy('coll_dir_Id');
        return view('users.create', [
            'roles' => Role::pluck('name')->all(),
            'colleges'=>$colleges,
            'departments'=>$departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {

   /*      $data=$request->validate([
            'userId' => ['required', 'max:255'],
            'userFname' => ['required',  'max:255'],
            'userMname' => ['required',  'max:255'],
            'userLname' => ['required',  'max:255'],
            'userEmail' => ['required',  'max:255'],
            'username' => ['required',   'max:255', 'unique:users'],
            'password' => ['required', 'string',  'confirmed'],
            'college' => ['required',  'max:255'],
            'department' => ['required',  'max:255'],
            'type' => ['required',  'max:255'],
        ]);*/
        // dd($data);

         /*Insert into employee*/


                $employee = Employee::create([
                     'emp_Id' =>$request->userId ,
                     'emp_Fname' =>$request->userFname,
                     'emp_Mname'=>$request->userMname,
                     'emp_Lname'=>$request->userLname,
                     'emp_coll_dirId'=>$request->college,
                     'emp_dept_teamId'=>$request->department,
                    ]);
     
            

     $user = User::create([
           'username' =>$request->username ,
           'password' => Hash::make($request->password),
           'status' => "1",
           'profileable_type' => Employee::class,
           'profileable_id' => $employee->id,
        ]);
       
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
                ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): RedirectResponse
    {
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')){
            if($user->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        $employee=Employee::where('emp_Id',$user->username)->first();
         $student=Student::where('stud_Id',$user->username)->first();
        //$student=collect();
        return view('users.edit', [
            'user' => $user,
            'employee' => $employee,
           'student' => $student,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);
    }

 public function updateUserStatus(Request $request, User $user) {
         // Check for valid status (either 0 or 1)
        if (!in_array($request->status, [0, 1])) {
            return response()->json(['success' => false, 'message' => 'Invalid status value.'], 400);
         }
        // Update user status
        $user->status = $request->status;
        $user->failed_attempts = 0;// to update user atempts to login
        $user->save();
        PasswordResetCode::where('email', $user->email)->update(['code'=>"",'no_changes'=>0]); //password change limit
        // Return success response
        return response()->json(['success' => true]);
     }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse{    
        $user->syncRoles($request->roles);
         return redirect()->route('users.index')
            ->withSuccess('User Role is updated successfully..');
        }


   public function changePassword(User $user){
       if ($user->hasRole('Super Admin')){
            if($user->id != auth()->user()->id){
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        return view('users.changePassword', [
            'user' => $user,
            'roles' => Role::pluck('name')->all(),
            'userRoles' => $user->roles->pluck('name')->all()
        ]);

   }

// Inside UserController

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        // Validate the password
        $request->validate([
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);

        // Check if the user is trying to update the password of their own or a Super Admin user
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')
            ->withSuccess('Password updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)
        {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
                ->withSuccess('User is deleted successfully.');
    }




}