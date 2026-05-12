<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - Meetup</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        .event-detail-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
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

        .event-detail-header {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .event-detail-hero {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 100px;
            margin-bottom: 30px;
        }

        .event-detail-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }

        .event-detail-group {
            font-size: 18px;
            color: #e74c3c;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .event-detail-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .meta-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .meta-icon {
            font-size: 24px;
            margin-top: 2px;
        }

        .meta-content {
            flex: 1;
        }

        .meta-label {
            font-size: 12px;
            color: #999;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .meta-value {
            font-size: 15px;
            color: #333;
            font-weight: 500;
        }

        .event-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-rsvp {
            background: #e74c3c;
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-rsvp:hover {
            background: #c73a2b;
        }

        .btn-share {
            background: #f5f7fa;
            color: #333;
            padding: 14px 30px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-share:hover {
            background: #e8ecf1;
        }

        .event-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .event-section {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .event-sidebar {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .sidebar-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }

        .event-description {
            font-size: 15px;
            line-height: 1.8;
            color: #666;
            margin-bottom: 20px;
        }

        .agenda-item {
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .agenda-item:last-child {
            border-bottom: none;
        }

        .agenda-time {
            font-weight: 700;
            color: #e74c3c;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .agenda-activity {
            font-size: 15px;
            color: #333;
        }

        .attendees-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .attendee-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: #f9fafb;
            border-radius: 6px;
        }

        .attendee-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
        }

        .attendee-name {
            font-weight: 600;
            color: #333;
        }

        .attendee-role {
            font-size: 12px;
            color: #999;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat {
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #e74c3c;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
        }

        @media (max-width: 768px) {
            .event-content {
                grid-template-columns: 1fr;
            }

            .event-detail-title {
                font-size: 24px;
            }

            .event-detail-hero {
                height: 200px;
                font-size: 60px;
            }

            .event-buttons {
                flex-direction: column;
            }

            .btn-rsvp,
            .btn-share {
                width: 100%;
            }
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

    <!-- Event Detail Content -->
    <div class="event-detail-container">
        <a href="{{ route('index') }}#events" class="back-link">← Back to Events</a>

        <!-- Event Header -->
        <div class="event-detail-header">
            <div class="event-detail-hero">🚀</div>
            <h1 class="event-detail-title">Web Development Workshop</h1>
            <p class="event-detail-group">Hosted by Tech Meetup</p>

            <div class="event-detail-meta">
                <div class="meta-item">
                    <div class="meta-icon">📅</div>
                    <div class="meta-content">
                        <div class="meta-label">Date & Time</div>
                        <div class="meta-value">April 28, 2026 • 6:00 PM - 8:00 PM</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">📍</div>
                    <div class="meta-content">
                        <div class="meta-label">Location</div>
                        <div class="meta-value">Convention Center, Main Hall</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">👥</div>
                    <div class="meta-content">
                        <div class="meta-label">Attendees</div>
                        <div class="meta-value">32 Going • 15 Interested</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">💰</div>
                    <div class="meta-content">
                        <div class="meta-label">Price</div>
                        <div class="meta-value">Free</div>
                    </div>
                </div>
            </div>

            <div class="event-buttons">
                <button class="btn-rsvp" onclick="alert('RSVP Confirmed! - Demo')">RSVP - Going</button>
                <button class="btn-share" onclick="alert('Event shared! - Demo')">📤 Share Event</button>
            </div>
        </div>

        <!-- Event Content -->
        <div class="event-content">
            <!-- Main Content -->
            <div>
                <!-- About Section -->
                <div class="event-section">
                    <h2 class="section-title">About This Event</h2>
                    <p class="event-description">
                        Join us for an exciting Web Development Workshop where you'll learn the latest techniques and 
                        best practices in modern web development. Whether you're a beginner or an experienced developer, 
                        this workshop offers valuable insights and hands-on experience.
                    </p>
                    <p class="event-description">
                        During this 2-hour session, we'll cover:
                    </p>
                    <ul style="margin-left: 20px; color: #666; line-height: 1.8;">
                        <li>React 18 and advanced component patterns</li>
                        <li>State management with Redux and Context API</li>
                        <li>Performance optimization techniques</li>
                        <li>Modern CSS and CSS-in-JS solutions</li>
                        <li>Web accessibility and SEO best practices</li>
                    </ul>
                </div>

                <!-- Agenda Section -->
                <div class="event-section" style="margin-top: 30px;">
                    <h2 class="section-title">Agenda</h2>
                    <div class="agenda-item">
                        <div class="agenda-time">6:00 PM - 6:15 PM</div>
                        <div class="agenda-activity">Welcome & Introductions</div>
                    </div>
                    <div class="agenda-item">
                        <div class="agenda-time">6:15 PM - 6:45 PM</div>
                        <div class="agenda-activity">React Advanced Patterns Deep Dive</div>
                    </div>
                    <div class="agenda-item">
                        <div class="agenda-time">6:45 PM - 7:15 PM</div>
                        <div class="agenda-activity">Live Coding Demo & Q&A</div>
                    </div>
                    <div class="agenda-item">
                        <div class="agenda-time">7:15 PM - 7:45 PM</div>
                        <div class="agenda-activity">Workshop Hands-on Exercises</div>
                    </div>
                    <div class="agenda-item">
                        <div class="agenda-time">7:45 PM - 8:00 PM</div>
                        <div class="agenda-activity">Closing Remarks & Networking</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="event-sidebar">
                <!-- Organizer Card -->
                <div class="sidebar-card">
                    <h3 class="section-title">Organizer</h3>
                    <div class="attendee-item" style="background: white; padding: 0;">
                        <div class="attendee-avatar">JW</div>
                        <div>
                            <div class="attendee-name">Jane Wilson</div>
                            <div class="attendee-role">Event Organizer</div>
                        </div>
                    </div>
                    <p style="margin-top: 15px; font-size: 13px; color: #666; line-height: 1.6;">
                        Jane has been organizing tech meetups for 5 years and has hosted over 50 events.
                    </p>
                </div>

                <!-- Stats Card -->
                <div class="sidebar-card">
                    <h3 class="section-title">Event Stats</h3>
                    <div class="stats">
                        <div class="stat">
                            <div class="stat-number">47</div>
                            <div class="stat-label">Total Interested</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">32</div>
                            <div class="stat-label">Going</div>
                        </div>
                    </div>
                </div>

                <!-- Attendees Card -->
                <div class="sidebar-card">
                    <h3 class="section-title">Attendees</h3>
                    <div class="attendees-list">
                        <div class="attendee-item">
                            <div class="attendee-avatar">JA</div>
                            <div>
                                <div class="attendee-name">John Anderson</div>
                                <div class="attendee-role">Software Developer</div>
                            </div>
                        </div>
                        <div class="attendee-item">
                            <div class="attendee-avatar">SM</div>
                            <div>
                                <div class="attendee-name">Sarah Miller</div>
                                <div class="attendee-role">Web Designer</div>
                            </div>
                        </div>
                        <div class="attendee-item">
                            <div class="attendee-avatar">MC</div>
                            <div>
                                <div class="attendee-name">Michael Chen</div>
                                <div class="attendee-role">Full Stack Dev</div>
                            </div>
                        </div>
                        <div style="text-align: center; padding-top: 10px; color: #e74c3c; font-weight: 600; cursor: pointer;">
                            + 29 more attendees
                        </div>
                    </div>
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
</body>
</html>
