<?php
// Debug reassignment requests
require_once __DIR__ . '/../vendor/autoload.php';

// Load Laravel application
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== Debugging Reassignment Requests ===\n\n";
    
    // Check all reassignment requests
    $requests = \App\Models\ReassignmentRequest::with(['requestingAgency', 'inquiry'])
                                              ->orderBy('created_at', 'desc')
                                              ->get();
    
    echo "Total reassignment requests: " . $requests->count() . "\n\n";
    
    if ($requests->count() > 0) {
        echo "All requests:\n";
        foreach ($requests as $request) {
            echo "Request ID: {$request->RequestID}\n";
            echo "Inquiry ID: {$request->InquiryID}\n";
            echo "Requesting Agency: " . ($request->requestingAgency ? $request->requestingAgency->AgencyName : 'N/A') . "\n";
            echo "Status: {$request->RequestStatus}\n";
            echo "Reason: {$request->RequestReason}\n";
            echo "Created: {$request->created_at}\n";
            echo "---\n";
        }
        
        echo "\nPending requests only:\n";
        $pendingRequests = \App\Models\ReassignmentRequest::where('RequestStatus', 'Pending')->get();
        echo "Pending count: " . $pendingRequests->count() . "\n";
        
        foreach ($pendingRequests as $request) {
            echo "- Inquiry #{$request->InquiryID} - Status: {$request->RequestStatus}\n";
        }
        
        // Check inquiry #4 specifically
        echo "\nChecking Inquiry #4:\n";
        $inquiry4 = \App\Models\Inquiry::with(['reassignmentRequests' => function($q) {
            $q->where('RequestStatus', 'Pending');
        }])->find(4);
        
        if ($inquiry4) {
            echo "Inquiry #4 found\n";
            echo "Reassignment requests count: " . $inquiry4->reassignmentRequests->count() . "\n";
            foreach ($inquiry4->reassignmentRequests as $req) {
                echo "- Request ID: {$req->RequestID}, Status: {$req->RequestStatus}\n";
            }
        } else {
            echo "Inquiry #4 not found\n";
        }
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
?>
