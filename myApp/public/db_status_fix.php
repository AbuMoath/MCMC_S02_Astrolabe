<?php
// Direct database table creation script
// This will create the reassignment_requests table

header('Content-Type: text/html; charset=utf-8');
echo "<!DOCTYPE html><html><head><title>Create Table</title></head><body>";
echo "<h2>Creating reassignment_requests table...</h2>";

try {
    // Try different connection methods
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'mcmc';
    
    // Method 1: MySQLi
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    
    echo "<p style='color: green;'>✅ Connected to database successfully</p>";
    
    // Drop existing table if it exists
    $dropSql = "DROP TABLE IF EXISTS reassignment_requests";
    if ($conn->query($dropSql)) {
        echo "<p style='color: blue;'>✅ Removed any existing table</p>";
    }
    
    // Create the table
    $createSql = "
    CREATE TABLE reassignment_requests (
        RequestID int(11) NOT NULL AUTO_INCREMENT,
        InquiryID int(11) NOT NULL,
        RequestingAgencyID int(11) NOT NULL,
        RequestReason text NOT NULL,
        RequestStatus varchar(50) NOT NULL DEFAULT 'Pending',
        AdminID int(11) DEFAULT NULL,
        AdminResponse text DEFAULT NULL,
        NewAgencyID int(11) DEFAULT NULL,
        created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (RequestID)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($createSql)) {
        echo "<p style='color: green;'>✅ Table 'reassignment_requests' created successfully!</p>";
    } else {
        throw new Exception("Error creating table: " . $conn->error);
    }
    
    // Test the table by inserting and deleting a test record
    $testInsert = "INSERT INTO reassignment_requests (InquiryID, RequestingAgencyID, RequestReason) VALUES (999, 999, 'TEST_RECORD')";
    if ($conn->query($testInsert)) {
        echo "<p style='color: green;'>✅ Test insert successful</p>";
        
        // Delete the test record
        $testDelete = "DELETE FROM reassignment_requests WHERE RequestReason = 'TEST_RECORD'";
        if ($conn->query($testDelete)) {
            echo "<p style='color: green;'>✅ Test record cleaned up</p>";
        }
    }
    
    // Show table structure
    $result = $conn->query("DESCRIBE reassignment_requests");
    if ($result) {
        echo "<h3>Table Structure:</h3>";
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr style='background: #f0f0f0;'><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Key']) . "</td>";
            echo "<td>" . htmlspecialchars($row['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    $conn->close();
    
    echo "<div style='background: #d4edda; border: 1px solid #c3e6cb; padding: 15px; margin: 20px 0; border-radius: 5px;'>";
    echo "<h2 style='color: #155724; margin: 0 0 10px 0;'>🎉 SUCCESS!</h2>";
    echo "<p style='color: #155724; margin: 0;'>The reassignment_requests table has been created successfully!</p>";
    echo "<p style='color: #155724; margin: 10px 0 0 0;'><strong>You can now go back to your application and use the Request Reassignment feature.</strong></p>";
    echo "</div>";
    
    echo "<div style='background: #fff3cd; border: 1px solid #ffeaa7; padding: 10px; margin: 10px 0; border-radius: 5px;'>";
    echo "<p style='color: #856404; margin: 0;'><strong>Security Note:</strong> Please delete this file (db_status_fix.php) after use.</p>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; margin: 20px 0; border-radius: 5px;'>";
    echo "<h3 style='color: #721c24; margin: 0 0 10px 0;'>❌ Error</h3>";
    echo "<p style='color: #721c24; margin: 0;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<h4 style='color: #721c24; margin: 15px 0 5px 0;'>Troubleshooting:</h4>";
    echo "<ul style='color: #721c24; margin: 0;'>";
    echo "<li>Make sure XAMPP is running</li>";
    echo "<li>Check that MySQL service is started</li>";
    echo "<li>Verify the database 'mcmc' exists</li>";
    echo "<li>Confirm the database credentials are correct</li>";
    echo "</ul>";
    echo "</div>";
}

echo "</body></html>";
?>
