<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meetup - Find Your Community</title>
    
    <!-- Link to CSS files -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <a href="{{ route('index') }}" class="logo">meetup</a>
            <ul class="header-nav">
                <li><a href="#home">Home</a></li>
                <li><a href="#groups">Groups</a></li>
                <li><a href="#events">Events</a></li>
                <li><a href="#category">Categories</a></li>
                <li><a href="#how-it-works">How It Works</a></li>
            </ul>
            <div class="header-buttons">
            </div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Join your people</h1>
            <p>Find and meet local groups interested in the things you care about</p>
            <div class="hero-search">
                <input type="text" placeholder="Search for a topic, group, or event">
                <button>Search</button>
            </div>
        </div>
    </section>
    
    <!-- Main Content -->
    <div class="container">
    <!-- Featured Groups Section -->
        <section class="section" id="groups">
            <div class="section-header">
                <h2 class="section-title">Featured Groups</h2>
                <p class="section-subtitle">Meet people interested in what you love</p>
            </div>
            <div class="grid">
                @forelse($featuredGroups as $group)
                <div class="card">
                    <div class="card-image" style="background-size: cover; background-position: center; background-image: url('{{ $group->photo_url }}');">
                        @if(!$group->group_photo)
                        {{ substr($group->group_name, 0, 1) }}
                        @endif
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $group->group_name }}</h3>
                        <p class="card-subtitle">{{ $group->category ?? 'General Group' }}</p>
                        <p class="card-meta">📍 {{ $group->city }}, {{ $group->country }}</p>
                        <p class="card-members">{{ $group->member_count }} members • ⭐ {{ number_format($group->average_rating, 1) }}</p>
                    </div>
                </div>
                @empty
                <p>No groups available yet.</p>
                @endforelse
            </div>
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('groups') }}" class="btn-primary">View All Groups</a>
            </div>
        </section>
        
        <!-- Upcoming Events Section -->
        <section class="section" id="events">
            <div class="section-header">
                <h2 class="section-title">Upcoming Events</h2>
                <p class="section-subtitle">Don't miss out on what's happening near you</p>
            </div>
            <div class="grid" id="eventsGrid">
                @forelse($upcomingEvents as $event)
                <a href="{{ route('event.detail', ['id' => $event->id_event]) }}" style="text-decoration: none; color: inherit;">
                    <div class="event-card" data-location="{{ $event->venue_name }}" data-country="{{ $event->venue_country }}" style="background-image: url('{{ $event->photo_url }}'); background-size: cover; background-position: center;">
                        <div class="event-date">
                            <div class="event-date-day">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                            <div class="event-date-month">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">{{ $event->event_title }}</h3>
                            <p class="event-group">{{ $event->group->group_name ?? 'Event' }}</p>
                            <p class="event-location">📍 {{ $event->venue_name }}</p>
                            <p class="event-attendees">{{ $event->total_rsvps }} going</p>
                        </div>
                    </div>
                </a>
                @empty
                <p>No upcoming events at the moment.</p>
                @endforelse
            </div>
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('events') }}" class="btn-primary">View All Events</a>
            </div>
        </section>
        
        <!-- Browse Categories Section -->
        <section class="section" id="category">
            <div class="section-header">
                <h2 class="section-title">Explore by Category</h2>
                <p class="section-subtitle">Find your community based on interests</p>
            </div>
            <div class="grid-2">
                <div class="category-item">
                    <div class="category-icon">💻</div>
                    <p class="category-name">Technology</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">🎨</div>
                    <p class="category-name">Arts & Design</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">⚽</div>
                    <p class="category-name">Sports & Fitness</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">🍔</div>
                    <p class="category-name">Food & Drink</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">📚</div>
                    <p class="category-name">Learning</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">🎬</div>
                    <p class="category-name">Entertainment</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">💼</div>
                    <p class="category-name">Business</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">❤️</div>
                    <p class="category-name">Wellness</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">🌍</div>
                    <p class="category-name">Travel & Culture</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">🚗</div>
                    <p class="category-name">Hobbies</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">👨‍👩‍👧‍👦</div>
                    <p class="category-name">Families</p>
                </div>
                <div class="category-item">
                    <div class="category-icon">🌟</div>
                    <p class="category-name">More Groups</p>
                </div>
            </div>
        </section>
        
        <!-- How It Works Section -->
        <section class="section" id="how-it-works">
            <div class="section-header">
                <h2 class="section-title">How It Works</h2>
                <p class="section-subtitle">Get started in three simple steps</p>
            </div>
            <div class="grid">
                <div class="card">
                    <div class="card-image">1️⃣</div>
                    <div class="card-content">
                        <h3 class="card-title">Join a Group</h3>
                        <p>Browse and join groups based on your interests. Connect with people who share your passions and hobbies.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">2️⃣</div>
                    <div class="card-content">
                        <h3 class="card-title">Find Events</h3>
                        <p>Discover upcoming events hosted by your groups. RSVP to events and meet new people in your community.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">3️⃣</div>
                    <div class="card-content">
                        <h3 class="card-title">Have Fun</h3>
                        <p>Attend events, network with others, and build meaningful connections. Create lasting friendships.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- CTA Section -->
        <section class="cta-section">
            <h2 class="cta-title">Ready to find your community?</h2>
            <p class="cta-subtitle">Join thousands of people discovering new interests and making meaningful connections</p>
            <a href="#" class="btn btn-primary">Sign Up Today</a>
        </section>
    </div>
    
    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-column">
                    <h4>MEETUP</h4>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Terms & Privacy</a></li>
                        <li><a href="#">Contact Us</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>GROUPS</h4>
                    <ul>
                        <li><a href="#">Create a Group</a></li>
                        <li><a href="#">How to Organize</a></li>
                        <li><a href="#">Event Ideas</a></li>
                        <li><a href="#">Community Guidelines</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>EVENTS</h4>
                    <ul>
                        <li><a href="#">Find Events</a></li>
                        <li><a href="#">Popular Events</a></li>
                        <li><a href="#">Browse Categories</a></li>
                        <li><a href="#">Virtual Events</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>RESOURCES</h4>
                    <ul>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Meetup API</a></li>
                        <li><a href="#">Accessibility</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Meetup. All rights reserved. | <a href="#" style="color: #999;">Privacy Policy</a> | <a href="#" style="color: #999;">Terms of Service</a></p>
            </div>
        </div>
    </footer>
    
    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeLoginModal()">&times;</button>
            <h1 class="modal-title">Log in</h1>
            
            <div class="social-login">
                <button class="social-btn" onclick="handleSocialLogin('google')">
                    <span>🔍</span>
                    Log in with Google
                </button>
                <button class="social-btn" onclick="handleSocialLogin('apple')">
                    <span>🍎</span>
                    Log in with Apple
                </button>
                <button class="social-btn" onclick="handleSocialLogin('facebook')">
                    <span>f</span>
                    Log in with Facebook
                </button>
            </div>
            
            <div class="divider">or</div>
            
            <form id="loginForm">
                <div class="form-group">
                    <label for="loginEmail">Email</label>
                    <input 
                        type="email" 
                        id="loginEmail" 
                        name="email" 
                        placeholder="you@example.com"
                        required
                    >
                    <div class="helper-text">Try demo: demo@example.com</div>
                </div>
                
                <div class="form-group">
                    <label for="loginPassword">Password</label>
                    <div class="password-container">
                        <input 
                            type="password" 
                            id="loginPassword" 
                            name="password" 
                            placeholder="••••••••••"
                            required
                        >
                        <button type="button" class="toggle-password" onclick="toggleLoginPassword()">
                            👁️
                        </button>
                    </div>
                    <div class="helper-text">Any password works for demo account</div>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="keepLogged" name="keepLogged">
                    <label for="keepLogged" style="margin: 0; cursor: pointer;">Keep me logged in</label>
                </div>
                
                <button type="submit" class="modal-btn">Log in</button>
                
                <div style="text-align: center; margin: 15px 0;">
                    <a href="#" style="color: #e74c3c; text-decoration: none; font-size: 13px; font-weight: 600;">Forgot password?</a>
                </div>
                
                <div class="modal-footer">
                    Don't have an account? <button type="button" onclick="switchToSignup()">Sign up</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Signup Modal -->
    <div id="signupModal" class="modal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeSignupModal()">&times;</button>
            <h1 class="modal-title">Finish signing up</h1>
            
            <form id="signupForm">
                <div class="form-group">
                    <label for="fullname">Your name</label>
                    <input 
                        type="text" 
                        id="fullname" 
                        name="fullname" 
                        placeholder="Your full name here" 
                        required
                    >
                    <div class="helper-text">Your name will be public on your Meetup profile</div>
                </div>
                
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="example@email.com" 
                        required
                    >
                    <div class="helper-text">We'll use your email address to send you updates and to verify your account</div>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••••" 
                        required
                        minlength="10"
                    >
                    <div class="helper-text">At least 10 characters are required</div>
                </div>
                
                <div class="form-group">
                    <label for="location">Location</label>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span>📍</span>
                        <input 
                            type="text" 
                            id="location" 
                            name="location" 
                            placeholder="Lahat, ID" 
                        >
                    </div>
                    <div class="helper-text">We'll use your location to show Meetup events near you</div>
                </div>
                
                <div class="form-group">
                    <label>Age</label>
                    <div class="checkbox-group">
                        <input type="checkbox" id="ageCheck" name="ageCheck" required>
                        <div class="checkbox-text">
                            I am 18 years of age or older.
                        </div>
                    </div>
                </div>
                
                <div class="checkbox-group">
                    <div>
                        <input type="checkbox" id="robot" name="robot">
                    </div>
                    <div class="checkbox-text">
                        I'm not a robot
                        <div style="font-size: 11px; color: #999; margin-top: 2px;">reCAPTCHA</div>
                    </div>
                </div>
                
                <button type="submit" class="modal-btn">Sign up</button>
                
                <div class="modal-footer">
                    Already have an account? <button type="button" onclick="switchToLogin()">Log in</button>
                </div>
                
                <div class="legal-text">
                    By signing up, you agree to our <a href="#">Terms of Service</a>, <a href="#">Privacy Policy</a>, and <a href="#">Cookie Policy</a>.
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // Login Modal Functions
        function openLoginModal() {
            document.getElementById('loginModal').classList.add('active');
            document.body.classList.add('modal-open');
        }
        
        function closeLoginModal() {
            document.getElementById('loginModal').classList.remove('active');
            document.body.classList.remove('modal-open');
        }
        
        // Signup Modal Functions
        function openSignupModal() {
            document.getElementById('signupModal').classList.add('active');
            document.body.classList.add('modal-open');
        }
        
        function closeSignupModal() {
            document.getElementById('signupModal').classList.remove('active');
            document.body.classList.remove('modal-open');
        }
        
        // Toggle between login and signup
        function switchToSignup() {
            closeLoginModal();
            openSignupModal();
        }
        
        function switchToLogin() {
            closeSignupModal();
            openLoginModal();
        }
        
        // Password toggle
        function toggleLoginPassword() {
            const passwordInput = document.getElementById('loginPassword');
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
        }
        
        // Social login
        function handleSocialLogin(provider) {
            alert(`Logging in with ${provider}... (This is a demo)`);
        }
        
        // Form submissions
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value;
            const password = document.getElementById('loginPassword').value;
            
            const user = userAuth.login(email, password);
            if (user) {
                alert('Login successful! Welcome ' + user.fullname);
                updateHeader();
                closeLoginModal();
                document.getElementById('loginForm').reset();
            } else {
                alert('Invalid email or password.\n\nTry demo account:\nEmail: demo@example.com\nPassword: any password');
            }
        });
        
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const fullname = document.getElementById('fullname').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const location = document.getElementById('location').value;
            
            const user = userAuth.signup(fullname, email, password, location);
            alert('Sign up successful! Welcome ' + user.fullname);
            updateHeader();
            closeSignupModal();
            document.getElementById('signupForm').reset();
        });
        
        // Close modal when clicking outside the modal content
        window.addEventListener('click', function(e) {
            const loginModal = document.getElementById('loginModal');
            const signupModal = document.getElementById('signupModal');
            
            if (e.target === loginModal) {
                closeLoginModal();
            }
            if (e.target === signupModal) {
                closeSignupModal();
            }
        });
        
        // Initialize on page load
        window.addEventListener('DOMContentLoaded', function() {
            // Page initialized
        });
    </script>
</body>
</html>
