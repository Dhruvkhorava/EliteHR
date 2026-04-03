<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalaryComponent;
use App\Models\SalaryTemplate;
use Illuminate\Support\Facades\DB;

class PayrollSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Standard Salary Components
        $components = [
            ['name' => 'Basic Salary', 'type' => 'earning', 'is_taxable' => true, 'is_recurring' => true],
            ['name' => 'House Rent Allowance (HRA)', 'type' => 'earning', 'is_taxable' => true, 'is_recurring' => true],
            ['name' => 'Medical Allowance', 'type' => 'earning', 'is_taxable' => false, 'is_recurring' => true],
            ['name' => 'Conveyance Allowance', 'type' => 'earning', 'is_taxable' => false, 'is_recurring' => true],
            ['name' => 'Provident Fund (PF)', 'type' => 'deduction', 'is_taxable' => false, 'is_recurring' => true],
            ['name' => 'Professional Tax', 'type' => 'deduction', 'is_taxable' => false, 'is_recurring' => true],
        ];

        $componentIds = [];
        foreach ($components as $c) {
            $component = SalaryComponent::firstOrCreate(['name' => $c['name']], $c);
            $componentIds[$c['name']] = $component->id;
        }

        // 2. Create a Standard Monthly Template
        $template = SalaryTemplate::firstOrCreate(
            ['name' => 'Standard Monthly Template'],
            ['description' => 'Default salary structure for monthly employees', 'status' => 1]
        );

        // 3. Link Components to Template if not already linked
        $templateLinks = [
            ['name' => 'Basic Salary', 'amount_type' => 'percentage', 'amount_value' => 50],
            ['name' => 'House Rent Allowance (HRA)', 'amount_type' => 'percentage', 'amount_value' => 40],
            ['name' => 'Medical Allowance', 'amount_type' => 'fixed', 'amount_value' => 1250],
            ['name' => 'Provident Fund (PF)', 'amount_type' => 'percentage', 'amount_value' => 12],
        ];

        foreach ($templateLinks as $link) {
            $componentId = $componentIds[$link['name']];
            if (!$template->components()->where('salary_component_id', $componentId)->exists()) {
                $template->components()->attach($componentId, [
                    'amount_type' => $link['amount_type'],
                    'amount_value' => $link['amount_value'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 4. Generate sample payrolls for users
        $users = \App\Models\User::all();
        $months = [now()->month, now()->subMonth()->month];
        $year = now()->year;

        foreach ($users as $user) {
            foreach ($months as $month) {
                \App\Models\Payroll::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'month' => $month,
                        'year' => $year,
                    ],
                    [
                        'basic' => 50000,
                        'hra' => 15000,
                        'allowance' => 5000,
                        'bonus' => 2000,
                        'total_deduction' => 1200,
                        'net_salary' => 70800,
                        'status' => 'paid',
                    ]
                );
            }
        }
    }
}
