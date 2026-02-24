{{-- resources/views/components/btn.blade.php --}}
@props(['href' => null, 'variant' => 'primary', 'type' => 'button'])

@php
$classes = match($variant) {
    'primary' => 'bg-gradient-to-r from-indigo-600 to-violet-500 text-white hover:opacity-90',
    'secondary' => 'bg-white text-indigo-600 border border-indigo-200 hover:bg-indigo-50',
    'ghost' => 'text-slate-600 hover:text-slate-900',
    default => 'bg-indigo-600 text-white hover:bg-indigo-700',
};
$base = 'inline-flex items-center justify-center px-8 py-3 rounded-full font-semibold text-sm transition-all duration-200 cursor-pointer';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$base $classes"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$base $classes"]) }}>
        {{ $slot }}
    </button>
@endif
