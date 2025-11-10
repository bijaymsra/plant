<!-- Events Grid -->
<div class="events-grid">
    @foreach ($events as $event)
        @php
            // Check if the currently authenticated user has joined this specific event
            $isJoined = auth()->check() && auth()->user()->joinedEvents->contains($event->id);
            // Check if the user has bookmarked this event
            $isBookmarked = auth()->check() && auth()->user()->bookmarkedEvents->contains($event->id);
        @endphp

        <div class="event-card">
            <!-- Event Image and Date -->
            <div class="event-image">
                <img src="{{ asset('event_images/' . $event->event_image) }}" alt="Cover Image">
                <span class="event-date">{{ \Carbon\Carbon::parse($event->event_date)->format('M d') }}</span>
            </div>

            <!-- Event Details -->
            <div class="event-details">
                <h3>{{ $event->event_title }}</h3>
                <p class="location"><i class="fas fa-map-marker-alt"></i> {{ $event->location_detail }}</p>
                <p class="tree-type"><i class="fas fa-leaf"></i> {{ implode(', ', json_decode($event->tree_types)) }}</p>
                <p class="participants"><i class="fas fa-users"></i> {{ $event->current_participants }}/{{ $event->expected_participants }} Participants</p>

                <!-- Action Buttons -->
                <div class="event-actions">
                    <!-- Join / Remove Participation Button -->
                    <button 
                        class="join-btn" 
                        data-event-id="{{ $event->id }}" 
                        data-joined="{{ $isJoined ? 'true' : 'false' }}">
                        {{ $isJoined ? 'Remove Participation' : 'Join Event' }}
                    </button>

                    <!-- Placeholder for any error/status messages -->
                    <span class="status-message"></span>

                    <!-- Bookmark Button -->
                    <button class="bookmark-btn" data-event-id="{{ $event->id }}">
                        <i class="{{ $isBookmarked ? 'fas' : 'far' }} fa-bookmark"></i>
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Pagination -->
@if ($events->lastPage() > 1)
    <div class="pagination">
        {{-- Previous Page --}}
        <button 
            class="prev-page" 
            @if ($events->onFirstPage()) disabled @endif
            onclick="window.location='{{ $events->previousPageUrl() }}'">
            <i class="fas fa-chevron-left"></i>
        </button>

        <div class="page-numbers">
            @for ($i = 1; $i <= $events->lastPage(); $i++)
                @if ($i == $events->currentPage())
                    <button class="active">{{ $i }}</button>
                @else
                    <button onclick="window.location='{{ $events->url($i) }}'">{{ $i }}</button>
                @endif
            @endfor
        </div>

        {{-- Next Page --}}
        <button 
            class="next-page" 
            @if (!$events->hasMorePages()) disabled @endif
            onclick="window.location='{{ $events->nextPageUrl() }}'">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
@endif
