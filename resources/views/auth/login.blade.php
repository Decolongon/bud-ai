@extends('layouts.guest')

@section('title', 'Sign in')
@section('body_class', 'bg-white text-gray-800 dark:bg-gray-900 dark:text-gray-200')
@section('content')
    <x-auth.card>
        <div class="text-center">
            <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign in</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                Don't have an account yet?
                <a
                    class="font-medium text-cyan-600 decoration-2 hover:underline focus:underline focus:outline-hidden dark:text-cyan-500"
                    href="{{ route('register') }}"
                >
                    Sign up here
                </a>
            </p>
        </div>

        <div class="mt-5">
            <x-auth.google-button>Sign in with Google</x-auth-google-button>
        </div>

        {{-- Form --}}
        <form action="{{ Route::has('login.store') ? route('login.store') : '#' }}" method="POST">
            @csrf
            @if (session('status'))
                <p class="mb-4 rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-xs text-green-700 dark:border-green-800 dark:bg-green-900/40 dark:text-green-300">
                    {{ session('status') }}
                </p>
            @endif

            <div class="grid gap-y-4">
                <x-auth.input name="email" type="email" label="Email address" autocomplete="email" autofocus />

                <x-auth.input name="password" type="password" autocomplete="current-password">
                    <x-slot:aside>
                        <a
                            class="mb-2 text-sm font-medium text-cyan-600 decoration-2 hover:underline focus:underline focus:outline-hidden dark:text-cyan-500"
                            href="#"
                        >
                            Forgot password?
                        </a>
                    </x-slot:aside>
                </x-auth.input>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-x-2 rounded-lg border border-transparent bg-cyan-600 px-4 py-3 text-sm font-medium text-white hover:bg-cyan-700 focus:bg-cyan-700 focus:outline-hidden disabled:pointer-events-none disabled:opacity-50 dark:bg-cyan-500 dark:hover:bg-cyan-600 dark:focus:bg-cyan-600"
                >
                    Sign in
                </button>
            </div>
        </form>
        {{-- End Form --}}
    </x-auth.card>
@endsection
