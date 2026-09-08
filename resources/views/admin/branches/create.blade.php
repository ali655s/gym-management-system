@extends('layouts.admin')

@section('title', 'Add Branch')

@section('content')
<h2 class="text-xl font-semibold mb-4">Add New Branch</h2>
<form action="{{ route('admin.branches.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
    @csrf
    <div>
        <label class="block text-gray-300">Name</label>
        <input type="text" name="name" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">City</label>
        <input type="text" name="city" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Address</label>
        <input type="text" name="address" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Phone</label>
        <input type="text" name="phone" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Map Link</label>
        <input type="url" name="map_link" class="w-full mt-1 p-2 bg-gray-700 rounded">
    </div>
    <div>
        <label class="block text-gray-300">Image</label>
        <input type="file" name="image" class="w-full mt-1 p-2 bg-gray-700 rounded">
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" class="form-checkbox text-red-600" checked>
            <span class="ml-2 text-gray-300">Active</span>
        </label>
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Create Branch</button>
</form>
@endsection
