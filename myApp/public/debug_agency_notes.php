<!DOCTYPE html>
<html>
<head>
    <title>Agency Notes Debug</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .success { color: green; }
        .error { color: red; }
        .info { color: blue; }
        pre { background: #f5f5f5; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Agency Notes Debug Page</h1>
    
    <?php
    require_once __DIR__ . '/vendor/autoload.php';
    
    try {
        $app = require_once __DIR__ . '/bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        
        echo '<p class="success">✅ Laravel application bootstrapped successfully</p>';
        
        // Test database connection
        try {
            $pdo = \DB::connection()->getPdo();
            echo '<p class="success">✅ Database connection successful</p>';
        } catch (Exception $e) {
            echo '<p class="error">❌ Database connection failed: ' . $e->getMessage() . '</p>';
        }
        
        // Check if agency_notes table exists
        try {
            $tableExists = \Schema::hasTable('agency_notes');
            if ($tableExists) {
                echo '<p class="success">✅ agency_notes table exists</p>';
                
                // Count existing notes
                $noteCount = \App\Models\AgencyNote::count();
                echo '<p class="info">📊 Current agency notes count: ' . $noteCount . '</p>';
                
                // Show some sample data
                $sampleNotes = \App\Models\AgencyNote::with(['inquiry', 'agency'])->limit(3)->get();
                echo '<h3>Sample Agency Notes:</h3>';
                echo '<pre>' . json_encode($sampleNotes->toArray(), JSON_PRETTY_PRINT) . '</pre>';
                
            } else {
                echo '<p class="error">❌ agency_notes table does not exist. Run migrations first.</p>';
            }
        } catch (Exception $e) {
            echo '<p class="error">❌ Error checking table: ' . $e->getMessage() . '</p>';
        }
        
        // Check models
        try {
            $agencyNote = new \App\Models\AgencyNote();
            echo '<p class="success">✅ AgencyNote model loaded successfully</p>';
            echo '<p class="info">Fillable fields: ' . implode(', ', $agencyNote->getFillable()) . '</p>';
        } catch (Exception $e) {
            echo '<p class="error">❌ AgencyNote model error: ' . $e->getMessage() . '</p>';
        }
        
        // Check if we have any inquiries and agencies for testing
        try {
            $inquiryCount = \App\Models\Inquiry::count();
            $agencyCount = \App\Models\Agency::count();
            
            echo '<p class="info">📊 Inquiries in database: ' . $inquiryCount . '</p>';
            echo '<p class="info">📊 Agencies in database: ' . $agencyCount . '</p>';
            
            if ($inquiryCount > 0 && $agencyCount > 0) {
                echo '<p class="success">✅ Sample data available for testing</p>';
            } else {
                echo '<p class="error">❌ No sample data. Create some inquiries and agencies first.</p>';
            }
        } catch (Exception $e) {
            echo '<p class="error">❌ Error checking sample data: ' . $e->getMessage() . '</p>';
        }
        
    } catch (Exception $e) {
        echo '<p class="error">❌ Failed to bootstrap Laravel: ' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    }
    ?>
    
    <h3>How to Test:</h3>
    <ol>
        <li>Make sure you have agencies and inquiries in your database</li>
        <li>Login as an agency user</li>
        <li>Go to the agency inquiry management page</li>
        <li>Click "Add Notes" on any inquiry</li>
        <li>Select "User" as recipient and add a comment</li>
        <li>Submit the form</li>
        <li>Login as the user who submitted that inquiry</li>
        <li>Go to the notifications page</li>
        <li>The agency note should appear in the notifications</li>
    </ol>
    
    <h3>Troubleshooting:</h3>
    <ul>
        <li>If agency_notes table doesn't exist, run: <code>php artisan migrate</code></li>
        <li>If database connection fails, check your .env file</li>
        <li>If no sample data, create some inquiries and agencies through the app</li>
    </ul>
</body>
</html>
