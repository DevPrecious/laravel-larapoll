<?php

namespace App\Http\Livewire;

use App\Models\Option;
use App\Models\Poll;
use App\Rules\CheckUserBalance;
use Livewire\Component;

class PollLivewire extends Component
{

    public $option, $title, $amount, $datetostop;
    public $updateMode = false;
    public $inputs = [];
    public $i = 1;


    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
    }

    public function render()
    {
        return view('livewire.poll-livewire');
    }

    private function resetInputFields()
    {
        $this->title = '';
        $this->option = '';
        $this->amount = '';
        $this->datetostop = '';
    }


    public function store()
    {
        $this->validate(
            [
                'option.0' => 'required',
                'option.*' => 'required',
                'title' => 'required',
                'amount' => [
                    'required',
                    // new CheckUserBalance()
                ],
            ],
            [
                'option.0.required' => 'Option field is required',
                'option.*.required' => 'Option field is required',
                'title.required' => 'Title field is required',
                'amount.required' => 'Amount field is required',
            ]
        );

        $poll = new Poll();
        $poll->title = $this->title;
        $poll->end_at = $this->datetostop;
        $poll->stake = $this->amount;
        $poll->user_id = auth()->id();
        $poll->save();

        // $poll = Poll::create([
        //     'title' => $this->title,
        //     'end_at' => $this->datetostop,
        //     'stake' => $this->amount,
        //     'user_id' => auth()->id()
        // ]);

        $pollID = $poll->id;

        foreach ($this->option as $key => $value) {
            Option::create([
                'poll_id' => $pollID,
                'option' => $this->option[$key]
            ]);
        }

        $this->inputs = [];

        $this->resetInputFields();

        session()->flash('message', 'Poll Created Successfully.');
    }
}
