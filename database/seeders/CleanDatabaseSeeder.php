<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Shift;
use App\Models\Attendance;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class CleanDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // $tables = [
        //     'users', 'shifts', 'attendances', 'leave_types', 'leaves', 'leave_balances',
        //     'recruitment_jobs', 'candidates', 'applications', 'interviews',
        //     'salaries', 'payrolls', 'payroll_details', 'goals', 'performances', 'appraisals',
        //     'roles', 'permissions', 'role_has_permissions', 'model_has_roles', 'model_has_permissions'
        // ];

        // foreach ($tables as $table) {
        //     if (Schema::hasTable($table)) {
        //         DB::table($table)->truncate();
        //     }
        // }

        Schema::enableForeignKeyConstraints();

        // 1. Roles & Permissions (5 Roles)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $permissionsList = [
            'user.view', 'user.create', 'user.edit', 'user.delete',
            'attendance.view', 'attendance.manage',
            'leave.apply', 'leave.approve', 'leave.view_all', 'leave_type.manage',
            'payroll.manage', 'view recruitment'
        ];
        foreach ($permissionsList as $pName) {
            Permission::create(['name' => $pName]);
        }

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $hrRole = Role::create(['name' => 'hr']);
        $hrRole->syncPermissions(['user.view', 'user.create', 'user.edit', 'attendance.view', 'attendance.manage', 'leave.apply', 'leave.view_all', 'payroll.manage', 'view recruitment']);

        $employeeRole = Role::create(['name' => 'employee']);
        $employeeRole->syncPermissions(['leave.apply', 'attendance.view']);

        Role::create(['name' => 'manager']);
        Role::create(['name' => 'intern']);

        // 2. Shifts (5 shifts)
        $shiftsData = [
            ['name' => 'General Shift', 'start_time' => '09:00:00', 'end_time' => '18:00:00', 'grace_period' => 15],
            ['name' => 'Morning Shift', 'start_time' => '06:00:00', 'end_time' => '15:00:00', 'grace_period' => 10],
            ['name' => 'Night Shift', 'start_time' => '22:00:00', 'end_time' => '07:00:00', 'grace_period' => 20],
            ['name' => 'Weekend Shift', 'start_time' => '10:00:00', 'end_time' => '16:00:00', 'grace_period' => 0],
            ['name' => 'Remote Shift', 'start_time' => '08:30:00', 'end_time' => '17:30:00', 'grace_period' => 30],
        ];
        foreach ($shiftsData as $s) {
            Shift::create($s);
        }
        $generalShift = Shift::first();

        // 3. Users (5 Users)
        $userData = [
            ['name' => 'Admin User', 'email' => 'admin@elitehr.com', 'role' => 'admin'],
            ['name' => 'HR Manager', 'email' => 'hr@elitehr.com', 'role' => 'hr'],
            ['name' => 'John Doe', 'email' => 'john@elitehr.com', 'role' => 'employee'],
            ['name' => 'Jane Smith', 'email' => 'jane@elitehr.com', 'role' => 'employee'],
            ['name' => 'Alex Brown', 'email' => 'alex@elitehr.com', 'role' => 'employee'],
        ];

        $createdUsers = [];
        foreach ($userData as $u) {
            $user = User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => Hash::make('password'),
                'shift_id' => $generalShift->id,
                'status' => 1,
            ]);
            $user->assignRole($u['role']);
            $createdUsers[] = $user;
        }

        // 4. Leave Types (5 types)
        $leaveTypeIds = [];
        $leaveTypesData = [
            ['name' => 'Annual Leave', 'days_allowed' => 20, 'is_paid' => true],
            ['name' => 'Sick Leave', 'days_allowed' => 10, 'is_paid' => true],
            ['name' => 'Casual Leave', 'days_allowed' => 12, 'is_paid' => true],
            ['name' => 'Maternity Leave', 'days_allowed' => 90, 'is_paid' => true],
            ['name' => 'Unpaid Leave', 'days_allowed' => 0, 'is_paid' => false],
        ];
        foreach ($leaveTypesData as $lt) {
            $leaveTypeIds[] = DB::table('leave_types')->insertGetId($lt + ['created_at' => now(), 'updated_at' => now()]);
        }

        // 5. Attendances (5 entries)
        for ($i = 0; $i < 5; $i++) {
            Attendance::create([
                'user_id' => $createdUsers[$i]->id,
                'date' => now()->toDateString(),
                'check_in' => '09:00:00',
                'status' => 'present',
                'working_hours' => 8.0,
            ]);
        }

        // 6. Recruitment Jobs (5 jobs)
        $jobIds = [];
        for ($i = 1; $i <= 5; $i++) {
            $jobIds[] = DB::table('recruitment_jobs')->insertGetId([
                'title' => 'Job Position ' . $i,
                'department' => 'Department ' . $i,
                'location' => 'Remote/Office',
                'salary_range' => '50k - 80k',
                'description' => 'Detailed description for job ' . $i,
                'required_skills' => 'Skill A, Skill B',
                'status' => 'open',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // 7. Candidates (5 candidates)
        $candidateIds = [];
        for ($i = 1; $i <= 5; $i++) {
            $candidateIds[] = DB::table('candidates')->insertGetId([
                'name' => 'Candidate ' . $i,
                'email' => 'candidate' . $i . '@example.com',
                'phone' => '987654321' . $i,
                'resume' => 'resume_' . $i . '.pdf',
                'experience' => $i . ' years',
                'skills' => 'PHP, Laravel, Vue',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // 8. Applications (5 applications)
        $appIds = [];
        for ($i = 0; $i < 5; $i++) {
            $appIds[] = DB::table('applications')->insertGetId([
                'job_id' => $jobIds[$i],
                'candidate_id' => $candidateIds[$i],
                'status' => 'Applied',
                'applied_at' => now(),
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // 9. Interviews (5 interviews)
        for ($i = 0; $i < 5; $i++) {
            DB::table('interviews')->insert([
                'application_id' => $appIds[$i],
                'interviewer_id' => $createdUsers[0]->id, // Admin
                'date' => now()->addDays($i + 1)->toDateString(),
                'time' => '10:00:00',
                'status' => 'Scheduled',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // 10. Salaries (5 records)
        foreach ($createdUsers as $user) {
            DB::table('salaries')->insert([
                'user_id' => $user->id,
                'basic' => 50000,
                'hra' => 15000,
                'allowance' => 5000,
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // 11. Payrolls (5 records)
        for ($i = 0; $i < 5; $i++) {
            DB::table('payrolls')->insert([
                'user_id' => $createdUsers[$i]->id,
                'month' => now()->month,
                'year' => now()->year,
                'basic' => 50000,
                'hra' => 15000,
                'allowance' => 5000,
                'bonus' => 2000,
                'total_deduction' => 1000,
                'net_salary' => 71000,
                'status' => 'paid',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // 12. Goals (5 goals)
        for ($i = 0; $i < 5; $i++) {
            DB::table('goals')->insert([
                'user_id' => $createdUsers[$i]->id,
                'title' => 'Performance Goal ' . ($i + 1),
                'description' => 'Target metrics for Q' . ($i + 1),
                'target' => 'Target ' . ($i + 1),
                'deadline' => now()->addMonths(2)->toDateString(),
                'status' => 'in_progress',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // 13. Performances (5 records)
        $perfIds = [];
        for ($i = 0; $i < 5; $i++) {
            $perfIds[] = DB::table('performances')->insertGetId([
                'user_id' => $createdUsers[$i]->id,
                'reviewer_id' => $createdUsers[0]->id,
                'rating' => 4,
                'feedback' => 'Good performance in current cycle',
                'review_date' => now()->toDateString(),
                'type' => 'monthly',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // 14. Appraisals (5 appraisals) - Linked to performances
        for ($i = 0; $i < 5; $i++) {
            DB::table('appraisals')->insert([
                'user_id' => $createdUsers[$i]->id,
                'performance_id' => $perfIds[$i],
                'rating' => 4,
                'increment_percentage' => 10.00,
                'previous_salary' => 60000.00,
                'new_salary' => 66000.00,
                'effective_date' => now()->addMonth()->toDateString(),
                'status' => 'approved',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // 15. Leaves (5 requests)
        for ($i = 0; $i < 5; $i++) {
            DB::table('leaves')->insert([
                'user_id' => $createdUsers[$i]->id,
                'leave_type_id' => $leaveTypeIds[$i % 5],
                'from_date' => now()->addDays($i + 5)->toDateString(),
                'to_date' => now()->addDays($i + 6)->toDateString(),
                'total_days' => 1,
                'reason' => 'Leave request ' . ($i + 1),
                'status' => 'pending',
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // 16. Leave Balances (5 records)
        for ($i = 0; $i < 5; $i++) {
            DB::table('leave_balances')->insert([
                'user_id' => $createdUsers[$i]->id,
                'leave_type_id' => $leaveTypeIds[0], // Annual Leave
                'total' => 20,
                'used' => 0,
                'remaining' => 20,
                'created_at' => now(), 'updated_at' => now()
            ]);
        }
    }
}
