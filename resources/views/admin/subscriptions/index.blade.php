@extends('layouts.admin')

@section('title', 'Subscriptions')

@section('content')
<h2 class="text-xl font-semibold mb-4">Subscriptions</h2>

<form method="GET" action="{{ route('admin.subscriptions.index') }}" class="flex space-x-2 mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search member or email" class="px-2 py-1 bg-gray-700 rounded" />
    <select name="branch_id" class="px-2 py-1 bg-gray-700 rounded">
        <option value="">All Branches</option>
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
        @endforeach
    </select>
    <select name="duration" class="px-2 py-1 bg-gray-700 rounded">
        <option value="">All Durations</option>
        <option value="1_month" {{ request('duration') == '1_month' ? 'selected' : '' }}>1 month</option>
        <option value="3_months" {{ request('duration') == '3_months' ? 'selected' : '' }}>3 months</option>
        <option value="6_months" {{ request('duration') == '6_months' ? 'selected' : '' }}>6 months</option>
    </select>
    <select name="status" class="px-2 py-1 bg-gray-700 rounded">
        <option value="">All Statuses</option>
        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
    </select>
    <button type="submit" class="bg-red-600 text-white px-3 rounded">Filter</button>
</form>

<table class="min-w-full bg-gray-800 text-gray-200">
    <thead>
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Member</th>
            <th class="px-4 py-2">Branch</th>
            <th class="px-4 py-2">Plan</th>
            <th class="px-4 py-2">Start</th>
            <th class="px-4 py-2">End</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Amount</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($subscriptions as $sub)
            <tr class="border-t border-gray-700">
                <td class="px-4 py-2">{{ $sub->id }}</td>
                <td class="px-4 py-2">{{ $sub->member->user->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $sub->membershipPlan->branch->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $sub->membershipPlan->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $sub->start_date->format('Y-m-d') }}</td>
                <td class="px-4 py-2">{{ $sub->end_date->format('Y-m-d') }}</td>
                <td class="px-4 py-2">{{ $sub->status }}</td>
                <td class="px-4 py-2">{{ $sub->amount_paid }}</td>
                <td class="px-4 py-2 space-x-2">
                    <form action="{{ route('admin.subscriptions.renew', $sub) }}" method="POST" class="inline" onsubmit="return confirm('Renew this subscription?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-green-400 hover:underline">Renew</button>
                    </form>
                    <form action="{{ route('admin.subscriptions.cancel', $sub) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this subscription?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-red-400 hover:underline">Cancel</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="9" class="px-4 py-2 text-center">No subscriptions found.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">{{ $subscriptions->links() }}</div>
@endsection
