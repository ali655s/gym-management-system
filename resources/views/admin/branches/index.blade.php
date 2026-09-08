@extends('layouts.admin')

@section('title', 'Branches')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold">Branches Management</h2>
            <p class="text-sm text-gray-400 mt-0.5">Manage gym branch locations, facilities, and contact details.</p>
        </div>
        <a href="{{ route('admin.branches.create') }}" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-500 text-white font-medium px-4 py-2 rounded transition shadow">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Add New Branch</span>
        </a>
    </div>

    <!-- Search bar -->
    <div class="bg-gray-800 p-4 rounded-lg border border-gray-700">
        <form method="GET" action="{{ route('admin.branches.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search branches by name, city, address, or phone..."
                    class="w-full pl-10 pr-4 py-2 bg-gray-700 border border-gray-600 rounded text-white text-sm focus:outline-none focus:border-red-500">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium rounded transition">
                Search
            </button>
            @if(request('search'))
            <a href="{{ route('admin.branches.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-gray-300 text-sm font-medium rounded transition text-center">
                Clear
            </a>
            @endif
        </form>
    </div>

    <!-- Branches Table -->
    <div class="bg-gray-800 rounded-lg border border-gray-700 overflow-hidden shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900/60">
                    <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        <th class="px-5 py-3.5">Branch</th>
                        <th class="px-5 py-3.5">Location & Contact</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Stats</th>
                        <th class="px-5 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/60">
                    @forelse($branches as $branch)
                    <tr class="hover:bg-gray-750/50 transition">
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $branch->image_url }}" alt="{{ $branch->name }}" class="h-12 w-16 object-cover rounded border border-gray-700 shrink-0">
                                <div>
                                    <div class="font-medium text-white">{{ $branch->name }}</div>
                                    <div class="text-xs text-red-400 font-semibold mt-0.5">{{ $branch->city }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-gray-300">
                            <div class="max-w-xs truncate">{{ $branch->address }}</div>
                            <div class="text-xs text-gray-400 mt-1 flex items-center gap-2">
                                <span>{{ $branch->phone }}</span>
                                @if($branch->map_link)
                                <a href="{{ $branch->map_link }}" target="_blank" class="text-red-400 hover:text-red-300 inline-flex items-center gap-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    <span>Map</span>
                                </a>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            @if($branch->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900/60 text-green-300 border border-green-700">
                                Active
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900/60 text-red-300 border border-red-700">
                                Inactive
                            </span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-xs text-gray-400 space-y-1">
                            <div>Plans: <strong class="text-white font-medium">{{ $branch->membership_plans_count ?? 0 }}</strong></div>
                            <div>Classes: <strong class="text-white font-medium">{{ $branch->gym_classes_count ?? 0 }}</strong></div>
                            <div>Members: <strong class="text-white font-medium">{{ $branch->members_count ?? 0 }}</strong></div>
                        </td>
                        <td class="px-5 py-4 text-right space-x-3 text-sm">
                            <a href="{{ route('admin.branches.edit', $branch) }}" class="text-blue-400 hover:text-blue-300 font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.branches.destroy', $branch) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete branch \'{{ $branch->name }}\'?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 font-medium">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-gray-400">
                            No branches found. <a href="{{ route('admin.branches.create') }}" class="text-red-400 underline">Add one now</a>.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($branches->hasPages())
    <div class="mt-4">
        {{ $branches->links() }}
    </div>
    @endif
</div>
@endsection