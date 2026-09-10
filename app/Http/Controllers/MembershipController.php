<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\MembershipPlan;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MembershipController extends Controller
{
    /**
     * Display all active branches with their membership plans and classes.
     */
    public function index(): View
    {
        $branches = Branch::active()
            ->with([
                'membershipPlans' => fn($q) => $q->active()->orderBy('price'),
                'gymClasses' => fn($q) => $q->active()->orderBy('start_time'),
            ])
            ->get();

        return view('pages.memberships', compact('branches'));
    }

    /**
     * Display the subscription checkout / confirmation screen.
     */
    public function checkout(MembershipPlan $plan): View
    {
        $plan->load('branch');
        $user = Auth::user();

        return view('pages.checkout', compact('plan', 'user'));
    }

    /**
     * Process member subscription confirmation.
     */
    public function subscribe(Request $request, MembershipPlan $plan): RedirectResponse
    {
        $user = Auth::user();

        // Ensure user has an associated member profile
        $member = $user->member;
        if (! $member) {
            $member = $user->member()->create();
        }

        // Create pending subscription request
        $subscription = Subscription::create([
            'member_id' => $member->id,
            'membership_plan_id' => $plan->id,
            'start_date' => now()->toDateString(),
            'status' => 'pending',
            'amount_paid' => $plan->price,
        ]);

        return redirect()->route('member.memberships')
            ->with('success', "Your subscription request for {$plan->branch->name} (" . str_replace('_', ' ', $plan->duration) . ") has been submitted successfully and is pending admin approval.");
    }
}
