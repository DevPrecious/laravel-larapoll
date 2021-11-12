<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use App\Models\Poll;
use App\Models\Option;
use App\Models\User;
use App\Models\Vote;
use App\Models\wallet;
use App\Rules\CheckUserBalance;

class PollSingle extends Component
{
    public $polls;
    public $poll_id, $option_id, $user_id, $staked;
    public $r_id;
    public $comment, $comments;

    public function mount()
    {
        $this->r_id;
    }

    public function render()
    {
        // $polls = Poll::all();
        $pollModel = new Poll();
        $pollOptionModel = new Option();
        $voteModel = new Vote();
        $userModel = new User();
        $getpoll = $pollModel->where('polls.id', $this->r_id)->orderBy('polls.created_at', 'DESC')->join('users', 'users.id', '=', 'polls.user_id')->get();
        // dd($getpoll->toArray());
        $this->comments = Comment::latest()->where('poll_id', $this->r_id)->get();

        $this->polls = array_map(function ($poll)
        use ($pollOptionModel, $voteModel) {
            $poll['options'] = $pollOptionModel->where('poll_id', $poll['id'])->get();
            // dd($poll['options']);
            $poll['votes'] = $voteModel->where('votes.poll_id', $poll['id'])->join('polls', 'polls.id', '=', 'votes.poll_id')->count();
            // $poll['user'] = $voteModel->where('votes.poll_id', $poll['id'])->->get();
            return $poll;
        }, $getpoll->toArray());
        // dd($this->polls);
        $data = [
            'poll' => $this->polls,
            'comments' => $this->comments
        ];
        return view('livewire.poll-single', $data);
    }
    private function resetInputFields()
    {
        $this->staked = '';
    }
    public function store($poll_id, $option_id)
    {
        // dd($poll_id, $option_id);
        $this->validate([
            'staked' => [
                'required',
                // new CheckUserBalance()
            ]
        ]);
        $vote = Vote::create([
            'poll_id' => $poll_id,
            'option_id' => $option_id,
            'user_id' => auth()->id(),
            'staked' => $this->staked
        ]);

        if ($vote) {
            $wallet = new wallet();
            $user_wallet = wallet::where('user_id', auth()->id())->first();
            $newbalance = $user_wallet['amount'] - $this->staked;
            $wallet_data['amount'] = $newbalance;
            $wallet->where('id', $user_wallet['id'])->update($wallet_data);
            $this->resetInputFields();
            session()->flash('message', 'Vote Successfull.');
        }
    }

    public function comment()
    {
        $this->validate([
            'comment' => 'required'
        ]);

        Comment::create([
            'comment' => $this->comment,
            'user_id' => auth()->id(),
            'poll_id' => $this->r_id
        ]);
        session()->flash('sent', 'Commented.');
    }
}
