<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report - AuthenticityHub Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6a7fd0, #6bc5f3);
            margin: 0;
            padding: 0;
        }

        .report-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .report-section {
            background: #f8faff;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #e2e8f0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #283d63;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 1rem;
        }

        .form-select, .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            color: #374151;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-select:focus, .form-input:focus {
            outline: none;
            border-color: #0057ff;
            box-shadow: 0 0 0 3px rgba(0, 87, 255, 0.1);
        }

        .stats-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .chart-placeholder {
            background: #f1f5f9;
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 1.125rem;
            margin: 1rem 0;
        }

        /* Top Bar Styling */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #d2dbf6;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 2rem;
            z-index: 100;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.07);
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.3rem;
            color: #283d63;
            letter-spacing: 0.02em;
            position: absolute;
            left: 2rem;
        }

        .admin-info-topbar {
            display: flex;
            flex-direction: row-reverse;
            align-items: center;
            position: absolute;
            right: 2rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .admin-info-topbar .admin-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #b9c8f6;
            margin-left: 0.7rem;
            background: #f3f4f6;
        }

        .admin-info-topbar .admin-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .admin-info-topbar .admin-name {
            font-size: 1rem;
            color: #283d63;
            font-weight: 600;
            text-align: right;
            max-width: 120px;
        }

        /* Sidebar Styling */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #d2dbf6;
            box-shadow: 0 4px 15px rgba(40, 61, 99, 0.1);
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            z-index: 99;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 0 1.5rem;
            flex: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: #283d63;
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            background: transparent;
        }

        .sidebar-link:hover {
            background: #b9c8f6;
            color: #0057ff;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: #b9c8f6;
            color: #0057ff;
            font-weight: 600;
        }

        .sidebar-link i {
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-content {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 2rem;
            min-height: calc(100vh - 56px);
            background: transparent;
        }

        .btn-primary {
            background: linear-gradient(145deg, #d1d9f0, #a6b1d7);
            border-radius: 0.75rem;
            box-shadow: 4px 4px 8px #9badcd, -4px -4px 8px #ffffff;
            color: #283d63;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: linear-gradient(145deg, #c3cbea, #9badcd);
            box-shadow: 2px 2px 6px #8a9ac4, -2px -2px 6px #e5eaf8;
            transform: translateY(-2px);
        }

        .btn-success {
            background: #10b981;
            color: white;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-download {
            background: #3b82f6;
            color: white;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-download:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .report-type-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .report-type-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 6px rgba(59, 130, 246, 0.1);
        }

        .report-type-card.selected {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .report-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub - Admin</div>

        <div class="admin-info-topbar">
            <div class="admin-pic">
                <img src="https://ui-avatars.com/api/?name=Admin&background=4f46e5&color=ffffff" alt="Admin">
            </div>
            <div class="admin-name">Administrator</div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('admin.home') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('module2.admin.reviewInquiry') }}" class="sidebar-link">
                <i class="fas fa-search"></i>
                <span>Review Inquiry</span>
            </a>
            <a href="{{ route('module2.admin.listOfInquiries') }}" class="sidebar-link">
                <i class="fas fa-clipboard-list"></i>
                <span>List of Inquiries</span>
            </a>
            <a href="{{ route('module2.admin.generateReport') }}" class="sidebar-link active">
                <i class="fas fa-chart-bar"></i>
                <span>Generate Report</span>
            </a>
            <div style="flex:1"></div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="sidebar-link"
                    style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <div class="report-container">
            <h1 class="text-2xl font-bold text-[#283d63] mb-6">Generate Report</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Current Statistics Overview -->
            <div class="report-section">
                <h2 class="text-xl font-semibold text-[#283d63] mb-4">Current Statistics Overview</h2>
                <div class="stats-overview">
                    <div class="stat-card">
                        <div class="stat-number">{{ $totalInquiries ?? 0 }}</div>
                        <div class="stat-label">Total Inquiries</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $pendingInquiries ?? 0 }}</div>
                        <div class="stat-label">Pending Inquiries</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $resolvedInquiries ?? 0 }}</div>
                        <div class="stat-label">Resolved Inquiries</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $activeAgencies ?? 0 }}</div>
                        <div class="stat-label">Active Agencies</div>
                    </div>
                </div>
            </div>

            <!-- Report Generation Form -->
            <div class="report-section">
                <h2 class="text-xl font-semibold text-[#283d63] mb-4">Generate Custom Report</h2>

                <form method="POST" action="{{ route('module2.admin.generateReport') }}">
                    @csrf

                    <!-- Report Type Selection -->
                    <div class="form-group">
                        <label class="form-label">Select Report Type</label>
                        <div class="report-grid">
                            <div class="report-type-card" onclick="selectReportType('summary')">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-chart-pie text-2xl text-blue-500"></i>
                                    <h3 class="font-semibold text-[#283d63]">Summary Report</h3>
                                </div>
                                <p class="text-sm text-gray-600">Overview of all inquiries with key statistics and trends</p>
                                <input type="radio" name="report_type" value="summary" class="hidden" required>
                            </div>

                            <div class="report-type-card" onclick="selectReportType('detailed')">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-list-alt text-2xl text-green-500"></i>
                                    <h3 class="font-semibold text-[#283d63]">Detailed Report</h3>
                                </div>
                                <p class="text-sm text-gray-600">Comprehensive list of all inquiries with full details</p>
                                <input type="radio" name="report_type" value="detailed" class="hidden">
                            </div>

                            <div class="report-type-card" onclick="selectReportType('agency')">
                                <div class="flex items-center gap-3 mb-2">
                                    <i class="fas fa-building text-2xl text-purple-500"></i>
                                    <h3 class="font-semibold text-[#283d63]">Agency Performance</h3>
                                </div>
                                <p class="text-sm text-gray-600">Performance metrics and statistics by agency</p>
                                <input type="radio" name="report_type" value="agency" class="hidden">
                            </div>
                        </div>
                    </div>

                    <!-- Date Range Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="form-group">
                            <label class="form-label" for="date_from">From Date</label>
                            <input type="date" id="date_from" name="date_from" class="form-input"
                                value="{{ request('date_from', date('Y-m-01')) }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="date_to">To Date</label>
                            <input type="date" id="date_to" name="date_to" class="form-input"
                                value="{{ request('date_to', date('Y-m-d')) }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="status_filter">Status Filter</label>
                            <select id="status_filter" name="status_filter" class="form-select">
                                <option value="">All Statuses</option>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                    </div>

                    <!-- Export Format Selection -->
                    <div class="form-group">
                        <label class="form-label">Export Format</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="export_format" value="pdf" checked class="text-blue-500">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-file-pdf text-red-500"></i>
                                    PDF Document
                                </span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="export_format" value="excel" class="text-blue-500">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-file-excel text-green-500"></i>
                                    Excel Spreadsheet
                                </span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="export_format" value="csv" class="text-blue-500">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-file-csv text-blue-500"></i>
                                    CSV File
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 mt-6">
                        <button type="submit" name="action" value="generate" class="btn-success">
                            <i class="fas fa-chart-line"></i>
                            Generate Report
                        </button>

                        <button type="submit" name="action" value="download" class="btn-download">
                            <i class="fas fa-download"></i>
                            Generate & Download
                        </button>

                        <button type="button" onclick="previewReport()" class="btn-primary">
                            <i class="fas fa-eye"></i>
                            Preview Report
                        </button>
                    </div>
                </form>
            </div>

            <!-- Report Preview Section -->
            <div class="report-section" id="reportPreview" style="display: none;">
                <h2 class="text-xl font-semibold text-[#283d63] mb-4">Report Preview</h2>
                <div class="chart-placeholder">
                    <div class="text-center">
                        <i class="fas fa-chart-bar text-4xl mb-2"></i>
                        <p>Report chart and data visualization will appear here</p>
                        <p class="text-sm">Select report type and click "Generate Report" to view data</p>
                    </div>
                </div>
            </div>

            <!-- Recent Reports -->
            <div class="report-section">
                <h2 class="text-xl font-semibold text-[#283d63] mb-4">Recent Reports</h2>
                <div class="space-y-3">
                    @if(isset($recentReports) && count($recentReports) > 0)
                        @foreach($recentReports as $report)
                            <div class="flex items-center justify-between p-3 bg-white rounded border">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-file-alt text-gray-500"></i>
                                    <div>
                                        <div class="font-medium">{{ $report['name'] }}</div>
                                        <div class="text-sm text-gray-500">Generated on {{ $report['date'] }}</div>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button class="btn-primary" onclick="viewReport('{{ $report['id'] }}')">
                                        <i class="fas fa-eye"></i>
                                        View
                                    </button>
                                    <button class="btn-download" onclick="downloadReport('{{ $report['id'] }}')">
                                        <i class="fas fa-download"></i>
                                        Download
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-6 text-gray-500">
                            <i class="fas fa-inbox text-3xl mb-2"></i>
                            <p>No recent reports found. Generate your first report above.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectReportType(type) {
            // Remove selected class from all cards
            document.querySelectorAll('.report-type-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Add selected class to clicked card
            event.currentTarget.classList.add('selected');

            // Check the corresponding radio button
            document.querySelector(`input[value="${type}"]`).checked = true;
        }

        function previewReport() {
            const reportType = document.querySelector('input[name="report_type"]:checked')?.value;
            const previewSection = document.getElementById('reportPreview');

            if (!reportType) {
                alert('Please select a report type first.');
                return;
            }

            previewSection.style.display = 'block';
            previewSection.scrollIntoView({ behavior: 'smooth' });

            // Here you would typically make an AJAX call to generate preview data
            console.log('Generating preview for:', reportType);
        }

        function viewReport(reportId) {
            // Implementation for viewing existing reports
            console.log('Viewing report:', reportId);
        }

        function downloadReport(reportId) {
            // Implementation for downloading existing reports
            console.log('Downloading report:', reportId);
        }
    </script>
</body>

</html>
