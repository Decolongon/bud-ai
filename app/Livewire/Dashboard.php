<?php

namespace App\Livewire;

use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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

    public ?string $activeConversationId = null;

    public string $search = '';

    protected DashboardService $service;

    public function boot(DashboardService $service)
    {
        $this->service = $service;
    }

    public function mount(): void
    {
        $this->activeConversationId = $this->service->latestConversationId();
        $this->messages = $this->service->recentMessages();
    }

    public function send(): void
    {
        $prompt = trim($this->message);

        if ($prompt === '') {
            return;
        }

        $this->messages[] = ['from' => 'user', 'text' => $prompt];
        $this->messages[] = ['from' => 'assistant', 'text' => $this->service->promptInConversation($prompt, $this->activeConversationId)];
        $this->message = '';

        // If this was a new chat, capture the newly created conversation id.
        if ($this->activeConversationId === null) {
            $this->activeConversationId = $this->service->latestConversationId();
        }

        unset($this->conversations, $this->conversation);
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
        $this->activeConversationId = null;
    }

    public function selectConversation(string $conversationId): void
    {
        $user = Auth::user();

        $conversation = $user->conversations()->where('id', $conversationId)->first();

        if ($conversation === null) {
            return;
        }

        $this->activeConversationId = $conversation->id;
        $this->messages = $this->service->messagesForConversation($conversation->id);
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
    public function conversations()
    {
        return Auth::user()->conversations()
            ->when(trim($this->search) !== '', function ($query): void {
                $query->where('title', 'like', '%'.trim($this->search).'%');
            })
            ->latest('updated_at')
            ->get();
    }

    /**
     * Kept for backward-compatibility if referenced elsewhere.
     */
    #[Computed]
    public function conversation()
    {
        return $this->conversations();
    }

    public function logout()
    {
        Auth::logout();
        Session::invalidate();
        Session::regenerate();

        return $this->redirectIntended(route('home'));
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
