@extends('layouts.public')

@section('title', 'Confirm Subscription - IronPulse Gym')

@section('content')

<div class="py-16 bg-neutral-950 min-h-[75vh]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Link -->
        <div class="mb-8">
            <a href="{{ route('memberships.index') }}" class="inline-flex items-center text-xs font-bold uppercase tracking-wider text-neutral-400 hover:text-rose-500 transition">
                &larr; Back to Memberships
            </a>
        </div>

        <!-- Checkout Card -->
        <div class="rounded-3xl bg-neutral-900 border border-neutral-800 p-8 sm:p-12 shadow-2xl space-y-8">
            
            <div class="space-y-2 border-b border-neutral-800 pb-6">
                <span class="px-3 py-1 rounded-full bg-rose-600/20 border border-rose-500/40 text-rose-400 text-[10px] font-black uppercase tracking-widest">
                    Confirmation & Activation
                </span>
                <h1 class="text-2xl sm:text-4xl font-black uppercase tracking-tight text-white">
                    CONFIRM YOUR MEMBERSHIP
                </h1>
                <p class="text-xs text-neutral-400">
                    Review your plan details below. Your subscription will be activated immediately upon confirmation.
                </p>
            </div>

            <!-- Summary Details -->
            <div class="space-y-6 text-sm">
                
                <!-- Branch & Plan Box -->
                <div class="p-6 rounded-2xl bg-neutral-950 border border-neutral-800 space-y-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs text-rose-500 font-bold uppercase tracking-wider">{{ $plan->branch->city }} Branch</span>
                            <h3 class="text-xl font-bold text-white uppercase">{{ $plan->branch->name }}</h3>
                            <p class="text-xs text-neutral-400 mt-0.5">{{ $plan->branch->address }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl sm:text-3xl font-black text-white font-sans">${{ number_format($plan->price, 2) }}</span>
                            <span class="block text-[11px] text-neutral-400 uppercase tracking-wider">{{ str_replace('_', ' ', $plan->duration) }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-neutral-800/80 grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-neutral-500 uppercase text-[10px] block">Subscription Start Date</span>
                            <span class="text-neutral-200 font-semibold">
                                @php
                                    $member = $user->member;
                                    $active = $member?->activeSubscription;
                                    $startDate = ($active && $active->end_date >= now()->toDateString()) 
                                        ? $active->end_date->format('M d, Y') . ' (After current plan)' 
                                        : now()->format('M d, Y') . ' (Today)';
                                @endphp
                                {{ $startDate }}
                            </span>
                        </div>
                        <div>
                            <span class="text-neutral-500 uppercase text-[10px] block">Duration Period</span>
                            <span class="text-neutral-200 font-semibold">{{ $plan->durationInMonths() }} Month(s)</span>
                        </div>
                    </div>
                </div>

                <!-- Athlete Profile Box -->
                <div class="p-6 rounded-2xl bg-neutral-950/60 border border-neutral-800/80 space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-400">Athlete Information</h4>
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-neutral-500 text-[10px] uppercase block">Member Name</span>
                            <span class="text-white font-semibold">{{ $user->name }}</span>
                        </div>
                        <div>
                            <span class="text-neutral-500 text-[10px] uppercase block">Email Address</span>
                            <span class="text-white font-semibold">{{ $user->email }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Confirmation Form -->
            <form action="{{ route('memberships.subscribe', $plan->id) }}" method="POST" class="pt-4 space-y-4">
                @csrf
                <button type="submit" 
                        class="w-full py-4 rounded-2xl bg-rose-600 hover:bg-rose-500 text-white font-black text-sm uppercase tracking-wider shadow-xl shadow-rose-950/60 hover:shadow-rose-600/40 hover:scale-[1.01] active:scale-[0.99] transition duration-200">
                    Confirm & Activate Subscription (${{ number_format($plan->price, 2) }})
                </button>
                <p class="text-center text-[11px] text-neutral-500">
                    By confirming, your access will be registered immediately in the {{ $plan->branch->name }} member roster.
                </p>
            </form>

        </div>

    </div>
</div>

@endsection
