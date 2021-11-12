<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Poll;
use App\Models\Option;
use App\Models\Vote;
use App\Models\wallet;
use App\Rules\CheckUserBalance;

class VoteWire extends Component
{
    public $polls;
    public $poll_id, $option_id, $user_id, $staked;

    public function render()
    {
        // $polls = Poll::all();
        $pollModel = new Poll();
        $pollOptionModel = new Option();
        $voteModel = new Vote();
        $getpoll = $pollModel->orderBy('polls.created_at', 'DESC')->get();
        // dd($getpoll->toArray());

        $this->polls = array_map(function ($poll)
        use ($pollOptionModel, $voteModel) {
            $poll['options'] = $pollOptionModel->where('poll_id', $poll['id'])->get();
            // dd($poll['options']);
            $poll['votes'] = $voteModel->where('votes.poll_id', $poll['id'])->join('polls', 'polls.id', '=', 'votes.poll_id')->count();
            return $poll;
        }, $getpoll->toArray());
        // dd($polls);
        $data = [
            'polls' => $this->polls
        ];
        return view('livewire.vote-wire', $data);
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
}
