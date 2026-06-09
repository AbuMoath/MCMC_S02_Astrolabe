<?php
$file = __DIR__ . '/../resources/views/Module4/admin/notification.blade.php';
$content = file_get_contents($file);

// Replace array accesses with object accesses
$content = preg_replace("/\\\$notification\['id'\]/", "\$notification->id", $content);
$content = preg_replace("/\\\$notification\['read'\]/", "\$notification->is_read", $content);
$content = preg_replace("/\\\$notification\['title'\]/", "\$notification->title", $content);
$content = preg_replace("/\\\$notification\['type'\]/", "\$notification->type", $content);
$content = preg_replace("/\\\$notification\['message'\]/", "\$notification->message", $content);
$content = preg_replace("/\\\$notification\['inquiry_id'\]/", "\$notification->inquiry_id", $content);
$content = preg_replace("/\\\$notification\['timestamp'\]/", "(\$notification->created_at ? \$notification->created_at->format('M j, Y \\\\a\\\\t g:i A') : 'Unknown')", $content);
$content = preg_replace("/\\\$notification\['officer_name'\]/", "(\$notification->inquiry && \$notification->inquiry->agency ? \$notification->inquiry->agency->AgencyName : 'System')", $content);

// Update fetch URLs to match the named routes we established
$content = str_replace("fetch('/module4/admin/notifications/' + notificationId + '/read'", "fetch('/admin/notifications/' + notificationId + '/mark-read'", $content);
$content = str_replace("fetch('/module4/admin/notifications/mark-all-read'", "fetch('/admin/notifications/mark-all-read'", $content);

file_put_contents($file, $content);
echo "Updated $file\n";
