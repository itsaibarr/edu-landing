{{-- resources/views/components/card.blade.php --}}
<div {{ $attributes->merge(['class' => 'border border-slate-200 rounded-xl p-6 bg-white']) }}>
    {{ $slot }}
</div>
