@extends('layouts.admin')

@section('title', 'Trainers')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold">Trainers</h2>
    <a href="{{ route('admin.trainers.create') }}" class="bg-red-600 text-white px-4 py-2 rounded">Add New</a>
</div>

<table class="min-w-full bg-gray-800 rounded">
    <thead>
        <tr class="text-left">
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Specialty</th>
            <th class="px-4 py-2">Experience (years)</th>
            <th class="px-4 py-2">Active</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($trainers as $trainer)
        <tr class="border-t border-gray-700">
            <td class="px-4 py-2">{{ $trainer->id }}</td>
            <td class="px-4 py-2">{{ $trainer->name }}</td>
            <td class="px-4 py-2">{{ $trainer->specialty }}</td>
            <td class="px-4 py-2">{{ $trainer->experience_years }}</td>
            <td class="px-4 py-2">{{ $trainer->is_active ? 'Yes' : 'No' }}</td>
            <td class="px-4 py-2 space-x-2">
                <a href="{{ route('admin.trainers.edit', $trainer) }}" class="text-blue-400">Edit</a>
                <a href="#" data-confirm data-confirm-message="Delete this trainer?" data-confirm-action="{{ route('admin.trainers.destroy', $trainer) }}" class="text-red-400">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $trainers->links() }}
</div>
@endsection
