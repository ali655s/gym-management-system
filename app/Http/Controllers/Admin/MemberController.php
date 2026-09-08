<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    /**
     * Display a listing of gym members (clients).
     */
    public function index(Request $request): View
    {
        $query = Member::with(['user', 'branch', 'activeSubscription.membershipPlan']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $members = $query->latest()->paginate(10)->withQueryString();
        $branches = Branch::orderBy('name')->get();

        return view('admin.members.index', compact('members', 'branches'));
    }

    /**
     * Display the specified member profile and subscription records.
     */
    public function show(Member $member): View
    {
        $member->load([
            'user',
            'branch',
            'subscriptions' => fn($q) => $q->with('membershipPlan.branch')->latest('start_date'),
        ]);

        return view('admin.members.show', compact('member'));
    }

    /**
     * Show the form for editing the member's gym status.
     */
    public function edit(Member $member): View
    {
        $member->load(['user', 'branch']);
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('admin.members.edit', compact('member', 'branches'));
    }

    /**
     * Update the member's branch or details in storage.
     */
    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'branch_id' => ['nullable', 'exists:branches,id'],
            'gender' => ['nullable', 'in:male,female,other'],
            'birth_date' => ['nullable', 'date'],
        ]);

        $member->update($validated);

        return redirect()->route('admin.members.show', $member->id)
            ->with('success', 'Member record updated successfully!');
    }
}
