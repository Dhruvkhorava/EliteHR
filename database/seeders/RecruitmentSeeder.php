<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RecruitmentJob;
use App\Models\Candidate;
use App\Models\Application;
use App\Models\Interview;
use App\Models\User;
use Carbon\Carbon;

class RecruitmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Sample Jobs
        $jobs = [
            [
                'title' => 'Senior Laravel Developer',
                'department' => 'IT / Development',
                'location' => 'Ahmedabad, Gujarat',
                'salary_range' => '$80k - $120k',
                'required_skills' => 'Laravel, PHP Core, Vue.js, MySQL, Redis',
                'description' => 'Looking for an experienced Laravel developer to join our core team.',
                'status' => 'open',
            ],
            [
                'title' => 'HR Manager',
                'department' => 'Human Resources',
                'location' => 'Remote',
                'salary_range' => '$60k - $90k',
                'required_skills' => 'Recruitment, Employee Relations, Payroll',
                'description' => 'Leading our HR efforts across multiple regions.',
                'status' => 'open',
            ],
            [
                'title' => 'UI/UX Designer',
                'department' => 'Creative',
                'location' => 'Surat, Gujarat',
                'salary_range' => '$50k - $80k',
                'required_skills' => 'Figma, Adobe XD, HTML/CSS',
                'description' => 'Design beautiful and intuitive user interfaces.',
                'status' => 'open',
            ],
        ];

        foreach ($jobs as $jobData) {
            RecruitmentJob::updateOrCreate(['title' => $jobData['title']], $jobData);
        }

        // 2. Create Sample Candidates
        $candidates = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone' => '+91 9876543210',
                'experience' => '5 Years',
                'skills' => 'PHP, Laravel, AWS',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.j@example.com',
                'phone' => '+91 8765432109',
                'experience' => '3 Years',
                'skills' => 'HR Operations, Talent Sourcing',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'mchen@example.com',
                'phone' => '+91 7654321098',
                'experience' => '7 Years',
                'skills' => 'Laravel, React, Node.js',
            ],
        ];

        foreach ($candidates as $candidateData) {
            Candidate::updateOrCreate(['email' => $candidateData['email']], $candidateData);
        }

        // 3. Create Applications
        $allJobs = RecruitmentJob::all();
        $allCandidates = Candidate::all();
        
        foreach ($allJobs as $index => $job) {
            if (isset($allCandidates[$index])) {
                Application::updateOrCreate(
                    [
                        'job_id' => $job->id,
                        'candidate_id' => $allCandidates[$index]->id,
                    ],
                    [
                        'status' => ['Applied', 'Interview Scheduled', 'Selected', 'Rejected'][rand(0, 3)],
                        'applied_at' => Carbon::now()->subDays(rand(1, 10)),
                    ]
                );
            }
        }

        // 4. Create Interviews for Scheduled Applications
        $scheduledApps = Application::where('status', 'interview_scheduled')->get();
        $admin = User::role('admin')->first();

        foreach ($scheduledApps as $app) {
            Interview::updateOrCreate(
                ['application_id' => $app->id],
                [
                    'interviewer_id' => $admin ? $admin->id : 1,
                    'date' => Carbon::now()->addDays(rand(1, 5))->toDateString(),
                    'time' => '11:00:00',
                    'status' => 'Scheduled',
                    'feedback' => 'Initial screening looks promising.',
                ]
            );
        }
    }
}
