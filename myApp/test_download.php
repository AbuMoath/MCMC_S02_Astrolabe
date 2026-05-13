<?php
// Test file to verify download functionality
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

try {
    // Initialize Laravel
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    echo "Testing download functionality...\n";
    
    // Check if storage symlink exists
    $publicStoragePath = public_path('storage');
    echo "Storage symlink exists: " . (is_link($publicStoragePath) || is_dir($publicStoragePath) ? "Yes" : "No") . "\n";
    
    // Check if evidence directory exists
    $evidencePath = storage_path('app/public/evidence');
    echo "Evidence directory exists: " . (is_dir($evidencePath) ? "Yes" : "No") . "\n";
    
    // List evidence files
    if (is_dir($evidencePath)) {
        $files = scandir($evidencePath);
        $files = array_filter($files, function($file) {
            return $file !== '.' && $file !== '..';
        });
        
        echo "Evidence files found: " . count($files) . "\n";
        
        if (count($files) > 0) {
            $firstFile = reset($files);
            echo "Sample file: " . $firstFile . "\n";
            echo "Full path: " . $evidencePath . DIRECTORY_SEPARATOR . $firstFile . "\n";
            echo "Accessible via: " . url('storage/evidence/' . $firstFile) . "\n";
            echo "Asset URL: " . asset('storage/evidence/' . $firstFile) . "\n";
        }
    }
    
    echo "\nDownload functionality test completed successfully!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
