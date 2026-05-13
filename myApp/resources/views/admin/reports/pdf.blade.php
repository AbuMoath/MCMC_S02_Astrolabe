<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $reportTitle ?? 'Report' }} - AuthenticityHub</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #ff3333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #ff3333;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 16px;
            margin-top: 5px;
        }
        
        .report-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #ff3333;
        }
        
        .report-info h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 18px;
        }
        
        .report-info .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        
        .report-info .info-item {
            background: white;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        
        .report-info .info-label {
            font-weight: bold;
            color: #555;
            font-size: 14px;
        }
        
        .report-info .info-value {
            color: #333;
            font-size: 14px;
        }
        
        .summary-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 25px 0;
        }
        
        .stat-card {
            background: #fff;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        
        .stat-card .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #ff3333;
            margin-bottom: 5px;
        }
        
        .stat-card .stat-label {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .section {
            margin: 30px 0;
            page-break-inside: avoid;
        }
        
        .section h2 {
            color: #333;
            font-size: 22px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .section h3 {
            color: #555;
            font-size: 18px;
            margin: 20px 0 10px 0;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background: white;
        }
        
        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
            font-size: 13px;
        }
        
        .data-table th {
            background: #f8f9fa;
            font-weight: bold;
            color: #333;
        }
        
        .data-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .data-table tr:hover {
            background: #f1f1f1;
        }
        
        .chart-placeholder {
            background: #f8f9fa;
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            margin: 15px 0;
            color: #666;
        }
        
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 30px;
            background: #f8f9fa;
            border-radius: 8px;
            margin: 15px 0;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .text-sm { font-size: 12px; }
        .text-lg { font-size: 18px; }
        .mb-4 { margin-bottom: 20px; }
        .mt-4 { margin-top: 20px; }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>AuthenticityHub</h1>
        <div class="subtitle">{{ $reportTitle ?? 'System Report' }}</div>
    </div>

    <!-- Report Information -->
    <div class="report-info">
        <h3>Report Information</h3>
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Report Type:</div>
                <div class="info-value">{{ $reportType ?? 'N/A' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Generated On:</div>
                <div class="info-value">{{ date('F j, Y g:i A') }}</div>
            </div>
            @if(isset($dateFrom) && $dateFrom)
            <div class="info-item">
                <div class="info-label">Date From:</div>
                <div class="info-value">{{ date('F j, Y', strtotime($dateFrom)) }}</div>
            </div>
            @endif
            @if(isset($dateTo) && $dateTo)
            <div class="info-item">
                <div class="info-label">Date To:</div>
                <div class="info-value">{{ date('F j, Y', strtotime($dateTo)) }}</div>
            </div>
            @endif
            @if(isset($reportCategory))
            <div class="info-item">
                <div class="info-label">Category:</div>
                <div class="info-value">{{ ucfirst(str_replace('_', ' ', $reportCategory)) }}</div>
            </div>
            @endif
            @if(isset($filters) && count($filters) > 0)
            <div class="info-item">
                <div class="info-label">Applied Filters:</div>
                <div class="info-value">{{ implode(', ', $filters) }}</div>
            </div>
            @endif
        </div>
    </div>

    @if(isset($summaryStats) && count($summaryStats) > 0)
    <!-- Summary Statistics -->
    <div class="summary-stats">
        @foreach($summaryStats as $stat)
        <div class="stat-card">
            <div class="stat-number">{{ $stat['value'] ?? 0 }}</div>
            <div class="stat-label">{{ $stat['label'] ?? 'Statistic' }}</div>
        </div>
        @endforeach
    </div>
    @endif

    @if(isset($reportData) && count($reportData) > 0)
    <!-- Main Report Data -->
    <div class="section">
        <h2>Report Data</h2>
        
        @if(isset($reportCategory))
            @if($reportCategory === 'users')
                @include('admin.reports.partials.users-data')
            @elseif($reportCategory === 'inquiries')
                @include('admin.reports.partials.inquiries-data')
            @elseif($reportCategory === 'assignments')
                @include('admin.reports.partials.assignments-data')
            @elseif($reportCategory === 'agency_performance')
                @include('admin.reports.partials.agency-performance-data')
            @else
                <!-- Generic data table -->
                <table class="data-table">
                    <thead>
                        <tr>
                            @if(count($reportData) > 0)
                                @foreach(array_keys((array)$reportData[0]) as $header)
                                    <th>{{ ucfirst(str_replace('_', ' ', $header)) }}</th>
                                @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reportData as $row)
                            <tr>
                                @foreach((array)$row as $value)
                                    <td>{{ $value ?? 'N/A' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @else
            <!-- Generic data table when category is not specified -->
            <table class="data-table">
                <thead>
                    <tr>
                        @if(count($reportData) > 0)
                            @foreach(array_keys((array)$reportData[0]) as $header)
                                <th>{{ ucfirst(str_replace('_', ' ', $header)) }}</th>
                            @endforeach
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportData as $row)
                        <tr>
                            @foreach((array)$row as $value)
                                <td>{{ $value ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    @else
    <div class="no-data">
        <h3>No Data Available</h3>
        <p>No data found for the selected criteria and date range.</p>
    </div>
    @endif

    @if(isset($includeCharts) && $includeCharts === 'yes')
    <!-- Charts Section -->
    <div class="section page-break">
        <h2>Visual Analytics</h2>
        <div class="chart-placeholder">
            <h3>Charts and Graphs</h3>
            <p>Visual representations would appear here in an interactive environment.</p>
            <p>Chart data based on: {{ $reportTitle ?? 'Report Data' }}</p>
        </div>
    </div>
    @endif

    @if(isset($additionalNotes) && $additionalNotes)
    <!-- Additional Notes -->
    <div class="section">
        <h2>Additional Notes</h2>
        <p>{{ $additionalNotes }}</p>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Generated by AuthenticityHub Admin System | {{ date('F j, Y g:i A') }}</p>
        <p>This report contains confidential information. Please handle accordingly.</p>
    </div>
</body>
</html>
