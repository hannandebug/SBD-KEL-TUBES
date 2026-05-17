<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meetup - Find Your Community</title>
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
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; font-size: 14px; }
        .form-group input { width: 100%; padding: 12px; border: 1px solid #e0e0e0; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
        .form-group input:focus { outline: none; border-color: #667eea; }
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
        .category-card { text-align: center; cursor: pointer; transition: transform 0.3s; background: white; border-radius: 12px; padding: 25px 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .category-card:hover { transform: translateY(-4px); box-shadow: 0 4px 16px rgba(0,0,0,0.12); }
        .category-icon { width: 70px; height: 70px; margin: 0 auto 12px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 32px; }
        .category-name { font-weight: 600; color: #333; font-size: 14px; }
        .category-count { font-size: 12px; color: #999; margin-top: 4px; }
        .section { margin-bottom: 60px; }
        .section-header { margin-bottom: 30px; }
        .section-title { font-size: 28px; font-weight: 700; color: #333; margin-bottom: 8px; }
        .section-subtitle { font-size: 16px; color: #666; }
        .featured-group-card, .event-card-wrapper { position: relative; overflow: hidden; }
        .card-overlay { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.65); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.3s ease; z-index: 10; border-radius: 8px; }
        .featured-group-card:hover .card-overlay, .event-card-wrapper:hover .card-overlay { opacity: 1; }
        .btn-join { padding: 12px 28px; background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; }
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
                            <a href="{{ route('reviews') }}">Reviews</a>
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

    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Join your people</h1>
            <p>Find and meet local groups interested in the things you care about</p>
            <div class="hero-search">
                <form method="GET" action="{{ route('search') }}" style="display: flex; width: 100%; gap: 10px; flex-wrap: wrap;">
                    <input type="text" name="q" placeholder="Search for a topic, group, or event" style="flex: 2; min-width: 200px;" value="{{ request('q') }}">
                    <input type="text" name="location" placeholder="City, Country" style="flex: 1; min-width: 140px;" value="{{ request('location', $location) }}">
                    <button type="submit">Search</button>
                </form>
            </div>
        </div>
    </section>

    <div class="container">
        <section class="section" id="groups">
            <div class="section-header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h2 class="section-title">Featured Groups</h2>
                    <p class="section-subtitle">Meet people interested in what you love</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    @if(Auth::check())
                        <a href="{{ route('group.create') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                            <span style="font-size: 18px; font-weight: 700;">+</span> Create Group
                        </a>
                    @endif
                    <a href="{{ route('groups') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 24px; background: white; color: #667eea; border: 2px solid #667eea; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#667eea';this.style.color='white'" onmouseout="this.style.background='white';this.style.color='#667eea'">
                        View All Groups <span style="font-size: 16px;">→</span>
                    </a>
                </div>
            </div>
            <div class="grid">
                @forelse($featuredGroups as $group)
                <div class="featured-group-card">
                    <a href="{{ route('group.detail', ['id' => $group->id_group]) }}" style="text-decoration: none; color: inherit;">
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
                    </a>
                    <div class="card-overlay">
                        <a href="{{ route('group.detail', ['id' => $group->id_group]) }}" class="btn-detail">Detail</a>
                        @if(Auth::check())
                        <form action="{{ route('group.join', ['id' => $group->id_group]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-join">Join Group</button>
                        </form>
                        @else
                        <button type="button" class="btn-join" onclick="openLoginModal()">Login to Join</button>
                        @endif
                    </div>
                </div>
                @empty
                <p>No groups available yet.</p>
                @endforelse
            </div>
        </section>

        <section class="section" id="events">
            <div class="section-header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
                <div>
                    <h2 class="section-title">Upcoming Events</h2>
                    <p class="section-subtitle">Don't miss out on what's happening near you</p>
                </div>
                <div style="display: flex; gap: 10px;">
                    @if(Auth::check())
                        <a href="{{ route('event.create') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                            <span style="font-size: 18px; font-weight: 700;">+</span> Create Event
                        </a>
                    @endif
                    <a href="{{ route('events') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 24px; background: white; color: #667eea; border: 2px solid #667eea; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#667eea';this.style.color='white'" onmouseout="this.style.background='white';this.style.color='#667eea'">
                        View All Events <span style="font-size: 16px;">→</span>
                    </a>
                </div>
            </div>
            <div class="grid">
                @forelse($upcomingEvents as $event)
                <div class="event-card-wrapper">
                    <a href="{{ route('event.detail', ['id' => $event->id_event]) }}" style="text-decoration: none; color: inherit;">
                        <div class="event-card">
                            <div style="height: 150px; background-image: url('{{ $event->photo_url }}'); background-size: cover; background-position: center; position: relative;">
                                @if(!$event->event_photo)
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);display:flex;align-items:center;justify-content:center;font-size:48px;color:white;">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                @endif
                                <div style="position: absolute; top: 10px; right: 10px; background: rgba(231,76,60,0.9); color: white; padding: 8px 12px; border-radius: 6px; text-align: center; min-width: 60px;">
                                    <div style="font-size: 18px; font-weight: bold;">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                                    <div style="font-size: 11px;">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                                </div>
                            </div>
                            <div class="event-content">
                                <h3 class="event-title">{{ $event->event_title }}</h3>
                                <p class="event-group">{{ $event->group->group_name ?? 'Event' }}</p>
                                <p class="event-location">📍 {{ $event->venue_name }}</p>
                                <p class="event-attendees">{{ $event->total_rsvps }} going</p>
                                @if($event->event_type == 'online')
                                <span style="display:inline-block;background:#3498db;color:white;padding:2px 6px;border-radius:3px;font-size:11px;margin-top:4px;">Online</span>
                                @else
                                <span style="display:inline-block;background:#27ae60;color:white;padding:2px 6px;border-radius:3px;font-size:11px;margin-top:4px;">In Person</span>
                                @endif
                            </div>
                        </div>
                    </a>
                    <div class="card-overlay">
                        <a href="{{ route('event.detail', ['id' => $event->id_event]) }}" class="btn-detail">Detail</a>
                        @if(Auth::check())
                        <form action="{{ route('event.rsvp', ['id' => $event->id_event]) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-join">RSVP</button>
                        </form>
                        @else
                        <button type="button" class="btn-join" onclick="openLoginModal()">Login to RSVP</button>
                        @endif
                    </div>
                </div>
                @empty
                <p>No upcoming events at the moment.</p>
                @endforelse
            </div>
        </section>

        <section class="section" id="category">
            <div class="section-header">
                <h2 class="section-title">Explore by Category</h2>
                <p class="section-subtitle">Find your community based on interests</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 16px;">
                @php
                    $categoryIcons = [
                        'Technology' => ['bg' => '#e8f4fd', 'icon' => '💻', 'color' => '#3498db'],
                        'Arts & Design' => ['bg' => '#fdf2e9', 'icon' => '🎨', 'color' => '#e67e22'],
                        'Sports & Fitness' => ['bg' => '#eafaf1', 'icon' => '⚽', 'color' => '#27ae60'],
                        'Food & Drink' => ['bg' => '#fdedec', 'icon' => '🍔', 'color' => '#e74c3c'],
                        'Learning' => ['bg' => '#f4ecf7', 'icon' => '📚', 'color' => '#8e44ad'],
                        'Entertainment' => ['bg' => '#fef9e7', 'icon' => '🎬', 'color' => '#f1c40f'],
                        'Business' => ['bg' => '#eaf2f8', 'icon' => '💼', 'color' => '#2980b9'],
                        'Wellness' => ['bg' => '#fdedec', 'icon' => '❤️', 'color' => '#e74c3c'],
                        'Travel & Culture' => ['bg' => '#e8f8f5', 'icon' => '🌍', 'color' => '#1abc9c'],
                        'Hobbies' => ['bg' => '#f5eef8', 'icon' => '🚗', 'color' => '#9b59b6'],
                        'Families' => ['bg' => '#fef9e7', 'icon' => '👨‍👩‍👧‍👦', 'color' => '#f39c12'],
                    ];
                @endphp
                @foreach($categories as $cat)
                    @php $info = $categoryIcons[$cat] ?? ['bg' => '#f0f0f0', 'icon' => '🌟', 'color' => '#667eea']; @endphp
                    <a href="{{ route('explore.category', $cat) }}" style="text-decoration: none; color: inherit;">
                        <div class="category-card">
                            <div class="category-icon" style="background: {{ $info['bg'] }}; box-shadow: 0 4px 12px {{ $info['color'] }}33;">
                                {{ $info['icon'] }}
                            </div>
                            <div class="category-name" style="color: {{ $info['color'] }};">{{ $cat }}</div>
                            <div class="category-count">Explore groups</div>
                        </div>
                    </a>
                @endforeach
                <a href="{{ route('groups') }}" style="text-decoration: none; color: inherit;">
                    <div class="category-card">
                        <div class="category-icon" style="background: #f0f0f0; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">🌟</div>
                        <div class="category-name" style="color: #667eea;">More Groups</div>
                        <div class="category-count">Browse all</div>
                    </div>
                </a>
            </div>
        </section>

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
                        <p>Browse and join groups based on your interests. Connect with people who share your passions.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">2️⃣</div>
                    <div class="card-content">
                        <h3 class="card-title">Find Events</h3>
                        <p>Discover upcoming events hosted by your groups. RSVP and meet new people in your community.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">3️⃣</div>
                    <div class="card-content">
                        <h3 class="card-title">Have Fun</h3>
                        <p>Attend events, network with others, and build meaningful connections.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h2 class="cta-title">Ready to find your community?</h2>
            <p class="cta-subtitle">Join thousands of people discovering new interests and making meaningful connections</p>
            @if(Auth::check())
                <a href="{{ route('profile') }}" class="btn" style="background: white; color: #667eea; display: inline-block;">View Your Profile</a>
            @else
                <a href="{{ route('auth.register') }}" class="btn" style="background: white; color: #667eea; display: inline-block; text-decoration: none;">Sign Up Today</a>
            @endif
        </section>
    </div>

    <footer>
        <div class="footer-container">
            <div class="footer-grid">
                <div class="footer-column"><h4>MEETUP</h4><ul><li><a href="#">About</a></li><li><a href="#">Blog</a></li><li><a href="#">Terms & Privacy</a></li><li><a href="#">Contact Us</a></li></ul></div>
                <div class="footer-column"><h4>GROUPS</h4><ul><li><a href="{{ route('groups') }}">Find Groups</a></li><li><a href="#">How to Organize</a></li><li><a href="#">Community Guidelines</a></li></ul></div>
                <div class="footer-column"><h4>EVENTS</h4><ul><li><a href="{{ route('events') }}">Find Events</a></li><li><a href="#">Popular Events</a></li><li><a href="#">Virtual Events</a></li></ul></div>
                <div class="footer-column"><h4>RESOURCES</h4><ul><li><a href="#">Help Center</a></li><li><a href="#">Accessibility</a></li><li><a href="#">Careers</a></li></ul></div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Meetup Clone. All rights reserved. | <a href="#" style="color:#999;">Privacy Policy</a> | <a href="#" style="color:#999;">Terms of Service</a></p>
            </div>
        </div>
    </footer>
</body>
</html>
