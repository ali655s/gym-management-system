@extends('layouts.admin')

@section('title', 'Message from ' . $message->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.contact-messages.index') }}" class="text-gray-400 hover:text-white flex items-center gap-1 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Messages
        </a>

        <div class="flex items-center space-x-2">
            <form action="{{ route('admin.contact-messages.toggleRead', $message) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1.5 rounded text-sm transition">
                    {{ $message->is_read ? 'Mark as Unread' : 'Mark as Read' }}
                </button>
            </form>

            <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm transition">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg shadow-lg border border-gray-700 overflow-hidden">
        <!-- Message Header -->
        <div class="p-6 border-b border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $message->name }}</h1>
                <p class="text-sm text-gray-400 mt-1">
                    Sent on {{ $message->created_at->format('F d, Y \a\t h:i A') }}
                </p>
            </div>
            <div>
                @if($message->is_read)
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-gray-700 text-gray-300 border border-gray-600">
                        Read
                    </span>
                @else
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-300 border border-red-700">
                        Unread
                    </span>
                @endif
            </div>
        </div>

        <!-- Sender Info -->
        <div class="p-6 bg-gray-850 border-b border-gray-700">
            <span class="text-xs uppercase text-gray-400 font-semibold tracking-wider">Email Address</span>
            <p class="text-base text-white mt-1">
                <a href="mailto:{{ $message->email }}" class="text-red-400 hover:underline flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    {{ $message->email }}
                </a>
            </p>
        </div>

        <!-- Message Body -->
        <div class="p-6">
            <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Message Content</h2>
            <div class="p-4 bg-gray-900 rounded border border-gray-700 text-gray-100 whitespace-pre-wrap leading-relaxed text-base">
                {{ $message->message }}
            </div>
        </div>
    </div>
</div>
@endsection
