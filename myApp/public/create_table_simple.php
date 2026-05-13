<?php
// Direct SQL execution to create reassignment_requests table
// Access this via: http://localhost/mcmc/myApp/public/create_table_simple.php

echo "<h2>Creating reassignment_requests table...</h2>";

try {
    // Database connection
    $mysqli = new mysqli("localhost", "root", "", "mcmc");
    
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    echo "<p>✅ Connected to database successfully</p>";
    
    // Drop table if exists
    $mysqli->query("DROP TABLE IF EXISTS reassignment_requests");
    echo "<p>✅ Cleared any existing table</p>";
    
    // Create table with simple structure first
    $sql = "CREATE TABLE reassignment_requests (
        RequestID int AUTO_INCREMENT PRIMARY KEY,
        InquiryID int NOT NULL,
        RequestingAgencyID int NOT NULL,
        RequestReason text NOT NULL,
        RequestStatus varchar(50) DEFAULT 'Pending',
        AdminID int NULL,
        AdminResponse text NULL,
        NewAgencyID int NULL,
        created_at timestamp DEFAULT CURRENT_TIMESTAMP,
        updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($mysqli->query($sql)) {
        echo "<p>✅ Table 'reassignment_requests' created successfully!</p>";
        
        // Test insert
        $testInsert = "INSERT INTO reassignment_requests (InquiryID, RequestingAgencyID, RequestReason) VALUES (1, 1, 'Test reason')";
        if ($mysqli->query($testInsert)) {
            echo "<p>✅ Test insert successful</p>";
            // Delete test record
            $mysqli->query("DELETE FROM reassignment_requests WHERE RequestReason = 'Test reason'");
            echo "<p>✅ Test record cleaned up</p>";
        }
        
        echo "<h3>🎉 SUCCESS!</h3>";
        echo "<p>The reassignment_requests table has been created and is ready to use.</p>";
        echo "<p><strong>You can now go back to your application and try the Request Reassignment feature again.</strong></p>";
        echo "<p><em>Remember to delete this file after use for security.</em></p>";
        
    } else {
        echo "<p>❌ Error creating table: " . $mysqli->error . "</p>";
    }
    
    $mysqli->close();
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}
?>
