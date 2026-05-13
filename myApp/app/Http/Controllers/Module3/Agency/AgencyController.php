<?php

namespace App\Http\Controllers\Module3\Agency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module3\Agency;
use App\Models\Module3\Inquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AgencyController extends Controller
{
    /**
     * Show agency home dashboard
     */
    public function showHome()
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        // Get inquiry status counts for the agency
        $statusCounts = [
            'total' => Inquiry::where('AgencyID', $agency->AgencyID)->count(),
            'under_investigation' => Inquiry::where('AgencyID', $agency->AgencyID)
                                          ->where('InquiryStatus', 'Under Investigation')->count(),
            'verified_true' => Inquiry::where('AgencyID', $agency->AgencyID)
                                    ->where('InquiryStatus', 'Verified as True')->count(),
            'identified_fake' => Inquiry::where('AgencyID', $agency->AgencyID)
                                       ->where('InquiryStatus', 'Identified as Fake')->count(),
        ];

        return view('Module3.Agency.agencyHome', compact('agency', 'statusCounts'));
    }

    /**
     * Show agency profile page
     */
    public function showProfile()
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        return view('Module3.Agency.manageProfilePage', compact('agency'));
    }

    /**
     * Update agency profile
     */
    public function updateProfile(Request $request)
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'AgencyName' => 'required|string|max:50',
            'AgencyEmail' => 'required|email|max:50|unique:agencies,AgencyEmail,' . $agency->AgencyID . ',AgencyID',
            'AgencyPhoneNum' => 'nullable|string|max:15',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('AgencyProfilePicture')) {
            // Delete old profile picture if it exists
            if ($agency->AgencyProfilePicture) {
                Storage::delete('public/' . $agency->AgencyProfilePicture);
            }

            $path = $request->file('AgencyProfilePicture')->store('agency_profile_pictures', 'public');
            $validated['AgencyProfilePicture'] = $path;
        }

        $agency->update($validated);

        return redirect()->route('agency.profile')
            ->with('status', 'Profile updated successfully!');
    }

    /**
     * Show agency security/password management page
     */
    public function showSecurity()
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        return view('Module3.Agency.editPasswordPage', compact('agency'));
    }

    /**
     * Verify current password for password change
     */
    public function verifyPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        if (!$agency->checkPassword($request->current_password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Store verification in session
        session(['agency_password_verified' => true]);

        return redirect()->route('agency.security')
            ->with('status', 'Password verified. You can now set a new password.');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        if (!session('agency_password_verified')) {
            return redirect()->route('agency.security')
                ->with('error', 'Please verify your current password first.');
        }

        $request->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);

        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        $agency->AgencyPassword = Hash::make($request->new_password);
        $agency->save();

        // Clear password verification session
        session()->forget('agency_password_verified');

        return redirect()->route('agency.security')
            ->with('status', 'Password updated successfully!');
    }

    /**
     * Reset password verification
     */
    public function resetPasswordVerification()
    {
        session()->forget('agency_password_verified');
        return redirect()->route('agency.security');
    }

    /**
     * Handle agency login (to be called from main login controller)
     */
    public function attemptLogin($loginInput, $password)
    {
        $agency = Agency::findByLogin($loginInput);

        if ($agency && $agency->checkPassword($password)) {
            // Check if agency has phone number
            if (empty($agency->AgencyPhoneNum) || is_null($agency->AgencyPhoneNum)) {
                // Store agency ID in session for phone verification
                session(['phone_verification_agency_id' => $agency->AgencyID]);

                return redirect()->route('password.recovery')
                    ->with('phone_required', 'Please add your phone number and reset your password to complete account setup.');
            }

            // Store agency data in session
            session(['agency_id' => $agency->AgencyID, 'agency_name' => $agency->AgencyName]);
            return redirect()->route('agency.home');
        }

        return false;
    }

    /**
     * Update agency phone number and password
     */
    public function updatePhoneAndPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Get agency ID from session
        $agencyId = session('phone_verification_agency_id');

        if (!$agencyId) {
            return redirect()->route('login')->with('error', 'Session expired. Please login again.');
        }

        $agency = Agency::find($agencyId);

        if (!$agency) {
            return redirect()->route('login')->with('error', 'Agency not found.');
        }

        // Update phone and password
        $agency->AgencyPhoneNum = $request->phone;
        $agency->AgencyPassword = Hash::make($request->password);
        $agency->save();

        // Clear the verification session
        session()->forget('phone_verification_agency_id');

        // Log the agency in
        session(['agency_id' => $agency->AgencyID, 'agency_name' => $agency->AgencyName]);

        return redirect()->route('agency.home')->with('success', 'Account setup completed successfully!');
    }    // Note: showViewAndDisplayInquiry method moved to AgencyReviewAndNotificationController
    // to consolidate inquiry management functionality    // Note: showInquiryDetails method moved to AgencyReviewAndNotificationController
    // to consolidate inquiry management functionality

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
        $inquiry->AgencyComments = $request->comments;
        $inquiry->save();

        return response()->json([
            'success' => true,
            'message' => 'Inquiry accepted and status updated to Under Investigation',
            'inquiry' => $inquiry->load(['user', 'agency'])
        ]);
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
        }

        // Validate input
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        // Update inquiry status
        $inquiry->InquiryStatus = 'Rejected';
        $inquiry->RejectionReason = $request->rejection_reason;
        $inquiry->save();

        return response()->json([
            'success' => true,
            'message' => 'Inquiry rejected successfully',
            'inquiry' => $inquiry->load(['user', 'agency'])
        ]);
    }
}
