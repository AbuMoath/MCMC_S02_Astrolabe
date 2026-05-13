<?php
/**
 * Test script to verify inquiry statistics display
 * Tests the status counts functionality in the Agency ViewAndDisplayInquiry page
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Module3\Inquiry;
use App\Models\Module3\Agency;

echo "=== Testing Inquiry Statistics Functionality ===\n\n";

try {
    // Test database connection
    echo "1. Testing database connection...\n";
    $inquiryCount = Inquiry::count();
    echo "   ✓ Database connected. Total inquiries in system: {$inquiryCount}\n\n";

    // Get the first agency for testing
    echo "2. Testing agency inquiry statistics...\n";
    $agency = Agency::first();
    
    if (!$agency) {
        echo "   ⚠ No agencies found in the database\n";
        exit(1);
    }
    
    echo "   Testing with Agency: {$agency->AgencyName} (ID: {$agency->AgencyID})\n";

    // Get inquiries for this agency (same logic as controller)
    $inquiries = Inquiry::with(['user', 'agency', 'admin'])
        ->where('AgencyID', $agency->AgencyID)
        ->get();

    echo "   Inquiries assigned to this agency: {$inquiries->count()}\n";

    // Calculate status counts (same logic as controller)
    $statusCounts = [
        'total' => $inquiries->count(),
        'pending' => $inquiries->where('InquiryStatus', 'Pending')->count(),
        'under_investigation' => $inquiries->where('InquiryStatus', 'Under Investigation')->count(),
        'verified_true' => $inquiries->where('InquiryStatus', 'Verified as True')->count(),
        'identified_fake' => $inquiries->where('InquiryStatus', 'Identified as Fake')->count(),
        'rejected' => $inquiries->where('InquiryStatus', 'Rejected')->count(),
    ];

    echo "\n3. Status Count Results:\n";
    echo "   Total Inquiries: {$statusCounts['total']}\n";
    echo "   Pending: {$statusCounts['pending']}\n";
    echo "   Under Investigation: {$statusCounts['under_investigation']}\n";
    echo "   Verified as True: {$statusCounts['verified_true']}\n";
    echo "   Identified as Fake: {$statusCounts['identified_fake']}\n";
    echo "   Rejected: {$statusCounts['rejected']}\n";

    // Verify the sum adds up
    $calculatedTotal = $statusCounts['pending'] + $statusCounts['under_investigation'] + 
                      $statusCounts['verified_true'] + $statusCounts['identified_fake'] + 
                      $statusCounts['rejected'];
    
    echo "\n4. Verification:\n";
    echo "   Sum of all statuses: {$calculatedTotal}\n";
    echo "   Total count: {$statusCounts['total']}\n";
    
    if ($calculatedTotal == $statusCounts['total']) {
        echo "   ✓ Status counts are consistent\n";
    } else {
        echo "   ⚠ Status counts don't add up - there may be inquiries with other statuses\n";
        
        // Check for other statuses
        echo "\n5. Checking for other inquiry statuses:\n";
        $allStatuses = $inquiries->pluck('InquiryStatus')->unique()->values();
        foreach ($allStatuses as $status) {
            $count = $inquiries->where('InquiryStatus', $status)->count();
            echo "   Status: '{$status}' - Count: {$count}\n";
        }
    }

    echo "\n6. Testing multiple agencies:\n";
    $agencies = Agency::take(3)->get();
    foreach ($agencies as $testAgency) {
        $agencyInquiries = Inquiry::where('AgencyID', $testAgency->AgencyID)->count();
        echo "   {$testAgency->AgencyName}: {$agencyInquiries} inquiries\n";
    }

    echo "\n=== Test completed successfully ===\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}
