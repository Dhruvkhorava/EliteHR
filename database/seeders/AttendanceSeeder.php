<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $daysToSeed = 30;
        $faker = \Faker\Factory::create();

        foreach ($users as $user) {
            for ($i = $daysToSeed; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                
                // Skip weekends for some variety, but maybe keep some "overtime" or "weekend work"
                if ($date->isWeekend() && rand(0, 100) > 20) {
                    continue;
                }

                // Randomize attendance
                if (rand(0, 100) > 10) { // 90% attendance rate
                    $this->createAttendance($user, $date, $faker);
                }
            }
        }
    }

    private function createAttendance($user, $date, $faker)
    {
        $dateStr = $date->toDateString();
        
        // Random check-in between 08:30 and 10:15
        $checkInHour = $faker->numberBetween(8, 9);
        $checkInMin = ($checkInHour == 8) ? $faker->numberBetween(30, 59) : $faker->numberBetween(0, 30);
        $checkIn = Carbon::parse("$dateStr $checkInHour:$checkInMin:00");

        // Random check-out between 17:00 and 19:30
        $checkOutHour = $faker->numberBetween(17, 18);
        $checkOutMin = $faker->numberBetween(0, 59);
        $checkOut = Carbon::parse("$dateStr $checkOutHour:$checkOutMin:00");

        // Break time between 30 and 60 minutes
        $breakSeconds = $faker->numberBetween(30, 60) * 60;
        
        $totalSeconds = $checkOut->diffInSeconds($checkIn, true);
        $workingSeconds = $totalSeconds - $breakSeconds;
        $workingHours = round($workingSeconds / 3600, 2);

        $status = 'present';
        if ($workingHours < 4.5) {
            $status = 'absent';
        } elseif ($workingHours < 7.5) {
            $status = 'half_day';
        }

        // Check for "late" status based on shift
        if ($user->shift) {
            $shiftStart = Carbon::parse($dateStr . ' ' . $user->shift->start_time)->addMinutes($user->shift->grace_period);
            if ($checkIn->greaterThan($shiftStart)) {
                $status = 'late';
            }
        }

        Attendance::updateOrCreate(
            ['user_id' => $user->id, 'date' => $dateStr],
            [
                'check_in' => $checkIn->toTimeString(),
                'check_out' => $checkOut->toTimeString(),
                'working_hours' => $workingHours,
                'status' => $status,
                'total_break_seconds' => $breakSeconds,
                'is_on_break' => false,
            ]
        );
    }
}
