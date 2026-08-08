<?php

use App\Ai\Agents\ChatAssistant;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

test('mensagem enviada salva a pergunta e a resposta da IA', function () {
    ChatAssistant::fake(['Resposta simulada da IA.']);

    $user = User::factory()->create();
    actingAs($user);

    Livewire::test('chat-box')
        ->set('body', 'Olá, tudo bem?')
        ->call('send');

    expect($user->messages()->count())->toBe(2);

    expect($user->messages()->where('role', 'user')->first()->content)
        ->toBe('Olá, tudo bem?');

    expect($user->messages()->where('role', 'assistant')->first()->content)
        ->toBe('Resposta simulada da IA.');

    ChatAssistant::assertPrompted('Olá, tudo bem?');
});

test('mensagem vazia não é salva', function () {
    ChatAssistant::fake();

    $user = User::factory()->create();
    actingAs($user);

    Livewire::test('chat-box')
        ->set('body', '')
        ->call('send')
        ->assertHasErrors(['body' => 'required']);

    expect($user->messages()->count())->toBe(0);

    ChatAssistant::assertNeverPrompted();
});
