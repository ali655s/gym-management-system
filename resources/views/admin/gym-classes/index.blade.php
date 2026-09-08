@extends('layouts.admin')

@section('title', 'Gym Classes')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold">Gym Classes</h2>
    <a href="{{ route('admin.gym-classes.create') }}" class="bg-red-600 text-white px-4 py-2 rounded">Add New</a>
</div>

{{-- Filters --}}
<form method="GET" class="mb-4 flex space-x-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="p-2 bg-gray-700 rounded"/>
    <select name="branch_id" class="p-2 bg-gray-700 rounded">
        <option value="">All Branches</option>
        @foreach($branches as $branch)
            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="bg-gray-600 text-white px-3 rounded">Filter</button>
</form>

<table class="min-w-full bg-gray-800 rounded">
    <thead>
        <tr class="text-left">
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Branch</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Trainer</th>
            <th class="px-4 py-2">Days</th>
            <th class="px-4 py-2">Capacity</th>
            <th class="px-4 py-2">Active</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($classes as $class)
        <tr class="border-t border-gray-700">
            <td class="px-4 py-2">{{ $class->id }}</td>
            <td class="px-4 py-2">{{ $class->branch->name }}</td>
            <td class="px-4 py-2">{{ $class->name }}</td>
            <td class="px-4 py-2">{{ $class->trainer_name }}</td>
            <td class="px-4 py-2">{{ $class->days }}</td>
            <td class="px-4 py-2">{{ $class->capacity }}</td>
            <td class="px-4 py-2">{{ $class->is_active ? 'Yes' : 'No' }}</td>
            <td class="px-4 py-2 space-x-2">
                <a href="{{ route('admin.gym-classes.edit', $class) }}" class="text-blue-400">Edit</a>
                <a href="#" data-confirm data-confirm-message="Delete this class?" data-confirm-action="{{ route('admin.gym-classes.destroy', $class) }}" class="text-red-400">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $classes->links() }}
</div>
@endsection
