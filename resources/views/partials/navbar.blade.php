<header x-data="{ mobileMenuOpen: false, userDropdownOpen: false }" class="sticky top-0 z-50 w-full bg-neutral-950/90 backdrop-blur-md border-b border-neutral-800/80 transition duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-rose-500 to-rose-700 flex items-center justify-center shadow-lg shadow-rose-900/40 group-hover:scale-105 transition duration-300">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-black tracking-wider uppercase text-white font-sans">
                        IRON<span class="text-rose-500">PULSE</span>
                    </span>
                    <span class="block text-[10px] tracking-widest text-neutral-400 font-semibold uppercase -mt-1">
                        Gym & Fitness
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden md:flex items-center space-x-1 lg:space-x-2 text-sm font-semibold tracking-wide">
                <a href="{{ route('home') }}" 
                   class="px-3 py-2 rounded-lg transition {{ request()->routeIs('home') ? 'text-white bg-neutral-900 border border-neutral-800' : 'text-neutral-300 hover:text-white hover:bg-neutral-900/50' }}">
                    Home
                </a>
                <a href="{{ route('memberships.index') }}" 
                   class="px-3 py-2 rounded-lg transition {{ request()->routeIs('memberships.*') ? 'text-white bg-neutral-900 border border-neutral-800' : 'text-neutral-300 hover:text-white hover:bg-neutral-900/50' }}">
                    Memberships
                </a>
                <a href="{{ route('home') }}#team" 
                   class="px-3 py-2 rounded-lg transition text-neutral-300 hover:text-white hover:bg-neutral-900/50">
                    Our Team
                </a>
                <a href="{{ route('franchise.index') }}" 
                   class="px-3 py-2 rounded-lg transition {{ request()->routeIs('franchise.*') ? 'text-white bg-neutral-900 border border-neutral-800' : 'text-neutral-300 hover:text-white hover:bg-neutral-900/50' }}">
                    Own a Franchise
                </a>
                <a href="{{ route('contact.index') }}" 
                   class="px-3 py-2 rounded-lg transition {{ request()->routeIs('contact.*') ? 'text-white bg-neutral-900 border border-neutral-800' : 'text-neutral-300 hover:text-white hover:bg-neutral-900/50' }}">
                    Contact Us
                </a>
            </nav>

            <!-- Right Side CTA / Auth Area -->
            <div class="hidden md:flex items-center space-x-3">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-500 hover:to-rose-600 text-white text-xs font-bold uppercase tracking-wider shadow-lg shadow-rose-950/60 border border-rose-500/30 transition duration-200">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    @endif

                    <!-- Authenticated Dropdown -->
                    <div class="relative" @click.away="userDropdownOpen = false">
                        <button @click="userDropdownOpen = !userDropdownOpen" 
                                class="flex items-center space-x-2.5 px-3 py-2 rounded-xl bg-neutral-900 border border-neutral-800 hover:border-neutral-700 text-sm font-semibold text-white transition focus:outline-none">
                            <div class="h-8 w-8 rounded-lg bg-rose-600/20 border border-rose-500/30 flex items-center justify-center text-rose-400 font-bold overflow-hidden">
                                @if(Auth::user()->image)
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
                                @else
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                @endif
                            </div>
                            <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-neutral-400 transition-transform duration-200" :class="{ 'rotate-180': userDropdownOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="userDropdownOpen" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 rounded-xl bg-neutral-900 border border-neutral-800 shadow-2xl py-2 z-50 divide-y divide-neutral-800/60"
                             style="display: none;">
                            
                            <div class="px-4 py-2">
                                <p class="text-xs text-neutral-400">Signed in as</p>
                                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->email }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-rose-500/20 text-rose-400">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>

                            <div class="py-1">
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-semibold text-rose-400 bg-rose-950/30 hover:bg-rose-900/50 hover:text-white transition">
                                        <svg class="h-4 w-4 mr-2.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        Admin Dashboard
                                    </a>
                                @endif
                                <a href="{{ route('member.memberships') }}" class="flex items-center px-4 py-2 text-sm text-neutral-200 hover:bg-neutral-800 hover:text-white transition">
                                    <svg class="h-4 w-4 mr-2.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                    </svg>
                                    My Memberships
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-neutral-200 hover:bg-neutral-800 hover:text-white transition">
                                    <svg class="h-4 w-4 mr-2.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Profile Settings
                                </a>
                            </div>

                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-rose-400 hover:bg-rose-950/40 hover:text-rose-300 transition">
                                        <svg class="h-4 w-4 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-neutral-300 hover:text-white transition">
                        Login
                    </a>
                    <a href="{{ route('memberships.index') }}" 
                       class="px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white text-sm font-bold tracking-wide shadow-lg shadow-rose-900/50 hover:shadow-rose-700/60 hover:scale-[1.02] active:scale-[0.98] transition duration-200">
                        Join Now
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="p-2.5 rounded-xl bg-neutral-900 border border-neutral-800 text-neutral-400 hover:text-white hover:border-neutral-700 focus:outline-none transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!mobileMenuOpen">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="mobileMenuOpen" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-b border-neutral-800 bg-neutral-950/95 backdrop-blur-xl px-4 pt-3 pb-6 space-y-2"
         style="display: none;">

        <a href="{{ route('home') }}" @click="mobileMenuOpen = false" 
           class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('home') ? 'bg-neutral-900 text-white font-bold' : 'text-neutral-300 hover:text-white hover:bg-neutral-900' }}">
            Home
        </a>
        <a href="{{ route('memberships.index') }}" @click="mobileMenuOpen = false" 
           class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('memberships.*') ? 'bg-neutral-900 text-white font-bold' : 'text-neutral-300 hover:text-white hover:bg-neutral-900' }}">
            Memberships
        </a>
        <a href="{{ route('home') }}#team" @click="mobileMenuOpen = false" 
           class="block px-3 py-2.5 rounded-lg text-base font-medium text-neutral-300 hover:text-white hover:bg-neutral-900">
            Our Team
        </a>
        <a href="{{ route('franchise.index') }}" @click="mobileMenuOpen = false" 
           class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('franchise.*') ? 'bg-neutral-900 text-white font-bold' : 'text-neutral-300 hover:text-white hover:bg-neutral-900' }}">
            Own a Franchise
        </a>
        <a href="{{ route('contact.index') }}" @click="mobileMenuOpen = false" 
           class="block px-3 py-2.5 rounded-lg text-base font-medium {{ request()->routeIs('contact.*') ? 'bg-neutral-900 text-white font-bold' : 'text-neutral-300 hover:text-white hover:bg-neutral-900' }}">
            Contact Us
        </a>

        <div class="pt-4 mt-2 border-t border-neutral-800/80">
            @auth
                <div class="flex items-center space-x-3 px-3 py-2 mb-3 bg-neutral-900 rounded-xl">
                    <div class="h-9 w-9 rounded-lg bg-rose-600/30 text-rose-400 font-bold flex items-center justify-center">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-neutral-400">{{ Auth::user()->email }}</p>
                    </div>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-red-600 to-rose-700 border border-rose-500/40 hover:from-red-500 hover:to-rose-600 mb-2 transition">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Admin Dashboard
                    </a>
                @endif
                <a href="{{ route('member.memberships') }}" class="block px-3 py-2 rounded-lg text-sm text-neutral-300 hover:text-white hover:bg-neutral-900">
                    My Memberships
                </a>
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-neutral-300 hover:text-white hover:bg-neutral-900">
                    Profile Settings
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-rose-400 hover:bg-rose-950/40">
                        Log Out
                    </button>
                </form>
            @else
                <div class="grid grid-cols-2 gap-3 pt-2">
                    <a href="{{ route('login') }}" class="flex justify-center items-center px-4 py-2.5 rounded-xl bg-neutral-900 border border-neutral-800 text-neutral-200 font-semibold text-sm">
                        Login
                    </a>
                    <a href="{{ route('memberships.index') }}" class="flex justify-center items-center px-4 py-2.5 rounded-xl bg-rose-600 text-white font-bold text-sm shadow-md shadow-rose-900/50">
                        Join Now
                    </a>
                </div>
            @endauth
        </div>
    </div>
</header>
