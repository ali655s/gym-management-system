@extends('layouts.admin')

@section('title', 'Members')

@section('content')
<h2 class="text-xl font-semibold mb-4">Members</h2>

<form method="GET" action="{{ route('admin.members.index') }}" class="flex space-x-2 mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email" class="px-2 py-1 bg-gray-700 rounded" />
    <select name="branch_id" class="px-2 py-1 bg-gray-700 rounded">
        <option value="">All Branches</option>
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-red-600 text-white px-3 rounded">Filter</button>
</form>

<table class="min-w-full bg-gray-800 text-gray-200">
    <thead>
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Branch</th>
            <th class="px-4 py-2">Active Plan</th>
            <th class="px-4 py-2">Expires</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($members as $member)
            <tr class="border-t border-gray-700">
                <td class="px-4 py-2">{{ $member->id }}</td>
                <td class="px-4 py-2">{{ $member->user->name }}</td>
                <td class="px-4 py-2">{{ $member->user->email }}</td>
                <td class="px-4 py-2">{{ $member->branch->name ?? '-' }}</td>
                <td class="px-4 py-2">
                    {{ optional(optional($member->activeSubscription)->membershipPlan)->name ?? '-' }}
                </td>
                <td class="px-4 py-2">
                    {{ optional($member->activeSubscription)->end_date ? $member->activeSubscription->end_date->format('Y-m-d') : '-' }}
                </td>
                <td class="px-4 py-2">
                    <a href="{{ route('admin.members.edit', $member) }}" class="text-red-400 hover:underline">Edit</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="px-4 py-2 text-center">No members found.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">{{ $members->links() }}</div>
@endsection
