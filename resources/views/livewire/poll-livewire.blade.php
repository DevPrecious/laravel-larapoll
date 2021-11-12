<div>
    <div class="py-6 px-6">
        <div class="flex justify-center md:p-4 p-6 md:max-w-md max-w-lg mx-auto bg-white rounded-xl shadow-md flex items-center space-x-4">
            <div class="py-4 px-4 flex flex-col">
                <span class="md:text-2xl text-xl md:flex md:justify-center font-bold">Create a Poll</span>
                <!-- <span class="pt-2 font-light text-lg">PollPay
                <a href="/register" class="text-blue-700 font-semibold"><u>Register</u></a>
            </span> -->
                <form id="add_poll" class="">
                    <div>
                        @if (session()->has('message'))
                        <div class="bg-green-400 rounded-lg p-4 text-white">
                            {{ session('message') }}
                        </div>
                        @endif
                    </div>
                    <div class="pt-6">
                        <input type="text" wire:model="title" value="{{ old('title') }}" class="@error('title') ring-red-500 @enderror rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="What is it about?" />
                        @error('title') {{ $message }} @enderror
                    </div>
                    <div class="pt-6" id="dynamic_field">
                        <div class="flex flex-col">
                            <input type="text" wire:model="option.0" required class="@error('option.0') ring-red-500 @enderror rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Option" />
                            @error('option.0') {{ $message }} @enderror
                        </div>
                        @foreach($inputs as $key => $value)
                        <div class="pt-2">
                            <input type="text" wire:model="option.{{ $value }}" placeholder="Option" class="@error('option.{{ $value }}') ring-red-500 @enderror rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                            @error('option.'.$value) {{ $message }} @enderror
                        </div>
                        <div class="pt-2">
                            <button class="w-full rounded-lg text-white shadow-md bg-blue-200" wire:click.prevent="remove({{$key}})">-</button>
                        </div>
                        @endforeach
                        <div class="p-2">
                            <button wire:click.prevent="add({{$i}})" class="w-full rounded-lg text-white shadow-md bg-blue-200" id="add">+</button>
                        </div>
                    </div>
                    <div class="pt-6">
                        <input type="number" wire:model="amount" id="amount" class="@error('title') ring-red-500 @enderror rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Stake">
                        @error('amount') {{ $message }} @enderror
                    </div>
                    <div class="pt-6">
                        <input type="datetime-local" required wire:model="datetostop" class="rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Time to stop" />
                    </div>
                    <div class="pt-6">
                        <div class="flex justify-center md:p-1 p-2 max-w-lg mx-auto bg-blue-500 rounded-xl shadow-md">
                            <button wire:click.prevent="store()" type="button" id="submit" class="flex justify-evenly text-white">
                                Create
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>