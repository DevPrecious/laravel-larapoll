<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Poll') }}
        </h2>
    </x-slot>


    @livewire('poll-livewire')

</x-app-layout>