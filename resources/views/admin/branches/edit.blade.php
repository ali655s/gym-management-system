@extends('layouts.admin')

@section('title', 'Edit Branch')

@section('content')
<h2 class="text-xl font-semibold mb-4">Edit Branch</h2>
<form action="{{ route('admin.branches.update', $branch) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-gray-300">Name</label>
        <input type="text" name="name" value="{{ old('name', $branch->name) }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">City</label>
        <input type="text" name="city" value="{{ old('city', $branch->city) }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Address</label>
        <input type="text" name="address" value="{{ old('address', $branch->address) }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Map Link</label>
        <input type="url" name="map_link" value="{{ old('map_link', $branch->map_link) }}" class="w-full mt-1 p-2 bg-gray-700 rounded">
    </div>
    <div>
        <label class="block text-gray-300">Image</label>
        <input type="file" name="image" class="w-full mt-1 p-2 bg-gray-700 rounded">
        @if($branch->image)
            <p class="text-gray-400 mt-1">Current: <img src="{{ asset('storage/'.$branch->image) }}" alt="Branch Image" class="h-12 inline-block"></p>
        @endif
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" value="1" {{ $branch->is_active ? 'checked' : '' }} class="form-checkbox text-red-600">
            <span class="ml-2 text-gray-300">Active</span>
        </label>
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Update Branch</button>
</form>
@endsection
