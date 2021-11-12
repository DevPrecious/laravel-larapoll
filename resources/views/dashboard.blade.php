<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(!empty($polls))
    @foreach($polls as $poll)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> -->
            <!-- <div class="p-6 bg-white border-b border-gray-200"> -->
            <div class="md:px-8 md:py-2 px-4 py-4" id="vote_sec">
                <div class="rounded-lg p-8 bg-blue-400 shadow-md max-w-lg md:mx-auto">
                    <span class="font-semibold text-xl text-white flex justify-center">
                        {{ $poll['title'] }}
                    </span>
                    <div class="pt-4">
                        <input type="number" name="staked" id="staked" class="rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Stake">
                    </div>
                    <div class="pt-2 flex flex-col">
                        @foreach($poll['options'] as $option)
                        <div class="pt-4">
                            <button id="" class="click-on w-full rounded-lg text-white p-2 bg-blue-300 shadow md">
                                {{ $option['option'] }}
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <div class="pt-4 flex flex-row justify-between">
                        <span class="text-white">
                            Ends {{ $poll['created_at'] }}
                        </span>
                        <span class="text-white">30k votes</span>
                    </div>
                </div>

            </div>
        </div>
        <!-- </div> -->
        <!-- </div> -->
    </div>
    </div>
    @endforeach
    @else
    <div class="bg-white p-4 rounded-lg">
        No Polls
    </div>
    @endif
</x-app-layout>