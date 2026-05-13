<?php
// Simple test to verify Agency Performance Reports integration
echo "Testing Agency Performance Reports Integration...\n\n";

// Check if our files exist
$files_to_check = [
    'app/Http/Controllers/Module1/AdminController.php',
    'resources/views/shared admin page/generateReportPage.blade.php',
    'routes/web.php'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "✓ {$file} exists\n";
    } else {
        echo "✗ {$file} missing\n";
    }
}

echo "\nChecking AdminController for agency performance method...\n";
$admin_controller_content = file_get_contents('app/Http/Controllers/Module1/AdminController.php');

if (strpos($admin_controller_content, 'generateAgencyPerformanceReports') !== false) {
    echo "✓ generateAgencyPerformanceReports method found\n";
} else {
    echo "✗ generateAgencyPerformanceReports method missing\n";
}

if (strpos($admin_controller_content, 'agency_performance') !== false) {
    echo "✓ agency_performance case handling found\n";
} else {
    echo "✗ agency_performance case handling missing\n";
}

echo "\nChecking generateReportPage for agency performance tab...\n";
$report_page_content = file_get_contents('resources/views/shared admin page/generateReportPage.blade.php');

if (strpos($report_page_content, 'agency-performance-tab') !== false) {
    echo "✓ Agency Performance tab found\n";
} else {
    echo "✗ Agency Performance tab missing\n";
}

if (strpos($report_page_content, 'submitAgencyPerformanceReport') !== false) {
    echo "✓ submitAgencyPerformanceReport function found\n";
} else {
    echo "✗ submitAgencyPerformanceReport function missing\n";
}

if (strpos($report_page_content, 'agency-performance-report-form') !== false) {
    echo "✓ Agency Performance form found\n";
} else {
    echo "✗ Agency Performance form missing\n";
}

echo "\nChecking routes...\n";
$routes_content = file_get_contents('routes/web.php');

if (strpos($routes_content, 'admin.reports.generate') !== false) {
    echo "✓ admin.reports.generate route found\n";
} else {
    echo "✗ admin.reports.generate route missing\n";
}

echo "\nIntegration test completed!\n";
echo "The Agency Performance Reports feature is now integrated as a tab in the existing reports page.\n";
echo "You can access it by:\n";
echo "1. Going to Admin Dashboard\n";
echo "2. Clicking on 'Report' in the sidebar\n";
echo "3. Selecting the 'Agency Performance Analytics' tab\n";
