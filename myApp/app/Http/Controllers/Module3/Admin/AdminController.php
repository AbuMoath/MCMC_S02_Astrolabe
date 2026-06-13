<?php

namespace App\Http\Controllers\Module3\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module3\Administrator as Admin;
use App\Models\Module3\PublicUsers as PublicUser;
use App\Models\Module3\Agency;
use App\Models\Module3\Inquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminOtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\AgencyRecommendationService;
use App\Services\InquiryNotificationService;

class AdminController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Show admin home dashboard
     */
    public function showHome()
    {
        // Get admin data from session
        $admin = Admin::find(session('admin_id'));

        // Get dashboard statistics
        $stats = [
            'total_inquiries' => Inquiry::count(),
            'pending_inquiries' => Inquiry::whereNull('AgencyID')->count(),
            'total_agencies' => Agency::count(),
            'total_users' => PublicUser::count(),
        ];

        // Get recent inquiries for activity feed
        $recentActivities = Inquiry::with('agency')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('Module3.Admin.adminHome', compact('admin', 'stats', 'recentActivities'));
    }

    /**
     * Show all users (public users and agencies) with search functionality
     */
    public function showUsers(Request $request)
    {
        // Handle user search
        $query = PublicUser::query();
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('UserName', 'like', "%{$searchTerm}%");
        }
        $users = $query->get();

        // Handle agency search
        $agencyQuery = Agency::query();
        if ($request->has('agency_search') && !empty($request->agency_search)) {
            $searchTerm = $request->agency_search;
            $agencyQuery->where('AgencyName', 'like', "%{$searchTerm}%")
                ->orWhere('AgencyUserName', 'like', "%{$searchTerm}%");
        }
        $agencies = $agencyQuery->get();

        return view('Module3.Admin.viewUsersProfilePage', compact('users', 'agencies'));
    }

    /**
     * Show edit form for a public user
     */
    public function editUser($id)
    {
        $user = PublicUser::findOrFail($id);
        return view('Module3.Admin.editUserPage', compact('user'));
    }

    /**
     * Update a public user
     */
    public function updateUser(Request $request, $id)
    {
        $user = PublicUser::findOrFail($id);

        $validated = $request->validate([
            'UserName' => 'required|string|max:50',
            'UserEmail' => 'required|email|max:50|unique:public_users,UserEmail,' . $id . ',UserID',
            'UserPhoneNum' => 'nullable|string|max:15',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Show edit form for an agency
     */
    public function editAgency($id)
    {
        $agency = Agency::findOrFail($id);
        return view('Module3.Admin.editAgencyPage', compact('agency'));
    }

    /**
     * Update an agency
     */
    public function updateAgency(Request $request, $id)
    {
        $agency = Agency::findOrFail($id);

        $validated = $request->validate([
            'AgencyName' => 'required|string|max:50',
            'AgencyUserName' => 'required|string|max:50|unique:agencies,AgencyUserName,' . $id . ',AgencyID',
            'AgencyEmail' => 'required|email|max:50|unique:agencies,AgencyEmail,' . $id . ',AgencyID',
            'AgencyPhoneNum' => 'nullable|string|max:15',
        ]);

        $agency->update($validated);

        return redirect()->route('admin.users')
            ->with('success', 'Agency updated successfully!');
    }

    /**
     * Show agency registration form
     */
    public function showAgencyRegistrationForm()
    {
        return view('Module3.Admin.registerNewAgencyPage');
    }

    /**
     * Store a new agency
     */
    public function storeAgency(Request $request)
    {
        $validated = $request->validate([
            'AgencyName' => 'required|string|max:50',
            'AgencyEmail' => 'required|email|max:50|unique:agencies,AgencyEmail',
            'AgencyUserName' => 'required|string|max:50|unique:agencies,AgencyUserName',
            'AgencyPassword' => 'required|string|min:6|confirmed',
        ]);

        // Hash the password before storing
        $validated['AgencyPassword'] = Hash::make($validated['AgencyPassword']);

        Agency::createAgency([
            'AgencyName' => $validated['AgencyName'],
            'AgencyEmail' => $validated['AgencyEmail'],
            'AgencyUserName' => $validated['AgencyUserName'],
            'AgencyPassword' => $validated['AgencyPassword'],
            'AgencyPhoneNum' => '',
            'AgencyType' => 'Default',
        ]);

        return redirect()->route('admin.agency.register')
            ->with('success', 'Agency registered successfully!');
    }

    /**
     * Show reports page
     */
    public function showReports()
    {
        return view('Module3.Admin.generateReportPage');
    }

    /**
     * Generate reports
     */
    public function generateReports(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:summary,detailed',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'user_type' => 'nullable|in:public,agency',
            'status_filter' => 'nullable|string',
            'format' => 'required|in:pdf,excel',
        ]);

        // Build query for report data
        $publicUsersQuery = PublicUser::query();
        $agenciesQuery = Agency::query();

        // Apply date filters
        $publicUsersQuery->whereBetween('created_at', [$request->date_from, $request->date_to]);
        $agenciesQuery->whereBetween('created_at', [$request->date_from, $request->date_to]);

        // Apply user type filter
        if ($request->user_type === 'public') {
            $agenciesQuery = null;
        } elseif ($request->user_type === 'agency') {
            $publicUsersQuery = null;
        }

        // Get the data
        $publicUsers = $publicUsersQuery ? $publicUsersQuery->get() : collect([]);
        $agencies = $agenciesQuery ? $agenciesQuery->get() : collect([]);

        // Prepare report data
        $reportData = [
            'report_type' => $request->report_type,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'user_type' => $request->user_type,
            'public_users' => $publicUsers,
            'agencies' => $agencies,
            'total_public_users' => $publicUsers->count(),
            'total_agencies' => $agencies->count(),
            'total_users' => $publicUsers->count() + $agencies->count(),
            'generated_at' => now(),
            'generated_by' => session('admin_name', 'Admin')
        ];

        // Generate report based on format
        if ($request->format === 'pdf') {
            $pdf = PDF::loadView('Module3.Admin.Reports.pdf', $reportData);
            $filename = 'user_report_' . $request->date_from . '_to_' . $request->date_to . '.pdf';

            return $pdf->download($filename);
        }

        // For excel format, return a simple download response for now
        $filename = 'user_report_' . $request->date_from . '_to_' . $request->date_to . '.xlsx';
        return response()->json(['message' => 'Excel export not implemented yet'])
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Handle admin login (to be called from main login controller)
     * AFTER IMPLEMENTATION: 2FA OTP - Credentials are verified but full session
     * is NOT established. Instead, an OTP is generated, emailed, and the admin
     * is redirected to the OTP verification page.
     */
    public function attemptLogin($loginInput, $password)
    {
        $admin = Admin::findByLogin($loginInput);

        if ($admin && $admin->checkPassword($password)) {
            // ── Step 1: Credentials valid. DO NOT establish full auth session. ──

            // ── Step 2: Generate a secure 6-digit numeric OTP code ──
            $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Save OTP and expiry (5 minutes) to the database
            $admin->otp_code = $otpCode;
            $admin->otp_expires_at = Carbon::now()->addMinutes(5);
            $admin->save();

            // ── Step 3: Send OTP via email using Laravel Mail Facade ──
            try {
                Mail::to($admin->AdminEmail)->send(new AdminOtpMail($otpCode, $admin->AdminName));
            } catch (\Exception $e) {
                Log::error('Failed to send OTP email to admin: ' . $e->getMessage());
                return redirect()->route('login')
                    ->withErrors(['login' => 'Failed to send OTP email. Please try again later.']);
            }

            // ── Step 4: Store ONLY partial identification in session ──
            session([
                'otp_admin_id' => $admin->AdminID,
                'admin_email'  => $admin->AdminEmail,
            ]);

            // Mark login as successful to clear form on return
            session()->flash('login_successful', true);

            // Redirect to OTP verification page
            return redirect()->route('admin.otp.show');
        }

        return false;
    }

    /**
     * Show the OTP verification form
     */
    public function showOtpForm()
    {
        // Guard: only accessible if partial OTP session exists
        if (!session('otp_admin_id')) {
            return redirect()->route('login')
                ->with('error', 'Please login first to receive your OTP code.');
        }

        return view('home.adminOTPVerifyPage');
    }

    /**
     * Verify the submitted OTP code
     * Step 5: Validates OTP against database, checks expiry, and
     * unlocks the full authenticated admin session on success.
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ], [
            'otp_code.required' => 'Please enter the 6-digit OTP code.',
            'otp_code.size'     => 'OTP code must be exactly 6 digits.',
        ]);

        $adminId = session('otp_admin_id');

        if (!$adminId) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        $admin = Admin::find($adminId);

        if (!$admin) {
            session()->forget(['otp_admin_id', 'admin_email']);
            return redirect()->route('login')
                ->with('error', 'Administrator account not found.');
        }

        // Check if OTP has expired
        if (Carbon::now()->greaterThan($admin->otp_expires_at)) {
            // Clear expired OTP from database
            $admin->otp_code = null;
            $admin->otp_expires_at = null;
            $admin->save();

            session()->forget(['otp_admin_id', 'admin_email']);

            return redirect()->route('login')
                ->with('error', 'OTP code has expired. Please login again to receive a new code.');
        }

        // Verify OTP code matches
        if ($request->otp_code !== $admin->otp_code) {
            return redirect()->route('admin.otp.show')
                ->with('error', 'Invalid OTP code. Please try again.');
        }

        // ── OTP Valid: Unlock full authenticated session ──

        // Clear OTP from database (single-use)
        $admin->otp_code = null;
        $admin->otp_expires_at = null;
        $admin->save();

        // Clear partial OTP session data
        session()->forget(['otp_admin_id', 'admin_email']);

        // Establish the full admin session (same as original login)
        session(['admin_id' => $admin->AdminID, 'admin_name' => $admin->AdminName]);

        Log::info('Admin 2FA login successful', ['admin_id' => $admin->AdminID]);

        // Redirect to Admin Dashboard
        return redirect()->route('admin.home');
    }

    /**
     * Resend OTP code to admin's email
     */
    public function resendOTP()
    {
        $adminId = session('otp_admin_id');

        if (!$adminId) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        $admin = Admin::find($adminId);

        if (!$admin) {
            session()->forget(['otp_admin_id', 'admin_email']);
            return redirect()->route('login')
                ->with('error', 'Administrator account not found.');
        }

        // Generate new OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $admin->otp_code = $otpCode;
        $admin->otp_expires_at = Carbon::now()->addMinutes(5);
        $admin->save();

        // Send new OTP via email
        try {
            Mail::to($admin->AdminEmail)->send(new AdminOtpMail($otpCode, $admin->AdminName));
        } catch (\Exception $e) {
            Log::error('Failed to resend OTP email: ' . $e->getMessage());
            return redirect()->route('admin.otp.show')
                ->with('error', 'Failed to resend OTP email. Please try again.');
        }

        return redirect()->route('admin.otp.show')
            ->with('info', 'A new OTP code has been sent to your email.');
    }

    /**
     * Show all inquiries for admin review
     */
    public function showInquiries(Request $request)
    {
        $query = Inquiry::query();

        // Handle search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where('InquiryTitle', 'like', "%{$searchTerm}%")
                ->orWhere('InquirySource', 'like', "%{$searchTerm}%")
                ->orWhere('InquiryID', 'like', "%{$searchTerm}%");
        }

        // Handle status filter
        if ($request->has('status') && !empty($request->status)) {
            $query->where('InquiryStatus', $request->status);
        }

        // Sort inquiries: Pending first, then others by date
        $inquiries = $query
            ->orderByRaw("CASE WHEN InquiryStatus = 'Pending' THEN 0 ELSE 1 END")
            ->orderBy('InquirySendDate', 'desc')
            ->get();

        return view('Module3.Admin.reviewInquiries', compact('inquiries'));
    }

    /**
     * Show inquiry details for admin review
     */
    public function showInquiryDetails($id)
    {
        $inquiry = Inquiry::findOrFail($id);

        return view('Module3.Admin.inquiryDetails', compact('inquiry'));
    }

    /**
     * Update inquiry status
     */
    public function updateInquiryStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Under Investigation,Verified as True,Identified as Fake,Rejected',
            'verification_description' => 'nullable|string'
        ]);

        $inquiry = Inquiry::findOrFail($id);
        $inquiry->InquiryStatus = $request->status;
        if ($request->verification_description) {
            $inquiry->VerificationDescription = $request->verification_description;
        }
        $inquiry->save();

        return redirect()->route('admin.inquiries')->with('success', 'Inquiry status updated successfully!');
    }

    /**
     * Show assign inquiry page
     */
    public function showAssignInquiry()
    {
        $inquiries = Inquiry::with(['agency', 'user'])->get();
        $agencies = Agency::all();

        $inquiries->each(function (Inquiry $inquiry) use ($agencies) {
            $recommendation = AgencyRecommendationService::recommend(
                (string) $inquiry->InquiryTitle,
                $inquiry->InquiryDescription,
                $agencies
            );

            $inquiry->recommended_agency_id = $recommendation['agency_id'];
            $inquiry->recommended_agency_name = $recommendation['agency_name'];
            $inquiry->recommended_agency_category = $recommendation['category'];
            $inquiry->recommended_keywords = $recommendation['matched_keywords'];
            $inquiry->recommended_reason = $recommendation['reason'];
        });

        return view('Module3.Admin.assignInquiry', compact('inquiries', 'agencies'));
    }    /**
     * Assign inquiries to agencies
     */
    public function assignInquiries(Request $request)
    {
        $request->validate([
            'inquiry_ids' => 'required|array',
            'agency_id' => 'required|exists:agencies,AgencyID',
            'admin_comments' => 'nullable|string|max:1000',
            'priority_level' => 'nullable|in:normal,high,urgent'
        ]);

        try {
            $agency = Agency::find($request->agency_id);
            $assignedCount = 0;

            foreach ($request->inquiry_ids as $inquiryId) {
                $inquiry = Inquiry::with('user')->find($inquiryId);
                if ($inquiry && !$inquiry->AgencyID) {
                    $inquiry->AgencyID = $request->agency_id;
                    
                    // Add admin comments if provided
                    if ($request->admin_comments) {
                        $inquiry->admin_comments = $request->admin_comments;
                    }
                    
                    // Add priority level if provided
                    if ($request->priority_level && $request->priority_level !== 'normal') {
                        $inquiry->InquiryPriority = ucfirst($request->priority_level);
                    }
                    
                    $inquiry->save();

                    InquiryNotificationService::notifyAssignment(
                        $inquiry,
                        $agency,
                        session('admin_name', 'Administrator')
                    );

                    $assignedCount++;
                }
            }

            $message = $assignedCount > 0 
                ? "Successfully assigned {$assignedCount} inquiries to {$agency->AgencyName}" 
                : "No inquiries were assigned (they may already be assigned)";

            return redirect()->route('admin.assign.inquiry')
                ->with('success', $message . ($request->admin_comments ? ' with comments.' : '.'));

        } catch (\Exception $e) {
            return redirect()->route('admin.assign.inquiry')
                ->with('error', 'Error assigning inquiries: ' . $e->getMessage());
        }
    }    /**
     * Assign inquiries with notes
     */
    public function assignInquiriesWithNotes(Request $request)
    {
        $request->validate([
            'inquiry_ids' => 'required|array',
            'agency_id' => 'required|exists:agencies,AgencyID',
            'assignment_notes' => 'nullable|string|max:1000',
            'priority_level' => 'nullable|in:normal,high,urgent',
            'expected_completion' => 'nullable|date|after:today'
        ]);

        try {
            $agency = Agency::find($request->agency_id);
            $assignedCount = 0;

            foreach ($request->inquiry_ids as $inquiryId) {
                $inquiry = Inquiry::with('user')->find($inquiryId);
                if ($inquiry && !$inquiry->AgencyID) {
                    $inquiry->AgencyID = $request->agency_id;
                    
                    // Add detailed assignment notes
                    if ($request->assignment_notes) {
                        $inquiry->admin_comments = $request->assignment_notes;
                    }
                    
                    // Set priority level
                    if ($request->priority_level && $request->priority_level !== 'normal') {
                        $inquiry->InquiryPriority = ucfirst($request->priority_level);
                    }
                    
                    // Set expected completion date if provided
                    if ($request->expected_completion) {
                        $inquiry->expected_completion_date = $request->expected_completion;
                    }
                    
                    $inquiry->save();

                    InquiryNotificationService::notifyAssignment(
                        $inquiry,
                        $agency,
                        session('admin_name', 'Administrator')
                    );

                    $assignedCount++;
                }
            }

            $message = $assignedCount > 0 
                ? "Successfully assigned {$assignedCount} inquiries to {$agency->AgencyName} with detailed instructions" 
                : "No inquiries were assigned (they may already be assigned)";

            return redirect()->route('admin.assign.inquiry')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('admin.assign.inquiry')
                ->with('error', 'Error assigning inquiries with notes: ' . $e->getMessage());
        }
    }

    /**
     * Dashboard view
     */
    public function dashboard()
    {
        return view('Module3.Admin.dashboard');
    }
}
