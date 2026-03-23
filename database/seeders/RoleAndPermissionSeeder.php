<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User Management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            
            // Attendance
            'attendance.view',
            'attendance.manage',
            
            // Leave Management
            'leave.apply',
            'leave.approve',
            'leave.view_all',
            'leave_type.manage',
            
            // Payroll
            'payroll.manage',
            
            // Recruitment
            'view recruitment',
            'manage jobs',
            'manage candidates',
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdminRole = Role::updateOrCreate(['name' => 'super_admin']);
        $superAdminRole->syncPermissions(Permission::all());

        $adminRole = Role::updateOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $hrRole = Role::updateOrCreate(['name' => 'hr']);
        $hrRole->syncPermissions([
            'user.view',
            'user.create',
            'user.edit',
            'attendance.view',
            'attendance.manage',
            'leave.apply',
            'leave.view_all',
            'payroll.manage',
            'view recruitment',
            'manage jobs',
            'manage candidates',
        ]);

        $employeeRole = Role::updateOrCreate(['name' => 'employee']);
        $employeeRole->syncPermissions([
            'leave.apply',
            'attendance.view',
        ]);

        // Create/Update default users
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@elitehr.com'],
            [
                'name' => 'Super Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        $admin = User::updateOrCreate(
            ['email' => 'admin@elitehr.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($adminRole);

        $hr = User::updateOrCreate(
            ['email' => 'hr@elitehr.com'],
            [
                'name' => 'HR User',
                'password' => Hash::make('password'),
            ]
        );
        $hr->assignRole($hrRole);

        $employee = User::updateOrCreate(
            ['email' => 'employee@elitehr.com'],
            [
                'name' => 'Employee User',
                'password' => Hash::make('password'),
            ]
        );
        $employee->assignRole($employeeRole);
    }
}
