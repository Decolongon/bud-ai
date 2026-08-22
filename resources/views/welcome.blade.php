<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ __('Welcome') }} - {{ config('app.name', 'Bud') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 dark:bg-gray-900 dark:text-gray-200">
    {{-- ===== Navigation ===== --}}
    <header class="sticky top-0 z-50 border-b border-gray-200 bg-white/80 backdrop-blur dark:border-gray-700 dark:bg-gray-900/80">
        <x-navigation />
    </header>

    <main>
        {{-- ===== Hero ===== --}}
        <section class="mx-auto max-w-6xl px-4 py-20 text-center sm:px-6 lg:py-28">
            <x-hero />
        </section>

        {{-- ===== Features ===== --}}
        <section
            id="features"
            class="border-t border-gray-200 bg-gray-50 py-20 dark:border-gray-700 dark:bg-gray-800/40"
        >
            <x-features />
        </section>

        {{-- ===== How it works ===== --}}
        <section id="how-it-works" class="py-20">
            <x-how-it-works />
        </section>

        {{-- ===== Testimonials ===== --}}
        <section
            id="testimonials"
            class="border-y border-gray-200 bg-gray-50 py-20 dark:border-gray-700 dark:bg-gray-800/40"
        >
            <x-testimonial />
        </section>

        {{-- ===== FAQ ===== --}}
        <section id="faq" class="py-20">
            <x-faq />
        </section>

        {{-- ===== CTA ===== --}}
        <section class="px-4 pb-20 sm:px-6">
            <x-cta />
        </section>
    </main>

    {{-- ===== Footer ===== --}}
    <footer class="border-t border-gray-200 py-10 dark:border-gray-700">
        <x-footer />
    </footer>
</body>
</html>
