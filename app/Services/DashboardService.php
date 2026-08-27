<?php

namespace App\Services;

use App\Ai\Agents\MentalHealthAgent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Ai\Contracts\ConversationStore;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Messages\MessageRole;
use Laravel\Ai\Models\Conversation;
use RuntimeException;

class DashboardService
{
    /**
     * The number of recent conversation messages to load for display.
     */
    private const RECENT_MESSAGE_LIMIT = 100;

    /**
     * Continue (or start) the user's conversation with the mental health agent.
     */
    public function prompt(string $message): string
    {
        $message = trim($message);

        if ($message === '') {
            return '';
        }

        return (new MentalHealthAgent)
            ->continueLastConversation($this->user())
            ->prompt($message, provider: Lab::Gemini)
            ->text;
    }

    /**
     * Get the messages of the user's most recent conversation.
     *
     * @return array<int, array{from: string, text: string}>
     */
    public function recentMessages(): array
    {
        $user = $this->user();

        $conversationId = resolve(ConversationStore::class)->latestConversationId(
            Conversation::participantType($user),
            Conversation::participantKey($user),
        );

        if ($conversationId === null) {
            return [];
        }

        return resolve(ConversationStore::class)
            ->getLatestConversationMessages($conversationId, self::RECENT_MESSAGE_LIMIT)
            ->filter(fn (Message $message): bool => in_array($message->role, [MessageRole::User, MessageRole::Assistant], true))
            ->map(fn (Message $message): array => [
                'from' => $message->role->value,
                'text' => (string) $message->content,
            ])
            ->values()
            ->all();
    }

    /**
     * Get the currently authenticated user.
     */
    private function user(): Authenticatable
    {
        return Auth::user() ?? throw new RuntimeException('Dashboard prompts require an authenticated user.');
    }
}
