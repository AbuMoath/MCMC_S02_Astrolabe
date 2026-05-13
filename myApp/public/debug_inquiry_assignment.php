<?php
// Debug inquiry assignments
require_once __DIR__ . '/../vendor/autoload.php';

// Load Laravel application
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== Inquiry Assignment Debug ===\n\n";
    
    // Check inquiry #4 specifically
    $inquiry = \App\Models\Inquiry::find(4);
    
    if ($inquiry) {
        echo "Inquiry #4 Details:\n";
        echo "ID: {$inquiry->InquiryID}\n";
        echo "Title: {$inquiry->InquiryTitle}\n";
        echo "Assigned Agency ID: " . ($inquiry->AgencyID ?: 'NOT ASSIGNED') . "\n";
        echo "Status: {$inquiry->InquiryStatus}\n";
        echo "Created: {$inquiry->created_at}\n";
        echo "\n";
        
        if ($inquiry->AgencyID) {
            $agency = \App\Models\Module1\Agency::find($inquiry->AgencyID);
            if ($agency) {
                echo "Assigned Agency Details:\n";
                echo "Agency ID: {$agency->AgencyID}\n";
                echo "Agency Name: {$agency->AgencyName}\n";
                echo "Agency Email: {$agency->AgencyEmail}\n";
            }
        }
        
        // Check if there are any reassignment requests for this inquiry
        $requests = \App\Models\ReassignmentRequest::where('InquiryID', 4)->get();
        echo "\nReassignment Requests for Inquiry #4: " . $requests->count() . "\n";
        
        foreach ($requests as $request) {
            echo "- Request ID: {$request->RequestID}\n";
            echo "  Requesting Agency ID: {$request->RequestingAgencyID}\n";
            echo "  Status: {$request->RequestStatus}\n";
            echo "  Reason: {$request->RequestReason}\n";
            echo "  Created: {$request->created_at}\n";
            echo "\n";
        }
        
    } else {
        echo "Inquiry #4 not found\n";
    }
    
    // Check all agencies
    echo "\nAll Agencies:\n";
    $agencies = \App\Models\Module1\Agency::select('AgencyID', 'AgencyName')->get();
    foreach ($agencies as $agency) {
        echo "- ID: {$agency->AgencyID}, Name: {$agency->AgencyName}\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
?>
