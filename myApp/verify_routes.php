<?php
// Route verification script
echo "Checking route consistency...\n\n";

// Get all route names from web.php
$routes_content = file_get_contents('routes/web.php');
preg_match_all("/->name\('([^']+)'\)/", $routes_content, $route_matches);
$defined_routes = $route_matches[1];

echo "Found " . count($defined_routes) . " defined routes:\n";
foreach ($defined_routes as $route) {
    echo "- {$route}\n";
}

echo "\nChecking controllers for route usage...\n";

// Check AgencyController
$agency_controller = file_get_contents('app/Http/Controllers/Module1/AgencyController.php');
preg_match_all("/route\('([^']+)'\)/", $agency_controller, $agency_routes);

echo "\nAgencyController route usage:\n";
foreach ($agency_routes[1] as $route) {
    if (in_array($route, $defined_routes)) {
        echo "✓ {$route} - OK\n";
    } else {
        echo "✗ {$route} - NOT DEFINED\n";
    }
}

// Check UserController
$user_controller = file_get_contents('app/Http/Controllers/Module1/UserController.php');
preg_match_all("/route\('([^']+)'\)/", $user_controller, $user_routes);

echo "\nUserController route usage:\n";
foreach ($user_routes[1] as $route) {
    if (in_array($route, $defined_routes)) {
        echo "✓ {$route} - OK\n";
    } else {
        echo "✗ {$route} - NOT DEFINED\n";
    }
}

echo "\nRoute verification completed!\n";
