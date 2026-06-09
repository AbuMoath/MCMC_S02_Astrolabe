@php
    $userId = null;
    $userType = null;
    
    $isAdminRoute = request()->is('admin*');
    $isAgencyRoute = request()->is('agency*');

    // Determine the user context based on the route to prevent session bleed
    if ($isAdminRoute && session()->has('admin_id')) {
        $userId = session('admin_id');
        $userType = 'admin';
    } elseif ($isAgencyRoute && session()->has('agency_id')) {
        $userId = session('agency_id');
        $userType = 'agency';
    } elseif ((!$isAdminRoute && !$isAgencyRoute) && (session()->has('user_id') || Auth::check())) {
        $userId = session()->has('user_id') ? session('user_id') : Auth::id();
        $userType = 'public';
    }

    $unreadCount = 0;
    $notifications = collect();
    
    if ($userId && $userType) {
        $notifications = \App\Models\Notification::where('user_id', $userId)
            ->where('user_type', $userType)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $unreadCount = $notifications->where('is_read', false)->count();
    }
@endphp

<div class="notification-container" style="position: relative; margin-right: 1.5rem; display: flex; align-items: center;">
    <!-- Notification Bell -->
    <button type="button" class="notification-bell" onclick="toggleNotifications(event)" style="background: none; border: none; cursor: pointer; color: inherit; font-size: 1.25rem; display: flex; align-items: center; position: relative; padding: 0;">
        <i class="fa-solid fa-bell"></i>
        @if($unreadCount > 0)
            <span id="notif-badge" class="badge" style="position: absolute; top: -5px; right: -8px; background: #e74c3c; color: white; border-radius: 50%; font-size: 0.65rem; padding: 2px 5px; font-weight: bold; min-width: 15px; text-align: center;">{{ $unreadCount }}</span>
        @endif
    </button>

    <!-- Notification Dropdown -->
    <div id="notification-dropdown" class="notification-dropdown" style="display: none; position: absolute; top: 100%; right: -10px; margin-top: 15px; width: 320px; background: #ffffff; border-radius: 12px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15); z-index: 1000; overflow: hidden; border: 1px solid rgba(0,0,0,0.05); text-align: left;">
        <div class="dropdown-header" style="display: flex; justify-content: space-between; align-items: center; padding: 16px; border-bottom: 1px solid #f0f0f0; background: #fafafa;">
            <h4 style="margin: 0; font-size: 1rem; color: #333; font-weight: 600;">Notifications</h4>
            @if($unreadCount > 0)
                <button onclick="markNotificationsAsRead(event)" id="mark-read-btn" style="background: none; border: none; color: #3182ce; font-size: 0.85rem; cursor: pointer; font-weight: 500; transition: color 0.3s ease; padding: 0;">
                    Mark all as read
                </button>
            @endif
        </div>
        
        <div class="dropdown-body" style="max-height: 300px; overflow-y: auto; background: #ffffff;">
            @if($notifications->count() > 0)
                @foreach($notifications as $notif)
                    <div class="notification-item {{ $notif->is_read ? 'read' : 'unread' }}" style="padding: 16px; border-bottom: 1px solid #f0f0f0; transition: background 0.2s ease; {{ !$notif->is_read ? 'background: #f8fbff;' : '' }}">
                        <p style="margin: 0 0 4px 0; font-size: 0.9rem; color: #333; line-height: 1.4;">{{ $notif->message ?? $notif->title }}</p>
                        <span style="font-size: 0.75rem; color: #888;">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                @endforeach
            @else
                <div style="padding: 32px 16px; text-align: center; color: #888;">
                    <i class="fa-solid fa-bell-slash" style="font-size: 2rem; margin-bottom: 8px; color: #ccc;"></i>
                    <p style="margin: 0; font-size: 0.9rem;">No notifications</p>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
    function toggleNotifications(event) {
        event.stopPropagation();
        const dropdown = document.getElementById('notification-dropdown');
        if (dropdown.style.display === 'none' || dropdown.style.display === '') {
            dropdown.style.display = 'block';
        } else {
            dropdown.style.display = 'none';
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const container = document.querySelector('.notification-container');
        const dropdown = document.getElementById('notification-dropdown');
        if (container && !container.contains(event.target) && dropdown) {
            dropdown.style.display = 'none';
        }
    });

    function markNotificationsAsRead(event) {
        event.stopPropagation();
        const userId = '{{ $userId }}';
        const userType = '{{ $userType }}';
        
        if(!userId || !userType) return;

        fetch('{{ route('notifications.markAllRead') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ user_id: userId, user_type: userType })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove badge
                const badge = document.getElementById('notif-badge');
                if (badge) badge.remove();
                
                // Hide mark as read button
                const markReadBtn = document.getElementById('mark-read-btn');
                if (markReadBtn) markReadBtn.style.display = 'none';
                
                // Update styling of unread items
                const unreadItems = document.querySelectorAll('.notification-item.unread');
                unreadItems.forEach(item => {
                    item.classList.remove('unread');
                    item.classList.add('read');
                    item.style.background = 'transparent';
                });
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
