<?php

namespace App\Livewire;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Dashboard extends Component
{
    /**
     * Static starter prompts shown on the empty chat state.
     *
     * @var array<int, array{icon: string, title: string, sub: string, prompt: string}>
     */
    private const SUGGESTIONS = [
        [
            'icon' => 'frown',
            'title' => "I'm feeling anxious today",
            'sub' => "Talk through what's on your mind",
            'prompt' => "I'm feeling anxious today",
        ],
        [
            'icon' => 'pencil',
            'title' => 'Help me reflect on my week',
            'sub' => 'Guided journaling prompts',
            'prompt' => 'Help me reflect on my week',
        ],
        [
            'icon' => 'chart',
            'title' => 'Guide me through a calm breath',
            'sub' => 'A 2-minute mindful moment',
            'prompt' => 'Guide me through a calm breathing exercise',
        ],
        [
            'icon' => 'moon',
            'title' => "I can't sleep, help me relax",
            'sub' => 'Wind down before bed',
            'prompt' => "I can't sleep, help me relax",
        ],
    ];

    /** @var array<int, array{from: string, text: string}> */
    public array $messages = [];

    public string $message = '';

    protected DashboardService $service;

    public function boot(DashboardService $service)
    {
        $this->service = $service;
    }

    public function mount(DashboardService $service): void
    {
        $this->messages = $service->recentMessages();
    }

    public function send(): void
    {
        $prompt = trim($this->message);

        if ($prompt === '') {
            return;
        }

        $this->messages[] = ['from' => 'user', 'text' => $prompt];
        $this->messages[] = ['from' => 'assistant', 'text' => $this->service->prompt($prompt)];
        $this->message = '';
    }

    public function ask(int $index): void
    {
        $suggestion = self::SUGGESTIONS[$index] ?? null;

        if ($suggestion === null) {
            return;
        }

        $this->message = $suggestion['prompt'];
        $this->send();
    }

    public function newChat(): void
    {
        $this->messages = [];
        $this->message = '';
    }

    /**
     * @return array<int, array{icon: string, title: string, sub: string}>
     */
    public function getSuggestionsProperty(): array
    {
        return array_map(fn (array $suggestion): array => [
            'icon' => $suggestion['icon'],
            'title' => $suggestion['title'],
            'sub' => $suggestion['sub'],
        ], self::SUGGESTIONS);
    }

    #[Computed]
    public function conversation()
    {
        return Auth::user()->conversations()->latest()->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
