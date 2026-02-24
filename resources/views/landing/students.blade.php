{{-- resources/views/landing/students.blade.php --}}
@extends('layouts.landing')

@section('title', 'Gradus for Students — See Your Real Progress')
@section('meta_description', 'Track growth, consistency, and effort — not just grades. Join the waitlist.')

@section('content')
<x-landing-nav active="students" />

{{-- Hero --}}
<x-section class="bg-gradient-to-br from-violet-50 via-purple-50 to-slate-50 pt-28 pb-20">
    <div class="text-center max-w-4xl mx-auto">
        <x-badge class="mb-6 bg-violet-100 text-violet-700">For Students</x-badge>

        <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-slate-900 mb-6 leading-tight">
            See your<br>
            <span class="bg-gradient-to-r from-violet-600 to-purple-500 bg-clip-text text-transparent">real progress.</span>
        </h1>

        <p class="text-xl text-slate-600 mb-10 max-w-2xl mx-auto">
            Track growth, consistency, and effort — not just grades.
            Your work should feel like progress, not just numbers in a gradebook.
        </p>

        <x-btn href="#waitlist-form" variant="primary" class="text-base px-10 py-4 from-violet-600 to-purple-500">
            Join the Waitlist
        </x-btn>

        {{-- Progress visualization mockup --}}
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-4 max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-violet-100 p-5 text-left">
                <div class="text-xs text-slate-400 mb-1">Your Growth Score</div>
                <div class="text-3xl font-bold text-violet-600 mb-1">78</div>
                <div class="text-xs text-green-600">↑ +12 since last month</div>
                <div class="mt-3 bg-violet-50 rounded-full h-2">
                    <div class="bg-gradient-to-r from-violet-500 to-purple-400 h-2 rounded-full" style="width: 78%"></div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-indigo-100 p-5 text-left">
                <div class="text-xs text-slate-400 mb-1">Engagement Streak</div>
                <div class="text-3xl font-bold text-indigo-600 mb-1">14 days</div>
                <div class="text-xs text-slate-500">Consistent attendance & submissions</div>
                <div class="mt-3 flex gap-1">
                    @foreach(range(1, 14) as $day)
                    <div class="flex-1 h-4 rounded-sm {{ $day <= 14 ? 'bg-indigo-400' : 'bg-slate-100' }}"></div>
                    @endforeach
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-emerald-100 p-5 text-left">
                <div class="text-xs text-slate-400 mb-1">vs. Your Baseline</div>
                <div class="text-3xl font-bold text-emerald-600 mb-1">+23%</div>
                <div class="text-xs text-emerald-600">Better than your personal average</div>
                <div class="mt-3 text-xs text-slate-400">Based on 3 months of data</div>
            </div>
        </div>
    </div>
</x-section>

{{-- Problem Section --}}
<x-section class="bg-white">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Grades don't tell the whole story</h2>
        <p class="text-lg text-slate-500 max-w-xl mx-auto">You work hard. But grades don't reflect that effort.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card>
            <div class="text-3xl mb-4">📉</div>
            <h3 class="font-semibold text-slate-900 mb-2">Grades miss improvement</h3>
            <p class="text-slate-500 text-sm leading-relaxed">You might be improving consistently, but if you started low, grades still look bad. That's not fair.</p>
        </x-card>
        <x-card>
            <div class="text-3xl mb-4">👻</div>
            <h3 class="font-semibold text-slate-900 mb-2">Effort feels invisible</h3>
            <p class="text-slate-500 text-sm leading-relaxed">You show up every day, submit on time, engage in class — but no one tracks any of that. Only the final number counts.</p>
        </x-card>
        <x-card>
            <div class="text-3xl mb-4">🔋</div>
            <h3 class="font-semibold text-slate-900 mb-2">Motivation drops</h3>
            <p class="text-slate-500 text-sm leading-relaxed">When you can't see progress, it's easy to think you're not getting better. Visible growth changes that.</p>
        </x-card>
    </div>
</x-section>

{{-- Solution Section --}}
<x-section class="bg-slate-50">
    <div class="text-center mb-14">
        <x-badge class="mb-4 bg-violet-100 text-violet-700">The Solution</x-badge>
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Progress you can actually see.</h2>
        <p class="text-slate-600 max-w-xl mx-auto">Gradus measures what grades miss: your effort, consistency, and growth trajectory.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card>
            <div class="text-2xl font-bold text-violet-600 mb-2">Growth Score</div>
            <p class="text-slate-500 text-sm leading-relaxed">Not your grade — your improvement vs. your personal baseline. Did you get better? By how much?</p>
        </x-card>
        <x-card>
            <div class="text-2xl font-bold text-indigo-600 mb-2">Engagement Streak</div>
            <p class="text-slate-500 text-sm leading-relaxed">Tracks attendance, submission consistency, and participation. Showing up counts.</p>
        </x-card>
        <x-card>
            <div class="text-2xl font-bold text-emerald-600 mb-2">Progress Trends</div>
            <p class="text-slate-500 text-sm leading-relaxed">Visual timeline of your progress over weeks and months. See the momentum building.</p>
        </x-card>
    </div>
</x-section>

{{-- Value Section --}}
<x-section class="bg-white">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
        @foreach([
            ['Visible growth', 'See your improvement clearly — even when grades haven\'t caught up yet.', '📈'],
            ['Fairer reflection', 'Your effort and consistency are tracked, not just your final exam score.', '⚖️'],
            ['Motivation through progress', 'Seeing growth compounds motivation. Progress is addictive.', '🚀'],
        ] as [$title, $desc, $emoji])
        <div class="p-6">
            <div class="text-4xl mb-4">{{ $emoji }}</div>
            <h3 class="font-semibold text-slate-900 mb-2">{{ $title }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</x-section>

{{-- Waitlist CTA --}}
<x-section class="bg-gradient-to-br from-violet-600 to-purple-600" id="waitlist-form">
    <div class="max-w-2xl mx-auto text-center mb-10">
        <x-badge class="bg-white/20 text-white border-0 mb-6">Join the Waitlist</x-badge>
        <h2 class="text-3xl font-bold text-white mb-4">
            Be the first to see your real progress.
        </h2>
        <p class="text-violet-200">
            In the AI era, outcomes are easy to generate — real progress is harder to see. We make learning growth visible again.
        </p>
    </div>
    <div class="max-w-md mx-auto bg-white rounded-2xl shadow-2xl p-8">
        <livewire:waitlist-form />
    </div>
</x-section>

<x-landing-footer />

@endsection
