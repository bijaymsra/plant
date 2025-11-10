<!--  My Upcoming and Past Events -->
<div class="events-list">
@forelse ($upcomingEvents as $event)
    <div class="event-item" data-event-id="{{ $event->id }}">
        <img src="{{ asset('event_images/' . $event->event_image) }}" alt="Cover Image" class="event-thumb">

        <div class="event-item-details">
            <h3>{{ $event->event_title }}</h3>
            <p class="event-date-time">
                <i class="fas fa-calendar-alt"></i>
                {{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }} • 
                {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
            </p>
            <p class="event-location">
                <i class="fas fa-map-marker-alt"></i> {{ $event->location_detail }}
            </p>
        </div>

        <div class="event-item-actions">
            <a href="{{ route('events.show', $event->id) }}" class="details-btn" style="text-decoration: none;">Details</a>
            <button class="cancel-btn">Cancel</button>
        </div>
    </div>
@empty
    <p>No upcoming events found.</p>
@endforelse
</div>

@foreach($pastEvents as $event)
<div class="event-item past">
    <img src="{{ asset('event_images/' . $event->event_image) }}" alt="Cover Image" class="event-thumb">
    
    <div class="event-item-details">
        <h3>{{ $event->event_title }}</h3>
        <p class="event-date-time">
            <i class="fas fa-calendar-alt"></i> 
            {{ \Carbon\Carbon::parse($event->event_date)->format('F j, Y') }} • 
            {{ \Carbon\Carbon::parse($event->event_time)->format('g:i A') }}
        </p>
        <p class="event-location">
            <i class="fas fa-map-marker-alt"></i> 
            {{ $event->location_detail }}
        </p>
    </div>

    <div class="event-item-actions">
        <div class="rating">
            @php
                $rating = $event->rating ?? 4; // Default rating out of 5
            @endphp
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $rating)
                    <i class="fas fa-star"></i>
                @else
                    <i class="far fa-star"></i>
                @endif
            @endfor
        </div>
        <button class="feedback-btn">Add Feedback</button>
    </div>
</div>
@endforeach

<!-- Feedback Form (Hidden initially) -->
<div class="feedback-form" style="display: none;">
<h3>Event Feedback</h3>
<div class="form-group">
    <label>Your Rating</label>
    <div class="star-rating">
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="fas fa-star"></i>
        <i class="far fa-star"></i>
    </div>
</div>
<div class="form-group">
    <label for="feedback-comment">Comments</label>
    <textarea id="feedback-comment" rows="4" placeholder="Share your experience..."></textarea>
</div>
<div class="form-actions">
    <button class="cancel-feedback">Cancel</button>
    <button class="submit-feedback">Submit Feedback</button>
</div>
</div> 
</section>
