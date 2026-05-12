<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Meetup</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        .profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .profile-header {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
            text-align: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 60px;
            margin: 0 auto 20px;
        }

        .profile-name {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .profile-info {
            font-size: 16px;
            color: #666;
            margin-bottom: 5px;
        }

        .profile-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
            padding-top: 30px;
            border-top: 1px solid #ddd;
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #e74c3c;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .profile-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }

        .bio {
            font-size: 15px;
            line-height: 1.6;
            color: #666;
            margin-bottom: 20px;
        }

        .interests {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .interest-tag {
            background: #f5f7fa;
            color: #333;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .events-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .event-item {
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
            border-left: 4px solid #e74c3c;
        }

        .event-item-title {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .event-item-details {
            font-size: 13px;
            color: #666;
        }

        .btn-edit {
            background: #e74c3c;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-edit:hover {
            background: #c73a2b;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #e74c3c;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <a href="{{ route('index') }}" class="logo">meetup</a>
            <ul class="header-nav">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li><a href="{{ route('index') }}#groups">Groups</a></li>
                <li><a href="{{ route('index') }}#events">Events</a></li>
                <li><a href="{{ route('index') }}#category">Categories</a></li>
            </ul>
            <div class="header-buttons">
            </div>
        </div>
    </header>

    <!-- Profile Content -->
    <div class="profile-container">
        <a href="{{ route('index') }}" class="back-link">← Back to Home</a>

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-avatar" id="profileAvatar">👤</div>
            <h1 class="profile-name" id="profileName">John Anderson</h1>
            <p class="profile-info" id="profileLocation">📍 San Francisco, California</p>
            <p class="profile-info" id="profileEmail">✉️ john.anderson@email.com</p>
            <p class="profile-info" id="profileJoinDate">Joined in March 2024</p>
            
            <div class="profile-stats">
                <div class="stat">
                    <div class="stat-number" id="groupsCount">12</div>
                    <div class="stat-label">Groups Joined</div>
                </div>
                <div class="stat">
                    <div class="stat-number" id="eventsCount">23</div>
                    <div class="stat-label">Events Attended</div>
                </div>
                <div class="stat">
                    <div class="stat-number" id="friendsCount">156</div>
                    <div class="stat-label">Friends</div>
                </div>
            </div>
        </div>

        <!-- Bio Section -->
        <div class="profile-section">
            <div class="section-title">About Me</div>
            <p class="bio">
                I'm a software developer passionate about building amazing web applications. 
                I love attending tech meetups, learning from others, and networking with like-minded professionals. 
                In my free time, I enjoy contributing to open-source projects and sharing knowledge with the community.
            </p>
            <button class="btn-edit">Edit Profile</button>
        </div>

        <!-- Interests Section -->
        <div class="profile-section">
            <div class="section-title">Interests</div>
            <div class="interests">
                <span class="interest-tag">💻 Technology</span>
                <span class="interest-tag">🚀 Startups</span>
                <span class="interest-tag">📚 Learning</span>
                <span class="interest-tag">🤝 Networking</span>
                <span class="interest-tag">🎨 Design</span>
                <span class="interest-tag">📱 Mobile Apps</span>
                <span class="interest-tag">🌐 Web Development</span>
                <span class="interest-tag">💡 Innovation</span>
            </div>
        </div>

        <!-- Upcoming Events Section -->
        <div class="profile-section">
            <div class="section-title">My Upcoming Events</div>
            <div class="events-list">
                <div class="event-item">
                    <div class="event-item-title">🚀 Web Development Workshop</div>
                    <div class="event-item-details">Tech Meetup • April 28, 2026 • Convention Center</div>
                </div>
                <div class="event-item">
                    <div class="event-item-title">🎨 Design Thinking Session</div>
                    <div class="event-item-details">Design Collective • April 30, 2026 • Creative Studio</div>
                </div>
                <div class="event-item">
                    <div class="event-item-title">💼 Startup Pitch Night</div>
                    <div class="event-item-details">Entrepreneurs Network • May 5, 2026 • Innovation Hub</div>
                </div>
            </div>
        </div>

        <!-- Past Events Section -->
        <div class="profile-section">
            <div class="section-title">Recent Attended Events</div>
            <div class="events-list">
                <div class="event-item">
                    <div class="event-item-title">React Advanced Patterns</div>
                    <div class="event-item-details">Tech Meetup • April 15, 2026 • 45 attendees</div>
                </div>
                <div class="event-item">
                    <div class="event-item-title">Networking Coffee Talk</div>
                    <div class="event-item-details">Business District • April 10, 2026 • 32 attendees</div>
                </div>
                <div class="event-item">
                    <div class="event-item-title">UI/UX Workshop</div>
                    <div class="event-item-details">Design Collective • April 1, 2026 • 28 attendees</div>
                </div>
            </div>
        </div>
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

    <script>
        // Load and display user profile
        function loadUserProfile() {
            if (!userAuth.isLoggedIn()) {
                alert('Please login to view your profile');
                window.location.href = '{{ route("index") }}';
                return;
            }

            const user = userAuth.getCurrentUser();
            
            // Update profile header
            document.getElementById('profileName').textContent = user.fullname;
            document.getElementById('profileLocation').textContent = '📍 ' + (user.location || 'Location not set');
            document.getElementById('profileEmail').textContent = '✉️ ' + user.email;
            document.getElementById('profileJoinDate').textContent = 'Joined in ' + user.joinDate;
            
            // Update avatar
            document.getElementById('profileAvatar').textContent = user.avatar;
            
            // Update stats
            document.getElementById('groupsCount').textContent = user.groupsJoined || '0';
            document.getElementById('eventsCount').textContent = user.eventsAttended || '0';
            document.getElementById('friendsCount').textContent = user.friends || '0';
        }

        // Initialize profile when page loads
        window.addEventListener('DOMContentLoaded', function() {
            loadUserProfile();
        });
    </script>
</body>
</html>
