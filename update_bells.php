<?php

$dir = new RecursiveDirectoryIterator(__DIR__ . '/myApp/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$pattern = '/@php\s*\$unreadCount = \\\App\\\Models\\\Notification::where.*?<\/a>/s';
$replacement = "@include('partials.notifications')";

$count = 0;
foreach($files as $file) {
    $filePath = $file[0];
    
    // Skip the partial itself and the old notification page
    if (strpos($filePath, 'partials' . DIRECTORY_SEPARATOR . 'notifications.blade.php') !== false) {
        continue;
    }
    
    $content = file_get_contents($filePath);
    if (preg_match($pattern, $content)) {
        $newContent = preg_replace($pattern, $replacement, $content);
        file_put_contents($filePath, $newContent);
        echo "Updated: $filePath\n";
        $count++;
    }
}

echo "Total files updated: $count\n";

