# Landing Page Redesign — Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Replace the AI-pattern-heavy design (purple gradients, emoji icons, mock dashboards) with a production-level editorial style modeled on Linear — white/slate-50 backgrounds, blue-600 as the sole accent, SVG line icons, slate-900 CTAs.

**Architecture:** Pure view-layer changes only. No PHP logic, models, migrations, or routes touched. Shared Blade components updated first so changes propagate everywhere, then each page updated individually.

**Tech Stack:** Laravel 11 Blade, Tailwind CSS v4, Alpine.js 3 (scroll animation removed)

---

### Task 1: Update shared Blade components

**Files:**
- Modify: `resources/views/components/badge.blade.php`
- Modify: `resources/views/components/card.blade.php`
- Modify: `resources/views/components/btn.blade.php`
- Modify: `resources/views/components/section.blade.php`
- Modify: `resources/views/components/landing-nav.blade.php`

**Step 1: Verify tests pass before any changes**

```bash
php artisan test
```
Expected: 5 tests, 5 passed.

**Step 2: Replace badge component**

Replace the entire contents of `resources/views/components/badge.blade.php` with:

```blade
{{-- resources/views/components/badge.blade.php --}}
<span {{ $attributes->merge(['class' => 'text-xs font-semibold uppercase tracking-widest text-blue-600']) }}>
    {{ $slot }}
</span>
```

**Step 3: Replace card component**

Replace the entire contents of `resources/views/components/card.blade.php` with:

```blade
{{-- resources/views/components/card.blade.php --}}
<div {{ $attributes->merge(['class' => 'border border-slate-200 rounded-xl p-6 bg-white']) }}>
    {{ $slot }}
</div>
```

**Step 4: Replace btn component**

Replace the entire contents of `resources/views/components/btn.blade.php` with:

```blade
{{-- resources/views/components/btn.blade.php --}}
@props(['href' => null, 'variant' => 'primary', 'type' => 'button'])

@php
$classes = match($variant) {
    'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',
    'secondary' => 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50',
    'ghost' => 'text-slate-600 hover:text-slate-900',
    default => 'bg-blue-600 text-white hover:bg-blue-700',
};
$base = 'inline-flex items-center justify-center px-8 py-3 rounded-lg font-semibold text-sm transition-colors duration-150 cursor-pointer';
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$base $classes"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$base $classes"]) }}>
        {{ $slot }}
    </button>
@endif
```

**Step 5: Replace section component — remove Alpine scroll-reveal**

Replace the entire contents of `resources/views/components/section.blade.php` with:

```blade
{{-- resources/views/components/section.blade.php --}}
<section class="py-20 px-4" {{ $attributes }}>
    <div class="max-w-6xl mx-auto">
        {{ $slot }}
    </div>
</section>
```

**Step 6: Update landing-nav — indigo → blue**

Replace the entire contents of `resources/views/components/landing-nav.blade.php` with:

```blade
{{-- resources/views/components/landing-nav.blade.php --}}
@props(['active' => 'home'])

<nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-sm border-b border-slate-100">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
        <a href="/" class="font-bold text-xl text-slate-900">
            <span class="text-blue-600">Gradus</span>
        </a>
        <div class="hidden md:flex items-center gap-6 text-sm text-slate-600">
            <a href="/institutions" class="{{ $active === 'institutions' ? 'text-blue-600 font-semibold' : 'hover:text-slate-900' }}">For Schools</a>
            <a href="/students" class="{{ $active === 'students' ? 'text-blue-600 font-semibold' : 'hover:text-slate-900' }}">For Students</a>
        </div>
        <div class="flex items-center gap-3">
            <x-btn href="/institutions" variant="primary" class="text-xs px-5 py-2">Join Pilot</x-btn>
        </div>
    </div>
</nav>
<div class="h-16"></div>
```

**Step 7: Run tests to confirm nothing broken**

```bash
php artisan test
```
Expected: 5 tests, 5 passed.

**Step 8: Commit**

```bash
git add resources/views/components/
git commit -m "refactor: update shared components to editorial design system"
```

---

### Task 2: Redesign home page

**Files:**
- Modify: `resources/views/landing/home.blade.php`

**Step 1: Replace home page**

Replace the entire contents of `resources/views/landing/home.blade.php` with:

```blade
{{-- resources/views/landing/home.blade.php --}}
@extends('layouts.landing')

@section('title', 'Gradus — Who Are You?')
@section('meta_description', 'Gradus tracks student growth and engagement in real time. Choose your path.')
@section('og_title', 'Gradus — Who Are You?')
@section('og_description', 'Gradus tracks student growth and engagement in real time. Choose your path.')

@section('content')
<x-landing-nav />

<main class="min-h-screen flex flex-col items-center justify-center px-4 bg-white">
    <div class="text-center max-w-2xl">
        <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-6">Early Access</p>

        <h1 class="text-5xl font-bold tracking-tight text-slate-900 mb-4">
            Who are you?
        </h1>
        <p class="text-xl text-slate-500 mb-12">
            Gradus works differently depending on your role. Choose your path.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-xl mx-auto">
            <a href="/institutions"
               class="group flex flex-col items-center gap-4 p-8 bg-white rounded-xl border border-slate-200 hover:border-blue-200 hover:shadow-sm transition-all duration-150">
                <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-150">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-slate-900 text-base">School or University</div>
                    <div class="text-sm text-slate-500 mt-1">Administrators & Teachers</div>
                </div>
                <div class="text-blue-600 text-sm font-medium">See how it works →</div>
            </a>

            <a href="/students"
               class="group flex flex-col items-center gap-4 p-8 bg-white rounded-xl border border-slate-200 hover:border-blue-200 hover:shadow-sm transition-all duration-150">
                <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center text-slate-500 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-150">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-semibold text-slate-900 text-base">Student</div>
                    <div class="text-sm text-slate-500 mt-1">Track your own progress</div>
                </div>
                <div class="text-blue-600 text-sm font-medium">Join the waitlist →</div>
            </a>
        </div>

        <p class="mt-10 text-xs text-slate-400">
            In the AI era, outcomes are easy to generate — real progress is harder to see. We make learning growth visible again.
        </p>
    </div>
</main>

<x-landing-footer />
@endsection
```

**Step 2: Run tests**

```bash
php artisan test
```
Expected: 5 tests, 5 passed. (`assertSee('Who are you?')` must still pass.)

**Step 3: Commit**

```bash
git add resources/views/landing/home.blade.php
git commit -m "refactor: redesign home page to editorial style"
```

---

### Task 3: Redesign institutions page

**Files:**
- Modify: `resources/views/landing/institutions.blade.php`

**Step 1: Replace institutions page**

Replace the entire contents of `resources/views/landing/institutions.blade.php` with:

```blade
{{-- resources/views/landing/institutions.blade.php --}}
@extends('layouts.landing')

@section('title', 'Gradus for Schools & Universities — Make Student Growth Visible')
@section('meta_description', 'Track student engagement and learning momentum without changing teacher workflows. Join our pilot.')
@section('og_title', 'Gradus for Schools & Universities — Make Student Growth Visible')
@section('og_description', 'Track student engagement and learning momentum without changing teacher workflows. Join our pilot.')

@section('content')
<x-landing-nav active="institutions" />

{{-- Hero --}}
<x-section class="bg-white pt-28 pb-20">
    <div class="text-center max-w-4xl mx-auto">
        <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-6">For Schools & Universities</p>

        <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-slate-900 mb-6 leading-tight">
            Make student<br>
            <span class="bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">growth visible.</span>
        </h1>

        <p class="text-xl text-slate-600 mb-4 max-w-2xl mx-auto">
            Track engagement and learning momentum without changing teacher workflows.
        </p>
        <p class="text-sm text-slate-400 mb-10">Works alongside existing systems like Kundelik.</p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <x-btn href="#pilot-form" variant="primary" class="text-base px-10 py-4">
                Request Pilot Access
            </x-btn>
            <x-btn href="#how-it-works" variant="secondary" class="text-base px-10 py-4">
                See How It Works
            </x-btn>
        </div>
    </div>
</x-section>

{{-- Problem Section --}}
<x-section class="bg-slate-50">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">The problem with grades</h2>
        <p class="text-lg text-slate-500 max-w-xl mx-auto">Grades show outcomes, but they hide what's actually happening.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card>
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">Grades hide engagement</h3>
            <p class="text-slate-500 text-sm leading-relaxed">A student can pass with copied work or disengage entirely — grades won't show the difference.</p>
        </x-card>
        <x-card>
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">Disengagement is detected late</h3>
            <p class="text-slate-500 text-sm leading-relaxed">By the time a student's grades drop, they've often been disengaged for weeks.</p>
        </x-card>
        <x-card>
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">Reporting without insight</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Schools have data, but no clarity on student momentum, effort, or early warning signals.</p>
        </x-card>
    </div>
</x-section>

{{-- Solution Section --}}
<x-section class="bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-4">The Solution</p>
            <h2 class="text-3xl font-bold text-slate-900 mb-6">
                A progress layer on top of your existing systems.
            </h2>
            <p class="text-slate-600 leading-relaxed mb-8">
                Gradus transforms existing academic data — attendance, assignments, grades — into two clear signals:
                the <strong class="text-slate-900">Engagement Index</strong> and the <strong class="text-slate-900">Growth Score</strong>.
                Teachers do nothing new. Schools gain a real-time picture of learning momentum.
            </p>
            <ul class="space-y-3">
                @foreach(['No additional teacher workload', 'Works with your current systems (e.g., Kundelik)', 'Real-time engagement and growth signals', 'Early warning for at-risk students'] as $item)
                <li class="flex items-center gap-3 text-slate-700 text-sm">
                    <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
        </div>
        <div class="border border-slate-200 rounded-xl p-8 bg-white space-y-6">
            <div class="border-b border-slate-100 pb-6">
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-2">Engagement Index</p>
                <p class="text-lg font-semibold text-slate-900">Student engagement score</p>
                <p class="text-sm text-slate-500 mt-2 leading-relaxed">Attendance, submission consistency, and participation — combined into a single real-time signal per student.</p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-2">Growth Score</p>
                <p class="text-lg font-semibold text-slate-900">Personal improvement rate</p>
                <p class="text-sm text-slate-500 mt-2 leading-relaxed">Progress measured against each student's own baseline — not their classmates or the class average.</p>
            </div>
        </div>
    </div>
</x-section>

{{-- Value Section --}}
<x-section class="bg-slate-50" id="value">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Built for everyone in the school</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card>
            <div class="w-9 h-9 bg-slate-100 rounded-lg flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">For Administrators</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Clear engagement analytics across classes. Early intervention signals before grades drop. Better decisions with real-time insight.</p>
        </x-card>
        <x-card>
            <div class="w-9 h-9 bg-slate-100 rounded-lg flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">For Teachers</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Zero additional workload. Continue using current workflows. Gradus works as an invisible layer on top of what you already do.</p>
        </x-card>
        <x-card>
            <div class="w-9 h-9 bg-slate-100 rounded-lg flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">For Institutions</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Track learning momentum school-wide. Demonstrate real educational value beyond grades to parents and accreditation bodies.</p>
        </x-card>
    </div>
</x-section>

{{-- How It Works --}}
<x-section class="bg-white" id="how-it-works">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">How it works in 3 steps</h2>
        <p class="text-slate-500 max-w-md mx-auto">No complex onboarding. No teacher retraining.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
        <div class="hidden md:block absolute top-6 left-1/4 right-1/4 h-px bg-slate-200"></div>
        @foreach([
            ['01', 'Connect your data', 'Share existing grade and attendance data via CSV, API, or our Kundelik connector.'],
            ['02', 'Gradus calculates signals', 'The platform computes Engagement Index and Growth Score per student, class, and school.'],
            ['03', 'Schools see insight', 'Administrators and teachers access a clear real-time dashboard of learning momentum.'],
        ] as [$num, $title, $desc])
        <div class="relative text-center">
            <div class="w-12 h-12 rounded-full bg-slate-900 text-white text-sm font-bold flex items-center justify-center mx-auto mb-4">
                {{ $num }}
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">{{ $title }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</x-section>

{{-- Pilot CTA Section --}}
<x-section class="bg-slate-900" id="pilot-form">
    <div class="max-w-2xl mx-auto text-center mb-10">
        <p class="text-xs font-semibold uppercase tracking-widest text-blue-400 mb-6">Limited Pilot Spots</p>
        <h2 class="text-3xl font-bold text-white mb-4">
            Looking for pilot schools and universities.
        </h2>
        <p class="text-slate-400">
            We're running a limited pilot with 5–10 schools. If you want to be among the first to see real learning momentum data, apply below.
        </p>
    </div>
    <div class="max-w-xl mx-auto bg-white rounded-xl shadow-none border border-slate-200 p-8">
        <livewire:pilot-request-form />
    </div>
</x-section>

<x-landing-footer />
@endsection
```

**Step 2: Run tests**

```bash
php artisan test
```
Expected: 5 tests, 5 passed. (`assertSee('The problem with grades')` must still pass.)

**Step 3: Commit**

```bash
git add resources/views/landing/institutions.blade.php
git commit -m "refactor: redesign institutions page to editorial style"
```

---

### Task 4: Redesign students page

**Files:**
- Modify: `resources/views/landing/students.blade.php`

**Step 1: Replace students page**

Replace the entire contents of `resources/views/landing/students.blade.php` with:

```blade
{{-- resources/views/landing/students.blade.php --}}
@extends('layouts.landing')

@section('title', 'Gradus for Students — See Your Real Progress')
@section('meta_description', 'Track growth, consistency, and effort — not just grades. Join the waitlist.')
@section('og_title', 'Gradus for Students — See Your Real Progress')
@section('og_description', 'Track growth, consistency, and effort — not just grades. Join the waitlist.')

@section('content')
<x-landing-nav active="students" />

{{-- Hero --}}
<x-section class="bg-white pt-28 pb-20">
    <div class="text-center max-w-4xl mx-auto">
        <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-6">For Students</p>

        <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-slate-900 mb-6 leading-tight">
            See your<br>
            <span class="bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent">real progress.</span>
        </h1>

        <p class="text-xl text-slate-600 mb-10 max-w-2xl mx-auto">
            Track growth, consistency, and effort — not just grades.
            Your work should feel like progress, not just numbers in a gradebook.
        </p>

        <x-btn href="#waitlist-form" variant="primary" class="text-base px-10 py-4">
            Join the Waitlist
        </x-btn>
    </div>
</x-section>

{{-- Problem Section --}}
<x-section class="bg-slate-50">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Grades don't tell the whole story</h2>
        <p class="text-lg text-slate-500 max-w-xl mx-auto">You work hard. But grades don't reflect that effort.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card>
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">Grades miss improvement</h3>
            <p class="text-slate-500 text-sm leading-relaxed">You might be improving consistently, but if you started low, grades still look bad. That's not fair.</p>
        </x-card>
        <x-card>
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">Effort feels invisible</h3>
            <p class="text-slate-500 text-sm leading-relaxed">You show up every day, submit on time, engage in class — but no one tracks any of that. Only the final number counts.</p>
        </x-card>
        <x-card>
            <div class="w-9 h-9 rounded-lg bg-slate-100 flex items-center justify-center mb-4 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">Motivation drops</h3>
            <p class="text-slate-500 text-sm leading-relaxed">When you can't see progress, it's easy to think you're not getting better. Visible growth changes that.</p>
        </x-card>
    </div>
</x-section>

{{-- Solution Section --}}
<x-section class="bg-white">
    <div class="text-center mb-14">
        <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-4">The Solution</p>
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Progress you can actually see.</h2>
        <p class="text-slate-600 max-w-xl mx-auto">Gradus measures what grades miss: your effort, consistency, and growth trajectory.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card>
            <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-3">Growth Score</p>
            <h3 class="font-semibold text-slate-900 mb-2">Your improvement rate</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Not your grade — your improvement vs. your personal baseline. Did you get better? By how much?</p>
        </x-card>
        <x-card>
            <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-3">Engagement Streak</p>
            <h3 class="font-semibold text-slate-900 mb-2">Showing up counts</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Tracks attendance, submission consistency, and participation. Your consistency is visible.</p>
        </x-card>
        <x-card>
            <p class="text-xs font-semibold uppercase tracking-widest text-blue-600 mb-3">Progress Trends</p>
            <h3 class="font-semibold text-slate-900 mb-2">See the momentum</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Visual timeline of your progress over weeks and months. See the momentum building.</p>
        </x-card>
    </div>
</x-section>

{{-- Value Section --}}
<x-section class="bg-slate-50">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach([
            ['Visible growth', 'See your improvement clearly — even when grades haven\'t caught up yet.', 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
            ['Fairer reflection', 'Your effort and consistency are tracked, not just your final exam score.', 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3'],
            ['Motivation through progress', 'Seeing growth compounds motivation. Progress is addictive.', 'M5 10l7-7m0 0l7 7m-7-7v18'],
        ] as [$title, $desc, $path])
        <div class="flex gap-4">
            <div class="w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center flex-shrink-0 text-slate-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $path }}"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-slate-900 mb-1">{{ $title }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $desc }}</p>
            </div>
        </div>
        @endforeach
    </div>
</x-section>

{{-- Waitlist CTA --}}
<x-section class="bg-slate-900" id="waitlist-form">
    <div class="max-w-2xl mx-auto text-center mb-10">
        <p class="text-xs font-semibold uppercase tracking-widest text-blue-400 mb-6">Join the Waitlist</p>
        <h2 class="text-3xl font-bold text-white mb-4">
            Be the first to see your real progress.
        </h2>
        <p class="text-slate-400">
            In the AI era, outcomes are easy to generate — real progress is harder to see. We make learning growth visible again.
        </p>
    </div>
    <div class="max-w-md mx-auto bg-white rounded-xl border border-slate-200 p-8">
        <livewire:waitlist-form />
    </div>
</x-section>

<x-landing-footer />

@endsection
```

**Step 2: Run tests**

```bash
php artisan test
```
Expected: 5 tests, 5 passed. (`assertSee('Grades don')` must still pass.)

**Step 3: Commit**

```bash
git add resources/views/landing/students.blade.php
git commit -m "refactor: redesign students page to editorial style"
```

---

### Task 5: Final build verification

**Step 1: Run full test suite**

```bash
php artisan test
```
Expected: 5 tests, 5 passed.

**Step 2: Run production build**

```bash
npm run build
```
Expected: Build succeeds with no errors.

**Step 3: Commit build artifacts if any changed**

```bash
git add public/build/
git commit -m "chore: production build after landing page redesign"
```

If no files changed in `public/build/`, skip the commit.
