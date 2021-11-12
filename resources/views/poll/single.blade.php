<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Single Poll') }}
        </h2>
    </x-slot>

    @livewire('poll-single', ['r_id' => Route::current()->parameter('id')])

</x-app-layout>