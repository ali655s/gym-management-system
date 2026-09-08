<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\Member;
use App\Models\MembershipPlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'member_id' => Member::factory(),
            'membership_plan_id' => MembershipPlan::factory(),
            'start_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['active', 'expired', 'cancelled']),
            // end_date and amount_paid will be auto-calculated by model booted method if null
        ];
    }
}
