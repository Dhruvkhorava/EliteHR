<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;
use App\Models\LeaveBalance;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LeaveManagementSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Initialize Leave Types
        $leaveTypes = [
            ['name' => 'Annual Leave', 'days_allowed' => 20, 'is_paid' => true],
            ['name' => 'Sick Leave', 'days_allowed' => 10, 'is_paid' => true],
            ['name' => 'Casual Leave', 'days_allowed' => 12, 'is_paid' => true],
            ['name' => 'Maternity Leave', 'days_allowed' => 90, 'is_paid' => true],
            ['name' => 'Unpaid Leave', 'days_allowed' => 0, 'is_paid' => false],
        ];

        foreach ($leaveTypes as $lt) {
            LeaveType::firstOrCreate(['name' => $lt['name']], $lt);
        }

        // 2. Ensure basic Leave Balances for existing users if missing
        $users = User::all();
        $annualLeaveType = LeaveType::where('name', 'Annual Leave')->first();

        if ($annualLeaveType) {
            foreach ($users as $user) {
                if (!LeaveBalance::where('user_id', $user->id)->where('leave_type_id', $annualLeaveType->id)->exists()) {
                    LeaveBalance::create([
                        'user_id' => $user->id,
                        'leave_type_id' => $annualLeaveType->id,
                        'total' => $annualLeaveType->days_allowed,
                        'used' => 0,
                        'remaining' => $annualLeaveType->days_allowed,
                    ]);
                }

                // Create a few sample leaves for each user
                for ($i = 0; $i < 3; $i++) {
                    $fromDate = now()->addDays(rand(1, 30));
                    $toDate = (clone $fromDate)->addDays(rand(1, 3));
                    $totalDays = $fromDate->diffInDays($toDate) + 1;

                    \App\Models\Leave::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'from_date' => $fromDate->toDateString(),
                        ],
                        [
                            'to_date' => $toDate->toDateString(),
                            'leave_type_id' => $leaveTypes[rand(0, 4)]['id'] ?? $annualLeaveType->id,
                            'total_days' => $totalDays,
                            'reason' => 'Sample leave reason ' . ($i + 1),
                            'status' => ['pending', 'approved', 'rejected'][rand(0, 2)],
                        ]
                    );
                }
            }
        }
    }
}
