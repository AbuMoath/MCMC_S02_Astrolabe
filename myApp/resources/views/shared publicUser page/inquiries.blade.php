<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Inquiries - AuthenticityHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #80aaff;
            margin: 0;
        }

        .inquiry-list {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .inquiry-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }

        .inquiry-table th {
            text-align: left;
            padding: 1rem;
            color: #283d63;
            font-weight: 600;
            border-bottom: 2px solid #d2dbf6;
        }

        .inquiry-table td {
            padding: 1rem;
            background: #f8faff;
            margin-bottom: 0.5rem;
        }

        .inquiry-table tr:hover td {
            background: #eef2ff;
        }

        .status-badge {
            padding: 0.25rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fff3dc;
            color: #b25e09;
        }

        .status-resolved {
            background: #dcfce7;
            color: #15803d;
        }

        .status-progress {
            background: #dbeafe;
            color: #1e40af;
        }

        .details-button {
            background: linear-gradient(145deg, #d1d9f0, #a6b1d7);
            border-radius: 0.75rem;
            box-shadow: 4px 4px 8px #9badcd, -4px -4px 8px #ffffff;
            color: #283d63;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .details-button:hover {
            background: linear-gradient(145deg, #c3cbea, #9badcd);
            box-shadow: 2px 2px 6px #8a9ac4, -2px -2px 6px #e5eaf8;
            transform: translateY(-2px);
        }

        .bg-blue-50 {
            background-color: #eff6ff;
        }

        .bg-blue-50:hover td {
            background-color: #dbeafe !important;
        }

        .bg-blue-100 {
            background-color: #dbeafe;
        }

        .text-blue-800 {
            color: #1e40af;
        }

        .topbar {
            background: #283d63;
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar {
            background: #f3f4f6;
            width: 14rem;
            min-height: 100vh;
            box-shadow: 0 4px 15px rgba(40, 61, 99, 0.1);
            border-top-right-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
            padding: 2rem 0;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .sidebar-brand {
            padding: 0 2rem;
            font-size: 1.5rem;
            font-weight: 600;
            color: #283d63;
            letter-spacing: 0.05em;
            user-select: none;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            padding: 0 1.5rem;
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
            background: #e5e7eb;
            color: #1e2f54;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: #d2dbf6;
            color: #0057ff;
            font-weight: 600;
        }

        .sidebar-link i {
            width: 1.25rem;
            height: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #506a9f;
        }

        .sidebar-link.active i {
            color: #0057ff;
        }

        .main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 0;
        }

        /* Standardized Button Styles */
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

        .btn-secondary {
            background: #283d63;
            color: white;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .btn-secondary:hover {
            background: #1e2f54;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 61, 99, 0.3);
        }

        /* Filter section */
        .filter-section {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .filter-form {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-form input,
        .filter-form select {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: white;
        }

        .filter-form button {
            background: #4f8cff;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        .filter-form button:hover {
            background: #3366cc;
        }

        .clear-button {
            background: #dddddd !important;
            color: #333 !important;
        }

        .clear-button:hover {
            background: #cccccc !important;
        }
    </style>
</head>
<body class="flex min-h-screen flex-col">
    <!-- Top Bar -->
    <div class="topbar">
        <div class="flex items-center space-x-4">
            <h1 class="text-xl font-semibold">AuthenticityHub</h1>
        </div>
        <div class="flex items-center space-x-4">
            @auth
                <span>Welcome, {{ Auth::user()->UserName }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-white hover:text-gray-200">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-white hover:text-gray-200">Login</a>
            @endauth
        </div>
    </div>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-brand">AuthenticityHub</div>
            <div class="sidebar-nav">
                <a href="{{ route('home') }}" class="sidebar-link">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('inquiries.index') }}" class="sidebar-link active">
                    <i class="fas fa-list"></i>
                    <span>Inquiry List</span>
                </a>
                <a href="{{ route('submit.inquiry') }}" class="sidebar-link">
                    <i class="fas fa-plus"></i>
                    <span>Submit Inquiry</span>
                </a>
                @auth
                    <a href="{{ route('manage.profile') }}" class="sidebar-link">
                        <i class="fas fa-user"></i>
                        <span>Manage Profile</span>
                    </a>
                    <a href="{{ route('notifications') }}" class="sidebar-link">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                    </a>
                @endauth
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content">
            <div class="inquiry-list">
                <h2 class="text-2xl font-semibold text-[#283d63] mb-6">Inquiry List</h2>

                <!-- Filter Form -->
                <div class="filter-section">
                    <form method="GET" action="{{ route('inquiries.index') }}" class="filter-form">
                        <input type="text" name="search" placeholder="Search by title, source, or ID..."
                            value="{{ request('search') }}" style="min-width: 250px;">
                        <input type="number" name="inquiry_id" placeholder="Inquiry ID"
                            value="{{ request('inquiry_id') }}">
                        <input type="date" name="submission_date" value="{{ request('submission_date') }}">
                        <select name="status">
                            <option value="">All Status</option>
                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending -
                                Awaiting Review</option>
                            <option value="Under Investigation"
                                {{ request('status') == 'Under Investigation' ? 'selected' : '' }}>Under Investigation
                                - Agency Reviewing</option>
                            <option value="Verified as True"
                                {{ request('status') == 'Verified as True' ? 'selected' : '' }}>Verified as True -
                                Genuine News</option>
                            <option value="Identified as Fake"
                                {{ request('status') == 'Identified as Fake' ? 'selected' : '' }}>Identified as Fake -
                                False Information</option>
                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected -
                                No Jurisdiction</option>
                        </select>
                        <button type="submit">Filter</button>
                        <a href="{{ route('inquiries.index') }}" class="filter-form button clear-button"
                            style="padding: 0.5rem 1rem; text-decoration: none; border-radius: 4px;">Clear</a>
                    </form>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Results Counter -->
                <div class="mb-4 text-sm text-gray-600">
                    @if(request()->hasAny(['inquiry_id', 'inquiry_title', 'submission_date', 'status']))
                        <div class="flex items-center gap-2">
                            <i class="fas fa-search"></i>
                            <span>Showing {{ $userInquiries->count() }} filtered result(s) from your inquiries</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <i class="fas fa-list"></i>
                            <span>Showing {{ $userInquiries->count() }} of your inquiries</span>
                        </div>
                    @endif
                </div>

                <table class="inquiry-table">
                    <thead>
                        <tr>
                            <th>Inquiry ID</th>
                            <th>Inquiry Title</th>
                            <th>Submission Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($userInquiries->count() > 0)
                            @foreach($userInquiries as $inquiry)
                            <tr class="bg-blue-50">
                                <td>
                                    <div class="flex items-center gap-2">
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Your Inquiry</span>
                                        {{ $inquiry->InquiryID }}
                                    </div>
                                </td>
                                <td>{{ $inquiry->InquiryTitle }}</td>
                                <td>{{ $inquiry->InquirySendDate ? $inquiry->InquirySendDate->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    <span class="status-badge status-{{ strtolower($inquiry->InquiryStatus) }}">
                                        {{ $inquiry->InquiryStatus }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('inquiries.show', $inquiry->InquiryID) }}"
                                       class="details-button">
                                        Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @endif

                        @foreach($otherInquiries as $inquiry)
                        <tr>
                            <td>{{ $inquiry->InquiryID }}</td>
                            <td>{{ $inquiry->InquiryTitle }}</td>
                            <td>{{ $inquiry->InquirySendDate ? $inquiry->InquirySendDate->format('Y-m-d') : 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($inquiry->InquiryStatus) }}">
                                    {{ $inquiry->InquiryStatus }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('inquiries.show', $inquiry->InquiryID) }}"
                                   class="details-button">
                                    Details
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        @if($userInquiries->count() == 0 && $otherInquiries->count() == 0)
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                No inquiries found. <a href="{{ route('submit.inquiry') }}" class="text-blue-600 hover:underline">Submit your first inquiry</a>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
