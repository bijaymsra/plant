<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposer Dashboard | EcoPlant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- for map -->
     <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

     <!-- Leaflet JS -->
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="{{ asset('css/proposer.css') }}">
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
                        <a href="#my-events"><i class="fas fa-calendar-alt"></i> My Events</a>
                    </li>
                    <li>
                        <a href="#create-event"><i class="fas fa-plus-circle"></i> Create Event</a>
                    </li>
                    <li>
                        <a href="#event-reports"><i class="fas fa-chart-line"></i> Event Reports</a>
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
            <div class="search-bar">
                <input type="text" id="search-input" placeholder="Search events...">
                <button id="search-btn"><i class="fas fa-search"></i></button>
            </div>

            <div class="top-nav-actions">
                <button class="notification-btn"><i class="fas fa-bell"></i><span class="badge"></span></button>
                <button class="settings-btn"><i class="fas fa-cog"></i></button>
            </div>

            <div class="notification-dropdown">
               <ul id="notification-list">
            <!-- Notifications will be dynamically inserted here -->
               <li>No new notifications</li>
               </ul>
            </div>

            <div class="settings-dropdown">
                 <ul>
                 <li>
                  <form method="POST" action="{{ route('logout') }}">
                     @csrf
                  <button type="submit" style="all: unset; cursor: pointer;">Logout</button>
                    </form>
                 </li>
                 </ul>
            </div>

        </header>


            <!-- Page Content -->
            <div class="content-wrapper">
                <!-- My Events Page -->
                <section id="my-events" class="page active">
                    <div class="page-header">
                        <h1>My Events</h1>
                        <p>Manage your plantation events</p>
                        <button class="new-event-btn"><i class="fas fa-plus"></i> Create New Event</button>
                    </div>

            <!-- Filter Buttons -->
            <div class="status-filter">
                <button class="filter-btn active" data-filter="all">All Events</button>
                <button class="filter-btn" data-filter="pending">Pending Approval</button>
                <button class="filter-btn" data-filter="approved">Approved</button>
                <button class="filter-btn" data-filter="denied">Denied</button>
                <button class="filter-btn" data-filter="completed">Completed</button>
            </div>

            <!-- Table Container -->
            <div id="events-container">
                @include('proposer.partials.events-table')
            </div>                
            </section>

                <!-- Create Event Page -->
                <section id="create-event" class="page">
                    <div class="page-header">
                        <h1>Create New Event</h1>
                        <p>Propose a new plantation event</p>
                    </div>
                    
                    <div class="form-container">
                        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="form-section">
                                <h3><i class="fas fa-info-circle"></i> Basic Information</h3>
                                <div class="form-group">
                                    <label for="event-title">Event Title</label>
                                    <input type="text" name="event_title" id="event-title" placeholder="Enter a descriptive title for your event">
                                </div>
                                
                                <div class="form-group">
                                    <label for="event-description">Event Description</label>
                                    <textarea name="event_description" id="event-description" rows="5" placeholder="Describe the purpose and details of your plantation event"></textarea>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="event-type">Event Type</label>
                                        <select name="event_type" id="event-type">
                                            <option value="">Select event type</option>
                                            <option value="public">Public Event</option>
                                            <option value="corporate">Corporate Event</option>
                                            <option value="community">Community Event</option>
                                            <option value="educational">Educational Event</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="expected-participants">Expected Participants</label>
                                        <input type="number" name="expected_participants" id="expected-participants" min="1" placeholder="Number of participants">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h3><i class="fas fa-map-marker-alt"></i> Location</h3>
                                <div class="form-group">
                                    <label for="location-region">Region</label>
                                    <select name="region" id="location-region">
                                        <option value="">Select region</option>
                                        <option value="north">North District</option>
                                        <option value="south">South District</option>
                                        <option value="east">East District</option>
                                        <option value="west">West District</option>
                                        <option value="central">Central District</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="location-detail">Location Details</label>
                                    <input type="text" name="location_detail" id="location-detail" placeholder="Specific location details">
                                </div>

                            <!-- Map HTML Structure -->
                            <div class="form-group">
                                <label>Map Location</label>
                                <div class="map-container">
                                    <div id="map" class="map-placeholder" style="display: none;"></div>
                                    <div class="map-placeholder" id="map-placeholder">
                                        <div class="map-overlay">
                                            <button type="button" class="select-location-btn" id="activate-map-btn">
                                                <i class="fas fa-map-pin"></i> Set Location on Map
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" id="latitude" name="latitude" value="">
                                    <input type="hidden" id="longitude" name="longitude" value="">
                                </div>
                                <div class="location-display" style="display: none;">
                                    <span id="selected-location">No location selected</span>
                                    <button type="button" class="change-location-btn">
                                        <i class="fas fa-sync-alt"></i> Remove Location
                                    </button>
                                </div>
                            </div>

                            </div>
                            
                            <div class="form-section">
                                <h3><i class="fas fa-tree"></i> Tree Types</h3>
                                <div class="form-group">
                                    <label>Select Tree Types for Planting</label>
                                    <div class="tree-selection">
                                        <div class="tree-option">
                                            <input type="checkbox" name="tree_types[]" id="tree-oak" value="oak" class="tree-checkbox">
                                            <label for="tree-oak" class="tree-label">
                                                <img src="{{ asset('images/oak.webp') }}" alt="Oak Tree">
                                                <span>Oak Trees</span>
                                            </label>
                                        </div>
                                        <div class="tree-option">
                                            <input type="checkbox" name="tree_types[]" id="tree-pine" value="pine" class="tree-checkbox">
                                            <label for="tree-pine" class="tree-label">
                                                <img src="{{ asset('images/pine.jpg') }}" alt="Pine Tree">
                                                <span>Pine Trees</span>
                                            </label>
                                        </div>
                                        <div class="tree-option">
                                            <input type="checkbox" name="tree_types[]" id="tree-maple" value="maple" class="tree-checkbox">
                                            <label for="tree-maple" class="tree-label">
                                                <img src="{{ asset('images/maple.jpg') }}"  alt="Maple Tree">
                                                <span>Maple Trees</span>
                                            </label>
                                        </div>
                                        <div class="tree-option">
                                            <input type="checkbox" name="tree_types[]" id="tree-fruit" value="fruit" class="tree-checkbox">
                                            <label for="tree-fruit" class="tree-label">
                                                <img src="{{ asset('images/fruit.jpg') }}" alt="Fruit Tree">
                                                <span>Fruit Trees</span>
                                            </label>
                                        </div>
                                        <div class="tree-option">
                                            <input type="checkbox" name="tree_types[]" id="tree-flowering" value="flowering" class="tree-checkbox">
                                            <label for="tree-flowering" class="tree-label">
                                                <img src="{{ asset('images/flowering.jpg') }}" alt="Flowering Tree">
                                                <span>Flowering Trees</span>
                                            </label>
                                        </div>
                                        <div class="tree-option">
                                            <input type="checkbox" name="tree_types[]" id="tree-native" value="native" class="tree-checkbox">
                                            <label for="tree-native" class="tree-label">
                                                <img src="{{ asset('images/native.jpg') }}" alt="Native Tree">
                                                <span>Native Species</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-section">
                                <h3><i class="fas fa-calendar-alt"></i> Date & Time</h3>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="event-date">Event Date</label>
                                        <input type="date" name="event_date" id="event-date">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="event-time">Start Time</label>
                                        <input type="time" name="start_time" id="event-time">
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="event-duration">Duration (hours)</label>
                                        <input type="number" name="duration" id="event-duration" min="1" max="12" placeholder="Event duration">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="registration-deadline">Registration Deadline</label>
                                        <input type="date" name="registration_deadline" id="registration-deadline">
                                    </div>
                                </div>
                            </div>
                            

                            <!-- Image upload HTML Structure -->
                            <div class="form-section">
                                <h3><i class="fas fa-image"></i> Event Image</h3>
                                <div class="form-group">
                                    <label>Upload Event Cover Image</label>
                                    <div class="image-upload-container">
                                        <div class="image-upload-area" id="upload-area">
                                            <div class="default-state">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <p>Drag and drop an image or click to browse</p>
                                                <button type="button" class="browse-btn" id="browse-button">Browse Files</button>
                                            </div>
                                            <div class="selected-state" style="display: none;">
                                                <i class="fas fa-check-circle"></i>
                                                <p id="file-name">No file selected</p>
                                                <button type="button" class="change-btn" id="change-button">Change Image</button>
                                            </div>
                                            <input type="file" id="event-image" name="event_image" accept="image/*" hidden>
                                        </div>
                                    </div>
                                    <p class="help-text">Recommended size: 1200x600 pixels, JPG or PNG</p>
                                </div>
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="save-draft-btn">Save as Draft</button>
                                <button type="submit" class="submit-event-btn">Submit for Approval</button>
                            </div>
                        </form>
                    </div>
                </section>

                <!-- Event Reports Page -->
                <section id="event-reports" class="page">
                    <div class="page-header">
                        <h1>Event Reports</h1>
                        <p>Upload photos and update event results</p>
                    </div>
                    
                    <!-- Events for Reporting -->
                    <div class="events-report-list">
                        <div class="report-event-card">
                            <div class="report-event-header">
                                <img src="/api/placeholder/80/80" alt="Event Thumbnail" class="report-event-img">
                                <div class="report-event-details">
                                    <h3>Urban Forest Initiative</h3>
                                    <p class="report-event-date"><i class="fas fa-calendar-alt"></i> May 28, 2025</p>
                                    <p class="report-event-location"><i class="fas fa-map-marker-alt"></i> Central Park, Downtown</p>
                                </div>
                                <div class="report-event-status">
                                    <span class="status-badge completed">Completed</span>
                                </div>
                            </div>
                            
                            <div class="report-stats">
                                <div class="report-stat-item">
                                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                                    <div class="stat-details">
                                        <h4>Participants</h4>
                                        <div class="stat-value">
                                            <input type="number" value="18" min="0"> / 30
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="report-stat-item">
                                    <div class="stat-icon"><i class="fas fa-tree"></i></div>
                                    <div class="stat-details">
                                        <h4>Trees Planted</h4>
                                        <div class="stat-value">
                                            <input type="number" value="45" min="0">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="report-stat-item">
                                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                                    <div class="stat-details">
                                        <h4>Total Hours</h4>
                                        <div class="stat-value">
                                            <input type="number" value="4" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="report-photos">
                                <h4>Event Photos</h4>
                                <div class="photo-gallery">
                                    <div class="photo-item">
                                        <img src="/api/placeholder/150/150" alt="Event Photo">
                                        <button class="delete-photo"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="photo-item">
                                        <img src="/api/placeholder/150/150" alt="Event Photo">
                                        <button class="delete-photo"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="photo-item add-photo">
                                        <i class="fas fa-plus"></i>
                                        <span>Add Photo</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="report-notes">
                                <h4>Additional Notes</h4>
                                <textarea rows="4" placeholder="Add any additional notes or comments about the event"></textarea>
                            </div>
                            
                            <div class="report-actions">
                                <button class="save-report-btn">Save Report</button>
                                <button class="publish-report-btn">Publish Results</button>
                            </div>
                        </div>
                        
                        <div class="report-event-card">
                            <div class="report-event-header">
                                <img src="/api/placeholder/80/80" alt="Event Thumbnail" class="report-event-img">
                                <div class="report-event-details">
                                    <h3>School Garden Project</h3>
                                    <p class="report-event-date"><i class="fas fa-calendar-alt"></i> April 12, 2025</p>
                                    <p class="report-event-location"><i class="fas fa-map-marker-alt"></i> Lincoln High School</p>
                                </div>
                                <div class="report-event-status">
                                    <span class="status-badge completed">Completed</span>
                                </div>
                            </div>
                            
                            <div class="report-stats">
                                <div class="report-stat-item">
                                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                                    <div class="stat-details">
                                        <h4>Participants</h4>
                                        <div class="stat-value">
                                            <input type="number" value="22" min="0"> / 20
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="report-stat-item">
                                    <div class="stat-icon"><i class="fas fa-tree"></i></div>
                                    <div class="stat-details">
                                        <h4>Trees Planted</h4>
                                        <div class="stat-value">
                                            <input type="number" value="15" min="0">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="report-stat-item">
                                    <div class="stat-icon"><i class="fas fa-clock"></i></div>
                                    <div class="stat-details">
                                        <h4>Total Hours</h4>
                                        <div class="stat-value">
                                            <input type="number" value="3" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="report-photos">
                                <h4>Event Photos</h4>
                                <div class="photo-gallery">
                                    <div class="photo-item">
                                        <img src="/api/placeholder/150/150" alt="Event Photo">
                                        <button class="delete-photo"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="photo-item">
                                        <img src="/api/placeholder/150/150" alt="Event Photo">
                                        <button class="delete-photo"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="photo-item">
                                        <img src="/api/placeholder/150/150" alt="Event Photo">
                                        <button class="delete-photo"><i class="fas fa-times"></i></button>
                                    </div>
                                    <div class="photo-item add-photo">
                                        <i class="fas fa-plus"></i>
                                        <span>Add Photo</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="report-notes">
                                <h4>Additional Notes</h4>
                                <textarea rows="4">Students were highly engaged in the planting process. The school has committed to maintaining the garden as part of their environmental curriculum.</textarea>
                            </div>
                            
                            <div class="report-actions">
                                <button class="save-report-btn">Save Report</button>
                                <button class="publish-report-btn">Publish Results</button>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".main-nav a");
    const createBtn = document.querySelector(".new-event-btn");
    const pages = document.querySelectorAll(".page");

        createBtn.addEventListener("click", () => {
            pages.forEach(page => {
                page.style.display = page.id === "create-event" ? "block" : "none";
            });

            // Optional: highlight "Create Event" nav link
            document.querySelectorAll(".main-nav li").forEach(li => li.classList.remove("active"));
            const navLink = document.querySelector('.main-nav a[href="#create-event"]');
            if (navLink) navLink.parentElement.classList.add("active");
        });


    navLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();

            // Remove active class from all nav items
            document.querySelectorAll(".main-nav li").forEach(li => li.classList.remove("active"));

            // Add active class to clicked nav item
            this.parentElement.classList.add("active");

            // Hide all pages
            pages.forEach(page => page.style.display = "none");

            // Show the clicked page
            const target = this.getAttribute("href");
            document.querySelector(target).style.display = "block";
        });
    });

    // Initial state: show only the first page
    pages.forEach(page => page.style.display = "none");
    document.querySelector("#my-events").style.display = "block";
});
</script>

<!-- JavaScript -->
<script>
// JavaScript
document.addEventListener('DOMContentLoaded', function () {
    const activateMapBtn = document.getElementById('activate-map-btn');
    const mapPlaceholder = document.getElementById('map-placeholder');
    const mapElement = document.getElementById('map');
    const locationDisplay = document.getElementById('selected-location');
    const locationDisplayContainer = document.querySelector('.location-display');
    const changeLocationBtn = document.querySelector('.change-location-btn');
    
    let map, marker;
    
    // Setup click event to activate the map
    activateMapBtn.addEventListener('click', function() {
        // Hide placeholder and show the map
        mapPlaceholder.style.display = 'none';
        mapElement.style.display = 'block';
        
        // Initialize map if not already done
        if (!map) {
            initMap();
        } else {
            // Force a map resize if already initialized
            map.invalidateSize();
        }
    });
    
    // Change location button click event
    if (changeLocationBtn) {
        changeLocationBtn.addEventListener('click', function() {
            // Reset the marker and location display
            if (marker && map) {
                map.removeLayer(marker);
                marker = null;
            }
            
            // Reset the location display and hidden fields
            locationDisplay.textContent = "No location selected";
            document.getElementById('latitude').value = '';
            document.getElementById('longitude').value = '';
            
            // Show map if it's hidden
            if (mapElement.style.display === 'none') {
                mapElement.style.display = 'block';
                mapPlaceholder.style.display = 'none';
            }
            
            // Force a map resize
            if (map) {
                map.invalidateSize();
            }
        });
    }
    
    function initMap() {
        // Default map center (e.g., center of country)
        var defaultLat = 20.5937; // India
        var defaultLng = 78.9629;

        // Initialize the map
        map = L.map('map').setView([defaultLat, defaultLng], 5);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Handle click to place or move the marker
        map.on('click', function (e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);

            // If marker exists, just move it
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
                marker.bindPopup("Selected Location").openPopup();
            }

            // Update hidden form fields
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            
            // Update the display text
            locationDisplay.textContent = `Selected: Lat ${lat}, Lng ${lng}`;
            locationDisplayContainer.style.display = 'flex';
            
            // Get location name using reverse geocoding (optional)
            reverseGeocode(lat, lng);
        });
        
        // Force a map resize after it's visible
        setTimeout(() => {
            map.invalidateSize();
        }, 100);
    }
    
    // Optional: Reverse geocoding function to get location name
    function reverseGeocode(lat, lng) {
        // You can implement this using a service like Nominatim
        // Example using fetch and Nominatim:
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`)
            .then(response => response.json())
            .then(data => {
                if (data && data.display_name) {
                    locationDisplay.textContent = `Selected: ${data.display_name}`;
                }
            })
            .catch(error => {
                console.error('Error getting location name:', error);
            });
    }
});
</script>


<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadArea = document.getElementById('upload-area');
        const fileInput = document.getElementById('event-image');
        const browseButton = document.getElementById('browse-button');
        const changeButton = document.getElementById('change-button');
        const fileName = document.getElementById('file-name');
        const defaultState = document.querySelector('.default-state');
        const selectedState = document.querySelector('.selected-state');
        
        // Browse button click handler
        browseButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            fileInput.click();
        });
        
        // Change button click handler
        changeButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            fileInput.click();
        });
        
        // Upload area click handler
        uploadArea.addEventListener('click', function(e) {
            if (e.target !== browseButton && e.target !== changeButton) {
                fileInput.click();
            }
        });
        
        // File input change handler
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                // Show selected file name
                fileName.textContent = fileInput.files[0].name;
                defaultState.style.display = 'none';
                selectedState.style.display = 'block';
            }
        });
        
        // Drag and drop handlers
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        // Highlight drop area when item is dragged over
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, function() {
                uploadArea.classList.add('drag-over');
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, function() {
                uploadArea.classList.remove('drag-over');
            }, false);
        });
        
        // Handle dropped files
        uploadArea.addEventListener('drop', function(e) {
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                
                // Trigger change event manually
                const changeEvent = new Event('change');
                fileInput.dispatchEvent(changeEvent);
            }
        }, false);
    });
</script>

<!-- filter events -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-btn');

    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');

            fetch(`/events/filter/${filter}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('events-container').innerHTML = data.html;
                })
                .catch(err => {
                    console.error('Error fetching filtered events:', err);
                });
        });
    });
});
</script>

<!-- search filter -->
<<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('.search-bar input');
const eventsContainer = document.getElementById('events-container');
let typingTimer;

searchInput.addEventListener('input', function () {
    clearTimeout(typingTimer);
    const query = this.value.trim();

    typingTimer = setTimeout(() => {
        if (query.length === 0) {
            // If search box is cleared, fetch all events
            fetchAllEvents();
        } else {
            fetchSearchResults(query);
        }
    }, 300);
});

function fetchSearchResults(query) {
    fetch(`/events/search?query=${encodeURIComponent(query)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Search failed');
            }
            return response.json();
        })
        .then(data => {
            eventsContainer.innerHTML = data.html;
        })
        .catch(error => {
            console.error('Search error:', error);
        });
}

function fetchAllEvents() {
    fetch('/events', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to fetch all events');
        }
        return response.text(); // Expecting HTML
    })
    .then(html => {
        eventsContainer.innerHTML = html;
    })
    .catch(error => {
        console.error('Error loading all events:', error);
    });
}
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


</body>
</html>