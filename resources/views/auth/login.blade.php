<x-layouts.app title="Entrar">
    <main class="grid min-h-full place-items-center px-6">
        <div class="w-full max-w-sm">
            <p class="text-xs uppercase tracking-[0.2em] text-[#8790A0]">Chatbot</p>
            <h1 class="mt-3 text-3xl font-bold" style="font-family: 'Space Grotesk', sans-serif">
                Entre para conversar
            </h1>
            <p class="mt-3 text-sm leading-relaxed text-[#8790A0]">
                Suas conversas ficam salvas na sua conta.
            </p>

            @if (session('error'))
            <p class="mt-6 border-l-2 border-red-400 bg-red-400/10 py-2 pl-3 text-sm text-red-300">
                {{ session('error') }}
            </p>
            @endif

            <a href="{{ route('google.redirect') }}"
                class="mt-8 flex w-full items-center justify-center rounded-md bg-[#7C9CF5] px-4 py-3 text-sm font-medium text-[#11141B] transition hover:bg-[#95AEF7] focus-visible:ring-2 focus-visible:ring-[#7C9CF5] focus-visible:ring-offset-2 focus-visible:ring-offset-[#11141B]">
                Entrar com Google
            </a>
        </div>
    </main>
</x-layouts.app>