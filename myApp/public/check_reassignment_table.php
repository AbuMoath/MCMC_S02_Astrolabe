<?php
// Check if reassignment_requests table exists
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mcmc";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connected successfully\n";
    
    // Check if reassignment_requests table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'reassignment_requests'");
    if ($stmt->rowCount() > 0) {
        echo "Reassignment requests table exists\n";
        
        // Show table structure
        $stmt = $pdo->query("DESCRIBE reassignment_requests");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "Table structure:\n";
        foreach ($columns as $column) {
            echo "- {$column['Field']} ({$column['Type']})\n";
        }
        
        // Show count
        $stmt = $pdo->query("SELECT COUNT(*) FROM reassignment_requests");
        $count = $stmt->fetchColumn();
        echo "Records count: $count\n";
        
    } else {
        echo "Reassignment requests table does not exist - creating it...\n";
        
        $createTable = "
        CREATE TABLE reassignment_requests (
            RequestID INT AUTO_INCREMENT PRIMARY KEY,
            InquiryID INT NOT NULL,
            RequestingAgencyID INT NOT NULL,
            RequestReason TEXT NOT NULL,
            RequestDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            RequestStatus VARCHAR(50) NOT NULL DEFAULT 'Pending',
            AdminID INT NULL,
            AdminResponse TEXT NULL,
            NewAgencyID INT NULL,
            ProcessedDate DATETIME NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_inquiry_id (InquiryID),
            INDEX idx_requesting_agency (RequestingAgencyID),
            INDEX idx_status (RequestStatus)
        ) ENGINE=InnoDB;
        ";
        
        $pdo->exec($createTable);
        echo "Table created successfully!\n";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
