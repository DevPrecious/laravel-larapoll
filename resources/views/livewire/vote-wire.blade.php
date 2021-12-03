<div>
    @if(!empty($polls))
    @foreach($polls as $poll)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg"> -->
            <!-- <div class="p-6 bg-white border-b border-gray-200"> -->
            <div class="md:px-8 md:py-2 px-4 py-4" id="vote_sec">
                <div class="rounded-lg p-8 bg-blue-400 shadow-md max-w-lg md:mx-auto">
                    @if (session()->has('message'))
                    <div class="bg-green-400 rounded-lg p-4 text-white">
                        {{ session('message') }}
                    </div>
                    @endif
                    <span class="text-white text-xl">Staked {{$poll->stake}}</span>
                    <div class="flex justify-between">
                        <a href="{{ route('users', $poll->user->username) }}" class="text-md text-white">{{ $poll->user->name }}</a>
                        <span class="text-md text-white">{{ \Carbon\Carbon::parse($poll['created_at'])->diffForHumans() }}</span>
                    </div>
                    <span class="font-semibold text-xl text-white flex justify-center">
                        {{ $poll['title'] }}
                    </span>
                    <div class="pt-4">
                        <input type="number" value="{{ old('staked') }}" wire:model="staked" id="staked" class="@error('staked') ring-red-500 @enderror rounded-lg p-4 ring ring-gray-100 ring-offset-0 w-full h-8 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Stake">
                        @error('staked') <span class="text-white">{{ $message }}</span> @enderror
                    </div>
                    <div class="pt-2 flex flex-col">
                        @foreach($poll['options'] as $option)
                        <div class="pt-4">
                            <button wire:click.prevent="store({{ $poll['id'] }}, {{ $option['id'] }})" type="button" class="click-on w-full rounded-lg text-white p-2 bg-blue-300 shadow md">
                                {{ $option['option'] }}
                            </button>
                        </div>
                        @endforeach
                    </div>
                    <div class="pt-4 flex flex-row justify-between">
                        <span class="text-white">
                            Ends {{ \Carbon\Carbon::parse($poll['end_at'])->diffForHumans() }}
                        </span>
                        <span class="text-white">{{ $poll['votes']->count() }} {{ Str::plural('vote', $poll['votes']->count()) }}</span>
                    </div>
                    <div class="pt-2">
                        <a href="{{ route('single', $poll['id']) }}" class="text-white text-md">Comment</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- </div> -->
        <!-- </div> -->
    </div>
    @endforeach
    @else
    <div class="bg-white p-4 rounded-lg">
        No Polls
    </div>
    @endif
</div>