@extends('layouts.public')

@section('title', 'My Memberships & Subscriptions - IronPulse Gym')

@section('content')

<div class="py-12 sm:py-16 bg-neutral-950 min-h-[80vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Header Profile Welcome -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center pb-6 border-b border-neutral-900 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-rose-500">Member Portal</span>
                <h1 class="text-3xl sm:text-4xl font-black uppercase tracking-tight text-white mt-1">
                    MY MEMBERSHIPS & PASSES
                </h1>
                <p class="text-xs sm:text-sm text-neutral-400 mt-1">
                    Manage your active gym pass, view access dates, and renew expired plans.
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('profile.edit') }}" 
                   class="px-4 py-2.5 rounded-xl bg-neutral-900 hover:bg-neutral-800 text-neutral-200 border border-neutral-800 text-xs font-bold uppercase tracking-wider transition">
                    Edit Profile
                </a>
                <a href="{{ route('memberships.index') }}" 
                   class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-rose-950/60 transition">
                    Browse Plans &rarr;
                </a>
            </div>
        </div>

        <!-- Active Subscription Highlight Card -->
        @if($activeSubscription)
            @php
                $daysRemaining = now()->diffInDays($activeSubscription->end_date, false);
            @endphp
            <div class="p-8 sm:p-10 rounded-3xl bg-gradient-to-br from-neutral-900 via-neutral-900 to-rose-950/30 border border-neutral-800 shadow-2xl relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 h-64 w-64 rounded-full bg-rose-600/10 blur-3xl pointer-events-none"></div>

                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 relative z-10">
                    <div class="space-y-4 max-w-2xl">
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-black uppercase tracking-wider">
                                <span class="h-2 w-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span>
                                Active Membership
                            </span>
                            <span class="text-xs text-neutral-400 font-medium">
                                Plan #{{ $activeSubscription->id }}
                            </span>
                        </div>

                        <div>
                            <h2 class="text-3xl font-black uppercase text-white tracking-tight">
                                {{ $activeSubscription->membershipPlan->branch->name }} &mdash; 
                                <span class="text-rose-500">{{ str_replace('_', ' ', $activeSubscription->membershipPlan->duration) }}</span>
                            </h2>
                            <p class="text-xs sm:text-sm text-neutral-300 mt-1">
                                Full facility & class access at {{ $activeSubscription->membershipPlan->branch->address }} ({{ $activeSubscription->membershipPlan->branch->city }})
                            </p>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-neutral-800/80 text-xs">
                            <div>
                                <span class="text-[10px] uppercase text-neutral-500 block">Start Date</span>
                                <span class="text-white font-bold">{{ $activeSubscription->start_date->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase text-neutral-500 block">Expiration Date</span>
                                <span class="text-white font-bold">{{ $activeSubscription->end_date->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase text-neutral-500 block">Time Left</span>
                                <span class="text-rose-400 font-bold">{{ max(0, $daysRemaining) }} Day(s) Remaining</span>
                            </div>
                            <div>
                                <span class="text-[10px] uppercase text-neutral-500 block">Paid Amount</span>
                                <span class="text-white font-bold">${{ number_format($activeSubscription->amount_paid, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Renew CTA Button -->
                    <div class="shrink-0 w-full lg:w-auto">
                        <form action="{{ route('subscriptions.renew', $activeSubscription->id) }}" method="POST"
                              onsubmit="return confirm('Renew this subscription for another {{ $activeSubscription->membershipPlan->duration }}? New duration will be added seamlessly to your current end date.')">
                            @csrf
                            <button type="submit" 
                                    class="w-full lg:w-auto px-8 py-4 rounded-2xl bg-rose-600 hover:bg-rose-500 text-white font-black text-xs uppercase tracking-wider shadow-xl shadow-rose-950/60 hover:shadow-rose-600/40 hover:scale-[1.02] active:scale-[0.98] transition">
                                Renew Subscription &rarr;
                            </button>
                        </form>
                        <p class="text-[11px] text-neutral-500 mt-2 text-center lg:text-right">
                            Renews at ${{ number_format($activeSubscription->membershipPlan->price, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <!-- No Active Subscription State -->
            <div class="p-10 rounded-3xl bg-neutral-900/60 border border-dashed border-neutral-800 text-center space-y-4">
                <div class="h-16 w-16 rounded-full bg-rose-600/10 text-rose-500 mx-auto flex items-center justify-center">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold uppercase text-white">No Active Subscription</h3>
                <p class="text-xs sm:text-sm text-neutral-400 max-w-md mx-auto">
                    You currently do not have an active membership. Explore our branch plans to start training today!
                </p>
                <div class="pt-2">
                    <a href="{{ route('memberships.index') }}" 
                       class="inline-block px-8 py-3.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-rose-950/50 transition">
                        View Membership Plans
                    </a>
                </div>
            </div>
        @endif

        <!-- Subscription History Table -->
        <div class="rounded-3xl bg-neutral-900 border border-neutral-800 overflow-hidden shadow-2xl space-y-4 p-6 sm:p-8">
            <div class="flex justify-between items-center pb-4 border-b border-neutral-800">
                <h3 class="text-base font-bold uppercase tracking-wide text-white">Subscription Log History</h3>
                <span class="text-xs text-neutral-400">{{ $subscriptions->count() }} Total Records</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-neutral-300">
                    <thead class="uppercase text-[10px] text-neutral-500 tracking-wider border-b border-neutral-800">
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Branch</th>
                            <th class="py-3 px-4">Plan Duration</th>
                            <th class="py-3 px-4">Period Dates</th>
                            <th class="py-3 px-4">Amount</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-neutral-800/60">
                        @forelse($subscriptions as $sub)
                            <tr class="hover:bg-neutral-950/50 transition">
                                <td class="py-3.5 px-4 font-mono text-neutral-400">#{{ $sub->id }}</td>
                                <td class="py-3.5 px-4 font-semibold text-white">
                                    {{ $sub->membershipPlan->branch->name }}
                                </td>
                                <td class="py-3.5 px-4 uppercase text-neutral-300">
                                    {{ str_replace('_', ' ', $sub->membershipPlan->duration) }}
                                </td>
                                <td class="py-3.5 px-4">
                                    {{ $sub->start_date->format('M d, Y') }} &mdash; {{ $sub->end_date->format('M d, Y') }}
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-white">
                                    ${{ number_format($sub->amount_paid, 2) }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($sub->status === 'active')
                                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-[10px] font-bold uppercase">
                                            Active
                                        </span>
                                    @elseif($sub->status === 'expired')
                                        <span class="px-2.5 py-0.5 rounded-full bg-neutral-800 text-neutral-400 border border-neutral-700 text-[10px] font-bold uppercase">
                                            Expired
                                        </span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full bg-rose-500/20 text-rose-400 border border-rose-500/30 text-[10px] font-bold uppercase">
                                            {{ $sub->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <form action="{{ route('subscriptions.renew', $sub->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Renew this plan? If expired, your new period will start today. If active, it starts from the old end date.')">
                                        @csrf
                                        <button type="submit" 
                                                class="px-3 py-1.5 rounded-lg bg-neutral-800 hover:bg-rose-600 text-neutral-300 hover:text-white text-[11px] font-bold uppercase tracking-wider transition">
                                            Renew
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-neutral-500">
                                    No subscription history on record yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
