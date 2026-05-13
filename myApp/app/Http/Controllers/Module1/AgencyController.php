<?php

namespace App\Http\Controllers\Module1;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;
use App\Models\Module1\Agency as Module1Agency;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AgencyController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Show agency profile page - Module1
     */
    public function showProfile(): View|RedirectResponse
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Module1Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        return view('Module3.Agency.manageProfilePage', compact('agency'));
    }

    /**
     * Update agency profile - Module1
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        // Validate input
        $request->validate([
            'AgencyName' => 'required|string|max:50',
            'AgencyUserName' => 'required|string|max:50',
            'AgencyEmail' => 'required|email',
            'AgencyPhoneNum' => 'nullable|string|max:15',
            'AgencyProfilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get agency from session
        $agencyId = session('agency_id');
        if (!$agencyId) {
            return redirect()->route('login');
        }

        // Get agency data
        $agency = Module1Agency::find($agencyId);
        if (!$agency) {
            return redirect()->route('login');
        }

        // Check for unique constraints
        $existingAgencyUsername = Module1Agency::where('AgencyUserName', $request->AgencyUserName)
            ->where('AgencyID', '!=', $agencyId)
            ->first();

        if ($existingAgencyUsername) {
            return Redirect::back()->withErrors(['AgencyUserName' => 'This username is already taken.'])->withInput();
        }

        $existingAgencyEmail = Module1Agency::where('AgencyEmail', $request->AgencyEmail)
            ->where('AgencyID', '!=', $agencyId)
            ->first();

        if ($existingAgencyEmail) {
            return Redirect::back()->withErrors(['AgencyEmail' => 'This email is already taken.'])->withInput();
        }

        // Prepare update data
        $updateData = [
            'AgencyName' => $request->AgencyName,
            'AgencyUserName' => $request->AgencyUserName,
            'AgencyEmail' => $request->AgencyEmail,
            'AgencyPhoneNum' => $request->AgencyPhoneNum ?? '',
        ];

        // Handle profile picture upload
        if ($request->hasFile('AgencyProfilePicture')) {
            // Delete old profile picture if it exists
            if ($agency->AgencyProfilePicture) {
                Storage::disk('public')->delete($agency->AgencyProfilePicture);
            }

            // Store new profile picture
            $path = $request->file('AgencyProfilePicture')->store('agency_profile_pictures', 'public');
            $updateData['AgencyProfilePicture'] = $path;
        }

        // Update agency profile
        $agency->updateProfile($updateData);

        return redirect()->route('agency.profile')
            ->with('status', 'Profile updated successfully!');
    }

    /**
     * Show agency security/password management page - Module1
     */
    public function showSecurity(): View|RedirectResponse
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Module1Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        return view('Module3.Agency.editPasswordPage', compact('agency'));
    }

    /**
     * Verify current password for password change - Module1
     */
    public function verifyPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
        ]);

        $agency = Module1Agency::find(session('agency_id'));

        if (!$agency) {
            return redirect()->route('login');
        }

        if ($agency->validateCurrentPassword($request->current_password)) {
            session(['agency_password_verified' => true]);
            return redirect()->back();
        } else {
            return Redirect::back()->with('error', 'Current password is incorrect.');
        }
    }

    /**
     * Update agency password - Module1
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $agency = Module1Agency::find(session('agency_id'));

        if (!$agency) {
            return redirect()->route('login');
        }

        $agency->updatePassword(Hash::make($request->new_password));

        session()->forget('agency_password_verified');
        return Redirect::back()->with('status', 'Password updated successfully!');
    }

    /**
     * Reset password verification session - Module1
     */
    public function resetPasswordVerification(): RedirectResponse
    {
        session()->forget('agency_password_verified');
        return redirect()->route('agency.security');
    }

    /**
     * Show agency home dashboard - Module1
     */
    public function showHome(): View|RedirectResponse
    {
        if (!session('agency_id')) {
            return redirect()->route('login');
        }

        $agency = Module1Agency::find(session('agency_id'));
        if (!$agency) {
            return redirect()->route('login');
        }

        // Get inquiry status counts for the agency
        $statusCounts = [
            'total' => Inquiry::where('AgencyID', $agency->AgencyID)->count(),
            'under_investigation' => Inquiry::where('AgencyID', $agency->AgencyID)
                                          ->where('InquiryStatus', 'Under Investigation')->count(),
            'verified_true' => Inquiry::where('AgencyID', $agency->AgencyID)
                                    ->where('InquiryStatus', 'Verified True')->count(),
            'identified_fake' => Inquiry::where('AgencyID', $agency->AgencyID)
                                       ->where('InquiryStatus', 'Identified Fake')->count(),
        ];

<<<<<<< HEAD
        return view('shared agency page.agencyHome', compact('agency', 'statusCounts'));
    }
    
    /**
     * Submit a reassignment request for an inquiry
     */
    public function submitReassignmentRequest(Request $request)
    {
        try {
            Log::info('Reassignment request received', $request->all());
            
            $request->validate([
                'inquiry_id' => 'required|integer|exists:inquiries,InquiryID',
                'reason' => 'required|string|max:1000'
            ]);

            $agencyId = session('agency_id');
            if (!$agencyId) {
                Log::error('Agency not authenticated - session agency_id: ' . session('agency_id'));
                return response()->json(['success' => false, 'message' => 'Agency not authenticated'], 401);
            }

            Log::info('Agency ID from session: ' . $agencyId);

            // Check if inquiry is assigned to this agency
            $inquiry = Inquiry::where('InquiryID', $request->inquiry_id)
                             ->where('AgencyID', $agencyId)
                             ->first();
            
            if (!$inquiry) {
                Log::error('Inquiry not found or not assigned to agency', [
                    'inquiry_id' => $request->inquiry_id,
                    'agency_id' => $agencyId
                ]);
                return response()->json(['success' => false, 'message' => 'Inquiry not found or not assigned to your agency'], 404);
            }

            Log::info('Inquiry found', ['inquiry_id' => $inquiry->InquiryID, 'title' => $inquiry->InquiryTitle]);

            // Check if there's already a pending request for this inquiry
            $existingRequest = \App\Models\ReassignmentRequest::where('InquiryID', $request->inquiry_id)
                                                             ->where('RequestStatus', 'Pending')
                                                             ->first();
            
            if ($existingRequest) {
                Log::warning('Existing pending request found', ['request_id' => $existingRequest->RequestID]);
                return response()->json(['success' => false, 'message' => 'A reassignment request is already pending for this inquiry'], 400);
            }

            // Create reassignment request
            $reassignmentRequest = \App\Models\ReassignmentRequest::create([
                'InquiryID' => $request->inquiry_id,
                'RequestingAgencyID' => $agencyId,
                'RequestReason' => $request->reason,
                'RequestDate' => now(),
                'RequestStatus' => 'Pending'
            ]);

            Log::info('Reassignment request created successfully', ['request_id' => $reassignmentRequest->RequestID]);

            return response()->json([
                'success' => true,
                'message' => 'Reassignment request submitted successfully',
                'request_id' => $reassignmentRequest->RequestID
            ]);

        } catch (\Exception $e) {
            Log::error('Error submitting reassignment request: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['success' => false, 'message' => 'An error occurred while submitting the reassignment request: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Check if there's a pending reassignment request for an inquiry
     */
    public function checkReassignmentRequest($inquiryId)
    {
        try {
            $agencyId = session('agency_id');
            if (!$agencyId) {
                return response()->json(['success' => false, 'message' => 'Agency not authenticated'], 401);
            }

            $request = \App\Models\ReassignmentRequest::where('InquiryID', $inquiryId)
                                                     ->where('RequestingAgencyID', $agencyId)
                                                     ->where('RequestStatus', 'Pending')
                                                     ->first();

            return response()->json([
                'success' => true,
                'has_pending_request' => $request ? true : false,
                'request_date' => $request ? $request->RequestDate->format('Y-m-d H:i:s') : null
            ]);

        } catch (\Exception $e) {
            Log::error('Error checking reassignment request: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
=======
        return view('Module3.Agency.agencyHome', compact('agency', 'statusCounts'));
>>>>>>> 11bc43cf3962a9ccfa5c927c09a5f93b64644d41
    }
}
