<?php

/**
 * Module3 Controller Organization Test
 * This file tests that all Module3 controllers can be instantiated properly
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Http\Controllers\Module3\PublicUser\UserController as Module3UserController;
use App\Http\Controllers\Module3\PublicUser\InquiryController as Module3InquiryController;
use App\Http\Controllers\Module3\Admin\AdminController as Module3AdminController;
use App\Http\Controllers\Module3\Agency\AgencyController as Module3AgencyController;
use App\Http\Controllers\Module3\Agency\AgencyReviewAndNotificationController as Module3AgencyReviewController;

echo "Testing Module3 Controller Organization...\n\n";

try {
    // Test Module3 PublicUser Controllers
    echo "✓ Module3\PublicUser\UserController: ";
    $userController = new Module3UserController();
    echo "OK\n";
    
    echo "✓ Module3\PublicUser\InquiryController: ";
    $inquiryController = new Module3InquiryController();
    echo "OK\n";
    
    // Test Module3 Admin Controllers
    echo "✓ Module3\Admin\AdminController: ";
    $adminController = new Module3AdminController();
    echo "OK\n";
    
    // Test Module3 Agency Controllers
    echo "✓ Module3\Agency\AgencyController: ";
    $agencyController = new Module3AgencyController();
    echo "OK\n";
    
    echo "✓ Module3\Agency\AgencyReviewAndNotificationController: ";
    $agencyReviewController = new Module3AgencyReviewController();
    echo "OK\n";
    
    echo "\n✅ All Module3 controllers loaded successfully!\n";
    echo "📁 Module3 controller organization is complete.\n\n";
    
    echo "Controller Structure:\n";
    echo "├── Module3/\n";
    echo "│   ├── PublicUser/\n";
    echo "│   │   ├── UserController.php\n";
    echo "│   │   └── InquiryController.php\n";
    echo "│   ├── Admin/\n";
    echo "│   │   └── AdminController.php\n";
    echo "│   └── Agency/\n";
    echo "│       ├── AgencyController.php\n";
    echo "│       └── AgencyReviewAndNotificationController.php\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Location: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
