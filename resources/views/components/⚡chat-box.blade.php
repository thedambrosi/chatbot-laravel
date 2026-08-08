<?php

use App\Ai\Agents\ChatAssistant;
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
        $this->validate(
            ['body' => ['required', 'string', 'max:2000']],
            ['body.required' => 'Digite uma mensagem.', 'body.max' => 'Mensagem muito longa (máximo 2000 caracteres).']
        );

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

        $this->dispatch('message-sent');
    }
}; ?>

<div class="flex flex-1 flex-col overflow-hidden">
    <div x-data
        x-on:message-sent.window="$nextTick(() => $el.scrollTop = $el.scrollHeight)"
        class="flex-1 space-y-6 overflow-y-auto py-8">
        @forelse ($this->messages as $message)
        @if ($message->role === 'user')
        <div class="flex justify-end">
            <p class="max-w-[85%] rounded-lg bg-[#1A1F29] px-4 py-3 text-sm leading-relaxed">
                {{ $message->content }}
            </p>
        </div>
        @else
        <div class="border-l-2 border-[#7C9CF5] pl-4">
            <p class="text-xs uppercase tracking-[0.15em] text-[#8790A0]">Assistente</p>
            <p class="mt-2 whitespace-pre-line text-sm leading-relaxed">{{ $message->content }}</p>
        </div>
        @endif
        @empty
        <p class="pt-12 text-center text-sm text-[#8790A0]">
            Mande a primeira mensagem para começar.
        </p>
        @endforelse

        <p wire:loading class="border-l-2 border-[#2A313F] pl-4 text-sm text-[#8790A0]">
            Pensando...
        </p>
    </div>

    <div class="border-t border-[#2A313F] py-5">
        <form wire:submit="send" class="flex gap-3">
            <input type="text" wire:model="body" placeholder="Digite sua mensagem"
                wire:loading.attr="disabled"
                x-on:message-sent.window="$el.focus()"
                class="flex-1 rounded-md border border-[#2A313F] bg-[#1A1F29] px-4 py-3 text-sm placeholder:text-[#8790A0] focus:border-[#7C9CF5] focus:outline-none disabled:opacity-50">
            <button type="submit" wire:loading.attr="disabled"
                class="rounded-md bg-[#7C9CF5] px-5 text-sm font-medium text-[#11141B] transition hover:bg-[#95AEF7] disabled:opacity-50">
                Enviar
            </button>
        </form>

        @error('body')
        <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
        @enderror
    </div>
</div>