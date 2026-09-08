<?php

namespace Database\Factories;

use App\Models\MembershipPlan;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MembershipPlan>
 */
class MembershipPlanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = MembershipPlan::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'branch_id' => Branch::factory(),
            'duration' => $this->faker->randomElement(['1_month', '3_months', '6_months']),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'is_active' => $this->faker->boolean,
        ];
    }
}
