<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Member>
 */
class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // Ensure a user and branch exist
        $user = User::factory()->create();
        $branch = Branch::factory()->create();

        return [
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'birth_date' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
        ];
    }
}
