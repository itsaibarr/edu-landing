{{-- resources/views/components/landing-nav.blade.php --}}
@props(['active' => 'home'])

<nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="/" class="font-bold text-xl text-slate-900">
            <span class="text-indigo-600">Gradus</span>
        </a>
        <div class="hidden md:flex items-center gap-6 text-sm text-slate-600">
            <a href="/institutions" class="{{ $active === 'institutions' ? 'text-indigo-600 font-semibold' : 'hover:text-slate-900' }}">For Schools</a>
            <a href="/students" class="{{ $active === 'students' ? 'text-indigo-600 font-semibold' : 'hover:text-slate-900' }}">For Students</a>
        </div>
        <div class="flex items-center gap-3">
            <x-btn href="/institutions" variant="primary" class="text-xs px-5 py-2">Join Pilot</x-btn>
        </div>
    </div>
</nav>
<div class="h-16"></div>
