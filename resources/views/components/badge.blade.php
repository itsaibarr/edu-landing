{{-- resources/views/components/badge.blade.php --}}
<span {{ $attributes->merge(['class' => 'text-xs font-semibold uppercase tracking-widest text-blue-600']) }}>
    {{ $slot }}
</span>
