@extends('layouts.admin')

@section('title', 'Franchise Application #' . $application->id)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.franchise-applications.index') }}" class="text-gray-400 hover:text-white flex items-center gap-1 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Applications
        </a>
        
        <div class="flex items-center space-x-2">
            @if($application->status !== 'approved')
                <form action="{{ route('admin.franchise-applications.updateStatus', $application) }}" method="POST" class="inline" onsubmit="return confirm('Approve this application?');">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-sm transition">
                        Approve
                    </button>
                </form>
            @endif

            @if($application->status !== 'rejected')
                <form action="{{ route('admin.franchise-applications.updateStatus', $application) }}" method="POST" class="inline" onsubmit="return confirm('Reject this application?');">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1.5 rounded text-sm transition">
                        Reject
                    </button>
                </form>
            @endif

            <form action="{{ route('admin.franchise-applications.destroy', $application) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to permanently delete this application?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm transition">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="bg-gray-800 rounded-lg shadow-lg border border-gray-700 overflow-hidden">
        <!-- Header -->
        <div class="p-6 border-b border-gray-700 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $application->full_name }}</h1>
                <p class="text-sm text-gray-400 mt-1">Submitted on {{ $application->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <div>
                @if($application->status === 'approved')
                    <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-green-900 text-green-300 border border-green-700">Approved</span>
                @elseif($application->status === 'rejected')
                    <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-red-900 text-red-300 border border-red-700">Rejected</span>
                @elseif($application->status === 'reviewed')
                    <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-blue-900 text-blue-300 border border-blue-700">Reviewed</span>
                @else
                    <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-yellow-900 text-yellow-300 border border-yellow-700">Pending</span>
                @endif
            </div>
        </div>

        <!-- Details Grid -->
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-850">
            <div class="space-y-1">
                <span class="text-xs uppercase text-gray-400 font-semibold tracking-wider">Email Address</span>
                <p class="text-base text-white">
                    <a href="mailto:{{ $application->email }}" class="text-red-400 hover:underline">{{ $application->email }}</a>
                </p>
            </div>

            <div class="space-y-1">
                <span class="text-xs uppercase text-gray-400 font-semibold tracking-wider">Phone Number</span>
                <p class="text-base text-white">
                    <a href="tel:{{ $application->phone }}" class="text-gray-200 hover:underline">{{ $application->phone }}</a>
                </p>
            </div>

            <div class="space-y-1">
                <span class="text-xs uppercase text-gray-400 font-semibold tracking-wider">Target City / Region</span>
                <p class="text-base text-white">{{ $application->city }}</p>
            </div>

            <div class="space-y-1">
                <span class="text-xs uppercase text-gray-400 font-semibold tracking-wider">Available Capital Range</span>
                <p class="text-base text-emerald-400 font-semibold">{{ $application->capital }}</p>
            </div>
        </div>

        <!-- Application Message / Notes -->
        <div class="p-6 border-t border-gray-700">
            <h2 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Applicant Message / Investment Vision</h2>
            <div class="p-4 bg-gray-900 rounded border border-gray-700 text-gray-200 whitespace-pre-wrap leading-relaxed">
                {{ $application->message ?: 'No additional message provided.' }}
            </div>
        </div>
    </div>
</div>
@endsection
