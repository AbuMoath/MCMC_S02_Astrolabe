<?php
$sourceFile = __DIR__ . '/../resources/views/Module4/publicUser/notification.blade.php';
$destFile = __DIR__ . '/../resources/views/Module4/agency/notification.blade.php';

$content = file_get_contents($sourceFile);

// Adjust title and styling slightly for Agency
$content = str_replace('AuthenticityHub</title>', 'AuthenticityHub Agency</title>', $content);
$content = str_replace('<div class="logo">AuthenticityHub</div>', '<div class="logo">AuthenticityHub Agency</div>', $content);

// Update sidebar links to point to agency routes
$content = preg_replace('/href="\{\{ .*? \}\}" class="sidebar-link"/', 'href="{{ route(\'agency.home\') }}" class="sidebar-link"', $content, 1); // Back link
$content = str_replace('route(\'manage.profile\')', 'route(\'agency.profile\')', $content);
$content = str_replace('route(\'password.edit\')', 'route(\'agency.security\')', $content);

// Update nav buttons
$content = preg_replace('/href="\{\{ route\(\'inquiries\.index\'\) \}\}"/', 'href="{{ route(\'agency.view.display.inquiry\') }}"', $content);
// Remove "Submit New Inquiry" button since agencies don't submit them
$content = preg_replace('/<a href="\{\{ route\(\'submit\.inquiry\'\) \}\}" class="nav-btn">.*?<\/a>/s', '', $content);

// Adjust JS endpoints
$content = str_replace("fetch('/module4/publicUser/notifications/'", "fetch('/agency/notifications/'", $content);
$content = str_replace("fetch('/module4/publicUser/notifications/mark-all-read'", "fetch('/agency/notifications/mark-all-read'", $content);

// Change user_type in JS payload for mark-all-read
// Actually the JS doesn't have a payload, let's just use the default. Wait, markAllAsRead in controller checks user_type.
$content = str_replace("body: JSON.stringify({", "body: JSON.stringify({ user_type: 'Agency',", $content);

file_put_contents($destFile, $content);
echo "Created $destFile\n";
