<?php
require_once 'vendor/autoload.php';

// Load Laravel configuration
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Test database connection
    $pdo = DB::connection()->getPdo();
    echo "Database connection successful!\n";
    
    // Check if the columns exist in the inquiries table
    $columns = DB::select("DESCRIBE inquiries");
    echo "\nColumns in inquiries table:\n";
    foreach ($columns as $column) {
        echo "- " . $column->Field . " (" . $column->Type . ")\n";
    }
    
    // Check specifically for StatusComments and ProcessedAt
    $hasStatusComments = false;
    $hasProcessedAt = false;
    foreach ($columns as $column) {
        if ($column->Field === 'StatusComments') {
            $hasStatusComments = true;
        }
        if ($column->Field === 'ProcessedAt') {
            $hasProcessedAt = true;
        }
    }
    
    echo "\nColumn Status:\n";
    echo "StatusComments: " . ($hasStatusComments ? "EXISTS" : "MISSING") . "\n";
    echo "ProcessedAt: " . ($hasProcessedAt ? "EXISTS" : "MISSING") . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
