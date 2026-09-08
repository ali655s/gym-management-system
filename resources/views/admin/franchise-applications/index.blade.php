@extends('layouts.admin')

@section('title', 'Franchise Applications')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
    <h2 class="text-xl font-semibold">Franchise Applications</h2>
</div>

<!-- Search and Filter Bar -->
<form method="GET" action="{{ route('admin.franchise-applications.index') }}" class="flex flex-wrap gap-2 mb-6">
    <input type="text" 
           name="search" 
           value="{{ request('search') }}" 
           placeholder="Search applicant, email, city..." 
           class="px-3 py-2 bg-gray-800 border border-gray-700 text-white rounded focus:outline-none focus:border-red-500 min-w-[240px]" />
    
    <select name="status" class="px-3 py-2 bg-gray-800 border border-gray-700 text-white rounded focus:outline-none focus:border-red-500">
        <option value="">All Statuses</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
    </select>

    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">
        Filter
    </button>

    @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('admin.franchise-applications.index') }}" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded transition flex items-center">
            Reset
        </a>
    @endif
</form>

<div class="bg-gray-800 rounded shadow overflow-x-auto">
    <table class="min-w-full text-left text-sm text-gray-300">
        <thead class="bg-gray-700 text-xs uppercase text-gray-400 border-b border-gray-600">
            <tr>
                <th class="px-4 py-3">ID</th>
                <th class="px-4 py-3">Applicant</th>
                <th class="px-4 py-3">Contact</th>
                <th class="px-4 py-3">City</th>
                <th class="px-4 py-3">Capital</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Submitted</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
            @forelse($applications as $app)
                <tr class="hover:bg-gray-750 transition">
                    <td class="px-4 py-3 font-mono text-gray-400">#{{ $app->id }}</td>
                    <td class="px-4 py-3 font-medium text-white">{{ $app->full_name }}</td>
                    <td class="px-4 py-3">
                        <div>{{ $app->email }}</div>
                        <div class="text-xs text-gray-400">{{ $app->phone }}</div>
                    </td>
                    <td class="px-4 py-3">{{ $app->city }}</td>
                    <td class="px-4 py-3 font-semibold text-gray-200">{{ $app->capital }}</td>
                    <td class="px-4 py-3">
                        @if($app->status === 'approved')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-300 border border-green-700">Approved</span>
                        @elseif($app->status === 'rejected')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-300 border border-red-700">Rejected</span>
                        @elseif($app->status === 'reviewed')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-900 text-blue-300 border border-blue-700">Reviewed</span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-900 text-yellow-300 border border-yellow-700">Pending</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-400">
                        {{ $app->created_at ? $app->created_at->format('Y-m-d H:i') : '-' }}
                    </td>
                    <td class="px-4 py-3 space-x-2 whitespace-nowrap">
                        <a href="{{ route('admin.franchise-applications.show', $app) }}" class="text-blue-400 hover:text-blue-300 underline">View</a>

                        @if($app->status !== 'approved')
                            <form action="{{ route('admin.franchise-applications.updateStatus', $app) }}" method="POST" class="inline" onsubmit="return confirm('Approve this franchise application?');">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="text-green-400 hover:text-green-300 underline">Approve</button>
                            </form>
                        @endif

                        @if($app->status !== 'rejected')
                            <form action="{{ route('admin.franchise-applications.updateStatus', $app) }}" method="POST" class="inline" onsubmit="return confirm('Reject this franchise application?');">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="text-yellow-400 hover:text-yellow-300 underline">Reject</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.franchise-applications.destroy', $app) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this application?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                        No franchise applications found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $applications->links() }}
</div>
@endsection
