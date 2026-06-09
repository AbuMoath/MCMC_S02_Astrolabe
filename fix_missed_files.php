<?php

$files = [
    __DIR__ . '/myApp/resources/views/shared admin page/reviewInquiries.blade.php',
    __DIR__ . '/myApp/resources/views/shared admin page/inquiryDetails.blade.php',
    __DIR__ . '/myApp/resources/views/Module3/Admin/reviewInquiries.blade.php',
    __DIR__ . '/myApp/resources/views/Module3/Admin/inquiryDetails.blade.php'
];

$pattern = '/<div class="user-info-topbar">.*?<\/div>\s*<\/div>\s*<\/div>/s';
$replacement = "@include('partials.user_area')\n    </div>";

$count = 0;
foreach($files as $filePath) {
    if (!file_exists($filePath)) continue;
    
    $content = file_get_contents($filePath);
    
    // In these files, the top bar ends with:
    // <div class="user-info-topbar"> ... </div> </div> </div>
    // Let's use a simpler pattern matching just the user-info-topbar div
    $pattern2 = '/<div class="user-info-topbar">.*?<\/div>\s*<\/div>\s*(<div class="main-container">)/s';
    
    if (preg_match($pattern2, $content)) {
        $newContent = preg_replace($pattern2, "@include('partials.user_area')\n    </div>\n\n    $1", $content);
        if ($newContent !== $content) {
            file_put_contents($filePath, $newContent);
            echo "Updated: $filePath\n";
            $count++;
        }
    }
}

echo "Total files fixed: $count\n";
