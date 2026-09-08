<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MemberSubscriptionController extends Controller
{
    /**
     * Display the member's subscriptions and history.
     */
    public function index(): View
    {
        $user = Auth::user();
        $member = $user->member;

        if (! $member) {
            $member = $user->member()->create();
        }

        $activeSubscription = $member->activeSubscription()->with('membershipPlan.branch')->first();
        $subscriptions = $member->subscriptions()
            ->with('membershipPlan.branch')
            ->orderByDesc('created_at')
            ->get();

        return view('member.memberships', compact('member', 'activeSubscription', 'subscriptions'));
    }

    /**
     * Renew an existing subscription for the authenticated member.
     */
    public function renew(Subscription $subscription): RedirectResponse
    {
        $user = Auth::user();
        $member = $user->member;

        if (! $member || $subscription->member_id !== $member->id) {
            abort(403, 'Unauthorized. You can only renew your own subscriptions.');
        }

        $newSubscription = $subscription->renew();

        return redirect()->route('member.memberships')
            ->with('success', "Your {$newSubscription->membershipPlan->duration} subscription has been successfully renewed through {$newSubscription->end_date->format('M d, Y')}!");
    }
}
