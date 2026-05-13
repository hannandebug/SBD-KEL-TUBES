<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groups - Meetup</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-container">
            <a href="{{ route('index') }}" class="logo">meetup</a>
            <ul class="header-nav">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li><a href="{{ route('groups') }}">Groups</a></li>
                <li><a href="{{ route('events') }}">Events</a></li>
                <li><a href="{{ route('reviews') }}">Reviews</a></li>
            </ul>
            <div class="header-buttons">
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <section class="section">
            <div class="section-header">
                <h1 class="section-title">Groups</h1>
                <p class="section-subtitle">Join groups and find your community</p>
            </div>

            @if(count($groups) > 0)
            <div class="grid">
                @foreach($groups as $group)
                <div class="card">
                    <div class="card-image" style="background-size: cover; background-position: center; background-image: url('{{ $group->photo_url }}');">
                        @if(!$group->group_photo)
                        {{ substr($group->group_name, 0, 1) }}
                        @endif
                    </div>
                    <div class="card-content">
                        <h3 class="card-title">{{ $group->group_name }}</h3>
                        <p class="card-subtitle">{{ $group->category ?? 'General Group' }}</p>
                        <p class="card-description" style="font-size: 13px; color: #666; margin: 10px 0;">{{ Str::limit($group->group_description, 100) }}</p>
                        <p class="card-meta">📍 {{ $group->city }}, {{ $group->country }}</p>
                        <p class="card-members">{{ $group->member_count }} members • ⭐ {{ number_format($group->average_rating, 1) }}</p>
                        @if($group->is_newgroup)
                        <span style="display: inline-block; background: #e74c3c; color: white; padding: 4px 8px; border-radius: 3px; font-size: 12px; margin-top: 8px;">NEW</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 40px; display: flex; justify-content: center; gap: 10px;">
                {{ $groups->links() }}
            </div>
            @else
            <p style="text-align: center; padding: 40px 0;">No groups found.</p>
            @endif
        </section>
    </div>

    <!-- Footer -->
    <footer style="background: #333; color: white; padding: 40px 20px; margin-top: 60px; text-align: center;">
        <p>&copy; 2026 Meetup Clone. All rights reserved.</p>
    </footer>
</body>
</html>
