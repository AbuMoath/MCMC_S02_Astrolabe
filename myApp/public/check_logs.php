<?php
// Check recent Laravel logs for reassignment request errors
$logFile = __DIR__ . '/../storage/logs/laravel.log';

if (file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    
    // Get last 50 lines of logs
    $lines = explode("\n", $logs);
    $recentLines = array_slice($lines, -100); // Last 100 lines
    
    echo "=== Recent Laravel Logs (Last 100 lines) ===\n\n";
    
    foreach ($recentLines as $line) {
        if (!empty($line)) {
            echo $line . "\n";
        }
    }
} else {
    echo "Laravel log file not found at: $logFile\n";
}
?>
