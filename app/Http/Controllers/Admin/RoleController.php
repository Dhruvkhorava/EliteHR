<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('name', '!=', 'super_admin')->get();
        return view('admin.roles.index', [
            'roles' => $roles,
            'catName' => 'settings',
            'title' => 'Roles & Permissions',
            'breadcrumbs' => ['Settings', 'Roles'],
        ]);
    }

    public function edit(Role $role)
    {
        if ($role->name === 'super_admin') {
            abort(403, 'The super_admin role cannot be modified.');
        }

        $permissions = Permission::all();
        
        // Group permissions by module
        $groupedPermissions = $this->groupPermissions($permissions);

        return view('admin.roles.edit', [
            'role' => $role,
            'groupedPermissions' => $groupedPermissions,
            'catName' => 'settings',
            'title' => 'Edit Role Permissions',
            'breadcrumbs' => ['Settings', 'Roles', 'Edit'],
        ]);
    }

    public function update(Request $request, Role $role)
    {
        if ($role->name === 'super_admin') {
            abort(403, 'The super_admin role cannot be modified.');
        }

        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index')->with('success', 'Role permissions updated successfully.');
    }

    private function groupPermissions($permissions)
    {
        $groups = [
            'Dashboard' => [],
            'User Management' => [],
            'Attendance' => [],
            'Leave Management' => [],
            'Payroll' => [],
            'Recruitment' => [],
            'Performance' => [],
            'Organization' => [],
            'Documents' => [],
            'Profile' => [],
            'Settings' => [],
            'Other' => [],
        ];

        foreach ($permissions as $permission) {
            $name = strtolower($permission->name);
            
            if (str_contains($name, 'analytics') || str_contains($name, 'sales') || str_contains($name, 'dashboard')) {
                $groups['Dashboard'][] = $permission;
            } elseif (str_contains($name, 'user.') || str_contains($name, 'admin.') || str_contains($name, 'hr.') || str_contains($name, 'employee.')) {
                $groups['User Management'][] = $permission;
            } elseif (str_contains($name, 'attendance.')) {
                $groups['Attendance'][] = $permission;
            } elseif (str_contains($name, 'leave.') || str_contains($name, 'leave_type.')) {
                $groups['Leave Management'][] = $permission;
            } elseif (str_contains($name, 'payroll.')) {
                $groups['Payroll'][] = $permission;
            } elseif (str_contains($name, 'recruitment') || str_contains($name, 'jobs') || str_contains($name, 'candidates') || str_contains($name, 'applications') || str_contains($name, 'interviews') || str_contains($name, 'convert')) {
                $groups['Recruitment'][] = $permission;
            } elseif (str_contains($name, 'performance.') || str_contains($name, 'goal.') || str_contains($name, 'appraisal.')) {
                $groups['Performance'][] = $permission;
            } elseif (str_contains($name, 'organization.')) {
                $groups['Organization'][] = $permission;
            } elseif (str_contains($name, 'document.')) {
                $groups['Documents'][] = $permission;
            } elseif (str_contains($name, 'profile.')) {
                $groups['Profile'][] = $permission;
            } elseif (str_contains($name, 'settings.') || str_contains($name, 'role.') || str_contains($name, 'permission.')) {
                $groups['Settings'][] = $permission;
            } else {
                $groups['Other'][] = $permission;
            }
        }

        // Remove empty groups
        return array_filter($groups, function($group) {
            return count($group) > 0;
        });
    }
}
