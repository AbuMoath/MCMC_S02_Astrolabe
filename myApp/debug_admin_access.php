<?php
// Test admin access and database check
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "🔍 ADMIN ACCESS DEBUG TOOL\n";
echo "==========================\n\n";

try {
    // Check if we can connect to database
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=mcmc", "root", "");
    echo "✅ Database connection successful\n\n";
    
    // Check all tables
    echo "📊 CHECKING DATABASE TABLES:\n";
    echo "-----------------------------\n";
    
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($tables as $table) {
        echo "📋 Table: {$table}\n";
    }
    
    echo "\n📊 CHECKING ADMINS TABLE:\n";
    echo "-------------------------\n";
    
    $stmt = $pdo->query("SELECT AdminID, AdminName, AdminEmail, AdminUserName FROM administrators LIMIT 5");
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($admins)) {
        echo "❌ No administrators found in database\n";
        echo "💡 Creating a test admin...\n";
        
        $testAdminData = [
            'AdminName' => 'Test Admin',
            'AdminEmail' => 'admin@test.com',
            'AdminUserName' => 'admin',
            'AdminPassword' => password_hash('admin123', PASSWORD_DEFAULT),
            'AdminPhoneNum' => '1234567890'
        ];
        
        $insertStmt = $pdo->prepare("INSERT INTO administrators (AdminName, AdminEmail, AdminUserName, AdminPassword, AdminPhoneNum) VALUES (?, ?, ?, ?, ?)");
        $result = $insertStmt->execute(array_values($testAdminData));
        
        if ($result) {
            echo "✅ Test admin created successfully!\n";
            echo "📝 Login credentials:\n";
            echo "   Username: admin\n";
            echo "   Password: admin123\n";
        } else {
            echo "❌ Failed to create test admin\n";
        }
    } else {
        echo "✅ Found " . count($admins) . " admin(s):\n\n";
        foreach ($admins as $admin) {
            echo "🧑‍💼 Admin #{$admin['AdminID']}\n";
            echo "   Name: {$admin['AdminName']}\n";
            echo "   Email: {$admin['AdminEmail']}\n";
            echo "   Username: {$admin['AdminUserName']}\n";
            echo "   -------------------------\n";
        }
    }
    
    echo "\n🔐 SESSION CHECK:\n";
    echo "-----------------\n";
    
    // Start session to check current login status
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_SESSION['admin_id'])) {
        echo "✅ Admin is logged in with ID: " . $_SESSION['admin_id'] . "\n";
    } else {
        echo "❌ No admin session found\n";
        echo "💡 You need to login as admin to access admin pages\n";
    }
    
    echo "\n🌐 ROUTE ACCESS:\n";
    echo "----------------\n";
    echo "🔗 Admin Login: http://127.0.0.1:8000/login\n";
    echo "🔗 Admin Users: http://127.0.0.1:8000/admin/users\n";
    echo "🔗 Admin Home: http://127.0.0.1:8000/admin/home\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
