<x-layout>
    <div>
        <header class="py-8 md:py-12">
            <h1 class="text-3xl font-bold">Ideas</h1>
            <p class="text-muted-foreground text-sm mt-2">Capture your thoughts. Make a plan.</p>

            <x-card x-data @click="$dispatch('open-modal', 'create-idea')" is="button" type="button"
                data-test="create-idea-button" class="mt-10 cursor-pointer h-32 w-full text-left">
                What's the idea?
            </x-card>
        </header>

        <div>
            <a href="/ideas" class="btn {{ request('status') === null ? '' : 'btn-outlined' }}">
                All
            </a>

            @foreach (App\Enums\IdeaStatus::cases() as $status)
                <a href="/ideas?status={{ $status->value }}"
                    class="btn {{ request('status') === $status->value ? '' : 'btn-outlined' }}">
                    {{ $status->label() }} <span class="text-xs pl-3">{{ $statusCounts->get($status->value) }}</span>
                </a>
            @endforeach
        </div>

        <div class="mt-10 text-muted-foreground">
            <div class="grid md:grid-cols-2 gap-6 items-start">

                @forelse($ideas as $idea)
                    <x-card href="{{ route('idea.show', $idea) }}"
                        class="p-0 overflow-hidden hover:border-primary transition flex flex-col h-full">
                        @if ($idea->image_path)
                            <div class="w-full overflow-hidden bg-muted">
                                <img src="{{ asset('storage/' . $idea->image_path) }}" alt="Idea Image"
                                    class="w-full h-48 object-cover">
                            </div>
                        @endif

                        <div class="p-6 flex flex-col flex-1">
                            <h3 class="text-foreground text-lg font-semibold">
                                {{ $idea->title }}
                            </h3>

                            <div class="mt-1">
                                <x-idea.status-label status="{{ $idea->status->value }}">
                                    {{ $idea->status->label() }}
                                </x-idea.status-label>
                            </div>

                            <div class="mt-5 line-clamp-3">
                                {{ strip_tags(Str::markdown($idea->description)) }}
                            </div>
                            <div class="mt-4 text-xs">
                                {{ $idea->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </x-card>
                @empty
                    <x-card class="col-span-2 p-6">
                        <p>No ideas at this time.</p>
                    </x-card>
                @endforelse
            </div>
        </div>

        <!-- Create Idea Modal extracted to component -->
        <x-idea.modal />
    </div>
</x-layout>
