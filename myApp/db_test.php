<?php
// Simple database test without Laravel
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mcmc";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection successful!\n\n";
    
    // Check if inquiries table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'inquiries'");
    if ($stmt->rowCount() == 0) {
        echo "ERROR: inquiries table does not exist!\n";
        exit;
    }
    
    echo "inquiries table exists.\n\n";
    
    // Get table structure
    $stmt = $pdo->query("DESCRIBE inquiries");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Columns in inquiries table:\n";
    $hasStatusComments = false;
    $hasProcessedAt = false;
    
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
        if ($column['Field'] === 'StatusComments') {
            $hasStatusComments = true;
        }
        if ($column['Field'] === 'ProcessedAt') {
            $hasProcessedAt = true;
        }
    }
    
    echo "\nColumn Status:\n";
    echo "StatusComments: " . ($hasStatusComments ? "EXISTS" : "MISSING") . "\n";
    echo "ProcessedAt: " . ($hasProcessedAt ? "EXISTS" : "MISSING") . "\n";
    
    // Test a simple update query
    echo "\nTesting update query without ProcessedAt...\n";
    $sql = "SELECT InquiryID, InquiryStatus FROM inquiries LIMIT 1";
    $stmt = $pdo->query($sql);
    $inquiry = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($inquiry) {
        echo "Found inquiry with ID: " . $inquiry['InquiryID'] . " and status: " . $inquiry['InquiryStatus'] . "\n";
        
        // Test update without ProcessedAt
        $updateSql = "UPDATE inquiries SET InquiryStatus = ? WHERE InquiryID = ?";
        $stmt = $pdo->prepare($updateSql);
        $result = $stmt->execute([$inquiry['InquiryStatus'], $inquiry['InquiryID']]);
        
        if ($result) {
            echo "Update query test successful!\n";
        } else {
            echo "Update query test failed!\n";
        }
    } else {
        echo "No inquiries found in table.\n";
    }
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
