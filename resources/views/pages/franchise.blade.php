@extends('layouts.public')

@section('title', 'Own an IronPulse Franchise - High-Growth Fitness Opportunity')

@section('content')

<!-- Franchise Hero Banner -->
<div class="py-20 bg-gradient-to-b from-neutral-900 to-neutral-950 border-b border-neutral-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-5">
        <span class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-600/20 border border-rose-500/40 text-rose-400 text-xs font-bold tracking-widest uppercase">
            Commercial Expansion Opportunity
        </span>
        <h1 class="text-4xl sm:text-6xl font-black uppercase tracking-tight text-white font-sans max-w-4xl mx-auto leading-tight">
            OWN A PROFITABLE <span class="text-rose-500">IRONPULSE</span> FRANCHISE
        </h1>
        <p class="text-neutral-400 text-base sm:text-lg max-w-2xl mx-auto">
            Partner with an established, high-energy gym powerhouse. Leverage turnkey gym blueprints, marketing automation, and proven operational playbooks.
        </p>
        <div class="pt-2">
            <a href="#apply" class="px-8 py-3.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-rose-950/60 transition">
                Apply for Franchise Rights
            </a>
        </div>
    </div>
</div>

<!-- Benefits Section -->
<section class="py-24 bg-neutral-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
            <span class="text-rose-500 font-bold text-xs uppercase tracking-widest">Why Partner With Us</span>
            <h2 class="text-3xl sm:text-4xl font-black uppercase text-white tracking-tight">
                UNMATCHED FRANCHISE ADVANTAGES
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-8 rounded-3xl bg-neutral-900 border border-neutral-800 space-y-4 hover:border-rose-500/50 transition">
                <div class="h-12 w-12 rounded-2xl bg-rose-600/10 border border-rose-500/20 text-rose-500 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <h3 class="text-xl font-bold uppercase text-white">Rapid Return on Capital</h3>
                <p class="text-neutral-400 text-xs sm:text-sm leading-relaxed">
                    Industry-leading recurring membership revenue model with multi-tier subscription plans, merchandise sales, and personal coaching add-ons.
                </p>
            </div>

            <div class="p-8 rounded-3xl bg-neutral-900 border border-neutral-800 space-y-4 hover:border-rose-500/50 transition">
                <div class="h-12 w-12 rounded-2xl bg-rose-600/10 border border-rose-500/20 text-rose-500 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
                <h3 class="text-xl font-bold uppercase text-white">Complete Turnkey Setup</h3>
                <p class="text-neutral-400 text-xs sm:text-sm leading-relaxed">
                    From architectural layout, acoustics, and Olympic equipment procurement to staff hiring and management software training.
                </p>
            </div>

            <div class="p-8 rounded-3xl bg-neutral-900 border border-neutral-800 space-y-4 hover:border-rose-500/50 transition">
                <div class="h-12 w-12 rounded-2xl bg-rose-600/10 border border-rose-500/20 text-rose-500 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                </div>
                <h3 class="text-xl font-bold uppercase text-white">Centralized Marketing Power</h3>
                <p class="text-neutral-400 text-xs sm:text-sm leading-relaxed">
                    Benefit from national digital campaigns, influencer sponsorships, and pre-launch membership sales driving cash-flow before opening day.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- Requirements & Steps Timeline -->
<section class="py-24 bg-neutral-900/30 border-y border-neutral-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
        
        <!-- Requirements Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
            <div>
                <span class="text-rose-500 font-bold text-xs uppercase tracking-widest">Eligibility</span>
                <h2 class="text-3xl font-black uppercase text-white tracking-tight mt-2">
                    INVESTMENT REQUIREMENTS
                </h2>
                <p class="text-neutral-400 text-sm mt-3 leading-relaxed">
                    We select visionary franchise partners committed to upholding the IronPulse standard of excellence and community passion.
                </p>
            </div>

            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-6 rounded-2xl bg-neutral-900 border border-neutral-800">
                    <span class="text-xs text-rose-500 font-bold uppercase">Estimated Investment</span>
                    <p class="text-2xl font-black text-white mt-1">$150,000 - $350,000</p>
                    <p class="text-xs text-neutral-400 mt-1">Depends on facility size and fit-out specifications.</p>
                </div>

                <div class="p-6 rounded-2xl bg-neutral-900 border border-neutral-800">
                    <span class="text-xs text-rose-500 font-bold uppercase">Minimum Facility Size</span>
                    <p class="text-2xl font-black text-white mt-1">600 - 1,500 m²</p>
                    <p class="text-xs text-neutral-400 mt-1">High-ceiling commercial spaces with prime street visibility.</p>
                </div>

                <div class="p-6 rounded-2xl bg-neutral-900 border border-neutral-800">
                    <span class="text-xs text-rose-500 font-bold uppercase">Royalty & Tech Fee</span>
                    <p class="text-2xl font-black text-white mt-1">5% Monthly</p>
                    <p class="text-xs text-neutral-400 mt-1">Includes continuous software, curriculum, and brand marketing support.</p>
                </div>

                <div class="p-6 rounded-2xl bg-neutral-900 border border-neutral-800">
                    <span class="text-xs text-rose-500 font-bold uppercase">Average Payback Period</span>
                    <p class="text-2xl font-black text-white mt-1">18 - 28 Months</p>
                    <p class="text-xs text-neutral-400 mt-1">Based on performance metrics across our flagship branches.</p>
                </div>
            </div>
        </div>

        <!-- 4 Steps Timeline -->
        <div class="space-y-12">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="text-rose-500 font-bold text-xs uppercase tracking-widest">Simple Roadmap</span>
                <h2 class="text-3xl font-black uppercase text-white tracking-tight">
                    THE 4-STEP ONBOARDING PROCESS
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="p-6 rounded-2xl bg-neutral-900 border border-neutral-800 relative">
                    <span class="text-4xl font-black text-neutral-800 absolute top-4 right-4">01</span>
                    <h4 class="text-base font-bold text-white uppercase mb-2">Apply Online</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed">Submit the initial franchise questionnaire with your city preference and available investment capital.</p>
                </div>

                <div class="p-6 rounded-2xl bg-neutral-900 border border-neutral-800 relative">
                    <span class="text-4xl font-black text-neutral-800 absolute top-4 right-4">02</span>
                    <h4 class="text-base font-bold text-white uppercase mb-2">Executive Interview</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed">Meet with our expansion leadership to review financial models, territorial exclusivity, and disclosures.</p>
                </div>

                <div class="p-6 rounded-2xl bg-neutral-900 border border-neutral-800 relative">
                    <span class="text-4xl font-black text-neutral-800 absolute top-4 right-4">03</span>
                    <h4 class="text-base font-bold text-white uppercase mb-2">Site Selection & Fit-Out</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed">Our real estate and design teams oversee property acquisition, architectural plans, and equipment fit-out.</p>
                </div>

                <div class="p-6 rounded-2xl bg-neutral-900 border border-neutral-800 relative">
                    <span class="text-4xl font-black text-neutral-800 absolute top-4 right-4">04</span>
                    <h4 class="text-base font-bold text-white uppercase mb-2">Grand Opening</h4>
                    <p class="text-xs text-neutral-400 leading-relaxed">Launch with a massive marketing blitz, pre-sale member registrations, and grand opening events.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Franchise Application Form (id="apply") -->
<section id="apply" class="py-24 bg-neutral-950 scroll-mt-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="rounded-3xl bg-neutral-900 border border-neutral-800 p-8 sm:p-12 shadow-2xl space-y-8">
            <div class="text-center space-y-3">
                <span class="text-rose-500 font-bold text-xs uppercase tracking-widest">Confidential Questionnaire</span>
                <h2 class="text-3xl sm:text-4xl font-black uppercase tracking-tight text-white">
                    FRANCHISE APPLICATION FORM
                </h2>
                <p class="text-xs text-neutral-400 max-w-lg mx-auto">
                    Fill out the form below to begin the qualification process. All inquiries remain strictly confidential.
                </p>
            </div>

            <form action="{{ route('franchise.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="full_name" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                            Full Legal Name <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" required
                               placeholder="e.g. Youssef El-Sayed"
                               class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        @error('full_name')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                            Business Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               placeholder="e.g. youssef@investments.com"
                               class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        @error('email')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                            Phone / WhatsApp <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" required
                               placeholder="+20 10 9876 5432"
                               class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        @error('phone')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="city" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                            Target City / Region <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required
                               placeholder="e.g. Mansoura / Sheikh Zayed"
                               class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        @error('city')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="capital" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                            Available Capital <span class="text-rose-500">*</span>
                        </label>
                        <select name="capital" id="capital" required
                                class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            <option value="">Select capital range</option>
                            <option value="$150,000 - $250,000" {{ old('capital') == '$150,000 - $250,000' ? 'selected' : '' }}>$150k - $250k</option>
                            <option value="$250,000 - $400,000" {{ old('capital') == '$250,000 - $400,000' ? 'selected' : '' }}>$250k - $400k</option>
                            <option value="$400,000+" {{ old('capital') == '$400,000+' ? 'selected' : '' }}>$400,000+ (Multi-Unit)</option>
                        </select>
                        @error('capital')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                        Business Background & Additional Notes
                    </label>
                    <textarea name="message" id="message" rows="4"
                              placeholder="Tell us about your previous business experience, existing commercial property (if any), or specific inquiries..."
                              class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full py-4 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-sm uppercase tracking-wider shadow-xl shadow-rose-950/60 hover:shadow-rose-600/40 transition duration-200">
                    Submit Franchise Application &rarr;
                </button>
            </form>
        </div>

    </div>
</section>

@endsection
