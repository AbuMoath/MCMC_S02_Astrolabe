<?php

$dir = new RecursiveDirectoryIterator(__DIR__ . '/myApp/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$pattern_admin_public = '/<div class="user-info-topbar">.*?<\/div>\s*<\/div>/s';
$pattern_agency = '/<div class="user-area">.*?<\/div>\s*<\/div>\s*<\/div>/s'; // agency has 3 closing divs
$replacement = "@include('partials.user_area')";

$count = 0;
foreach($files as $file) {
    $filePath = $file[0];
    
    // Skip partials
    if (strpos($filePath, 'partials' . DIRECTORY_SEPARATOR) !== false) {
        continue;
    }
    
    $content = file_get_contents($filePath);
    $original = $content;
    
    // Admin and Public User replacement
    // Need a better regex to match the topbar div specifically.
    // Let's match from <div class="user-info-topbar"> until we reach the closing </header>
    $pattern1 = '/<div class="user-info-topbar">.*?<\/header>/s';
    if (preg_match($pattern1, $content)) {
        $content = preg_replace($pattern1, "@include('partials.user_area')\n    </header>", $content);
    }
    
    // Agency replacement
    $pattern2 = '/<div class="user-area">.*?<\/header>/s';
    if (preg_match($pattern2, $content)) {
        $content = preg_replace($pattern2, "@include('partials.user_area')\n    </header>", $content);
    }
    
    if ($content !== $original) {
        file_put_contents($filePath, $content);
        echo "Updated: $filePath\n";
        $count++;
    }
}

echo "Total files updated: $count\n";
