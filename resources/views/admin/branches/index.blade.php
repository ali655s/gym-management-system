@extends('layouts.admin')

@section('title', 'Branches')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold">Branches</h2>
    <a href="{{ route('admin.branches.create') }}" class="bg-red-600 text-white px-4 py-2 rounded">Add New</a>
</div>

<table class="min-w-full bg-gray-800 rounded">
    <thead>
        <tr class="text-left">
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">City</th>
            <th class="px-4 py-2">Active</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($branches as $branch)
        <tr class="border-t border-gray-700">
            <td class="px-4 py-2">{{ $branch->id }}</td>
            <td class="px-4 py-2">{{ $branch->name }}</td>
            <td class="px-4 py-2">{{ $branch->city }}</td>
            <td class="px-4 py-2">{{ $branch->is_active ? 'Yes' : 'No' }}</td>
            <td class="px-4 py-2 space-x-2">
                <a href="{{ route('admin.branches.edit', $branch) }}" class="text-blue-400">Edit</a>
                <a href="#" data-confirm data-confirm-message="Delete this branch?" data-confirm-action="{{ route('admin.branches.destroy', $branch) }}" class="text-red-400">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $branches->links() }}
</div>
@endsection
