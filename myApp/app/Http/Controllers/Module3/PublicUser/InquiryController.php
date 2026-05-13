<?php

namespace App\Http\Controllers\Module3\PublicUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Validation\ValidationException;
<<<<<<< HEAD:myApp/app/Http/Controllers/InquiryController.php
use App\Models\Inquiry;
use App\Models\AgencyNote;

/**
 * @phpstan-ignore-file
 */
=======
use App\Models\Module3\Inquiry;
>>>>>>> 11bc43cf3962a9ccfa5c927c09a5f93b64644d41:myApp/app/Http/Controllers/Module3/PublicUser/InquiryController.php

class InquiryController extends Controller
{
    /**
     * Submit inquiry form page
     */
    public function submitInquiryForm(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('Module3.PublicUser.submitInquiryForm');
    }

    /**
     * Store a new inquiry
     */
    public function store(Request $request): RedirectResponse
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to submit an inquiry.');
        }

        // Debug information
        Log::info('Inquiry form submitted', [
            'request_data' => $request->except(['_token']), // Don't log the token
            'has_csrf_token' => $request->has('_token'),
            'csrf_token_length' => $request->has('_token') ? strlen($request->input('_token')) : 0,
            'session_token_length' => session()->token() ? strlen(session()->token()) : 0,
            'has_file' => $request->hasFile('InquiryEvidence'),
            'user_id' => Auth::id(),
        ]);

        // Check CSRF token explicitly
        if (!$request->has('_token') || empty($request->input('_token'))) {
            Log::error('CSRF token missing from request');
            return Redirect::back()->with('error', 'Security token missing. Please refresh the page and try again.');
        }

        try {
            $request->validate([
                'InquiryTitle' => 'required|string|max:50',
                'InquirySource' => 'required|string|max:100',
                'InquiryDescription' => 'required|string|max:255',
                'InquiryEvidence' => 'required|file|mimes:pdf,png,jpg,jpeg|max:2048',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return Redirect::back()->withErrors($e->errors())->withInput();
        }

        // Handle file upload
        try {
            $evidencePath = $request->file('InquiryEvidence')->store('evidence', 'public');
        } catch (\Exception $e) {
            Log::error('File upload failed', ['error' => $e->getMessage()]);
            return Redirect::back()->with('error', 'File upload failed. Please try again.');
        }

        try {
            Inquiry::create([
                'InquiryTitle' => $request->InquiryTitle,
                'InquirySource' => $request->InquirySource,
                'InquiryDescription' => $request->InquiryDescription,
                'InquiryEvidence' => $evidencePath,
                'InquiryStatus' => 'Pending', // Set default status
                'VerificationDescription' => $request->VerificationDescription ?? null,
                'InquirySendDate' => now(),
                'UserID' => Auth::id() ?? null,
            ]);

            Log::info('Inquiry created successfully');
            // Redirect to inquiries list with success message
            return redirect()->route('inquiries.index')->with('success', 'Inquiry submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Inquiry creation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return Redirect::back()->with('error', 'Failed to submit inquiry. Please try again. Error: ' . $e->getMessage());
        }
    }

    public function index(Request $request): View|RedirectResponse
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your inquiries.');
        }

        // Store the previous URL for back button functionality
        if (URL::previous() !== RequestFacade::url()) {
            Session::put('previous_url', URL::previous());
        }

        // Start building the query for user's inquiries
        $userInquiriesQuery = Inquiry::where('UserID', Auth::id());

        // Apply filters based on request parameters
        if ($request->filled('search')) {
            $search = $request->search;
            $userInquiriesQuery->where(function($query) use ($search) {
                $query->where('InquiryTitle', 'like', '%' . $search . '%')
                      ->orWhere('InquirySource', 'like', '%' . $search . '%')
                      ->orWhere('InquiryID', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('inquiry_id')) {
            $userInquiriesQuery->where('InquiryID', $request->inquiry_id);
        }

        if ($request->filled('inquiry_title')) {
            $userInquiriesQuery->where('InquiryTitle', 'like', '%' . $request->inquiry_title . '%');
        }

        if ($request->filled('submission_date')) {
            $userInquiriesQuery->whereDate('InquirySendDate', $request->submission_date);
        }

        if ($request->filled('status')) {
            $userInquiriesQuery->where('InquiryStatus', $request->status);
        }

        // Get filtered user inquiries
        $userInquiries = $userInquiriesQuery->orderBy('InquirySendDate', 'desc')->get();

        // Get other public inquiries (only if no filters are applied for user inquiries)
        $otherInquiries = collect(); // Empty collection since we're focusing on user's inquiries only
        if (!$request->hasAny(['search', 'inquiry_id', 'inquiry_title', 'submission_date', 'status'])) {
            $otherInquiries = Inquiry::where('UserID', '!=', Auth::id())
                ->orWhereNull('UserID')
                ->orderBy('InquirySendDate', 'desc')
                ->limit(10)
                ->get();
        }

<<<<<<< HEAD:myApp/app/Http/Controllers/InquiryController.php
        // Get all possible inquiry statuses for the filter dropdown
        $statuses = [
            'Pending' => 'Pending - Awaiting Review',
            'Under Investigation' => 'Under Investigation - Agency Reviewing',
            'Verified as True' => 'Verified as True - Genuine News',
            'Identified as Fake' => 'Identified as Fake - False Information',
            'Rejected' => 'Rejected - No Jurisdiction'
        ];

        return view('shared publicUser page.inquiries', compact('userInquiries', 'otherInquiries', 'statuses'));
=======
        return view('publicUser.inquiries', compact('userInquiries', 'otherInquiries'));
>>>>>>> 11bc43cf3962a9ccfa5c927c09a5f93b64644d41:myApp/app/Http/Controllers/Module3/PublicUser/InquiryController.php
    }

    /**
     * Show inquiry details
     */
    public function show($id): View|RedirectResponse
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view inquiry details.');
        }

        // Store the previous URL for back button functionality
        if (URL::previous() !== RequestFacade::url()) {
            Session::put('previous_url', URL::previous());
        }

        // Allow users to view their own inquiries or public inquiries
        // Include agency relationship for assignment information
        $inquiry = Inquiry::with('agency')
            ->where(function ($query) {
                $query->where('UserID', Auth::id())
                    ->orWhereNull('UserID');
            })->findOrFail($id);

<<<<<<< HEAD:myApp/app/Http/Controllers/InquiryController.php
        return view('shared publicUser page.inquiryDetails', compact('inquiry'));
=======
        return view('Module3.PublicUser.inquiryDetails', compact('inquiry'));
    }

    /**
     * View assigned agencies for public user inquiries
     */
    public function viewAssignedAgencies(Request $request): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        $inquiries = Inquiry::with('agency')
            ->where('UserID', $userId)
            ->orderByDesc('InquirySendDate')
            ->get();

        return view('Module3.PublicUser.ViewAssignedAgency', compact('inquiries'));
>>>>>>> 11bc43cf3962a9ccfa5c927c09a5f93b64644d41:myApp/app/Http/Controllers/Module3/PublicUser/InquiryController.php
    }

    public function notifications()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // Store intended URL for redirect after login
            session(['url.intended' => request()->url()]);
            return redirect()->route('login')->with('message', 'Please log in to view your notifications.');
        }

        // Store the previous URL for back button functionality
        if (url()->previous() !== request()->url()) {
            session(['previous_url' => url()->previous()]);
        }

        try {
            // Get user's inquiries with status updates
            $userInquiries = Inquiry::where('UserID', Auth::id())
                ->whereNotNull('InquiryStatus') // Only inquiries with a status
                ->orderBy('updated_at', 'desc') // Order by most recent updates
                ->get();

            // Filter inquiries that have been updated (not just created)
            $inquiryNotifications = $userInquiries->filter(function ($inquiry) {
                return $inquiry->created_at != $inquiry->updated_at; // Has been updated since creation
            });

            // Get agency notes for this user
            $agencyNotes = AgencyNote::where('user_id', Auth::id())
                ->where('recipient_type', 'User')
                ->with(['inquiry', 'agency'])
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('Fetching notifications for user', [
                'user_id' => Auth::id(),
                'inquiry_notifications_count' => $inquiryNotifications->count(),
                'agency_notes_count' => $agencyNotes->count()
            ]);

            // Combine inquiry notifications and agency notes
            $notifications = collect();
            
            // Add inquiry status notifications
            foreach ($inquiryNotifications as $inquiry) {
                $notifications->push([
                    'type' => 'inquiry_update',
                    'title' => 'Inquiry Status Update',
                    'message' => "Your inquiry '{$inquiry->InquiryTitle}' status has been updated to: {$inquiry->InquiryStatus}",
                    'date' => $inquiry->updated_at,
                    'inquiry_id' => $inquiry->InquiryID,
                    'inquiry' => $inquiry
                ]);
            }

            // Add agency notes
            foreach ($agencyNotes as $note) {
                $notifications->push([
                    'type' => 'agency_note',
                    'title' => 'New Note from ' . $note->agency_name,
                    'message' => $note->comment,
                    'date' => $note->created_at,
                    'inquiry_id' => $note->inquiry_id,
                    'agency_note' => $note,
                    'inquiry' => $note->inquiry,
                    'supporting_document' => $note->supporting_document
                ]);
            }

            // Sort all notifications by date (most recent first)
            $notifications = $notifications->sortByDesc('date');

            return view('Module4.publicUser.notification', compact('notifications'));
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error loading notifications: ' . $e->getMessage());
            
            // Return a safe fallback
            $notifications = collect();
            return view('Module4.publicUser.notification', compact('notifications'))
                ->with('error', 'There was an issue loading your notifications. Please try again later.');
        }
    }

    /**
     * Create new inquiry form
     */
    public function create()
    {
        return view('inquiries.create');
    }

    /**
     * Edit inquiry form
     */
    public function edit($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        
        // Check if user owns this inquiry
        if (session('user_id') && $inquiry->UserID !== session('user_id')) {
            abort(403, 'Unauthorized to edit this inquiry.');
        }

        return view('inquiries.edit', compact('inquiry'));
    }

    /**
     * Update inquiry
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'InquiryTitle' => 'required|string|max:255',
            'InquiryDescription' => 'required|string',
            'InquiryType' => 'required|string',
            'InquiryPriority' => 'nullable|string'
        ]);

        $inquiry = Inquiry::findOrFail($id);
        
        // Check if user owns this inquiry
        if (session('user_id') && $inquiry->UserID !== session('user_id')) {
            abort(403, 'Unauthorized to update this inquiry.');
        }

        $inquiry->update([
            'InquiryTitle' => $request->InquiryTitle,
            'InquiryDescription' => $request->InquiryDescription,
            'InquiryType' => $request->InquiryType,
            'InquiryPriority' => $request->InquiryPriority ?? 'Normal'
        ]);

        return redirect()->route('inquiries.show', $id)->with('success', 'Inquiry updated successfully!');
    }

    /**
     * Delete inquiry
     */
    public function destroy($id)
    {
        $inquiry = Inquiry::findOrFail($id);
        
        // Check if user owns this inquiry
        if (session('user_id') && $inquiry->UserID !== session('user_id')) {
            abort(403, 'Unauthorized to delete this inquiry.');
        }

        $inquiry->delete();
        
        return redirect()->route('inquiries.index')->with('success', 'Inquiry deleted successfully!');
    }

    /**
     * Update inquiry status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,In Progress,Completed,Rejected'
        ]);

        $inquiry = Inquiry::findOrFail($id);
        $inquiry->update(['InquiryStatus' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry status updated successfully'
        ]);
    }

    /**
     * Filter inquiries by criteria
     */
    public function filter(Request $request)
    {
        $query = Inquiry::query();

        if ($request->has('status') && $request->status !== '') {
            $query->where('InquiryStatus', $request->status);
        }

        if ($request->has('priority') && $request->priority !== '') {
            $query->where('InquiryPriority', $request->priority);
        }

        if ($request->has('agency') && $request->agency !== '') {
            $query->where('AgencyID', $request->agency);
        }

        if ($request->has('date_from') && $request->date_from !== '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to !== '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $inquiries = $query->with(['agency', 'user'])->paginate(10);

        return view('inquiries.index', compact('inquiries'));
    }
}
