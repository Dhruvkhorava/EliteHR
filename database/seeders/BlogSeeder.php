<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'superadmin@elitehr.com')->first();
        if (!$admin) {
            $admin = User::first();
        }

        $blogs = [
            [
                'title' => 'Optimizing Remote Work with EliteHR Attendance',
                'category' => 'Workforce',
                'excerpt' => 'Discover how our geolocation and time-tracking features help manage remote teams effectively across global timezones.',
                'content' => 'Remote work is no longer just a perk; it is a fundamental shift in how businesses operate. With EliteHR’s advanced attendance module, managing a distributed workforce becomes seamless. Our platform leverages geolocation tagging and biometric synchronization to provide real-time visibility into employee activities. 

Key benefits include:
- Reduced time theft and improved accountability.
- Automated synchronization across different global timezones.
- Integration with payroll for accurate overtime calculation.
- Geofencing capabilities to ensure check-ins happen only at approved locations.

By implementing these features, HR teams can focus on strategic engagement rather than administrative tracking.',
                'is_published' => true,
                'published_at' => now(),
            ],
            [
                'title' => 'Simplifying Tax Compliance with EliteHR Payroll',
                'category' => 'Payroll',
                'excerpt' => 'Learn how automated tax deductions and payslip generation can save your HR team hours each month and eliminate errors.',
                'content' => 'Payroll management is one of the most critical yet complex functions within any organization. Tax laws and compliance requirements are constantly evolving, making manual processing a risky endeavor. EliteHR’s payroll engine is designed to handle these complexities with ease.

From automated income tax calculations (TDS) to statutory contributions like PF, ESI, and PT, our system ensures that every payslip is accurate and compliant. 

Key features include:
- One-click bulk payroll processing.
- Automated generation of Form 16 and other statutory reports.
- Flexible salary component configuration.
- Direct bank transfer batch generation.

Stop worrying about penalties and start empowering your finance team with EliteHR.',
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Finding Top Talent Fast: Digital Recruiting',
                'category' => 'Recruitment',
                'excerpt' => 'How EliteHR’s recruitment module streamlines candidate screening and conversion to employees through AI-driven matching.',
                'content' => 'In today’s competitive job market, speed and precision are everything. EliteHR’s recruitment module transforms the hiring lifecycle from a manual bottleneck into a strategic advantage. 

Our candidate management system (CMS) allows recruiters to track every applicant from application to onboarding in a single unified interface. 

What makes EliteHR different:
- AI-driven resume parsing and keyword matching.
- Collaborative interview scheduling with calendar integration.
- Automated candidate status updates and email templates.
- Seamless "Convert to Employee" functionality that migrates all data instantly.

Building your dream team should not take forever. Let EliteHR handle the heavy lifting while you focus on the people.',
                'is_published' => true,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($blogs as $blog) {
            Blog::updateOrCreate(
                ['slug' => Str::slug($blog['title'])],
                array_merge($blog, ['author_id' => $admin->id])
            );
        }
    }
}
