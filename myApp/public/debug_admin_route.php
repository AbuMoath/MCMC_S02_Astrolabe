<!DOCTYPE html>
<html>
<head>
    <title>Admin Notifications Route Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
    </style>
</head>
<body>
    <h1>Admin Notifications Route Test</h1>
    
    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    
    try {
        $app = require_once __DIR__ . '/bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        
        echo '<p class="success">✅ Laravel application bootstrapped successfully</p>';
        
        // Test if the controller class exists
        if (class_exists('App\Http\Controllers\Module4\NotificationController')) {
            echo '<p class="success">✅ Module4\NotificationController class exists</p>';
            
            // Test if the adminNotifications method exists
            $controller = new \App\Http\Controllers\Module4\NotificationController();
            if (method_exists($controller, 'adminNotifications')) {
                echo '<p class="success">✅ adminNotifications method exists</p>';
            } else {
                echo '<p class="error">❌ adminNotifications method does not exist</p>';
            }
            
            // Test if other required methods exist
            $methods = ['getUnreadCount', 'markAsRead', 'markAllAsRead'];
            foreach ($methods as $method) {
                if (method_exists($controller, $method)) {
                    echo '<p class="success">✅ ' . $method . ' method exists</p>';
                } else {
                    echo '<p class="error">❌ ' . $method . ' method does not exist</p>';
                }
            }
            
        } else {
            echo '<p class="error">❌ Module4\NotificationController class does not exist</p>';
        }
        
        // Test database connection for agency notes
        try {
            $adminNoteCount = \App\Models\AgencyNote::where('recipient_type', 'Administrator')->count();
            echo '<p class="success">✅ Database connection working - Found ' . $adminNoteCount . ' admin notes</p>';
        } catch (Exception $e) {
            echo '<p class="error">❌ Database error: ' . $e->getMessage() . '</p>';
        }
        
    } catch (Exception $e) {
        echo '<p class="error">❌ Error: ' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }
    ?>
    
    <h3>Fixed Issues:</h3>
    <ul>
        <li>✅ Fixed import: Changed from <code>NotificationController</code> to <code>Module4\NotificationController</code></li>
        <li>✅ Added missing methods: getUnreadCount, publicNotifications, etc.</li>
        <li>✅ Fixed middleware: Changed from 'auth' to 'admin.auth'</li>
        <li>✅ Updated adminNotifications method to fetch agency notes</li>
    </ul>
    
    <h3>Admin Notifications Should Now Work:</h3>
    <ol>
        <li>Login as admin user</li>
        <li>Click "Notifications" button in admin sidebar</li>
        <li>Should no longer show "Target class does not exist" error</li>
        <li>Should display admin notifications page with any agency notes</li>
    </ol>
    
    <p><strong>Admin Notifications URL:</strong> <a href="/admin/notifications">/admin/notifications</a></p>
</body>
</html>
