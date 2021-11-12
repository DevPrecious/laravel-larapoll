<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PollController extends Controller
{
    public function index()
    {
        return view('poll.create');
    }
}
