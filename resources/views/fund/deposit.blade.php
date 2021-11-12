<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fund Account') }}
        </h2>
    </x-slot>

    <div class="py-6 px-6">
        <div class="flex justify-center md:p-4 p-6 md:max-w-md max-w-lg mx-auto bg-white rounded-xl shadow-md flex items-center space-x-4">
            <div class="py-4 px-4 flex flex-col">
                <span class="md:text-2xl text-xl md:flex md:justify-center font-bold">Deposit</span>
                <!-- <span class="pt-2 font-light text-lg">PollPay
            </span> -->
                @if (session()->has('success'))
                <div class="bg-green-400 rounded-lg p-4 text-white">
                    {{ session('success') }}
                </div>
                @endif

                @if (session()->has('error'))
                <div class="bg-red-400 rounded-lg p-4 text-white">
                    {{ session('error') }}
                </div>
                @endif
                <form action="{{ route('fund') }}" method="POST" class="">
                    @csrf
                    <div class="pt-6">
                        <input type="number" name="amount" value="{{ old('amount') }}" class="@error('amount') ring-red-500 text-white @enderror rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="500" />
                        @error('amount') {{ $message }} @enderror
                    </div>
                    <!-- <div class="pt-6">
                    <input type="password" name="password" class="rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Password" />
                </div> -->
                    <div class="pt-6">
                        <div class="flex justify-center md:p-1 p-2 max-w-lg mx-auto bg-blue-500 rounded-xl shadow-md">
                            <button type="submit" class="text-white flex justify-evenly">
                                Fund Wallet
                            </button>
                        </div>
                    </div>
                    <!-- <div class="pt-6">
                    <input type="checkbox" name="" id="">
                    <span class="font-thin text-md">Remember me</span>
                </div> -->
                </form>
            </div>
        </div>
    </div>

</x-app-layout>