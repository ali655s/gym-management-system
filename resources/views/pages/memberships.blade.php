@extends('layouts.public')

@section('title', 'Membership Plans & Branch Access - IronPulse Gym')

@section('content')

<!-- Banner Header -->
<div class="py-16 sm:py-20 bg-gradient-to-b from-neutral-900 to-neutral-950 border-b border-neutral-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <span class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-600/20 border border-rose-500/40 text-rose-400 text-xs font-bold tracking-widest uppercase">
            Transparent Pricing & Real Schedules
        </span>
        <h1 class="text-4xl sm:text-6xl font-black uppercase tracking-tight text-white font-sans">
            SELECT YOUR ARENA & PLAN
        </h1>
        <p class="text-neutral-400 text-base max-w-2xl mx-auto">
            Each IronPulse branch features customized membership pricing and dedicated class timetables. Find your city, choose your duration, and start training.
        </p>
    </div>
</div>

<!-- Branches Listing -->
<div class="py-16 bg-neutral-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-24">
        
        @php
            $branchPhotos = [
                'Downtown Flagship' => 'https://images.unsplash.com/photo-1540497077202-7c8a3999166f?auto=format&fit=crop&w=1200&q=80',
                'Seaside Arena' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1200&q=80',
                'Oasis Health Club' => 'https://images.unsplash.com/photo-1571902943202-507ec2618e8f?auto=format&fit=crop&w=1200&q=80',
            ];
        @endphp

        @forelse($branches as $branch)
            <div id="branch-{{ $branch->id }}" class="rounded-3xl bg-neutral-900/80 border border-neutral-800 overflow-hidden shadow-2xl space-y-8 p-6 sm:p-10">
                
                <!-- Branch Banner Header -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center pb-8 border-b border-neutral-800">
                    <div class="lg:col-span-2 space-y-3">
                        <div class="flex items-center space-x-3">
                            <span class="px-3.5 py-1 rounded-full bg-rose-600 text-white text-xs font-black uppercase tracking-wider">
                                {{ $branch->city }}
                            </span>
                            <span class="text-xs text-neutral-400 font-medium">Flagship Arena</span>
                        </div>
                        <h2 class="text-3xl sm:text-4xl font-black uppercase text-white tracking-tight">
                            {{ $branch->name }}
                        </h2>
                        <div class="flex flex-wrap gap-4 text-xs sm:text-sm text-neutral-400 pt-1">
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                                {{ $branch->address }}
                            </span>
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $branch->phone }}
                            </span>
                        </div>
                    </div>

                    <div class="flex lg:justify-end">
                        @if($branch->map_link)
                            <a href="{{ $branch->map_link }}" target="_blank" 
                               class="inline-flex items-center px-5 py-3 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white font-bold text-xs uppercase tracking-wider border border-neutral-700 transition">
                                <svg class="h-4 w-4 mr-2 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                </svg>
                                View on Google Maps &rarr;
                            </a>
                        @endif
                    </div>
                </div>

                <!-- 3 Plans for this branch -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-neutral-300">
                        1. Select Membership Duration
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($branch->membershipPlans as $plan)
                            @php
                                $durationLabel = match($plan->duration) {
                                    '1_month' => '1 Month Pass',
                                    '3_months' => '3 Months Power Pass',
                                    '6_months' => '6 Months VIP Pass',
                                    default => $plan->duration,
                                };
                                $isPopular = $plan->duration === '3_months';
                            @endphp
                            
                            <div class="relative rounded-2xl p-6 flex flex-col justify-between transition duration-300 border {{ $isPopular ? 'bg-neutral-950 border-rose-500/80 shadow-2xl shadow-rose-950/40 ring-1 ring-rose-500/50' : 'bg-neutral-950/70 border-neutral-800 hover:border-neutral-700' }}">
                                
                                @if($isPopular)
                                    <span class="absolute -top-3 right-6 px-3 py-0.5 rounded-full bg-rose-600 text-white text-[10px] font-black uppercase tracking-widest shadow-md">
                                        Most Popular
                                    </span>
                                @endif

                                <div class="space-y-4">
                                    <div>
                                        <h4 class="text-base font-bold text-white uppercase tracking-wide">{{ $durationLabel }}</h4>
                                        <p class="text-xs text-neutral-400 mt-1">Full access to {{ $branch->name }} facilities</p>
                                    </div>

                                    <div class="flex items-baseline space-x-1">
                                        <span class="text-3xl sm:text-4xl font-black text-white font-sans">${{ number_format($plan->price, 2) }}</span>
                                        <span class="text-xs text-neutral-400 font-medium">/ {{ str_replace('_', ' ', $plan->duration) }}</span>
                                    </div>

                                    <!-- Plan Perks -->
                                    <ul class="space-y-2.5 text-xs text-neutral-300 pt-2 border-t border-neutral-800">
                                        <li class="flex items-center">
                                            <svg class="h-4 w-4 mr-2 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            Unlimited Free Weights & Cardio Zone
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="h-4 w-4 mr-2 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            Access to Zumba & CrossFit Schedules
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="h-4 w-4 mr-2 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                            Locker Room & Shower Access
                                        </li>
                                        @if($plan->duration === '6_months')
                                            <li class="flex items-center text-rose-300 font-semibold">
                                                <svg class="h-4 w-4 mr-2 text-rose-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                                Free Monthly Body Composition Scan
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                <!-- Subscribe CTA -->
                                <div class="pt-6 mt-4">
                                    <a href="{{ route('memberships.checkout', $plan->id) }}" 
                                       class="w-full block text-center py-3 rounded-xl font-bold text-xs uppercase tracking-wider transition duration-200 {{ $isPopular ? 'bg-rose-600 hover:bg-rose-500 text-white shadow-lg shadow-rose-950/60' : 'bg-neutral-800 hover:bg-rose-600 text-neutral-200 hover:text-white' }}">
                                        Subscribe Now &rarr;
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Classes at this branch -->
                <div class="space-y-4 pt-4 border-t border-neutral-800">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold uppercase tracking-widest text-neutral-300">
                            2. Class Timetable (Included with Any Membership)
                        </h3>
                        <span class="text-xs text-neutral-500">Live Weekly Schedule</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($branch->gymClasses as $class)
                            <div class="p-5 rounded-2xl bg-neutral-950/70 border border-neutral-800/80 flex flex-col justify-between space-y-3">
                                <div>
                                    <div class="flex items-center justify-between">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $class->name === 'CrossFit' ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-purple-500/20 text-purple-400 border border-purple-500/30' }}">
                                            {{ $class->name }}
                                        </span>
                                        <span class="text-[11px] text-neutral-400 font-medium">Max {{ $class->capacity }} Athletes</span>
                                    </div>
                                    <h4 class="text-lg font-bold text-white uppercase tracking-wide mt-2">{{ $class->name }}</h4>
                                    <p class="text-xs text-neutral-400 mt-1 leading-relaxed">{{ $class->description }}</p>
                                </div>

                                <div class="pt-3 border-t border-neutral-800/80 grid grid-cols-2 gap-2 text-xs">
                                    <div>
                                        <span class="text-[10px] uppercase text-neutral-500 block">Coach</span>
                                        <span class="text-neutral-200 font-bold">{{ $class->trainer_name }}</span>
                                    </div>
                                    <div>
                                        <span class="text-[10px] uppercase text-neutral-500 block">Days & Hours</span>
                                        <span class="text-neutral-200 font-medium">
                                            {{ $class->days }} ({{ substr($class->start_time, 0, 5) }} - {{ substr($class->end_time, 0, 5) }})
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-6 text-xs text-neutral-500">
                                No classes scheduled for this branch yet.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        @empty
            <div class="text-center py-20 text-neutral-500">
                No active branches found.
            </div>
        @endforelse

    </div>
</div>

@endsection
