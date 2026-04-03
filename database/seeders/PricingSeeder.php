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
        $free = \App\Models\Pricing::create([
            'name' => 'Free',
            'price' => 0.00,
            'duration' => 'monthly',
            'status' => true,
            'is_featured' => false
        ]);
        $free->features()->createMany([
            ['feature_name' => '10 Users'],
            ['feature_name' => 'Basic Support'],
            ['feature_name' => '5GB Storage'],
        ]);

        $pro = \App\Models\Pricing::create([
            'name' => 'Professional',
            'price' => 29.00,
            'duration' => 'monthly',
            'status' => true,
            'is_featured' => true
        ]);
        $pro->features()->createMany([
            ['feature_name' => 'Unlimited Users'],
            ['feature_name' => 'Priority Support'],
            ['feature_name' => '50GB Storage'],
            ['feature_name' => 'Advanced Analytics'],
        ]);

        $enterprise = \App\Models\Pricing::create([
            'name' => 'Enterprise',
            'price' => 99.00,
            'duration' => 'monthly',
            'status' => true,
            'is_featured' => false
        ]);
        $enterprise->features()->createMany([
            ['feature_name' => 'Custom solutions'],
            ['feature_name' => 'Dedicated Account Manager'],
            ['feature_name' => 'Unlimited Storage'],
            ['feature_name' => 'White-labeling'],
        ]);
    }
}
