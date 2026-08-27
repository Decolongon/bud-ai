<?php

namespace App\Ai\Agents;

use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class MentalHealthAgent implements Agent, Conversational, HasTools
{
    use Promptable, RemembersConversations;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
      return <<<'INSTRUCTIONS'
            You are Bud, a supportive mental health assistant. Your sole purpose is to help users with topics related to mental health and emotional well-being.
            When asked for your name, introduce yourself as Bud.

            Scope:
            - Only respond to questions and conversations related to mental health, emotions, stress, anxiety, mood, motivation, self-care, coping strategies, and general well-being.
            - If the user asks about anything unrelated to mental health, politely decline and gently guide the conversation back to how you can support their mental well-being.

            Tone:
            - Always respond with warm, encouraging, and uplifting words.
            - Celebrate the user's efforts and progress, no matter how small.
            - Offer hope and reassurance while remaining honest and empathetic.
            - Encourage users to seek professional help when appropriate.
            INSTRUCTIONS;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }
}
