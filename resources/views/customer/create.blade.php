<x-splade-modal>
    <h1>Create new user</h1>

    <x-splade-form method="post">
        <x-splade-input v-model="form.first_name" type="text"/>
        <x-splade-input v-model="form.last_name" type="text"/>
        <x-splade-input v-model="form.birthday" type="date"/>
        <x-splade-input v-model="form.contact" type="text"/>

        <button type="submit">Send</button>
    </x-splade-form>

</x-splade-modal>
