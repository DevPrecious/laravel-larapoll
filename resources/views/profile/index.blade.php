<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="p-8 space-y-2 md:flex">
        <div class="md:w-1/2 bg-white shadow-md rounded-lg p-4">
            <div class="flex justify-center">
                @if(empty($user->profile->image))
                <img src="https://picsum.photos/200/300" class="w-40 h-40 rounded-lg" alt="">
                @else
                <img src="{{ URL::to('/') }}/profiles/{{ $user->profile->image }}" class="w-40 h-40 rounded-lg" alt="">
                @endif
            </div>
            <div class="pt-2 flex justify-center">
                <span>{{ $user->name }}</span>
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
        <div class="pl-2"></div>
        <div class="md:w-1/2 bg-white shadow-md rounded-lg p-4">
            @if(Session::get('success'))
            <div class="flex justify-center">
                <div class="rounded-md bg-green-500 p-3 text-white md:w-1/2">
                    <div class="flex">
                        <div class="hidden md:grid md:grid-cols-2 md:space-x-6 md:divide-x divide-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div></div>
                        </div>
                        <div class="pl-3">
                            {{ Session::get('success') }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-center">
                    <span class="text-lg">Update Profile</span>
                </div>
                <div class="pt-3">
                    <div class="grid">
                        <label for="" class="text-md">Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="@error('name') ring-red-500 @enderror rounded-md">
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                        <label for="" class="text-md">Email</label>
                        <input type="text" name="email" value="{{ $user->email }}" class="@error('name') ring-red-500 @enderror rounded-md">
                        @error('email') <span class="text-red-500">{{ $message }}</span> @enderror
                        <label for="" class="text-md">Password</label>
                        <input type="password" name="password" class="@error('name') ring-red-500 @enderror rounded-md">
                        @error('password') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-1 divide-y divide-yellow-500">
                        <div class="pt-2"></div>
                        <span class="text-xl">Profile Image</span>
                    </div>
                    <div class="grid">
                        <label for="" class="text-md">Image</label>
                        <input type="file" name="image" class="@error('name') ring-red-500 @enderror rounded-md ring-1 ring-black-500">
                        @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="bg-blue-500 text-white p-3 rounded-lg w-full">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</x-app-layout>