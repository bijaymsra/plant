<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function store(Request $request)
    {
        // Ensure the user is logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create an event.');
        }

        // Validation
        $request->validate([
            'event_title' => 'required|string|max:255',
            'event_description' => 'required|string',
            'event_type' => 'required|string',
            'expected_participants' => 'required|integer',
            'region' => 'required|string',
            'location_detail' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'tree_types' => 'nullable|array',
            'event_date' => 'required|date',
            'start_time' => 'required',
            'duration' => 'required|integer',
            'registration_deadline' => 'required|date',
            'event_image' => 'nullable|image|max:2048',
        ]);

        // Create Event
        $event = new Event();
        $event->event_title = $request->event_title;
        $event->event_description = $request->event_description;
        $event->event_type = $request->event_type;
        $event->expected_participants = $request->expected_participants;
        $event->region = $request->region;
        $event->location_detail = $request->location_detail;
        $event->latitude = $request->latitude;
        $event->longitude = $request->longitude;
        $event->tree_types = json_encode($request->tree_types); // store as JSON
        $event->event_date = $request->event_date;
        $event->start_time = $request->start_time;
        $event->duration = $request->duration;
        $event->registration_deadline = $request->registration_deadline;

        // Handle file upload
        if ($request->hasFile('event_image')) {
            $filename = time() . '.' . $request->event_image->extension();
            $request->event_image->move(public_path('event_images'), $filename);
            $event->event_image = $filename;
        }

       // Set default status and user ID
      $event->status = 'pending'; // 👈 default value here

        // Set user ID
        $event->user_id = Auth::id(); // Safely getting the user ID after the check

        // Save Event
        $event->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Event created successfully!');
    }


    // view as per id and only 5
    public function index(Request $request)
    {
        $events = Event::where('user_id', Auth::id())->paginate(10);
        
        // // If it's an AJAX request, return just the partial
        if ($request->ajax()) {
            return view('proposer.partials.events-table', compact('events'));
        }

        // // Otherwise load the full page
        return view('proposer.partials.events-table', compact('events'));
    
    }

    // View single eventdetails
    public function show($id)
    {
    $event = Event::findOrFail($id);
    
    if (auth()->user()->role === 'proposer') {
        return view('proposer.partials.event-details', compact('event'));
    } else if(auth()->user()->role === 'admin'){
        return view('admin.partial.event-details', compact('event'));
    }else{
        return view('user.partial.event-details', compact('event'));
    }
    }

    // // filter events
    public function filter($status)
    {
        $query = Event::where('user_id', Auth::id());
    
        if ($status !== 'all') {
            $query->where('status', $status); // make sure status matches exactly
        }
    
        $events = $query->latest()->paginate(10);
    
        // Return the HTML block (partial table view)
        return response()->json([
            'html' => view('proposer.partials.events-table', compact('events'))->render()
        ]);
    }


    // search-events
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Ensure the query is not empty
        if (!$query) {
            return response()->json(['html' => 'No query provided'], 400);
        }
    
        $events = Event::where('user_id', Auth::id())
            ->where('event_title', 'like', '%' . $query . '%')
            ->latest()
            ->paginate(10);
    
        return response()->json([
            'html' => view('proposer.partials.events-table', compact('events'))->render()
        ]);
    }


    public function toggleBookmark(Event $event)
    {
        $user = auth()->user();

        if ($user->bookmarkedEvents->contains($event->id)) {
            $user->bookmarkedEvents()->detach($event->id);
            return response()->json(['status' => 'removed']);
        } else {
            $user->bookmarkedEvents()->attach($event->id);
            return response()->json(['status' => 'bookmarked']);
        }
    }

}