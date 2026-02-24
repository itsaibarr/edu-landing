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
