{{-- resources/views/components/section.blade.php --}}
<section {{ $attributes->merge(['class' => 'py-20 px-4']) }}>
    <div class="max-w-6xl mx-auto">
        {{ $slot }}
    </div>
</section>
