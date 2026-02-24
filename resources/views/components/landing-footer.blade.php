{{-- resources/views/components/landing-footer.blade.php --}}
<footer class="bg-slate-900 text-slate-400 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <span class="text-white font-bold text-lg">Gradus</span>
                <p class="text-sm mt-1">Grades show results, but they hide progress.</p>
            </div>
            <div class="flex gap-6 text-sm">
                <a href="/institutions" class="hover:text-white">For Schools</a>
                <a href="/students" class="hover:text-white">For Students</a>
            </div>
        </div>
        <div class="mt-8 pt-8 border-t border-slate-800 text-center text-xs">
            © {{ date('Y') }} Gradus. All rights reserved.
        </div>
    </div>
</footer>
