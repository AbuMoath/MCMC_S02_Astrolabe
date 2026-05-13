<!DOCTYPE html>
<html>
<head>
    <title>Create Agency Notes Table</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
    </style>
</head>
<body>
    <h1>Create Agency Notes Table</h1>
      <?php
    require_once __DIR__ . '/../vendor/autoload.php';
    
    try {
        $app = require_once __DIR__ . '/../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        
        echo '<p class="info">Checking database connection...</p>';
        
        // Test database connection
        $pdo = \DB::connection()->getPdo();
        echo '<p class="success">✅ Database connected successfully</p>';
        
        // Check if table exists
        if (\Schema::hasTable('agency_notes')) {
            echo '<p class="success">✅ Table "agency_notes" already exists.</p>';
        } else {
            echo '<p class="info">Creating table "agency_notes"...</p>';
            
            // Create the table using raw SQL to ensure it works
            \DB::statement('
                CREATE TABLE `agency_notes` (
                  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                  `inquiry_id` bigint(20) unsigned NOT NULL,
                  `agency_id` bigint(20) unsigned NOT NULL,
                  `agency_name` varchar(255) NOT NULL,
                  `recipient_type` enum("User","Administrator") NOT NULL,
                  `comment` text NOT NULL,
                  `supporting_document` varchar(255) DEFAULT NULL,
                  `user_id` bigint(20) unsigned DEFAULT NULL,
                  `created_at` timestamp NULL DEFAULT NULL,
                  `updated_at` timestamp NULL DEFAULT NULL,
                  PRIMARY KEY (`id`),
                  KEY `agency_notes_inquiry_id_recipient_type_index` (`inquiry_id`,`recipient_type`),
                  KEY `agency_notes_user_id_created_at_index` (`user_id`,`created_at`),
                  KEY `agency_notes_agency_id_index` (`agency_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ');
            
            echo '<p class="success">✅ Table "agency_notes" created successfully!</p>';
        }
        
        // Test table functionality
        echo '<p class="info">Testing table functionality...</p>';
        
        $count = \DB::table('agency_notes')->count();
        echo '<p class="info">Current notes count: ' . $count . '</p>';
        
        echo '<p class="success">✅ Table is ready for use!</p>';
        
        echo '<h3>Next Steps:</h3>';
        echo '<ol>';
        echo '<li>Go to the agency page</li>';
        echo '<li>Click "Add Notes" on any inquiry</li>';
        echo '<li>Select "User" as recipient and add a comment</li>';
        echo '<li>Submit the form</li>';
        echo '<li>Login as the user who submitted that inquiry</li>';
        echo '<li>Go to notifications page - the note should appear!</li>';
        echo '</ol>';
        
    } catch (Exception $e) {
        echo '<p class="error">❌ Error: ' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }
    ?>
</body>
</html>
