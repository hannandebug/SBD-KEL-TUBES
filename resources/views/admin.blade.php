<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Meetup</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); text-align: center; }
        .stat-number { font-size: 36px; font-weight: 700; color: #667eea; }
        .stat-label { font-size: 14px; color: #666; margin-top: 8px; }
        .admin-section { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-bottom: 30px; padding: 25px; }
        .admin-section h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; border-bottom: 2px solid #667eea; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; font-size: 14px; }
        th { background: #f8f9fa; font-weight: 600; color: #333; }
        tr:hover { background: #f8f9fa; }
        .edit-form { display: none; margin-top: 10px; padding: 15px; background: #f8f9fa; border-radius: 6px; }
        .edit-form.show { display: block; }
        .edit-form input, .edit-form textarea, .edit-form select { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 13px; }
        .btn-sm { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 600; }
        .btn-edit { background: #3498db; color: white; }
        .btn-delete { background: #e74c3c; color: white; }
        .btn-save { background: #27ae60; color: white; }
        .btn-cancel { background: #95a5a6; color: white; }
        .rank-badge { display: inline-block; width: 24px; height: 24px; border-radius: 50%; background: #f39c12; color: white; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700; }
        .rank-1 { background: #f39c12; }
        .rank-2 { background: #95a5a6; }
        .rank-3 { background: #cd7f32; }
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
                <li><a href="{{ route('admin.index') }}" style="color: #e74c3c; font-weight: 700;">Admin</a></li>
            </ul>
            <div class="header-right">
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

    <div class="admin-container">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px;">{{ session('success') }}</div>
        @endif

        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px; flex-wrap: wrap;">
            <h1 style="font-size: 32px; font-weight: 700; margin: 0;">Admin Dashboard</h1>
            <form method="GET" action="{{ route('admin.index') }}" style="display: flex; align-items: center; gap: 10px; margin-left: auto; flex-wrap: wrap;">
                <label style="font-size: 14px; font-weight: 600; color: #555;">Show top</label>
                <input type="number" name="limit" value="{{ $limit }}" min="1" max="999" style="padding: 8px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; width: 80px;">
                <span style="font-size: 14px; color: #666;">rankings</span>
                <button type="submit" style="padding: 8px 20px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600;">Apply</button>
            </form>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_members'] }}</div>
                <div class="stat-label">Total Members</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_groups'] }}</div>
                <div class="stat-label">Total Groups</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_events'] }}</div>
                <div class="stat-label">Total Events</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_reviews'] }}</div>
                <div class="stat-label">Total Reviews</div>
            </div>
        </div>

        <div class="admin-section">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
                <h2 style="font-size: 20px; font-weight: 700; border-bottom: 2px solid #667eea; padding-bottom: 10px; margin: 0;">🏆 Top {{ $limit }} Members (Most Groups Joined)</h2>
                <form method="GET" action="{{ route('admin.index') }}" style="display: flex; align-items: center; gap: 8px; margin-left: auto;">
                    <input type="hidden" name="limit" value="{{ $limit }}">
                    <input type="hidden" name="sort_rated" value="{{ $sortRated }}">
                    <input type="hidden" name="sort_most" value="{{ $sortMost }}">
                    <label style="font-size: 13px; font-weight: 600; color: #555;">Sort by</label>
                    <select name="sort_members" onchange="this.form.submit()" style="padding: 6px 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; cursor: pointer; background: white;">
                        <option value="member_gr_count" @if($sortMembers == 'member_gr_count') selected @endif>Groups Joined</option>
                        <option value="member_ev_count" @if($sortMembers == 'member_ev_count') selected @endif>Events Attended</option>
                        <option value="member_name" @if($sortMembers == 'member_name') selected @endif>Name</option>
                    </select>
                </form>
            </div>
            <table>
                <thead><tr><th>Rank</th><th>Name</th><th>Email</th><th>Groups Joined</th><th>Events Attended</th></tr></thead>
                <tbody>
                @forelse($topMembers as $i => $member)
                    <tr>
                        <td><span class="rank-badge rank-{{ $i < 3 ? $i+1 : '' }}">{{ $i+1 }}</span></td>
                        <td><a href="{{ route('profile.id', $member->id_member) }}" style="color: #667eea; text-decoration: none;">{{ $member->member_name }}</a></td>
                        <td>{{ $member->member_email }}</td>
                        <td>{{ $member->member_gr_count }}</td>
                        <td>{{ $member->member_ev_count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;">No members found</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
                <h2 style="font-size: 20px; font-weight: 700; border-bottom: 2px solid #667eea; padding-bottom: 10px; margin: 0;">⭐ Top {{ $limit }} Highest Rated Groups</h2>
                <form method="GET" action="{{ route('admin.index') }}" style="display: flex; align-items: center; gap: 8px; margin-left: auto;">
                    <input type="hidden" name="limit" value="{{ $limit }}">
                    <input type="hidden" name="sort_members" value="{{ $sortMembers }}">
                    <input type="hidden" name="sort_most" value="{{ $sortMost }}">
                    <label style="font-size: 13px; font-weight: 600; color: #555;">Sort by</label>
                    <select name="sort_rated" onchange="this.form.submit()" style="padding: 6px 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; cursor: pointer; background: white;">
                        <option value="average_rating" @if($sortRated == 'average_rating') selected @endif>Rating</option>
                        <option value="member_count" @if($sortRated == 'member_count') selected @endif>Members</option>
                        <option value="group_name" @if($sortRated == 'group_name') selected @endif>Name</option>
                    </select>
                </form>
            </div>
            <table>
                <thead><tr><th>Rank</th><th>Group</th><th>Rating</th><th>Members</th><th>Category</th></tr></thead>
                <tbody>
                @forelse($topRated as $i => $group)
                    <tr>
                        <td><span class="rank-badge rank-{{ $i < 3 ? $i+1 : '' }}">{{ $i+1 }}</span></td>
                        <td><a href="{{ route('group.detail', $group->id_group) }}" style="color: #667eea; text-decoration: none;">{{ $group->group_name }}</a></td>
                        <td>⭐ {{ number_format($group->average_rating, 1) }}</td>
                        <td>{{ $group->member_count }}</td>
                        <td>{{ $group->category }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;">No groups found</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
                <h2 style="font-size: 20px; font-weight: 700; border-bottom: 2px solid #667eea; padding-bottom: 10px; margin: 0;">👥 Top {{ $limit }} Most Members Groups</h2>
                <form method="GET" action="{{ route('admin.index') }}" style="display: flex; align-items: center; gap: 8px; margin-left: auto;">
                    <input type="hidden" name="limit" value="{{ $limit }}">
                    <input type="hidden" name="sort_members" value="{{ $sortMembers }}">
                    <input type="hidden" name="sort_rated" value="{{ $sortRated }}">
                    <label style="font-size: 13px; font-weight: 600; color: #555;">Sort by</label>
                    <select name="sort_most" onchange="this.form.submit()" style="padding: 6px 10px; border: 1px solid #ddd; border-radius: 6px; font-size: 13px; cursor: pointer; background: white;">
                        <option value="member_count" @if($sortMost == 'member_count') selected @endif>Members</option>
                        <option value="average_rating" @if($sortMost == 'average_rating') selected @endif>Rating</option>
                        <option value="group_name" @if($sortMost == 'group_name') selected @endif>Name</option>
                    </select>
                </form>
            </div>
            <table>
                <thead><tr><th>Rank</th><th>Group</th><th>Members</th><th>Rating</th><th>Category</th></tr></thead>
                <tbody>
                @forelse($mostMembers as $i => $group)
                    <tr>
                        <td><span class="rank-badge rank-{{ $i < 3 ? $i+1 : '' }}">{{ $i+1 }}</span></td>
                        <td><a href="{{ route('group.detail', $group->id_group) }}" style="color: #667eea; text-decoration: none;">{{ $group->group_name }}</a></td>
                        <td>{{ $group->member_count }}</td>
                        <td>⭐ {{ number_format($group->average_rating, 1) }}</td>
                        <td>{{ $group->category }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;">No groups found</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-section">
            <h2>✏️ Manage Groups (Edit/Delete)</h2>
            <table>
                <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>Members</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach($groups as $group)
                    <tr>
                        <td>{{ $group->id_group }}</td>
                        <td>{{ $group->group_name }}</td>
                        <td>{{ $group->category }}</td>
                        <td>{{ $group->member_count }}</td>
                        <td>
                            <button class="btn-sm btn-edit" onclick="toggleEdit('group-{{ $group->id_group }}')">✏️ Edit</button>
                            <form method="POST" action="{{ route('admin.group.delete', $group->id_group) }}" style="display: inline;" onsubmit="return confirm('Delete this group?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm btn-delete">🗑️ Delete</button>
                            </form>
                            <div id="group-{{ $group->id_group }}" class="edit-form">
                                <form method="POST" action="{{ route('admin.group.update', $group->id_group) }}">
                                    @csrf @method('PUT')
                                    <input type="text" name="group_name" value="{{ $group->group_name }}" placeholder="Group Name">
                                    <textarea name="group_description" placeholder="Description" rows="2">{{ $group->group_description }}</textarea>
                                    <input type="text" name="category" value="{{ $group->category }}" placeholder="Category">
                                    <input type="text" name="city" value="{{ $group->city }}" placeholder="City">
                                    <input type="text" name="country" value="{{ $group->country }}" placeholder="Country">
                                    <input type="text" name="group_photo" value="{{ $group->group_photo }}" placeholder="Photo URL">
                                    <div style="display:flex;gap:10px;">
                                        <button type="submit" class="btn-sm btn-save">💾 Save</button>
                                        <button type="button" class="btn-sm btn-cancel" onclick="toggleEdit('group-{{ $group->id_group }}')">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="margin-top: 20px;">{{ $groups->links('vendor.pagination.meetup') }}</div>
        </div>

        <div class="admin-section">
            <h2>✏️ Manage Events (Edit/Delete)</h2>
            <table>
                <thead><tr><th>ID</th><th>Title</th><th>Type</th><th>Date</th><th>RSVPs</th><th>Actions</th></tr></thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $event->id_event }}</td>
                        <td>{{ $event->event_title }}</td>
                        <td>{{ $event->event_type }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</td>
                        <td>{{ $event->total_rsvps }}</td>
                        <td>
                            <button class="btn-sm btn-edit" onclick="toggleEdit('event-{{ $event->id_event }}')">✏️ Edit</button>
                            <form method="POST" action="{{ route('admin.event.delete', $event->id_event) }}" style="display: inline;" onsubmit="return confirm('Delete this event?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm btn-delete">🗑️ Delete</button>
                            </form>
                            <div id="event-{{ $event->id_event }}" class="edit-form">
                                <form method="POST" action="{{ route('admin.event.update', $event->id_event) }}">
                                    @csrf @method('PUT')
                                    <input type="text" name="event_title" value="{{ $event->event_title }}" placeholder="Event Title">
                                    <textarea name="event_description" placeholder="Description" rows="2">{{ $event->event_description }}</textarea>
                                    <select name="event_type"><option value="online" @if($event->event_type == 'online') selected @endif>Online</option><option value="in_person" @if($event->event_type == 'in_person') selected @endif>In Person</option></select>
                                    <input type="datetime-local" name="event_date" value="{{ \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i') }}">
                                    <input type="text" name="venue_name" value="{{ $event->venue_name }}" placeholder="Venue">
                                    <input type="text" name="venue_city" value="{{ $event->venue_city }}" placeholder="City">
                                    <input type="text" name="venue_country" value="{{ $event->venue_country }}" placeholder="Country">
                                    <input type="text" name="event_photo" value="{{ $event->event_photo }}" placeholder="Photo URL">
                                    <div style="display:flex;gap:10px;">
                                        <button type="submit" class="btn-sm btn-save">💾 Save</button>
                                        <button type="button" class="btn-sm btn-cancel" onclick="toggleEdit('event-{{ $event->id_event }}')">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="margin-top: 20px;">{{ $events->links('vendor.pagination.meetup') }}</div>
        </div>
    </div>

    <script>
        function toggleEdit(id) {
            document.getElementById(id).classList.toggle('show');
        }
    </script>

    <footer style="background: #333; color: white; padding: 40px 20px; margin-top: 60px; text-align: center;">
        <p>&copy; 2026 Meetup Clone. All rights reserved.</p>
    </footer>
</body>
</html>
