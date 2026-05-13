<?php

require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Check for rejected inquiries
$inquiries = \App\Models\Inquiry::where('InquiryStatus', 'Rejected')->get();

echo "Total rejected inquiries: " . $inquiries->count() . "\n";

foreach($inquiries as $inquiry) {
    echo "ID: " . $inquiry->InquiryID . 
         ", Status: " . $inquiry->InquiryStatus . 
         ", Agency: " . ($inquiry->agency ? $inquiry->agency->AgencyName : 'None') . 
         ", Comments: " . ($inquiry->StatusComments ?? 'None') . 
         ", Processed At: " . ($inquiry->ProcessedAt ?? 'None') . "\n";
}

// Also check the recent inquiries with different statuses
echo "\nAll inquiry statuses:\n";
$allInquiries = \App\Models\Inquiry::selectRaw('InquiryStatus, COUNT(*) as count')
    ->groupBy('InquiryStatus')
    ->get();

foreach($allInquiries as $status) {
    echo $status->InquiryStatus . ": " . $status->count . "\n";
}
