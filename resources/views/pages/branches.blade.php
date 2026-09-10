@extends('layouts.public')

@section('title', 'Branch Locations - IronPulse Gym')

@section('content')

<!-- Banner Header -->
<div class="py-16 sm:py-20 bg-gradient-to-b from-neutral-900 to-neutral-950 border-b border-neutral-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <span class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-600/20 border border-rose-500/40 text-rose-400 text-xs font-bold tracking-widest uppercase">
            Our Centers & Facilities
        </span>
        <h1 class="text-4xl sm:text-6xl font-black uppercase tracking-tight text-white font-sans">
            ALL BRANCH LOCATIONS
        </h1>
        <p class="text-neutral-400 text-base max-w-2xl mx-auto">
            Discover our world-class training arenas across the country, each offering bespoke membership pricing and state-of-the-art facilities.
        </p>
    </div>
</div>

<!-- Branches Listing -->
<div class="py-16 bg-neutral-950 min-h-[50vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($branches as $branch)
                <div class="rounded-3xl bg-neutral-900 border border-neutral-800 overflow-hidden hover:border-rose-500/50 hover:shadow-2xl hover:shadow-rose-950/20 transition duration-300 flex flex-col">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $branch->image_url }}" 
                             alt="{{ $branch->name }}" 
                             class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-transparent to-transparent"></div>
                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-rose-600 text-white text-[11px] font-black uppercase tracking-wider">
                            {{ $branch->city }}
                        </span>
                    </div>

                    <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                        <div>
                            <h3 class="text-xl font-bold text-white uppercase tracking-tight">{{ $branch->name }}</h3>
                            <p class="text-xs text-neutral-400 mt-1 flex items-center">
                                <svg class="h-4 w-4 mr-1 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $branch->address }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-neutral-800/80 flex items-center justify-between">
                            <span class="text-xs text-neutral-400">
                                @if($branch->membershipPlans->isNotEmpty())
                                    Plans from <strong class="text-white">${{ number_format($branch->membershipPlans->min('price'), 2) }}</strong>
                                @else
                                    <strong class="text-neutral-400">Flexible Passes</strong>
                                @endif
                            </span>
                            <a href="{{ route('memberships.index') }}" 
                               class="px-4 py-2 rounded-xl bg-neutral-800 hover:bg-rose-600 text-white font-bold text-xs uppercase tracking-wider transition">
                                View Plans
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 text-neutral-500">
                    <svg class="h-12 w-12 mx-auto mb-4 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <p class="text-base font-semibold text-neutral-400">No active branches found.</p>
                    <p class="text-xs text-neutral-500 mt-1">Please check back soon for our newest arena openings.</p>
                </div>
            @endforelse
        </div>

        <!-- Back to Home Link -->
        <div class="mt-16 text-center">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center text-sm font-semibold text-neutral-400 hover:text-white transition">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>

@endsection
