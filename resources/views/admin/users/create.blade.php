@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<h2 class="text-xl font-semibold mb-4">Create New User</h2>
<form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block text-gray-300">Name</label>
        <input type="text" name="name" value="{{ old('name') }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Password</label>
        <input type="password" name="password" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
    </div>
    <div>
        <label class="block text-gray-300">Role</label>
        <select name="role" class="w-full mt-1 p-2 bg-gray-700 rounded" required>
            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
        </select>
    </div>
    <div>
        <label class="block text-gray-300">Phone (optional)</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="w-full mt-1 p-2 bg-gray-700 rounded">
    </div>
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Create User</button>
</form>
@endsection
