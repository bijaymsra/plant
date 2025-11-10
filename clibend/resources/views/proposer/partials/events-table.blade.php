<div class="events-table-wrapper">
    <table class="events-table">
        <thead>
            <tr>
                <th>Event Title</th>
                <th>Date</th>
                <th>Location</th>
                <th>Status</th>
                <th>Participants</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td class="event-title">
                    <div class="title-with-img">
                        <img src="{{ asset('event_images/' . $event->event_image) }}" alt="Cover Image">
                        <div>
                            <h4>{{ $event->event_title }}</h4>
                            <span class="event-type">{{ ucfirst($event->event_type) }}</span>
                        </div>
                    </div>
                </td>
                <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                <td>{{ $event->location_detail }}</td>
                <td>
                    <span class="status-badge {{ strtolower($event->status) }}">
                        {{ ucfirst($event->status) }}
                    </span>
                </td>
                <td>{{ $event->current_participants }}/{{ $event->expected_participants }}</td>
                <td class="actions-cell"> 
                    <a href="{{ route('events.show', $event->id) }}" class="action-btn view"><i class="fas fa-eye"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


