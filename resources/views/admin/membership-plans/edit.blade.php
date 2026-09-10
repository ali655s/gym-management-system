@extends('layouts.admin')

@section('title', 'Edit Membership Plan')

@section('content')
<h2 class="text-xl font-semibold mb-4">Edit Membership Plan</h2>

<form action="{{ route('admin.membership-plans.update', $membershipPlan) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-gray-300">Branch</label>

        <select name="branch_id" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ $membershipPlan->branch_id == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                </option>
            @endforeach
        </select>

        @error('branch_id')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-gray-300">Duration</label>

        <select name="duration" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
            <option value="1_month" {{ $membershipPlan->duration == '1_month' ? 'selected' : '' }}>
                1 Month
            </option>

            <option value="3_months" {{ $membershipPlan->duration == '3_months' ? 'selected' : '' }}>
                3 Months
            </option>

            <option value="6_months" {{ $membershipPlan->duration == '6_months' ? 'selected' : '' }}>
                6 Months
            </option>
        </select>

        @error('duration')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-gray-300">Price</label>

        <input
            type="number"
            step="0.01"
            name="price"
            value="{{ old('price', $membershipPlan->price) }}"
            class="w-full mt-1 p-2 bg-gray-700 rounded"
            required
        >

        @error('price')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="inline-flex items-center">

            <input
                type="checkbox"
                name="is_active"
                value="1"
                {{ $membershipPlan->is_active ? 'checked' : '' }}
                class="form-checkbox text-red-600"
            >

            <span class="ml-2 text-gray-300">Active</span>

        </label>
    </div>

    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">
        Update Plan
    </button>
</form>
@endsection
