<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Meetup</title>
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
                <h1 class="section-title">Reviews</h1>
                <p class="section-subtitle">See what people think about groups and events</p>
            </div>

            @if(count($reviews) > 0)
            <div style="display: grid; gap: 20px;">
                @foreach($reviews as $review)
                <div style="background: white; padding: 20px; border-radius: 8px; border: 1px solid #e0e0e0;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                        <div>
                            <p style="margin: 0; font-weight: 500; font-size: 16px; color: #333;">
                                {{ $review->member->member_name ?? 'Anonymous' }}
                            </p>
                            <p style="margin: 4px 0 0 0; color: #999; font-size: 14px;">
                                {{ $review->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 16px; margin-bottom: 4px;">
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < ($review->rating_given ?? 0))
                                    ⭐
                                    @else
                                    ☆
                                    @endif
                                @endfor
                            </div>
                            <p style="margin: 0; color: #e74c3c; font-weight: 500; font-size: 14px;">
                                {{ $review->rating_given ?? 0 }}/5
                            </p>
                        </div>
                    </div>
                    
                    @if($review->event)
                    <p style="margin: 0 0 8px 0; color: #666; font-size: 14px;">
                        <strong>Event:</strong> {{ $review->event->event_title }}
                    </p>
                    @endif

                    @if($review->group)
                    <p style="margin: 0 0 8px 0; color: #666; font-size: 14px;">
                        <strong>Group:</strong> {{ $review->group->group_name }}
                    </p>
                    @endif

                    <p style="margin: 0; color: #333; font-size: 14px; line-height: 1.6;">
                        {{ $review->event->event_description ?? $review->group->group_description ?? 'Great experience!' }}
                    </p>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 40px; display: flex; justify-content: center; gap: 10px;">
                {{ $reviews->links() }}
            </div>
            @else
            <p style="text-align: center; padding: 40px 0;">No reviews found.</p>
            @endif
        </section>
    </div>

    <!-- Footer -->
    <footer style="background: #333; color: white; padding: 40px 20px; margin-top: 60px; text-align: center;">
        <p>&copy; 2026 Meetup Clone. All rights reserved.</p>
    </footer>
</body>
</html>
