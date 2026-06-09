<?php

$dir = __DIR__ . '/../resources/views/Module3/Agency';
$files = glob($dir . '/*.blade.php');

$bellHtml = <<<HTML
                @php
                    \$unreadCount = \App\Models\Notification::where('user_id', session('agency_id', 1))
                        ->where('user_type', 'Agency')
                        ->where('is_read', false)
                        ->count();
                @endphp
                <a href="{{ route('agency.notifications') }}" class="notification-bell" style="position: relative; margin-right: 1rem; color: #ffffff; font-size: 1.25rem; display: flex; align-items: center; text-decoration: none;">
                    <i class="fa-solid fa-bell"></i>
                    @if(\$unreadCount > 0)
                        <span class="badge" style="position: absolute; top: -5px; right: -8px; background: #e74c3c; color: white; border-radius: 50%; font-size: 0.65rem; padding: 2px 5px; font-weight: bold; min-width: 15px; text-align: center;">{{ \$unreadCount }}</span>
                    @endif
                </a>
HTML;

foreach ($files as $file) {
    $content = file_get_contents($file);
    if (strpos($content, '<div class="user-area">') !== false && strpos($content, 'class="notification-bell"') === false) {
        $content = preg_replace(
            '/(<div class="user-area">)/',
            "$1\n$bellHtml",
            $content
        );
        file_put_contents($file, $content);
        echo "Updated $file\n";
    }
}
