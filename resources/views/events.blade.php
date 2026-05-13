<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events - Meetup</title>
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
                <h1 class="section-title">Events</h1>
                <p class="section-subtitle">Find and join events happening near you</p>
            </div>

            @if(count($events) > 0)
            <div style="display: grid; gap: 20px;">
                @foreach($events as $event)
                <a href="{{ route('event.detail', ['id' => $event->id_event]) }}" style="text-decoration: none; color: inherit;">
                    <div style="background: white; padding: 0; border-radius: 8px; display: grid; grid-template-columns: 200px 1fr; gap: 0; border: 1px solid #e0e0e0; transition: all 0.3s ease; overflow: hidden;">
                        <div style="height: 150px; background-image: url('{{ $event->photo_url }}'); background-size: cover; background-position: center; position: relative;">
                            <div style="position: absolute; top: 10px; right: 10px; background: rgba(231, 76, 60, 0.9); color: white; padding: 8px 12px; border-radius: 6px; text-align: center; min-width: 60px;">
                                <div style="font-size: 18px; font-weight: bold;">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                                <div style="font-size: 11px;">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                            </div>
                        </div>
                        <div style="padding: 20px;">
                            <h3 style="margin: 0 0 8px 0; font-size: 18px; color: #333;">{{ $event->event_title }}</h3>
                            <p style="margin: 0 0 5px 0; color: #666; font-size: 14px;">{{ $event->group->group_name ?? 'Event' }}</p>
                            <p style="margin: 0 0 5px 0; color: #666; font-size: 14px;">📍 {{ $event->venue_name }}, {{ $event->venue_city }}, {{ $event->venue_country }}</p>
                            <p style="margin: 0 0 5px 0; color: #666; font-size: 14px;">Type: {{ $event->event_type }}</p>
                            <p style="margin: 0; color: #e74c3c; font-size: 14px; font-weight: 500;">{{ $event->total_rsvps }} people going</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 40px; display: flex; justify-content: center; gap: 10px;">
                {{ $events->links() }}
            </div>
            @else
            <p style="text-align: center; padding: 40px 0;">No events found.</p>
            @endif
        </section>
    </div>

    <!-- Footer -->
    <footer style="background: #333; color: white; padding: 40px 20px; margin-top: 60px; text-align: center;">
        <p>&copy; 2026 Meetup Clone. All rights reserved.</p>
    </footer>
</body>
</html>
