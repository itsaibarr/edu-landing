{{-- resources/views/components/card.blade.php --}}
<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-100 shadow-sm p-6']) }}>
    {{ $slot }}
</div>
