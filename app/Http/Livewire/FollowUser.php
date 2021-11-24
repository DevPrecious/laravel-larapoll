<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class FollowUser extends Component
{
    public $user_id;
    public $text;
    public $user;

    public function mount()
    {
        $this->user_id;
    }

    public function render()
    {
        $you = User::find(auth()->id());
        $user_to_follow = User::find($this->user_id);

        if ($you->isFollowing($user_to_follow)) {
            $this->text = 'Following';
        } else {
            $this->text = 'Follow';
        }
        $this->user = $user_to_follow;
        return view('livewire.follow-user');
    }

    public function follow()
    {
        $you = User::find(auth()->id());
        $user_to_follow = User::find($this->user_id);

        if ($you->isFollowing($user_to_follow)) {
            $you->unfollow($user_to_follow);
        } else {
            $you->follow($user_to_follow);
        }
    }
}
