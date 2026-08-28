<span class="inline-block rounded-full border border-cyan-200 bg-cyan-50 px-4 py-1 text-xs font-medium text-cyan-700 dark:border-cyan-800 dark:bg-cyan-900/40 dark:text-cyan-300">
    Your mental health companion
</span>
<h1 class="mx-auto mt-6 max-w-3xl text-4xl font-bold tracking-tight sm:text-5xl">
    Feel better, <span class="text-cyan-600 dark:text-cyan-400">one small step</span> at a time
</h1>
<p class="mx-auto mt-6 max-w-2xl text-base text-gray-600 sm:text-lg dark:text-gray-300">
    {{ config('app.name', 'Bud') }} helps you track your mood, reflect through guided journaling, and find calm with
    simple daily practices — all in one safe space.
</p>
<div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
    @if (Route::has('login') && ! auth()->check())
        <a
            href="{{ route('register') }}"
            class="w-full rounded-lg border border-transparent bg-cyan-600 px-6 py-3 text-sm font-medium text-white hover:bg-cyan-700 focus:bg-cyan-700 focus:outline-hidden sm:w-auto dark:bg-cyan-500 dark:hover:bg-cyan-600"
        >
            Get Started
        </a>
        <a
            href="#how-it-works"
            class="w-full rounded-lg border border-gray-200 bg-white px-6 py-3 text-sm font-medium text-gray-800 shadow-2xs hover:bg-gray-50 sm:w-auto dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700"
        >
            See how it works
        </a>
    @else
        <a
            href="{{ route('dashboard') }}"
            class="rounded-lg border border-transparent bg-cyan-600 px-6 py-3 text-sm font-medium text-white hover:bg-cyan-700 dark:bg-cyan-500 dark:hover:bg-cyan-600"
        >
            Go to dashboard
        </a>
    @endif
</div>
<p class="mt-6 text-xs text-gray-400 dark:text-gray-500">Free to start · No credit card required · Private by design</p>
