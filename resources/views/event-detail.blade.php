<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - Meetup</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease-in-out;
            backdrop-filter: blur(4px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            position: relative;
            animation: slideUp 0.3s ease-in-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-btn {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 28px;
            font-weight: bold;
            color: #999;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            color: #333;
        }

        .modal-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .modal-header h1 {
            font-size: 28px;
            color: #333;
            margin: 0 0 5px 0;
            font-weight: 600;
        }

        .modal-header p {
            color: #999;
            margin: 0;
            font-size: 14px;
        }

        .social-login {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
            justify-content: center;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            background: white;
            cursor: pointer;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .social-btn.google {
            color: #DB4437;
        }

        .social-btn.facebook {
            color: #1877F2;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
            color: #999;
            font-size: 12px;
        }

        .divider:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e0e0e0;
            z-index: 0;
        }

        .divider span {
            background: white;
            padding: 0 10px;
            position: relative;
            z-index: 1;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .modal-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .modal-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }

        .modal-footer a:hover {
            text-decoration: underline;
        }

        .category-dropdown {
            position: relative;
            display: inline-block;
        }

        .category-dropdown-btn {
            padding: 6px 12px;
            background: #f0f0f0;
            border: none;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .category-dropdown-btn:hover {
            background: #667eea;
            color: white;
        }

        .category-dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 12px 0;
            z-index: 1;
            border-radius: 6px;
            top: 100%;
            left: 0;
            margin-top: 5px;
        }

        .category-dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 13px;
            transition: all 0.3s;
        }

        .category-dropdown-content a:hover {
            background-color: #f0f0f0;
            padding-left: 20px;
        }

        .category-dropdown:hover .category-dropdown-content {
            display: block;
        }

        .navbar-categories {
            display: flex;
            gap: 15px;
            margin-left: auto;
            margin-right: 30px;
        }

        .event-detail-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
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
            color: #667eea;
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
            background: #27ae60;
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s;
        }

        .btn-rsvp:hover {
            background: #229954;
        }

        .btn-rsvp.cancel {
            background: #e74c3c;
        }

        .btn-rsvp.cancel:hover {
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
            color: #667eea;
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
                <li><a href="{{ route('groups') }}">Groups</a></li>
                <li><a href="{{ route('events') }}">Events</a></li>
                <li><a href="{{ route('reviews') }}">Reviews</a></li>
            </ul>
            <div class="navbar-categories">
                <div class="category-dropdown">
                    <button class="category-dropdown-btn">
                        <i class="fas fa-th"></i> Categories
                    </button>
                    <div class="category-dropdown-content">
                        @forelse($categories as $cat)
                            <a href="{{ route('explore.category', $cat) }}">{{ $cat }}</a>
                        @empty
                            <a href="#">No categories</a>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="header-buttons">
                @if(Auth::check())
                    <span style="margin-right: 15px; color: #333;">{{ Auth::user()->member_name }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px;">Logout</button>
                    </form>
                @else
                    <button onclick="openLoginModal()" style="margin-right: 10px; padding: 8px 16px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">Login</button>
                    <button onclick="openRegisterModal()" style="padding: 8px 16px; background: #764ba2; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px;">Register</button>
                @endif
            </div>
        </div>
    </header>

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeLoginModal()">&times;</button>
            <div class="modal-header">
                <h1>meetup</h1>
                <p>Login ke akun Anda</p>
            </div>

            <div class="social-login">
                <button class="social-btn google" title="Sign in with Google" onclick="alert('Google Sign-in Coming Soon!')">
                    <i class="fab fa-google"></i>
                </button>
                <button class="social-btn facebook" title="Sign in with Facebook" onclick="alert('Facebook Sign-in Coming Soon!')">
                    <i class="fab fa-facebook-f"></i>
                </button>
            </div>

            <div class="divider">
                <span>atau</span>
            </div>

            <form method="POST" action="{{ route('auth.login') }}">
                @csrf

                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" required>
                </div>

                <button type="submit" class="submit-btn">Login</button>
            </form>

            <div class="modal-footer">
                Belum punya akun? <a onclick="switchToRegisterModal()">Daftar sekarang</a>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeRegisterModal()">&times;</button>
            <div class="modal-header">
                <h1>meetup</h1>
                <p>Buat akun baru</p>
            </div>

            <div class="social-login">
                <button class="social-btn google" title="Sign in with Google" onclick="alert('Google Sign-in Coming Soon!')">
                    <i class="fab fa-google"></i>
                </button>
                <button class="social-btn facebook" title="Sign in with Facebook" onclick="alert('Facebook Sign-in Coming Soon!')">
                    <i class="fab fa-facebook-f"></i>
                </button>
            </div>

            <div class="divider">
                <span>atau</span>
            </div>

            <form method="POST" action="{{ route('auth.register') }}">
                @csrf

                <div class="form-group">
                    <label for="register-name">Nama Lengkap</label>
                    <input type="text" id="register-name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="register-password-confirm">Konfirmasi Password</label>
                    <input type="password" id="register-password-confirm" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <label for="register-city">Kota</label>
                    <input type="text" id="register-city" name="city" required>
                </div>

                <div class="form-group">
                    <label for="register-country">Negara</label>
                    <input type="text" id="register-country" name="country" required>
                </div>

                <button type="submit" class="submit-btn">Daftar</button>
            </form>

            <div class="modal-footer">
                Sudah punya akun? <a onclick="switchToLoginModal()">Login di sini</a>
            </div>
        </div>
    </div>

    <script>
        function openLoginModal() {
            document.getElementById('loginModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function openRegisterModal() {
            document.getElementById('registerModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function switchToLoginModal() {
            closeRegisterModal();
            openLoginModal();
        }

        function switchToRegisterModal() {
            closeLoginModal();
            openRegisterModal();
        }

        window.onclick = function(event) {
            let loginModal = document.getElementById('loginModal');
            let registerModal = document.getElementById('registerModal');
            
            if (event.target == loginModal) {
                closeLoginModal();
            }
            if (event.target == registerModal) {
                closeRegisterModal();
            }
        }
    </script>

    <!-- Event Detail Content -->
    <div class="event-detail-container">
        <a href="{{ route('events') }}" class="back-link">← Kembali ke Events</a>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Event Header -->
        <div class="event-detail-header">
            <div class="event-detail-hero" style="background-image: url('{{ $event->photo_url }}'); background-size: cover; background-position: center;"></div>
            <h1 class="event-detail-title">{{ $event->event_title }}</h1>
            <p class="event-detail-group">Hosted by <a href="{{ route('group.detail', $event->id_group) }}" style="color: #667eea; text-decoration: none;">{{ $event->group->group_name ?? 'Event' }}</a></p>

            <div class="event-detail-meta">
                <div class="meta-item">
                    <div class="meta-icon">📅</div>
                    <div class="meta-content">
                        <div class="meta-label">Date & Time</div>
                        <div class="meta-value">{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y • H:i') }}</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">📍</div>
                    <div class="meta-content">
                        <div class="meta-label">Location</div>
                        <div class="meta-value">{{ $event->venue_name }}, {{ $event->venue_city }}, {{ $event->venue_country }}</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">👥</div>
                    <div class="meta-content">
                        <div class="meta-label">Attendees</div>
                        <div class="meta-value">{{ $event->total_rsvps }} Going</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">🎟️</div>
                    <div class="meta-content">
                        <div class="meta-label">Event Type</div>
                        <div class="meta-value">{{ ucfirst($event->event_type) }}</div>
                    </div>
                </div>
            </div>

            <div class="event-buttons">
                @if(Auth::check())
                    @if($isAttending)
                        <form method="POST" action="{{ route('event.cancel-rsvp', $event->id_event) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-rsvp cancel">Batal RSVP</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('event.rsvp', $event->id_event) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-rsvp">RSVP - Going</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('auth.login') }}" class="btn-rsvp" style="text-decoration: none; display: inline-block;">RSVP - Going</a>
                @endif
                <button class="btn-share" onclick="alert('Feature share akan datang!')">📤 Share Event</button>
            </div>
        </div>

        <!-- Event Content -->
        <div class="event-content">
            <!-- Main Content -->
            <div>
                <!-- About Section -->
                <div class="event-section">
                    <h2 class="section-title">Tentang Event Ini</h2>
                    <p class="event-description">
                        {{ $event->event_description }}
                    </p>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="event-sidebar">
                <!-- Stats Card -->
                <div class="sidebar-card">
                    <h3 class="section-title">Event Stats</h3>
                    <div class="stats">
                        <div class="stat">
                            <div class="stat-number">{{ $event->total_rsvps }}</div>
                            <div class="stat-label">Going</div>
                        </div>
                        <div class="stat">
                            <div class="stat-number">{{ count($event->attendees) }}</div>
                            <div class="stat-label">Attendees</div>
                        </div>
                    </div>
                </div>

                <!-- Attendees Card -->
                @if($event->attendees->count() > 0)
                <div class="sidebar-card">
                    <h3 class="section-title">Attendees ({{ $event->attendees->count() }})</h3>
                    <div class="attendees-list">
                        @foreach($event->attendees->take(5) as $attendee)
                        <div class="attendee-item">
                            <div class="attendee-avatar">{{ substr($attendee->member_name, 0, 1) }}</div>
                            <div>
                                <div class="attendee-name">{{ $attendee->member_name }}</div>
                                <div class="attendee-role">Attendee</div>
                            </div>
                        </div>
                        @endforeach
                        @if($event->attendees->count() > 5)
                        <div style="text-align: center; padding: 10px; color: #666; font-size: 13px;">
                            +{{ $event->attendees->count() - 5 }} lebih banyak
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer style="background: #333; color: white; padding: 40px 20px; margin-top: 60px; text-align: center;">
        <p>&copy; 2026 Meetup Clone. All rights reserved.</p>
    </footer>
</body>
</html>
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
            <div class="event-detail-hero" style="background-image: url('{{ $event->photo_url }}'); background-size: cover; background-position: center;"></div>
            <h1 class="event-detail-title">{{ $event->event_title }}</h1>
            <p class="event-detail-group">Hosted by {{ $event->group->group_name ?? 'Event' }}</p>

            <div class="event-detail-meta">
                <div class="meta-item">
                    <div class="meta-icon">📅</div>
                    <div class="meta-content">
                        <div class="meta-label">Date & Time</div>
                        <div class="meta-value">{{ \Carbon\Carbon::parse($event->event_date)->format('F d, Y') }} • {{ \Carbon\Carbon::parse($event->event_date)->format('g:i A') }}{{ $event->detail && $event->detail->event_endtime ? ' - ' . \Carbon\Carbon::parse($event->detail->event_endtime)->format('g:i A') : '' }}</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">📍</div>
                    <div class="meta-content">
                        <div class="meta-label">Location</div>
                        <div class="meta-value">{{ $event->detail && $event->detail->venue_address ? $event->detail->venue_address : ($event->venue_name . ', ' . $event->venue_city . ', ' . $event->venue_country) }}</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">👥</div>
                    <div class="meta-content">
                        <div class="meta-label">Attendees</div>
                        <div class="meta-value">{{ $event->total_rsvps }} Going</div>
                    </div>
                </div>
                <div class="meta-item">
                    <div class="meta-icon">💰</div>
                    <div class="meta-content">
                        <div class="meta-label">Event Type</div>
                        <div class="meta-value">{{ ucfirst($event->event_type) }}</div>
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
                        {{ $event->event_description }}
                    </p>
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
