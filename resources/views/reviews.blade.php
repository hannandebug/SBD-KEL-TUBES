<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Meetup</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="{{ asset('js/app.js') }}"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease-in-out;
            backdrop-filter: blur(4px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px;
            position: relative;
            animation: slideUp 0.3s ease-in-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-btn {
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 28px;
            font-weight: bold;
            color: #999;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            color: #333;
        }

        .modal-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .modal-header h1 {
            font-size: 28px;
            color: #333;
            margin: 0 0 5px 0;
            font-weight: 600;
        }

        .modal-header p {
            color: #999;
            margin: 0;
            font-size: 14px;
        }

        .social-login {
            display: flex;
            gap: 12px;
            margin-bottom: 25px;
            justify-content: center;
        }

        .social-btn {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            background: white;
            cursor: pointer;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .social-btn.google {
            color: #DB4437;
        }

        .social-btn.facebook {
            color: #1877F2;
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
            color: #999;
            font-size: 12px;
        }

        .divider:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #e0e0e0;
            z-index: 0;
        }

        .divider span {
            background: white;
            padding: 0 10px;
            position: relative;
            z-index: 1;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-top: 10px;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .modal-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .modal-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }

        .modal-footer a:hover {
            text-decoration: underline;
        }

        .category-dropdown {
            position: relative;
            display: inline-block;
            padding-bottom: 20px;
            margin-bottom: -20px;
        }

        .category-dropdown-btn {
            padding: 6px 12px;
            background: #f0f0f0;
            border: none;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .category-dropdown-btn:hover {
            background: #667eea;
            color: white;
        }

        .category-dropdown-content {
            opacity: 0;
            visibility: hidden;
            position: absolute;
            background-color: white;
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 12px 0;
            z-index: 1;
            border-radius: 6px;
            top: 100%;
            left: 0;
            margin-top: 5px;
        }

        .category-dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 13px;
            transition: all 0.3s;
        }

        .category-dropdown-content a:hover {
            background-color: #f0f0f0;
            padding-left: 20px;
        }

        .category-dropdown:hover .category-dropdown-content,
        .category-dropdown.active .category-dropdown-content {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
        }

        .navbar-categories {
            display: flex;
            gap: 15px;
            margin-left: auto;
            margin-right: 30px;
        }
    </style>
</head>
<body>
    <!-- Header -->
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
                        <button class="category-dropdown-btn">
                            <i class="fas fa-th"></i> Categories
                        </button>
                        <div class="category-dropdown-content">
                            @php
                                $categories = \App\Models\Group::distinct('category')->pluck('category')->filter()->values();
                            @endphp
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
            <div class="modal-header">
                <h1>meetup</h1>
                <p>Login ke akun Anda</p>
            </div>

            <div class="social-login">
                <button class="social-btn google" title="Sign in with Google" onclick="alert('Google Sign-in Coming Soon!')">
                    <i class="fab fa-google"></i>
                </button>
                <button class="social-btn facebook" title="Sign in with Facebook" onclick="alert('Facebook Sign-in Coming Soon!')">
                    <i class="fab fa-facebook-f"></i>
                </button>
            </div>

            <div class="divider">
                <span>atau</span>
            </div>

            <form method="POST" action="{{ route('auth.login') }}">
                @csrf

                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input type="email" id="login-email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" required>
                </div>

                <button type="submit" class="submit-btn">Login</button>
            </form>

            <div class="modal-footer">
                Belum punya akun? <a onclick="switchToRegisterModal()">Daftar sekarang</a>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeRegisterModal()">&times;</button>
            <div class="modal-header">
                <h1>meetup</h1>
                <p>Buat akun baru</p>
            </div>

            <div class="social-login">
                <button class="social-btn google" title="Sign in with Google" onclick="alert('Google Sign-in Coming Soon!')">
                    <i class="fab fa-google"></i>
                </button>
                <button class="social-btn facebook" title="Sign in with Facebook" onclick="alert('Facebook Sign-in Coming Soon!')">
                    <i class="fab fa-facebook-f"></i>
                </button>
            </div>

            <div class="divider">
                <span>atau</span>
            </div>

            <form method="POST" action="{{ route('auth.register') }}">
                @csrf

                <div class="form-group">
                    <label for="register-name">Nama Lengkap</label>
                    <input type="text" id="register-name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="register-email">Email</label>
                    <input type="email" id="register-email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="register-password-confirm">Konfirmasi Password</label>
                    <input type="password" id="register-password-confirm" name="password_confirmation" required>
                </div>

                <div class="form-group">
                    <label for="register-city">Kota</label>
                    <input type="text" id="register-city" name="city" required>
                </div>

                <div class="form-group">
                    <label for="register-country">Negara</label>
                    <input type="text" id="register-country" name="country" required>
                </div>

                <button type="submit" class="submit-btn">Daftar</button>
            </form>

            <div class="modal-footer">
                Sudah punya akun? <a onclick="switchToLoginModal()">Login di sini</a>
            </div>
        </div>
    </div>

    <script>
        function openLoginModal() {
            document.getElementById('loginModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function openRegisterModal() {
            document.getElementById('registerModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function switchToLoginModal() {
            closeRegisterModal();
            openLoginModal();
        }

        function switchToRegisterModal() {
            closeLoginModal();
            openRegisterModal();
        }

        window.onclick = function(event) {
            let loginModal = document.getElementById('loginModal');
            let registerModal = document.getElementById('registerModal');
            
            if (event.target == loginModal) {
                closeLoginModal();
            }
            if (event.target == registerModal) {
                closeRegisterModal();
            }
        }
    </script>

    <!-- Main Content -->
    <div class="container">
        <section class="section">
            <div class="section-header">
                <h1 class="section-title">Reviews</h1>
                <p class="section-subtitle">See what people think about groups and events</p>
            </div>

            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 6px; margin-bottom: 20px;">{{ session('success') }}</div>
            @endif

            @if(Auth::check())
            <div style="background: white; padding: 25px; border-radius: 8px; border: 1px solid #e0e0e0; margin-bottom: 30px;">
                <h3 style="margin-bottom: 15px; font-size: 18px;">Tulis Review</h3>
                <form method="POST" action="{{ route('review.store') }}">
                    @csrf
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Rating</label>
                        <select name="rating_given" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px;">Komentar</label>
                        <textarea name="review_text" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; font-family: inherit;" placeholder="Tulis review Anda..."></textarea>
                    </div>
                    <button type="submit" style="padding: 10px 24px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">Kirim Review</button>
                </form>
            </div>
            @else
            <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center; margin-bottom: 30px;">
                <p style="color: #666;">Silakan <a href="{{ route('auth.login') }}" style="color: #667eea; font-weight: 600;">login</a> untuk menulis review.</p>
            </div>
            @endif

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

                    @if($review->review_text)
                    <p style="margin: 0; color: #333; font-size: 14px; line-height: 1.6;">
                        {{ $review->review_text }}
                    </p>
                    @else
                    <p style="margin: 0; color: #999; font-size: 13px; font-style: italic;">
                        No comment provided.
                    </p>
                    @endif
                </div>
                @endforeach
            </div>

            {{ $reviews->links('vendor.pagination.meetup') }}
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
