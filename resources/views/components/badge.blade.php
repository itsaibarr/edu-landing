{{-- resources/views/components/badge.blade.php --}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700']) }}>
    {{ $slot }}
</span>
