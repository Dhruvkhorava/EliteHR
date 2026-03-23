<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecruitmentPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view recruitment',
            'manage jobs',
            'manage candidates',
            'manage applications',
            'schedule interviews',
            'convert to employee',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        $hr = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'HR']);
        $employee = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Employee']);

        $admin->givePermissionTo($permissions);
        $hr->givePermissionTo($permissions);
    }
}
