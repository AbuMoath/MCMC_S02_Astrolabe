<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Profile - AuthenticityHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            opacity: 0;
            animation: fadeIn 0.7s ease-in-out forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        /* Top Bar Styling */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #d2dbf6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 2rem;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.07);
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.3rem;
            color: #283d63;
            letter-spacing: 0.02em;
            margin-right: 2rem;
            margin-left: 0;
            position: absolute;
            left: 2rem;
        }

        /* User info in top bar - top right */
        .user-info-topbar {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .user-info-topbar .user-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #b9c8f6;
            margin-bottom: 0;
            margin-left: 0.7rem;
            background: #f3f4f6;
        }

        .user-info-topbar .user-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info-topbar .user-name {
            font-size: 1rem;
            color: #283d63;
            font-weight: 600;
            text-align: right;
            max-width: 120px;
            word-break: break-all;
        }

        /* Standardized Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #d2dbf6;
            box-shadow: 0 4px 15px rgba(40, 61, 99, 0.1);
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            z-index: 99;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 0 1.5rem;
            flex: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #283d63;
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            background: transparent;
        }

        .sidebar-link:hover {
            background: #b9c8f6;
            color: #0057ff;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: #b9c8f6;
            color: #0057ff;
            font-weight: 600;
        }

        .sidebar-link.logout-button {
            margin-top: auto;
            color: #e74c3c;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            font-family: inherit;
            font-size: 1rem;
        }

        .sidebar-link.logout-button:hover {
            background: #f8d7da;
            color: #c82333;
        }

        .sidebar-link i {
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
        }

        .form-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #283d63;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 1rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            color: #374151;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #0057ff;
            box-shadow: 0 0 0 3px rgba(0, 87, 255, 0.1);
            background: #fff;
        }

        .form-input[readonly] {
            background: #f3f4f6;
            color: #6b7280;
            cursor: not-allowed;
        }

        .btn-primary {
            background: #283d63;
            color: white;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: #1e2f54;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
            border-radius: 0.5rem;
            padding: 0.75rem 2rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: 600;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .avatar-wrapper {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .avatar-wrapper img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e5e7eb;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #e5eaf6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #6a7fd0;
            font-weight: 700;
            border: 3px solid #e5e7eb;
        }

        .avatar-edit-btn {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #4b5563;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s;
        }

        .avatar-edit-btn:hover {
            background: #f3f4f6;
            color: #283d63;
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
        @include('partials.user_area')
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('public.user.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i><span>Home</span>
            </a>
            <a href="{{ route('inquiries.index') }}" class="sidebar-link">
                <i class="fas fa-clipboard-list"></i><span>Inquiry List</span>
            </a>
            <a href="{{ route('submit.inquiry') }}" class="sidebar-link">
                <i class="fas fa-edit"></i><span>Submit Inquiry</span>
            </a>
            @auth
                <a href="{{ route('manage.profile') }}" class="sidebar-link active">
                    <i class="fas fa-user"></i><span>Manage Profile</span>
                </a>
            @endauth
            <div style="flex:1"></div>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="submit" class="sidebar-link logout-button">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="form-container">

            @if(session('status') || session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') ?? session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Personal Information</h2>

                <div class="profile-header">
                    <div class="avatar-wrapper">
                        @if(Auth::user()->UserProfilePicture)
                            <img src="{{ asset('storage/' . Auth::user()->UserProfilePicture) }}" alt="Profile Picture">
                        @else
                            <div class="avatar-placeholder">
                                {{ strtoupper(substr(Auth::user()->UserName, 0, 1)) }}
                            </div>
                        @endif
                        <label for="pic-input" class="avatar-edit-btn" title="Change photo">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" id="pic-input" name="UserProfilePicture" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">{{ Auth::user()->UserName }}</h3>
                        <p class="text-gray-500">{{ Auth::user()->UserEmail }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="UserName" class="form-label">Full Name</label>
                        <input type="text" id="UserName" name="UserName" class="form-input"
                               value="{{ old('UserName', Auth::user()->UserName) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="UserEmail" class="form-label">Email Address</label>
                        <input type="email" id="UserEmail" name="UserEmail" class="form-input"
                               value="{{ old('UserEmail', Auth::user()->UserEmail) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="UserPhoneNum" class="form-label">Phone Number</label>
                        <input type="tel" id="UserPhoneNum" name="UserPhoneNum" class="form-input"
                               value="{{ old('UserPhoneNum', Auth::user()->UserPhoneNum) }}" placeholder="e.g. 012-3456789">
                    </div>

                    <div class="form-group">
                        <label for="UserID" class="form-label">User ID</label>
                        <input type="text" id="UserID" class="form-input" value="{{ Auth::user()->UserID }}" readonly>
                    </div>
                </div>

                <div class="flex gap-4 mt-6">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>

            <hr class="my-8 border-gray-200">

            <h2 class="text-2xl font-bold text-gray-800 mb-4">Security</h2>
            <p class="text-gray-600 mb-4">Want to change your password? Verify your current password first.</p>
            
            <a href="{{ route('password.verify') }}" class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center gap-2"
               onclick="event.preventDefault(); document.getElementById('verify-form').submit();">
                <i class="fas fa-key"></i> Change Password
            </a>
            
            <form id="verify-form" method="POST" action="{{ route('password.verify') }}" class="hidden">
                @csrf
                <input type="hidden" name="current_password" value="">
            </form>
        </div>
    </main>

    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelectorAll('.avatar-placeholder, .avatar-wrapper img').forEach(el => {
                        if (el.tagName === 'IMG') {
                            el.src = e.target.result;
                        } else {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            el.parentNode.replaceChild(img, el);
                        }
                    });
                    document.querySelectorAll('.user-info-topbar .user-pic img').forEach(el => {
                        el.src = e.target.result;
                    });
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
