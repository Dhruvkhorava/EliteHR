<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Performance;
use App\Models\Appraisal;
use App\Models\Goal;
use App\Models\User;
use App\Models\Salary;
use Carbon\Carbon;

class PerformanceSeeder extends Seeder
{
    public function run(): void
    {
        // Get employees
        $users = User::role('employee')->get();
        
        // If no employees, try to get some users as fallback
        if ($users->isEmpty()) {
            $users = User::take(5)->get();
        }

        // Get an admin or HR for reviewer role
        $admin = User::role('admin')->first() ?: User::whereHas('roles', function($q){ $q->where('name', 'hr'); })->first() ?: User::first();

        if (!$admin || $users->isEmpty()) {
            return;
        }

        foreach ($users as $user) {
            // 1. Create Goals
            $goalCategories = [
                'Technical' => ['Master Laravel Ecosystem', 'Database Optimization', 'Security Hardening', 'API Integration'],
                'Soft Skills' => ['Effective Team Communication', 'Leadership Training', 'Client Relationship Management'],
                'Project-Specific' => ['EliteHR Payroll Module', 'Recruitment System Revamp', 'Performance Module Implementation'],
            ];

            foreach ($goalCategories as $category => $titles) {
                Goal::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'title' => $titles[array_rand($titles)],
                    ],
                    [
                        'description' => "Category: $category. Objective: " . fake()->paragraph(),
                        'target' => fake()->randomElement(['100% completion', '90% efficiency', 'Deliver within timeline', 'Exceed KPIs']),
                        'deadline' => Carbon::now()->addMonths(rand(1, 6))->toDateString(),
                        'status' => fake()->randomElement(['in_progress', 'completed', 'pending']),
                    ]
                );
            }

            // 2. Create Performance Reviews (Performances)
            $types = ['monthly', 'quarterly', 'yearly'];
            foreach ($types as $type) {
                $performance = Performance::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'review_date' => Carbon::now()->subMonths(rand(1, 4))->toDateString(),
                        'type' => $type,
                    ],
                    [
                        'reviewer_id' => $admin->id,
                        'rating' => rand(3, 5),
                        'feedback' => "Feedback for $type review: " . fake()->sentences(3, true),
                    ]
                );

                // 3. Create Appraisals (primarily for yearly or high-rated reviews)
                if ($type === 'yearly' || ($type === 'quarterly' && rand(0, 1))) {
                    $currentSalaryRecord = Salary::where('user_id', $user->id)->first();
                    $currentSalary = $currentSalaryRecord ? $currentSalaryRecord->ctc : rand(45000, 120000);
                    $increment = rand(5, 20);
                    $newSalary = $currentSalary * (1 + ($increment / 100));

                    Appraisal::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'performance_id' => $performance->id,
                        ],
                        [
                            'rating' => $performance->rating,
                            'increment_percentage' => $increment,
                            'previous_salary' => $currentSalary,
                            'new_salary' => $newSalary,
                            'effective_date' => Carbon::now()->addMonths(rand(1, 3))->startOfMonth()->toDateString(),
                            'status' => fake()->randomElement(['approved', 'pending']),
                        ]
                    );
                }
            }
        }
    }
}
