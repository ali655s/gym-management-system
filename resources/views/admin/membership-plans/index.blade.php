@extends('layouts.admin')

@section('title', 'Membership Plans')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold">Membership Plans</h2>
    <a href="{{ route('admin.membership-plans.create') }}" class="bg-red-600 text-white px-4 py-2 rounded">Add New</a>
</div>

<table class="min-w-full bg-gray-800 rounded">
    <thead>
        <tr class="text-left">
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Branch</th>
            <th class="px-4 py-2">Duration</th>
            <th class="px-4 py-2">Price</th>
            <th class="px-4 py-2">Active</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($plans as $plan)
        <tr class="border-t border-gray-700">
            <td class="px-4 py-2">{{ $plan->id }}</td>
            <td class="px-4 py-2">{{ $plan->branch->name }}</td>
            <td class="px-4 py-2">{{ $plan->duration }}</td>
            <td class="px-4 py-2">${{ number_format($plan->price, 2) }}</td>
            <td class="px-4 py-2">{{ $plan->is_active ? 'Yes' : 'No' }}</td>
            <td class="px-4 py-2 space-x-2">
                <a href="{{ route('admin.membership-plans.edit', $plan) }}" class="text-blue-400">Edit</a>
                <a href="#" data-confirm data-confirm-message="Delete this plan?" data-confirm-action="{{ route('admin.membership-plans.destroy', $plan) }}" class="text-red-400">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $plans->links() }}
</div>
@endsection
