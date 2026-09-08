<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\GymClass;
use Illuminate\Database\Seeder;

class GymClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branchClasses = [
            'Downtown Flagship' => [
                [
                    'name' => 'Zumba',
                    'description' => 'Dynamic cardio dance fitness fusing Latin rhythms with interval training.',
                    'trainer_name' => 'Elena Rostova',
                    'start_time' => '09:00:00',
                    'end_time' => '10:00:00',
                    'days' => 'Mon, Wed, Fri',
                    'capacity' => 25,
                    'is_active' => true,
                ],
                [
                    'name' => 'CrossFit',
                    'description' => 'High-intensity functional movements combining gymnastics, weightlifting, and metabolic conditioning.',
                    'trainer_name' => 'Marcus Stone',
                    'start_time' => '18:00:00',
                    'end_time' => '19:30:00',
                    'days' => 'Sun, Tue, Thu',
                    'capacity' => 20,
                    'is_active' => true,
                ],
            ],
            'Seaside Arena' => [
                [
                    'name' => 'Zumba',
                    'description' => 'Upbeat party-style workout designed to torch calories and improve coordination.',
                    'trainer_name' => 'Elena Rostova',
                    'start_time' => '10:00:00',
                    'end_time' => '11:00:00',
                    'days' => 'Sun, Tue, Thu',
                    'capacity' => 20,
                    'is_active' => true,
                ],
                [
                    'name' => 'CrossFit',
                    'description' => 'Challenging WOD (Workout of the Day) sessions built for endurance and power.',
                    'trainer_name' => 'Marcus Stone',
                    'start_time' => '17:00:00',
                    'end_time' => '18:30:00',
                    'days' => 'Mon, Wed, Sat',
                    'capacity' => 18,
                    'is_active' => true,
                ],
            ],
            'Oasis Health Club' => [
                [
                    'name' => 'Zumba',
                    'description' => 'Fun and accessible cardio fitness dance class set to international pop and salsa.',
                    'trainer_name' => 'Elena Rostova',
                    'start_time' => '11:00:00',
                    'end_time' => '12:00:00',
                    'days' => 'Mon, Wed, Fri',
                    'capacity' => 30,
                    'is_active' => true,
                ],
                [
                    'name' => 'CrossFit',
                    'description' => 'Strength building and barbell complexes with Olympic lifting focus.',
                    'trainer_name' => 'David Miller',
                    'start_time' => '19:00:00',
                    'end_time' => '20:30:00',
                    'days' => 'Sun, Tue, Thu',
                    'capacity' => 25,
                    'is_active' => true,
                ],
            ],
        ];

        foreach ($branchClasses as $branchName => $classes) {
            $branch = Branch::where('name', $branchName)->first();

            if (! $branch) {
                continue;
            }

            foreach ($classes as $classData) {
                GymClass::updateOrCreate(
                    [
                        'branch_id' => $branch->id,
                        'name' => $classData['name'],
                    ],
                    $classData
                );
            }
        }
    }
}
