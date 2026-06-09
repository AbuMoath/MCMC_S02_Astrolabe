{{--
Module 4: Admin - Notification List Page
--}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Notifications - AuthenticityHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2c2c2c, #4a4a4a);
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
            background: #111111;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 2rem;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.3rem;
            color: #ffffff;
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
            background: #333333;
            color: #ffffff;
            font-size: 1rem;
            box-shadow: 0 2px 8px #1a1a1a inset;
            outline: none;
        }

        .top-bar .search-container input::placeholder {
            color: #999999;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #e2e2e2;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
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
            color: #333333;
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            background: transparent;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.6);
            color: #ff3333;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.6);
            color: #ff3333;
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
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            max-width: 800px;
            margin: 0 auto;
        }

        .page-title {
            color: #333333;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .notification-item {
            background: #f8f8f8;
            border-left: 4px solid #ff3333;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .notification-item:hover {
            background: #f0f0f0;
            transform: translateX(4px);
        }

        .notification-item.unread {
            background: #fafafa;
            border-left: 4px solid #ff3333;
        }

        .notification-item.read {
            background: #f5f5f5;
            border-left: 4px solid #999999;
        }

        .notification-title {
            color: #333333;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .notification-meta {
            color: #666666;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .notification-message {
            color: #444444;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .no-notifications {
            text-align: center;
            color: #666666;
            font-style: italic;
            padding: 2rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending-review {
            background: #fef3c7;
            color: #92400e;
        }

        .status-agency-note {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-resolved {
            background: #d1fae5;
            color: #065f46;
        }

        .status-investigation {
            background: #dbeafe;
            color: #1e40af;
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
            border: 2px solid #666666;
            margin-left: 0.7rem;
            background: #333333;
        }

        .user-info-topbar .user-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info-topbar .user-name {
            font-size: 1rem;
            color: #ffffff;
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
            background: linear-gradient(145deg, #d1d1d1, #a6a6a6);
            border-radius: 0.75rem;
            box-shadow: 4px 4px 8px #9a9a9a, -4px -4px 8px #ffffff;
            color: #333333;
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
            background: linear-gradient(145deg, #c3c3c3, #9a9a9a);
            box-shadow: 2px 2px 6px #8a8a8a, -2px -2px 6px #e5e5e5;
            transform: translateY(-2px);
        }

        .nav-btn:active {
            transform: translateY(1px) scale(0.98);
        }

        .nav-btn.btn-danger {
            background: linear-gradient(145deg, #ff6b6b, #cc5555);
            color: #ffffff;
        }

        .nav-btn.btn-danger:hover {
            background: linear-gradient(145deg, #ff5555, #cc4444);
        }

        .notification-actions {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e0e0e0;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-success {
            background-color: #10b981;
            color: white;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
        }

        .unread-indicator {
            width: 8px;
            height: 8px;
            background: #ff3333;
            border-radius: 50%;
            display: inline-block;
            margin-left: 0.5rem;
        }

        .agency-note-content {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            border-left: 4px solid #ff3333;
            margin-bottom: 1rem;
        }

        .document-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.875rem;
            margin-top: 0.75rem;
        }

        .document-link:hover {
            color: #2563eb;
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub Admin</div>
        <div class="search-container">
            <input type="text" placeholder="Search...">
        </div>
        @include('partials.user_area')
    </header>    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('admin.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.notifications') }}" class="sidebar-link active">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="sidebar-link">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <div class="content-card">
            <h1 class="page-title">Admin Notifications</h1>
            
            <!-- Navigation Buttons -->
            <div class="nav-buttons">
                @if(!empty($notifications) && $notifications->count() > 0)
                    <button onclick="markAllAsRead()" class="nav-btn btn-danger">
                        <i class="fas fa-check-double"></i>
                        Mark All as Read
                    </button>
                @endif
                <a href="{{ route('admin.home') }}" class="nav-btn">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>

            <!-- Notifications List -->
            @if(empty($notifications) || $notifications->count() == 0)
                <div class="no-notifications">
                    <i class="fas fa-bell-slash" style="font-size: 3rem; color: #999999; margin-bottom: 1rem;"></i>
                    <h3>No Notifications</h3>
                    <p>You'll see system notifications and updates here, including notes from agencies.</p>
                </div>
            @else
                @foreach($notifications as $notification)
                    <div class="notification-item {{ ($notification->is_read ?? false) ? 'read' : 'unread' }}" id="notification-{{ $notification->id }}">
                        <div class="notification-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                            <div>
                                <div class="notification-title">
                                    {{ $notification->title }}
                                    @if(!($notification->is_read ?? false))
                                        <span class="unread-indicator"></span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="notification-meta">
                            @if(isset($notification->type) && $notification->type == 'agency_note')
                                {{-- Agency Note --}}
                                <span><strong>Inquiry:</strong> #{{ $notification->inquiry_id }}</span>
                                <span><strong>Agency:</strong> {{ ($notification->inquiry && $notification->inquiry->agency ? $notification->inquiry->agency->AgencyName : 'System') }}</span>
                                <span><strong>Time:</strong> {{ ($notification->created_at ? $notification->created_at->format('M j, Y \a\t g:i A') : 'Unknown') }}</span>
                                <span class="status-badge status-agency-note">Agency Note</span>
                            @else
                                {{-- Legacy Notification --}}
                                <span><strong>Inquiry:</strong> #{{ $notification->inquiry_id ?? 'N/A' }}</span>
                                <span><strong>Officer:</strong> {{ ($notification->inquiry && $notification->inquiry->agency ? $notification->inquiry->agency->AgencyName : 'System') ?? 'System' }}</span>
                                <span><strong>Time:</strong> {{ ($notification->created_at ? $notification->created_at->format('M j, Y \a\t g:i A') : 'Unknown') ?? 'Unknown' }}</span>
                                @if(isset($notification['status_update']))
                                    <span class="status-badge status-{{ $notification['status_update'] }}">
                                        {{ ucfirst(str_replace('_', ' ', $notification['status_update'])) }}
                                    </span>
                                @endif
                            @endif
                        </div>
                        
                        <div class="notification-message">
                            @if(isset($notification->type) && $notification->type == 'agency_note')
                                {{-- Agency Note Message --}}
                                <div class="agency-note-content">
                                    {{ $notification->message }}
                                </div>
                                @if($notification['supporting_document'])
                                    <a href="{{ asset('storage/' . $notification['supporting_document']) }}" 
                                       target="_blank" 
                                       class="document-link">
                                        <i class="fas fa-paperclip"></i>
                                        View Supporting Document
                                    </a>
                                @endif
                            @else
                                {{-- Legacy Message --}}
                                {{ $notification->message }}
                            @endif
                        </div>                        <div class="notification-actions">
                            @if(!($notification->is_read ?? false))
                                <button onclick="markAsRead('{{ $notification->id }}')" class="btn btn-success">
                                    <i class="fas fa-check"></i>
                                    Mark as Read
                                </button>
                            @endif
                            @if(isset($notification->inquiry_id))
                                <a href="{{ route('admin.inquiry.details', $notification->inquiry_id) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i>
                                    View Inquiry
                                </a>
                            @endif
                            <a href="{{ route('admin.reports') }}" class="btn btn-secondary">
                                <i class="fas fa-chart-bar"></i>
                                Reports
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </main>    <script>
        function markAsRead(notificationId) {
            fetch('/admin/notifications/' + notificationId + '/mark-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {                if (data.success) {
                    const notification = document.getElementById('notification-' + notificationId);
                    
                    // Make the notification semi-transparent (low opacity)
                    notification.style.opacity = '0.3';
                    notification.style.transition = 'opacity 0.5s ease';
                    
                    // Update the notification appearance to show it's read
                    notification.classList.remove('unread');
                    notification.classList.add('read');
                    
                    // Remove the unread indicator
                    const indicator = notification.querySelector('.unread-indicator');
                    if (indicator) indicator.remove();
                    
                    // Remove the "Mark as Read" button
                    const markButton = notification.querySelector('button[onclick*="markAsRead"]');
                    if (markButton) markButton.remove();
                }
            })            .catch(error => {
                console.error('Error:', error);
            });
        }

        function markAllAsRead() {
            fetch('/admin/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {                if (data.success) {
                    // Update all unread notifications to read status
                    const unreadNotifications = document.querySelectorAll('.notification-item.unread');
                    
                    unreadNotifications.forEach(notification => {
                        // Make the notification semi-transparent (low opacity)
                        notification.style.opacity = '0.3';
                        notification.style.transition = 'opacity 0.5s ease';
                        
                        // Update the notification appearance
                        notification.classList.remove('unread');
                        notification.classList.add('read');
                        
                        // Remove the unread indicator
                        const indicator = notification.querySelector('.unread-indicator');
                        if (indicator) indicator.remove();
                        
                        // Remove the "Mark as Read" button
                        const markButton = notification.querySelector('button[onclick*="markAsRead"]');
                        if (markButton) markButton.remove();
                    });
                    
                    // Hide the "Mark All as Read" button
                    const markAllButton = document.querySelector('button[onclick*="markAllAsRead"]');
                    if (markAllButton) {
                        markAllButton.style.display = 'none';
                    }
                }
            })            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>
