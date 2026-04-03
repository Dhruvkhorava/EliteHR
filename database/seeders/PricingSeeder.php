<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Starter Plan
        $starter = \App\Models\Pricing::updateOrCreate(
            ['name' => 'Starter'],
            [
                'price' => 0.00,
                'duration' => 'monthly',
                'status' => true,
                'is_featured' => false
            ]
        );
        $starter->features()->delete();
        $starter->features()->createMany([
            ['feature_name' => '10 Employees'],
            ['feature_name' => 'Basic Attendance'],
            ['feature_name' => 'Core HR Management'],
            ['feature_name' => 'Community Support'],
        ]);

        // Professional Plan
        $pro = \App\Models\Pricing::updateOrCreate(
            ['name' => 'Professional'],
            [
                'price' => 4999.00,
                'duration' => 'monthly',
                'status' => true,
                'is_featured' => true
            ]
        );
        $pro->features()->delete();
        $pro->features()->createMany([
            ['feature_name' => 'Up to 50 Employees'],
            ['feature_name' => 'Bulk Payroll Processing'],
            ['feature_name' => 'Statutory Compliance'],
            ['feature_name' => 'Shift Management'],
            ['feature_name' => 'Priority Email Support'],
        ]);

        // Enterprise Plan
        $enterprise = \App\Models\Pricing::updateOrCreate(
            ['name' => 'Enterprise'],
            [
                'price' => 12499.00,
                'duration' => 'monthly',
                'status' => true,
                'is_featured' => false
            ]
        );
        $enterprise->features()->delete();
        $enterprise->features()->createMany([
            ['feature_name' => 'Unlimited Employees'],
            ['feature_name' => 'Geofencing Attendance'],
            ['feature_name' => 'Advanced Recruitment (ATS)'],
            ['feature_name' => 'Full Performance Appraisals'],
            ['feature_name' => 'Dedicated Account Manager'],
        ]);
    }
}
