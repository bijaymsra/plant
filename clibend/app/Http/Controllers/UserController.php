<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class UserController extends Controller
{
public function showUser(Request $request)
{
    // Start query and filter only approved events
    $query = Event::where('status', 'approved');

    // Filter by location
    if ($request->filled('location')) {
        $query->where('region', 'like', '%' . $request->location . '%');
    }

    // Filter by tree type (assumes stored as JSON or comma string)
    if ($request->filled('tree_type')) {
        $query->where('tree_types', 'like', '%' . $request->tree_type . '%');
    }

    // Filter by start date
    if ($request->filled('start_date')) {
        $query->whereDate('event_date', '>=', $request->start_date);
    }

    // Ensure upcoming events if needed (optional, depending on your logic)
    if ($request->filled('start_date')) {
        $query->whereDate('event_date', '>=', max($request->start_date, now()));
    }

    // Get filtered approved events, paginated
    $events = $query->orderBy('event_date')->paginate(6)->appends($request->query());

    // Upcoming approved events only
    $upcomingEvents = Event::where('status', 'approved')
        ->whereDate('event_date', '>=', now())
        ->orderBy('event_date')
        ->get();

    // Past approved events only
    $pastEvents = Event::where('status', 'approved')
        ->whereDate('event_date', '<', now())
        ->orderBy('event_date', 'desc')
        ->get();

    return view('user.user', compact('events', 'upcomingEvents', 'pastEvents'));
}


public function toggleParticipation(Request $request, $eventId)
{
    $user = Auth::user();
    $event = Event::findOrFail($eventId);

    if ($user->joinedEvents->contains($eventId)) {
        // Remove participation
        $user->joinedEvents()->detach($eventId);
        $event->decrement('current_participants');

        return response()->json(['status' => 'left']);
    } else {
        // Check if slots are available
        if ($event->current_participants < $event->expected_participants) {
            $user->joinedEvents()->attach($eventId);
            $event->increment('current_participants');

            return response()->json(['status' => 'joined']);
        } else {
            return response()->json(['status' => 'full'], 403);
        }
    }
}

}
