<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Meetup</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        .search-hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 60px 20px; text-align: center; }
        .search-hero h1 { color: white; font-size: 32px; font-weight: 700; margin-bottom: 10px; }
        .search-hero p { color: rgba(255,255,255,0.85); font-size: 16px; margin-bottom: 25px; }
        .search-form { max-width: 700px; margin: 0 auto; display: flex; gap: 10px; flex-wrap: wrap; }
        .search-form input { flex: 1; min-width: 150px; padding: 12px 16px; border: none; border-radius: 8px; font-size: 14px; }
        .search-form button { padding: 12px 28px; background: #e74c3c; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .search-form button:hover { background: #c0392b; }
        .result-count { padding: 20px 0; font-size: 14px; color: #666; border-bottom: 1px solid #eee; margin-bottom: 30px; }
        .section-label { font-size: 22px; font-weight: 700; color: #333; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; }
        .empty-state { text-align: center; padding: 60px 20px; color: #999; }
        .empty-state i { font-size: 48px; margin-bottom: 15px; color: #ddd; }
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

    <!-- Login Modal -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeLoginModal()">&times;</button>
            <div class="modal-header"><h1>meetup</h1><p>Login ke akun Anda</p></div>
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

    <div class="search-hero">
        <h1>🔍 Search Results</h1>
        <p>Find groups and events that match your interests</p>
        <form class="search-form" method="GET" action="{{ route('search') }}">
            <input type="text" name="q" placeholder="Search groups & events..." value="{{ $q }}">
            <input type="text" name="location" placeholder="City, Country" value="{{ $location }}" style="flex: 0.6;">
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="container">
        <div class="result-count">
            @if($q || $location)
                Showing results for
                @if($q)<strong>"{{ $q }}"</strong>@endif
                @if($q && $location) in @endif
                @if($location)<strong>{{ $location }}</strong>@endif
                — {{ $groups->count() + $events->count() }} results
            @else
                Browse all groups and events
            @endif
        </div>

        @if($groups->count() > 0)
        <div class="section-label">🏘️ Groups ({{ $groups->count() }})</div>
        <div class="grid" style="margin-bottom: 40px;">
            @foreach($groups as $group)
            <div class="card">
                <div class="card-image" style="background-size: cover; background-position: center; background-image: url('{{ $group->photo_url }}');"></div>
                <div class="card-content">
                    <h3 class="card-title">{{ $group->group_name }}</h3>
                    <p class="card-subtitle">{{ $group->category ?? 'General' }}</p>
                    <p class="card-meta">📍 {{ $group->city }}, {{ $group->country }}</p>
                    <p class="card-members">{{ $group->member_count }} members • ⭐ {{ number_format($group->average_rating, 1) }}</p>
                    <a href="{{ route('group.detail', $group->id_group) }}" style="display: inline-block; margin-top: 12px; padding: 8px 16px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-size: 13px; font-weight: 600;">View Group</a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($events->count() > 0)
        <div class="section-label">📅 Events ({{ $events->count() }})</div>
        <div style="display: grid; gap: 20px; margin-bottom: 40px;">
            @foreach($events as $event)
            <div style="background: white; border-radius: 8px; display: grid; grid-template-columns: 200px 1fr; gap: 0; border: 1px solid #e0e0e0; overflow: hidden;">
                <div style="height: 150px; background-image: url('{{ $event->photo_url }}'); background-size: cover; background-position: center; position: relative;">
                    <div style="position: absolute; top: 10px; right: 10px; background: rgba(231,76,60,0.9); color: white; padding: 8px 12px; border-radius: 6px; text-align: center; min-width: 60px;">
                        <div style="font-size: 18px; font-weight: bold;">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                        <div style="font-size: 11px;">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                    </div>
                </div>
                <div style="padding: 20px;">
                    <h3 style="margin: 0 0 6px 0; font-size: 18px;">{{ $event->event_title }}</h3>
                    <p style="margin: 0 0 4px 0; color: #666; font-size: 14px;">{{ $event->group->group_name ?? 'Event' }}</p>
                    <p style="margin: 0 0 4px 0; color: #666; font-size: 14px;">📍 {{ $event->venue_name }}, {{ $event->venue_city }}, {{ $event->venue_country }}</p>
                    <p style="margin: 0 0 4px 0; font-size: 13px;">
                        @if($event->event_type == 'online')
                            <span style="display:inline-block;background:#3498db;color:white;padding:2px 8px;border-radius:3px;">🌐 Online</span>
                        @else
                            <span style="display:inline-block;background:#27ae60;color:white;padding:2px 8px;border-radius:3px;">📍 In Person</span>
                        @endif
                    </p>
                    <p style="margin: 0 0 12px 0; color: #e74c3c; font-size: 14px;">{{ $event->total_rsvps }} going</p>
                    <a href="{{ route('event.detail', $event->id_event) }}" style="padding: 8px 16px; background: #667eea; color: white; text-decoration: none; border-radius: 6px; font-size: 13px; font-weight: 600; display: inline-block;">View Event</a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        @if($groups->count() == 0 && $events->count() == 0)
        <div class="empty-state">
            <i class="fas fa-search"></i>
            <p style="font-size: 18px; color: #666;">No results found</p>
            <p style="font-size: 14px;">Try a different search term or browse categories</p>
            <a href="{{ route('groups') }}" style="display: inline-block; margin-top: 20px; padding: 10px 24px; background: #667eea; color: white; border-radius: 6px; text-decoration: none; font-weight: 600;">Browse Groups</a>
        </div>
        @endif
    </div>

    <footer style="background: #333; color: white; padding: 40px 20px; margin-top: 60px; text-align: center;">
        <p>&copy; 2026 Meetup Clone. All rights reserved.</p>
    </footer>

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
</body>
</html>
