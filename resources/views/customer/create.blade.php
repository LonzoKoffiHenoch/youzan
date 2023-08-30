<x-splade-modal>
    <h1 class="font-bold text-2xl mb-2">Create un nouveau client</h1>

    <x-splade-form method="post" class="flex flex-col space-y-2">
        <x-splade-input v-model="form.first_name" type="text" label="Saisir le nom"/>
        <x-splade-input v-model="form.last_name" type="text" label="Saisir le prenom"/>
        <x-splade-input v-model="form.birthday" type="date" label="Entrée la date d'anniversaire"/>
        <x-splade-input v-model="form.contact" type="text" label="Entrez le contact "/>

        <button type="submit" class="bg-blue-600 rounded-md py-2 text-white ">Ajouter un client</button>
    </x-splade-form>

</x-splade-modal>
