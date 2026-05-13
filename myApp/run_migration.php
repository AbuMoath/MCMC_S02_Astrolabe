<?php
// Manual database migration script for reassignment_requests table
// Run this script to create the table if artisan migrate is not working

try {
    // Database configuration (update these with your actual database credentials)
    $host = 'localhost';
    $dbname = 'mcmc';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully.\n";

    // Check if table already exists
    $checkTableQuery = "SHOW TABLES LIKE 'reassignment_requests'";
    $result = $pdo->query($checkTableQuery);
    
    if ($result->rowCount() > 0) {
        echo "Table 'reassignment_requests' already exists.\n";
        exit;
    }

    // Create the table
    $createTableSQL = "
    CREATE TABLE `reassignment_requests` (
      `RequestID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
      `InquiryID` bigint(20) UNSIGNED NOT NULL,
      `RequestingAgencyID` bigint(20) UNSIGNED NOT NULL,
      `RequestReason` text NOT NULL,
      `RequestStatus` varchar(50) NOT NULL DEFAULT 'Pending',
      `AdminID` bigint(20) UNSIGNED NULL,
      `AdminResponse` text NULL,
      `NewAgencyID` bigint(20) UNSIGNED NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`RequestID`),
      KEY `reassignment_requests_inquiryid_foreign` (`InquiryID`),
      KEY `reassignment_requests_requestingagencyid_foreign` (`RequestingAgencyID`),
      KEY `reassignment_requests_adminid_foreign` (`AdminID`),
      KEY `reassignment_requests_newagencyid_foreign` (`NewAgencyID`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

    $pdo->exec($createTableSQL);
    echo "Table 'reassignment_requests' created successfully.\n";

    // Add foreign key constraints
    $foreignKeys = [
        "ALTER TABLE `reassignment_requests` ADD CONSTRAINT `reassignment_requests_inquiryid_foreign` FOREIGN KEY (`InquiryID`) REFERENCES `inquiries` (`InquiryID`) ON DELETE CASCADE",
        "ALTER TABLE `reassignment_requests` ADD CONSTRAINT `reassignment_requests_requestingagencyid_foreign` FOREIGN KEY (`RequestingAgencyID`) REFERENCES `agencies` (`AgencyID`) ON DELETE CASCADE",
        "ALTER TABLE `reassignment_requests` ADD CONSTRAINT `reassignment_requests_adminid_foreign` FOREIGN KEY (`AdminID`) REFERENCES `administrators` (`AdminID`) ON DELETE SET NULL",
        "ALTER TABLE `reassignment_requests` ADD CONSTRAINT `reassignment_requests_newagencyid_foreign` FOREIGN KEY (`NewAgencyID`) REFERENCES `agencies` (`AgencyID`) ON DELETE SET NULL"
    ];

    foreach ($foreignKeys as $sql) {
        try {
            $pdo->exec($sql);
            echo "Added foreign key constraint.\n";
        } catch (Exception $e) {
            echo "Warning: Could not add foreign key constraint: " . $e->getMessage() . "\n";
        }
    }

    // Add to migrations table
    $addToMigrations = "
    INSERT INTO `migrations` (`migration`, `batch`) VALUES 
    ('2025_01_10_000000_create_reassignment_requests_table', 
     (SELECT COALESCE(MAX(batch), 0) + 1 FROM (SELECT batch FROM migrations) as temp))";
    
    try {
        $pdo->exec($addToMigrations);
        echo "Added migration record.\n";
    } catch (Exception $e) {
        echo "Warning: Could not add migration record: " . $e->getMessage() . "\n";
    }

    echo "\n✅ Migration completed successfully!\n";
    echo "The 'reassignment_requests' table has been created.\n";
    echo "You can now use the Request Reassignment feature.\n";

} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    echo "\nPlease check your database credentials and make sure:\n";
    echo "1. MySQL server is running\n";
    echo "2. Database 'mcmc' exists\n";
    echo "3. Username and password are correct\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
