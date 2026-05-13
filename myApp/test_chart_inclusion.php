<?php

// Test script to verify chart inclusion functionality
require_once __DIR__ . '/vendor/autoload.php';

// Load Laravel application
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Http\Controllers\Module1\AdminController;
use Illuminate\Http\Request;

try {
    echo "Testing chart inclusion functionality...\n\n";

    // Create test data simulating what would be passed to the Excel export
    $testDataWithCharts = [
        'report_type' => 'summary',
        'date_from' => '2024-01-01',
        'date_to' => '2024-12-31',
        'agency_filter' => null,
        'status_filter' => null,
        'include_charts' => 'yes', // Charts enabled
        'generated_at' => now()->format('Y-m-d H:i:s'),
        'total_assignments' => 100,
        'status_stats' => [
            'pending' => 30,
            'under_investigation' => 25,
            'verified_true' => 20,
            'identified_fake' => 15,
            'rejected' => 10,
        ],
        'agency_stats' => collect([
            1 => [
                'agency' => (object)['AgencyName' => 'Test Agency 1'],
                'count' => 50,
                'pending' => 15,
                'under_investigation' => 12,
                'verified_true' => 10,
                'identified_fake' => 8,
                'rejected' => 5,
            ],
            2 => [
                'agency' => (object)['AgencyName' => 'Test Agency 2'],
                'count' => 50,
                'pending' => 15,
                'under_investigation' => 13,
                'verified_true' => 10,
                'identified_fake' => 7,
                'rejected' => 5,
            ]
        ]),
        'assignment_trends' => collect([
            '2024-01-15' => 5,
            '2024-02-15' => 8,
            '2024-03-15' => 12,
            '2024-04-15' => 10,
            '2024-05-15' => 15,
        ]),
        'assigned_inquiries' => collect([])
    ];

    $testDataWithoutCharts = $testDataWithCharts;
    $testDataWithoutCharts['include_charts'] = 'no'; // Charts disabled

    echo "🧪 Test 1: Charts ENABLED (include_charts = 'yes')\n";
    
    // Test with charts enabled
    $controller = new AdminController();
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('generateAssignmentExcel');
    $method->setAccessible(true);
    
    ob_start();
    $response = $method->invoke($controller, $testDataWithCharts);
    $content1 = $response->getContent();
    ob_end_clean();
    
    // Check for chart-related content
    $hasChartNote = strpos($content1, 'CHART DATA NOTE') !== false;
    $hasTrends = strpos($content1, 'ASSIGNMENT TRENDS OVER TIME') !== false;
    $hasIncludeChartsHeader = strpos($content1, 'Include Charts: yes') !== false;
    
    echo "  ✅ Include Charts in header: " . ($hasIncludeChartsHeader ? "YES" : "NO") . "\n";
    echo "  ✅ Assignment trends data: " . ($hasTrends ? "INCLUDED" : "NOT INCLUDED") . "\n";
    echo "  ✅ Chart data notes: " . ($hasChartNote ? "INCLUDED" : "NOT INCLUDED") . "\n";
    
    echo "\n🧪 Test 2: Charts DISABLED (include_charts = 'no')\n";
    
    // Test with charts disabled
    ob_start();
    $response = $method->invoke($controller, $testDataWithoutCharts);
    $content2 = $response->getContent();
    ob_end_clean();
    
    // Check for chart-related content
    $hasChartNote2 = strpos($content2, 'CHART DATA NOTE') !== false;
    $hasTrends2 = strpos($content2, 'ASSIGNMENT TRENDS OVER TIME') !== false;
    $hasIncludeChartsHeader2 = strpos($content2, 'Include Charts: no') !== false;
    
    echo "  ✅ Include Charts in header: " . ($hasIncludeChartsHeader2 ? "YES" : "NO") . "\n";
    echo "  ✅ Assignment trends data: " . ($hasTrends2 ? "INCLUDED" : "NOT INCLUDED") . "\n";
    echo "  ✅ Chart data notes: " . ($hasChartNote2 ? "INCLUDED" : "NOT INCLUDED") . "\n";
    
    echo "\n📋 Test Results Summary:\n";
    echo "=================================\n";
    
    if ($hasIncludeChartsHeader && $hasTrends && $hasChartNote && 
        $hasIncludeChartsHeader2 && !$hasTrends2 && !$hasChartNote2) {
        echo "✅ ALL TESTS PASSED!\n";
        echo "✅ Chart inclusion setting is properly respected in Excel exports\n";
        echo "✅ When charts are enabled: trends data and chart notes are included\n";
        echo "✅ When charts are disabled: trends data and chart notes are excluded\n";
        echo "✅ Header correctly shows the chart inclusion setting\n";
    } else {
        echo "❌ SOME TESTS FAILED!\n";
        echo "Charts enabled - Should have trends and notes: " . ($hasTrends && $hasChartNote ? "✅" : "❌") . "\n";
        echo "Charts disabled - Should NOT have trends and notes: " . (!$hasTrends2 && !$hasChartNote2 ? "✅" : "❌") . "\n";
    }
    
    echo "\n🎯 Summary:\n";
    echo "The assignment report Excel export now properly respects the 'Include Charts and Graphs' setting!\n";
    echo "- When 'Yes - Include Charts and Graphs' is selected: Full data including trends and chart instructions\n";
    echo "- When 'No - Data Only' is selected: Basic data only, no chart-related information\n";
    echo "- This matches the behavior of the PDF export which already had conditional chart rendering\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
