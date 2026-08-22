<nav class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6">
    <a href="{{ route('home') }}" class="flex items-center gap-x-2">
        <span class="flex size-8 items-center justify-center rounded-full bg-cyan-600 text-white dark:bg-cyan-500">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
        </span>
        <span class="text-lg font-bold">{{ config('app.name', 'Bud') }}</span>
    </a>

    {{-- Desktop links --}}
    <div class="hidden items-center gap-x-8 md:flex">
        <a
            href="#features"
            class="text-sm font-medium text-gray-600 hover:text-cyan-600 dark:text-gray-300 dark:hover:text-cyan-400"
        >Features</a>
        <a
            href="#how-it-works"
            class="text-sm font-medium text-gray-600 hover:text-cyan-600 dark:text-gray-300 dark:hover:text-cyan-400"
        >How it works</a>
        <a
            href="#testimonials"
            class="text-sm font-medium text-gray-600 hover:text-cyan-600 dark:text-gray-300 dark:hover:text-cyan-400"
        >Testimonials</a>
        <a
            href="#faq"
            class="text-sm font-medium text-gray-600 hover:text-cyan-600 dark:text-gray-300 dark:hover:text-cyan-400"
        >FAQ</a>
    </div>

    <div class="hidden items-center gap-x-3 md:flex">
        @if (Route::has('login'))
            @guest
                <a
                    href="{{ route('login') }}"
                    class="rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                >
                    Sign in
                </a>
                <a
                    href="{{ route('register') }}"
                    class="rounded-lg border border-transparent bg-cyan-600 px-4 py-2 text-sm font-medium text-white hover:bg-cyan-700 focus:bg-cyan-700 focus:outline-hidden dark:bg-cyan-500 dark:hover:bg-cyan-600"
                >
                    Get started
                </a>
            @else
                <a
                    href="{{ route('home') }}"
                    class="rounded-lg border border-transparent bg-cyan-600 px-4 py-2 text-sm font-medium text-white hover:bg-cyan-700 focus:bg-cyan-700 focus:outline-hidden dark:bg-cyan-500 dark:hover:bg-cyan-600"
                >
                    Dashboard
                </a>
            @endguest
        @endif
    </div>

    {{-- Mobile menu --}}
    <details class="relative md:hidden">
        <summary class="[&::-webkit-details-marker]:hidden flex cursor-pointer list-none items-center rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </summary>
        <div class="absolute end-0 mt-2 w-52 rounded-xl border border-gray-200 bg-white p-3 shadow-lg dark:border-gray-700 dark:bg-gray-800">
            <a
                href="#features"
                class="block rounded-lg px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700"
            >Features</a>
            <a
                href="#how-it-works"
                class="block rounded-lg px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700"
            >How it works</a>
            <a
                href="#testimonials"
                class="block rounded-lg px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700"
            >Testimonials</a>
            <a
                href="#faq"
                class="block rounded-lg px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700"
            >FAQ</a>
            <hr class="my-2 border-gray-200 dark:border-gray-700" />
            @if (Route::has('login'))
                @guest
                    <a
                        href="{{ route('login') }}"
                        class="block rounded-lg px-3 py-2 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700"
                    >Sign in</a>
                    <a
                        href="{{ route('register') }}"
                        class="mt-1 block rounded-lg bg-cyan-600 px-3 py-2 text-center text-sm font-medium text-white hover:bg-cyan-700 dark:bg-cyan-500 dark:hover:bg-cyan-600"
                    >Get started</a>
                @else
                    <a
                        href="{{ route('home') }}"
                        class="block rounded-lg bg-cyan-600 px-3 py-2 text-center text-sm font-medium text-white hover:bg-cyan-700 dark:bg-cyan-500 dark:hover:bg-cyan-600"
                    >Dashboard</a>
                @endguest
            @endif
        </div>
    </details>
</nav>
