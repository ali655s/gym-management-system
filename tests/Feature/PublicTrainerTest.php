<?php

namespace Tests\Feature;

use App\Models\Trainer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicTrainerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_limits_trainers_to_three_using_query(): void
    {
        // Create 6 active trainers
        for ($i = 1; $i <= 6; $i++) {
            Trainer::create([
                'name' => "Coach {$i}",
                'specialty' => 'Fitness',
                'bio' => 'Bio info',
                'instagram' => "@coach{$i}",
                'experience_years' => 5,
                'is_active' => true,
            ]);
        }

        // Create 2 inactive trainers
        for ($i = 7; $i <= 8; $i++) {
            Trainer::create([
                'name' => "Coach {$i}",
                'specialty' => 'Fitness',
                'bio' => 'Bio info',
                'instagram' => "@coach{$i}",
                'experience_years' => 5,
                'is_active' => false,
            ]);
        }

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewHas('trainers', function ($trainers) {
            return $trainers->count() === 3;
        });

        // Ensure "Show All Coaches" button is present and links to route('trainers.index')
        $response->assertSee(route('trainers.index'));
    }

    public function test_public_trainers_page_displays_all_active_trainers(): void
    {
        // Create 5 active trainers
        for ($i = 1; $i <= 5; $i++) {
            Trainer::create([
                'name' => "Active Coach {$i}",
                'specialty' => 'Conditioning',
                'bio' => 'Active coach bio',
                'instagram' => "@active{$i}",
                'experience_years' => 4,
                'is_active' => true,
            ]);
        }

        // Create 2 inactive trainers
        for ($i = 1; $i <= 2; $i++) {
            Trainer::create([
                'name' => "Inactive Hidden Trainer {$i}",
                'specialty' => 'Hidden',
                'bio' => 'Hidden bio',
                'instagram' => "@hidden{$i}",
                'experience_years' => 2,
                'is_active' => false,
            ]);
        }

        $response = $this->get(route('trainers.index'));

        $response->assertOk();
        $response->assertViewIs('pages.trainers');
        $response->assertViewHas('trainers', function ($trainers) {
            return $trainers->count() === 5;
        });

        for ($i = 1; $i <= 5; $i++) {
            $response->assertSee("Active Coach {$i}");
        }

        $response->assertDontSee('Inactive Hidden Trainer');
    }

    public function test_public_trainers_page_preserves_trainer_details(): void
    {
        Trainer::create([
            'name' => 'Captain Ahmed',
            'specialty' => 'Olympic Weightlifting',
            'bio' => 'National champion with extensive coaching background.',
            'instagram' => '@ahmed_coach',
            'experience_years' => 8,
            'is_active' => true,
        ]);

        $response = $this->get(route('trainers.index'));

        $response->assertOk();
        $response->assertSee('Captain Ahmed');
        $response->assertSee('Olympic Weightlifting');
        $response->assertSee('National champion with extensive coaching background.');
        $response->assertSee('@ahmed_coach');
        $response->assertSee('8+ Yrs Experience');
        $response->assertSee(route('memberships.index'));
    }
}
