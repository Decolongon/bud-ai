@props([
    'name',
    'type' => 'text',
    'label' => null,
    'autocomplete' => null,
    'autofocus' => false,
])

@php
    $inputId = $name;
    $resolvedLabel = $label ?? str_replace('_', ' ', ucfirst($name));
@endphp

<div>
    <div class="flex items-center justify-between">
        <label
            for="{{ $inputId }}"
            class="mb-2 block text-sm text-gray-700 dark:text-gray-300"
        >{{ $resolvedLabel }}</label>
        @isset($aside)
            {{ $aside }}
        @endisset
    </div>
    <div class="relative">
        <input
            type="{{ $type }}"
            id="{{ $inputId }}"
            name="{{ $name }}"
            value="{{ old($name) }}"
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if ($autofocus) autofocus @endif
            required
            aria-describedby="{{ $inputId }}-error"
            class="block w-full rounded-lg border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-800 shadow-2xs placeholder:text-gray-400 focus:border-cyan-600 focus:ring-cyan-600 disabled:pointer-events-none disabled:opacity-50 sm:py-3 dark:border-gray-600 dark:bg-gray-900/40 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-cyan-500 dark:focus:ring-cyan-500"
        />
        <div class="pointer-events-none absolute inset-y-0 inset-e-0 hidden pe-3">
            <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
            </svg>
        </div>
    </div>
    @error($name)
        <p class="mt-2 text-xs text-red-600 dark:text-red-400" id="{{ $inputId }}-error">{{ $message }}</p>
    @enderror
</div>
