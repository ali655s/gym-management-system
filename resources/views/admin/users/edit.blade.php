@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<h2 class="text-xl font-semibold mb-4">Edit User</h2>
<form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-gray-300">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Password (leave blank to keep current)</label>
        <input type="password" name="password" class="w-full mt-1 p-2 bg-gray-700 rounded">
    </div>
    <div>
        <label class="block text-gray-300">Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full mt-1 p-2 bg-gray-700 rounded">
    </div>
    <div>
        <label class="block text-gray-300">Role</label>
        @if(auth()->id() === $user->id)
            <input type="text" value="{{ $user->role }}" disabled class="w-full mt-1 p-2 bg-gray-700 rounded">
        @else
            <select name="role" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
            </select>
        @endif
    </div>
    <div>
        <label class="block text-gray-300">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full mt-1 p-2 bg-gray-700 rounded">
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Update User</button>
</form>
@endsection
