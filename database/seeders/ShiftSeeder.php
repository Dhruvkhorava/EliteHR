<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;
use App\Models\User;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        $shift = Shift::updateOrCreate(
            ['name' => 'General Shift'],
            [
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'grace_period' => 15,
            ]
        );

        User::query()->update(['shift_id' => $shift->id]);
    }
}
