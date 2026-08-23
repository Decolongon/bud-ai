<div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-12">
    <a
        href="{{ route('home') }}"
        class="absolute start-4 top-4 inline-flex items-center gap-x-1.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-cyan-600 focus:outline-hidden focus-visible:ring-2 focus-visible:ring-cyan-500 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-cyan-400"
    >
        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
        </svg>
        Back to home
    </a>

    <div class="w-full max-w-md rounded-xl border border-gray-200 bg-white shadow-2xs dark:border-gray-700 dark:bg-gray-800">
        <div class="p-4 sm:p-7">
            <div class="mb-5 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-x-2">
                    <span class="flex size-9 items-center justify-center rounded-full bg-cyan-600 text-white dark:bg-cyan-500">
                        <svg class="size-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                    </span>
                    <span class="text-lg font-bold text-gray-800 dark:text-white">{{ config('app.name', 'Bud') }}</span>
                </a>
            </div>

            {{ $slot }}
        </div>
    </div>
</div>
