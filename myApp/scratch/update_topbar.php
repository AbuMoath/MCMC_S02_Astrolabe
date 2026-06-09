<?php

$dirs = [
    'PublicUser' => [
        'type' => 'PublicUser',
        'route' => 'public.notifications',
        'dir' => __DIR__ . '/../resources/views/Module3/PublicUser',
    ],
    'Admin' => [
        'type' => 'Administrator',
        'route' => 'admin.notifications',
        'dir' => __DIR__ . '/../resources/views/Module3/Admin',
    ],
    'Agency' => [
        'type' => 'Agency',
        'route' => 'agency.notifications',
        'dir' => __DIR__ . '/../resources/views/Module3/Agency',
    ]
];

foreach ($dirs as $role => $info) {
    if (!is_dir($info['dir'])) continue;

    $files = glob($info['dir'] . '/*.blade.php');
    foreach ($files as $file) {
        $content = file_get_contents($file);

        // Check if top-bar exists and doesn't already have notification-bell
        if (strpos($content, '<div class="user-info-topbar">') !== false && strpos($content, 'class="notification-bell"') === false) {

            $bellHtml = <<<HTML
                @php
                    \$unreadCount = \App\Models\Notification::where('user_id', Auth::id())
                        ->where('user_type', '{$info['type']}')
                        ->where('is_read', false)
                        ->count();
                @endphp
                <a href="{{ route('{$info['route']}') }}" class="notification-bell" style="position: relative; margin-right: 1.5rem; color: #283d63; font-size: 1.25rem; display: flex; align-items: center; text-decoration: none;">
                    <i class="fa-solid fa-bell"></i>
                    @if(\$unreadCount > 0)
                        <span class="badge" style="position: absolute; top: -5px; right: -8px; background: #e74c3c; color: white; border-radius: 50%; font-size: 0.65rem; padding: 2px 5px; font-weight: bold; min-width: 15px; text-align: center;">{{ \$unreadCount }}</span>
                    @endif
                </a>
HTML;

            // Insert after <div class="user-info-topbar">
            // But wait, there might be @auth inside.
            // Let's just insert it right inside <div class="user-info-topbar">
            $content = preg_replace(
                '/(<div class="user-info-topbar">)/',
                "$1\n$bellHtml",
                $content
            );

            file_put_contents($file, $content);
            echo "Updated $file\n";
        }
    }
}
