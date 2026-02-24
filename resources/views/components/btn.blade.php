{{-- resources/views/components/btn.blade.php --}}
@props(['href' => null, 'variant' => 'primary', 'type' => 'button'])

@php
$classes = match($variant) {
    'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
    'secondary' => 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50',
    'ghost' => 'text-slate-600 hover:text-slate-900',
    default => 'bg-blue-600 text-white hover:bg-blue-700',
};
$base = 'inline-flex items-center justify-center px-8 py-3 rounded-lg font-semibold text-sm transition-colors duration-150 cursor-pointer';
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
