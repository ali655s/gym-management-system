@extends('layouts.admin')

@section('title', 'Edit Member')

@section('content')
<h2 class="text-xl font-semibold mb-4">Edit Member Branch</h2>
<form action="{{ route('admin.members.update', $member) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-gray-300">Name</label>
        <input type="text" value="{{ $member->user->name }}" disabled class="w-full mt-1 p-2 bg-gray-700 rounded">
    </div>
    <div>
        <label class="block text-gray-300">Email</label>
        <input type="text" value="{{ $member->user->email }}" disabled class="w-full mt-1 p-2 bg-gray-700 rounded">
    </div>
    <div>
        <label class="block text-gray-300">Branch</label>
        <select name="branch_id" class="w-full mt-1 p-2 bg-gray-700 rounded">
            <option value="" {{ $member->branch_id ? '' : 'selected' }}>No Branch</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" {{ $member->branch_id == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Update Member</button>
</form>
@endsection
