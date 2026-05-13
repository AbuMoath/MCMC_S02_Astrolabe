<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Performance Reports - AuthenticityHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f0f0;
        }

        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #111111;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.3rem;
            color: #ffffff;
            margin-right: 2rem;
        }

        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #e2e2e2;
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            box-shadow: 0 4px 15px rgba(40, 61, 99, 0.1);
            display: flex;
            flex-direction: column;
            padding: 2rem 0;
            z-index: 99;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 0 1rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.75rem 1rem;
            color: #333;
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.6);
            color: #ff3333;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.8);
            color: #ff3333;
        }

        .content-area {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 40px;
            min-height: calc(100vh - 56px);
        }

        .report-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }

        .filter-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 24px;
            color: white;
            margin-bottom: 24px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF595A, #ff7b7c);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 89, 90, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            margin-right: 8px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-1px);
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .stat-item {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #FF595A;
            margin-bottom: 8px;
        }

        .stat-label {
            color: #6c757d;
            font-weight: 500;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #f8f9fa;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
        }

        .data-table td {
            padding: 16px;
            border-bottom: 1px solid #e9ecef;
        }

        .data-table tr:hover {
            background: #f8f9fa;
        }

        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #495057;
            margin-bottom: 20px;
            text-align: center;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            margin-bottom: 4px;
            font-weight: 500;
            color: white;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .performance-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-excellent {
            background: #d4edda;
            color: #155724;
        }

        .badge-good {
            background: #d1ecf1;
            color: #0c5460;
        }

        .badge-average {
            background: #fff3cd;
            color: #856404;
        }

        .badge-poor {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
        <div style="margin-left: auto; color: white;">
            <span>Admin Dashboard - Agency Performance Reports</span>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('admin.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Home</span>
            </a>
            <a href="{{ route('admin.assign.inquiry') }}" class="sidebar-link">
                <i class="fas fa-tasks"></i>
                <span>Assign Inquiry</span>
            </a>
            <a href="{{ route('admin.inquiries') }}" class="sidebar-link">
                <i class="fas fa-clipboard-list"></i>
                <span>Review Inquiries</span>
            </a>
            <a href="{{ route('admin.agency.register') }}" class="sidebar-link">
                <i class="fas fa-cog"></i>
                <span>Agency Registration</span>
            </a>
            <a href="{{ route('admin.users') }}" class="sidebar-link">
                <i class="fas fa-search"></i>
                <span>Search For User</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="sidebar-link">
                <i class="fas fa-chart-bar"></i>
                <span>Report</span>
            </a>
            <a href="{{ route('admin.reports.agency.dashboard') }}" class="sidebar-link active">
                <i class="fas fa-building"></i>
                <span>Agency Reports</span>
            </a>
            <a href="{{ route('login') }}" class="sidebar-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Exit</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="content-area">
        <div class="report-card">
            <h1 style="font-size: 2rem; font-weight: 700; color: #333; margin-bottom: 8px;">
                <i class="fas fa-chart-line" style="color: #FF595A; margin-right: 12px;"></i>
                Agency Performance Reports
            </h1>
            <p style="color: #6c757d; margin-bottom: 24px;">
                Comprehensive performance analytics for all verification agencies in the system
            </p>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <h3 style="margin-bottom: 20px; font-size: 1.25rem;">
                <i class="fas fa-filter" style="margin-right: 8px;"></i>
                Report Filters
            </h3>
            <form id="reportFilters">
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-d', strtotime('-3 months')) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Agency</label>
                        <select name="agency_id" class="form-control">
                            <option value="">All Agencies</option>
                            @foreach($agencies as $agency)
                                <option value="{{ $agency->AgencyID }}">{{ $agency->AgencyName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Inquiry Category</label>
                        <select name="inquiry_category" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="margin-top: 20px;">
                    <button type="button" class="btn-primary" onclick="generateReport()">
                        <i class="fas fa-search"></i> Generate Report
                    </button>
                    <button type="button" class="btn-secondary" onclick="exportToPDF()">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                    <button type="button" class="btn-secondary" onclick="exportToExcel()">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </div>
            </form>
        </div>

        <!-- Loading Indicator -->
        <div id="loading" class="loading">
            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #FF595A;"></i>
            <p style="margin-top: 16px;">Generating report...</p>
        </div>

        <!-- Summary Statistics -->
        <div id="summarySection" style="display: none;">
            <h3 style="color: #333; margin-bottom: 16px; font-size: 1.25rem;">
                <i class="fas fa-chart-bar" style="color: #FF595A; margin-right: 8px;"></i>
                Summary Statistics
            </h3>
            <div class="stat-grid" id="summaryStats"></div>
        </div>

        <!-- Charts Section -->
        <div id="chartsSection" style="display: none;">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
                <div class="chart-container">
                    <h4 class="chart-title">Resolution Rate by Agency</h4>
                    <canvas id="resolutionRateChart"></canvas>
                </div>
                <div class="chart-container">
                    <h4 class="chart-title">Assigned vs Resolved Inquiries</h4>
                    <canvas id="assignedResolvedChart"></canvas>
                </div>
                <div class="chart-container">
                    <h4 class="chart-title">Average Resolution Time</h4>
                    <canvas id="resolutionTimeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div id="tableSection" style="display: none;">
            <h3 style="color: #333; margin-bottom: 16px; font-size: 1.25rem;">
                <i class="fas fa-table" style="color: #FF595A; margin-right: 8px;"></i>
                Detailed Performance Data
            </h3>
            <div class="table-container">
                <table class="data-table" id="reportTable">
                    <thead>
                        <tr>
                            <th>Agency Name</th>
                            <th>Total Assigned</th>
                            <th>Total Resolved</th>
                            <th>Pending</th>
                            <th>Overdue</th>
                            <th>Avg Resolution Time (Days)</th>
                            <th>Resolution Rate</th>
                            <th>Performance</th>
                        </tr>
                    </thead>
                    <tbody id="reportTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        let currentFilters = {};
        let charts = {};

        function generateReport() {
            const formData = new FormData(document.getElementById('reportFilters'));
            const params = new URLSearchParams(formData);
            
            currentFilters = Object.fromEntries(formData);
            
            document.getElementById('loading').style.display = 'block';
            document.getElementById('summarySection').style.display = 'none';
            document.getElementById('chartsSection').style.display = 'none';
            document.getElementById('tableSection').style.display = 'none';

            fetch('/admin/reports/agency-performance/generate?' + params.toString())
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displaySummary(data.summary);
                        displayTable(data.data);
                        loadCharts();
                    } else {
                        alert('Error generating report: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while generating the report');
                })
                .finally(() => {
                    document.getElementById('loading').style.display = 'none';
                });
        }

        function displaySummary(summary) {
            const summaryHTML = `
                <div class="stat-item">
                    <div class="stat-number">${summary.total_agencies}</div>
                    <div class="stat-label">Total Agencies</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">${summary.total_assigned_all}</div>
                    <div class="stat-label">Total Assigned</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">${summary.total_resolved_all}</div>
                    <div class="stat-label">Total Resolved</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">${summary.total_pending_all}</div>
                    <div class="stat-label">Pending Inquiries</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">${summary.total_overdue_all}</div>
                    <div class="stat-label">Overdue Inquiries</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">${summary.avg_resolution_rate}%</div>
                    <div class="stat-label">Avg Resolution Rate</div>
                </div>
            `;
            
            document.getElementById('summaryStats').innerHTML = summaryHTML;
            document.getElementById('summarySection').style.display = 'block';
        }

        function displayTable(data) {
            let tableHTML = '';
            
            data.forEach(agency => {
                const performance = getPerformanceBadge(agency.resolution_rate);
                
                tableHTML += `
                    <tr>
                        <td><strong>${agency.agency.AgencyName}</strong></td>
                        <td>${agency.total_assigned}</td>
                        <td>${agency.total_resolved}</td>
                        <td>${agency.pending_inquiries}</td>
                        <td>${agency.overdue_inquiries}</td>
                        <td>${agency.avg_resolution_time}</td>
                        <td>${agency.resolution_rate}%</td>
                        <td>${performance}</td>
                    </tr>
                `;
            });
            
            document.getElementById('reportTableBody').innerHTML = tableHTML;
            document.getElementById('tableSection').style.display = 'block';
        }

        function getPerformanceBadge(rate) {
            if (rate >= 80) return '<span class="performance-badge badge-excellent">Excellent</span>';
            if (rate >= 60) return '<span class="performance-badge badge-good">Good</span>';
            if (rate >= 40) return '<span class="performance-badge badge-average">Average</span>';
            return '<span class="performance-badge badge-poor">Poor</span>';
        }

        function loadCharts() {
            const formData = new FormData(document.getElementById('reportFilters'));
            const params = new URLSearchParams(formData);
            
            fetch('/admin/reports/agency-performance/statistics?' + params.toString())
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        createCharts(data.charts);
                        document.getElementById('chartsSection').style.display = 'block';
                    }
                })
                .catch(error => console.error('Error loading charts:', error));
        }

        function createCharts(data) {
            // Destroy existing charts
            Object.values(charts).forEach(chart => chart.destroy());
            charts = {};

            // Resolution Rate Chart
            const ctx1 = document.getElementById('resolutionRateChart').getContext('2d');
            charts.resolutionRate = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: data.agencies,
                    datasets: [{
                        label: 'Resolution Rate (%)',
                        data: data.resolution_rates,
                        backgroundColor: 'rgba(255, 89, 90, 0.8)',
                        borderColor: 'rgba(255, 89, 90, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            // Assigned vs Resolved Chart
            const ctx2 = document.getElementById('assignedResolvedChart').getContext('2d');
            charts.assignedResolved = new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: data.agencies,
                    datasets: [
                        {
                            label: 'Assigned',
                            data: data.assigned_counts,
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Resolved',
                            data: data.resolved_counts,
                            backgroundColor: 'rgba(75, 192, 192, 0.8)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Resolution Time Chart
            const ctx3 = document.getElementById('resolutionTimeChart').getContext('2d');
            charts.resolutionTime = new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: data.agencies,
                    datasets: [{
                        label: 'Avg Resolution Time (Days)',
                        data: data.avg_resolution_times,
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function exportToPDF() {
            if (!Object.keys(currentFilters).length) {
                alert('Please generate a report first');
                return;
            }
            
            const params = new URLSearchParams(currentFilters);
            window.open('/admin/reports/agency-performance/export-pdf?' + params.toString(), '_blank');
        }

        function exportToExcel() {
            if (!Object.keys(currentFilters).length) {
                alert('Please generate a report first');
                return;
            }
            
            const params = new URLSearchParams(currentFilters);
            window.open('/admin/reports/agency-performance/export-excel?' + params.toString(), '_blank');
        }

        // Set CSRF token for all AJAX requests
        document.addEventListener('DOMContentLoaded', function() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Set default CSRF token for fetch requests
            const originalFetch = window.fetch;
            window.fetch = function(url, options = {}) {
                if (!options.headers) {
                    options.headers = {};
                }
                if (!options.headers['X-CSRF-TOKEN']) {
                    options.headers['X-CSRF-TOKEN'] = token;
                }
                return originalFetch(url, options);
            };
        });
    </script>
</body>

</html>
