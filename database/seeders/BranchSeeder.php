<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            [
                'name' => 'Downtown Flagship',
                'city' => 'Cairo',
                'address' => '15 Tahrir Square, Downtown',
                'phone' => '+20 2 2790 0001',
                'map_link' => 'https://maps.google.com/?q=Downtown+Cairo',
                'image' => 'branches/downtown-flagship.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Seaside Arena',
                'city' => 'Alexandria',
                'address' => '42 Corniche Road, Gleem',
                'phone' => '+20 3 5840 0002',
                'map_link' => 'https://maps.google.com/?q=Alexandria+Corniche',
                'image' => 'branches/seaside-arena.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Oasis Health Club',
                'city' => 'Giza',
                'address' => '88 Pyramids Road, Al Haram',
                'phone' => '+20 2 3380 0003',
                'map_link' => 'https://maps.google.com/?q=Giza+Pyramids',
                'image' => 'branches/oasis-health-club.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::updateOrCreate(
                ['name' => $branch['name']],
                $branch
            );
        }
    }
}
