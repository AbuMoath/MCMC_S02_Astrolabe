<?php

namespace App\Http\Controllers\Module3\Agency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module3\Inquiry;
use App\Models\Module3\Agency;
use Illuminate\Support\Facades\Auth;
use App\Services\InquiryNotificationService;

class AgencyReviewAndNotificationController extends Controller
{
    /**
     * Show the public user's inquiries and their assigned agencies.
     */
    public function viewAssignedAgencies(Request $request)
    {
        $userId = auth()->id();
        $inquiries = Inquiry::with('agency')
            ->where('UserID', $userId)
            ->orderByDesc('InquirySendDate')
            ->get();

        return view('Module3.PublicUser.ViewAssignedAgency', compact('inquiries'));
    }

    /**
     * Show view and display inquiry page for agencies
     */
    public function showViewAndDisplayInquiry()
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        // Get inquiries assigned to this agency with relationships
        $inquiries = Inquiry::with(['user', 'agency', 'admin'])
            ->where('AgencyID', $agency->AgencyID)
            ->orderByRaw("
                CASE
                    WHEN COALESCE(InquiryPriority, 'Normal') = 'High' THEN 1
                    WHEN COALESCE(InquiryPriority, 'Normal') = 'Medium' THEN 2
                    WHEN COALESCE(InquiryPriority, 'Normal') = 'Low' THEN 3
                    ELSE 4
                END
            ")
            ->orderByDesc('InquirySendDate')
            ->get();        // Calculate status counts
        $statusCounts = [
            'total' => $inquiries->count(),
            'pending' => $inquiries->where('InquiryStatus', 'Pending')->count(),
            'under_investigation' => $inquiries->where('InquiryStatus', 'Under Investigation')->count(),
            'verified_true' => $inquiries->where('InquiryStatus', 'Verified as True')->count(),
            'identified_fake' => $inquiries->where('InquiryStatus', 'Identified as Fake')->count(),
            'rejected' => $inquiries->where('InquiryStatus', 'Rejected')->count(),
        ];

        return view('Module3.Agency.ViewAndDisplayInquiry', compact('agency', 'statusCounts', 'inquiries'));
    }

    /**
     * Show inquiry details (AJAX compatible)
     */
    public function showInquiryDetails($id)
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        // Get inquiry with relationships, ensuring it belongs to this agency
        $inquiry = Inquiry::with(['user', 'agency', 'admin'])
            ->where('InquiryID', $id)
            ->where('AgencyID', $agency->AgencyID)
            ->first();

        if (!$inquiry) {
            return redirect()->route('agency.view.display.inquiry')
                ->with('error', 'Inquiry not found or not assigned to your agency.');
        }

        // Handle AJAX requests
        if (request()->ajax() || request()->expectsJson()) {
            return response()->json([
                'inquiry' => $inquiry,
                'agency' => $agency
            ]);
        }

        return view('Module3.Agency.ViewAndDisplayInquiry', compact('inquiry', 'agency'));
    }

    /**
     * Reject an inquiry
     */
    public function rejectInquiry(Request $request, $id)
    {
        if (!session('agency_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return response()->json(['success' => false, 'message' => 'Agency not found'], 404);
        }

        // Find inquiry belonging to this agency
        $inquiry = Inquiry::where('InquiryID', $id)
            ->where('AgencyID', $agency->AgencyID)
            ->first();

        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Inquiry not found'], 404);
        }        // Validate input
        $request->validate([
            'reason' => 'required|string|max:500',
            'comments' => 'required|string|max:1000',
        ]);

        try {
            // Update inquiry status to 'Rejected'
            $inquiry->InquiryStatus = 'Rejected';
            $inquiry->StatusComments = $request->reason . ' - ' . $request->comments;
            $inquiry->save();

            if ($inquiry->UserID) {
                InquiryNotificationService::notifyPublicUserOfAgencyUpdate($inquiry, $agency);
            }

            return response()->json([
                'success' => true,
                'message' => 'Inquiry rejected successfully!',
                'inquiry' => $inquiry
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error rejecting inquiry: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Accept an inquiry
     */
    public function acceptInquiry(Request $request, $id)
    {
        if (!session('agency_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return response()->json(['success' => false, 'message' => 'Agency not found'], 404);
        }

        // Find inquiry belonging to this agency
        $inquiry = Inquiry::where('InquiryID', $id)
            ->where('AgencyID', $agency->AgencyID)
            ->first();

        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Inquiry not found'], 404);
        }

        // Validate input
        $request->validate([
            'comments' => 'required|string|max:1000',
        ]);

        // Update inquiry status
        $inquiry->InquiryStatus = 'Under Investigation';
        $inquiry->StatusComments = $request->comments;
        $inquiry->save();

        if ($inquiry->UserID) {
            InquiryNotificationService::notifyPublicUserOfAgencyUpdate($inquiry, $agency);
        }

        return response()->json([
            'success' => true,
            'message' => 'Inquiry accepted and status updated to Under Investigation',
            'inquiry' => $inquiry->load(['user', 'agency'])
        ]);
    }

    /**
     * Update inquiry status
     */
    public function updateInquiryStatus(Request $request, $id)
    {
        if (!session('agency_id')) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return response()->json(['success' => false, 'message' => 'Agency not found'], 404);
        }

        // Find inquiry belonging to this agency
        $inquiry = Inquiry::where('InquiryID', $id)
            ->where('AgencyID', $agency->AgencyID)
            ->first();

        if (!$inquiry) {
            return response()->json(['success' => false, 'message' => 'Inquiry not found'], 404);
        }

        // Validate input
        $request->validate([
            'status' => 'required|in:Pending,Under Investigation,Verified as True,Identified as Fake,Completed',
            'comments' => 'nullable|string|max:1000',
        ]);

        // Update inquiry
        $inquiry->InquiryStatus = $request->status;
        if ($request->comments) {
            $inquiry->StatusComments = $request->comments;
            $inquiry->VerificationDescription = $request->comments;
        }
        $inquiry->save();

        if ($inquiry->UserID) {
            InquiryNotificationService::notifyPublicUserOfAgencyUpdate($inquiry, $agency);
        }

        return response()->json([
            'success' => true,
            'message' => 'Inquiry status updated successfully',
            'inquiry' => $inquiry->load(['user', 'agency'])
        ]);
    }
}
