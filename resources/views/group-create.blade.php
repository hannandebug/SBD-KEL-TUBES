<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group - Meetup</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .create-container { max-width: 600px; margin: 40px auto; padding: 0 20px; }
        .create-card { background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 40px; }
        .create-card h1 { font-size: 28px; font-weight: 700; margin-bottom: 8px; color: #333; }
        .create-card p { color: #666; font-size: 14px; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 14px; color: #333; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px 14px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
        .form-group input:focus, .form-group textarea:focus, .form-group select:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.1); }
        .submit-btn { width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 6px; font-size: 16px; font-weight: 600; cursor: pointer; transition: transform 0.2s; }
        .submit-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(102,126,234,0.3); }
        .back-link { display: inline-block; margin-bottom: 20px; color: #667eea; text-decoration: none; font-weight: 600; }
        .back-link:hover { text-decoration: underline; }
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
                <div class="header-buttons">
                    @if(Auth::check())
                        <a href="{{ route('profile') }}" style="margin-right: 15px; color: #333; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                            <span style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: inline-flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px;">
                                {{ substr(Auth::user()->member_name, 0, 1) }}
                            </span>
                            {{ Auth::user()->member_name }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #e74c3c; color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 14px;">Logout</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <div class="create-container">
        <a href="{{ route('groups') }}" class="back-link">← Back to Groups</a>
        <div class="create-card">
            <h1>Create a New Group</h1>
            <p>Start a community around your interests</p>

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('group.store') }}">
                @csrf
                <div class="form-group">
                    <label>Group Name</label>
                    <input type="text" name="group_name" value="{{ old('group_name') }}" required placeholder="e.g. Jakarta Photography Club">
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="group_description" rows="4" required placeholder="Tell people what your group is about...">{{ old('group_description') }}</textarea>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" @if(old('category') == $cat) selected @endif>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" value="{{ old('city') }}" required placeholder="e.g. Jakarta">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" value="{{ old('country') }}" required placeholder="e.g. Indonesia">
                </div>
                <div class="form-group">
                    <label>Photo URL (optional)</label>
                    <input type="url" name="group_photo" value="{{ old('group_photo') }}" placeholder="https://example.com/photo.jpg">
                </div>
                <button type="submit" class="submit-btn">Create Group</button>
            </form>
        </div>
    </div>

    <footer style="background: #333; color: white; padding: 40px 20px; margin-top: 60px; text-align: center;">
        <p>&copy; 2026 Meetup Clone. All rights reserved.</p>
    </footer>
</body>
</html>
