<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administration') }}
        </h2>
    </x-slot>
    <div class="mt-10">
        <div class="flex justify-between">
            <h3 class="text-2xl font-bold">Liste des Clients</h3>
            <Link href="{{route("administrative.create")}}" modal class="px-2 py-3 rounded-md bg-blue-600 text-white">

            Ajouter un client
            </Link>
        </div>
    </div>
    <div class=" mt-5">
        <x-splade-table :for="$customers"/>
    </div>

</x-app-layout>
