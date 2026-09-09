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
            <th class="px-4 py-2">Image</th>
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
            <td class="px-4 py-2">
                @if($trainer->image)
                    <img src="{{ asset('storage/' . $trainer->image) }}" alt="{{ $trainer->name }}" class="w-10 h-10 object-cover rounded-full">
                @else
                    <span class="text-gray-400 text-xs">No Image</span>
                @endif
            </td>
            <td class="px-4 py-2">{{ $trainer->name }}</td>
            <td class="px-4 py-2">{{ $trainer->specialty }}</td>
            <td class="px-4 py-2">{{ $trainer->experience_years }}</td>
            <td class="px-4 py-2">{{ $trainer->is_active ? 'Yes' : 'No' }}</td>
            <td class="px-4 py-2 space-x-2 flex items-center">
                <a href="{{ route('admin.trainers.edit', $trainer) }}" class="text-blue-400 mr-2">Edit</a>

                {{-- Form الحذف الصحيح --}}
                <form action="{{ route('admin.trainers.destroy', $trainer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this trainer?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-400 hover:text-red-600 bg-transparent border-0 p-0 cursor-pointer">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $trainers->links() }}
</div>
@endsection
