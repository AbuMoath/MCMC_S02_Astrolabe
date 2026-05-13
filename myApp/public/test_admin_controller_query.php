<?php
// Test what the admin controller returns
require_once __DIR__ . '/../vendor/autoload.php';

// Load Laravel application
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== Testing Admin Controller Query ===\n\n";
    
    // Simulate the exact query from AdminController
    $query = \App\Models\Inquiry::with(['reassignmentRequests' => function($q) {
        $q->where('RequestStatus', 'Pending');
    }]);

    $inquiries = $query
        ->orderByRaw("CASE WHEN InquiryStatus = 'Pending' THEN 0 ELSE 1 END")
        ->orderBy('InquirySendDate', 'desc')
        ->get();

    echo "Total inquiries found: " . $inquiries->count() . "\n\n";
    
    foreach ($inquiries as $inquiry) {
        echo "Inquiry ID: {$inquiry->InquiryID}\n";
        echo "Title: {$inquiry->InquiryTitle}\n";
        echo "Status: {$inquiry->InquiryStatus}\n";
        echo "Agency ID: {$inquiry->AgencyID}\n";
        echo "Reassignment Requests Count: " . $inquiry->reassignmentRequests->count() . "\n";
        
        if ($inquiry->reassignmentRequests->count() > 0) {
            echo "Reassignment Requests:\n";
            foreach ($inquiry->reassignmentRequests as $req) {
                echo "  - Request ID: {$req->RequestID}, Status: {$req->RequestStatus}, Created: {$req->created_at}\n";
            }
        }
        echo "---\n";
    }
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
?>
