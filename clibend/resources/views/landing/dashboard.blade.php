<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EcoAction - Making Our Planet Greener</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
  <!-- Navigation -->
  <nav class="container">
    <div class="logo">
      🌱 EcoAction
    </div>
    <ul class="nav-links">
      <li><a href="#home">Home</a></li>
      <li><a href="#event-detail">Events</a></li>
      <li><a href="#about">About</a></li>
      <li><a href="#contact">Contact</a></li>

    </ul>
  </nav>

  <!-- Hero Section -->
  <section class="hero container" id="home">
    <div class="hero-content">
      <h1>Together We Can Make Our Planet Greener</h1>
      <p>Join our movement to plant trees, organize clean-ups, and protect natural habitats. Every small action counts towards a sustainable future.</p>
      <div class="hero-buttons">
        <a href="{{ route('login') }}" class="btn btn-primary">Join Us</a>
        <a href="#event-detail" class="btn btn-secondary">View Events</a>
      </div>
    </div> 

  </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="container">
            <div class="stats-container">
                <div class="stat-item">
                    <i class="fas fa-tree"></i>
                    <div class="stat-number">75,432</div>
                    <div class="stat-label">Trees Planted</div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-users"></i>
                    <div class="stat-number">12,897</div>
                    <div class="stat-label">Active Members</div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-calendar-alt"></i>
                    <div class="stat-number">143</div>
                    <div class="stat-label">Upcoming Events</div>
                </div>
            </div>
        </div>
    </section>

  <!-- Event Details Page -->
  <section class="event-details" id="event-detail">
    <div class="event-header">
      <div class="container">
        <h1 class="event-title">Spring Reforestation: City Park Revival</h1>
        <div class="event-meta">Saturday, April 26, 2025 • 9:00 AM - 2:00 PM</div>
      </div>
    </div>
    
    <div class="container">
      <div class="event-content">
        <div class="event-main">
          <div class="event-section">
            <h3>About This Event</h3>
            <div class="event-description">
              <p>Join us for our biggest reforestation event of the Spring season! We're revitalizing the eastern section of City Park by planting native trees that will provide shade, clean air, and habitat for local wildlife for generations to come.</p>
              <p>No experience necessary - our team leaders will guide you through the planting process and teach you about the importance of each species we're planting. This is a family-friendly event, and children are welcome when accompanied by an adult.</p>
              <p>We'll provide all necessary tools, gloves, and refreshments. Just bring your enthusiasm, weather-appropriate clothing, and a water bottle!</p>
            </div>
          </div>
          
          <div class="event-section">
            <h3>Tree Types</h3>
            <div class="tree-types">
              <div class="tree-type">
                <div class="tree-icon">🌳</div>
                <div class="tree-info">
                  <h4>Red Maple (Acer rubrum)</h4>
                  <p>Fast-growing shade tree with vibrant fall colors. Adaptable to various soil conditions.</p>
                </div>
              </div>
              <div class="tree-type">
                <div class="tree-icon">🌳</div>
                <div class="tree-info">
                  <h4>Eastern Redbud (Cercis canadensis)</h4>
                  <p>Small ornamental tree with striking pink-purple flowers in early spring.</p>
                </div>
              </div>
              <div class="tree-type">
                <div class="tree-icon">🌳</div>
                <div class="tree-info">
                  <h4>White Oak (Quercus alba)</h4>
                  <p>Long-lived, majestic tree that provides excellent wildlife habitat and shade.</p>
                </div>
              </div>
              <div class="tree-type">
                <div class="tree-icon">🌳</div>
                <div class="tree-info">
                  <h4>River Birch (Betula nigra)</h4>
                  <p>Moisture-loving tree with distinctive peeling bark and resistance to pests.</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="event-section">
            <h3>Location</h3>
            <div class="event-map">
            <iframe
              src="https://www.google.com/maps?q=City+Park+Lakeside+Pavilion&output=embed"
              style="width:100%; height:100%; object-fit:cover; border:0;"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
            </div>
            <p>Eastern Section of City Park, near the Lakeside Pavilion. Look for the EcoAction banners and check-in tent.</p>
           </div>
        </div>
        
        <div class="event-sidebar">
          <h3>Event Details</h3>
          <ul class="event-details-list">
            <li>
              <div class="detail-icon">📅</div>
              <div>
                <strong>Date:</strong><br>
                Saturday, April 26, 2025
              </div>
            </li>
            <li>
              <div class="detail-icon">🕒</div>
              <div>
                <strong>Time:</strong><br>
                9:00 AM - 2:00 PM
              </div>
            </li>
            <li>
              <div class="detail-icon">📍</div>
              <div>
                <strong>Location:</strong><br>
                City Park, Eastern Section<br>
                123 Park Avenue, Eco City
              </div>
            </li>
            <li>
              <div class="detail-icon">👥</div>
              <div>
                <strong>Spots Available:</strong><br>
                42 of 75 remaining
              </div>
            </li>
            <li>
              <div class="detail-icon">🌱</div>
              <div>
                <strong>Trees to Plant:</strong><br>
                150 native saplings
              </div>
            </li>
          </ul>
          
          <div class="organizer">
            <div class="organizer-avatar"></div>
            <div class="organizer-info">
              <h4>Event Organizer</h4>
              <p>David Wilson, Parks Coordinator</p>
              <a href="mailto:david@ecoaction.org" class="organizer-contact">david@ecoaction.org</a>
            </div>
          </div>
          
          <div class="join-button-container">
            <a href="{{ route('login') }}" class="btn btn-primary btn-large">Join This Event</a>
            <p style="margin-top: 10px; font-size: 14px; color: var(--gray);">Login required to join events</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonials">
    <div class="container">
      <h2 class="section-title">Success Stories</h2>
      <div class="testimonials-container">
        <div class="testimonial-card">
          <div class="testimonial-content">
            "I joined EcoAction last year and have participated in 12 tree planting events since. The community is amazing and the impact we're making is visible in our neighborhood!"
          </div>
          <div class="testimonial-author">
            <div class="author-avatar"></div>
            <div class="author-info">
              <h4>Sarah Johnson</h4>
              <p>Volunteer since 2024</p>
            </div>
          </div>
        </div>
        <div class="testimonial-card">
          <div class="testimonial-content">
            "Our local park was transformed thanks to EcoAction volunteers. We planted over 50 native trees and created a beautiful space for our community to enjoy."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar"></div>
            <div class="author-info">
              <h4>Michael Torres</h4>
              <p>Event Organizer</p>
            </div>
          </div>
        </div>
        <div class="testimonial-card">
          <div class="testimonial-content">
            "As a teacher, I bring my students to EcoAction events to learn about sustainability. It's been an incredible hands-on learning experience for them."
          </div>
          <div class="testimonial-author">
            <div class="author-avatar"></div>
            <div class="author-info">
              <h4>Emily Chen</h4>
              <p>Science Teacher</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About/Contact Section -->
  <section class="about-contact" id="about">
    <div class="container about-contact-container">
      <div class="about-section">
        <h2>Our Mission</h2>
        <div class="about-text">
          <p>At EcoAction, we believe in the power of community-driven environmental initiatives. Our mission is to restore and protect natural ecosystems through collective action.</p>
          <p>We organize tree planting events, clean-ups, and educational workshops to empower individuals to make a positive impact on our planet.</p>
          <p>Founded in 2020, we've grown from a small group of passionate volunteers to a nationwide movement with thousands of participants.</p>
        </div>
        <a href="{{ route('login') }}" class="btn btn-primary">Learn More About Us</a>
      </div>
      
      <div class="contact-section" id="contact">
        <h2>Get In Touch</h2>
        <form class="contact-form" id="contactForm">
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" class="form-control" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Send Message</button>
        </form>

        <!-- Success Message -->
        <div id="successMessage" style="display:none; margin-top: 1rem; color: green; font-weight: 500;">
          ✅ Message saved successfully!
        </div>

        
        <div class="contact-info">
          <p><i>📧</i> bm.bijaymishra@gmail.com</p>
          <p><i>📱</i> +91 8810862625</p>
          <p><i>📍</i> Punjab, India</p>
        </div>
      </div>
    </div>
  </section>


  <!-- Footer -->
  <footer>
    <div class="container footer-container">
      <div class="footer-section">
        <h3>EcoAction</h3>
        <p>Making our planet greener, one tree at a time.</p>
      </div>
      <div class="footer-section">
        <h3>Quick Links</h3>
        <ul class="footer-links">
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#event-detail">Events</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Resources</h3>
        <ul class="footer-links">
          <li><a href="#">Blog</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Volunteer Guide</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h3>Newsletter</h3>
        <p>Subscribe to our newsletter for updates on events and initiatives.</p>
      <form id="subscribeForm">
        <input type="email" class="form-control" placeholder="Your email" required style="margin-bottom: 10px;">
        <button type="submit" class="btn btn-primary">Subscribe</button>
      </form>

      <!-- Success Message -->
      <div id="subscribeSuccess" style="display:none; margin-top: 1rem; color: green; font-weight: 500;">
        ✅ Subscription successful!
      </div>
      </div>
    </div>
    <div class="container copyright">
      <p>&copy; 2025 EcoAction. All rights reserved.</p>
    </div>
  </footer>


  <script>
  document.getElementById("contactForm").addEventListener("submit", function (e) {
    e.preventDefault(); // prevent actual submission (for now)

    // Optionally: Reset the form
    this.reset();

    // Show the success message
    const success = document.getElementById("successMessage");
    success.style.display = "block";

    // Optionally hide after few seconds
    setTimeout(() => {
      success.style.display = "none";
    }, 3000); // hides after 3 seconds
  });
</script>

<script>
  document.getElementById("subscribeForm").addEventListener("submit", function (e) {
    e.preventDefault(); // prevent real submission

    this.reset(); // clear form fields

    const successMsg = document.getElementById("subscribeSuccess");
    successMsg.style.display = "block";

    // Auto-hide after 3 seconds
    setTimeout(() => {
      successMsg.style.display = "none";
    }, 3000);
  });
</script>


</body>
</html>