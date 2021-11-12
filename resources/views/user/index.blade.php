<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User') }}
        </h2>
    </x-slot>

    <div class="p-8 space-y-2 md:flex justify-center text-center">
        <div class="md:w-1/2 bg-white shadow-md rounded-lg p-4">
            <div class="flex justify-center">
                @if(empty($user->profile->image))
                <img src="https://picsum.photos/200/300" class="w-40 h-40 rounded-lg" alt="">
                @else
                <img src="{{ URL::to('/') }}/profiles/{{ $user->profile->image }}" class="w-40 h-40 rounded-lg" alt="">
                @endif
            </div>
            <div class="pt-2">
                <button class="rounded-md bg-blue-500 p-3 text-white">Follow</button>
            </div>
            <div class="pt-2 grid grid-cols-1 divide-y divide-yellow-500">
                <span class="text-md md:text-2xl">Personal Information</span>
                <span></span>
            </div>
            <div class="grid">
                <span>Name:</span> <span class="text-md md:text-lg">{{ $user->name }}</span>
                <span>Email:</span> <span class="text-md md:text-lg">{{ $user->email }}</span>
                <span>Joined: </span> <span class="text-md md:text-lg"> {{ $user->created_at->diffForHumans() }} </span>
            </div>
        </div>
    </div>

    <div class="p-8 space-y-2 md:flex justify-center text-center">
        <div class="md:w-1/2 bg-white shadow-md rounded-lg p-4">
            <span class="text-xl">Posts by {{ $user->name }}</span>
            @foreach($user->polls as $poll)
            <div class="grid pt-2 space-y-3">
                <a href="{{ route('single', $poll->id) }}" class="bg-blue-300 p-3 rounded-lg text-md text-white">{{ $poll->title }}</a>
            </div>
            @endforeach
        </div>
    </div>

</x-app-layout>