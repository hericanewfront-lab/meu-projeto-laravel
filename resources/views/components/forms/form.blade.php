@props(['title' => '', 'description' => ''])

<div class="flex min-h-[calc(100dvh-4rem)] items-center justify-center px-4">
    <div class="w-full max-w-md">
        @if ($title)
            <div class="text-center">
                <h1 class="text-3xl font-bold tracking-tight">{{ $title }}</h1>
                @if ($description)
                    <p class="text-base-content/70 mt-1">{{ $description }}</p>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</div>
