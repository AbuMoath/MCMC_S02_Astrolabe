<?php
// Test reassignment functionality
require_once __DIR__ . '/../vendor/autoload.php';

// Load Laravel application
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== Testing Reassignment Request Feature ===\n\n";
    
    // Check if tables exist
    $tablesCheck = [
        'inquiries' => \Illuminate\Support\Facades\Schema::hasTable('inquiries'),
        'agencies' => \Illuminate\Support\Facades\Schema::hasTable('agencies'),
        'reassignment_requests' => \Illuminate\Support\Facades\Schema::hasTable('reassignment_requests')
    ];
    
    echo "Table existence check:\n";
    foreach ($tablesCheck as $table => $exists) {
        echo "- $table: " . ($exists ? 'EXISTS' : 'MISSING') . "\n";
    }
    echo "\n";
    
    if ($tablesCheck['reassignment_requests']) {
        // Check table structure
        $columns = \Illuminate\Support\Facades\DB::select("DESCRIBE reassignment_requests");
        echo "Reassignment requests table structure:\n";
        foreach ($columns as $column) {
            echo "- {$column->Field} ({$column->Type})\n";
        }
        echo "\n";
        
        // Check if we have agencies
        $agencyCount = \App\Models\Module1\Agency::count();
        echo "Agencies count: $agencyCount\n";
        
        if ($agencyCount > 0) {
            $agencies = \App\Models\Module1\Agency::select('AgencyID', 'AgencyName')->limit(3)->get();
            echo "Sample agencies:\n";
            foreach ($agencies as $agency) {
                echo "- ID: {$agency->AgencyID}, Name: {$agency->AgencyName}\n";
            }
        }
        echo "\n";
        
        // Check if we have inquiries
        $inquiryCount = \App\Models\Inquiry::count();
        echo "Inquiries count: $inquiryCount\n";
        
        if ($inquiryCount > 0) {
            $inquiries = \App\Models\Inquiry::select('InquiryID', 'InquiryTitle', 'AgencyID')->limit(3)->get();
            echo "Sample inquiries:\n";
            foreach ($inquiries as $inquiry) {
                echo "- ID: {$inquiry->InquiryID}, Title: {$inquiry->InquiryTitle}, Agency: {$inquiry->AgencyID}\n";
            }
        }
        echo "\n";
        
        // Check existing reassignment requests
        $requestCount = \App\Models\ReassignmentRequest::count();
        echo "Existing reassignment requests: $requestCount\n";
        
        if ($requestCount > 0) {
            $requests = \App\Models\ReassignmentRequest::with(['requestingAgency', 'inquiry'])
                                                      ->limit(3)
                                                      ->get();
            echo "Sample requests:\n";
            foreach ($requests as $request) {
                echo "- Request ID: {$request->RequestID}, Inquiry: {$request->InquiryID}, Status: {$request->RequestStatus}\n";
            }
        }
        
    } else {
        echo "ERROR: reassignment_requests table is missing!\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
?>
