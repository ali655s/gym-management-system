<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branch = Branch::where('name', 'Downtown Flagship')->first() ?? Branch::first();

        $user = User::updateOrCreate(
            ['email' => 'member@gym.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'role' => 'member',
                'phone' => '+20 10 1234 5678',
            ]
        );

        $member = Member::updateOrCreate(
            ['user_id' => $user->id],
            [
                'branch_id' => $branch?->id,
                'birth_date' => '1995-05-15',
                'gender' => 'male',
            ]
        );

        $plan = MembershipPlan::where('branch_id', $branch?->id)
            ->where('duration', '1_month')
            ->first() ?? MembershipPlan::first();

        if ($plan && ! $member->activeSubscription()->exists()) {
            Subscription::create([
                'member_id' => $member->id,
                'membership_plan_id' => $plan->id,
                'start_date' => Carbon::today()->toDateString(),
                'status' => 'active',
                'amount_paid' => $plan->price,
            ]);
        }
    }
}
