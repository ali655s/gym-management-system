<footer class="bg-black border-t border-neutral-900 text-neutral-400 text-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
            
            <!-- Brand Column -->
            <div class="lg:col-span-2 space-y-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-rose-500 to-rose-700 flex items-center justify-center shadow-lg shadow-rose-900/40">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xl font-black tracking-wider uppercase text-white font-sans">
                        IRON<span class="text-rose-500">PULSE</span>
                    </span>
                </a>
                <p class="text-neutral-400 text-sm leading-relaxed max-w-sm">
                    Empowering individuals to break boundaries and achieve peak physical performance. Premium facilities, elite coaches, and an unstoppable fitness community.
                </p>
                <div class="flex items-center space-x-3 pt-2">
                    <!-- Social icons -->
                    <a href="#" class="h-9 w-9 rounded-lg bg-neutral-900 border border-neutral-800 flex items-center justify-center text-neutral-400 hover:text-rose-500 hover:border-rose-500/40 transition">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                    <a href="#" class="h-9 w-9 rounded-lg bg-neutral-900 border border-neutral-800 flex items-center justify-center text-neutral-400 hover:text-rose-500 hover:border-rose-500/40 transition">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                    </a>
                    <a href="#" class="h-9 w-9 rounded-lg bg-neutral-900 border border-neutral-800 flex items-center justify-center text-neutral-400 hover:text-rose-500 hover:border-rose-500/40 transition">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-200">Navigation</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-rose-500 transition">Home</a></li>
                    <li><a href="{{ route('memberships.index') }}" class="hover:text-rose-500 transition">Membership Plans</a></li>
                    <li><a href="{{ route('home') }}#team" class="hover:text-rose-500 transition">Our Elite Trainers</a></li>
                    <li><a href="{{ route('franchise.index') }}" class="hover:text-rose-500 transition">Franchise Partnership</a></li>
                    <li><a href="{{ route('contact.index') }}" class="hover:text-rose-500 transition">Contact & Locations</a></li>
                </ul>
            </div>

            <!-- Operating Hours -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-200">Gym Hours</h4>
                <ul class="space-y-1.5 text-xs text-neutral-400">
                    <li class="flex justify-between py-1 border-b border-neutral-900">
                        <span>Monday - Thursday</span>
                        <span class="text-neutral-200 font-medium">06:00 - 23:00</span>
                    </li>
                    <li class="flex justify-between py-1 border-b border-neutral-900">
                        <span>Friday</span>
                        <span class="text-neutral-200 font-medium">08:00 - 22:00</span>
                    </li>
                    <li class="flex justify-between py-1 border-b border-neutral-900">
                        <span>Saturday - Sunday</span>
                        <span class="text-neutral-200 font-medium">07:00 - 21:00</span>
                    </li>
                    <li class="pt-2 text-rose-400 font-semibold flex items-center">
                        <span class="h-2 w-2 rounded-full bg-rose-500 mr-2 animate-pulse"></span>
                        Keycard 24/7 Access for 6M Plan
                    </li>
                </ul>
            </div>

            <!-- Newsletter Signup -->
            <div class="space-y-3" x-data="{ subscribed: false, email: '' }">
                <h4 class="text-xs font-bold uppercase tracking-widest text-neutral-200">Stay Empowered</h4>
                <p class="text-xs text-neutral-400">Subscribe for nutrition tips, exclusive class announcements, and discounts.</p>
                
                <template x-if="!subscribed">
                    <form @submit.prevent="if(email) subscribed = true" class="space-y-2">
                        <div class="relative">
                            <input type="email" x-model="email" placeholder="Enter your email" required
                                   class="w-full rounded-xl bg-neutral-900 border border-neutral-800 px-3.5 py-2.5 text-xs text-white placeholder-neutral-500 focus:outline-none focus:border-rose-500 focus:ring-1 focus:ring-rose-500 transition">
                        </div>
                        <button type="submit" 
                                class="w-full py-2.5 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs uppercase tracking-wider shadow-md shadow-rose-900/40 transition">
                            Subscribe
                        </button>
                    </form>
                </template>

                <template x-if="subscribed">
                    <div class="p-3 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-xs">
                        Thank you for subscribing! Check your inbox soon.
                    </div>
                </template>
            </div>

        </div>

        <!-- Bottom bar -->
        <div class="mt-12 pt-8 border-t border-neutral-900 flex flex-col sm:flex-row justify-between items-center text-xs text-neutral-500 space-y-4 sm:space-y-0">
            <p>&copy; {{ date('Y') }} IronPulse Gym System. All rights reserved.</p>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-neutral-300 transition">Privacy Policy</a>
                <a href="#" class="hover:text-neutral-300 transition">Terms of Service</a>
                <a href="{{ route('franchise.index') }}" class="hover:text-neutral-300 transition">Franchise Inquiries</a>
            </div>
        </div>
    </div>
</footer>
