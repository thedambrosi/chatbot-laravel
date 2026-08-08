<x-layouts.app title="Chat">
    <div class="mx-auto flex h-full max-w-2xl flex-col px-6">
        <header class="flex items-center justify-between border-b border-[#2A313F] py-5">
            <div>
                <p class="text-xs uppercase tracking-[0.2em] text-[#8790A0]">Chatbot</p>
                <p class="mt-1 text-sm">{{ auth()->user()->name }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-[#8790A0] transition hover:text-[#E6E9EF]">
                    Sair
                </button>
            </form>
        </header>

        <livewire:chat-box />
    </div>
</x-layouts.app>