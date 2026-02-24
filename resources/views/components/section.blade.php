{{-- resources/views/components/section.blade.php --}}
<section
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
    :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
    class="transition-all duration-700 ease-out py-20 px-4"
    {{ $attributes->except(['class']) }}
>
    <div class="max-w-6xl mx-auto">
        {{ $slot }}
    </div>
</section>
