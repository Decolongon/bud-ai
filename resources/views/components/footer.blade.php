<div class="mx-auto max-w-6xl px-4 sm:px-6">
    <div class="flex flex-col items-center justify-between gap-6 md:flex-row">
        <a href="{{ route('home') }}" class="flex items-center gap-x-2">
            <span class="flex size-7 items-center justify-center rounded-full bg-cyan-600 text-white dark:bg-cyan-500">
                <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>
            </span>
            <span class="font-bold">{{ config('app.name', 'Bud') }}</span>
        </a>

        <nav class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm text-gray-600 dark:text-gray-300">
            <a href="#features" class="hover:text-cyan-600 dark:hover:text-cyan-400">Features</a>
            <a href="#how-it-works" class="hover:text-cyan-600 dark:hover:text-cyan-400">How it works</a>
            <a href="#faq" class="hover:text-cyan-600 dark:hover:text-cyan-400">FAQ</a>
        </nav>

        <p class="text-xs text-gray-400 dark:text-gray-500">
            &copy; {{ date('Y') }} {{ config('app.name', 'Bud') }}. Not a substitute for professional care.
        </p>
    </div>
</div>
