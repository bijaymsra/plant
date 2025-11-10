<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
public function showUsers(Request $request)
{
    $eventFilter = $request->input('event_filter', 'all');
    $userFilter = $request->input('user_filter', 'all');

    // Filter Events
    $eventsQuery = Event::with('proposer')->latest();
    if ($eventFilter !== 'all') {
        $eventsQuery->where('status', $eventFilter);
    }
    $events = $eventsQuery->paginate(5, ['*'], 'events');

    // Filter Users
    $usersQuery = User::latest();

    if ($userFilter !== 'all') {
        if ($userFilter === 'regular') {
            $usersQuery->where('role', 'end-user');
        } elseif (in_array($userFilter, ['admin', 'proposer', 'banned'])) {
            $usersQuery->where('role', $userFilter);
        }
    }

    $users = $usersQuery->paginate(5, ['*'], 'users');



    // added 
     $totalUsers = User::count();
    $pendingEvents = Event::where('status', 'pending')->count();

    return view('admin.admin', compact('events', 'users', 'totalUsers', 'pendingEvents'));
}


public function filterEvents(Request $request)
{
    $status = $request->input('status', 'all');

    $query = Event::with('proposer');

    if ($status !== 'all') {
        $query->where('status', $status);
    }

    $events = $query->paginate(10);

    // If AJAX, return only the table partial
    if ($request->ajax()) {
        return view('admin.partial.events', compact('events'))->render();
    }

    // Default fallback (not usually triggered)
    return redirect()->back();
}


// this is for event status changing logic
public function approveEvent(Event $event)
{
    $event->status = 'approved';
    $event->save();

    return response()->json(['success' => true, 'message' => 'Event approved successfully']);
}

public function rejectEvent(Event $event)
{
    $event->status = 'rejected';
    $event->save();

    return response()->json(['success' => true, 'message' => 'Event rejected']);
}

public function pauseEvent(Event $event)
{
    $event->status = 'pending';
    $event->save();

    return response()->json(['success' => true, 'message' => 'Event status set to pending']);
}

}
