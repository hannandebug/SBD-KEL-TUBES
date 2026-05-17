<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->member_name }} - Profile</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); animation: fadeIn 0.3s ease-in-out; backdrop-filter: blur(4px); }
        .modal.show { display: flex; align-items: center; justify-content: center; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-content { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); width: 100%; max-width: 400px; position: relative; animation: slideUp 0.3s ease-in-out; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .close-btn { position: absolute; right: 15px; top: 15px; font-size: 28px; font-weight: bold; color: #999; cursor: pointer; background: none; border: none; }
        .close-btn:hover { color: #333; }
        .modal-header { text-align: center; margin-bottom: 30px; }
        .modal-header h1 { font-size: 28px; color: #333; margin: 0 0 5px 0; }
        .modal-header p { color: #999; margin: 0; font-size: 14px; }
        .social-login { display: flex; gap: 12px; margin-bottom: 25px; justify-content: center; }
        .social-btn { width: 45px; height: 45px; border-radius: 8px; border: 1px solid #e0e0e0; background: white; cursor: pointer; font-size: 20px; display: flex; align-items: center; justify-content: center; }
        .social-btn.google { color: #DB4437; }
        .social-btn.facebook { color: #1877F2; }
        .divider { text-align: center; margin: 20px 0; position: relative; color: #999; font-size: 12px; }
        .divider:before { content: ''; position: absolute; left: 0; top: 50%; width: 100%; height: 1px; background: #e0e0e0; z-index: 0; }
        .divider span { background: white; padding: 0 10px; position: relative; z-index: 1; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; font-size: 14px; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
        .form-group input:focus, .form-group textarea:focus { outline: none; border-color: #667eea; }
        .submit-btn { width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; margin-top: 10px; }
        .modal-footer { text-align: center; margin-top: 20px; font-size: 14px; color: #666; }
        .modal-footer a { color: #667eea; text-decoration: none; font-weight: 600; cursor: pointer; }
        .category-dropdown { position: relative; display: inline-block; padding-bottom: 20px; margin-bottom: -20px; }
        .category-dropdown-btn { padding: 6px 12px; background: #f0f0f0; border: none; border-radius: 20px; font-size: 12px; font-weight: 600; color: #666; cursor: pointer; display: flex; align-items: center; gap: 5px; }
        .category-dropdown-btn:hover { background: #667eea; color: white; }
        .category-dropdown-content { opacity: 0; visibility: hidden; position: absolute; background-color: white; min-width: 200px; box-shadow: 0 8px 16px rgba(0,0,0,0.1); padding: 12px 0; z-index: 1; border-radius: 6px; }
        .category-dropdown-content a { color: black; padding: 12px 16px; text-decoration: none; display: block; font-size: 13px; }
        .category-dropdown-content a:hover { background-color: #f0f0f0; }
        .category-dropdown:hover .category-dropdown-content, .category-dropdown.active .category-dropdown-content { visibility: visible; opacity: 1; transform: translateY(0); }
        .navbar-categories { display: flex; gap: 15px; margin-left: auto; margin-right: 30px; }

        .profile-container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .profile-header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 40px; border-radius: 12px; margin-bottom: 30px; text-align: center; }
        .profile-avatar { width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-size: 60px; margin: 0 auto 20px; border: 4px solid rgba(255,255,255,0.3); }
        .profile-name { font-size: 32px; font-weight: 700; margin-bottom: 10px; }
        .profile-info { font-size: 16px; opacity: 0.9; margin-bottom: 5px; }
        .profile-stats { display: flex; justify-content: center; gap: 40px; margin-top: 30px; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.2); }
        .stat { text-align: center; }
        .stat-number { font-size: 28px; font-weight: 700; }
        .stat-label { font-size: 14px; opacity: 0.8; margin-top: 5px; }
        .profile-section { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 30px; }
        .section-title { font-size: 20px; font-weight: 700; margin-bottom: 20px; color: #333; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
        .member-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 15px; }
        .member-item { text-align: center; }
        .member-avatar { width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; margin: 0 auto 8px; cursor: pointer; }
        .member-name { font-size: 12px; color: #333; word-break: break-word; }
        .events-list { display: grid; gap: 15px; }
        .event-item { padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px; cursor: pointer; transition: all 0.3s; display: flex; justify-content: space-between; align-items: center; }
        .event-item:hover { border-color: #667eea; }
        .event-item-title { font-weight: 600; color: #333; }
        .event-item-date { font-size: 13px; color: #666; }
        .review-item { padding: 15px; border: 1px solid #e0e0e0; border-radius: 6px; margin-bottom: 10px; }
        .review-item:last-child { margin-bottom: 0; }
        .group-badge { display: inline-block; padding: 4px 8px; border-radius: 3px; font-size: 11px; margin-left: 5px; }
        .badge-organizer { background: #f39c12; color: white; }
        .badge-co-organizer { background: #27ae60; color: white; }
        .badge-event-organizer { background: #3498db; color: white; }
        .badge-member { background: #667eea; color: white; }
    </style>
</head>
<body>
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
                        <button class="category-dropdown-btn"><i class="fas fa-th"></i> Categories</button>
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

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeLoginModal()">&times;</button>
            <div class="modal-header"><h1>meetup</h1><p>Login ke akun Anda</p></div>
            <div class="social-login">
                <button class="social-btn google" onclick="alert('Google Sign-in Coming Soon!')"><i class="fab fa-google"></i></button>
                <button class="social-btn facebook" onclick="alert('Facebook Sign-in Coming Soon!')"><i class="fab fa-facebook-f"></i></button>
            </div>
            <div class="divider"><span>atau</span></div>
            <form method="POST" action="{{ route('auth.login') }}">@csrf
                <div class="form-group"><label for="login-email">Email</label><input type="email" id="login-email" name="email" required></div>
                <div class="form-group"><label for="login-password">Password</label><input type="password" id="login-password" name="password" required></div>
                <button type="submit" class="submit-btn">Login</button>
            </form>
            <div class="modal-footer">Belum punya akun? <a onclick="switchToRegisterModal()">Daftar sekarang</a></div>
        </div>
    </div>
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeRegisterModal()">&times;</button>
            <div class="modal-header"><h1>meetup</h1><p>Buat akun baru</p></div>
            <div class="social-login">
                <button class="social-btn google" onclick="alert('Google Sign-in Coming Soon!')"><i class="fab fa-google"></i></button>
                <button class="social-btn facebook" onclick="alert('Facebook Sign-in Coming Soon!')"><i class="fab fa-facebook-f"></i></button>
            </div>
            <div class="divider"><span>atau</span></div>
            <form method="POST" action="{{ route('auth.register') }}">@csrf
                <div class="form-group"><label for="register-name">Nama Lengkap</label><input type="text" id="register-name" name="name" required></div>
                <div class="form-group"><label for="register-email">Email</label><input type="email" id="register-email" name="email" required></div>
                <div class="form-group"><label for="register-password">Password</label><input type="password" id="register-password" name="password" required></div>
                <div class="form-group"><label for="register-password-confirm">Konfirmasi Password</label><input type="password" id="register-password-confirm" name="password_confirmation" required></div>
                <div class="form-group"><label for="register-city">Kota</label><input type="text" id="register-city" name="city" required></div>
                <div class="form-group"><label for="register-country">Negara</label><input type="text" id="register-country" name="country" required></div>
                <button type="submit" class="submit-btn">Daftar</button>
            </form>
            <div class="modal-footer">Sudah punya akun? <a onclick="switchToLoginModal()">Login di sini</a></div>
        </div>
    </div>

    <script>
        function openLoginModal() { document.getElementById('loginModal').classList.add('show'); document.body.style.overflow = 'hidden'; }
        function closeLoginModal() { document.getElementById('loginModal').classList.remove('show'); document.body.style.overflow = 'auto'; }
        function openRegisterModal() { document.getElementById('registerModal').classList.add('show'); document.body.style.overflow = 'hidden'; }
        function closeRegisterModal() { document.getElementById('registerModal').classList.remove('show'); document.body.style.overflow = 'auto'; }
        function switchToLoginModal() { closeRegisterModal(); openLoginModal(); }
        function switchToRegisterModal() { closeLoginModal(); openRegisterModal(); }
        window.onclick = function(event) {
            if (event.target == document.getElementById('loginModal')) closeLoginModal();
            if (event.target == document.getElementById('registerModal')) closeRegisterModal();
        }
    </script>

    <div class="profile-container">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px;">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px;">{{ session('error') }}</div>
        @endif

        <div class="profile-header">
            <div class="profile-avatar">{{ substr($user->member_name, 0, 1) }}</div>
            <h1 class="profile-name">{{ $user->member_name }}</h1>
            <p class="profile-info">📍 {{ $user->member_city }}, {{ $user->member_country }}</p>
            <p class="profile-info">✉️ {{ $user->member_email }}</p>
            <div class="profile-stats">
                <div class="stat">
                    <div class="stat-number">{{ $user->member_gr_count }}</div>
                    <div class="stat-label">Groups Joined</div>
                </div>
                <div class="stat">
                    <div class="stat-number">{{ $user->member_ev_count }}</div>
                    <div class="stat-label">Events Attended</div>
                </div>
                <div class="stat">
                    <div class="stat-number">{{ $user->reviews->count() }}</div>
                    <div class="stat-label">Reviews</div>
                </div>
            </div>
        </div>

        @if($user->groups->count() > 0)
        <div class="profile-section">
            <div class="section-title">My Groups ({{ $user->groups->count() }})</div>
            <div class="member-list">
                @foreach($user->groups as $group)
                    @php
                        $role = $group->pivot->role ?? 'member';
                        $badgeClass = 'badge-' . str_replace('_', '-', $role);
                    @endphp
                    <a href="{{ route('group.detail', $group->id_group) }}" style="text-decoration: none; color: inherit;">
                        <div class="member-item">
                            <div class="member-avatar">{{ substr($group->group_name, 0, 1) }}</div>
                            <div class="member-name">{{ $group->group_name }}</div>
                            <span class="group-badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $role)) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($user->events->count() > 0)
        <div class="profile-section">
            <div class="section-title">My Events ({{ $user->events->count() }})</div>
            <div class="events-list">
                @foreach($user->events as $event)
                    <a href="{{ route('event.detail', $event->id_event) }}" style="text-decoration: none; color: inherit;">
                        <div class="event-item">
                            <div>
                                <div class="event-item-title">{{ $event->event_title }}</div>
                                <div class="event-item-date">📅 {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }} • 📍 {{ $event->venue_name }}</div>
                            </div>
                            <div style="color: #667eea; font-weight: 600;">{{ $event->total_rsvps }} going</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($user->reviews->count() > 0)
        <div class="profile-section">
            <div class="section-title">My Reviews ({{ $user->reviews->count() }})</div>
            @foreach($user->reviews as $review)
                <div class="review-item">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <div>
                            @if($review->group)
                                <strong>Group:</strong> <a href="{{ route('group.detail', $review->group->id_group) }}">{{ $review->group->group_name }}</a>
                            @endif
                            @if($review->event)
                                <strong>Event:</strong> <a href="{{ route('event.detail', $review->event->id_event) }}">{{ $review->event->event_title }}</a>
                            @endif
                        </div>
                        <div>@for($i = 0; $i < 5; $i++)@if($i < $review->rating_given)⭐@else☆@endif @endfor</div>
                    </div>
                    @if($review->review_text)
                        <p style="color: #666; font-size: 14px; line-height: 1.5;">{{ $review->review_text }}</p>
                    @endif
                    <p style="color: #999; font-size: 12px; margin-top: 8px;">{{ $review->created_at->format('M d, Y') }}</p>
                </div>
            @endforeach
        </div>
        @endif
        @if(Auth::check() && Auth::user()->id_member == $user->id_member)
        <div style="text-align: center; margin-top: 20px;">
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="padding: 12px 30px; background: #e74c3c; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600;">Logout</button>
            </form>
        </div>
        @endif
    </div>

    <footer style="background: #333; color: white; padding: 40px 20px; margin-top: 60px; text-align: center;">
        <p>&copy; 2026 Meetup Clone. All rights reserved.</p>
    </footer>
</body>
</html>
