@props(['idea' => new App\Models\Idea()])

<x-modal name="create-idea" title="{{ $idea->exists ? 'Edit Idea' : 'New Idea' }}">
    <form
        x-data="{
            status: @js(old('status', $idea->status->value)),
            newLink: '',
            links: @js(old('links', $idea->links ?? [])),
            newStep: '',
            steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed'])))
        }"
        method="POST"
        action="{{ $idea->exists ? route('idea.update', $idea) : route('idea.store') }}"
        enctype="multipart/form-data"
    >
        @csrf

        @if ($idea->exists)
            @method('PATCH')
        @endif

        <div class="space-y-6">
            <x-forms.field
                label="Title"
                name="title"
                placeholder="Enter an idea for your title"
                autofocus
                required
                :value="old('title', $idea->title)"
            />

            <div class="space-y-2">
                <label for="status" class="label">Status</label>

                <div class="flex gap-x-3">
                    @foreach (App\Enums\IdeaStatus::cases() as $status)
                        <button
                            type="button"
                            @click="status = @js($status->value)"
                            data-test="button-status-{{ $status->value }}"
                            class="btn flex-1 h-10"
                            :class="{ 'btn-outlined': status !== @js($status->value) }"
                        >
                            {{ $status->label() }}
                        </button>
                    @endforeach
                </div>

                <input type="hidden" name="status" :value="status" class="input">
                <x-forms.error name="status" />
            </div>

            <x-forms.field
                label="Description"
                name="description"
                type="textarea"
                placeholder="Describe your idea..."
                :value="old('description', $idea->description)"
            />

            <div class="space-y-2">
                <label for="image" class="label">Featured image</label>

                @if ($idea->image_path)
                    <div class="space-y-2">
                        <img
                            src="{{ asset('storage/' . $idea->image_path) }}"
                            alt="{{ $idea->title }}"
                            class="w-full h-48 object-cover rounded-lg"
                        >
                        <button type="button" class="btn btn-outlined h-10 w-full" form="delete-image-form">Remover Imagem</button>
                    </div>
                @endif

                <input type="file" id="image" name="image" accept="image/*" class="input">
                <x-forms.error name="image" />
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Actionable Steps</legend>

                    <template x-for="(step, index) in steps" :key="step.id || index">
                        <div class="flex gap-x-2 items-center">
                            <input type="text" :name="`steps[${index}][description]`" x-model="step.description" class="input flex-1" readonly>
                            <input type="hidden" :name="`steps[${index}][completed]`" :value="step.completed ? '1' : '0'">

                            <button
                                type="button"
                                aria-label="Remove step"
                                @click="steps.splice(index, 1)"
                            >
                                <x-icons.close />
                            </button>
                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center">
                        <input
                            x-model="newStep"
                            id="new-step"
                            data-test="new-step"
                            placeholder="What needs to be done?"
                            class="input flex-1"
                            spellcheck="false"
                        >

                        <button
                            type="button"
                            @click="
                                steps.push({ description: newStep.trim(), completed: false });
                                newStep = '';
                            "
                            data-test="submit-new-step-button"
                            :disabled="!newStep.trim().length"
                            aria-label="Add a new step"
                        >
                            <x-icons.close class="rotate-45" />
                        </button>
                    </div>
                </fieldset>
            </div>

            <div>
                <fieldset class="space-y-3">
                    <legend class="label">Links</legend>

                    <template x-for="(link, index) in links" :key="index">
                        <div class="flex gap-x-2 items-center">
                            <input type="text" name="links[]" x-model="links[index]" class="input flex-1" readonly>

                            <button
                                type="button"
                                aria-label="Remove link"
                                @click="links.splice(index, 1)"
                            >
                                <x-icons.close />
                            </button>
                        </div>
                    </template>

                    <div class="flex gap-x-2 items-center">
                        <input
                            x-model="newLink"
                            type="url"
                            id="new-link"
                            data-test="new-link"
                            placeholder="http://example.com"
                            autocomplete="url"
                            class="input flex-1"
                            spellcheck="false"
                        >

                        <button
                            type="button"
                            @click="links.push(newLink.trim()); newLink = ''"
                            data-test="submit-new-link-button"
                            :disabled="!newLink.trim().length"
                            aria-label="Add a new link"
                        >
                            <x-icons.close class="rotate-45" />
                        </button>
                    </div>
                </fieldset>
            </div>

            <div class="flex justify-end gap-x-5">
                <button type="button" @click="$dispatch('close-modal')">Cancel</button>
                <button type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>
            </div>
        </div>
    </form>

    @if ($idea->image_path)
        <form method="POST" action="{{ route('idea.image.destroy', $idea) }}" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>
