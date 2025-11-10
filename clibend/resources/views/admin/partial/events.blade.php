<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Event Name</th>
            <th>Proposer</th>
            <th>Location</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td>{{ $event->event_title }}</td>
                <td>
                    @if($event->proposer)
                        {{ $event->proposer->first_name }} {{ $event->proposer->last_name }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $event->location_detail }}</td>
                <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                <td><span class="status {{ $event->status }}">{{ ucfirst($event->status) }}</span></td>
                <td class="actions">
                    <!-- for view event details -->
                    <a href="{{ route('events.show', $event->id) }}" class="btn-icon"><i class="fas fa-eye"></i></a>
                    @if($event->status === 'pending')

                        <!-- change status from pending to approved -->
                        <button class="btn-icon success approve-btn" data-event-id="{{ $event->id }}">
                            <i class="fas fa-check"></i>
                        </button>

                          <!-- change status form approve to rejected -->  
                          <button class="btn-icon danger reject-btn" data-event-id="{{ $event->id }}">
                                <i class="fas fa-times"></i>
                          </button>

                    @elseif($event->status === 'approved')
                            <!-- change status form approve to pending -->
                            <button class="btn-icon warning pause-btn" data-event-id="{{ $event->id }}">
                                <i class="fas fa-pause"></i>
                            </button>

                          <!-- change status form approve to rejected -->  
                           <button class="btn-icon danger reject-btn" data-event-id="{{ $event->id }}">
                                <i class="fas fa-trash"></i>
                            </button>

                    @elseif($event->status === 'rejected')
                          <!-- change status form rejected to approved -->  
                        <button class="btn-icon success approve-btn" data-event-id="{{ $event->id }}">
                            <i class="fas fa-redo"></i>
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
