<?php
require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

app()->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $columns = DB::select('SHOW COLUMNS FROM inquiries');
    
    echo "Inquiries table columns:\n";
    foreach ($columns as $column) {
        echo "- " . $column->Field . " (" . $column->Type . ")\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
