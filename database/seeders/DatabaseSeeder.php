<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            BranchSeeder::class,
            MembershipPlanSeeder::class,
            TrainerSeeder::class,
            GymClassSeeder::class,
            MemberSeeder::class,
            PartnerSeeder::class,
        ]);
    }
}
