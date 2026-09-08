@extends('layouts.admin')

@section('title', 'Edit Trainer')

@section('content')
<h2 class="text-xl font-semibold mb-4">Edit Trainer</h2>
<form action="{{ route('admin.trainers.update', $trainer) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-gray-300">Name</label>
        <input type="text" name="name" value="{{ old('name', $trainer->name) }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Specialty</label>
        <input type="text" name="specialty" value="{{ old('specialty', $trainer->specialty) }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('specialty')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Bio</label>
        <textarea name="bio" class="w-full mt-1 p-2 bg-gray-700 rounded">{{ old('bio', $trainer->bio) }}</textarea>
        @error('bio')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Image</label>
        <input type="file" name="image" class="w-full mt-1 p-2 bg-gray-700 rounded">
        @if($trainer->image)
            <p class="text-gray-400 mt-1">Current: <img src="{{ asset('storage/'.$trainer->image) }}" alt="Trainer Image" class="h-12 inline-block"></p>
        @endif
        @error('image')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Instagram</label>
        <input type="text" name="instagram" value="{{ old('instagram', $trainer->instagram) }}" class="w-full mt-1 p-2 bg-gray-700 rounded">
        @error('instagram')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Experience Years</label>
        <input type="number" name="experience_years" value="{{ old('experience_years', $trainer->experience_years) }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('experience_years')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" value="1" {{ $trainer->is_active ? 'checked' : '' }} class="form-checkbox text-red-600">
            <span class="ml-2 text-gray-300">Active</span>
        </label>
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Update Trainer</button>
</form>
@endsection
