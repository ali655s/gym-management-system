@extends('layouts.admin')

@section('title', 'Partners')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h2 class="text-xl font-semibold">Partners</h2>
    <a href="{{ route('admin.partners.create') }}" class="bg-red-600 text-white px-4 py-2 rounded">Add New</a>
</div>

{{-- Search --}}
<form method="GET" class="mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search partners..." class="p-2 bg-gray-700 rounded"/>
    <button type="submit" class="bg-gray-600 text-white px-3 rounded ml-2">Filter</button>
</form>

<table class="min-w-full bg-gray-800 rounded">
    <thead>
        <tr class="text-left">
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Website</th>
            <th class="px-4 py-2">Active</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($partners as $partner)
        <tr class="border-t border-gray-700">
            <td class="px-4 py-2">{{ $partner->id }}</td>
            <td class="px-4 py-2">{{ $partner->name }}</td>
            <td class="px-4 py-2"><a href="{{ $partner->website }}" target="_blank" class="text-blue-400">{{ $partner->website }}</a></td>
            <td class="px-4 py-2">{{ $partner->is_active ? 'Yes' : 'No' }}</td>
            <td class="px-4 py-2 space-x-2">
                <a href="{{ route('admin.partners.edit', $partner) }}" class="text-blue-400">Edit</a>
                <a href="#" data-confirm data-confirm-message="Delete this partner?" data-confirm-action="{{ route('admin.partners.destroy', $partner) }}" class="text-red-400">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $partners->links() }}
</div>
@endsection
