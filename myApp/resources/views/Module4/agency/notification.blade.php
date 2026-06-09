<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Notifications - AuthenticityHub Agency</title>
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

        /* Sidebar Styling */
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

        .sidebar-link i {
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
        }

        .content-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
            max-width: 800px;
            margin: 0 auto;
        }

        .page-title {
            color: #283d63;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .notification-item {
            background: #f8f9ff;
            border-left: 4px solid #4f8cff;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            background: #f0f4ff;
            transform: translateX(4px);
        }

        .notification-title {
            color: #283d63;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .notification-status {
            color: #0057ff;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .notification-date {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .no-notifications {
            text-align: center;
            color: #6b7280;
            font-style: italic;
            padding: 2rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-investigation {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-verified {
            background: #d1fae5;
            color: #065f46;
        }

        .status-false {
            background: #fee2e2;
            color: #991b1b;
        }

        /* User info in top bar */
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
            margin-left: 0.7rem;
            background: #f3f4f6;
        }

        .user-info-topbar .user-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }        .user-info-topbar .user-name {
            font-size: 1rem;
            color: #283d63;
            font-weight: 600;
            text-align: right;
            max-width: 120px;
            word-break: break-all;
        }

        /* Navigation buttons */
        .nav-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .nav-btn {
            background: linear-gradient(145deg, #d1d9f0, #a6b1d7);
            border-radius: 0.75rem;
            box-shadow: 4px 4px 8px #9badcd, -4px -4px 8px #ffffff;
            color: #283d63;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .nav-btn:hover {
            background: linear-gradient(145deg, #c3cbea, #9badcd);
            box-shadow: 2px 2px 6px #8a9ac4, -2px -2px 6px #e5eaf8;
            transform: translateY(-2px);
        }

        .nav-btn:active {
            transform: translateY(1px) scale(0.98);
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub Agency</div>
        <div class="search-container">
            <input type="text" placeholder="Search...">
        </div>        @include('partials.user_area')
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('agency.home') }}" class="sidebar-link">
                <i class="fas fa-arrow-left"></i> <span>Back</span>
            </a>
            <a href="{{ route('agency.profile') }}" class="sidebar-link">
                <i class="fas fa-user"></i> <span>Profile</span>
            </a>
            <a href="#" class="sidebar-link">
                <i class="fas fa-cog"></i> <span>Settings</span>
            </a>
            <a href="{{ route('agency.security') }}" class="sidebar-link">
                <i class="fas fa-shield-alt"></i> <span>Security</span>
            </a>
            <div style="flex:1"></div>
            <a href="{{ route('login') }}" class="sidebar-link">
                <i class="fas fa-sign-out-alt"></i> <span>Exit</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">        <div class="content-card">
            <h1 class="page-title">Notifications</h1>

            @if(session('error'))
                <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #dc2626;">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('message'))
                <div style="background: #dbeafe; color: #1e40af; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; border-left: 4px solid #3b82f6;">
                    <i class="fas fa-info-circle"></i> {{ session('message') }}
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="nav-buttons">
                <a href="{{ route('agency.view.display.inquiry') }}" class="nav-btn">
                    <i class="fas fa-list"></i>
                    View Inquiry List
                </a>
                            </div>

            @if(isset($notifications) && $notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="notification-item {{ !$notification->is_read ? 'unread' : '' }}">
                        @if($notification->type == 'inquiry_assigned')
                            {{-- Inquiry Assigned by Admin --}}
                            <div class="notification-title">
                                <i class="fas fa-inbox" style="color: #10b981; margin-right: 0.5rem;"></i>
                                {{ $notification->title }}
                            </div>
                            <div class="notification-status">
                                {{ $notification->message }}
                            </div>
                            <div class="notification-date">
                                Assigned: {{ $notification->created_at->format('M j, Y \a\t g:i A') }}
                            </div>

                        @elseif($notification->type == 'status_update' || $notification->type == 'inquiry_update')
                            {{-- Inquiry Status Update --}}
                            <div class="notification-title">
                                <i class="fas fa-info-circle" style="color: #3b82f6; margin-right: 0.5rem;"></i>
                                {{ $notification->title }}
                            </div>
                            <div class="notification-status">
                                {{ $notification->message }}
                            </div>
                            <div class="notification-date">
                                Updated: {{ $notification->created_at->format('M j, Y \a\t g:i A') }}
                            </div>

                        @elseif($notification->type == 'agency_note')
                            {{-- Agency Note --}}
                            <div class="notification-title">
                                <i class="fas fa-sticky-note" style="color: #f59e0b; margin-right: 0.5rem;"></i>
                                {{ $notification->title }}
                            </div>
                            <div style="color: #4b5563; margin-top: 0.5rem;">
                                <strong>Regarding:</strong> {{ $notification->inquiry->InquiryTitle ?? 'Inquiry #' . $notification->inquiry_id }}
                            </div>
                            <div style="color: #374151; margin-top: 0.75rem; background: #f9fafb; padding: 1rem; border-radius: 0.5rem; border-left: 4px solid #f59e0b;">
                                {{ $notification->message }}
                            </div>
                            <div class="notification-date">
                                Sent: {{ $notification->created_at->format('M j, Y \a\t g:i A') }}
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="no-notifications">
                    <i class="fas fa-bell-slash" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                    <p>No notifications yet.</p>
                    <p>You'll see updates here when the status of your inquiries changes or when agencies send you notes.</p>
                </div>
            @endif
        </div>
    </div>
</body>

</html>
