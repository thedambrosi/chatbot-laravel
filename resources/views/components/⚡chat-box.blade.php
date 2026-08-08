<?php

use App\Ai\Agents\ChatAssistant;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Throwable;

new class extends Component {
    public string $body = '';

    #[Computed]
    public function messages()
    {
        return Auth::user()->messages()->oldest()->get();
    }

    public function send()
    {
        $this->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $prompt = $this->body;

        Auth::user()->messages()->create([
            'role' => 'user',
            'content' => $prompt,
        ]);

        $this->body = '';
        unset($this->messages);

        try {
            $reply = (new ChatAssistant)->prompt($prompt)->text;
        } catch (Throwable $e) {
            report($e);
            $reply = 'Desculpe, não consegui responder agora. Tente novamente.';
        }

        Auth::user()->messages()->create([
            'role' => 'assistant',
            'content' => $reply,
        ]);

        unset($this->messages);
    }
}; ?>

<div>
    <div>
        @foreach ($this->messages as $message)
        <p>
            <strong>{{ $message->role === 'user' ? 'Você' : 'IA' }}:</strong>
            {{ $message->content }}
        </p>
        @endforeach
    </div>

    <form wire:submit="send">
        <input type="text" wire:model="body" placeholder="Digite sua mensagem..." wire:loading.attr="disabled">
        <button type="submit" wire:loading.attr="disabled">Enviar</button>
    </form>
    @error('body') <p style="color:red">{{ $message }}</p> @enderror

    <p wire:loading>Pensando...</p>
</div>