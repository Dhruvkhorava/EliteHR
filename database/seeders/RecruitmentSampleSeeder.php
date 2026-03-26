<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RecruitmentJob;
use App\Models\Candidate;
use App\Models\Application;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RecruitmentSampleSeeder extends Seeder
{
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        RecruitmentJob::truncate();
        Candidate::truncate();
        Application::truncate();
        Interview::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Create Sample Jobs
        $jobs = [
            [
                'title' => 'Senior Laravel Developer',
                'department' => 'IT / Development',
                'location' => 'Ahmedabad, Gujarat',
                'salary_range' => '$80k - $120k',
                'required_skills' => 'Laravel, PHP Core, Vue.js, MySQL, Redis',
                'description' => 'We are looking for an experienced Laravel developer to join our core team. You will be responsible for building scalable backend systems.',
                'status' => 'open',
            ],
            [
                'title' => 'HR Manager',
                'department' => 'Human Resources',
                'location' => 'Remote',
                'salary_range' => '$60k - $90k',
                'required_skills' => 'Recruitment, Employee Relations, Payroll, Compliance',
                'description' => 'Leading our HR efforts across multiple regions. Responsible for talent acquisition and company culture.',
                'status' => 'open',
            ],
            [
                'title' => 'UI/UX Designer',
                'department' => 'Creative',
                'location' => 'Surat, Gujarat',
                'salary_range' => '$50k - $80k',
                'required_skills' => 'Figma, Adobe XD, HTML/CSS, Responsive Design',
                'description' => 'Design beautiful and intuitive user interfaces for our enterprise HR platform.',
                'status' => 'open',
            ],
        ];

        foreach ($jobs as $jobData) {
            RecruitmentJob::create($jobData);
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

        $createdCandidates = [];
        foreach ($candidates as $candidateData) {
            $createdCandidates[] = Candidate::create($candidateData);
        }

        // 3. Create Applications
        $allJobs = RecruitmentJob::all();
        
        // Link John to Senior Laravel Job
        $app1 = Application::create([
            'job_id' => $allJobs[0]->id,
            'candidate_id' => $createdCandidates[0]->id,
            'status' => 'Interview Scheduled',
            'applied_at' => now()->subDays(5),
        ]);

        // Link Sarah to HR Manager Job
        $app2 = Application::create([
            'job_id' => $allJobs[1]->id,
            'candidate_id' => $createdCandidates[1]->id,
            'status' => 'Screening',
            'applied_at' => now()->subDays(2),
        ]);

        // Link Michael to UI/UX Job
        $app3 = Application::create([
            'job_id' => $allJobs[2]->id,
            'candidate_id' => $createdCandidates[2]->id,
            'status' => 'Selected',
            'applied_at' => now()->subDays(10),
        ]);

        // 4. Create Interviews
        $admin = User::role('admin')->first();
        if ($admin) {
            Interview::create([
                'application_id' => $app1->id,
                'interviewer_id' => $admin->id,
                'date' => now()->addDays(2)->format('Y-m-d'),
                'time' => '11:00:00',
                'status' => 'Scheduled',
                'feedback' => 'Candidate looks promising from the initial screening.',
            ]);
        }
    }
}
