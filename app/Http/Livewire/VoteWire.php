<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Poll;
use App\Models\Option;
use App\Models\User;
use App\Models\Vote;
use App\Models\Wallet;
use App\Rules\CheckUserBalance;

use function GuzzleHttp\Promise\all;

class VoteWire extends Component
{
    public $polls;
    public $poll_id, $option_id, $user_id, $staked;


    public function render()
    {
        $this->polls = Poll::withCount('options')->get();
        // foreach ($this->polls as $pl) {
        //     foreach ($pl->options as $xl) {
        //         dd($xl);
        //     }
        // }
        // // $polls = Poll::all();
        // $pollModel = new Poll();
        // $pollOptionModel = new Option();
        // $voteModel = new Vote();
        // $userModel = new User();
        // $getpoll = $pollModel->orderBy('polls.created_at', 'DESC')->join('users', 'users.id', '=', 'polls.user_id')->get();

        // $this->polls = array_map(function ($poll)
        // use ($pollOptionModel, $voteModel) {
        //     // $poll['options'] = $pollOptionModel->where('poll_id', $poll['id'])->get();
        //     $poll['options'] = Option::where('poll_id', $poll['id'])->get();
        //     dd($poll['options']);
        //     $poll['votes'] = $voteModel->where('votes.poll_id', $poll['id'])->join('polls', 'polls.id', '=', 'votes.poll_id')->count();
        //     // $poll['user'] = $voteModel->where('votes.poll_id', $poll['id'])->->get();
        //     return $poll;
        // }, $getpoll->toArray());
        // // dd($polls);
        // $data = [
        //     'polls' => $this->polls
        // ];
        // return view('livewire.vote-wire', $data);
        return view('livewire.vote-wire');
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
                new CheckUserBalance()
            ]
        ]);
        $vote = Vote::create([
            'poll_id' => $poll_id,
            'option_id' => $option_id,
            'user_id' => auth()->id(),
            'staked' => $this->staked
        ]);

        if ($vote) {
            $wallet = new Wallet();
            $user_wallet = Wallet::where('user_id', auth()->id())->first();
            $newbalance = $user_wallet['amount'] - $this->staked;
            $wallet_data['amount'] = $newbalance;
            $wallet->where('id', $user_wallet['id'])->update($wallet_data);
            $this->resetInputFields();
            session()->flash('message', 'Vote Successfull.');
        }
    }
}
