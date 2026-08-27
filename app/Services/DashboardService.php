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
     * Continue a specific conversation (or start a new one if id is null) with the mental health agent.
     */
    public function promptInConversation(string $message, ?string $conversationId = null): string
    {
        $message = trim($message);

        if ($message === '') {
            return '';
        }

        $agent = new MentalHealthAgent;

        if ($conversationId !== null) {
            $agent->continue($conversationId, $this->user());
        } else {
            // Start a fresh conversation instead of continuing the latest one.
            $agent->forParticipant($this->user());
        }

        return $agent->prompt($message, provider: Lab::Gemini)->text;
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

        return $this->messagesForConversation($conversationId);
    }

    /**
     * Get the messages for a specific conversation.
     *
     * @return array<int, array{from: string, text: string}>
     */
    public function messagesForConversation(string $conversationId): array
    {
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
     * Get the latest conversation id for the authenticated user.
     */
    public function latestConversationId(): ?string
    {
        $user = $this->user();

        return resolve(ConversationStore::class)->latestConversationId(
            Conversation::participantType($user),
            Conversation::participantKey($user),
        );
    }

    /**
     * Get the currently authenticated user.
     */
    private function user(): Authenticatable
    {
        return Auth::user() ?? throw new RuntimeException('Dashboard prompts require an authenticated user.');
    }
}
