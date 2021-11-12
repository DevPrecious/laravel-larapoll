<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Poll;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        // $polls = Poll::all();
        $pollModel = new Poll();
        $pollOptionModel = new Option();
        $getpoll = $pollModel->orderBy('polls.created_at', 'DESC')->get();
        // dd($getpoll->toArray());

        $polls = array_map(function ($poll)
        use ($pollOptionModel) {
            $poll['options'] = $pollOptionModel->where('poll_id', $poll['id'])->get();
            // dd($poll['options']);
            // $poll['votes'] = $voteModel->where('votes.poll_id', $poll['poll_id'])->join('polls', 'polls.poll_id = votes.poll_id')->countAllResults();
            return $poll;
        }, $getpoll->toArray());
        // dd($polls);
        $data = [
            'polls' => $polls
        ];
        return view('dashboard', $data);
    }
}
