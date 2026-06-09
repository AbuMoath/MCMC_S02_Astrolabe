<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile-card {
            background: rgba(238, 242, 255, 0.9);
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            max-width: 600px;
            width: 100%;
            box-sizing: border-box;
            backdrop-filter: blur(10px);
            text-align: center;
            opacity: 0;
            animation: slideInUp 0.8s ease-out forwards 0.3s;
            transition: all 0.4s ease;
        }

        .profile-card:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
        }

        .profile-header {
            color: #283d63;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 2px dashed #ccc;
            margin: 0 auto 1.5rem;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            transition: all 0.5s ease;
            animation: pulse 2s ease-in-out infinite;
        }

        .profile-picture:hover {
            transform: scale(1.05);
            border-color: #4f8cff;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
            opacity: 0;
            animation: slideInUp 0.5s ease-out forwards;
            animation-delay: calc(var(--animation-order) * 0.1s + 0.5s);
        }

        .form-group label {
            font-weight: 600;
            color: #283d63;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-group input {
            width: 100%;
            padding: 0.8rem;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            transform: scale(1.02);
            border-color: #4f8cff;
            box-shadow: 0 0 10px rgba(79, 140, 255, 0.3);
        }

        .btn-save {
            background: linear-gradient(145deg, #d1d9f0, #a6b1d7);
            border-radius: 0.75rem;
            box-shadow: 4px 4px 8px #9badcd, -4px -4px 8px #ffffff;
            color: #283d63;
            font-weight: 600;
            padding: 1rem 2rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards 1.2s;
        }

        .btn-save:hover {
            background: linear-gradient(145deg, #c3cbea, #9badcd);
            box-shadow: 2px 2px 6px #8a9ac4, -2px -2px 6px #e5eaf8;
            transform: translateY(-2px);
        }

        .btn-save:active {
            transform: translateY(1px) scale(0.98);
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

        .top-bar .search-container {
            flex: 1 1 500px;
            max-width: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 180px;
        }

        .top-bar .search-container input {
            width: 100%;
            max-width: 500px;
            padding: 0.5rem 1.2rem;
            border-radius: 30px;
            border: none;
            background: #f4f7fd;
            color: #283d63;
            font-size: 1rem;
            box-shadow: 0 2px 8px #c3d2f7 inset;
            outline: none;
        }

        .top-bar nav {
            margin-left: 2rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            position: absolute;
            right: 2rem;
        }

        .top-bar nav a {
            color: #283d63;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .top-bar nav a:hover {
            color: #0057ff;
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

        .sidebar-link.back-button {
            background: #b9c8f6;
            color: #0057ff;
            margin-bottom: 1rem;
        }

        .sidebar-link.logout-button {
            margin-top: auto;
            color: #e74c3c;
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
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Standardized Button Styles */
        .btn-save {
            background: linear-gradient(145deg, #d1d9f0, #a6b1d7);
            border-radius: 0.75rem;
            box-shadow: 4px 4px 8px #9badcd, -4px -4px 8px #ffffff;
            color: #283d63;
            font-weight: 600;
            padding: 1rem 2rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .btn-save:hover {
            background: linear-gradient(145deg, #c3cbea, #9badcd);
            box-shadow: 2px 2px 6px #8a9ac4, -2px -2px 6px #e5eaf8;
            transform: translateY(-2px);
        }

        .btn-save:active {
            transform: translateY(1px) scale(0.98);
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

        /* Animation Keyframes */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Page Load Animation */
        body {
            opacity: 0;
            animation: fadeIn 0.8s ease-in-out forwards;
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
        <div class="search-container">
            <input type="text" placeholder="Search...">
        </div>
        @include('partials.user_area')
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ url()->previous() !== request()->url() && url()->previous() !== '' ? url()->previous() : route('home') }}" class="sidebar-link btn-back"><i class="fas fa-arrow-left"></i> <span>Back</span></a>
            <a href="#" class="sidebar-link active"><i class="fas fa-user"></i> <span>Profile</span></a>
            <a href="#" class="sidebar-link"><i class="fas fa-cog"></i> <span>Settings</span></a>
            <a href="{{ route('password.edit') }}" class="sidebar-link"><i class="fas fa-shield-alt"></i> <span>Security</span></a>

            <div style="flex:1"></div>
            <a href="{{ route('login') }}" class="sidebar-link exit-link"><i class="fas fa-sign-out-alt"></i> <span>Exit</span></a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="profile-card">
            <!-- Success Message -->
            @if (session('status'))
                <div class="alert alert-success" style="color: green; margin-bottom: 1rem;">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Circular Profile Picture -->
            <div class="profile-picture">
                @if (Auth::user()->UserProfilePicture)
                    <img id="profilePicPreview" src="{{ asset('storage/' . Auth::user()->UserProfilePicture) }}"
                        alt="Profile Picture">
                @else
                    <img id="profilePicPreview"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->UserName) }}&background=cccccc&color=555555"
                        alt="Profile Picture">
                @endif
            </div>

            <h2 class="profile-header">Manage Your Profile</h2>

            @if(session('status'))
                <div style="background: #10b981; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #ef4444; color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group" style="--animation-order: 1">
                    <label for="UserName">Name</label>
                    <input type="text" name="UserName" id="UserName" value="{{ old('UserName', Auth::user()->UserName) }}"
                        required />
                    @error('UserName')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="--animation-order: 2">
                    <label for="UserEmail">Email Address</label>
                    <input type="email" name="UserEmail" id="UserEmail" value="{{ old('UserEmail', Auth::user()->UserEmail) }}"
                        required />
                    @error('UserEmail')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="--animation-order: 3">
                    <label for="UserPhoneNum">Phone Number</label>
                    <input type="text" name="UserPhoneNum" id="UserPhoneNum"
                        value="{{ old('UserPhoneNum', Auth::user()->UserPhoneNum) }}" />
                    @error('UserPhoneNum')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" style="--animation-order: 4">
                    <label for="UserProfilePicture">Profile Picture</label>
                    <input type="file" name="UserProfilePicture" id="UserProfilePicture" accept="image/*" />
                    @error('UserProfilePicture')
                        <div style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-save">Save Changes</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('UserProfilePicture');
            const preview = document.getElementById('profilePicPreview');

            // Profile picture preview animation
            input.addEventListener('change', function(e) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.style.opacity = '0';
                        setTimeout(() => {
                            preview.src = e.target.result;
                            preview.style.opacity = '1';
                            preview.style.transition = 'opacity 0.5s ease';
                        }, 300);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });

            // Form submission animation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                if (!form.checkValidity()) return;

                const submitBtn = this.querySelector('.btn-save');
                const originalText = submitBtn.innerText;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                submitBtn.style.pointerEvents = 'none';
            });

            // Add animation to success message if present
            const alertSuccess = document.querySelector('.alert-success');
            if (alertSuccess) {
                setTimeout(() => {
                    alertSuccess.style.opacity = '0';
                    alertSuccess.style.transition = 'opacity 0.5s ease';
                }, 3000);
            }
        });
    </script>
</body>

</html>
