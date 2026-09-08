@extends('layouts.admin')

@section('title', 'Add Partner')

@section('content')
<h2 class="text-xl font-semibold mb-4">Add New Partner</h2>
<form action="{{ route('admin.partners.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
    @csrf
    <div>
        <label class="block text-gray-300">Name</label>
        <input type="text" name="name" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Logo</label>
        <input type="file" name="logo" class="w-full mt-1 p-2 bg-gray-700 rounded">
        @error('logo')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Website</label>
        <input type="url" name="website" class="w-full mt-1 p-2 bg-gray-700 rounded">
        @error('website')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" class="form-checkbox text-red-600" checked>
            <span class="ml-2 text-gray-300">Active</span>
        </label>
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Create Partner</button>
</form>
@endsection
