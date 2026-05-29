<?php

$files = [
    'app/Http/Controllers/Module3/PublicUser/InquiryController.php',
    'app/Http/Controllers/Module1/AgencyController.php',
    'app/Http/Controllers/Module1/AdminController.php',
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    
    $lines = file($file);
    $newLines = [];
    $inConflict = false;
    $keep = false;

    foreach ($lines as $line) {
        if (strpos($line, '<<<<<<< HEAD') === 0) {
            $inConflict = true;
            $keep = false; // Discard HEAD version
            continue;
        }

        if ($inConflict && strpos($line, '=======') === 0) {
            $keep = true; // Keep the incoming version
            continue;
        }

        if ($inConflict && strpos($line, '>>>>>>>') === 0) {
            $inConflict = false;
            $keep = false;
            continue;
        }

        if (!$inConflict || $keep) {
            $newLines[] = $line;
        }
    }

    file_put_contents($file, implode('', $newLines));
    echo "Fixed conflicts in $file\n";
}
