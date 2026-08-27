<div class="flex h-svh overflow-hidden">
    {{-- Mobile sidebar toggle (checkbox hack, no JS) --}}
    <input type="checkbox" id="app-sidebar" class="peer sr-only" />

    {{-- Backdrop --}}
    <label
        for="app-sidebar"
        aria-label="Close sidebar"
        class="pointer-events-none fixed inset-0 z-40 bg-gray-900/60 opacity-0 transition-opacity peer-checked:pointer-events-auto peer-checked:opacity-100 lg:hidden"
    ></label>

    {{-- ===== Sidebar ===== --}}
    <aside class="fixed inset-y-0 start-0 z-50 flex w-72 shrink-0 -translate-x-full flex-col border-e border-gray-200 bg-gray-50 transition-transform duration-300 peer-checked:translate-x-0 lg:static lg:translate-x-0 dark:border-gray-700 dark:bg-gray-800/60">
        {{-- Brand --}}
        <div class="flex h-14 shrink-0 items-center justify-between px-4">
            <a href="{{ route('home') }}" class="flex items-center gap-x-2">
                <span class="flex size-8 items-center justify-center rounded-full bg-cyan-600 text-white dark:bg-cyan-500">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </span>
                <span class="text-lg font-bold">{{ config('app.name', 'Bud') }}</span>
            </a>
            <label
                for="app-sidebar"
                class="cursor-pointer rounded-lg p-1.5 text-gray-500 hover:bg-gray-100 lg:hidden dark:text-gray-400 dark:hover:bg-gray-700"
                aria-label="Close sidebar"
            >
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </label>
        </div>

        {{-- New chat --}}
        <div class="px-4 pt-2">
            <button
                type="button"
                wire:click="newChat"
                class="inline-flex w-full items-center justify-center gap-x-2 rounded-lg border border-transparent bg-cyan-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-cyan-700 focus:bg-cyan-700 focus:outline-hidden disabled:pointer-events-none disabled:opacity-50 dark:bg-cyan-500 dark:hover:bg-cyan-600 dark:focus:bg-cyan-600"
            >
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                New chat
            </button>
        </div>

        {{-- Search --}}
        <div class="px-4 pt-3">
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 start-0 z-20 flex items-center ps-3.5">
                    <svg class="size-4 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search chats"
                    class="block w-full rounded-lg border-gray-200 bg-white py-2 ps-9 pe-3 text-sm text-gray-800 placeholder:text-gray-400 focus:border-cyan-600 focus:ring-cyan-600 disabled:pointer-events-none disabled:opacity-50 dark:border-gray-700 dark:bg-gray-900/40 dark:text-white dark:placeholder:text-gray-500 dark:focus:border-cyan-500 dark:focus:ring-cyan-500"
                />
            </div>
        </div>

        {{-- Chat history --}}
        <nav class="mt-4 flex-1 overflow-y-auto px-2 pb-4">
            @if ($this->conversations->isEmpty())
                <p class="py-8 text-center text-xs text-gray-400 dark:text-gray-500">
                    {{ trim($search) !== '' ? 'No matching conversations' : 'No conversations yet' }}
                </p>
            @else
                <ul class="space-y-1">
                    @foreach ($this->conversations as $conversation)
                        <li wire:key="conversation-{{ $conversation->id }}">
                            <button
                                type="button"
                                wire:click="selectConversation('{{ $conversation->id }}')"
                                class="flex w-full flex-col gap-y-1 rounded-lg px-3 py-2.5 text-left transition-colors focus:outline-hidden {{ $activeConversationId === $conversation->id ? 'bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-700 dark:ring-gray-600' : 'hover:bg-white hover:shadow-sm dark:hover:bg-gray-700/60' }}"
                            >
                                <span class="flex w-full items-center justify-between gap-x-2">
                                    <span class="truncate text-sm font-medium leading-none {{ $activeConversationId === $conversation->id ? 'text-gray-900 dark:text-white' : 'text-gray-800 dark:text-gray-200' }}">
                                        {{ \Illuminate\Support\Str::limit($conversation->title ?: 'New conversation', 36) }}
                                    </span>
                                    @if ($activeConversationId === $conversation->id)
                                        <span class="size-2 shrink-0 rounded-full bg-cyan-600 dark:bg-cyan-500"></span>
                                    @endif
                                </span>
                                <span class="truncate text-xs {{ $activeConversationId === $conversation->id ? 'text-gray-500 dark:text-gray-400' : 'text-gray-400 dark:text-gray-500' }}">
                                    {{ $conversation->updated_at->diffForHumans(null, true, true) }}
                                </span>
                            </button>
                        </li>
                    @endforeach
                </ul>
            @endif
        </nav>

        {{-- User --}}
        <div class="shrink-0 border-t border-gray-200 p-3 dark:border-gray-700">
            <div
                class="flex items-center gap-x-3 rounded-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-700"
                wire:click="logout"
                wire:confirm="Are you sure you want to logout?"
            >
                <span class="flex size-9 shrink-0 items-center justify-center rounded-full bg-cyan-600 text-xs font-bold text-white">{{ Auth::user()->initials() }}</span>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-gray-400 dark:text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                <button
                    type="button"
                    aria-label="Log out"
                    class="shrink-0 rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-hidden dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                >
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                    </svg>
                </button>
            </div>
        </div>
    </aside>

    {{-- ===== Main column ===== --}}
    <div class="flex min-w-0 flex-1 flex-col">
        {{-- Header --}}
        <header class="sticky top-0 z-30 flex h-14 shrink-0 items-center justify-between gap-x-3 border-b border-gray-200 bg-white/80 px-4 backdrop-blur sm:px-6 dark:border-gray-700 dark:bg-gray-900/80">
            <div class="flex items-center gap-x-3">
                <label
                    for="app-sidebar"
                    class="-ms-1 cursor-pointer rounded-lg p-2 text-gray-500 hover:bg-gray-100 lg:hidden dark:text-gray-400 dark:hover:bg-gray-700"
                    aria-label="Open sidebar"
                >
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </label>

                <span class="inline-flex items-center gap-x-2 rounded-full border border-gray-200 bg-gray-50 px-3 py-1.5 text-sm font-medium dark:border-gray-700 dark:bg-gray-800">
                    <span class="flex size-5 items-center justify-center rounded-full bg-cyan-600 text-white dark:bg-cyan-500">
                        <svg class="size-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                    </span>
                    Bud Chat
                </span>
            </div>

            <span
                class="flex size-8 items-center justify-center rounded-full bg-cyan-600 text-xs font-bold text-white"
                wire:click="logout"
                wire:confirm="{{ __('Are you sure you want to logout?') }}"
            >{{ Auth::user()->initials() }}</span>
        </header>

        {{-- Messages --}}
        <main class="flex-1 overflow-y-auto">
            @if (count($messages) === 0)
                <div class="mx-auto w-full max-w-3xl px-4 py-8 sm:px-6">
                    {{-- Greeting --}}
                    <div class="py-6 text-center sm:py-10">
                        <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-cyan-100 text-cyan-600 dark:bg-cyan-900/40 dark:text-cyan-400">
                            <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </span>
                        <h1 class="mt-4 text-2xl font-bold sm:text-3xl">
                            Hi {{ \Illuminate\Support\Str::before(Auth::user()->name, ' ') }}, I'm Bud
                        </h1>
                        <p class="mt-2 text-sm text-gray-600 sm:text-base dark:text-gray-300">
                            How are you feeling today?
                        </p>
                    </div>

                    {{-- Suggestions --}}
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach ($this->suggestions as $index => $suggestion)
                            <button
                                type="button"
                                wire:key="suggestion-{{ $index }}"
                                wire:click="ask({{ $index }})"
                                class="group flex items-start gap-x-3 rounded-xl border border-gray-200 bg-white p-4 text-start shadow-2xs hover:border-cyan-300 hover:bg-cyan-50/50 focus:outline-hidden dark:border-gray-700 dark:bg-gray-800 dark:hover:border-cyan-500/50 dark:hover:bg-cyan-500/5"
                            >
                                <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-cyan-100 text-cyan-600 group-hover:bg-cyan-600 group-hover:text-white dark:bg-cyan-900/40 dark:text-cyan-400">
                                    @if ($suggestion['icon'] === 'frown')
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0 0 12.016 15a4.486 4.486 0 0 0-3.198 1.318M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" /></svg>
                                    @elseif ($suggestion['icon'] === 'pencil')
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                    @elseif ($suggestion['icon'] === 'chart')
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" /></svg>
                                    @else
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" /></svg>
                                    @endif
                                </span>
                                <span>
                                    <span class="block text-sm font-medium">{{ $suggestion['title'] }}</span>
                                    <span class="mt-0.5 block text-xs text-gray-500 dark:text-gray-400">{{ $suggestion['sub'] }}</span>
                                </span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="mx-auto w-full max-w-3xl space-y-8 px-4 py-8 sm:px-6">
                    @foreach ($messages as $item)
                        @if ($item['from'] === 'user')
                            {{-- User message --}}
                            <div class="flex justify-end" wire:key="msg-{{ $loop->index }}">
                                <div class="max-w-[85%] rounded-2xl rounded-ee-md border border-cyan-100 bg-cyan-50 px-4 py-3 sm:max-w-[75%] dark:border-cyan-500/20 dark:bg-cyan-500/10">
                                    <p class="text-sm leading-relaxed whitespace-pre-line sm:text-base">
                                        {{ $item['text'] }}
                                    </p>
                                </div>
                            </div>
                        @else
                            {{-- Assistant message --}}
                            <div class="flex items-start gap-x-3" wire:key="msg-{{ $loop->index }}">
                                <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-cyan-600 text-white dark:bg-cyan-500">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm leading-relaxed whitespace-pre-line text-gray-700 sm:text-base dark:text-gray-300">
                                        {{ $item['text'] }}
                                    </p>

                                    <div class="mt-3 flex items-center gap-x-1 text-gray-400 dark:text-gray-500">
                                        <button
                                            type="button"
                                            aria-label="Copy"
                                            class="rounded-lg p-1.5 hover:bg-gray-100 hover:text-gray-600 focus:outline-hidden dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                        >
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" /></svg>
                                        </button>
                                        <button
                                            type="button"
                                            aria-label="Good response"
                                            class="rounded-lg p-1.5 hover:bg-gray-100 hover:text-gray-600 focus:outline-hidden dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                        >
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V3a.75.75 0 0 1 .75-.75A2.25 2.25 0 0 1 16.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" /></svg>
                                        </button>
                                        <button
                                            type="button"
                                            aria-label="Bad response"
                                            class="rounded-lg p-1.5 hover:bg-gray-100 hover:text-gray-600 focus:outline-hidden dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                        >
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7.498 15.25H4.372c-1.026 0-1.945-.694-2.054-1.715a12.137 12.137 0 0 1-.068-1.285c0-2.848.992-5.464 2.649-7.521C5.287 4.247 5.886 4 6.504 4h4.016a4.5 4.5 0 0 1 1.423.23l3.114 1.04a4.5 4.5 0 0 0 1.423.23h1.294M7.498 15.25c.618 0 .991.724.725 1.282A7.471 7.471 0 0 0 7.5 19.75 2.25 2.25 0 0 0 9.75 22a.75.75 0 0 0 .75-.75v-.633c0-.573.11-1.14.322-1.672.304-.76.93-1.33 1.653-1.715a9.04 9.04 0 0 0 2.86-2.4c.498-.634 1.226-1.08 2.032-1.08h.384m-10.253 1.5H9.7m8.075-9.75c.01.05.027.1.05.148.593 1.2.925 2.55.925 3.977 0 1.487-.36 2.89-.999 4.125m.023-8.25c-.076-.365.183-.75.575-.75h.908c.889 0 1.713.518 1.972 1.368.12.385.21.782.26 1.19.096.81-.1 1.588-.314 2.341m-.218 3.917c-.3.67-.684 1.294-1.145 1.857m-6.9-14.25c-.436 0-.8.34-.83.774-.02.29-.038.582-.052.874m4.42 12.651c.09.203.172.41.245.62m-9.443-2.75a8.973 8.973 0 0 0-.436 3.142" /></svg>
                                        </button>
                                        <button
                                            type="button"
                                            aria-label="Regenerate"
                                            wire:click="newChat"
                                            class="rounded-lg p-1.5 hover:bg-gray-100 hover:text-gray-600 focus:outline-hidden dark:hover:bg-gray-700 dark:hover:text-gray-300"
                                        >
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992V4.356m0 4.992-3.181-3.183a8.25 8.25 0 0 0-13.803 3.7M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <div wire:loading.flex class="hidden items-center gap-x-3">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-cyan-600 text-white dark:bg-cyan-500">
                            <svg class="size-4 animate-pulse" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </span>
                        <p class="text-sm text-gray-400 dark:text-gray-500">Bud is thinking...</p>
                    </div>
                </div>
            @endif
        </main>

        {{-- Composer --}}
        <footer class="sticky bottom-0 border-t border-gray-200 bg-white/80 px-4 pt-3 pb-2 backdrop-blur sm:px-6 dark:border-gray-700 dark:bg-gray-900/80">
            <form wire:submit="send" class="mx-auto w-full max-w-3xl">
                <div class="flex items-end gap-x-2 rounded-2xl border border-gray-200 bg-white p-2 shadow-sm focus-within:border-cyan-500 focus-within:ring-2 focus-within:ring-cyan-500/20 dark:border-gray-700 dark:bg-gray-800 dark:focus-within:border-cyan-500">
                    <button
                        type="button"
                        aria-label="Attach file"
                        class="mb-0.5 rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-hidden dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                    >
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" /></svg>
                    </button>
                    <input
                        type="text"
                        wire:model="message"
                        wire:keydown.enter="send"
                        placeholder="Message Bud..."
                        autocomplete="off"
                        class="min-w-0 flex-1 border-0 bg-transparent px-1 py-2 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-0 focus:outline-hidden dark:text-white dark:placeholder:text-gray-500"
                    />
                    <button
                        type="button"
                        aria-label="Voice message"
                        class="mb-0.5 rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 focus:outline-hidden dark:text-gray-500 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                    >
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" /></svg>
                    </button>
                    <button
                        type="submit"
                        aria-label="Send message"
                        wire:loading.attr="disabled"
                        wire:target="send"
                        class="mb-0.5 inline-flex items-center justify-center rounded-xl border border-transparent bg-cyan-600 p-2.5 text-white hover:bg-cyan-700 focus:bg-cyan-700 focus:outline-hidden disabled:pointer-events-none disabled:opacity-50 dark:bg-cyan-500 dark:hover:bg-cyan-600 dark:focus:bg-cyan-600"
                    >
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" /></svg>
                    </button>
                </div>
                <p class="pt-2 pb-1 text-center text-xs text-gray-400 dark:text-gray-500">
                    Bud offers support, not medical advice. In crisis, contact your local emergency number.
                </p>
            </form>
        </footer>
    </div>
</div>
