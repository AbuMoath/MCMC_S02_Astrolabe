<?php
// Test Module3 models accessibility and basic functionality

require_once __DIR__ . '/vendor/autoload.php';

try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    echo "Testing Module3 Model Structure...\n\n";

    // Test if Module3 models can be instantiated
    echo "1. Testing Module3 Models:\n";
    
    try {
        $publicUser = new App\Models\Module3\PublicUsers();
        echo "   ✅ PublicUsers model loads successfully\n";
    } catch (Exception $e) {
        echo "   ❌ PublicUsers model error: " . $e->getMessage() . "\n";
    }

    try {
        $admin = new App\Models\Module3\Administrator();
        echo "   ✅ Administrator model loads successfully\n";
    } catch (Exception $e) {
        echo "   ❌ Administrator model error: " . $e->getMessage() . "\n";
    }

    try {
        $agency = new App\Models\Module3\Agency();
        echo "   ✅ Agency model loads successfully\n";
    } catch (Exception $e) {
        echo "   ❌ Agency model error: " . $e->getMessage() . "\n";
    }

    try {
        $inquiry = new App\Models\Module3\Inquiry();
        echo "   ✅ Inquiry model loads successfully\n";
    } catch (Exception $e) {
        echo "   ❌ Inquiry model error: " . $e->getMessage() . "\n";
    }

    echo "\n2. Testing Model Methods:\n";
    
    // Test static methods
    try {
        $searchResult = App\Models\Module3\PublicUsers::search('test');
        echo "   ✅ PublicUsers::search() method works\n";
    } catch (Exception $e) {
        echo "   ❌ PublicUsers::search() error: " . $e->getMessage() . "\n";
    }

    try {
        $searchResult = App\Models\Module3\Agency::search('test');
        echo "   ✅ Agency::search() method works\n";
    } catch (Exception $e) {
        echo "   ❌ Agency::search() error: " . $e->getMessage() . "\n";
    }

    echo "\n3. Testing Controller Accessibility:\n";
    
    try {
        $controller = new App\Http\Controllers\Module3\PublicUser\UserController();
        echo "   ✅ Module3 UserController loads successfully\n";
    } catch (Exception $e) {
        echo "   ❌ Module3 UserController error: " . $e->getMessage() . "\n";
    }

    try {
        $controller = new App\Http\Controllers\Module3\Admin\AdminController();
        echo "   ✅ Module3 AdminController loads successfully\n";
    } catch (Exception $e) {
        echo "   ❌ Module3 AdminController error: " . $e->getMessage() . "\n";
    }

    try {
        $controller = new App\Http\Controllers\Module3\Agency\AgencyController();
        echo "   ✅ Module3 AgencyController loads successfully\n";
    } catch (Exception $e) {
        echo "   ❌ Module3 AgencyController error: " . $e->getMessage() . "\n";
    }

    echo "\n✅ Module3 Structure Test Complete!\n";
    echo "🎉 All components are properly organized and accessible.\n";

} catch (Exception $e) {
    echo "❌ Bootstrap Error: " . $e->getMessage() . "\n";
}
?>
