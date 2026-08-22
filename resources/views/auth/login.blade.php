@extends('layouts.guest')

@section('title', 'Sign in')

@section('content')
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

            <div class="text-center">
                <h1 id="hs-modal-signin-label" class="block text-2xl font-bold text-gray-800 dark:text-white">
                    Sign in
                </h1>
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
                <button
                    type="button"
                    class="inline-flex w-full items-center justify-center gap-x-2 rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-gray-800 shadow-2xs hover:bg-gray-50 focus:bg-gray-50 focus:outline-hidden disabled:pointer-events-none disabled:opacity-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700"
                >
                    <svg class="h-auto w-4" width="46" height="47" viewBox="0 0 46 47" fill="none">
                        <path d="M46 24.0287C46 22.09 45.8533 20.68 45.5013 19.2112H23.4694V27.9356H36.4069C36.1429 30.1094 34.7347 33.37 31.5957 35.5731L31.5663 35.8669L38.5191 41.2719L38.9885 41.3306C43.4477 37.2181 46 31.1669 46 24.0287Z" fill="#4285F4" />
                        <path d="M23.4694 47C29.8061 47 35.1161 44.9144 39.0179 41.3012L31.625 35.5437C29.6301 36.9244 26.9898 37.8937 23.4987 37.8937C17.2793 37.8937 12.0281 33.7812 10.1505 28.1412L9.88649 28.1706L2.61097 33.7812L2.52296 34.0456C6.36608 41.7125 14.287 47 23.4694 47Z" fill="#34A853" />
                        <path d="M10.1212 28.1413C9.62245 26.6725 9.32908 25.1156 9.32908 23.5C9.32908 21.8844 9.62245 20.3275 10.0918 18.8588V18.5356L2.75765 12.8369L2.52296 12.9544C0.909439 16.1269 0 19.7106 0 23.5C0 27.2894 0.909439 30.8731 2.49362 34.0456L10.1212 28.1413Z" fill="#FBBC05" />
                        <path d="M23.4694 9.07688C27.8699 9.07688 30.8622 10.9863 32.5344 12.5725L39.1645 6.11C35.0867 2.32063 29.8061 0 23.4694 0C14.287 0 6.36607 5.2875 2.49362 12.9544L10.0918 18.8588C11.9987 13.1894 17.25 9.07688 23.4694 9.07688Z" fill="#EB4335" />
                    </svg>
                    Sign in with Google
                </button>

                <div class="flex items-center py-3 text-xs text-gray-400 uppercase before:me-6 before:flex-1 before:border-t before:border-gray-200 after:ms-6 after:flex-1 after:border-t after:border-gray-200 dark:text-gray-500 dark:before:border-neutral-700 dark:after:border-neutral-700">
                    Or
                </div>
            </div>

            <!-- Form -->
            <form action="{{ Route::has('login.store') ? route('login.store') : '#' }}" method="POST">
                @csrf
                @if (session('status'))
                    <p class="mb-4 rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-xs text-green-700 dark:border-green-800 dark:bg-green-900/40 dark:text-green-300">
                        {{ session('status') }}
                    </p>
                @endif

                <div class="grid gap-y-4">
                    <!-- Form Group -->
                    <div>
                        <label for="email" class="mb-2 block text-sm text-gray-700 dark:text-gray-300"
                            >Email address</label>
                        <div class="relative">
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="block w-full rounded-lg border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-2xs placeholder:text-gray-400 focus:border-cyan-600 focus:ring-cyan-600 disabled:pointer-events-none disabled:opacity-50 sm:py-3 dark:border-gray-600 dark:bg-gray-900/40 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-cyan-500 dark:focus:ring-cyan-500"
                                required
                                autofocus
                                autocomplete="email"
                                aria-describedby="email-error"
                            />
                            <div class="pointer-events-none absolute inset-y-0 inset-e-0 hidden pe-3">
                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                </svg>
                            </div>
                        </div>
                        @error('email')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400" id="email-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- End Form Group -->

                    <!-- Form Group -->
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="mb-2 block text-sm text-gray-700 dark:text-gray-300"
                                >Password</label>
                            <a
                                class="mb-2 text-sm font-medium text-cyan-600 decoration-2 hover:underline focus:underline focus:outline-hidden dark:text-cyan-500"
                                href="#"
                            >
                                Forgot password?
                            </a>
                        </div>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="block w-full rounded-lg border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-2xs placeholder:text-gray-400 focus:border-cyan-600 focus:ring-cyan-600 disabled:pointer-events-none disabled:opacity-50 sm:py-3 dark:border-gray-600 dark:bg-gray-900/40 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-cyan-500 dark:focus:ring-cyan-500"
                                required
                                autocomplete="current-password"
                                aria-describedby="password-error"
                            />
                            <div class="pointer-events-none absolute inset-y-0 inset-e-0 hidden pe-3">
                                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                </svg>
                            </div>
                        </div>
                        @error('password')
                            <p class="mt-2 text-xs text-red-600 dark:text-red-400" id="password-error">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <!-- End Form Group -->

                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-x-2 rounded-lg border border-transparent bg-cyan-600 px-4 py-3 text-sm font-medium text-white hover:bg-cyan-700 focus:bg-cyan-700 focus:outline-hidden disabled:pointer-events-none disabled:opacity-50 dark:bg-cyan-500 dark:hover:bg-cyan-600 dark:focus:bg-cyan-600"
                    >
                        Sign in
                    </button>
                </div>
            </form>
            <!-- End Form -->
        </div>
    </div>

    <p class="mt-4 text-center text-xs text-gray-400 dark:text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-cyan-600 dark:hover:text-cyan-400">&larr; Back to home</a>
    </p>
@endsection
