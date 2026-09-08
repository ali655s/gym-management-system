@extends('layouts.admin')

@section('title', 'Edit Partner')

@section('content')
<h2 class="text-xl font-semibold mb-4">Edit Partner</h2>
<form action="{{ route('admin.partners.update', $partner) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-gray-300">Name</label>
        <input type="text" name="name" value="{{ old('name', $partner->name) }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Website</label>
        <input type="url" name="website" value="{{ old('website', $partner->website) }}" class="w-full mt-1 p-2 bg-gray-700 rounded">
    </div>
    <div>
        <label class="block text-gray-300">Logo</label>
        <input type="file" name="logo" class="w-full mt-1 p-2 bg-gray-700 rounded">
        @if($partner->logo)
            <p class="text-gray-400 mt-1">Current: <img src="{{ asset('storage/' . $partner->logo) }}" alt="Partner Logo" class="h-12 inline-block"></p>
        @endif
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" value="1" {{ $partner->is_active ? 'checked' : '' }} class="form-checkbox text-red-600">
            <span class="ml-2 text-gray-300">Active</span>
        </label>
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Update Partner</button>
</form>
@endsection
