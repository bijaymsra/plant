<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class ProposerController extends Controller
{
    public function showProposer()
    {
        $events = Event::where('user_id', auth()->id())->get();
        return view('proposer.proposer', compact('events'));
    }
    
}
