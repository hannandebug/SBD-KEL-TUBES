<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $group->group_name }} - Album</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .album-container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .album-header { margin-bottom: 30px; }
        .album-header h1 { font-size: 28px; color: #333; }
        .album-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; }
        .album-item { border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); transition: transform 0.3s; }
        .album-item:hover { transform: scale(1.03); }
        .album-item img { width: 100%; height: 200px; object-fit: cover; display: block; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #667eea; text-decoration: none; font-weight: 600; }
        .back-link:hover { text-decoration: underline; }
        .empty-state { text-align: center; padding: 80px 20px; color: #999; }
        .empty-state i { font-size: 64px; margin-bottom: 20px; color: #ddd; }
    </style>
</head>
<body>
    <div class="album-container">
        <a href="{{ route('group.detail', $group->id_group) }}" class="back-link">← Kembali ke {{ $group->group_name }}</a>
        <div class="album-header">
            <h1>📸 {{ $group->group_name }} - Photo Album</h1>
            <p style="color: #666;">{{ count($albumPhotos) }} photos</p>
        </div>
        @if(count($albumPhotos) > 0)
        <div class="album-grid">
            @foreach($albumPhotos as $photo)
            <div class="album-item">
                <img src="{{ $photo }}" alt="Album photo" onerror="this.parentElement.innerHTML='<div style=\'height:200px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;color:#999;\'><i class=\'fas fa-image\' style=\'font-size:48px;\'></i></div>'">
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-image"></i>
            <h2>No Photos Yet</h2>
            <p>This group hasn't uploaded any photos yet.</p>
        </div>
        @endif
    </div>
    <footer style="background: #333; color: white; padding: 40px 20px; margin-top: 60px; text-align: center;">
        <p>&copy; 2026 Meetup Clone. All rights reserved.</p>
    </footer>
</body>
</html>
