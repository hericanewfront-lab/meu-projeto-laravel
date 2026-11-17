<x-layout>
    <x-forms.form title="Editar conta" description="Precisa alterar algo?">
        <form action="/profile/edit" method="POST" class="mt-10 space-y-4">
            @csrf
            @method('PATCH')
            <x-forms.field name="name" label="Name" />
            <x-forms.field name="email" label="Email" type="email" />
            <x-forms.field name="password" label="Password" type="password" />

            <button type="submit" class="btn mt-2 h-10 w-full">Update Account</button>
        </form>
    </x-forms.form>
</x-layout>
