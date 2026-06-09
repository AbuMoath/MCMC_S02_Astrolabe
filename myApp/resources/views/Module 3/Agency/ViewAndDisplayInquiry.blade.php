<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Agency Inquiry Management - AuthenticityHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #F7F3EA;
            margin: 0;
            padding: 0;
        }

        /* Top Bar Styling - Dark brown/gray as in the profile page */
        .top-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 56px;
            background: #6B6860;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            z-index: 100;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .top-bar .logo {
            font-weight: 700;
            font-size: 1.3rem;
            color: #ffffff;
            letter-spacing: 0.02em;
        }

        .search-bar {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 360px;
            height: 36px;
            background: #FFFFFF;
            border-radius: 20px;
            display: flex;
            align-items: center;
            padding: 0 15px;
        }

        .search-bar input {
            width: 100%;
            border: none;
            background: transparent;
            outline: none;
            padding: 8px;
        }

        /* User area with profile picture */
        .user-area {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #FFFFFF;
        }

        .user-area .welcome {
            text-align: right;
            line-height: 1.2;
            font-size: 0.85rem;
        }

        .profile-pic-container {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.6);
            background: #F9F9F9;
            position: relative;
            cursor: pointer;
        }

        .profile-pic-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Sidebar Styling - Standardized Design */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 14rem;
            height: calc(100vh - 56px);
            background: #EAEAEA;
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
            flex: 1;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.75rem 1rem;
            color: #333333;
            text-decoration: none;
            font-weight: 500;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .sidebar-link:hover {
            color: #FF595A;
            transform: translateX(4px);
        }

        .sidebar-link.active {
            color: #FF595A;
        }

        .sidebar-link i {
            width: 1.2rem;
            text-align: center;
        }

        .logout-link {
            margin-top: auto;
            margin-bottom: 1rem;
            color: #e74c3c !important;
        }

        .logout-link:hover {
            color: #c0392b !important;
        }

        /* Content Area */
        .content-area {
            margin-left: 14rem;
            margin-top: 56px;
            padding: 30px;
            background: #F7F3EA;
            min-height: calc(100vh - 56px);
        }

        /* Content Container */
        .content-container {
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            padding: 30px;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 30px;
            border-bottom: 1px solid #EFEFEF;
            margin-bottom: 30px;
            padding-bottom: 10px;
        }

        .tab {
            padding: 5px 0;
            font-weight: 500;
            color: #999;
            cursor: pointer;
            position: relative;
        }

        .tab.active {
            color: #FF595A;
            font-weight: 600;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -11px;
            left: 0;
            width: 100%;
            height: 2px;
            background: #FF595A;
        }

        /* Inquiry Cards */
        .inquiry-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .inquiry-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-color: #d1d5db;
        }

        .inquiry-header {
            background: #f9fafb;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .inquiry-body {
            padding: 1.5rem;
        }

        .inquiry-actions {
            background: #f9fafb;
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-under-investigation {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-accepted {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-verified-as-true {
            background: #22c55e;
            color: #ffffff;
        }

        .status-identified-as-fake {
            background: #ef4444;
            color: #ffffff;
        }

        .status-rejected {
            background: #000000;
            color: #ffffff;
        }

        /* Priority Badges */
        .priority-urgent {
            background: #fee2e2;
            color: #991b1b;
        }

        .priority-high {
            background: #fed7aa;
            color: #9a3412;
        }

        .priority-normal {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Standardized Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-size: 0.875rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-primary {
            background: linear-gradient(145deg, #DDDDDD, #CCCCCC);
            color: #333;
        }

        .btn-primary:hover {
            background: linear-gradient(145deg, #CCCCCC, #BBBBBB);
        }

        .btn-success {
            background: linear-gradient(145deg, #10b981, #059669);
            color: white;
        }

        .btn-success:hover {
            background: linear-gradient(145deg, #059669, #047857);
        }

        .btn-danger {
            background: linear-gradient(145deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(145deg, #dc2626, #b91c1c);
        }

        .btn-warning {
            background: linear-gradient(145deg, #f59e0b, #d97706);
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(145deg, #d97706, #b45309);
        }

        .btn-secondary {
            background: linear-gradient(145deg, #DDDDDD, #CCCCCC);
            color: #333;
        }

        .btn-secondary:hover {
            background: linear-gradient(145deg, #CCCCCC, #BBBBBB);
        }

        /* Modal */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #EFEFEF;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #EFEFEF;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        /* Form Elements */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 0.9rem;
            color: #333;
            font-weight: 500;
        }

        .form-input,
        .form-textarea {
            border: 1px solid #DDD;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 0.95rem;
            outline: none;
        }

        .form-input:focus,
        .form-textarea:focus {
            border-color: #AAA;
        }

        /* Detail Items */
        .detail-item {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .detail-label {
            font-weight: 500;
            color: #6b7280;
            width: 150px;
            flex-shrink: 0;
        }

        .detail-value {
            color: #374151;
            flex: 1;
        }

        /* Hidden class */
        .hidden {
            display: none !important;
        }

        /* Evidence files */
        .evidence-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 0.5rem;
            margin: 0.5rem 0;
        }

        .evidence-icon {
            width: 2.5rem;
            height: 2.5rem;
            background: #FF595A;
            color: white;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Summary Cards */
        .summary-card {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .summary-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .summary-icon.total {
            background: #FF595A;
        }

        .summary-icon.pending {
            background: #f59e0b;
        }

        .summary-icon.approved {
            background: #10b981;
        }

        .summary-icon.rejected {
            background: #ef4444;
        }

        /* Filter Section */
        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 16px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            align-items: end;
        }
    </style>
</head>

<body> <!-- Top Bar -->
    <header class="top-bar">
        <div class="logo">AuthenticityHub</div>
        <div class="search-bar">
            <input type="text" placeholder="Search inquiries..." id="mainSearchInput" />
        </div>
        @include('partials.user_area')
    </header>

    <!-- Sidebar -->
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <a href="{{ route('agency.home') }}" class="sidebar-link"><i class="fas fa-home"></i> <span>Home</span></a>
            <a href="{{ route('agency.profile') }}" class="sidebar-link"><i class="fas fa-cog"></i>
                <span>Profile</span></a>
            <a href="{{ route('agency.security') }}" class="sidebar-link"><i class="fas fa-shield-alt"></i>
                <span>Security</span></a>
            <a href="#" class="sidebar-link active"><i class="far fa-clipboard"></i> <span>Display and
                    Approved</span></a>
            <a href="{{ route('login') }}" class="sidebar-link logout-link"><i class="fas fa-sign-out-alt"></i>
                <span>Logout</span></a>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="content-area">
        <div class="content-container">
            <!-- Tabs -->
            <div class="tabs">
                <div class="tab active">Inquiry Management</div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Page Header -->
                <div style="margin-bottom: 2rem;">
                    <h1 style="font-size: 1.875rem; font-weight: 700; color: #1f2937; margin-bottom: 0.5rem;">
                        Inquiry Management
                    </h1>
                    <p style="color: #6b7280;">
                        Review and manage inquiries assigned to your agency. Reject inquiries that do not fall under your jurisdiction or require additional information.
                        appropriate reasoning.
                    </p>
                </div>

                <!-- Summary Cards -->
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                    <div
                        style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div
                                style="width: 3rem; height: 3rem; background: #3b82f6; color: white; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">
                                    {{ $statusCounts['total'] ?? 0 }}</div>
                                <div style="color: #6b7280; font-size: 0.875rem;">Total Inquiries</div>
                            </div>
                        </div>
                    </div>

                    <div
                        style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div
                                style="width: 3rem; height: 3rem; background: #f59e0b; color: white; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">
                                    {{ $statusCounts['under_investigation'] ?? 0 }}</div>
                                <div style="color: #6b7280; font-size: 0.875rem;">Under Review</div>
                            </div>
                        </div>
                    </div>

                    <div
                        style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div
                                style="width: 3rem; height: 3rem; background: #10b981; color: white; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">
                                    {{ $statusCounts['verified_true'] ?? 0 }}</div>
                                <div style="color: #6b7280; font-size: 0.875rem;">Verified</div>
                            </div>
                        </div>
                    </div>

                    <div
                        style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div
                                style="width: 3rem; height: 3rem; background: #ef4444; color: white; border-radius: 0.75rem; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-times"></i>
                            </div>
                            <div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">
                                    {{ $statusCounts['identified_fake'] ?? 0 }}</div>
                                <div style="color: #6b7280; font-size: 0.875rem;">Rejected</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div
                    style="background: white; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                    <div
                        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
                        <div>
                            <label class="form-label">Search Inquiries</label>
                            <input type="text" id="searchInput" placeholder="Search by title, ID, or source..."
                                class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Filter by Status</label>
                            <select id="statusFilter" class="form-input">
                                <option value="">All Statuses</option>
                                <option value="Pending">Pending</option>
                                <option value="Under Investigation">Under Investigation</option>
                                <option value="Verified as True">Verified as True</option>
                                <option value="Identified as Fake">Identified as Fake</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Filter by Priority</label>
                            <select id="priorityFilter" class="form-input">
                                <option value="">All Priorities</option>
                                <option value="Urgent">Urgent</option>
                                <option value="High">High</option>
                                <option value="Normal">Normal</option>
                            </select>
                        </div>
                        <div>
                            <button onclick="clearFilters()" class="btn btn-secondary">
                                <i class="fas fa-undo"></i>
                                Clear Filters
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Inquiries List -->
                <div id="inquiriesList">
                    @if (isset($inquiries) && $inquiries->count() > 0)
                        @foreach ($inquiries as $inquiry)
                            <div class="inquiry-card" data-status="{{ $inquiry->InquiryStatus }}"
                                data-priority="{{ $inquiry->InquiryPriority ?? 'Normal' }}">
                                <div class="inquiry-header">
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: start; gap: 1rem;">
                                        <div style="flex: 1;">
                                            <h3
                                                style="font-weight: 600; font-size: 1.125rem; color: #1f2937; margin-bottom: 0.5rem;">
                                                {{ $inquiry->InquiryTitle }}
                                            </h3>
                                            <div style="display: flex; gap: 1rem; align-items: center;">
                                                <span style="font-size: 0.875rem; color: #6b7280;">
                                                    <i class="fas fa-hashtag"></i> {{ $inquiry->InquiryID }}
                                                </span>
                                                <span
                                                    class="status-badge status-{{ strtolower(str_replace(' ', '-', $inquiry->InquiryStatus)) }}">
                                                    {{ $inquiry->InquiryStatus }}
                                                </span>
                                                <span
                                                    class="status-badge priority-{{ strtolower($inquiry->InquiryPriority ?? 'normal') }}">
                                                    {{ $inquiry->InquiryPriority ?? 'Normal' }} Priority
                                                </span>
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                            <div style="font-size: 0.875rem; color: #6b7280;">
                                                Assigned:
                                                {{ $inquiry->assignment_date ? $inquiry->assignment_date->format('M d, Y') : 'N/A' }}
                                            </div>
                                            @if ($inquiry->user)
                                                <div style="font-size: 0.75rem; color: #6b7280;">
                                                    Submitted by: {{ $inquiry->user->UserName }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="inquiry-body">
                                    <div style="margin-bottom: 1rem;">
                                        <strong style="color: #374151;">Source:</strong>
                                        <span
                                            style="color: #6b7280;">{{ $inquiry->InquirySource ?? 'Not specified' }}</span>
                                    </div>
                                    <div style="margin-bottom: 1rem;">
                                        <strong style="color: #374151;">Description:</strong>
                                        <p style="color: #6b7280; margin-top: 0.5rem; line-height: 1.5;">
                                            {{ Str::limit($inquiry->InquiryDescription, 200) }}
                                        </p>
                                    </div>
                                    @if ($inquiry->InquiryEvidence)
                                        <div>
                                            <strong style="color: #374151;">Evidence:</strong>
                                            <span style="color: #10b981; font-size: 0.875rem;">
                                                <i class="fas fa-paperclip"></i> Attachments available
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="inquiry-actions">
                                    <button onclick="showInquiryDetails({{ $inquiry->InquiryID }})"
                                        class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                        Show Full Details
                                    </button>

                                    <button onclick="showAddNotesModal({{ $inquiry->InquiryID }})"
                                        class="btn btn-secondary">
                                        <i class="fas fa-sticky-note"></i>
                                        Add Notes
                                    </button>

                                    <button onclick="showStatusModal({{ $inquiry->InquiryID }})"
                                        class="btn btn-success">
                                        <i class="fas fa-edit"></i>
                                        Update Status
                                    </button>

                                    @if ($inquiry->InquiryStatus === 'Pending' || $inquiry->InquiryStatus === 'Under Investigation')
                                        @if ($inquiry->reassignmentRequests->count() > 0)
                                            <button disabled class="btn btn-secondary" style="opacity: 0.6; cursor: not-allowed;">
                                                <i class="fas fa-paper-plane"></i>
                                                Request Sent
                                            </button>
                                        @else
                                            <button onclick="showRequestReassignmentModal({{ $inquiry->InquiryID }})"
                                                class="btn btn-warning">
                                                <i class="fas fa-exchange-alt"></i>
                                                Request Reassignment
                                            </button>
                                        @endif
                                        
                                        <button onclick="rejectInquiry({{ $inquiry->InquiryID }})"
                                            class="btn btn-danger">
                                            <i class="fas fa-times"></i>
                                            Reject Inquiry
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div
                            style="background: white; padding: 3rem; border-radius: 12px; text-align: center; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);">
                            <i class="fas fa-inbox" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                            <h3 style="font-size: 1.25rem; font-weight: 600; color: #374151; margin-bottom: 0.5rem;">
                                No Inquiries Assigned
                            </h3>
                            <p style="color: #6b7280;">
                                You don't have any inquiries assigned to your agency at the moment.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Inquiry Details Modal -->
            <div id="detailsModal" class="modal hidden">
                <div class="modal-content" style="width: 90%; max-width: 900px;">
                    <div class="modal-header">
                        <h2 style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">Inquiry Details</h2>
                    </div>
                    <div class="modal-body" id="detailsContent">
                        <!-- Content will be loaded here -->
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeModal('detailsModal')" class="btn btn-secondary">Close</button>
                    </div>
                </div>
            </div>

            <!-- Reject Modal -->
            <div id="rejectModal" class="modal hidden">
                <div class="modal-content" style="width: 500px;">
                    <div class="modal-header">
                        <h2 style="font-size: 1.25rem; font-weight: 600; color: #1f2937;">Reject Inquiry</h2>
                    </div>
                    <div class="modal-body">
                        <p style="color: #6b7280; margin-bottom: 1rem;">
                            Please provide a reason for rejecting this inquiry. This will be visible to the user who
                            submitted it.
                        </p>
                        <form id="rejectForm">
                            <input type="hidden" id="rejectInquiryId" name="inquiry_id">
                            <div class="form-group">
                                <label class="form-label">Rejection Reason <span
                                        style="color: #ef4444;">*</span></label>
                                <select id="rejectReason" name="reason" class="form-input" required>
                                    <option value="">Select a reason...</option>
                                    <option value="outside_jurisdiction">Outside Our Jurisdiction</option>
                                    <option value="insufficient_evidence">Insufficient Evidence</option>
                                    <option value="duplicate_inquiry">Duplicate Inquiry</option>
                                    <option value="invalid_source">Invalid News Source</option>
                                    <option value="spam_irrelevant">Spam or Irrelevant Content</option>
                                    <option value="other">Other (specify below)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Additional Comments <span
                                        style="color: #ef4444;">*</span></label>
                                <textarea id="rejectComments" name="comments" rows="4" class="form-textarea" required
                                    placeholder="Please provide detailed explanation for the rejection..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeModal('rejectModal')" class="btn btn-secondary">Cancel</button>
                        <button onclick="submitReject()" class="btn btn-danger">
                            <i class="fas fa-times"></i>
                            Reject Inquiry
                        </button>
                    </div>
                </div>
            </div>

            <!-- Request Reassignment Modal -->
            <div id="reassignmentModal" class="modal hidden">
                <div class="modal-content" style="width: 600px;">
                    <div class="modal-header">
                        <h2 style="font-size: 1.25rem; font-weight: 600; color: #1f2937;">Request Reassignment</h2>
                    </div>
                    <div class="modal-body">
                        <p style="color: #6b7280; margin-bottom: 1rem;">
                            If this inquiry does not fall under your agency's authority or jurisdiction, you can request 
                            that it be reassigned to a more appropriate agency. Please provide a detailed reason for this request.
                        </p>
                        <form id="reassignmentForm">
                            <input type="hidden" id="reassignmentInquiryId" name="inquiry_id">
                            
                            <div class="form-group">
                                <label class="form-label">Inquiry ID</label>
                                <input type="text" id="reassignmentInquiryIdDisplay" class="form-input" readonly style="background: #f9fafb;">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Reason for Reassignment Request <span style="color: #ef4444;">*</span></label>
                                <select id="reassignmentReason" name="reason_category" class="form-input" required>
                                    <option value="">Select a reason...</option>
                                    <option value="outside_jurisdiction">Outside Our Jurisdiction</option>
                                    <option value="specialized_expertise">Requires Specialized Expertise</option>
                                    <option value="resource_constraints">Resource Constraints</option>
                                    <option value="conflict_of_interest">Conflict of Interest</option>
                                    <option value="other">Other (specify below)</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Detailed Explanation <span style="color: #ef4444;">*</span></label>
                                <textarea id="reassignmentComments" name="reason" rows="4" class="form-textarea" required
                                    placeholder="Please provide a detailed explanation for why this inquiry should be reassigned, including any specific agencies you believe would be more appropriate..."></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeModal('reassignmentModal')" class="btn btn-secondary">Cancel</button>
                        <button onclick="submitReassignmentRequest()" class="btn btn-warning">
                            <i class="fas fa-paper-plane"></i>
                            Send Request
                        </button>
                    </div>
                </div>
            </div>

            <!-- Status Update Modal -->
            <div id="statusModal" class="modal hidden">
                <div class="modal-content" style="width: 600px;">
                    <div class="modal-header">
                        <h2 style="font-size: 1.25rem; font-weight: 600; color: #1f2937;">Update Inquiry Status</h2>
                    </div>
                    <div class="modal-body">
                        <p style="color: #6b7280; margin-bottom: 1rem;">
                            Select the appropriate status for this inquiry based on your investigation and findings.
                        </p>
                        <form id="statusForm">
                            <input type="hidden" id="statusInquiryId" name="inquiry_id">
                            
                            <div class="form-group">
                                <label class="form-label">Inquiry ID</label>
                                <input type="text" id="statusInquiryIdDisplay" class="form-input" readonly style="background: #f9fafb;">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Select Status <span style="color: #ef4444;">*</span></label>
                                <select id="inquiryStatus" name="status" class="form-input" required>
                                    <option value="">-- Select Status --</option>
                                    <option value="Pending">Pending - inquiry is being reviewed</option>
                                    <option value="Verified as True">Verified as True - news has been confirmed as genuine</option>
                                    <option value="Identified as Fake">Identified as Fake - news has been determined to be false or misleading</option>
                                    <option value="Rejected">Rejected - inquiry is not within the agency's jurisdiction</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeModal('statusModal')" class="btn btn-secondary">Cancel</button>
                        <button onclick="submitStatusUpdate()" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Update Status
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add Notes Modal -->
            <div id="addNotesModal" class="modal hidden">
                <div class="modal-content" style="width: 700px;">
                    <div class="modal-header">
                        <h2 style="font-size: 1.25rem; font-weight: 600; color: #1f2937;">Add Notes</h2>
                    </div>
                    <div class="modal-body">
                        <p style="color: #6b7280; margin-bottom: 1rem;">
                            Add notes about this inquiry for either the User or Administrator.
                        </p>
                        <form id="addNotesForm" enctype="multipart/form-data">
                            <input type="hidden" id="notesInquiryId" name="inquiry_id">
                            
                            <div class="form-group">
                                <label class="form-label">Inquiry ID</label>
                                <input type="text" id="notesInquiryIdDisplay" class="form-input" readonly style="background: #f9fafb;">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Send Notes To <span style="color: #ef4444;">*</span></label>
                                <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
                                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                        <input type="radio" name="recipient_type" value="User" id="recipientUser" onchange="toggleNotesFields()" required>
                                        <span>User</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                        <input type="radio" name="recipient_type" value="Administrator" id="recipientAdmin" onchange="toggleNotesFields()" required>
                                        <span>Administrator</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Agency Name</label>
                                <input type="text" id="notesAgencyName" class="form-input" readonly style="background: #f9fafb;" value="{{ $agency->AgencyName ?? 'Agency' }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Comment <span style="color: #ef4444;">*</span></label>
                                <textarea id="notesComment" name="comment" rows="4" class="form-textarea" required
                                    placeholder="Enter your comment about this inquiry..."></textarea>
                            </div>

                            <div class="form-group" id="supportingDocumentGroup" style="display: none;">
                                <label class="form-label">Supporting Document <small style="color: #6b7280;">(Optional - PNG, PDF, Excel files only)</small></label>
                                <input type="file" id="supportingDocument" name="supporting_document" class="form-input" 
                                    accept=".png,.pdf,.xls,.xlsx" style="padding: 0.5rem;">
                                <small style="color: #6b7280; font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                                    Maximum file size: 10MB. Supported formats: PNG, PDF, Excel (XLS, XLSX)
                                </small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button onclick="closeModal('addNotesModal')" class="btn btn-secondary">Cancel</button>
                        <button onclick="submitAddNotes()" class="btn btn-success">
                            <i class="fas fa-save"></i>
                            Add Notes
                        </button>
                    </div>
                </div>
            </div>

            <script>
                let allInquiries = @json($inquiries ?? []);
                const storageUrl = "{{ asset('storage') }}";

                // Modal Functions
                function showModal(modalId) {
                    document.getElementById(modalId).classList.remove('hidden');
                }

                function closeModal(modalId) {
                    document.getElementById(modalId).classList.add('hidden');
                }

                // Show Inquiry Details
                function showInquiryDetails(inquiryId) {
                    const inquiry = allInquiries.find(inq => inq.InquiryID == inquiryId);
                    if (!inquiry) {
                        alert('Inquiry not found');
                        return;
                    }

                    let evidenceHtml = '';
                    if (inquiry.InquiryEvidence) {
                        let evidenceFiles = [];
                        try {
                            evidenceFiles = typeof inquiry.InquiryEvidence === 'string' ?
                                JSON.parse(inquiry.InquiryEvidence) :
                                inquiry.InquiryEvidence;
                            if (!Array.isArray(evidenceFiles)) {
                                evidenceFiles = [inquiry.InquiryEvidence];
                            }
                        } catch (e) {
                            evidenceFiles = [inquiry.InquiryEvidence];
                        }

                        evidenceHtml = evidenceFiles.map(file => `
                    <div class="evidence-item">
                        <div class="evidence-icon">
                            <i class="fas fa-file"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 500;">${file}</div>
                            <div style="font-size: 0.875rem; color: #6b7280;">Evidence File</div>
                        </div>
                        <a href="${storageUrl}/${file}" target="_blank" class="btn btn-primary" style="padding: 0.5rem;" download>
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                `).join('');
                    }

                    const detailsHtml = `
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">
                            Basic Information
                        </h3>
                        <div class="detail-item">
                            <div class="detail-label">Inquiry ID:</div>
                            <div class="detail-value">#${inquiry.InquiryID}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Title:</div>
                            <div class="detail-value">${inquiry.InquiryTitle}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Source:</div>
                            <div class="detail-value">${inquiry.InquirySource || 'Not specified'}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Status:</div>
                            <div class="detail-value">
                                <span class="status-badge status-${inquiry.InquiryStatus.toLowerCase().replace(' ', '-')}">
                                    ${inquiry.InquiryStatus}
                                </span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Priority:</div>
                            <div class="detail-value">
                                <span class="status-badge priority-${(inquiry.InquiryPriority || 'normal').toLowerCase()}">
                                    ${inquiry.InquiryPriority || 'Normal'}
                                </span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Assigned Date:</div>
                            <div class="detail-value">${inquiry.assignment_date ? new Date(inquiry.assignment_date).toLocaleDateString() : 'N/A'}</div>
                        </div>
                    </div>

                    <div>
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">
                            Submitter Information
                        </h3>
                        ${inquiry.user ? `
                                        <div class="detail-item">
                                            <div class="detail-label">Name:</div>
                                            <div class="detail-value">${inquiry.user.UserName}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Email:</div>
                                            <div class="detail-value">${inquiry.user.UserEmail}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label">Phone:</div>
                                            <div class="detail-value">${inquiry.user.UserPhone || 'Not provided'}</div>
                                        </div>
                                    ` : `
                                        <div style="color: #6b7280; font-style: italic;">Anonymous submission</div>
                                    `}
                        <div class="detail-item">
                            <div class="detail-label">Submitted:</div>
                            <div class="detail-value">${inquiry.created_at ? new Date(inquiry.created_at).toLocaleDateString() : 'N/A'}</div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">
                        Inquiry Description
                    </h3>
                    <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                        ${inquiry.InquiryDescription || 'No description provided'}
                    </div>
                </div>

                ${evidenceHtml ? `
                                <div style="margin-top: 2rem;">
                                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">
                                        Evidence Files
                                    </h3>
                                    ${evidenceHtml}
                                </div>
                            ` : ''}

                ${inquiry.VerificationDescription ? `
                                <div style="margin-top: 2rem;">
                                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">
                                        Verification Notes
                                    </h3>
                                    <div style="background: #f9fafb; padding: 1rem; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
                                        ${inquiry.VerificationDescription}
                                    </div>
                                </div>
                            ` : ''}
            `;

                    document.getElementById('detailsContent').innerHTML = detailsHtml;
                    showModal('detailsModal');
                }

                // Reject Inquiry
                function rejectInquiry(inquiryId) {
                    document.getElementById('rejectInquiryId').value = inquiryId;
                    document.getElementById('rejectReason').value = '';
                    document.getElementById('rejectComments').value = '';
                    showModal('rejectModal');
                }

                function submitReject() {
                    const inquiryId = document.getElementById('rejectInquiryId').value;
                    const reason = document.getElementById('rejectReason').value;
                    const comments = document.getElementById('rejectComments').value;

                    if (!reason || !comments) {
                        alert('Please provide both a reason and comments for the rejection');
                        return;
                    }

                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        alert('Security token not found. Please refresh the page and try again.');
                        return;
                    }

                    // Send AJAX request to reject inquiry
                    fetch(`/agency/inquiry/${inquiryId}/reject`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                reason: reason,
                                comments: comments
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                alert('Inquiry rejected successfully!');
                                closeModal('rejectModal');
                                location.reload();
                            } else {
                                alert('Error: ' + (data.message || 'Failed to reject inquiry'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while rejecting the inquiry: ' + error.message);
                        });
                }

                // Status Update Functions
                function showStatusModal(inquiryId) {
                    document.getElementById('statusInquiryId').value = inquiryId;
                    document.getElementById('statusInquiryIdDisplay').value = `#${inquiryId}`;
                    document.getElementById('inquiryStatus').value = '';
                    showModal('statusModal');
                }

                function submitStatusUpdate() {
                    const inquiryId = document.getElementById('statusInquiryId').value;
                    const status = document.getElementById('inquiryStatus').value;

                    if (!status) {
                        alert('Please select a status for the inquiry');
                        return;
                    }

                    // Send AJAX request to update inquiry status
                    fetch(`/agency/inquiry/${inquiryId}/update-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                status: status
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(`Inquiry #${inquiryId} status updated to: ${status}`);
                                location.reload();
                            } else {
                                alert('Error: ' + (data.message || 'Failed to update inquiry status'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while updating the inquiry status');
                        });

                    closeModal('statusModal');
                }

                // Add Notes Functions
                function showAddNotesModal(inquiryId) {
                    document.getElementById('notesInquiryId').value = inquiryId;
                    document.getElementById('notesInquiryIdDisplay').value = `#${inquiryId}`;
                    document.getElementById('notesComment').value = '';
                    document.getElementById('supportingDocument').value = '';
                    
                    // Reset radio buttons
                    document.getElementById('recipientUser').checked = false;
                    document.getElementById('recipientAdmin').checked = false;
                    
                    // Hide supporting document field initially
                    document.getElementById('supportingDocumentGroup').style.display = 'none';
                    
                    showModal('addNotesModal');
                }

                function toggleNotesFields() {
                    const isAdmin = document.getElementById('recipientAdmin').checked;
                    const supportingDocGroup = document.getElementById('supportingDocumentGroup');
                    
                    if (isAdmin) {
                        supportingDocGroup.style.display = 'block';
                    } else {
                        supportingDocGroup.style.display = 'none';
                        document.getElementById('supportingDocument').value = '';
                    }
                }

                function submitAddNotes() {
                    const inquiryId = document.getElementById('notesInquiryId').value;
                    const recipientType = document.querySelector('input[name="recipient_type"]:checked')?.value;
                    const comment = document.getElementById('notesComment').value;
                    const supportingDocument = document.getElementById('supportingDocument').files[0];

                    if (!recipientType) {
                        alert('Please select a recipient type (User or Administrator)');
                        return;
                    }

                    if (!comment.trim()) {
                        alert('Please enter a comment');
                        return;
                    }

                    // Validate file if uploaded
                    if (supportingDocument) {
                        const allowedTypes = ['image/png', 'application/pdf', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
                        const maxSize = 10 * 1024 * 1024; // 10MB
                        
                        if (!allowedTypes.includes(supportingDocument.type)) {
                            alert('Please upload only PNG, PDF, or Excel files');
                            return;
                        }
                        
                        if (supportingDocument.size > maxSize) {
                            alert('File size must be less than 10MB');
                            return;
                        }
                    }

                    // Create FormData for file upload
                    const formData = new FormData();
                    formData.append('inquiry_id', inquiryId);
                    formData.append('recipient_type', recipientType);
                    formData.append('comment', comment);
                    formData.append('agency_name', document.getElementById('notesAgencyName').value);
                    
                    if (supportingDocument) {
                        formData.append('supporting_document', supportingDocument);
                    }

                    // Send AJAX request to add notes
                    fetch(`/agency/inquiry/${inquiryId}/add-notes`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(`Notes added successfully and sent to ${recipientType}!`);
                            location.reload();
                        } else {
                            alert('Error: ' + (data.message || 'Failed to add notes'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while adding notes');
                    });

                    closeModal('addNotesModal');
                }

                // Request Reassignment Functions
                function showRequestReassignmentModal(inquiryId) {
                    document.getElementById('reassignmentInquiryId').value = inquiryId;
                    document.getElementById('reassignmentInquiryIdDisplay').value = `#${inquiryId}`;
                    document.getElementById('reassignmentReason').value = '';
                    document.getElementById('reassignmentComments').value = '';
                    showModal('reassignmentModal');
                }

                function submitReassignmentRequest() {
                    const inquiryId = document.getElementById('reassignmentInquiryId').value;
                    const reasonCategory = document.getElementById('reassignmentReason').value;
                    const reason = document.getElementById('reassignmentComments').value;

                    if (!reasonCategory || !reason.trim()) {
                        alert('Please select a reason category and provide a detailed explanation');
                        return;
                    }

                    // Combine reason category and detailed reason
                    const fullReason = `${reasonCategory}: ${reason}`;

                    // Send AJAX request to submit reassignment request
                    fetch('/agency/inquiry/request-reassignment', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                inquiry_id: inquiryId,
                                reason: fullReason
                            })
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Response data:', data);
                            if (data.success) {
                                alert('Reassignment request submitted successfully! The admin will review your request.');
                                location.reload();
                            } else {
                                alert('Error: ' + (data.message || 'Failed to submit reassignment request'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while submitting the reassignment request: ' + error.message);
                        });

                    closeModal('reassignmentModal');
                }

                // Filtering Functions
                function filterInquiries() {
                    const search = document.getElementById('searchInput').value.toLowerCase();
                    const status = document.getElementById('statusFilter').value;
                    const priority = document.getElementById('priorityFilter').value;

                    const cards = document.querySelectorAll('.inquiry-card');

                    cards.forEach(card => {
                        const cardStatus = card.getAttribute('data-status');
                        const cardPriority = card.getAttribute('data-priority');
                        const cardText = card.textContent.toLowerCase();

                        const matchesSearch = !search || cardText.includes(search);
                        const matchesStatus = !status || cardStatus === status;
                        const matchesPriority = !priority || cardPriority === priority;

                        if (matchesSearch && matchesStatus && matchesPriority) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }

                function clearFilters() {
                    document.getElementById('searchInput').value = '';
                    document.getElementById('statusFilter').value = '';
                    document.getElementById('priorityFilter').value = '';
                    filterInquiries();
                }

                // Event Listeners
                document.getElementById('searchInput').addEventListener('input', filterInquiries);
                document.getElementById('statusFilter').addEventListener('change', filterInquiries);
                document.getElementById('priorityFilter').addEventListener('change', filterInquiries);

                // Close modals when clicking outside
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('modal')) {
                        e.target.classList.add('hidden');
                    }
                });

                // Keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        document.querySelectorAll('.modal').forEach(modal => {
                            modal.classList.add('hidden');
                        });
                    }
                });
            </script>
</body>

</html>
