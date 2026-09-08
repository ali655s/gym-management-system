<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'Gymshark',
                'logo' => 'partners/gymshark.png',
                'website' => 'https://www.gymshark.com',
                'is_active' => true,
            ],
            [
                'name' => 'Optimum Nutrition',
                'logo' => 'partners/optimum-nutrition.png',
                'website' => 'https://www.optimumnutrition.com',
                'is_active' => true,
            ],
            [
                'name' => 'Nike Training',
                'logo' => 'partners/nike.png',
                'website' => 'https://www.nike.com',
                'is_active' => true,
            ],
        ];

        foreach ($partners as $partner) {
            Partner::updateOrCreate(
                ['name' => $partner['name']],
                $partner
            );
        }
    }
}
