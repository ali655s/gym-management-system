@extends('layouts.public')

@section('title', 'Meet Our Elite Coaches - IronPulse Gym')

@section('content')

<!-- Banner Header -->
<div class="py-16 sm:py-20 bg-gradient-to-b from-neutral-900 to-neutral-950 border-b border-neutral-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <span class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-600/20 border border-rose-500/40 text-rose-400 text-xs font-bold tracking-widest uppercase">
            Coaching Excellence
        </span>
        <h1 class="text-4xl sm:text-6xl font-black uppercase tracking-tight text-white font-sans">
            MEET OUR ELITE COACHES
        </h1>
        <p class="text-neutral-400 text-base max-w-2xl mx-auto">
            Our certified coaching staff brings decades of combined competitive experience to elevate your technique, intensity, and nutrition.
        </p>
    </div>
</div>

<!-- Trainers Listing -->
<div class="py-16 bg-neutral-950 min-h-[50vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($trainers as $trainer)
                <div class="rounded-3xl bg-neutral-900 border border-neutral-800 overflow-hidden hover:border-rose-500/50 hover:-translate-y-1.5 transition duration-300 group flex flex-col">
                    
                    <!-- Trainer Photo -->
                    <div class="relative aspect-4/5 overflow-hidden bg-neutral-950">
                        @php
                            $displayImage = $trainer->image
                                ? asset('storage/' . $trainer->image)
                                : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=800&q=80';
                        @endphp

                        <img src="{{ $displayImage }}"
                             alt="{{ $trainer->name }}"
                             class="h-full w-full object-cover object-top group-hover:scale-105 transition duration-500">

                        <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-transparent to-transparent"></div>
                        
                        <!-- Experience Badge -->
                        <div class="absolute top-4 right-4 px-3 py-1 rounded-full bg-neutral-950/80 backdrop-blur-md border border-neutral-800 text-neutral-200 text-xs font-bold">
                            {{ $trainer->experience_years }}+ Yrs Experience
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                        <div>
                            <span class="text-rose-500 font-bold text-xs uppercase tracking-wider">{{ $trainer->specialty }}</span>
                            <h3 class="text-xl font-bold text-white uppercase tracking-wide mt-1">{{ $trainer->name }}</h3>
                            <p class="text-neutral-400 text-xs sm:text-sm mt-2 line-clamp-3 leading-relaxed">
                                {{ $trainer->bio }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-neutral-800 flex items-center justify-between">
                            <span class="text-xs text-neutral-400 font-medium">{{ $trainer->instagram }}</span>
                            <a href="{{ route('memberships.index') }}" 
                               class="text-xs font-bold text-rose-500 hover:text-rose-400 uppercase tracking-wider">
                                Book Class &rarr;
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 text-neutral-500">
                    <svg class="h-12 w-12 mx-auto mb-4 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-base font-semibold text-neutral-400">No coaches listed at this time.</p>
                    <p class="text-xs text-neutral-500 mt-1">Please check back soon to meet our newest personal trainers.</p>
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
