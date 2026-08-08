<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

class ChatAssistant implements Agent
{
    use Promptable;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return 'Você é um assistente virtual prestativo e amigável. '
            . 'Responda sempre em português do Brasil, de forma clara e concisa. '
            . 'Se não souber a resposta, diga que não sabe em vez de inventar.';
    }
}
