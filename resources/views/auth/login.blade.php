<x-layout>
    <div class="flex min-h-[calc(100dvh-4rem)] items-center justify-center px-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold tracking-tight">Iniciar Sessão</h1>
                <p class="text-base-content/70 mt-1">Aceda à sua conta para continuar.</p>
            </div>

            <form action="/login" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="label">Email</label>
                    <input type="email" class="input input-bordered w-full" id="email" name="email" required>
                </div>

                <div class="space-y-2">
                    <label for="password" class="label">Password</label>
                    <input type="password" class="input input-bordered w-full" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary mt-2 h-10 w-full">Entrar</button>
            </form>
        </div>
    </div>
</x-layout>
