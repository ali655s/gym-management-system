<?php

namespace Database\Seeders;

use App\Models\Trainer;
use Illuminate\Database\Seeder;

class TrainerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainers = [
            [
                'name' => 'Marcus Stone',
                'specialty' => 'CrossFit & High-Intensity Conditioning',
                'bio' => 'Certified CrossFit Level 3 trainer with 8+ years specializing in functional strength and athletic agility.',
                'image' => 'trainers/marcus-stone.jpg',
                'instagram' => '@marcus_crossfit',
                'experience_years' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Elena Rostova',
                'specialty' => 'Zumba & Aerobics Dance',
                'bio' => 'International dance and rhythm fitness instructor known for high-octane, energizing group choreography.',
                'image' => 'trainers/elena-rostova.jpg',
                'instagram' => '@elena_dancefit',
                'experience_years' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'David Miller',
                'specialty' => 'Powerlifting & Hypertrophy',
                'bio' => 'Elite strength coach and former competitive powerlifter helping members build raw power and longevity.',
                'image' => 'trainers/david-miller.jpg',
                'instagram' => '@miller_iron',
                'experience_years' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($trainers as $trainer) {
            Trainer::updateOrCreate(
                ['name' => $trainer['name']],
                $trainer
            );
        }
    }
}
