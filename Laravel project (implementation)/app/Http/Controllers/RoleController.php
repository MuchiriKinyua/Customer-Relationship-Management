<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Flash;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::get();
        return view('roles.index', [
            'roles' => $roles
        ]);    
    }
    public function create(){
        return view('roles.create');
    }
    public function store(Request $request){
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
            ]);
            Role::create([
                'name' => $request->name
            ]);
            return redirect('roles')->with('status','Role Created Successfully');
    }
    public function edit(Role $role){
        return view('roles.edit',[
            'role' => $role
        ]);
    }
    public function update(Request $request, Role $role){
        $request->validate([
            'name' => [
            'required',
            'string',
            'unique:roles,name,'.$role->id
        ]
        ]);
        $role->update([
            'name' => $request->name
        ]);
        return redirect('roles')->with('status','Role Updated Successfully');
    }
    public function destroy($roleId){
        $role = Role::find($roleId);
        $role->delete();
        return redirect('roles')->with('status','Role Deleted Successfully');
    }
    public function addPermissionToRole($roleId){
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
                                ->where('role_has_permissions.role_id', $role->id)
                                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                ->all();

        return view('roles.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }
    public function givePermissionToRole(Request $request, $roleId) {
        $request->validate([
            'permission' => 'required|array'
        ]);
        
        $role = Role::findOrFail($roleId);
        $permissions = Permission::whereIn('name', $request->permission)->get();
    
        // Sync permissions
        $role->syncPermissions($permissions);
    
        return redirect()->back()->with('status', 'Permissions updated successfully');
    }
    
    
}