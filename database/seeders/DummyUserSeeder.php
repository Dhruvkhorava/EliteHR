<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['admin', 'hr', 'employee'];
        
        foreach ($roles as $role) {
            \App\Models\User::factory(50)->create()->each(function ($user) use ($role) {
                $user->assignRole($role);
            });
        }
    }
}
