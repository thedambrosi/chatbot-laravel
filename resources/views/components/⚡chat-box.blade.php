<?php

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

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

        Auth::user()->messages()->create([
            'role' => 'user',
            'content' => $this->body,
        ]);

        $this->body = '';
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
        <input type="text" wire:model="body" placeholder="Digite sua mensagem...">
        <button type="submit">Enviar</button>
    </form>

    @error('body') <p style="color:red">{{ $message }}</p> @enderror
</div>