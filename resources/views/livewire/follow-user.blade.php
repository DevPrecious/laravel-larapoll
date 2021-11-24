<div>
    @if($user->id != Auth::user()->id)
    <button wire:click.prevent="follow" class="rounded-md bg-blue-500 p-3 text-white">
        {{ $text }}
    </button>
    @endif
    <div class="pt-2">
        <span class="text-md">{{ $user->followings()->count() }} Following</span>
        <span class="text-md">{{ $user->followers()->count() }} Followers </span>
    </div>
</div>