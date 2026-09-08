<li {{ $attributes->merge(['class' => ($active ?? false) ? 'bg-gray-700' : '']) }}>
    <a href="{{ $href }}" class="flex items-center px-4 py-2 text-sm font-medium {{ ($active ?? false) ? 'text-white' : 'text-gray-400 hover:text-white' }}">
        @if(isset($icon))
            <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <!-- Simple placeholder icons based on name -->
                @switch($icon)
                    @case('home')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                        @break
                    @case('building')
                        <rect width="20" height="14" x="2" y="5" rx="2" ry="2" />
                        <path d="M2 10h20" />
                        @break
                    @default
                        <circle cx="12" cy="12" r="10" />
                @endswitch
            </svg>
        @endif
        {{ $slot }}
    </a>
</li>
