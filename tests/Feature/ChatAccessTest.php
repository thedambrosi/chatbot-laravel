<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('visitante não autenticado é redirecionado para o login', function () {
    get('/chat')->assertRedirect('/login');
});

test('usuário autenticado acessa o chat', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get('/chat')
        ->assertOk()
        ->assertSee($user->name);
});
