<?php

namespace App\Ai\Agents;

use App\Models\Message as ChatMessage;
use Illuminate\Support\Collection;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Messages\AssistantMessage;
use Laravel\Ai\Messages\UserMessage;
use Laravel\Ai\Promptable;
use Stringable;

class ChatAssistant implements Agent, Conversational
{
    use Promptable;

    public function __construct(private Collection $history = new Collection) {}

    public function instructions(): Stringable|string
    {
        return 'Você é um assistente virtual prestativo e amigável. '
            .'Responda sempre em português do Brasil, de forma clara e concisa. '
            .'Se não souber a resposta, diga que não sabe em vez de inventar.';
    }

    public function messages(): iterable
    {
        return $this->history->map(
            fn (ChatMessage $message) => $message->role === 'user'
                ? new UserMessage($message->content)
                : new AssistantMessage($message->content)
        )->all();
    }
}
