@extends('layouts.admin')

@section('title', 'Add Branch')

@section('content')
<div class="max-w-3xl">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-semibold">Add New Branch</h2>
        <a href="{{ route('admin.branches.index') }}" class="text-sm text-gray-400 hover:text-white">
            &larr; Back to Branches
        </a>
    </div>

    <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">
        <form action="{{ route('admin.branches.store') }}" method="POST" class="space-y-5" enctype="multipart/form-data">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-300">Branch Name <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full mt-1 p-2.5 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-red-500 @error('name') border-red-500 @enderror"
                       placeholder="e.g. Downtown Flagship" required>
                @error('name')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-300">City <span class="text-red-500">*</span></label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}"
                           class="w-full mt-1 p-2.5 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-red-500 @error('city') border-red-500 @enderror"
                           placeholder="e.g. Cairo" required>
                    @error('city')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-300">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                           class="w-full mt-1 p-2.5 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-red-500 @error('phone') border-red-500 @enderror"
                           placeholder="e.g. +20 2 2790 0001" required>
                    @error('phone')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="address" class="block text-sm font-medium text-gray-300">Detailed Address <span class="text-red-500">*</span></label>
                <input type="text" name="address" id="address" value="{{ old('address') }}"
                       class="w-full mt-1 p-2.5 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-red-500 @error('address') border-red-500 @enderror"
                       placeholder="e.g. 15 Tahrir Square, Downtown" required>
                @error('address')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="map_link" class="block text-sm font-medium text-gray-300">Google Maps Link (Optional)</label>
                <input type="text" name="map_link" id="map_link" value="{{ old('map_link') }}"
                       class="w-full mt-1 p-2.5 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-red-500 @error('map_link') border-red-500 @enderror"
                       placeholder="https://maps.google.com/?q=...">
                <p class="text-xs text-gray-400 mt-1">Accepts full link (e.g. https://maps.google.com/...) or short share link.</p>
                @error('map_link')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-300">Branch Photo (Optional)</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full mt-1 p-2 bg-gray-700 border border-gray-600 rounded text-white focus:outline-none focus:border-red-500 @error('image') border-red-500 @enderror">
                <p class="text-xs text-gray-400 mt-1">Supported formats: JPG, PNG, WEBP (Max: 2MB). A default gym photo will be used if none uploaded.</p>
                @error('image')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-2">
                <label class="inline-flex items-center cursor-pointer">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="form-checkbox h-5 w-5 text-red-600 rounded bg-gray-700 border-gray-600">
                    <span class="ml-2 text-sm text-gray-300">Active (Visible to public members & website)</span>
                </label>
                @error('is_active')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-gray-700">
                <button type="submit" class="bg-red-600 hover:bg-red-500 text-white font-medium px-5 py-2.5 rounded transition">
                    Create Branch
                </button>
                <a href="{{ route('admin.branches.index') }}" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-5 py-2.5 rounded transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
