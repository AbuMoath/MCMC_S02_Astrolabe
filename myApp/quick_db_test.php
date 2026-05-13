<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=mcmc', 'root', '');
    echo "✅ Database connected successfully\n";
    
    $stmt = $pdo->query('SELECT COUNT(*) as count FROM inquiries WHERE AgencyID IS NOT NULL');
    $result = $stmt->fetch();
    echo "📊 Found " . $result['count'] . " assigned inquiries\n";
    
    $stmt = $pdo->query('SELECT InquiryID, InquiryTitle, InquiryStatus FROM inquiries WHERE AgencyID IS NOT NULL LIMIT 3');
    $inquiries = $stmt->fetchAll();
    
    if (!empty($inquiries)) {
        echo "\n📋 Sample inquiries:\n";
        foreach ($inquiries as $inquiry) {
            echo "   ID: {$inquiry['InquiryID']} - {$inquiry['InquiryTitle']} (Status: {$inquiry['InquiryStatus']})\n";
        }
    }
    
} catch(Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}
