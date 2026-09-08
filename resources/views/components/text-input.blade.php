@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-neutral-950 border border-neutral-800 text-white placeholder-neutral-500 focus:border-rose-500 focus:ring-1 focus:ring-rose-500 rounded-xl shadow-sm']) }}>
