@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<h2 class="text-xl font-semibold mb-4">Users</h2>

<form method="GET" action="{{ route('admin.users.index') }}" class="flex space-x-2 mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email or phone" class="px-2 py-1 bg-gray-700 rounded" />
    <select name="role" class="px-2 py-1 bg-gray-700 rounded">
        <option value="">All Roles</option>
        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        <option value="member" {{ request('role') == 'member' ? 'selected' : '' }}>Member</option>
    </select>
    <button type="submit" class="bg-red-600 text-white px-3 rounded">Filter</button>
    <a href="{{ route('admin.users.create') }}" class="ml-auto bg-green-600 text-white px-3 py-1 rounded">Create New</a>
</form>

<table class="min-w-full bg-gray-800 text-gray-200">
    <thead>
        <tr>
            <th class="px-4 py-2">ID</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Role</th>
            <th class="px-4 py-2">Phone</th>
            <th class="px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr class="border-t border-gray-700">
                <td class="px-4 py-2">{{ $user->id }}</td>
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">{{ $user->role }}</td>
                <td class="px-4 py-2">{{ $user->phone ?? '-' }}</td>
                <td class="px-4 py-2 space-x-2">
                    @if(auth()->id() !== $user->id)
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-red-400 hover:underline">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                        </form>
                    @else
                        <span class="text-gray-500">Self</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-4 py-2 text-center">No users found.</td></tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
