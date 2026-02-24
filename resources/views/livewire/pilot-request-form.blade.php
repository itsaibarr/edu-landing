<div>
    @if($submitted)
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Thank you!</h3>
            <p class="text-slate-500">We'll reach out within 2 business days to discuss the pilot.</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Full Name *</label>
                    <input wire:model="name" type="text" placeholder="Asel Nurova"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm @error('name') border-red-400 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Work Email *</label>
                    <input wire:model="email" type="email" placeholder="you@school.edu"
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Institution *</label>
                <input wire:model="institution" type="text" placeholder="School #42, Almaty"
                       class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm @error('institution') border-red-400 @enderror">
                @error('institution') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Your Role *</label>
                <select wire:model="role"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm @error('role') border-red-400 @enderror">
                    <option value="">Select role...</option>
                    <option value="admin">Administrator / Director</option>
                    <option value="teacher">Teacher</option>
                    <option value="other">Other</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Biggest challenge (optional)</label>
                <textarea wire:model="challenge" rows="3" placeholder="What's the hardest thing about tracking student progress today?"
                          class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm resize-none"></textarea>
            </div>
            <x-btn type="submit" variant="primary" class="w-full text-base py-4">
                <span wire:loading.remove>Request Pilot Access</span>
                <span wire:loading>Sending...</span>
            </x-btn>
            <p class="text-xs text-center text-slate-400">No spam. Pilot conversations only.</p>
        </form>
    @endif
</div>
