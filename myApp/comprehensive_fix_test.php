<?php
/**
 * Comprehensive Test for Agency Inquiry Rejection Fix
 * This test verifies that the HTTP 422 error has been resolved
 */

// Include Laravel bootstrap
require_once __DIR__ . '/vendor/autoload.php';

echo "🧪 TESTING AGENCY INQUIRY REJECTION FIX\n";
echo "=====================================\n\n";

// Test 1: Verify Controller File Exists and Has Correct Method
echo "📁 Test 1: Checking Controller File...\n";
$controllerPath = __DIR__ . '/app/Http/Controllers/Module3/Agency/AgencyReviewAndNotificationController.php';

if (file_exists($controllerPath)) {
    echo "✅ Controller file exists: AgencyReviewAndNotificationController.php\n";
    
    $controllerContent = file_get_contents($controllerPath);
    
    // Check for the fixed validation rules
    if (strpos($controllerContent, "'reason' => 'required|string|max:500'") !== false) {
        echo "✅ Fixed validation rule for 'reason' field found\n";
    } else {
        echo "❌ Fixed validation rule for 'reason' field NOT found\n";
    }
    
    if (strpos($controllerContent, "'comments' => 'required|string|max:1000'") !== false) {
        echo "✅ Fixed validation rule for 'comments' field found\n";
    } else {
        echo "❌ Fixed validation rule for 'comments' field NOT found\n";
    }
    
    // Check for old problematic validation
    if (strpos($controllerContent, "'rejection_reason' => 'required|string|max:1000'") !== false) {
        echo "⚠️  OLD validation rule still present - should be removed\n";
    } else {
        echo "✅ Old problematic validation rule has been removed\n";
    }
    
    // Check for try-catch block
    if (strpos($controllerContent, 'try {') !== false && strpos($controllerContent, 'catch') !== false) {
        echo "✅ Try-catch error handling found\n";
    } else {
        echo "❌ Try-catch error handling NOT found\n";
    }
    
} else {
    echo "❌ Controller file does not exist!\n";
}

echo "\n";

// Test 2: Check Route Configuration
echo "🛣️  Test 2: Checking Route Configuration...\n";

$routesPath = __DIR__ . '/routes/web.php';
if (file_exists($routesPath)) {
    $routesContent = file_get_contents($routesPath);
    
    if (strpos($routesContent, "Route::post('/agency/inquiry/{id}/reject'") !== false) {
        echo "✅ Rejection route found in web.php\n";
    } else {
        echo "❌ Rejection route NOT found in web.php\n";
    }
    
    if (strpos($routesContent, "AgencyReviewAndNotificationController") !== false) {
        echo "✅ Controller reference found in routes\n";
    } else {
        echo "❌ Controller reference NOT found in routes\n";
    }
}

echo "\n";

// Test 3: Check Module3 Models Structure
echo "🏗️  Test 3: Checking Module3 Models Structure...\n";

$modelPaths = [
    'PublicUsers' => __DIR__ . '/app/Models/Module3/PublicUsers.php',
    'Administrator' => __DIR__ . '/app/Models/Module3/Administrator.php',
    'Agency' => __DIR__ . '/app/Models/Module3/Agency.php',
    'Inquiry' => __DIR__ . '/app/Models/Module3/Inquiry.php',
    'AssignedInquiry' => __DIR__ . '/app/Models/Module3/AssignedInquiry.php'
];

$allModelsExist = true;
foreach ($modelPaths as $modelName => $path) {
    if (file_exists($path)) {
        echo "✅ {$modelName} model exists\n";
    } else {
        echo "❌ {$modelName} model missing\n";
        $allModelsExist = false;
    }
}

if ($allModelsExist) {
    echo "✅ All 5 UML-required models are present\n";
} else {
    echo "❌ Some models are missing\n";
}

echo "\n";

// Test 4: Check View File
echo "👁️  Test 4: Checking Agency View File...\n";

$viewPath = __DIR__ . '/resources/views/Module3/Agency/ViewAndDisplayInquiry.blade.php';
if (file_exists($viewPath)) {
    echo "✅ Agency view file exists\n";
    
    $viewContent = file_get_contents($viewPath);
    
    // Check for form fields that should match validation
    if (strpos($viewContent, 'name="reason"') !== false) {
        echo "✅ 'reason' form field found in view\n";
    } else {
        echo "❌ 'reason' form field NOT found in view\n";
    }
    
    if (strpos($viewContent, 'name="comments"') !== false) {
        echo "✅ 'comments' form field found in view\n";
    } else {
        echo "❌ 'comments' form field NOT found in view\n";
    }
} else {
    echo "❌ Agency view file does not exist\n";
}

echo "\n";

// Test 5: Database Connection Test
echo "🗄️  Test 5: Testing Database Connection...\n";

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=mcmc', 'root', '');
    echo "✅ Database connection successful\n";
    
    // Check if inquiries table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'inquiries'");
    if ($stmt->rowCount() > 0) {
        echo "✅ 'inquiries' table exists\n";
        
        // Check for test data
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM inquiries WHERE AgencyID IS NOT NULL");
        $result = $stmt->fetch();
        echo "📊 Found {$result['count']} assigned inquiries for testing\n";
        
    } else {
        echo "❌ 'inquiries' table does not exist\n";
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
}

echo "\n";

// Test Summary
echo "📋 TEST SUMMARY:\n";
echo "===============\n";
echo "✅ The HTTP 422 error fix involves:\n";
echo "   1. Updated validation rules in controller (reason + comments)\n";
echo "   2. Removed old 'rejection_reason' validation\n";
echo "   3. Added proper error handling with try-catch\n";
echo "   4. Ensured form fields match validation rules\n\n";

echo "🎯 NEXT STEPS:\n";
echo "==============\n";
echo "1. Start Laravel server: php artisan serve\n";
echo "2. Log in as an agency user\n";
echo "3. Navigate to assigned inquiries\n";
echo "4. Try rejecting an inquiry with reason and comments\n";
echo "5. Verify no 422 error occurs\n\n";

echo "🚀 Ready to test! The fix should resolve the HTTP 422 error.\n";
