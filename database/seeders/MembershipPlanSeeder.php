<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pricing = [
            'Downtown Flagship' => [
                '1_month' => 60.00,
                '3_months' => 155.00,
                '6_months' => 280.00,
            ],
            'Seaside Arena' => [
                '1_month' => 45.00,
                '3_months' => 120.00,
                '6_months' => 220.00,
            ],
            'Oasis Health Club' => [
                '1_month' => 50.00,
                '3_months' => 135.00,
                '6_months' => 250.00,
            ],
        ];

        foreach ($pricing as $branchName => $plans) {
            $branch = Branch::where('name', $branchName)->first();

            if (! $branch) {
                continue;
            }

            foreach ($plans as $duration => $price) {
                MembershipPlan::updateOrCreate(
                    [
                        'branch_id' => $branch->id,
                        'duration' => $duration,
                    ],
                    [
                        'price' => $price,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
