@extends('layouts.admin')

@section('title', 'Add Trainer')

@section('content')
<h2 class="text-xl font-semibold mb-4">Add New Trainer</h2>
<form action="{{ route('admin.trainers.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
    @csrf
    <div>
        <label class="block text-gray-300">Name</label>
        <input type="text" name="name" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Specialty</label>
        <input type="text" name="specialty" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('specialty')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Bio</label>
        <textarea name="bio" class="w-full mt-1 p-2 bg-gray-700 rounded"></textarea>
        @error('bio')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Image</label>
        <input type="file" name="image" class="w-full mt-1 p-2 bg-gray-700 rounded">
        @error('image')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Instagram</label>
        <input type="text" name="instagram" class="w-full mt-1 p-2 bg-gray-700 rounded">
        @error('instagram')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Experience Years</label>
        <input type="number" name="experience_years" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('experience_years')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" class="form-checkbox text-red-600" checked>
            <span class="ml-2 text-gray-300">Active</span>
        </label>
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Create Trainer</button>
</form>
@endsection
