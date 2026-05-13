<?php
/**
 * Simple test for inquiry statistics
 */

// Check if we're in the right directory
echo "Current directory: " . getcwd() . "\n";
echo "Checking Laravel bootstrap...\n";

if (file_exists('vendor/autoload.php')) {
    echo "Autoload file found\n";
    require_once 'vendor/autoload.php';
} else {
    echo "Autoload file not found\n";
    exit(1);
}

if (file_exists('bootstrap/app.php')) {
    echo "Bootstrap file found\n";
    $app = require_once 'bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    echo "Laravel bootstrapped successfully\n";
} else {
    echo "Bootstrap file not found\n";
    exit(1);
}

echo "Test completed successfully\n";
