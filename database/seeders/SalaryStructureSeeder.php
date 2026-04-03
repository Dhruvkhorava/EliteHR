<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalaryComponent;
use App\Models\SalaryTemplate;

class SalaryStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Earnings
        $basic = SalaryComponent::create([
            'name' => 'Basic',
            'type' => 'earning',
            'is_taxable' => true,
            'is_recurring' => true,
        ]);

        $hra = SalaryComponent::create([
            'name' => 'HRA',
            'type' => 'earning',
            'is_taxable' => true,
            'is_recurring' => true,
        ]);

        $allowance = SalaryComponent::create([
            'name' => 'Special Allowance',
            'type' => 'earning',
            'is_taxable' => true,
            'is_recurring' => true,
        ]);

        // Deductions
        $pf = SalaryComponent::create([
            'name' => 'Provident Fund (PF)',
            'type' => 'deduction',
            'is_taxable' => false,
            'is_recurring' => true,
        ]);

        $pt = SalaryComponent::create([
            'name' => 'Professional Tax (PT)',
            'type' => 'deduction',
            'is_taxable' => false,
            'is_recurring' => true,
        ]);

        // Create Template
        $template = SalaryTemplate::create([
            'name' => 'Standard Monthly Template',
            'description' => 'Default monthly salary structure for regular employees',
            'status' => 'active',
        ]);

        // Attach Components to Template
        $template->components()->attach($basic->id, ['amount_type' => 'percentage', 'amount_value' => 50]); // 50% of monthly CTC
        $template->components()->attach($hra->id, ['amount_type' => 'percentage', 'amount_value' => 20]);   // 20% of monthly CTC
        $template->components()->attach($allowance->id, ['amount_type' => 'percentage', 'amount_value' => 30]); // 30% of monthly CTC
        $template->components()->attach($pf->id, ['amount_type' => 'percentage', 'amount_value' => 12]);    // 12% of basic
        $template->components()->attach($pt->id, ['amount_type' => 'fixed', 'amount_value' => 200]);        // Fixed 200
    }
}
