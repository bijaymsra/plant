<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container">
        <div class="auth-container">
            <!-- Left Panel - Branding -->
            <div class="brand-panel">
                <div class="logo-container">
                   <h1 class="logo-b">🌱 EcoAction</h1>
                </div>
                <p class="tagline">Connect, Create, Collaborate</p>
                <div class="features">
                    <div class="feature-item">
                        <i class="fas fa-calendar-check"></i>
                        <span>Organize and discover events</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-users"></i>
                        <span>Connect with like-minded people</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Secure and reliable platform</span>
                    </div>
                </div>
            </div>

            <!-- Right Panel - Auth Forms -->
            <div class="auth-forms-panel">
                <!-- Form Navigation Tabs -->
                <div class="tabs">
                    <button class="tab-btn active" id="login-tab">Login</button>
                    <button class="tab-btn" id="register-tab">Register</button>
                </div>

                <!-- Login Form -->
                <div class="form-container" id="login-form">
                    <h2>Sign In</h2>
                    <p class="form-subtitle">Access your account</p>

                    <form action="{{ route('login.custom') }}" method="POST">
                    @csrf
                        <div class="form-group">
                            <label for="login-email">Email</label>
                            <input type="email" id="login-email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="login-password">Password</label>
                            <div class="password-input">
                                <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                                <i class="fas fa-eye-slash toggle-password"></i>
                            </div>
                        </div>
                        <div class="form-options">
                            <div class="remember-me">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Remember me</label>
                            </div>
                            <a href="#" class="forgot-password">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn-submit">Login</button>
                    </form>
                </div>

                <!-- Registration Form -->
                <div class="form-container hidden" id="register-form">
                    <h2>Create Account</h2>
                    <p class="form-subtitle">Choose your role and register</p>

                    <!-- Role Selection -->
                    <div class="role-selector">
                        <div class="role-option" data-role="end-user">
                            <div class="role-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="role-details">
                                <h3>End User</h3>
                                <p>Discover and attend events</p>
                            </div>
                        </div>
                        <div class="role-option" data-role="proposer">
                            <div class="role-icon">
                                <i class="fas fa-calendar-plus"></i>
                            </div>
                            <div class="role-details">
                                <h3>Proposer</h3>
                                <p>Create and organize events</p>
                            </div>
                        </div>
                        <div class="role-option" data-role="admin">
                            <div class="role-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="role-details">
                                <h3>Admin</h3>
                                <p>Manage platform operations</p>
                            </div>
                        </div>
                    </div>

                    <form action="/register" method="POST" id="register-form-element">
                    @csrf
                        <input type="hidden" id="selected-role" name="role" value="">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="register-first-name">First Name</label>
                                <input type="text" id="register-first-name" name="first_name" placeholder="Enter first name" required>
                            </div>
                            <div class="form-group">
                                <label for="register-last-name">Last Name</label>
                                <input type="text" id="register-last-name" name="last_name" placeholder="Enter last name" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="register-email">Email</label>
                            <input type="email" id="register-email" name="email" placeholder="Enter your email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="register-password">Password</label>
                            <div class="password-input">
                                <input type="password" id="register-password" name="password" placeholder="Create a password" required>
                                <i class="fas fa-eye-slash toggle-password"></i>
                            </div>
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-indicator"></div>
                                </div>
                                <span class="strength-text">Password strength</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="register-confirm-password">Confirm Password</label>
                            <div class="password-input">
                                <input type="password" id="register-confirm-password" name="password_confirmation" placeholder="Confirm your password" required>
                                <i class="fas fa-eye-slash toggle-password"></i>
                            </div>
                        </div>
                        
                        <div class="form-options">
                            <div class="terms-agreement">
                                <input type="checkbox" id="terms" name="terms" required>
                                <label for="terms">I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-submit">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration Success Modal -->
<div class="modal hidden" id="success-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Success 🎉</h2>
        </div>
        <div class="modal-body">
            <p>✅ Registration successful!</p>
            <p>Redirecting to login in <span id="countdown">3</span> seconds...</p>
        </div>
    </div>
</div>


    <script>
        // Basic interactivity for demonstrative purposes
        document.addEventListener('DOMContentLoaded', function() {


            // Role selection
            const roleOptions = document.querySelectorAll('.role-option');
            const selectedRoleInput = document.getElementById('selected-role');

            roleOptions.forEach(option => {
                option.addEventListener('click', function() {
                    roleOptions.forEach(item => item.classList.remove('selected'));
                    this.classList.add('selected');
                    selectedRoleInput.value = this.getAttribute('data-role');
                });
            });
            // Set a default role if none selected (optional)
            if (!selectedRoleInput.value) {
              selectedRoleInput.value = 'end-user';
            }


            // Tab switching
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');

            loginTab.addEventListener('click', function() {
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
            });

            registerTab.addEventListener('click', function() {
                registerTab.classList.add('active');
                loginTab.classList.remove('active');
                registerForm.classList.remove('hidden');
                loginForm.classList.add('hidden');
            });


            // Password visibility toggle
            const togglePasswordButtons = document.querySelectorAll('.toggle-password');
            
            togglePasswordButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const passwordInput = this.previousElementSibling;
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            });

            // this is for registration success message
        @if(session('registration_success'))
        const modal = document.getElementById('success-modal');
        modal.classList.remove('hidden');

        let seconds = 3;
        const countdown = document.getElementById('countdown');
        const interval = setInterval(() => {
            seconds--;
            countdown.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = "{{ url('/login') }}";
            }
        }, 1000);
        @endif



            // Simple password strength indicator
            const passwordInput = document.getElementById('register-password');
            const strengthIndicator = document.querySelector('.strength-indicator');
            const strengthText = document.querySelector('.strength-text');

            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                if (password.length >= 8) strength += 25;
                if (password.match(/[A-Z]/)) strength += 25;
                if (password.match(/[0-9]/)) strength += 25;
                if (password.match(/[^A-Za-z0-9]/)) strength += 25;
                
                strengthIndicator.style.width = strength + '%';
                
                if (strength <= 25) {
                    strengthIndicator.style.backgroundColor = '#ff4d4d';
                    strengthText.textContent = 'Weak password';
                } else if (strength <= 50) {
                    strengthIndicator.style.backgroundColor = '#ffa64d';
                    strengthText.textContent = 'Moderate password';
                } else if (strength <= 75) {
                    strengthIndicator.style.backgroundColor = '#4dbf4d';
                    strengthText.textContent = 'Good password';
                } else {
                    strengthIndicator.style.backgroundColor = '#2eb82e';
                    strengthText.textContent = 'Strong password';
                }
            });
        });
    </script>
</body>
</html>