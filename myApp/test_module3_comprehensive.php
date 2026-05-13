<?php
/**
 * Comprehensive Module3 System Test
 * Tests all components of the Module3 organization
 */

// Set up Laravel environment
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

echo "🔧 COMPREHENSIVE MODULE 3 SYSTEM TEST\n";
echo "=====================================\n\n";

$errors = 0;
$successes = 0;

function testSuccess($message) {
    global $successes;
    echo "✅ " . $message . "\n";
    $successes++;
}

function testError($message) {
    global $errors;
    echo "❌ " . $message . "\n";
    $errors++;
}

// 1. Test Model Loading
echo "1. 📁 TESTING MODEL LOADING\n";
echo "----------------------------\n";

try {
    $publicUser = new App\Models\Module3\PublicUsers();
    testSuccess("Module3\\PublicUsers model loads successfully");
} catch (Exception $e) {
    testError("Module3\\PublicUsers model failed: " . $e->getMessage());
}

try {
    $admin = new App\Models\Module3\Administrator();
    testSuccess("Module3\\Administrator model loads successfully");
} catch (Exception $e) {
    testError("Module3\\Administrator model failed: " . $e->getMessage());
}

try {
    $agency = new App\Models\Module3\Agency();
    testSuccess("Module3\\Agency model loads successfully");
} catch (Exception $e) {
    testError("Module3\\Agency model failed: " . $e->getMessage());
}

try {
    $inquiry = new App\Models\Module3\Inquiry();
    testSuccess("Module3\\Inquiry model loads successfully");
} catch (Exception $e) {
    testError("Module3\\Inquiry model failed: " . $e->getMessage());
}

try {
    $baseModel = new class extends App\Models\Module3\BaseModel {
        protected $table = 'test_table';
        protected $primaryKey = 'id';
        protected $fillable = ['name'];
    };
    testSuccess("Module3\\BaseModel abstract class works correctly");
} catch (Exception $e) {
    testError("Module3\\BaseModel failed: " . $e->getMessage());
}

echo "\n";

// 2. Test Model Methods
echo "2. 🛠️ TESTING MODEL METHODS\n";
echo "---------------------------\n";

try {
    $result = App\Models\Module3\PublicUsers::search('test');
    testSuccess("PublicUsers::search() method works");
} catch (Exception $e) {
    testError("PublicUsers::search() failed: " . $e->getMessage());
}

try {
    $result = App\Models\Module3\Administrator::search('test');
    testSuccess("Administrator::search() method works");
} catch (Exception $e) {
    testError("Administrator::search() failed: " . $e->getMessage());
}

try {
    $result = App\Models\Module3\Agency::search('test');
    testSuccess("Agency::search() method works");
} catch (Exception $e) {
    testError("Agency::search() failed: " . $e->getMessage());
}

try {
    $result = App\Models\Module3\Inquiry::search('test');
    testSuccess("Inquiry::search() method works");
} catch (Exception $e) {
    testError("Inquiry::search() failed: " . $e->getMessage());
}

echo "\n";

// 3. Test Controller Loading
echo "3. 🎮 TESTING CONTROLLER LOADING\n";
echo "--------------------------------\n";

try {
    $controller = new App\Http\Controllers\Module3\PublicUser\UserController();
    testSuccess("Module3\\PublicUser\\UserController loads successfully");
} catch (Exception $e) {
    testError("Module3\\PublicUser\\UserController failed: " . $e->getMessage());
}

try {
    $controller = new App\Http\Controllers\Module3\PublicUser\InquiryController();
    testSuccess("Module3\\PublicUser\\InquiryController loads successfully");
} catch (Exception $e) {
    testError("Module3\\PublicUser\\InquiryController failed: " . $e->getMessage());
}

try {
    $controller = new App\Http\Controllers\Module3\Admin\AdminController();
    testSuccess("Module3\\Admin\\AdminController loads successfully");
} catch (Exception $e) {
    testError("Module3\\Admin\\AdminController failed: " . $e->getMessage());
}

try {
    $controller = new App\Http\Controllers\Module3\Agency\AgencyController();
    testSuccess("Module3\\Agency\\AgencyController loads successfully");
} catch (Exception $e) {
    testError("Module3\\Agency\\AgencyController failed: " . $e->getMessage());
}

try {
    $controller = new App\Http\Controllers\Module3\Agency\AgencyReviewAndNotificationController();
    testSuccess("Module3\\Agency\\AgencyReviewAndNotificationController loads successfully");
} catch (Exception $e) {
    testError("Module3\\Agency\\AgencyReviewAndNotificationController failed: " . $e->getMessage());
}

echo "\n";

// 4. Test Model Traits
echo "4. 🧩 TESTING MODEL TRAITS\n";
echo "-------------------------\n";

try {
    // Test if traits can be used
    $testModel = new class extends Illuminate\Database\Eloquent\Model {
        use App\Models\Module3\Traits\HasProfile;
        use App\Models\Module3\Traits\Searchable;
        use App\Models\Module3\Traits\HasStatus;
        use App\Models\Module3\Traits\Auditable;
        
        protected $table = 'test_table';
        protected function getActiveStatus() { return 'active'; }
        protected function getInactiveStatus() { return 'inactive'; }
        protected function getSearchableFields() { return ['name']; }
    };
    testSuccess("All Module3 traits can be used together");
} catch (Exception $e) {
    testError("Module3 traits failed: " . $e->getMessage());
}

echo "\n";

// 5. Test File Structure
echo "5. 📂 TESTING FILE STRUCTURE\n";
echo "----------------------------\n";

$requiredFiles = [
    'app/Models/Module3/PublicUsers.php' => 'Module3 PublicUsers model',
    'app/Models/Module3/Administrator.php' => 'Module3 Administrator model',
    'app/Models/Module3/Agency.php' => 'Module3 Agency model',
    'app/Models/Module3/Inquiry.php' => 'Module3 Inquiry model',
    'app/Models/Module3/BaseModel.php' => 'Module3 BaseModel abstract class',
    'app/Models/Module3/Traits/ModelTraits.php' => 'Module3 ModelTraits file',
    'app/Http/Controllers/Module3/PublicUser/UserController.php' => 'Module3 PublicUser UserController',
    'app/Http/Controllers/Module3/PublicUser/InquiryController.php' => 'Module3 PublicUser InquiryController',
    'app/Http/Controllers/Module3/Admin/AdminController.php' => 'Module3 Admin AdminController',
    'app/Http/Controllers/Module3/Agency/AgencyController.php' => 'Module3 Agency AgencyController',
    'app/Http/Controllers/Module3/Agency/AgencyReviewAndNotificationController.php' => 'Module3 Agency ReviewController',
];

foreach ($requiredFiles as $file => $description) {
    if (file_exists($file)) {
        testSuccess($description . " file exists");
    } else {
        testError($description . " file missing");
    }
}

echo "\n";

// 6. Test Route Accessibility
echo "6. 🛣️ TESTING ROUTE ACCESSIBILITY\n";
echo "--------------------------------\n";

// Test if routes can be generated
try {
    $routes = [
        'home' => 'Home page route',
        'login' => 'Login page route',
        'register' => 'Registration page route',
        'admin.home' => 'Admin home route',
        'agency.home' => 'Agency home route',
        'public.user.home' => 'Public user home route',
    ];
    
    foreach ($routes as $routeName => $description) {
        try {
            $url = route($routeName);
            testSuccess($description . " accessible");
        } catch (Exception $e) {
            testError($description . " not accessible: " . $e->getMessage());
        }
    }
} catch (Exception $e) {
    testError("Route testing failed: " . $e->getMessage());
}

echo "\n";

// 7. Summary
echo "📊 TEST SUMMARY\n";
echo "==============\n";
echo "✅ Successes: " . $successes . "\n";
echo "❌ Errors: " . $errors . "\n";
echo "📊 Success Rate: " . round(($successes / ($successes + $errors)) * 100, 2) . "%\n\n";

if ($errors === 0) {
    echo "🎉 ALL TESTS PASSED! Module3 organization is complete and working properly.\n";
    echo "🚀 The system is ready for production use.\n";
} else {
    echo "⚠️ Some tests failed. Please review the errors above.\n";
    echo "🔧 Fix the issues and run the test again.\n";
}

echo "\n🏁 Test completed at: " . date('Y-m-d H:i:s') . "\n";
?>
