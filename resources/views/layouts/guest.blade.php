<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'IRONPULSE') }} - Access Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-neutral-950 text-neutral-100 selection:bg-rose-600 selection:text-white min-h-screen flex flex-col justify-between">
        
        <!-- Subtle background glow -->
        <div class="fixed inset-0 bg-radial-at-t from-rose-950/20 via-neutral-950 to-neutral-950 pointer-events-none -z-10"></div>

        <div class="flex-grow flex flex-col sm:justify-center items-center px-4 py-12 sm:pt-0">
            <!-- Brand Logo -->
            <div class="mb-8">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-rose-500 to-rose-700 flex items-center justify-center shadow-xl shadow-rose-900/50 group-hover:scale-105 transition">
                        <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-2xl font-black tracking-wider uppercase text-white font-sans">
                            IRON<span class="text-rose-500">PULSE</span>
                        </span>
                        <span class="block text-[10px] tracking-widest text-neutral-400 font-semibold uppercase -mt-1">
                            Athlete Portal
                        </span>
                    </div>
                </a>
            </div>

            <!-- Card Box -->
            <div class="w-full sm:max-w-md p-8 sm:p-10 bg-neutral-900 border border-neutral-800 shadow-2xl shadow-black/80 rounded-3xl">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-xs text-neutral-500">
                <a href="{{ route('home') }}" class="hover:text-neutral-300 transition">&larr; Return to IronPulse Home</a>
            </div>
        </div>

        <footer class="py-6 text-center text-xs text-neutral-600 border-t border-neutral-900">
            &copy; {{ date('Y') }} IronPulse Gym. All rights reserved.
        </footer>
    </body>
</html>
