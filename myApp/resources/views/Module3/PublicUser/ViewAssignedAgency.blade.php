<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="View your inquiries and their assigned agencies in the AuthenticityHub system" />
    <meta name="keywords" content="inquiry, agency, assignment, verification, authenticity" />
    <meta name="author" content="AuthenticityHub" />
    <title>View Assigned Agencies | AuthenticityHub</title>

    <!-- External resources -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            color: #2d3748;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #718096;
            font-size: 1.1rem;
        }

        .inquiry-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
            gap: 2rem;
        }

        .inquiry-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .inquiry-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .inquiry-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1rem;
        }

        .inquiry-meta {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #718096;
            font-size: 0.9rem;
        }

        .meta-item i {
            width: 16px;
            text-align: center;
        }

        .agency-info {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1.5rem;
            border-radius: 15px;
            margin-top: 1rem;
        }

        .agency-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .status-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            color: white;
        }

        .status-approved {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .status-rejected {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .no-inquiries {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .no-inquiries i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.9);
            color: #2d3748;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .back-button:hover {
            background: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .header h1 {
                font-size: 2rem;
            }

            .inquiry-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="{{ route('public.user.home') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to Home
        </a>

        <div class="header">
            <h1>Your Assigned Agencies</h1>
            <p>View your inquiries and the agencies assigned to handle them</p>
        </div>

        @if($inquiries && $inquiries->count() > 0)
            <div class="inquiry-grid">
                @foreach($inquiries as $inquiry)
                    <div class="inquiry-card">
                        <div class="inquiry-title">{{ $inquiry->InquiryTitle }}</div>
                        
                        <div class="inquiry-meta">
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $inquiry->InquirySendDate ? \Carbon\Carbon::parse($inquiry->InquirySendDate)->format('M d, Y') : 'N/A' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-tag"></i>
                                <span>{{ $inquiry->InquirySource ?? 'General' }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-info-circle"></i>
                                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $inquiry->InquiryStatus ?? 'pending')) }}">
                                    {{ $inquiry->InquiryStatus ?? 'Pending' }}
                                </span>
                            </div>
                        </div>

                        @if($inquiry->agency)
                            <div class="agency-info">
                                <div class="agency-name">
                                    <i class="fas fa-building"></i>
                                    {{ $inquiry->agency->AgencyName }}
                                </div>
                                <div style="font-size: 0.9rem; opacity: 0.9;">
                                    Assigned Agency
                                </div>
                            </div>
                        @else
                            <div style="padding: 1rem; background: #f7fafc; border-radius: 10px; color: #718096; text-align: center;">
                                <i class="fas fa-clock"></i>
                                No agency assigned yet
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-inquiries">
                <i class="fas fa-inbox"></i>
                <h3 style="color: #2d3748; margin-bottom: 0.5rem;">No Inquiries Found</h3>
                <p style="color: #718096;">You haven't submitted any inquiries yet.</p>
                <a href="{{ route('submit.inquiry') }}" style="
                    display: inline-block;
                    margin-top: 1.5rem;
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    color: white;
                    padding: 0.75rem 2rem;
                    border-radius: 12px;
                    text-decoration: none;
                    font-weight: 500;
                    transition: transform 0.3s ease;
                " onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                    Submit Your First Inquiry
                </a>
            </div>
        @endif
    </div>
</body>

</html>
