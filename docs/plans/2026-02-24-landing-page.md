# Landing Page Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Build a split-path landing page that validates demand from two audiences — Institutions (schools/universities) and Students — using Laravel + Livewire 3 + Tailwind CSS v4.

**Architecture:** Entry split on `/` routes users to `/institutions` or `/students`. Each path is a dedicated Blade view with Livewire form components for lead capture. No auth required — pure static content + form submissions stored in DB and sent via mail.

**Tech Stack:** Laravel 11, Livewire 3, Tailwind CSS v4, Alpine.js 3, Pest (testing), SQLite (dev), Resend (mail)

---

## Design System Reference

From inspiration image: clean SaaS style, purple/indigo primary, pink accent, white backgrounds, rounded cards, bold headings.

**Color Tokens (Tailwind config):**
```
Primary: indigo-600 (#4f46e5)
Accent: violet-500 (#8b5cf6)
Gradient: from-indigo-600 to-violet-500
Text-dark: slate-900
Text-muted: slate-500
Background: white / slate-50
Card: white with shadow-sm border border-slate-100
CTA button: bg-gradient-to-r from-indigo-600 to-violet-500 text-white rounded-full px-8 py-3
```

**Typography:**
- Heading font: Inter (loaded via Bunny Fonts)
- H1: `text-5xl font-bold tracking-tight text-slate-900`
- H2: `text-3xl font-bold text-slate-900`
- Body: `text-slate-600 text-lg leading-relaxed`

---

## Parallel Agent Assignments

| Agent | Owns | Can start |
|---|---|---|
| **Agent A** | Laravel setup + shared components + entry split | Immediately |
| **Agent B** | Institution path (`/institutions`) | After Agent A: Task 1-3 complete |
| **Agent C** | Student path (`/students`) | After Agent A: Task 1-3 complete |
| **Wire Agent** | Integration + forms + DB + mail + SEO + polish | After all three complete |

**Shared component API (Agents B & C must use these):**
```blade
{{-- Primary button --}}
<x-btn href="/institutions" variant="primary">Join Pilot</x-btn>
<x-btn href="/students" variant="secondary">Join Waitlist</x-btn>

{{-- Section wrapper --}}
<x-section class="bg-white">...</x-section>

{{-- Badge/pill --}}
<x-badge>For Schools</x-badge>

{{-- Card --}}
<x-card>...</x-card>
```

---

## Task 1 (Agent A): Laravel Project Scaffold

**Files:**
- Create: `composer.json` (via `composer create-project laravel/laravel .`)
- Modify: `vite.config.js`
- Modify: `package.json`
- Modify: `resources/css/app.css`

**Step 1: Initialize Laravel project**

```bash
cd /home/itsaibarr/projects/gamified-study
composer create-project laravel/laravel . --prefer-dist
```

Expected: Laravel 11 installed, `artisan` present.

**Step 2: Install Livewire 3**

```bash
composer require livewire/livewire
```

**Step 3: Install Tailwind CSS v4 with Vite**

```bash
npm install tailwindcss @tailwindcss/vite
```

**Step 4: Configure Tailwind v4 in Vite**

Replace `vite.config.js`:
```js
import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
    plugins: [
        laravel({ input: ['resources/css/app.css', 'resources/js/app.js'], refresh: true }),
        tailwindcss(),
    ],
})
```

**Step 5: Set up CSS with design tokens**

Replace `resources/css/app.css`:
```css
@import "tailwindcss";

@theme {
    --color-primary: #4f46e5;
    --color-accent: #8b5cf6;
    --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
}
```

**Step 6: Add Inter font to `resources/views/layouts/landing.blade.php`**

```html
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
```

**Step 7: Build assets to verify**

```bash
npm run build
```

Expected: No errors, `public/build/` created.

**Step 8: Commit**

```bash
git init && git add -A && git commit -m "feat: initialize Laravel 11 + Livewire 3 + Tailwind CSS v4"
```

---

## Task 2 (Agent A): Base Layout

**Files:**
- Create: `resources/views/layouts/landing.blade.php`

**Step 1: Create landing layout**

```blade
{{-- resources/views/layouts/landing.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gradus — Make Student Growth Visible')</title>
    <meta name="description" content="@yield('meta_description', 'Track student engagement and growth in real time. Grades show results, but they hide progress.')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-white text-slate-900">
    @yield('content')
    @livewireScripts
</body>
</html>
```

**Step 2: Commit**

```bash
git add resources/views/layouts/landing.blade.php
git commit -m "feat: add landing base layout"
```

---

## Task 3 (Agent A): Shared Blade Components

**Files:**
- Create: `resources/views/components/btn.blade.php`
- Create: `resources/views/components/badge.blade.php`
- Create: `resources/views/components/card.blade.php`
- Create: `resources/views/components/section.blade.php`
- Create: `resources/views/components/landing-nav.blade.php`
- Create: `resources/views/components/landing-footer.blade.php`

**Step 1: Create `x-btn` component**

```blade
{{-- resources/views/components/btn.blade.php --}}
@props(['href' => null, 'variant' => 'primary', 'type' => 'button'])

@php
$classes = match($variant) {
    'primary' => 'bg-gradient-to-r from-indigo-600 to-violet-500 text-white hover:opacity-90',
    'secondary' => 'bg-white text-indigo-600 border border-indigo-200 hover:bg-indigo-50',
    'ghost' => 'text-slate-600 hover:text-slate-900',
    default => 'bg-indigo-600 text-white hover:bg-indigo-700',
};
$base = 'inline-flex items-center justify-center px-8 py-3 rounded-full font-semibold text-sm transition-all duration-200 cursor-pointer';
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

**Step 2: Create `x-badge` component**

```blade
{{-- resources/views/components/badge.blade.php --}}
<span {{ $attributes->merge(['class' => 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700']) }}>
    {{ $slot }}
</span>
```

**Step 3: Create `x-card` component**

```blade
{{-- resources/views/components/card.blade.php --}}
<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-100 shadow-sm p-6']) }}>
    {{ $slot }}
</div>
```

**Step 4: Create `x-section` component**

```blade
{{-- resources/views/components/section.blade.php --}}
<section {{ $attributes->merge(['class' => 'py-20 px-4']) }}>
    <div class="max-w-6xl mx-auto">
        {{ $slot }}
    </div>
</section>
```

**Step 5: Create navigation component**

```blade
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
```

**Step 6: Create footer component**

```blade
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
```

**Step 7: Write Pest test for components exist**

```php
// tests/Feature/LandingComponentsTest.php
<?php

use function Pest\Laravel\get;

test('home page loads', function () {
    get('/')->assertStatus(200);
});
```

**Step 8: Run test to verify it fails (no route yet)**

```bash
php artisan test tests/Feature/LandingComponentsTest.php
```

Expected: FAIL — 404

**Step 9: Commit components**

```bash
git add resources/views/components/ tests/Feature/LandingComponentsTest.php
git commit -m "feat: add shared Blade components (btn, badge, card, section, nav, footer)"
```

---

## Task 4 (Agent A): Entry Split Page + Routes

**Files:**
- Create: `resources/views/landing/home.blade.php`
- Modify: `routes/web.php`

**Step 1: Write the route test**

```php
// tests/Feature/LandingRoutesTest.php
<?php

use function Pest\Laravel\get;

test('home page returns 200', fn() => get('/')->assertStatus(200)->assertSee('Who are you?'));
test('institutions page returns 200', fn() => get('/institutions')->assertStatus(200)->assertSee('Make student growth visible'));
test('students page returns 200', fn() => get('/students')->assertStatus(200)->assertSee('See your real progress'));
```

**Step 2: Run to verify fails**

```bash
php artisan test tests/Feature/LandingRoutesTest.php
```

Expected: All FAIL

**Step 3: Create entry split view**

```blade
{{-- resources/views/landing/home.blade.php --}}
@extends('layouts.landing')

@section('title', 'Gradus — Who Are You?')
@section('meta_description', 'Gradus tracks student growth and engagement in real time. Choose your path.')

@section('content')
<x-landing-nav />

<main class="min-h-screen flex flex-col items-center justify-center px-4 bg-gradient-to-br from-slate-50 to-indigo-50">
    <div class="text-center max-w-2xl">
        <x-badge class="mb-6">Early Access</x-badge>

        <h1 class="text-5xl font-bold tracking-tight text-slate-900 mb-4">
            Who are you?
        </h1>
        <p class="text-xl text-slate-500 mb-12">
            Gradus works differently depending on your role. Choose your path.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-xl mx-auto">
            <a href="/institutions"
               class="group flex flex-col items-center gap-4 p-8 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all duration-200">
                <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center text-2xl group-hover:bg-indigo-600 transition-colors">
                    🏫
                </div>
                <div>
                    <div class="font-semibold text-slate-900 text-lg">School or University</div>
                    <div class="text-sm text-slate-500 mt-1">Administrators & Teachers</div>
                </div>
                <div class="text-indigo-600 text-sm font-medium group-hover:text-indigo-700">See how it works →</div>
            </a>

            <a href="/students"
               class="group flex flex-col items-center gap-4 p-8 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-violet-200 transition-all duration-200">
                <div class="w-14 h-14 bg-violet-100 rounded-xl flex items-center justify-center text-2xl group-hover:bg-violet-600 transition-colors">
                    🎓
                </div>
                <div>
                    <div class="font-semibold text-slate-900 text-lg">Student</div>
                    <div class="text-sm text-slate-500 mt-1">Track your own progress</div>
                </div>
                <div class="text-violet-600 text-sm font-medium group-hover:text-violet-700">Join the waitlist →</div>
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

**Step 4: Add routes**

```php
// routes/web.php — replace the default route, add:
Route::view('/', 'landing.home')->name('home');
Route::view('/institutions', 'landing.institutions')->name('institutions');
Route::view('/students', 'landing.students')->name('students');
```

**Step 5: Create stub views so routes don't 404 (Agents B & C will replace these)**

```bash
mkdir -p resources/views/landing
echo "@extends('layouts.landing') @section('content')<p>Make student growth visible</p>@endsection" > resources/views/landing/institutions.blade.php
echo "@extends('layouts.landing') @section('content')<p>See your real progress</p>@endsection" > resources/views/landing/students.blade.php
```

**Step 6: Run tests to verify they pass**

```bash
php artisan test tests/Feature/
```

Expected: All PASS

**Step 7: Commit**

```bash
git add resources/views/landing/ routes/web.php tests/Feature/LandingRoutesTest.php
git commit -m "feat: add entry split page and landing routes"
```

> **AGENT A COMPLETE — Agents B and C can now start in parallel.**

---

## Task 5 (Agent B): Institution Hero + Problem Sections

**Files:**
- Modify: `resources/views/landing/institutions.blade.php`

**Design context:**
- Purple/indigo theme
- Hero: large headline, subhead, CTA button, mock dashboard visual (HTML/CSS mockup, no real image needed)
- Problem: 3 pain points in card layout

**Step 1: Replace stub with hero + problem sections**

```blade
{{-- resources/views/landing/institutions.blade.php --}}
@extends('layouts.landing')

@section('title', 'Gradus for Schools & Universities — Make Student Growth Visible')
@section('meta_description', 'Track student engagement and learning momentum without changing teacher workflows. Join our pilot.')

@section('content')
<x-landing-nav active="institutions" />

{{-- Hero --}}
<x-section class="bg-gradient-to-br from-slate-50 via-indigo-50 to-violet-50 pt-28 pb-20">
    <div class="text-center max-w-4xl mx-auto">
        <x-badge class="mb-6">For Schools & Universities</x-badge>

        <h1 class="text-5xl md:text-6xl font-bold tracking-tight text-slate-900 mb-6 leading-tight">
            Make student<br>
            <span class="bg-gradient-to-r from-indigo-600 to-violet-500 bg-clip-text text-transparent">growth visible.</span>
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

        {{-- Mock dashboard visual --}}
        <div class="mt-16 bg-white rounded-2xl shadow-xl border border-slate-100 p-6 max-w-3xl mx-auto text-left">
            <div class="flex items-center justify-between mb-4">
                <span class="text-sm font-semibold text-slate-700">Class 10B — Engagement Overview</span>
                <span class="text-xs text-slate-400">Updated 2 min ago</span>
            </div>
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="bg-indigo-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-indigo-600">87%</div>
                    <div class="text-xs text-slate-500 mt-1">Engagement Index</div>
                    <div class="text-xs text-green-600 mt-1">↑ +4% this week</div>
                </div>
                <div class="bg-violet-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-violet-600">72%</div>
                    <div class="text-xs text-slate-500 mt-1">Growth Score</div>
                    <div class="text-xs text-green-600 mt-1">↑ +8% this month</div>
                </div>
                <div class="bg-amber-50 rounded-xl p-4">
                    <div class="text-2xl font-bold text-amber-600">3</div>
                    <div class="text-xs text-slate-500 mt-1">At-Risk Students</div>
                    <div class="text-xs text-red-500 mt-1">⚠ Needs attention</div>
                </div>
            </div>
            <div class="flex gap-2">
                @foreach(['Asel K.', 'Daniyar M.', 'Kamila B.', 'Arman T.', 'Zarina O.'] as $student)
                <div class="flex-1 bg-slate-50 rounded-lg p-2 text-center">
                    <div class="w-6 h-6 rounded-full bg-indigo-200 mx-auto mb-1 text-xs flex items-center justify-center font-semibold text-indigo-700">
                        {{ substr($student, 0, 1) }}
                    </div>
                    <div class="text-xs text-slate-500">{{ $student }}</div>
                    <div class="text-xs font-semibold text-indigo-600 mt-1">{{ rand(70, 95) }}%</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-section>

{{-- Problem Section --}}
<x-section class="bg-white">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">The problem with grades</h2>
        <p class="text-lg text-slate-500 max-w-xl mx-auto">Grades show outcomes, but they hide what's actually happening.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card>
            <div class="text-3xl mb-4">📊</div>
            <h3 class="font-semibold text-slate-900 mb-2">Grades hide engagement</h3>
            <p class="text-slate-500 text-sm leading-relaxed">A student can pass with copied work or disengage entirely — grades won't show the difference.</p>
        </x-card>
        <x-card>
            <div class="text-3xl mb-4">⏰</div>
            <h3 class="font-semibold text-slate-900 mb-2">Disengagement is detected late</h3>
            <p class="text-slate-500 text-sm leading-relaxed">By the time a student's grades drop, they've often been disengaged for weeks.</p>
        </x-card>
        <x-card>
            <div class="text-3xl mb-4">📋</div>
            <h3 class="font-semibold text-slate-900 mb-2">Reporting without insight</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Schools have data, but no clarity on student momentum, effort, or early warning signals.</p>
        </x-card>
    </div>
</x-section>

@endsection
```

**Step 2: View in browser**

```bash
php artisan serve
# Visit http://localhost:8000/institutions
```

Expected: Hero and problem sections render correctly with purple gradient, dashboard mockup visible.

**Step 3: Commit**

```bash
git add resources/views/landing/institutions.blade.php
git commit -m "feat: add institution hero and problem sections"
```

---

## Task 6 (Agent B): Institution Solution + Value + How It Works Sections

**Files:**
- Modify: `resources/views/landing/institutions.blade.php`

**Step 1: Add solution, value, and how-it-works sections after the problem section (before `@endsection`)**

```blade
{{-- Solution Section --}}
<x-section class="bg-slate-50">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <x-badge class="mb-4">The Solution</x-badge>
            <h2 class="text-3xl font-bold text-slate-900 mb-6">
                A progress layer on top of your existing systems.
            </h2>
            <p class="text-slate-600 leading-relaxed mb-8">
                Gradus transforms existing academic data — attendance, assignments, grades — into two clear signals:
                the <strong class="text-indigo-600">Engagement Index</strong> and the <strong class="text-violet-600">Growth Score</strong>.
                Teachers do nothing new. Schools gain a real-time picture of learning momentum.
            </p>
            <ul class="space-y-3">
                @foreach(['No additional teacher workload', 'Works with your current systems (e.g., Kundelik)', 'Real-time engagement and growth signals', 'Early warning for at-risk students'] as $item)
                <li class="flex items-center gap-3 text-slate-700 text-sm">
                    <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    </div>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <div class="mb-4 text-sm font-semibold text-slate-700">Growth Score Trend — Daniyar M.</div>
            <div class="flex items-end gap-2 h-24">
                @foreach([40, 45, 52, 48, 58, 65, 72, 78, 82, 88] as $height)
                <div class="flex-1 rounded-t-sm bg-gradient-to-t from-indigo-600 to-violet-400" style="height: {{ $height }}%"></div>
                @endforeach
            </div>
            <div class="flex justify-between text-xs text-slate-400 mt-2">
                <span>Sep</span><span>Oct</span><span>Nov</span><span>Dec</span><span>Jan</span>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                <span class="text-sm text-slate-600">Growth: <strong class="text-green-600">+48% since September</strong></span>
            </div>
        </div>
    </div>
</x-section>

{{-- Value Section --}}
<x-section class="bg-white" id="value">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">Built for everyone in the school</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card class="border-indigo-100">
            <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">For Administrators</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Clear engagement analytics across classes. Early intervention signals before grades drop. Better decisions with real-time insight.</p>
        </x-card>
        <x-card class="border-violet-100">
            <div class="w-10 h-10 bg-violet-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">For Teachers</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Zero additional workload. Continue using current workflows. Gradus works as an invisible layer on top of what you already do.</p>
        </x-card>
        <x-card class="border-emerald-100">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">For Institutions</h3>
            <p class="text-slate-500 text-sm leading-relaxed">Track learning momentum school-wide. Demonstrate real educational value beyond grades to parents and accreditation bodies.</p>
        </x-card>
    </div>
</x-section>

{{-- How It Works --}}
<x-section class="bg-indigo-50" id="how-it-works">
    <div class="text-center mb-14">
        <h2 class="text-3xl font-bold text-slate-900 mb-4">How it works in 3 steps</h2>
        <p class="text-slate-500 max-w-md mx-auto">No complex onboarding. No teacher retraining.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
        <div class="hidden md:block absolute top-8 left-1/4 right-1/4 h-0.5 bg-indigo-200"></div>
        @foreach([
            ['01', 'Connect your data', 'Share existing grade and attendance data via CSV, API, or our Kundelik connector.', 'indigo'],
            ['02', 'Gradus calculates signals', 'The platform computes Engagement Index and Growth Score per student, class, and school.', 'violet'],
            ['03', 'Schools see insight', 'Administrators and teachers access a clear real-time dashboard of learning momentum.', 'emerald'],
        ] as [$num, $title, $desc, $color])
        <div class="relative text-center">
            <div class="w-16 h-16 rounded-full bg-{{ $color }}-600 text-white text-xl font-bold flex items-center justify-center mx-auto mb-4">
                {{ $num }}
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">{{ $title }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ $desc }}</p>
        </div>
        @endforeach
    </div>
</x-section>
```

**Step 2: Commit**

```bash
git add resources/views/landing/institutions.blade.php
git commit -m "feat: add institution solution, value, and how-it-works sections"
```

---

## Task 7 (Agent B): Institution Pilot CTA Form (Livewire)

**Files:**
- Create: `app/Livewire/PilotRequestForm.php`
- Create: `resources/views/livewire/pilot-request-form.blade.php`
- Modify: `resources/views/landing/institutions.blade.php`

**Step 1: Write Pest test first**

```php
// tests/Feature/PilotRequestFormTest.php
<?php

use Livewire\Livewire;
use App\Livewire\PilotRequestForm;

test('pilot request form renders', function () {
    Livewire::test(PilotRequestForm::class)
        ->assertSee('Join Pilot')
        ->assertSet('submitted', false);
});

test('pilot request form validates required fields', function () {
    Livewire::test(PilotRequestForm::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'institution', 'role']);
});

test('pilot request form validates email format', function () {
    Livewire::test(PilotRequestForm::class)
        ->set('email', 'not-an-email')
        ->call('submit')
        ->assertHasErrors(['email']);
});

test('pilot request form submits successfully with valid data', function () {
    Livewire::test(PilotRequestForm::class)
        ->set('name', 'Asel Nurova')
        ->set('email', 'asel@school.kz')
        ->set('institution', 'School #42, Almaty')
        ->set('role', 'admin')
        ->call('submit')
        ->assertSet('submitted', true)
        ->assertHasNoErrors();
});
```

**Step 2: Run test to verify it fails**

```bash
php artisan test tests/Feature/PilotRequestFormTest.php
```

Expected: FAIL — class not found

**Step 3: Create Livewire component class**

```php
// app/Livewire/PilotRequestForm.php
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;

class PilotRequestForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $institution = '';
    public string $role = '';
    public string $challenge = '';
    public bool $submitted = false;

    protected array $rules = [
        'name' => 'required|string|min:2|max:100',
        'email' => 'required|email|max:255',
        'institution' => 'required|string|min:2|max:200',
        'role' => 'required|in:admin,teacher,other',
        'challenge' => 'nullable|string|max:1000',
    ];

    public function submit(): void
    {
        $this->validate();

        Lead::create([
            'name' => $this->name,
            'email' => $this->email,
            'institution' => $this->institution,
            'role' => $this->role,
            'message' => $this->challenge,
            'type' => 'institution',
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.pilot-request-form');
    }
}
```

**Step 4: Create the Livewire view**

```blade
{{-- resources/views/livewire/pilot-request-form.blade.php --}}
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
```

**Step 5: Add CTA section to institutions page (before `@endsection`)**

```blade
{{-- Pilot CTA Section --}}
<x-section class="bg-gradient-to-br from-indigo-600 to-violet-600" id="pilot-form">
    <div class="max-w-2xl mx-auto text-center mb-10">
        <x-badge class="bg-white/20 text-white border-0 mb-6">Limited Pilot Spots</x-badge>
        <h2 class="text-3xl font-bold text-white mb-4">
            Looking for pilot schools and universities.
        </h2>
        <p class="text-indigo-200">
            We're running a limited pilot with 5–10 schools. If you want to be among the first to see real learning momentum data, apply below.
        </p>
    </div>
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-2xl p-8">
        <livewire:pilot-request-form />
    </div>
</x-section>
```

**Step 6: Run tests**

```bash
php artisan test tests/Feature/PilotRequestFormTest.php
```

Expected: FAIL (Lead model missing — Wire Agent will add migrations)
Note: Tests will pass after Wire Agent completes Task 11.

**Step 7: Commit**

```bash
git add app/Livewire/PilotRequestForm.php resources/views/livewire/pilot-request-form.blade.php resources/views/landing/institutions.blade.php tests/Feature/PilotRequestFormTest.php
git commit -m "feat: add institution pilot request form (Livewire)"
```

> **AGENT B COMPLETE.**

---

## Task 8 (Agent C): Student Hero + Problem Sections

**Files:**
- Modify: `resources/views/landing/students.blade.php`

**Design context:** Violet/purple theme (softer than institution). Emotional, motivational tone.

**Step 1: Replace stub with hero + problem**

```blade
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

@endsection
```

**Step 2: Commit**

```bash
git add resources/views/landing/students.blade.php
git commit -m "feat: add student hero and problem sections"
```

---

## Task 9 (Agent C): Student Solution + Value + Waitlist Form (Livewire)

**Files:**
- Create: `app/Livewire/WaitlistForm.php`
- Create: `resources/views/livewire/waitlist-form.blade.php`
- Modify: `resources/views/landing/students.blade.php`

**Step 1: Write Pest test for waitlist form**

```php
// tests/Feature/WaitlistFormTest.php
<?php

use Livewire\Livewire;
use App\Livewire\WaitlistForm;

test('waitlist form renders', function () {
    Livewire::test(WaitlistForm::class)
        ->assertSee('Join Waitlist')
        ->assertSet('submitted', false);
});

test('waitlist form validates required fields', function () {
    Livewire::test(WaitlistForm::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'school']);
});

test('waitlist form submits successfully', function () {
    Livewire::test(WaitlistForm::class)
        ->set('name', 'Daniyar Bekov')
        ->set('email', 'daniyar@gmail.com')
        ->set('school', 'School #15, Nur-Sultan')
        ->call('submit')
        ->assertSet('submitted', true);
});
```

**Step 2: Run test — expect FAIL**

```bash
php artisan test tests/Feature/WaitlistFormTest.php
```

**Step 3: Create WaitlistForm Livewire component**

```php
// app/Livewire/WaitlistForm.php
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lead;

class WaitlistForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $school = '';
    public string $frustration = '';
    public bool $submitted = false;

    protected array $rules = [
        'name' => 'required|string|min:2|max:100',
        'email' => 'required|email|max:255',
        'school' => 'required|string|min:2|max:200',
        'frustration' => 'nullable|string|max:1000',
    ];

    public function submit(): void
    {
        $this->validate();

        Lead::create([
            'name' => $this->name,
            'email' => $this->email,
            'institution' => $this->school,
            'role' => 'student',
            'message' => $this->frustration,
            'type' => 'student',
        ]);

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.waitlist-form');
    }
}
```

**Step 4: Create waitlist form view**

```blade
{{-- resources/views/livewire/waitlist-form.blade.php --}}
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
```

**Step 5: Add solution + value + waitlist sections to students page (before `@endsection`)**

```blade
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
```

**Step 6: Add footer to students page**

```blade
<x-landing-footer />
@endsection
```

**Step 7: Commit**

```bash
git add app/Livewire/WaitlistForm.php resources/views/livewire/ resources/views/landing/students.blade.php tests/Feature/WaitlistFormTest.php
git commit -m "feat: add student solution, value, and waitlist form sections"
```

> **AGENT C COMPLETE.**

---

## Task 10 (Wire Agent): Database Migration for Leads

**Files:**
- Create: `database/migrations/xxxx_create_leads_table.php`
- Create: `app/Models/Lead.php`

**Step 1: Write migration test**

```php
// tests/Feature/LeadModelTest.php
<?php

use App\Models\Lead;

test('lead can be created', function () {
    $lead = Lead::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'institution' => 'Test School',
        'role' => 'admin',
        'type' => 'institution',
        'message' => null,
    ]);

    expect($lead)->toBeInstanceOf(Lead::class)
        ->and($lead->email)->toBe('test@example.com');
});
```

**Step 2: Run test — expect FAIL**

```bash
php artisan test tests/Feature/LeadModelTest.php
```

**Step 3: Create Lead model**

```php
// app/Models/Lead.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'institution',
        'role',
        'type',
        'message',
    ];
}
```

**Step 4: Create migration**

```bash
php artisan make:migration create_leads_table
```

Then edit the generated file:

```php
// database/migrations/xxxx_create_leads_table.php
Schema::create('leads', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email');
    $table->string('institution');
    $table->string('role');
    $table->string('type'); // 'institution' or 'student'
    $table->text('message')->nullable();
    $table->timestamps();
});
```

**Step 5: Configure SQLite for development**

```bash
# In .env (development):
DB_CONNECTION=sqlite
touch database/database.sqlite
php artisan migrate
```

**Step 6: Run all tests**

```bash
php artisan test
```

Expected: All tests PASS

**Step 7: Commit**

```bash
git add app/Models/Lead.php database/migrations/ database/database.sqlite tests/Feature/LeadModelTest.php .env.example
git commit -m "feat: add Lead model and migration for capturing signups"
```

---

## Task 11 (Wire Agent): Footer to Institutions Page + Final Integration Check

**Files:**
- Modify: `resources/views/landing/institutions.blade.php`

**Step 1: Add footer to institutions page (before `@endsection`)**

Add `<x-landing-footer />` as the last item before `@endsection`.

**Step 2: Run full test suite**

```bash
php artisan test
```

Expected: All PASS including PilotRequestFormTest and WaitlistFormTest.

**Step 3: Commit**

```bash
git add resources/views/landing/institutions.blade.php
git commit -m "fix: add footer to institutions page, verify all tests pass"
```

---

## Task 12 (Wire Agent): SEO + Meta + Social Sharing

**Files:**
- Modify: `resources/views/layouts/landing.blade.php`
- Modify: `resources/views/landing/home.blade.php`
- Modify: `resources/views/landing/institutions.blade.php`
- Modify: `resources/views/landing/students.blade.php`

**Step 1: Add OG tags to base layout**

```html
{{-- In <head> of landing.blade.php --}}
<meta property="og:title" content="@yield('og_title', 'Gradus — Make Student Growth Visible')">
<meta property="og:description" content="@yield('og_description', 'Track student engagement and growth in real time.')">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('og_title', 'Gradus — Make Student Growth Visible')">
<meta name="twitter:description" content="@yield('og_description', 'Track student engagement and growth in real time.')">
<link rel="canonical" href="{{ url()->current() }}">
```

**Step 2: Add `@section('og_title')` to each page**

Each page already has `@section('title')` and `@section('meta_description')` — add matching `@section('og_title')` and `@section('og_description')` using the same values.

**Step 3: Commit**

```bash
git add resources/views/
git commit -m "feat: add SEO meta tags and Open Graph tags to all pages"
```

---

## Task 13 (Wire Agent): Alpine.js Scroll Animations

**Files:**
- Modify: `resources/views/layouts/landing.blade.php`
- Modify shared section component: `resources/views/components/section.blade.php`

**Step 1: Add Alpine.js scroll reveal to section component**

```blade
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
```

**Step 2: Install Alpine Intersect plugin**

```bash
npm install @alpinejs/intersect
```

Update `resources/js/app.js`:
```js
import Alpine from 'alpinejs'
import intersect from '@alpinejs/intersect'

Alpine.plugin(intersect)
Alpine.start()
```

**Step 3: Build and test visually**

```bash
npm run build
php artisan serve
```

Visit all three pages. Sections should fade in on scroll.

**Step 4: Commit**

```bash
git add resources/views/components/section.blade.php resources/js/app.js package.json package-lock.json
git commit -m "feat: add Alpine.js scroll reveal animations to sections"
```

---

## Task 14 (Wire Agent): Final Validation

**Step 1: Run master checklist**

```bash
python .agent/scripts/checklist.py .
```

**Step 2: Run full test suite**

```bash
php artisan test --coverage
```

Expected: All green, 10+ tests passing.

**Step 3: Build production assets**

```bash
npm run build
```

Expected: No warnings.

**Step 4: Check mobile responsiveness**

Start server and check all three pages on mobile viewport (375px wide) in browser devtools.

**Step 5: Final commit**

```bash
git add -A
git commit -m "feat: complete landing page — entry split, institution path, student path, forms, animations, SEO"
```

---

## Parallel Execution Summary

```
IMMEDIATELY:
  └── Agent A: Tasks 1-4 (setup + shared components + entry split)
         ↓ when done
  ┌──────────────────────────────────┐
  │                                  │
Agent B: Tasks 5-7             Agent C: Tasks 8-9
(Institution path)             (Student path)
  │                                  │
  └──────────────┬───────────────────┘
                 ↓ when both done
         Wire Agent: Tasks 10-14
         (DB + integration + SEO + animations + validation)
```

---

## File Index

```
resources/
├── views/
│   ├── layouts/
│   │   └── landing.blade.php          (Agent A)
│   ├── components/
│   │   ├── btn.blade.php              (Agent A)
│   │   ├── badge.blade.php            (Agent A)
│   │   ├── card.blade.php             (Agent A)
│   │   ├── section.blade.php          (Agent A → Wire Agent)
│   │   ├── landing-nav.blade.php      (Agent A)
│   │   └── landing-footer.blade.php   (Agent A)
│   ├── landing/
│   │   ├── home.blade.php             (Agent A)
│   │   ├── institutions.blade.php     (Agent B)
│   │   └── students.blade.php         (Agent C)
│   └── livewire/
│       ├── pilot-request-form.blade.php  (Agent B)
│       └── waitlist-form.blade.php       (Agent C)
├── css/app.css                        (Agent A)
└── js/app.js                          (Agent A → Wire Agent)

app/
├── Livewire/
│   ├── PilotRequestForm.php           (Agent B)
│   └── WaitlistForm.php               (Agent C)
└── Models/
    └── Lead.php                       (Wire Agent)

database/migrations/
└── xxxx_create_leads_table.php        (Wire Agent)

routes/web.php                         (Agent A)

tests/Feature/
├── LandingComponentsTest.php          (Agent A)
├── LandingRoutesTest.php              (Agent A)
├── PilotRequestFormTest.php           (Agent B)
├── WaitlistFormTest.php               (Agent C)
└── LeadModelTest.php                  (Wire Agent)
```
