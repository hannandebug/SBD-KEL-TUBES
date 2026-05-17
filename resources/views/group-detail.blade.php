<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $group->group_name }} - Meetup</title>
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
            padding-bottom: 20px;
            margin-bottom: -20px;
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
            opacity: 0;
            visibility: hidden;
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

        .category-dropdown:hover .category-dropdown-content,
        .category-dropdown.active .category-dropdown-content {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }

        .navbar-categories {
            display: flex;
            gap: 15px;
            margin-left: auto;
            margin-right: 30px;
        }

        .group-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            margin-bottom: 40px;
        }
        .group-header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 30px;
            align-items: center;
        }
        .group-photo {
            width: 150px;
            height: 150px;
            border-radius: 12px;
            background-size: cover;
            background-position: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        .group-info h1 {
            margin: 0 0 10px 0;
            font-size: 32px;
        }
        .group-info p {
            margin: 5px 0;
            opacity: 0.95;
        }
        .group-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            text-decoration: none;
        }
        .btn-primary {
            background: white;
            color: #667eea;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-danger {
            background: #e74c3c;
            color: white;
        }
        .btn-danger:hover {
            background: #c0392b;
        }
        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        .detail-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }
        .detail-section h2 {
            margin: 0 0 15px 0;
            font-size: 18px;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }
        .topic-list {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .topic-tag {
            background: #f0f0f0;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s;
        }
        .topic-tag:hover {
            background: #667eea;
            color: white;
        }
        .member-section {
            margin-bottom: 20px;
        }
        .member-section-title {
            font-size: 14px;
            font-weight: 600;
            color: #666;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .member-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 15px;
        }
        .member-item {
            text-align: center;
        }
        .member-item a {
            text-decoration: none;
        }
        .member-avatar {
            width: 60px;
            height: 60px;
            background: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin: 0 auto 8px;
            font-size: 20px;
        }
        .member-name {
            font-size: 12px;
            color: #333;
            word-break: break-word;
        }
        .organizer-badge {
            display: inline-block;
            background: #f39c12;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: 600;
            margin-top: 4px;
        }
        .coorganizer-badge {
            display: inline-block;
            background: #27ae60;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: 600;
            margin-top: 4px;
        }
        .eventorg-badge {
            display: inline-block;
            background: #3498db;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: 600;
            margin-top: 4px;
        }
        .events-list {
            display: grid;
            gap: 15px;
        }
        .event-item {
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .event-item:hover {
            border-color: #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }
        .event-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .event-date {
            font-size: 13px;
            color: #666;
        }
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            margin-bottom: 15px;
        }
        .photo-item {
            width: 100%;
            height: 150px;
            border-radius: 6px;
            background-size: cover;
            background-position: center;
            border: 1px solid #e0e0e0;
        }
        .review-item {
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .review-author {
            font-weight: 600;
            color: #333;
        }
        .review-date {
            font-size: 12px;
            color: #999;
        }
        .review-stars {
            color: #f39c12;
        }
        .review-text {
            color: #666;
            line-height: 1.5;
            font-size: 14px;
        }
        .review-form textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            resize: vertical;
            box-sizing: border-box;
        }
        .review-form textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .review-form select {
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        .btn-outline {
            padding: 8px 16px;
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-outline:hover {
            background: #667eea;
            color: white;
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
                @if(Auth::check())
                <li><a href="{{ route('my.groups') }}" style="color: #e74c3c; font-weight: 700;">My Groups</a></li>
                <li><a href="{{ route('my.events') }}" style="color: #e74c3c; font-weight: 700;">My Events</a></li>
                @endif
            </ul>
            <div class="header-right">
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
                        <a href="{{ route('profile') }}" style="margin-right: 15px; color: #333; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                            <span style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: inline-flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px;">
                                {{ substr(Auth::user()->member_name, 0, 1) }}
                            </span>
                            {{ Auth::user()->member_name }}
                        </a>
                        @if(Auth::user()->member_email == 'admin@meetup.com')
                            <a href="{{ route('admin.index') }}" style="margin-right: 10px; padding: 8px 16px; background: #f39c12; color: white; border-radius: 6px; text-decoration: none; font-size: 13px;">Admin</a>
                        @endif
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

    <!-- Group Header -->
    <div class="group-header">
        <div class="group-header-content">
            <div class="group-photo" style="background-image: url('{{ $group->photo_url }}');"></div>
            <div class="group-info">
                <h1>{{ $group->group_name }}</h1>
                <p><strong>{{ $group->category ?? 'General Group' }}</strong></p>
                <p>📍 {{ $group->city }}, {{ $group->country }}</p>
                <p>{{ $group->member_count }} members • ⭐ {{ number_format($group->average_rating, 1) }}</p>
                @if($group->is_newgroup)
                    <span style="display: inline-block; background: #e74c3c; color: white; padding: 4px 8px; border-radius: 3px; font-size: 12px; margin-top: 8px;">NEW GROUP</span>
                @endif
                <div class="group-actions">
                    @if(Auth::check())
                        @if($isJoined)
                            <form method="POST" action="{{ route('group.leave', $group->id_group) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">Keluar dari Grup</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('group.join', $group->id_group) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">Bergabung</button>
                            </form>
                        @endif
                    @else
                        <button onclick="openLoginModal()" class="btn btn-primary" style="border: none; cursor: pointer;">Bergabung</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
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

        <div class="details-grid">
            <!-- About Group -->
            <div class="detail-section">
                <h2>Tentang Grup</h2>
                <p style="color: #666; line-height: 1.6;">{{ $group->group_description }}</p>
            </div>

            <!-- Topics -->
            @if($group->topics->count() > 0)
            <div class="detail-section">
                <h2>Topik</h2>
                <div class="topic-list">
                    @foreach($group->topics as $topic)
                        <a href="{{ route('search.topic', $topic->topic_name) }}" class="topic-tag">{{ $topic->topic_name }}</a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Events -->
            @if($group->events->count() > 0)
            <div class="detail-section">
                <h2>Event Mendatang ({{ $group->events->count() }})</h2>
                <div class="events-list">
                    @foreach($group->events->take(5) as $event)
                        <div class="event-item" onclick="window.location.href='{{ route('event.detail', $event->id_event) }}'">
                            <div class="event-title">{{ $event->event_title }}</div>
                            <div class="event-date">📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y H:i') }}</div>
                            <div class="event-date">{{ $event->total_rsvps }} going</div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Members Section -->
            <div class="detail-section full-width">
                <h2>Anggota ({{ $group->members->count() }})</h2>

                <!-- Organizer -->
                @if($organizer)
                <div class="member-section">
                    <div class="member-section-title"><i class="fas fa-crown" style="color: #f39c12;"></i> Organizer</div>
                    <div class="member-list">
                        <div class="member-item">
                            <a href="{{ route('profile.id', $organizer->id_member) }}">
                                <div class="member-avatar" style="background: linear-gradient(135deg, #f39c12, #e67e22);">{{ substr($organizer->member_name, 0, 1) }}</div>
                                <div class="member-name">{{ $organizer->member_name }}</div>
                            </a>
                            <div class="organizer-badge">Organizer</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Co-Organizers -->
                @if($coOrganizers->count() > 0)
                <div class="member-section">
                    <div class="member-section-title"><i class="fas fa-user-tie" style="color: #27ae60;"></i> Co-Organizers</div>
                    <div class="member-list">
                        @foreach($coOrganizers as $co)
                        <div class="member-item">
                            <a href="{{ route('profile.id', $co->id_member) }}">
                                <div class="member-avatar" style="background: linear-gradient(135deg, #27ae60, #2ecc71);">{{ substr($co->member_name, 0, 1) }}</div>
                                <div class="member-name">{{ $co->member_name }}</div>
                            </a>
                            <div class="coorganizer-badge">Co-Organizer</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Event Organizers -->
                @if($eventOrganizers->count() > 0)
                <div class="member-section">
                    <div class="member-section-title"><i class="fas fa-calendar-check" style="color: #3498db;"></i> Event Organizers</div>
                    <div class="member-list">
                        @foreach($eventOrganizers as $eo)
                        <div class="member-item">
                            <a href="{{ route('profile.id', $eo->id_member) }}">
                                <div class="member-avatar" style="background: linear-gradient(135deg, #3498db, #2980b9);">{{ substr($eo->member_name, 0, 1) }}</div>
                                <div class="member-name">{{ $eo->member_name }}</div>
                            </a>
                            <div class="eventorg-badge">Event Org.</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Members -->
                @if($members->count() > 0)
                <div class="member-section">
                    <div class="member-section-title"><i class="fas fa-users" style="color: #667eea;"></i> Members</div>
                    <div class="member-list">
                        @foreach($members as $member)
                        <div class="member-item">
                            <a href="{{ route('profile.id', $member->id_member) }}">
                                <div class="member-avatar">{{ substr($member->member_name, 0, 1) }}</div>
                                <div class="member-name">{{ $member->member_name }}</div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Album Section -->
            @if(count($albumPhotos) > 0)
            <div class="detail-section">
                <h2>Album Foto</h2>
                <div class="photo-grid">
                    @foreach(array_slice($albumPhotos, 0, 6) as $photo)
                        <div class="photo-item" style="background-image: url('{{ $photo }}');"></div>
                    @endforeach
                </div>
                <a href="{{ route('group.album', $group->id_group) }}" class="btn-outline">Lihat Album Lengkap</a>
            </div>
            @endif

            <!-- Reviews Section -->
            <div class="detail-section">
                <h2>Ulasan ({{ $reviews->count() }})</h2>

                @if($reviews->count() > 0)
                    @foreach($reviews as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <div>
                                <span class="review-author">{{ $review->member->member_name ?? 'Anonymous' }}</span>
                                <span class="review-date"> • {{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}</span>
                            </div>
                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating_given)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        <p class="review-text">{{ $review->review_text }}</p>
                    </div>
                    @endforeach
                @else
                    <p style="color: #999; font-size: 14px;">Belum ada ulasan untuk grup ini.</p>
                @endif

                @if(Auth::check())
                <div class="review-form" style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0;">
                    <h3 style="font-size: 16px; margin: 0 0 15px 0; color: #333;">Tulis Ulasan</h3>
                    <form method="POST" action="{{ route('review.store') }}">
                        @csrf
                        <input type="hidden" name="id_group" value="{{ $group->id_group }}">

                        <div class="form-group">
                            <label for="rating_given">Rating</label>
                            <select name="rating_given" id="rating_given" required style="padding: 10px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 14px; background: white; width: 100%; box-sizing: border-box;">
                                <option value="">Pilih rating</option>
                                <option value="1">1 - Sangat Buruk</option>
                                <option value="2">2 - Buruk</option>
                                <option value="3">3 - Cukup</option>
                                <option value="4">4 - Baik</option>
                                <option value="5">5 - Sangat Baik</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="review_text">Ulasan</label>
                            <textarea name="review_text" id="review_text" rows="4" required placeholder="Bagikan pengalaman Anda di grup ini..."></textarea>
                        </div>

                        <button type="submit" class="submit-btn">Kirim Ulasan</button>
                    </form>
                </div>
                @else
                <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #e0e0e0; text-align: center;">
                    <p style="color: #999; font-size: 14px;">Silakan <a onclick="openLoginModal()" style="color: #667eea; text-decoration: none; font-weight: 600; cursor: pointer;">login</a> untuk memberikan ulasan.</p>
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
