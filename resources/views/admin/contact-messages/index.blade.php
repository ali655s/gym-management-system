@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
    <h2 class="text-xl font-semibold">Contact Messages Inbox</h2>
</div>

<!-- Search & Filter Form -->
<form method="GET" action="{{ route('admin.contact-messages.index') }}" class="flex flex-wrap gap-2 mb-6">
    <input type="text" 
           name="search" 
           value="{{ request('search') }}" 
           placeholder="Search sender, email, keywords..." 
           class="px-3 py-2 bg-gray-800 border border-gray-700 text-white rounded focus:outline-none focus:border-red-500 min-w-[240px]" />

    <select name="status" class="px-3 py-2 bg-gray-800 border border-gray-700 text-white rounded focus:outline-none focus:border-red-500">
        <option value="">All Messages</option>
        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread Only</option>
        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read Only</option>
    </select>

    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">
        Filter
    </button>

    @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('admin.contact-messages.index') }}" class="bg-gray-700 hover:bg-gray-600 text-gray-300 px-4 py-2 rounded transition flex items-center">
            Reset
        </a>
    @endif
</form>

<div class="bg-gray-800 rounded shadow overflow-x-auto">
    <table class="min-w-full text-left text-sm text-gray-300">
        <thead class="bg-gray-700 text-xs uppercase text-gray-400 border-b border-gray-600">
            <tr>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Sender</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Message Preview</th>
                <th class="px-4 py-3">Date</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-700">
            @forelse($messages as $msg)
                <tr class="transition {{ $msg->is_read ? 'hover:bg-gray-750 text-gray-300' : 'bg-gray-750/70 font-medium text-white hover:bg-gray-750' }}">
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if(! $msg->is_read)
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-bold rounded-full bg-red-900/80 text-red-300 border border-red-600 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                Unread
                            </span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-normal rounded-full bg-gray-700 text-gray-400 border border-gray-600">
                                Read
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-semibold text-white whitespace-nowrap">{{ $msg->name }}</td>
                    <td class="px-4 py-3 text-gray-300 whitespace-nowrap">
                        <a href="mailto:{{ $msg->email }}" class="hover:text-red-400 hover:underline">{{ $msg->email }}</a>
                    </td>
                    <td class="px-4 py-3 max-w-md truncate text-gray-300">
                        {{ \Illuminate\Support\Str::limit($msg->message, 80) }}
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-400 whitespace-nowrap">
                        {{ $msg->created_at ? $msg->created_at->format('Y-m-d H:i') : '-' }}
                    </td>
                    <td class="px-4 py-3 space-x-2 whitespace-nowrap">
                        <a href="{{ route('admin.contact-messages.show', $msg) }}" class="text-blue-400 hover:text-blue-300 underline font-normal">
                            View
                        </a>

                        <form action="{{ route('admin.contact-messages.toggleRead', $msg) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-yellow-400 hover:text-yellow-300 underline font-normal">
                                {{ $msg->is_read ? 'Mark Unread' : 'Mark Read' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.contact-messages.destroy', $msg) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 underline font-normal">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                        No contact messages found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $messages->links() }}
</div>
@endsection
