<?php
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "Creating agency_notes table...\n";

try {
    // Check if table exists
    if (Schema::hasTable('agency_notes')) {
        echo "✅ Table 'agency_notes' already exists.\n";
    } else {
        // Create the table using Schema Builder
        Schema::create('agency_notes', function ($table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id');
            $table->unsignedBigInteger('agency_id');
            $table->string('agency_name');
            $table->enum('recipient_type', ['User', 'Administrator']);
            $table->text('comment');
            $table->string('supporting_document')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // Add indexes for better performance
            $table->index(['inquiry_id', 'recipient_type']);
            $table->index(['user_id', 'created_at']);
            $table->index('agency_id');
        });
        
        echo "✅ Table 'agency_notes' created successfully!\n";
    }

    // Test if we can insert and retrieve data
    echo "\nTesting table functionality...\n";
    
    // Count existing notes
    $count = DB::table('agency_notes')->count();
    echo "Current notes count: $count\n";
    
    echo "\n✅ Table is ready for use!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>
