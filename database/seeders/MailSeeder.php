<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mail;
use App\Models\User;
use Carbon\Carbon;

class MailSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $admin = User::role('admin')->first();

        // 1. Create Sample Inbox/Sent messages for Admin/Users
        foreach ($users as $user) {
            if ($admin && $user->id !== $admin->id) {
                // Sent to user from admin
                Mail::updateOrCreate(
                    [
                        'sender_id' => $admin->id,
                        'receiver_id' => $user->id,
                        'subject' => "Welcome to EliteHR, " . $user->name,
                    ],
                    [
                        'message' => "We are excited to have you on board. Please explore the platform and feel free to reach out to HR for any assistance.",
                        'is_read' => rand(0, 1),
                        'is_starred_receiver' => rand(0, 1),
                        'is_draft' => false,
                        'read_at' => Carbon::now()->subMinutes(rand(1, 1000)),
                    ]
                );

                // Sent to admin from user
                Mail::updateOrCreate(
                    [
                        'sender_id' => $user->id,
                        'receiver_id' => $admin->id,
                        'subject' => "Re: Welcome to EliteHR - Reply",
                    ],
                    [
                        'message' => "Thank you! I am enjoying the platform and am looking forward to contributing to the team.",
                        'is_read' => true,
                        'is_starred_receiver' => false,
                        'is_draft' => false,
                        'read_at' => Carbon::now()->subMinutes(5),
                    ]
                );

                // Draft from user
                Mail::updateOrCreate(
                    [
                        'sender_id' => $user->id,
                        'subject' => "Draft: Question regarding leave policy",
                    ],
                    [
                        'receiver_id' => $admin->id,
                        'message' => "Hi, I have a quick question about the Sick Leave policy regarding medical certificates...",
                        'is_read' => false,
                        'is_starred_sender' => true,
                        'is_draft' => true,
                    ]
                );
            }
        }
    }
}
