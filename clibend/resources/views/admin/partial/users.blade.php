<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Joined Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            @php
                $statusClass = match($user->role) {
                    'admin', 'proposer', 'end-user' => 'active',
                    default => 'pending'
                };

                $statusLabel = match($statusClass) {
                    'active' => 'Active',
                    'pending' => 'Pending',
                    'banned' => 'Banned',
                    default => ucfirst($statusClass)
                };
            @endphp
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td><span class="status {{ $statusClass }}">{{ $statusLabel }}</span></td>
                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('M d, Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

        <!-- pagination -->
<div class="pagination">
    {{-- Previous Page Link --}}
    @if ($users->onFirstPage())
        <button class="btn-page" disabled><i class="fas fa-chevron-left"></i></button>
    @else
        <a href="{{ $users->previousPageUrl() }}#users" class="btn-page"><i class="fas fa-chevron-left"></i></a>
    @endif

    {{-- Page Number Links --}}
    @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
        @if ($page == $users->currentPage())
            <button class="btn-page active">{{ $page }}</button>
        @elseif ($page == 1 || $page == $users->lastPage() || abs($page - $users->currentPage()) <= 1)
            <a href="{{ $url }}#users" class="btn-page">{{ $page }}</a>
        @elseif ($page == $users->currentPage() - 2 || $page == $users->currentPage() + 2)
            <span class="ellipsis">...</span>
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($users->hasMorePages())
        <a href="{{ $users->nextPageUrl() }}#users" class="btn-page"><i class="fas fa-chevron-right"></i></a>
    @else
        <button class="btn-page" disabled><i class="fas fa-chevron-right"></i></button>
    @endif
</div>