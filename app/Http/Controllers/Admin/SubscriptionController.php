<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    /**
     * Display all subscriptions with filtering and search.
     */
    public function index(Request $request): View
    {
        $query = Subscription::with(['member.user', 'membershipPlan.branch']);

        if ($request->filled('branch_id')) {
            $branchId = $request->branch_id;
            $query->whereHas('membershipPlan', function ($q) use ($branchId) {
                $q->where('branch_id', $branchId);
            });
        }

        if ($request->filled('duration')) {
            $duration = $request->duration;
            $query->whereHas('membershipPlan', function ($q) use ($duration) {
                $q->where('duration', $duration);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $subscriptions = $query->latest('id')->paginate(15)->withQueryString();
        $branches = Branch::orderBy('name')->get();

        return view('admin.subscriptions.index', compact('subscriptions', 'branches'));
    }

    /**
     * Approve a pending subscription request, activate it, and assign the selected branch to the member.
     */
    public function approve(Subscription $subscription): RedirectResponse
    {
        $plan = $subscription->membershipPlan;
        $member = $subscription->member;

        $startDate = Carbon::today()->toDateString();
        $months = $plan->durationInMonths();
        $endDate = Carbon::parse($startDate)->addMonths($months)->toDateString();

        $subscription->update([
            'status' => 'active',
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        // Automatically assign the subscription's selected branch to the member
        $member->update([
            'branch_id' => $plan->branch_id,
        ]);

        return redirect()->back()
            ->with('success', "Subscription #{$subscription->id} for {$member->user->name} has been approved and activated! Member branch updated to {$plan->branch->name}.");
    }

    /**
     * Reject a pending subscription request.
     */
    public function reject(Subscription $subscription): RedirectResponse
    {
        $subscription->update(['status' => 'rejected']);

        return redirect()->back()
            ->with('success', "Subscription request #{$subscription->id} has been rejected.");
    }

    /**
     * Renew an existing subscription on behalf of a member.
     */
    public function renew(Subscription $subscription): RedirectResponse
    {
        $newSub = $subscription->renew();

        return redirect()->back()
            ->with('success', "Subscription renewed successfully! New pass active through {$newSub->end_date->format('M d, Y')}.");
    }

    /**
     * Cancel an active or pending subscription.
     */
    public function cancel(Subscription $subscription): RedirectResponse
    {
        $subscription->update(['status' => 'cancelled']);

        return redirect()->back()
            ->with('success', "Subscription #{$subscription->id} has been marked as cancelled.");
    }
}
