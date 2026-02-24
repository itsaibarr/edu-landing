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
