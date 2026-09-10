@extends('layouts.public')

@section('title', 'Dominate Your Potential - IronPulse Gym')

@section('content')

<!-- ========================================================================= -->
<!-- 1. HERO SLIDER SECTION                                                    -->
<!-- ========================================================================= -->
<section x-data="{
        activeSlide: 0,
        slides: [
            {
                title: 'UNLEASH YOUR ULTIMATE STRENGTH',
                subtitle: 'World-class coaches, Olympic equipment, and high-energy training grounds built to shatter your limits.',
                cta: 'Explore Memberships',
                link: '{{ route('memberships.index') }}',
                image: 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?auto=format&fit=crop&w=1920&q=80',
                badge: 'ELITE PERFORMANCE FACILITY'
            },
            {
                title: 'CROSSFIT & HIGH INTENSITY COMBAT',
                subtitle: 'Push through mental plateaus with specialized conditioning, barbell complexes, and community grit.',
                cta: 'View Class Timetables',
                link: '{{ route('memberships.index') }}',
                image: 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=1920&q=80',
                badge: 'DAILY WOD & ADVANCED COACHING'
            },
            {
                title: 'FORGED FOR RESULTS. DRIVEN BY COMMUNITY.',
                subtitle: 'Whether building lean mass, cutting body fat, or finding your rhythm in Zumba — your transformation starts today.',
                cta: 'Join IronPulse Today',
                link: '{{ route('memberships.index') }}',
                image: 'https://images.unsplash.com/photo-1540497077202-7c8a3999166f?auto=format&fit=crop&w=1920&q=80',
                badge: '3 LOCATIONS ACROSS CAIRO, ALEX & GIZA'
            }
        ],
        timer: null,
        next() {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
        },
        prev() {
            this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
        },
        init() {
            this.timer = setInterval(() => { this.next(); }, 6500);
        }
    }"
    class="relative h-[85vh] min-h-[600px] max-h-[900px] w-full overflow-hidden bg-neutral-950">

    <!-- Slide Items -->
    <template x-for="(slide, index) in slides" :key="index">
        <div x-show="activeSlide === index"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="absolute inset-0">
            
            <!-- Background Image with Gradient Overlay -->
            <img :src="slide.image" :alt="slide.title" class="h-full w-full object-cover object-center brightness-[0.42] select-none">
            <div class="absolute inset-0 bg-gradient-to-t from-neutral-950 via-neutral-950/40 to-neutral-950/80"></div>
            <div class="absolute inset-0 bg-radial-at-c from-transparent via-black/40 to-black/80"></div>

            <!-- Slide Content -->
            <div class="absolute inset-0 flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="max-w-3xl space-y-6">
                        <span class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full bg-rose-600/20 border border-rose-500/40 text-rose-400 text-xs font-bold tracking-widest uppercase"
                              x-text="slide.badge">
                        </span>

                        <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black uppercase tracking-tight text-white leading-none font-sans"
                            x-text="slide.title">
                        </h1>

                        <p class="text-base sm:text-xl text-neutral-300 leading-relaxed font-normal max-w-2xl"
                           x-text="slide.subtitle">
                        </p>

                        <div class="pt-4 flex flex-wrap gap-4">
                            <a :href="slide.link" 
                               class="px-8 py-4 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-black text-sm uppercase tracking-wider shadow-xl shadow-rose-950/60 hover:shadow-rose-600/50 hover:scale-105 active:scale-95 transition duration-200">
                                <span x-text="slide.cta"></span>
                            </a>
                            <a href="#about" 
                               class="px-8 py-4 rounded-xl bg-neutral-900/80 hover:bg-neutral-800 text-neutral-200 hover:text-white font-bold text-sm uppercase tracking-wider border border-neutral-700/80 backdrop-blur-md transition duration-200">
                                Discover More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <!-- Slider Arrows -->
    <button @click="prev()" 
            class="absolute left-4 sm:left-8 top-1/2 -translate-y-1/2 h-12 w-12 rounded-full bg-neutral-900/60 hover:bg-rose-600 text-white border border-neutral-800 hover:border-rose-500 flex items-center justify-center backdrop-blur-md transition z-20 focus:outline-none">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
        </svg>
    </button>
    <button @click="next()" 
            class="absolute right-4 sm:right-8 top-1/2 -translate-y-1/2 h-12 w-12 rounded-full bg-neutral-900/60 hover:bg-rose-600 text-white border border-neutral-800 hover:border-rose-500 flex items-center justify-center backdrop-blur-md transition z-20 focus:outline-none">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <!-- Slider Pagination Dots -->
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center space-x-3 z-20">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="activeSlide = index"
                    class="h-2.5 rounded-full transition-all duration-300"
                    :class="activeSlide === index ? 'w-10 bg-rose-500' : 'w-2.5 bg-neutral-600 hover:bg-neutral-400'">
            </button>
        </template>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 2. QUICK STATS & ABOUT SECTION                                            -->
<!-- ========================================================================= -->
<section id="about" class="py-20 bg-neutral-900/40 border-b border-neutral-900 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 -mt-32 relative z-30 mb-20">
            <div class="p-6 rounded-2xl bg-neutral-900/90 border border-neutral-800 backdrop-blur-xl shadow-2xl hover:border-rose-500/50 transition group">
                <div class="text-rose-500 font-bold text-xs uppercase tracking-widest mb-1">Active Community</div>
                <div class="text-4xl sm:text-5xl font-black text-white font-sans tracking-tight group-hover:text-rose-500 transition">
                    {{ number_format($stats['members']) }}+
                </div>
                <p class="text-xs text-neutral-400 mt-2">Active athletes pushing their personal bests daily.</p>
            </div>

            <div class="p-6 rounded-2xl bg-neutral-900/90 border border-neutral-800 backdrop-blur-xl shadow-2xl hover:border-rose-500/50 transition group">
                <div class="text-rose-500 font-bold text-xs uppercase tracking-widest mb-1">State-of-the-Art</div>
                <div class="text-4xl sm:text-5xl font-black text-white font-sans tracking-tight group-hover:text-rose-500 transition">
                    {{ $stats['branches'] }} Branches
                </div>
                <p class="text-xs text-neutral-400 mt-2">Flagship locations across Cairo, Alexandria & Giza.</p>
            </div>

            <div class="p-6 rounded-2xl bg-neutral-900/90 border border-neutral-800 backdrop-blur-xl shadow-2xl hover:border-rose-500/50 transition group">
                <div class="text-rose-500 font-bold text-xs uppercase tracking-widest mb-1">Master Coaches</div>
                <div class="text-4xl sm:text-5xl font-black text-white font-sans tracking-tight group-hover:text-rose-500 transition">
                    {{ $stats['trainers'] }} Certified
                </div>
                <p class="text-xs text-neutral-400 mt-2">Elite specialists in CrossFit, Dance, and Hypertrophy.</p>
            </div>

            <div class="p-6 rounded-2xl bg-neutral-900/90 border border-neutral-800 backdrop-blur-xl shadow-2xl hover:border-rose-500/50 transition group">
                <div class="text-rose-500 font-bold text-xs uppercase tracking-widest mb-1">Legacy of Power</div>
                <div class="text-4xl sm:text-5xl font-black text-white font-sans tracking-tight group-hover:text-rose-500 transition">
                    {{ $stats['years'] }} Years
                </div>
                <p class="text-xs text-neutral-400 mt-2">Consistently redefining modern athletic fitness.</p>
            </div>
        </div>

        <!-- About Us Content Block -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <div class="inline-flex items-center space-x-2 text-rose-500 font-bold text-xs uppercase tracking-widest">
                    <span class="h-1.5 w-6 bg-rose-500 rounded-full"></span>
                    <span>The IronPulse Story</span>
                </div>
                <h2 class="text-3xl sm:text-5xl font-black uppercase text-white tracking-tight leading-tight">
                    BUILT FOR THOSE WHO REFUSE TO SETTLE FOR MEDIOCRE.
                </h2>
                <p class="text-neutral-300 text-base leading-relaxed">
                    Founded in 2014, IronPulse began with a clear mission: to eradicate uninspired, cookie-cutter gyms and build an unapologetic sanctuary for raw human progress.
                </p>
                <p class="text-neutral-400 text-sm leading-relaxed">
                    From customized free-weight platforms and competition CrossFit rigs to pulse-pounding rhythm Zumba sessions, every square meter of our branches is calibrated to fuel physical excellence and mental tenacity.
                </p>

                <div class="pt-2 flex flex-wrap gap-4">
                    <a href="{{ route('memberships.index') }}" 
                       class="px-6 py-3 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs uppercase tracking-wider transition">
                        View Membership Options
                    </a>
                    <a href="{{ route('franchise.index') }}" 
                       class="px-6 py-3 rounded-xl bg-neutral-800 hover:bg-neutral-700 text-white font-bold text-xs uppercase tracking-wider transition">
                        Partner With Us
                    </a>
                </div>
            </div>

            <div class="relative">
                <div class="aspect-4/3 rounded-3xl overflow-hidden border border-neutral-800 shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1574680096145-d05b474e2155?auto=format&fit=crop&w=1000&q=80" 
                         alt="IronPulse gym floor" 
                         class="h-full w-full object-cover">
                </div>
                <div class="absolute -bottom-6 -left-6 p-6 rounded-2xl bg-neutral-900 border border-neutral-800 shadow-2xl max-w-xs hidden sm:block">
                    <p class="text-rose-500 font-black text-2xl">100% Commitment</p>
                    <p class="text-neutral-400 text-xs mt-1">State-of-the-art facilities with 24/7 keycard access on select long-term tiers.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- 3. FEATURES SECTION                                                       -->
<!-- ========================================================================= -->
<section class="py-24 bg-neutral-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
            <span class="text-rose-500 font-bold text-xs uppercase tracking-widest">Why Choose IronPulse</span>
            <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                DESIGNED FOR MAXIMUM IMPACT
            </h2>
            <p class="text-neutral-400 text-base">
                Everything you need to surpass your fitness goals under one roof, backed by science-driven coaching and premium amenities.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Feature 1 -->
            <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800/80 hover:border-rose-500/50 hover:bg-neutral-900 transition duration-300 group">
                <div class="h-14 w-14 rounded-2xl bg-rose-600/10 border border-rose-500/20 text-rose-500 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-rose-600 group-hover:text-white transition duration-300">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white uppercase tracking-wide group-hover:text-rose-400 transition">Certified Master Coaches</h3>
                <p class="text-neutral-400 text-xs sm:text-sm mt-3 leading-relaxed">
                    Personalized guidance and biomechanics oversight from vetted national athletes and fitness professionals.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800/80 hover:border-rose-500/50 hover:bg-neutral-900 transition duration-300 group">
                <div class="h-14 w-14 rounded-2xl bg-rose-600/10 border border-rose-500/20 text-rose-500 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-rose-600 group-hover:text-white transition duration-300">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white uppercase tracking-wide group-hover:text-rose-400 transition">Olympic Grade Iron</h3>
                <p class="text-neutral-400 text-xs sm:text-sm mt-3 leading-relaxed">
                    Eleiko barbells, calibrated competition bumper plates, selectorized machines, and dedicated deadlift platforms.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800/80 hover:border-rose-500/50 hover:bg-neutral-900 transition duration-300 group">
                <div class="h-14 w-14 rounded-2xl bg-rose-600/10 border border-rose-500/20 text-rose-500 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-rose-600 group-hover:text-white transition duration-300">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white uppercase tracking-wide group-hover:text-rose-400 transition">Dynamic Group Classes</h3>
                <p class="text-neutral-400 text-xs sm:text-sm mt-3 leading-relaxed">
                    From high-octane CrossFit WODs to rhythm-powered Zumba workouts, stay motivated within an electric team atmosphere.
                </p>
            </div>

            <!-- Feature 4 -->
            <div class="p-8 rounded-2xl bg-neutral-900/60 border border-neutral-800/80 hover:border-rose-500/50 hover:bg-neutral-900 transition duration-300 group">
                <div class="h-14 w-14 rounded-2xl bg-rose-600/10 border border-rose-500/20 text-rose-500 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-rose-600 group-hover:text-white transition duration-300">
                    <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-white uppercase tracking-wide group-hover:text-rose-400 transition">Supportive Tribe</h3>
                <p class="text-neutral-400 text-xs sm:text-sm mt-3 leading-relaxed">
                    Zero intimidation, 100% accountability. Join a community of driven athletes celebrating every milestone.
                </p>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- 4. OUR TEAM SECTION (id="team")                                           -->
<!-- ========================================================================= -->
<section id="team" class="py-24 bg-neutral-900/30 border-y border-neutral-900 scroll-mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16">
            <div class="space-y-4">
                <span class="text-rose-500 font-bold text-xs uppercase tracking-widest">Coaching Excellence</span>
                <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                    MEET THE ELITE COACHES
                </h2>
                <p class="text-neutral-400 text-base max-w-xl">
                    Our certified coaching staff brings decades of combined competitive experience to elevate your technique, intensity, and nutrition.
                </p>
            </div>
            <div class="mt-6 md:mt-0">
                <a href="{{ route('memberships.index') }}" class="inline-flex items-center text-rose-400 hover:text-rose-300 font-bold text-sm group">
                    Train With Them
                    <svg class="h-4 w-4 ml-1.5 group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

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
                <div class="col-span-3 text-center py-12 text-neutral-500">
                    No coaches listed at this time.
                </div>
            @endforelse
        </div>

        @if($trainers->isNotEmpty())
            <!-- Show All Coaches Button -->
            <div class="mt-14 text-center">
                <a href="{{ route('trainers.index') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-neutral-900 hover:bg-rose-600 text-white font-black text-xs uppercase tracking-widest border border-neutral-800 hover:border-rose-500 shadow-xl shadow-neutral-950/50 hover:shadow-rose-950/40 hover:scale-105 active:scale-95 transition duration-300 group">
                    <span>Show All Coaches</span>
                    <svg class="h-4 w-4 ml-2.5 text-rose-500 group-hover:text-white group-hover:translate-x-1 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- ========================================================================= -->
<!-- 5. BRANCH LOCATIONS PREVIEW                                               -->
<!-- ========================================================================= -->
<section class="py-24 bg-neutral-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
            <span class="text-rose-500 font-bold text-xs uppercase tracking-widest">Our Centers</span>
            <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                LOCATED WHERE YOU THRIVE
            </h2>
            <p class="text-neutral-400 text-base">
                Three flagship training arenas across Egypt, each offering bespoke membership pricing and unique class schedules.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredBranches as $branch)
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
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 text-neutral-500">
                    No branch locations available at this time.
                </div>
            @endforelse
        </div>

        @if($featuredBranches->isNotEmpty())
            <!-- Show All Branches Button -->
            <div class="mt-14 text-center">
                <a href="{{ route('branches.index') }}" 
                   class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-neutral-900 hover:bg-rose-600 text-white font-black text-xs uppercase tracking-widest border border-neutral-800 hover:border-rose-500 shadow-xl shadow-neutral-950/50 hover:shadow-rose-950/40 hover:scale-105 active:scale-95 transition duration-300 group">
                    <span>Show All Branches</span>
                    <svg class="h-4 w-4 ml-2.5 text-rose-500 group-hover:text-white group-hover:translate-x-1 transition duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- ========================================================================= -->
<!-- 6. TESTIMONIALS SLIDER SECTION                                            -->
<!-- ========================================================================= -->
<section class="py-24 bg-neutral-900/30 border-y border-neutral-900" 
         x-data="{
             testimonials: {{ json_encode($testimonials) }},
             activeIndex: 0,
             next() {
                 this.activeIndex = (this.activeIndex + 1) % this.testimonials.length;
             },
             prev() {
                 this.activeIndex = (this.activeIndex - 1 + this.testimonials.length) % this.testimonials.length;
             }
         }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-2xl mx-auto mb-16 space-y-4">
            <span class="text-rose-500 font-bold text-xs uppercase tracking-widest">Real Results</span>
            <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                HEAR FROM OUR ATHLETES
            </h2>
        </div>

        <div class="max-w-4xl mx-auto relative px-4 sm:px-12">
            <template x-for="(t, idx) in testimonials" :key="t.id">
                <div x-show="activeIndex === idx"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="p-8 sm:p-12 rounded-3xl bg-neutral-900 border border-neutral-800 text-center space-y-6 shadow-2xl">
                    
                    <!-- Star Ratings -->
                    <div class="flex justify-center space-x-1 text-amber-400">
                        <template x-for="star in t.rating" :key="star">
                            <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </template>
                    </div>

                    <!-- Quote -->
                    <p class="text-lg sm:text-2xl text-neutral-200 font-medium italic leading-relaxed" x-text="'&ldquo;' + t.quote + '&rdquo;'"></p>

                    <!-- Member info -->
                    <div class="pt-4 border-t border-neutral-800">
                        <h4 class="text-base font-bold text-white uppercase tracking-wider" x-text="t.name"></h4>
                        <p class="text-xs text-rose-500 font-semibold" x-text="t.role"></p>
                    </div>
                </div>
            </template>

            <!-- Testimonial Controls -->
            <div class="flex justify-center items-center space-x-4 mt-8">
                <button @click="prev()" class="h-10 w-10 rounded-full bg-neutral-900 hover:bg-rose-600 border border-neutral-800 hover:border-rose-500 text-white flex items-center justify-center transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                </button>
                <div class="flex space-x-2">
                    <template x-for="(t, idx) in testimonials" :key="t.id">
                        <button @click="activeIndex = idx" 
                                class="h-2 rounded-full transition-all"
                                :class="activeIndex === idx ? 'w-6 bg-rose-500' : 'w-2 bg-neutral-700'"></button>
                    </template>
                </div>
                <button @click="next()" class="h-10 w-10 rounded-full bg-neutral-900 hover:bg-rose-600 border border-neutral-800 hover:border-rose-500 text-white flex items-center justify-center transition">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                </button>
            </div>
        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- 7. PARTNERS SECTION                                                       -->
<!-- ========================================================================= -->
<section class="py-16 bg-neutral-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-xs font-bold uppercase tracking-widest text-neutral-500 mb-8">
            OFFICIAL BRAND PARTNERS & NUTRITION SPONSORS
        </p>
        <div class="grid grid-cols-3 gap-8 items-center justify-center max-w-3xl mx-auto">
            @foreach($partners as $partner)
                <a href="{{ $partner->website ?? '#' }}" target="_blank" 
                   class="p-4 rounded-2xl bg-neutral-900/50 border border-neutral-800/80 hover:border-rose-500/50 flex items-center justify-center text-neutral-300 hover:text-white font-black text-sm uppercase tracking-widest transition group">
                    <span class="group-hover:scale-105 transition">{{ $partner->name }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- 8. CONTACT US SECTION                                                     -->
<!-- ========================================================================= -->
<section class="py-24 bg-neutral-900/40 border-t border-neutral-900 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
            
            <div class="space-y-6">
                <span class="text-rose-500 font-bold text-xs uppercase tracking-widest">Get In Touch</span>
                <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white leading-tight">
                    READY TO CRUSH YOUR GOALS? REACH OUT.
                </h2>
                <p class="text-neutral-300 text-base leading-relaxed">
                    Have questions about classes, schedules, personal training, or corporate gym memberships? Send our fitness team a message and we'll reply within 24 hours.
                </p>

                <div class="space-y-4 pt-2">
                    <div class="flex items-center space-x-4 p-4 rounded-2xl bg-neutral-900 border border-neutral-800">
                        <div class="h-10 w-10 rounded-xl bg-rose-600/20 text-rose-500 flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400">Call Directly</p>
                            <p class="text-sm font-bold text-white">+20 2 2790 0001 / +20 10 0000 0001</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 p-4 rounded-2xl bg-neutral-900 border border-neutral-800">
                        <div class="h-10 w-10 rounded-xl bg-rose-600/20 text-rose-500 flex items-center justify-center shrink-0">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-neutral-400">Email Us</p>
                            <p class="text-sm font-bold text-white">support@ironpulse.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="p-8 sm:p-10 rounded-3xl bg-neutral-900 border border-neutral-800 shadow-2xl">
                <h3 class="text-xl font-bold uppercase text-white tracking-wide mb-6">Send A Quick Message</h3>
                
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">Your Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               placeholder="e.g. Omar Khaled"
                               class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        @error('name')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required
                               placeholder="e.g. omar@example.com"
                               class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        @error('email')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-xs font-bold uppercase tracking-wider text-neutral-300 mb-1.5">Message / Inquiry</label>
                        <textarea name="message" id="message" rows="4" required
                                  placeholder="Tell us about your fitness goals or questions..."
                                  class="w-full rounded-xl bg-neutral-950 border border-neutral-800 px-4 py-3 text-sm text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full py-3.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-sm uppercase tracking-wider shadow-lg shadow-rose-950/60 hover:shadow-rose-600/40 transition duration-200">
                        Send Message
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection
