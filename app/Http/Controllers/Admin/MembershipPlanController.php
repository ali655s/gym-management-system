<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\MembershipPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of membership plans.
     */
    public function index(Request $request): View
    {
        $query = MembershipPlan::with('branch');

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('duration')) {
            $query->where('duration', $request->duration);
        }

        $plans = $query->latest()->paginate(10)->withQueryString();
        $branches = Branch::orderBy('name')->get();

        return view('admin.membership-plans.index', compact('plans', 'branches'));
    }

    /**
     * Show the form for creating a new membership plan.
     */
    public function create(): View
    {
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('admin.membership-plans.create', compact('branches'));
    }

    /**
     * Store a newly created membership plan in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'duration' => ['required', 'in:1_month,3_months,6_months'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        MembershipPlan::create($validated);

        return redirect()->route('admin.membership-plans.index')
            ->with('success', 'Membership plan created successfully!');
    }

    /**
     * Show the form for editing the specified membership plan.
     */
    public function edit(MembershipPlan $membershipPlan): View
    {
        $branches = Branch::orderBy('name')->get();

        return view('admin.membership-plans.edit', compact('membershipPlan', 'branches'));
    }

    /**
     * Update the specified membership plan in storage.
     */
    public function update(Request $request, MembershipPlan $membershipPlan): RedirectResponse
    {
        $validated = $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'duration' => ['required', 'in:1_month,3_months,6_months'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $membershipPlan->update($validated);

        return redirect()->route('admin.membership-plans.index')
            ->with('success', 'Membership plan updated successfully!');
    }

    /**
     * Remove the specified membership plan from storage.
     */
    public function destroy(MembershipPlan $membershipPlan): RedirectResponse
    {
        $membershipPlan->delete();

        return redirect()->route('admin.membership-plans.index')
            ->with('success', 'Membership plan deleted successfully!');
    }
}
