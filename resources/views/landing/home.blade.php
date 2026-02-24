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
