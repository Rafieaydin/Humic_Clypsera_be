<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePremissionController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return response()->json([
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function create_role(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'api']);

        return response()->json([
            'message' => 'Role created successfully',
            'role' => $role,
        ]);
    }

    public function assign_permission(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);
        $role = Role::where('name', $request->role)->first();
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $permissions = Permission::whereIn('name', $request->permissions)->get();
        if ($permissions->isEmpty()) {
            return response()->json(['error' => 'Permissions not found'], 404);
        }

        $role->syncPermissions($permissions);

        return response()->json([
            'message' => 'Permissions assigned successfully',
            'role' => $role,
        ]);
    }

    public function remove_permission(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);

        $role = Role::where('name', $request->role)->first();
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $permissions = Permission::whereIn('name', $request->permissions)->get();
        if ($permissions->isEmpty()) {
            return response()->json(['error' => 'Permissions not found'], 404);
        }

        $role->revokePermissionTo($permissions);

        return response()->json([
            'message' => 'Permissions removed successfully',
            'role' => $role,
        ]);
    }

    public function delete_role(Request $request,  $role)
    {
        $role = Role::where('name', $role)->first();
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        $role->delete();

        return response()->json([
            'message' => 'Role deleted successfully',
        ]);
    }


}
