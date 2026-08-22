<?php

namespace App\Livewire;

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

    public function send(): void
    {
        $text = trim($this->message);

        if ($text === '') {
            return;
        }

        $this->messages[] = ['from' => 'user', 'text' => $text];
        $this->message = '';
        $this->messages[] = ['from' => 'bud', 'text' => $this->replyFor($text)];
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

    private function replyFor(string $text): string
    {
        $lower = mb_strtolower($text);

        if (str_contains($lower, 'anxious') || str_contains($lower, 'anxiety') || str_contains($lower, 'worry')) {
            return "Thank you for sharing that with me — anxiety can feel overwhelming, but you're not alone in this moment.\n\n"
                ."Try this with me:\n\n"
                ."1. Name three things you can see around you.\n"
                ."2. Take a slow breath in for 4 counts, hold for 4, and out for 6.\n"
                ."3. Notice how your shoulders feel, and let them drop.\n\n"
                .'Would you like to keep talking about what is making you feel this way?';
        }

        if (str_contains($lower, 'sleep') || str_contains($lower, 'tired') || str_contains($lower, 'night')) {
            return "Restless nights are exhausting, and it makes sense you're looking for some calm.\n\n"
                ."A gentle wind-down you can try tonight:\n\n"
                ."- Put screens away 30 minutes before bed.\n"
                ."- Write down anything still circling in your mind so it can rest too.\n"
                ."- Breathe slowly: in for 4, out for 6, ten times.\n\n"
                .'Sweet dreams start small — would you like me to guide you through a relaxation story?';
        }

        if (str_contains($lower, 'work') || str_contains($lower, 'overwhelm') || str_contains($lower, 'stress')) {
            return "That sounds really heavy — carrying too much at once wears anyone down.\n\n"
                ."Let's make it lighter:\n\n"
                ."- Pick just three priorities for tomorrow and let the rest wait.\n"
                ."- Take a real 10-minute break away from your screen today.\n"
                ."- At day's end, write a closing line like 'done for today' to help your mind switch off.\n\n"
                .'What is weighing on you the most right now?';
        }

        if (str_contains($lower, 'reflect') || str_contains($lower, 'journal') || str_contains($lower, 'week')) {
            return "Reflection helps us see how far we've really come. Let's take a gentle look at your week:\n\n"
                ."1. What was one moment that felt good, even a small one?\n"
                ."2. What drained your energy the most?\n"
                ."3. What is one kind thing you can do for yourself this weekend?\n\n"
                .'There are no wrong answers here — write whatever feels true.';
        }

        if (str_contains($lower, 'sad') || str_contains($lower, 'down') || str_contains($lower, 'low')) {
            return "I'm really glad you told me. Low days are hard, and feeling them doesn't mean something is wrong with you.\n\n"
                ."For right now:\n\n"
                ."- Be as kind to yourself as you would be to a good friend.\n"
                ."- If possible, get some daylight or step outside for five minutes.\n"
                ."- Reach out to one person you trust, even with a simple message.\n\n"
                .'If this heaviness stays for weeks or feels too much, please talk to a professional or someone close to you. You deserve real support.';
        }

        return "Thank you for telling me how you feel — putting it into words already takes courage.\n\n"
            ."I'm here to listen without judgment. You can tell me more about what's going on, or we can do something calming together, like a short breathing exercise.\n\n"
            .'What would feel most helpful right now?';
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
