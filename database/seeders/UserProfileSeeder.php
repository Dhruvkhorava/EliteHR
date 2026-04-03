<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        foreach ($users as $user) {
            if (empty($user->first_name)) {
                $name = $user->name;
                $parts = explode(' ', $name, 2);
                $user->first_name = $parts[0];
                $user->last_name = $parts[1] ?? ' ';
                // Also set other profile fields with dummy data for existing users to pass validation
                $user->date_of_birth = '1990-01-01';
                $user->gender = 'male';
                $user->address = 'Temporary Address';
                $user->city = 'City';
                $user->state = 'State';
                $user->country = 'Country';
                $user->pincode = '000000';
                $user->save();
            }
        }
    }
}
