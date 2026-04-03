<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Define all permissions
        $permissions = [
            // User Management
            'user.view', 'user.create', 'user.edit', 'user.delete',
            'hr.view', 'admin.view', 'employee.view',
            // Attendance
            'attendance.view', 'attendance.manage',
            // Leave Management
            'leave.apply', 'leave.approve', 'leave.view_all', 'leave_type.manage',
            // Payroll
            'payroll.manage', 'payroll.view_own', 'payroll.view',
            // Recruitment
            'view recruitment', 'recruitment.manage',
            // Performance
            'performance.view', 'performance.manage', 'goal.manage', 'appraisal.manage',
            // Documents
            'document.view', 'document.manage',
            // Mail
            'mail.view',
            // Settings & Roles
            'settings.view', 'settings.manage', 'roles.manage'
        ];

        // 2. Create permissions if they don't exist
        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // 3. Create/Update Super Admin Role
        $superAdminRole = Role::findOrCreate('super_admin');
        $superAdminRole->syncPermissions(Permission::all());

        // 4. Ensure other standard roles exist (optional, but good for completeness)
        Role::findOrCreate('admin');
        Role::findOrCreate('hr');
        Role::findOrCreate('employee');
        Role::findOrCreate('manager');

        // 5. Create/Update Super Admin User
        User::updateOrCreate(
            ['email' => 'superadmin@elitehr.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'status' => 1,
            ]
        )->assignRole('super_admin');
    }
}
