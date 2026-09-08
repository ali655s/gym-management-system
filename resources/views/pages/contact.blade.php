@extends('layouts.public')

@section('title', 'Contact Us & Branch Locations - IronPulse Gym')

@section('content')

<!-- Header Banner -->
<div class="py-16 sm:py-20 bg-gradient-to-b from-neutral-900 to-neutral-950 border-b border-neutral-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
        <span class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-rose-600/20 border border-rose-500/40 text-rose-400 text-xs font-bold tracking-widest uppercase">
            We Are Here To Assist You
        </span>
        <h1 class="text-4xl sm:text-6xl font-black uppercase tracking-tight text-white font-sans">
            CONNECT WITH IRONPULSE
        </h1>
        <p class="text-neutral-400 text-base max-w-2xl mx-auto">
            Find details for each of our flagship locations, drop by for a tour, or send our customer experience team an inquiry below.
        </p>
    </div>
</div>

<div class="py-16 bg-neutral-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        <!-- Contact Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left Info Column (5 cols) -->
            <div class="lg:col-span-5 space-y-8">
                <div>
                    <h2 class="text-2xl font-black uppercase tracking-tight text-white">Central Support</h2>
                    <p class="text-xs sm:text-sm text-neutral-400 mt-2 leading-relaxed">
                        Our membership advisors and management team are available 7 days a week to answer inquiries and schedule private facility walkthroughs.
                    </p>
                </div>

                <div class="space-y-4 text-xs sm:text-sm">
                    <div class="p-5 rounded-2xl bg-neutral-900 border border-neutral-800 flex items-start space-x-4">
                        <div class="h-10 w-10 rounded-xl bg-rose-600/20 text-rose-500 flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white uppercase text-xs">HQ Address</h4>
                            <p class="text-neutral-400 mt-1">15 Tahrir Square, Central District, Cairo, Egypt</p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-neutral-900 border border-neutral-800 flex items-start space-x-4">
                        <div class="h-10 w-10 rounded-xl bg-rose-600/20 text-rose-500 flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white uppercase text-xs">Direct Telephone</h4>
                            <p class="text-neutral-400 mt-1">+20 2 2790 0001 (Landline)</p>
                            <p class="text-neutral-400">+20 10 0000 0001 (WhatsApp)</p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-neutral-900 border border-neutral-800 flex items-start space-x-4">
                        <div class="h-10 w-10 rounded-xl bg-rose-600/20 text-rose-500 flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-white uppercase text-xs">Email Desk</h4>
                            <p class="text-neutral-400 mt-1">support@ironpulse.com</p>
                            <p class="text-neutral-400">membership@ironpulse.com</p>
                        </div>
                    </div>
                </div>

                <!-- Branch Quick List -->
                <div class="p-6 rounded-3xl bg-neutral-900/60 border border-neutral-800/80 space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-neutral-300">All Branch Arenas</h3>
                    <ul class="divide-y divide-neutral-800/80 text-xs text-neutral-400">
                        @foreach($branches as $branch)
                            <li class="py-2.5 flex justify-between items-center">
                                <div>
                                    <strong class="text-white block">{{ $branch->name }}</strong>
                                    <span class="text-neutral-500">{{ $branch->city }} &bull; {{ $branch->phone }}</span>
                                </div>
                                <a href="{{ route('memberships.index') }}#branch-{{ $branch->id }}" 
                                   class="text-[11px] font-bold text-rose-500 hover:text-rose-400 uppercase">
                                    Timetable &rarr;
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Right Form Column (7 cols) -->
            <div class="lg:col-span-7">
                <div class="p-8 sm:p-12 rounded-3xl bg-neutral-900 border border-neutral-800 shadow-2xl space-y-6">
                    <div>
                        <span class="text-rose-500 font-bold text-xs uppercase tracking-widest">Send An Inquiry</span>
                        <h3 class="text-2xl sm:text-3xl font-black uppercase text-white tracking-tight mt-1">
                            LEAVE US A MESSAGE
                        </h3>
                    </div>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="contact_name" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                                Your Full Name <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" id="contact_name" value="{{ old('name') }}" required
                                   placeholder="e.g. Tarek Mansour"
                                   class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            @error('name')
                                <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_email" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                                Email Address <span class="text-rose-500">*</span>
                            </label>
                            <input type="email" name="email" id="contact_email" value="{{ old('email') }}" required
                                   placeholder="e.g. tarek@gmail.com"
                                   class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                            @error('email')
                                <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_message" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">
                                Message / Inquiry <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="message" id="contact_message" rows="5" required
                                      placeholder="How can our coaches and staff help you today?"
                                      class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="w-full py-4 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-sm uppercase tracking-wider shadow-lg shadow-rose-950/60 hover:shadow-rose-600/40 transition duration-200">
                            Submit Message &rarr;
                        </button>
                    </form>
                </div>
            </div>

        </div>

        <!-- Interactive Google Map Embed -->
        <div class="rounded-3xl bg-neutral-900 border border-neutral-800 overflow-hidden shadow-2xl p-2 sm:p-4">
            <div class="rounded-2xl overflow-hidden aspect-21/9 min-h-[300px] w-full">
                <iframe 
                    title="IronPulse Gym Locations Map"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d110502.60389552107!2d31.188423690048827!3d30.059618470404368!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14583fa60b21beeb%3A0x79dfb296e8423bba!2sCairo%2C%20Cairo%20Governorate!5e0!3m2!1sen!2seg!4v1700000000000!5m2!1sen!2seg" 
                    width="100%" 
                    height="100%" 
                    style="border:0; filter: invert(90%) hue-rotate(180deg);" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

    </div>
</div>

@endsection
