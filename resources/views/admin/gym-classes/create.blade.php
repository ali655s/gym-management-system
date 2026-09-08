@extends('layouts.admin')

@section('title', 'Add Gym Class')

@section('content')
<h2 class="text-xl font-semibold mb-4">Add New Gym Class</h2>
<form action="{{ route('admin.gym-classes.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block text-gray-300">Branch</label>
        <select name="branch_id" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
            @endforeach
        </select>
        @error('branch_id')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Name</label>
        <input type="text" name="name" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Description</label>
        <textarea name="description" class="w-full mt-1 p-2 bg-gray-700 rounded"></textarea>
        @error('description')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Trainer Name</label>
        <input type="text" name="trainer_name" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('trainer_name')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div class="flex space-x-2">
        <div class="flex-1">
            <label class="block text-gray-300">Start Time</label>
            <input type="time" name="start_time" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
            @error('start_time')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex-1">
            <label class="block text-gray-300">End Time</label>
            <input type="time" name="end_time" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
            @error('end_time')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div>
        <label class="block text-gray-300">Days (e.g. Mon,Wed,Fri)</label>
        <input type="text" name="days" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('days')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="block text-gray-300">Capacity</label>
        <input type="number" name="capacity" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
        @error('capacity')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" class="form-checkbox text-red-600" checked>
            <span class="ml-2 text-gray-300">Active</span>
        </label>
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Create Class</button>
</form>
@endsection
