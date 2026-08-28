<div class="mx-auto max-w-6xl rounded-2xl bg-gradient-to-br from-cyan-600 to-cyan-800 px-6 py-16 text-center shadow-lg">
    <h2 class="text-3xl font-bold text-white">Ready to feel a little better today?</h2>
    <p class="mx-auto mt-4 max-w-md text-sm text-cyan-100 sm:text-base">
        Join others taking small, kind steps toward better mental health.
    </p>
    @if (Route::has('login') && ! auth()->check())
        <a
            href="{{ route('register') }}"
            class="mt-8 inline-block rounded-lg bg-white px-8 py-3 text-sm font-semibold text-cyan-700 shadow-sm hover:bg-gray-50"
        >
            Get started
        </a>
    @else
        <a
            href="{{ route('dashboard') }}"
            class="mt-8 inline-block rounded-lg bg-white px-8 py-3 text-sm font-semibold text-cyan-700 shadow-sm hover:bg-gray-50"
        >
            Open dashboard
        </a>
    @endif
</div>
