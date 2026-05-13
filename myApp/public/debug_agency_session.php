<?php
session_start();
echo "=== Agency Session Debug ===\n\n";
echo "Session ID: " . session_id() . "\n";
echo "Agency ID in session: " . (isset($_SESSION['agency_id']) ? $_SESSION['agency_id'] : 'NOT SET') . "\n";
echo "All session data:\n";
print_r($_SESSION);
?>
