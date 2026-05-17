<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Groups - Meetup</title>
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
        .search-filter-container { background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 30px; }
        .filter-row { display: flex; gap: 15px; flex-wrap: wrap; align-items: center; }
        .filter-group { display: flex; gap: 10px; align-items: center; }
        .filter-group label { font-weight: 600; color: #333; font-size: 14px; }
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

    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 30px 20px;">
        <div class="section-header" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; margin-bottom: 30px;">
            <div>
                <h2 class="section-title" style="display: flex; align-items: center; gap: 12px;">
                    My Joined Groups
                    <span style="font-size: 14px; background: #667eea; color: white; padding: 4px 12px; border-radius: 20px; font-weight: 600;">
                        {{ $groups->total() }}
                    </span>
                </h2>
                <p class="section-subtitle">Groups you are a member of</p>
            </div>
            <a href="{{ route('groups') }}" style="padding: 10px 24px; background: #667eea; color: white; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none;">Browse All Groups</a>
        </div>

        @if(count($groups) > 0)
        <div class="grid">
            @foreach($groups as $group)
            <div class="card">
                <a href="{{ route('group.detail', $group->id_group) }}" style="text-decoration: none; color: inherit;">
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
                        @if($group->pivot && $group->pivot->role)
                        <span style="display: inline-block; background: #3498db; color: white; padding: 2px 8px; border-radius: 3px; font-size: 11px; margin-top: 6px;">
                            {{ ucfirst(str_replace('_', ' ', $group->pivot->role)) }}
                        </span>
                        @endif
                        <div style="display: flex; gap: 10px; margin-top: 15px;">
                            <a href="{{ route('group.detail', $group->id_group) }}" style="flex: 1; padding: 8px 12px; background: #667eea; color: white; text-decoration: none; border-radius: 4px; text-align: center; font-size: 13px; font-weight: 600;">Lihat Detail</a>
                            <form method="POST" action="{{ route('group.leave', $group->id_group) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" style="width: 100%; padding: 8px 12px; background: #e74c3c; color: white; border: none; border-radius: 4px; font-size: 13px; font-weight: 600; cursor: pointer;">Keluar</button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        {{ $groups->links('vendor.pagination.meetup') }}
        @else
        <div style="text-align: center; padding: 60px 20px; background: #f8f9fa; border-radius: 12px;">
            <div style="font-size: 64px; margin-bottom: 20px;">👥</div>
            <h3 style="color: #333; margin-bottom: 10px;">Belum Bergabung dengan Grup</h3>
            <p style="color: #666; margin-bottom: 20px;">Mulai bergabung dengan grup untuk melihatnya di sini.</p>
            <a href="{{ route('groups') }}" style="padding: 12px 28px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block;">Cari Grup</a>
        </div>
        @endif
    </div>

    <footer style="background: #333; color: white; padding: 40px 20px; margin-top: 60px; text-align: center;">
        <p>&copy; 2026 Meetup Clone. All rights reserved.</p>
    </footer>
</body>
</html>