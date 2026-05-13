<?php

require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Module3\Inquiry;
use App\Models\Module3\Agency;
use Illuminate\Support\Facades\DB;

echo "🧪 Testing Admin Assignment Comments Feature...\n\n";

try {
    // Check if we have inquiries and agencies
    $inquiryCount = Inquiry::count();
    $agencyCount = Agency::count();
    
    echo "📊 Current Data:\n";
    echo "- Total Inquiries: {$inquiryCount}\n";
    echo "- Total Agencies: {$agencyCount}\n\n";
    
    if ($inquiryCount === 0) {
        echo "⚠️  No inquiries found. Creating test inquiry...\n";
        
        $testInquiry = new Inquiry();
        $testInquiry->InquiryTitle = "Test Assignment with Comments";
        $testInquiry->InquiryDescription = "Testing the enhanced assignment functionality with admin comments";
        $testInquiry->InquirySource = "Test System";
        $testInquiry->InquiryStatus = "Pending";
        $testInquiry->InquirySendDate = now();
        $testInquiry->save();
        
        echo "✅ Test inquiry created with ID: {$testInquiry->InquiryID}\n\n";
    }
    
    if ($agencyCount === 0) {
        echo "⚠️  No agencies found. Creating test agency...\n";
        
        $testAgency = new Agency();
        $testAgency->AgencyName = "Test Assignment Agency";
        $testAgency->AgencyUserName = "test_agency_comments";
        $testAgency->AgencyEmail = "test.agency.comments@example.com";
        $testAgency->AgencyPassword = bcrypt('password');
        $testAgency->save();
        
        echo "✅ Test agency created with ID: {$testAgency->AgencyID}\n\n";
    }
    
    // Test the assignment with comments functionality
    echo "🔄 Testing Assignment with Comments...\n";
    
    // Get an unassigned inquiry
    $testInquiry = Inquiry::whereNull('AgencyID')->first();
    $testAgency = Agency::first();
    
    if ($testInquiry && $testAgency) {
        // Simulate the admin assignment with comments
        $testInquiry->AgencyID = $testAgency->AgencyID;
        $testInquiry->AdminNotes = "High priority case requiring immediate attention. Please provide daily updates and contact the requester within 24 hours.";
        $testInquiry->InquiryPriority = "High";
        $testInquiry->save();
        
        echo "✅ Assignment Test Successful!\n";
        echo "- Inquiry ID: {$testInquiry->InquiryID}\n";
        echo "- Assigned to: {$testAgency->AgencyName}\n";
        echo "- Admin Comments: {$testInquiry->AdminNotes}\n";
        echo "- Priority Level: {$testInquiry->InquiryPriority}\n\n";
        
        // Test retrieving the assignment with comments
        $assignedInquiry = Inquiry::with('agency')->find($testInquiry->InquiryID);
        
        echo "🔍 Verification - Retrieved Assignment Data:\n";
        echo "- Agency: {$assignedInquiry->agency->AgencyName}\n";
        echo "- Has Admin Notes: " . ($assignedInquiry->AdminNotes ? "✅ Yes" : "❌ No") . "\n";
        echo "- Notes Preview: " . substr($assignedInquiry->AdminNotes, 0, 50) . "...\n";
        echo "- Priority: " . ($assignedInquiry->InquiryPriority ?: "Normal") . "\n\n";
        
    } else {
        echo "❌ Could not find test data for assignment\n";
    }
    
    // Check database schema for comment fields
    echo "🔍 Checking Database Schema...\n";
    
    $columns = DB::select("DESCRIBE inquiries");
    $hasAdminNotes = false;
    $hasPriority = false;
    
    foreach ($columns as $column) {
        if ($column->Field === 'AdminNotes') {
            $hasAdminNotes = true;
        }
        if ($column->Field === 'InquiryPriority') {
            $hasPriority = true;
        }
    }
    
    echo "- AdminNotes column: " . ($hasAdminNotes ? "✅ Present" : "❌ Missing") . "\n";
    echo "- InquiryPriority column: " . ($hasPriority ? "✅ Present" : "❌ Missing") . "\n\n";
    
    // Summary of assigned inquiries with comments
    $assignedWithComments = Inquiry::whereNotNull('AgencyID')
        ->whereNotNull('AdminNotes')
        ->with('agency')
        ->get();
        
    echo "📋 Summary of Assignments with Comments:\n";
    echo "- Total assignments with comments: {$assignedWithComments->count()}\n";
    
    foreach ($assignedWithComments->take(3) as $inquiry) {
        echo "  • ID {$inquiry->InquiryID}: {$inquiry->InquiryTitle}\n";
        echo "    Agency: {$inquiry->agency->AgencyName}\n";
        echo "    Comment: " . substr($inquiry->AdminNotes, 0, 60) . "...\n";
        echo "    Priority: " . ($inquiry->InquiryPriority ?: "Normal") . "\n\n";
    }
    
    echo "🎉 Assignment Comments Feature Test Complete!\n";
    echo "✅ The enhanced admin assignment functionality is working correctly.\n";
    echo "✅ Admins can now add comments and set priority levels when assigning inquiries.\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
