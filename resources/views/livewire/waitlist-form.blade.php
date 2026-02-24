<div>
    @if($submitted)
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-violet-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">You're on the list!</h3>
            <p class="text-slate-500">We'll notify you when Gradus is ready for students.</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Your Name *</label>
                <input wire:model="name" type="text" placeholder="Daniyar Bekov"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-violet-500 text-sm @error('name') border-red-400 @enderror">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email *</label>
                <input wire:model="email" type="email" placeholder="you@example.com"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-violet-500 text-sm @error('email') border-red-400 @enderror">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">School or University *</label>
                <input wire:model="school" type="text" placeholder="School #42, Almaty"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-violet-500 text-sm @error('school') border-red-400 @enderror">
                @error('school') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">What frustrates you about progress tracking? (optional)</label>
                <textarea wire:model="frustration" rows="3" placeholder="The thing I hate most about grades is..."
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-violet-500 text-sm resize-none"></textarea>
            </div>
            <x-btn type="submit" variant="primary" class="w-full text-base py-4 from-violet-600 to-purple-500">
                <span wire:loading.remove>Join Waitlist</span>
                <span wire:loading>Joining...</span>
            </x-btn>
            <p class="text-xs text-center text-slate-400">Free. No commitment. We'll notify you when we launch.</p>
        </form>
    @endif
</div>
