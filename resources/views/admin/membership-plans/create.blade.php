@extends('layouts.admin')

@section('title', 'Add Membership Plan')

@section('content')
<h2 class="text-xl font-semibold mb-4">Add New Membership Plan</h2>
<form action="{{ route('admin.membership-plans.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block text-gray-300">Branch</label>
        <select name="branch_id" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-gray-300">Duration</label>
        <select name="duration" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
            <option value="1_month">1 Month</option>
            <option value="3_months">3 Months</option>
            <option value="6_months">6 Months</option>
        </select>
    </div>
    <div>
        <label class="block text-gray-300">Price</label>
        <input type="number" step="0.01" name="price" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" class="form-checkbox text-red-600" checked>
            <span class="ml-2 text-gray-300">Active</span>
        </label>
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Create Plan</button>
</form>
@endsection
