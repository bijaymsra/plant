<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | EcoPlant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo">
                <h2>🌱 EcoAction</h2>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="active">
                        <a href="#dashboard"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="#users"><i class="fas fa-users"></i> User Management</a>
                    </li>
                    <li>
                        <a href="#events"><i class="fas fa-calendar-check"></i> Event Approval</a>
                    </li>
                    <li>
                        <a href="#tree-types"><i class="fas fa-tree"></i> Tree Types</a>
                    </li>
                    <li>
                        <a href="#settings"><i class="fas fa-cog"></i> Site Settings</a>
                    </li>
                </ul>
            </nav>
            <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Top Header -->

            <header class="top-header">
                <div class="header-left">
                </div>
                <div class="header-right">

                <div class="admin-profile">

                <span class="admin-name animate-fade-in">
                    <i class="fas fa-leaf waving-leaf"></i>
                    Hey, {{ Auth::user()->first_name }}
                </span>

                    </div>
                </div>

                <div class="notifications">
                    <button class="notification-btn"><i class="fas fa-bell"></i><span class="badge"></span></button>
                </div>

                <div class="notification-dropdown">
                <ul id="notification-list">
                <!-- Notifications will be dynamically inserted here -->
                <li>No new notifications</li>
                </ul>
                </div>
            </header>

            <!-- Dashboard Overview Section -->
             <section id="dashboard" class="dashboard-section active">
                <h1>Dashboard Overview</h1>
                <div class="overview-cards">
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-users"></i></div>
                        <div class="card-info">
                            <h3>Total Users</h3>
                            <p class="card-value">{{ $totalUsers }}</p>
                            <p class="card-trend positive">
                                +{{ number_format($totalUsers / 100, 2) }}% this month
                            </p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-calendar-check"></i></div>
                        <div class="card-info">
                            <h3>Pending Events</h3>
                            <p class="card-value">{{ $pendingEvents }}</p>
                            <p class="card-trend neutral">Same as yesterday</p>
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-tree"></i></div>
                        <div class="card-info">
                            <h3>Tree Types</h3>
                            <p class="card-value">100</p>
                            <p class="card-trend positive">+10 this week</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-icon"><i class="fas fa-seedling"></i></div>
                        <div class="card-info">
                            <h3>Trees Planted</h3>
                            <p class="card-value">300</p>
                            <p class="card-trend positive">+100 this week</p>
                        </div>
                    </div>
                </div>

        <!--  visual Activity chart dashboard  -->
            <div class="container">
            <div class="tabs">
                <div class="chart-tab active" data-chart="activity">Recent Activity</div>
                <div class="chart-tab" data-chart="distribution">Distribution</div>
                <div class="chart-tab" data-chart="comparison">Comparison</div>
            </div>

            <div class="chart-wrapper active" id="activity-chart">
                <canvas id="activityLineChart"></canvas>
            </div>
            <div class="chart-wrapper" id="distribution-chart">
                <canvas id="distributionPieChart"></canvas>
            </div>
            <div class="chart-wrapper" id="comparison-chart">
                <canvas id="comparisonBarChart"></canvas>
            </div>
            </div>
            </section>

            <!-- User Management Section -->  
                <section id="users" class="dashboard-section" style="display: none;">
                <h1>User Management</h1>

                <div class="section-header">

            <div class="filter-options">
                <select id="user-filter" name="filter">
                <option value="all" {{ request('user_filter', 'all') == 'all' ? 'selected' : '' }}>All Users</option>
                <option value="regular" {{ request('user_filter') == 'regular' ? 'selected' : '' }}>Regular Users</option>
                <option value="proposer" {{ request('user_filter') == 'proposer' ? 'selected' : '' }}>Proposers</option>
                <option value="admin" {{ request('user_filter') == 'admin' ? 'selected' : '' }}>Admins</option>
                <option value="banned" {{ request('user_filter') == 'banned' ? 'selected' : '' }}>Banned Users</option>
            </select>

                <button class="btn" id="user-filter-btn">Filter</button>
            </div>
            </div>

                <div class="data-table">
                @include('admin.partial.users') <!-- added separate partial -->
                </div>
            </section>


                <!-- Event Approval Section -->
            <section id="events" class="dashboard-section">
                <h1>Event Approval</h1>
                <div class="section-header">
                    <div class="filter-options">
                        <form id="event-filter-form">
                            <select name="status" id="filter-status">
                                <option value="all">All Events</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <button type="submit" class="btn">Filter</button>
                        </form>
                    </div>
                </div>

                <div class="data-table" id="event-table-container">
                    @include('admin.partial.events') <!-- added separate partial -->
                </div>
            </section>


            <!-- Tree Types Section -->
            <section id="tree-types" class="dashboard-section">
                <h1>Tree Type Management</h1>
                <div class="section-header">
                    <div class="filter-options">
                        <!-- <input type="text" placeholder="Search tree types..."> -->
                        <!-- <button class="btn">Search</button> -->
                    </div>
                    <div class="action-buttons">
                        <!-- <button class="btn primary"><i class="fas fa-plus"></i> Add New Tree Type</button> -->
                    </div>
                </div>
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Scientific Name</th>
                                <th>Climate</th>
                                <th>Growth Rate</th>
                                <!-- <th>Actions</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>3001</td>
                                <td><img src="{{ asset('images/oak.webp') }}" alt="Oak Tree" class="tree-thumbnail"></td>
                                <td>Oak</td>
                                <td>Quercus</td>
                                <td>Temperate</td>
                                <td>Slow</td>
                                <!-- <td class="actions">
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon danger"><i class="fas fa-trash"></i></button>
                                    <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                                </td> -->
                            </tr>
                            <tr>
                                <td>3002</td>
                                <td><img src="{{ asset('images/pine.jpg') }}" alt="Pine Tree" class="tree-thumbnail"></td>
                                <td>Pine</td>
                                <td>Pinus</td>
                                <td>Various</td>
                                <td>Medium</td>
                                <!-- <td class="actions">
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon danger"><i class="fas fa-trash"></i></button>
                                    <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                                </td> -->
                            </tr>
                            <tr>
                                <td>3003</td>
                                <td><img src="{{ asset('images/maple.jpg') }}" alt="Maple Tree" class="tree-thumbnail"></td>
                                <td>Maple</td>
                                <td>Acer</td>
                                <td>Temperate</td>
                                <td>Medium</td>
                                <!-- <td class="actions">
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon danger"><i class="fas fa-trash"></i></button>
                                    <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                                </td> -->
                            </tr>
                            <tr>
                                <td>3004</td>
                                <td><img src="{{ asset('images/fruit.jpg') }}" alt="Palm Tree" class="tree-thumbnail"></td>
                                <td>Palm</td>
                                <td>Arecaceae</td>
                                <td>Tropical</td>
                                <td>Fast</td>
                                <!-- <td class="actions">
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon danger"><i class="fas fa-trash"></i></button>
                                    <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                                </td> -->
                            </tr>
                            <tr>
                                <td>3005</td>
                                <td><img src="{{ asset('images/native.jpg') }}" alt="Birch Tree" class="tree-thumbnail"></td>
                                <td>Birch</td>
                                <td>Betula</td>
                                <td>Cold, Temperate</td>
                                <td>Fast</td>
                                <!-- <td class="actions">
                                    <button class="btn-icon"><i class="fas fa-edit"></i></button>
                                    <button class="btn-icon danger"><i class="fas fa-trash"></i></button>
                                    <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                                </td> -->
                            </tr>
                        </tbody>
                    </table>
                    <!-- <div class="pagination">
                        <button class="btn-page"><i class="fas fa-chevron-left"></i></button>
                        <button class="btn-page active">1</button>
                        <button class="btn-page">2</button>
                        <button class="btn-page">3</button>
                        <button class="btn-page">4</button>
                        <button class="btn-page"><i class="fas fa-chevron-right"></i></button>
                    </div> -->
                </div>
            </section>


            <!-- Site Settings Section -->
            <section id="settings" class="dashboard-section">
                <h1>Site Settings</h1>
                <div class="settings-container">

                    <div class="settings-content">
                        <div id="general-settings" class="settings-panel active">
                            <form class="settings-form">
                                <div class="form-group">
                                    <label for="site-name">Site Name</label>
                                    <input type="text" id="site-name" value="EcoPlant">
                                </div>
                                <div class="form-group">
                                    <label for="site-tagline">Tagline</label>
                                    <input type="text" id="site-tagline" value="Plant Trees, Save Earth">
                                </div>
                                <div class="form-group">
                                    <label for="site-logo">Site Logo</label>
                                    <div class="logo-upload">
                                        <!-- <img src="/api/placeholder/100/100" alt="Site Logo"> -->
                                        <input type="file" id="site-logo">
                                        <button class="btn">Upload New Logo</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="favicon">Favicon</label>
                                    <div class="favicon-upload">
                                        <!-- <img src="/api/placeholder/32/32" alt="Favicon"> -->
                                        <input type="file" id="favicon">
                                        <button class="btn">Upload New Favicon</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="timezone">Timezone</label>
                                    <select id="timezone">
                                        <option value="utc">UTC</option>
                                        <option value="est" selected>Eastern Standard Time</option>
                                        <option value="cst">Central Standard Time</option>
                                        <option value="mst">Mountain Standard Time</option>
                                        <option value="pst">Pacific Standard Time</option>
                                    </select>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn primary">Save Changes</button>
                                    <button type="reset" class="btn secondary">Reset</button>
                                </div>
                            </form>
                        </div>
                        

                </div>
            </section>
        </main>
    </div> 


<!-- for event sections -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const sections = document.querySelectorAll(".dashboard-section");
    const defaultSection = "dashboard"; // Set default section to be shown

    // Function to show/hide sections based on the URL hash
    function showSectionFromHash() {
        const hash = window.location.hash || `#${defaultSection}`; // Fallback to dashboard if no hash

        sections.forEach(section => {
            // Always hide User Management section when it's not selected
            if (section.id === "users" || section.id === "events" || section.id === "settings" || section.id === "tree-types") {
                section.style.display = (hash === `#${section.id}`) ? "block" : "none";
            } else {
                section.style.display = (hash === `#${section.id}`) ? "block" : "none";
            }
        });
    }

    // Initial check to display the correct section
    showSectionFromHash();

    // When clicking on menu links, update hash and show corresponding section
    document.querySelectorAll("a[href^='#']").forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault(); // Prevent the default behavior

            const targetHash = this.getAttribute("href");
            window.location.hash = targetHash; // Change the hash
            showSectionFromHash(); // Show the corresponding section
        });
    });

    // React to manual hash change (when user directly modifies the hash in the URL)
    window.addEventListener("hashchange", showSectionFromHash);
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('event-filter-form');
    const tableContainer = document.getElementById('event-table-container');

    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const status = document.getElementById('filter-status').value;

        fetch(`/admin/filter-events?status=${status}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            tableContainer.innerHTML = html;
        })
        .catch(err => {
            console.error('Failed to load filtered events:', err);
        });
    });
});
</script>

<!-- for user section -->
<script>
    // Filter Users
    document.getElementById('user-filter-btn').addEventListener('click', function () {
        const userFilter = document.getElementById('user-filter').value;
        const url = new URL(window.location.href);

        // Remove all params first to avoid stacking
        url.searchParams.delete('user_filter');
        url.searchParams.set('user_filter', userFilter);

        // Keep existing event filter if available
        const eventFilter = document.getElementById('event-filter');
        if (eventFilter) {
            url.searchParams.set('event_filter', eventFilter.value);
        }

        // Navigate to updated URL with anchor
        window.location.href = url.pathname + '?' + url.searchParams.toString() + '#users';
    });

    // Filter Events (if you haven't added this already)
    const eventFilterBtn = document.getElementById('event-filter-btn');
    if (eventFilterBtn) {
        eventFilterBtn.addEventListener('click', function () {
            const eventFilter = document.getElementById('event-filter').value;
            const url = new URL(window.location.href);

            // Clean user filter if available
            const userFilter = document.getElementById('user-filter');
            if (userFilter) {
                url.searchParams.set('user_filter', userFilter.value);
            }

            url.searchParams.delete('event_filter');
            url.searchParams.set('event_filter', eventFilter);

            window.location.href = url.pathname + '?' + url.searchParams.toString() + '#events';
        });
    }
</script>

<!-- changing status from pending to approved -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.approve-btn').forEach(button => {
            button.addEventListener('click', function () {
                const eventId = this.getAttribute('data-event-id');
                const url = `/admin/events/${eventId}/approve`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload to reflect updated status
                        location.reload();
                    } else {
                        alert(data.message || 'Something went wrong');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Server error');
                });
            });
        });
    });
</script>


<!-- changing status from approved to pending -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.pause-btn').forEach(button => {
            button.addEventListener('click', function () {
                const eventId = this.getAttribute('data-event-id');
                const url = `/admin/events/${eventId}/pause`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload to reflect updated status
                        location.reload();
                    } else {
                        alert(data.message || 'Something went wrong');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Server error');
                });
            });
        });
    });
</script>

<!-- changing status from approved to rejected -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.reject-btn').forEach(button => {
            button.addEventListener('click', function () {
                const eventId = this.getAttribute('data-event-id');
                const url = `/admin/events/${eventId}/reject`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload to reflect updated status
                        location.reload();
                    } else {
                        alert(data.message || 'Something went wrong');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Server error');
                });
            });
        });
    });
</script>



<!--  visual Activity chart dashboard  -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chartTabs = document.querySelectorAll('.chart-tab');
    const chartWrappers = document.querySelectorAll('.chart-wrapper');

    chartTabs.forEach(tab => {
        tab.addEventListener('click', function () {
            chartTabs.forEach(t => t.classList.remove('active'));
            chartWrappers.forEach(w => w.classList.remove('active'));

            this.classList.add('active');
            const chartId = this.getAttribute('data-chart') + '-chart';
            document.getElementById(chartId).classList.add('active');
        });
    });

    initCharts();
});

function initCharts() {
    const dates = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    const activityData = {
        users: [12, 19, 15, 25, 22, 30, 25],
        events: [5, 8, 3, 10, 12, 15, 8],
        trees: [2, 5, 3, 4, 8, 10, 4],
        planted: [35, 45, 30, 60, 75, 90, 65]
    };

    const treeTypes = {
        labels: ['Oak', 'Pine', 'Maple', 'Birch', 'Redwood', 'Other'],
        data: [30, 25, 20, 15, 5, 5]
    };

    const weeklyComparison = {
        labels: ['Users', 'Events', 'Tree Types', 'Trees Planted'],
        current: [148, 61, 36, 400],
        previous: [120, 50, 28, 350]
    };

    createActivityChart(dates, activityData);
    createDistributionChart(treeTypes);
    createComparisonChart(weeklyComparison);
}

function createActivityChart(dates, data) {
    const ctx = document.getElementById('activityLineChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: dates,
            datasets: [
                {
                    label: 'Users',
                    data: data.users,
                    borderColor: '#2196f3',
                    backgroundColor: 'rgba(33, 150, 243, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Events',
                    data: data.events,
                    borderColor: '#9c27b0',
                    backgroundColor: 'rgba(156, 39, 176, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Tree Types',
                    data: data.trees,
                    borderColor: '#ff9800',
                    backgroundColor: 'rgba(255, 152, 0, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Trees Planted',
                    data: data.planted,
                    borderColor: '#2e7d32',
                    backgroundColor: 'rgba(46, 125, 50, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 6
                    }
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            interaction: {
                intersect: false,
                mode: 'nearest'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

function createDistributionChart(data) {
    const ctx = document.getElementById('distributionPieChart').getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: data.labels,
            datasets: [{
                data: data.data,
                backgroundColor: [
                    'rgba(46, 125, 50, 0.7)',
                    'rgba(33, 150, 243, 0.7)',
                    'rgba(255, 152, 0, 0.7)',
                    'rgba(156, 39, 176, 0.7)',
                    'rgba(244, 67, 54, 0.7)',
                    'rgba(158, 158, 158, 0.7)'
                ],
                borderWidth: 1,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 12
                    }
                },
                title: {
                    display: true,
                    text: 'Tree Types Distribution',
                    font: {
                        size: 14
                    }
                }
            },
            cutout: '60%'
        }
    });
}

function createComparisonChart(data) {
    const ctx = document.getElementById('comparisonBarChart').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [
                {
                    label: 'Current Week',
                    data: data.current,
                    backgroundColor: 'rgba(46, 125, 50, 0.7)',
                    borderColor: 'rgba(46, 125, 50, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Previous Week',
                    data: data.previous,
                    backgroundColor: 'rgba(156, 39, 176, 0.7)',
                    borderColor: 'rgba(156, 39, 176, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.raw;
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}
</script>


<!-- Notification  -->
<script>
    const notificationBtn = document.querySelector('.notification-btn');
    const dropdown = document.querySelector('.notification-dropdown');
    const badge = document.querySelector('.notification-btn .badge');
    const notificationList = document.getElementById('notification-list');

    const notifications = [
        "hey, Welcome to EcoAction.",
        "New participant are waiting for your appoval.",
        "Reminder: Events distributors are waiting.",
    ];

    // Update badge and list
    function loadNotifications() {
        if (notifications.length > 0) {
            badge.textContent = notifications.length;
            notificationList.innerHTML = "";
            notifications.forEach(note => {
                const li = document.createElement('li');
                li.textContent = note;
                notificationList.appendChild(li);
            });
        } else {
            badge.textContent = 0;
            notificationList.innerHTML = "<li>No new notifications</li>";
        }
    }

    notificationBtn.addEventListener('click', () => {
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    });

    // Optional: Hide dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!notificationBtn.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    // Initialize
    loadNotifications();
</script>


</body>
</html>