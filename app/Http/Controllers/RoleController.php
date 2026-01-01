<?php

namespace App\Http\Controllers;

use App\Http\Requests\Roles\StoreRoleRequest;
use App\Http\Requests\Roles\UpdateRoleRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index','show']]);
        $this->middleware('permission:create-role', ['only' => ['create','store']]);
        $this->middleware('permission:edit-role', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
      $roles= Role::with('permissions')->orderBy('id', 'DESC')->get();
        return view('roles.index', ['roles' => $roles,]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View{
    $permissions = Permission::all();
    $groupedPermissions = $permissions->groupBy('groupName'); // Assuming 'group' is a field in your permissions table
    return view('roles.create', compact('groupedPermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = Role::create(['name' => $request->name]);

        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
                ->withSuccess('New role is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(): RedirectResponse
    {
        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
  public function edit(Role $role)
{
    if ($role->name == 'Super Admin') {
        abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
    }

    $rolePermissions = DB::table("role_has_permissions")
        ->where("role_id", $role->id)
        ->pluck('permission_id')
        ->all();

    // Group permissions by their groupName
    $groupedPermissions = Permission::all()->groupBy('groupName');

    return view('roles.edit', [
        'role' => $role,
        'permissions' => Permission::all(),
        'rolePermissions' => $rolePermissions,
        'groupedPermissions' => $groupedPermissions
    ]);
}



    /**
     * Update the specified resource in storage.
     */
 public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
{
    // Only update the role name
    $input = $request->only('name');
    $role->update($input);

    // If no permissions are provided in the request, sync to an empty array to remove all permissions
    if ($request->permissions) {
        $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
        $role->syncPermissions($permissions);
    } else {
        // If no permissions are selected, remove all permissions from the role
        $role->syncPermissions([]);
    }
    
    return redirect()->route('roles.index')
        ->withSuccess('Role is updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if(auth()->user()->hasRole($role->name)){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();
        return redirect()->route('roles.index')
                ->withSuccess('Role is deleted successfully.');
    }
}