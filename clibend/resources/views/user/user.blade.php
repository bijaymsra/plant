<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eco Plantation Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="user.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="logo-container">
                <h2>🌱 EcoAction</h2>
            </div>
            
            <nav class="main-nav">
                <ul>
                    <li class="active">
                        <a href="#browse-events"><i class="fas fa-seedling"></i> Browse Events</a>
                    </li>
                    <li>
                        <a href="#my-events"><i class="fas fa-calendar-check"></i> My Events</a>
                    </li>
                    <li>
                        <a href="#profile"><i class="fas fa-user"></i> Profile</a>

                    </li>
                </ul>
            </nav>
            
            <div class="user-info">
                <div class="user-details">
                <span class="admin-name animate-fade-in">
                    <i class="fas fa-leaf waving-leaf"></i>
                    Hi, {{ Auth::user()->first_name }}
                </span>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Top Navigation Bar -->
            <header class="top-nav">

            <!-- welcome Bar -->
                <div class="welcome-bar">
                    <h3>Welcome</h3>
                </div>

                <div class="top-nav-actions">
                    <button class="notification-btn"><i class="fas fa-bell"></i><span class="badge"></span></button>
                </div>

                <div class="notification-dropdown">
                <ul id="notification-list">
                <!-- Notifications will be dynamically inserted here -->
                <li>No new notifications</li>
                </ul>
                </div>                
            </header>

            <!-- Page Content -->
            <div class="content-wrapper">
                <!-- Browse Plantation Events Page -->
                <section id="browse-events" class="page active">
                    <div class="page-header">
                        <h1>Browse Plantation Events</h1>
                        <p>Find and join tree plantation events happening around you</p>
                    </div>

                <!-- Filters Section -->
                <form method="GET" action="{{ route('user') }}">
                    <div class="filters-section">
                        <div class="filter-group">
                            <label for="location">Location</label>
                            <select id="location" name="location">
                                <option value="">All Locations</option>
                                <option value="north" {{ request('location') == 'north' ? 'selected' : '' }}>North Region</option>
                                <option value="south" {{ request('location') == 'south' ? 'selected' : '' }}>South Region</option>
                                <option value="east" {{ request('location') == 'east' ? 'selected' : '' }}>East Region</option>
                                <option value="west" {{ request('location') == 'west' ? 'selected' : '' }}>West Region</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="tree-type">Tree Type</label>
                            <select id="tree-type" name="tree_type">
                                <option value="">All Types</option>
                                <option value="fruit" {{ request('tree_type') == 'fruit' ? 'selected' : '' }}>Fruit Trees</option>
                                <option value="oak" {{ request('tree_type') == 'oak' ? 'selected' : '' }}>Oak Trees</option>
                                <option value="flowering" {{ request('tree_type') == 'flowering' ? 'selected' : '' }}>Flowering Trees</option>
                                <option value="native" {{ request('tree_type') == 'native' ? 'selected' : '' }}>Native Species</option>
                                <option value="pine" {{ request('tree_type') == 'pine' ? 'selected' : '' }}>Pine Species</option>
                                <option value="maple" {{ request('tree_type') == 'maple' ? 'selected' : '' }}>Maple Species</option>
                            </select>
                        </div>

                        <div class="filter-group date-range">
                            <label>Date Range</label>
                            <div class="date-inputs">
                                <input type="date" id="start-date" name="start_date" value="{{ request('start_date') }}">
                                <span>to</span>
                                <input type="date" id="end-date" name="end_date" value="{{ request('end_date') }}">
                            </div>
                        </div>

                        <button type="submit" class="filter-button">Apply Filters</button>
                    </div>
                </form>


                <!-- events and pagination -->
                @include('user.partial.allEvents', ['events' => $events])
                </section>

                <!-- My Participated Events Page -->
                <section id="my-events" class="page">

                    <div class="page-header">
                        <h1>My Participated Events</h1>
                        <p>Track your contribution to a greener planet</p>
                    </div>
                    
                    <div class="participation-stats">
                        <div class="stat-card">
                            <span class="stat-icon"><i class="fas fa-tree"></i></span>
                            <div class="stat-info">
                                <h3>0</h3>
                                <p>Trees Planted</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <span class="stat-icon"><i class="fas fa-calendar-check"></i></span>
                            <div class="stat-info">
                                <h3>0</h3>
                                <p>Events Joined</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <span class="stat-icon"><i class="fas fa-clock"></i></span>
                            <div class="stat-info">
                                <h3>0h</h3>
                                <p>Volunteer Hours</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="event-tabs">
                        <button class="tab-btn active">Upcoming</button>
                        <button class="tab-btn">Past Events</button>
                    </div>

                    <!-- Upcoming and past events details -->
                    @include('user.partial.upcoming-past-events', [
                        'upcomingEvents' => $upcomingEvents,
                        'pastEvents' => $pastEvents
                    ])



<!-- Profile Page-->
<section id="profile" class="page">
    <div class="page-header">
        <h1>My Profile</h1>
        <p>Manage your account and track your impact</p>
    </div>
    
    <div class="profile-container">
        <div class="profile-sidebar">
            <h2 class="profile-name">{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}</h2>
            <p class="profile-email">{{Auth::user()->email}}</p>
            <div class="profile-stats">
                <div class="stat">
                    <span class="stat-number">0</span>
                    <span class="stat-label">Trees</span>
                </div>
                <div class="stat">
                    <span class="stat-number">0</span>
                    <span class="stat-label">Events</span>
                </div>
                <div class="stat">
                    <span class="stat-number">0</span>
                    <span class="stat-label">Badges</span>
                </div>
            </div>
            <div class="profile-nav">
                <button class="profile-nav-btn active">Personal Info</button>
                <button class="profile-nav-btn">Badges & Streaks</button>
                <button class="profile-nav-btn">Settings</button>
            </div>
        </div>
        
        <div class="profile-content">
            <!-- Personal Info Form -->
            <div class="profile-section active">
                <h3>Personal Information</h3>
                <form class="profile-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first-name">First Name</label>
                            <input type="text" id="first-name" value="John">
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name</label>
                            <input type="text" id="last-name" value="Doe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" value="john.doe@example.com">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" value="(555) 123-4567">
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" value="San Francisco, CA">
                    </div>
                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea id="bio" rows="4">Environmental enthusiast passionate about reforestation and community building.</textarea>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="update-profile-btn">Save Changes</button>
                    </div>
                </form>
            </div>
            
            <!-- Badges & Streaks Section -->
            <div class="profile-section badges-section" style="display: none;">
                <h3>Badges & Achievements</h3>
                <div class="badges-container">
                    <div class="badge-item">
                        <div class="badge-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h4>Green Thumb</h4>
                        <p>Planted your first tree</p>
                    </div>
                    <div class="badge-item">
                        <div class="badge-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Community Builder</h4>
                        <p>Participated in 5 events</p>
                    </div>
                    <div class="badge-item locked">
                        <div class="badge-icon">
                            <i class="fas fa-tree"></i>
                        </div>
                        <h4>Forest Creator</h4>
                        <p>Plant 25 trees to unlock</p>
                    </div>
                </div>
                
                <h3>Activity Streak</h3>
                <div class="streak-container">
                    <div class="streak-stats">
                        <div class="streak-count">
                            <span class="count">0</span>
                            <span class="label">Current Streak</span>
                        </div>
                        <div class="streak-count">
                            <span class="count">0</span>
                            <span class="label">Best Streak</span>
                        </div>
                    </div>
                    <div class="streak-calendar">
                        <div class="calendar-day">M</div>
                        <div class="calendar-day">T</div>
                        <div class="calendar-day">W</div>
                        <div class="calendar-day">T</div>
                        <div class="calendar-day">F</div>
                        <div class="calendar-day">S</div>
                        <div class="calendar-day">S</div>
                    </div>
                </div>
            </div>

        <!-- Settings Section (Hidden initially) -->
        <div class="profile-section settings-section" style="display: none;">
            <h3>Account Settings</h3>
            <!-- Change Password -->
            <div class="settings-group">
                <h4>Change Password</h4>
                <form class="settings-form">
                    <div class="form-group">
                        <label for="current-password">Current Password</label>
                        <input type="password" id="current-password" placeholder="Enter current password">
                    </div>
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" id="new-password" placeholder="Enter new password">
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm New Password</label>
                        <input type="password" id="confirm-password" placeholder="Confirm new password">
                    </div>
                    <div class="form-actions">
                        <!-- <button type="submit" class="update-password-btn">Update Password</button> -->
                        <button type="submit" class="update-profile-btn">Update Password</button>
                    </div>
                </form> 
            </div>

            <!-- Notification Preferences (Optional Extra) -->
            <div class="settings-group">
                <h4>Notifications</h4>
                <div class="form-group">
                    <label>
                        <input type="checkbox" checked>
                        Email me about upcoming events
                    </label>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox">
                        Notify me when I earn a new badge
                    </label>
                </div>
            </div>

            <!-- Logout -->
            <div class="settings-group danger-zone">
                <h4>Danger Zone</h4>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="update-profile-btn" >Logout</button>
                </form>
            </div>
               </div>
               </div>
               </div>
              </section>
            </div>
        </main>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const filtersForm = document.querySelector('.filters-section');
    const eventsContainer = document.getElementById('events-container');

    function fetchFilteredEvents(extraParams = {}) {
        const formData = new FormData();
        formData.append('location', document.getElementById('location').value);
        formData.append('tree_type', document.getElementById('tree-type').value);
        formData.append('start_date', document.getElementById('start-date').value);
        formData.append('end_date', document.getElementById('end-date').value);
        formData.append('search', searchInput.value);

        for (const key in extraParams) {
            formData.append(key, extraParams[key]);
        }

        fetch("{{ route('user') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.text())
        .then(html => {
            eventsContainer.innerHTML = html;
        });
    }

    searchInput.addEventListener('keyup', function () {
        fetchFilteredEvents();
    });

    document.querySelector('.filter-button').addEventListener('click', function () {
        fetchFilteredEvents();
    });

    // Handle pagination click via delegation
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const url = e.target.closest('a').href;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                eventsContainer.innerHTML = html;
                window.history.pushState({}, '', url);
            });
        }
    });
    });
</script>
    
<!-- handle navigation for pages -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".main-nav a");
    const pages = document.querySelectorAll(".page");

    navLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            // Remove active class from all nav items
            navLinks.forEach(l => l.parentElement.classList.remove("active"));
            this.parentElement.classList.add("active");

            const targetId = this.getAttribute("href");

            // Hide all pages
            pages.forEach(p => p.classList.remove("active"));

            // Show the selected one
            const targetPage = document.querySelector(targetId);
            if (targetPage) {
                targetPage.classList.add("active");
            }
        });
    });
});
</script>

<!-- this is for handling upcoming and past events -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll(".tab-btn");
    const allEvents = document.querySelectorAll(".event-item");

    // Add click event to each tab
    tabButtons.forEach((btn, index) => {
        btn.addEventListener("click", () => {
            // Remove active from all buttons
            tabButtons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            // Filter events
            allEvents.forEach(event => {
                if (index === 0) {
                    // Show only upcoming
                    event.style.display = event.classList.contains("past") ? "none" : "flex";
                } else {
                    // Show only past
                    event.style.display = event.classList.contains("past") ? "flex" : "none";
                }
            });
        });
    });

    // ✅ Trigger the default tab (Upcoming) on load
    if (tabButtons.length > 0) {
        tabButtons[0].click();
    }
});
</script>

<!-- feedback form submission -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const feedbackForm = document.querySelector(".feedback-form");
    let activeFeedbackBtn = null;

    // Handle Add Feedback click
    document.querySelectorAll(".feedback-btn").forEach(btn => {
        btn.addEventListener("click", function () {
            const eventItem = btn.closest(".event-item");

            // Move the feedback form below the event
            eventItem.insertAdjacentElement("afterend", feedbackForm);

            feedbackForm.style.display = "block";

            // Hide the current feedback button
            btn.style.display = "none";
            activeFeedbackBtn = btn;

            // Reset star rating
            const stars = feedbackForm.querySelectorAll(".star-rating i");
            stars.forEach((star, index) => {
                star.addEventListener("click", () => {
                    stars.forEach((s, i) => {
                        if (i <= index) {
                            s.classList.add("fas");
                            s.classList.remove("far");
                        } else {
                            s.classList.remove("fas");
                            s.classList.add("far");
                        }
                    });
                    feedbackForm.dataset.rating = index + 1;
                });
            });

            // Clear previous comment
            feedbackForm.querySelector("#feedback-comment").value = "";
        });
    });

    // Cancel button
    document.querySelector(".cancel-feedback").addEventListener("click", () => {
        feedbackForm.style.display = "none";

        // Restore the last clicked feedback button
        if (activeFeedbackBtn) {
            activeFeedbackBtn.style.display = "inline-block";
            activeFeedbackBtn = null;
        }
    });

    // Submit feedback
    document.querySelector(".submit-feedback").addEventListener("click", () => {
        const rating = feedbackForm.dataset.rating || 0;
        const comment = feedbackForm.querySelector("#feedback-comment").value;

        console.log("Feedback submitted!");
        console.log("Rating:", rating);
        console.log("Comment:", comment);

        // Optional reset
        feedbackForm.style.display = "none";
        if (activeFeedbackBtn) {
            activeFeedbackBtn.style.display = "inline-block";
            activeFeedbackBtn = null;
        }

        feedbackForm.querySelector("#feedback-comment").value = "";
    });
    });
</script>

<!-- Notification  -->
<script>
    const notificationBtn = document.querySelector('.notification-btn');
    const dropdown = document.querySelector('.notification-dropdown');
    const badge = document.querySelector('.notification-btn .badge');
    const notificationList = document.getElementById('notification-list');

    const notifications = [
        "Your event proposal was approved.",
        "New participant registered for your event.",
        "Event reminder: Tree Plantation Drive tomorrow!",
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

<!-- settings -->
<script>
    const settingsBtn = document.querySelector('.settings-btn');
    const settingsDropdown = document.querySelector('.settings-dropdown');

    settingsBtn.addEventListener('click', () => {
        settingsDropdown.style.display = settingsDropdown.style.display === "block" ? "none" : "block";
    });

    // Hide when clicking outside
    document.addEventListener('click', (e) => {
        if (!settingsBtn.contains(e.target) && !settingsDropdown.contains(e.target)) {
            settingsDropdown.style.display = 'none';
        }
    });
</script>

<!-- for profile , badges and settings -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const navButtons = document.querySelectorAll('.profile-nav-btn');
        const sections = document.querySelectorAll('.profile-section');

        navButtons.forEach((btn, index) => {
            btn.addEventListener('click', function () {
                // Remove active class from all buttons
                navButtons.forEach(b => b.classList.remove('active'));

                // Hide all sections
                sections.forEach(section => {
                    section.classList.remove('active');
                    section.style.display = 'none';
                });

                // Activate clicked button
                this.classList.add('active');

                // Show corresponding section
                sections[index].classList.add('active');
                sections[index].style.display = 'block';
            });
        });
    });
</script>


<!-- to hide the event displayed at upcoming events -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const cancelButtons = document.querySelectorAll('.cancel-btn');

        cancelButtons.forEach(button => {
            button.addEventListener('click', function () {
                const eventItem = this.closest('.event-item');
                if (eventItem) {
                    eventItem.style.display = 'none';
                }
            });
        });
    });
</script>

<!-- for toggle participants in events -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.join-btn').forEach(button => {
            button.addEventListener('click', function () {
                const eventId = this.getAttribute('data-event-id');
                const url = `/events/${eventId}/toggle-participation`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => {
                    if (!response.ok) return response.json().then(data => { throw data; });
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'joined') {
                        location.reload(); // Reload page to reflect DB change
                        this.textContent = 'Remove Participation';
                        this.setAttribute('data-joined', 'true');
                    } else if (data.status === 'left') {
                        location.reload(); // Reload page to reflect DB change
                        this.textContent = 'Join Event';
                        this.setAttribute('data-joined', 'false');
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    const msg = this.nextElementSibling;
                    msg.textContent = err.status === 'full' ? 'Event is full' : 'Something went wrong';
                });
            });
        });
    });
</script>



<!-- for bookmark section -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.bookmark-btn').forEach(button => {
        button.addEventListener('click', function () {
            const eventId = this.getAttribute('data-event-id');
            const icon = this.querySelector('i');

            fetch(`/events/${eventId}/toggle-bookmark`, {
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
                if (data.status === 'bookmarked') {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
            })
            .catch(err => {
                console.error('Bookmark Error:', err);
                alert('Could not toggle bookmark');
            });
        });
    });
});
</script>

</body>
</html>