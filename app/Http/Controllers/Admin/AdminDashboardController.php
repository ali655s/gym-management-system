<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\FranchiseApplication;
use App\Models\Member;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin overview dashboard.
     */
    public function index(): View
    {
        $totalMembers = \App\Models\Member::count();

        $activeSubscriptions = \App\Models\Subscription::where('status', 'active')
            ->where('end_date', '>=', now())
            ->count();

        $totalRevenue = \App\Models\Subscription::whereIn('status', ['active', 'expired'])
            ->sum('amount_paid');

        $pendingFranchise = \App\Models\FranchiseApplication::where('status', 'pending')->count();

        $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();

        // Build monthly revenue + matching labels together, in the same loop, so they can never get out of sync
        $monthlyLabels = [];
        $monthlyRevenue = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $monthlyLabels[] = $date->format('M');

            $rev = \App\Models\Subscription::whereIn('status', ['active', 'expired'])
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount_paid');

            $monthlyRevenue[] = (float) $rev;
        }

        $recentSubscriptions = \App\Models\Subscription::with(['member.user', 'membershipPlan.branch'])
            ->latest('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMembers',
            'activeSubscriptions',
            'totalRevenue',
            'pendingFranchise',
            'unreadMessages',
            'monthlyLabels',
            'monthlyRevenue',
            'recentSubscriptions'
        ));
    }
}
