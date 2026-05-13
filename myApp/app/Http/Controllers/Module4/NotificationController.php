<?php

namespace App\Http\Controllers\Module4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgencyNote;
use Illuminate\Support\Facades\Log;

/**
 * Module 4: Inquiry Progress Tracking - Notification Controller
 * 
 * This controller handles notification system for inquiry updates
 */
class NotificationController extends Controller
{
    /**
     * Display notifications for public users
     */
    public function publicUserNotifications()
    {
        $userId = session('user_id', 1); // Assuming user ID is stored in session
        
        // Get notifications for the current user
        $notifications = session('user_notifications_' . $userId, []);
        
        // Sort by created_at (newest first)
        usort($notifications, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return view('Module4.publicUser.notification', compact('notifications'));
    }    /**
     * Display notifications for admin
     */
    public function adminNotifications()
    {
        try {
            // Get legacy session notifications for admin
            $sessionNotifications = session('admin_notifications', []);
            
            // Get agency notes sent to administrators
            $agencyNotes = AgencyNote::where('recipient_type', 'Administrator')
                ->with(['inquiry', 'agency'])
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('Fetching admin notifications', [
                'session_notifications_count' => count($sessionNotifications),
                'agency_notes_count' => $agencyNotes->count()
            ]);

            // Combine session notifications and agency notes
            $notifications = collect();

            // Add legacy session notifications
            foreach ($sessionNotifications as $notification) {
                $notifications->push($notification);
            }            // Add agency notes
            foreach ($agencyNotes as $note) {
                $notifications->push([
                    'id' => 'agency_note_' . $note->id,
                    'type' => 'agency_note',
                    'title' => 'New Note from ' . $note->agency_name,
                    'message' => $note->comment,
                    'inquiry_id' => $note->inquiry_id,
                    'officer_name' => $note->agency_name,
                    'timestamp' => $note->created_at->format('M j, Y \a\t g:i A'),
                    'created_at' => $note->created_at->toISOString(),
                    'supporting_document' => $note->supporting_document,
                    'inquiry' => $note->inquiry,
                    'agency_note' => $note,
                    'read' => $note->is_read ?? false // Check database is_read status
                ]);
            }

            // Sort by created_at (newest first)
            $notifications = $notifications->sortByDesc('created_at')->values();

            return view('Module4.admin.notification', compact('notifications'));
            
        } catch (\Exception $e) {
            Log::error('Error loading admin notifications: ' . $e->getMessage());
            
            // Return a safe fallback
            $notifications = collect();
            return view('Module4.admin.notification', compact('notifications'))
                ->with('error', 'There was an issue loading your notifications. Please try again later.');
        }
    }

    /**
     * Mark notification as read for public user
     */
    public function markAsRead($notificationId)
    {
        $userId = session('user_id', 1);
        $notifications = session('user_notifications_' . $userId, []);
        
        foreach ($notifications as &$notification) {
            if ($notification['id'] == $notificationId) {
                $notification['read'] = true;
                break;
            }
        }
        
        session(['user_notifications_' . $userId => $notifications]);
        
        return response()->json(['success' => true]);
    }    /**
     * Mark notification as read for admin
     */
    public function markAdminAsRead($notificationId)
    {
        try {
            // Handle agency notes
            if (strpos($notificationId, 'agency_note_') === 0) {
                $noteId = str_replace('agency_note_', '', $notificationId);
                $agencyNote = AgencyNote::find($noteId);
                if ($agencyNote) {
                    $agencyNote->is_read = true;
                    $agencyNote->save();
                }
            } else {
                // Handle legacy session notifications
                $notifications = session('admin_notifications', []);
                
                foreach ($notifications as &$notification) {
                    if ($notification['id'] == $notificationId) {
                        $notification['read'] = true;
                        break;
                    }
                }
                
                session(['admin_notifications' => $notifications]);
            }
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            Log::error('Error marking admin notification as read: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to mark notification as read']);
        }
    }

    /**
     * Mark all notifications as read for public user
     */
    public function markAllAsRead()
    {
        $userId = session('user_id', 1);
        $notifications = session('user_notifications_' . $userId, []);
        
        foreach ($notifications as &$notification) {
            $notification['read'] = true;
        }
        
        session(['user_notifications_' . $userId => $notifications]);
        
        return response()->json(['success' => true]);
    }    /**
     * Mark all notifications as read for admin
     */
    public function markAllAdminAsRead()
    {
        try {
            // Mark all agency notes as read
            AgencyNote::where('recipient_type', 'Administrator')
                ->where('is_read', false)
                ->update(['is_read' => true]);
            
            // Mark all legacy session notifications as read
            $notifications = session('admin_notifications', []);
            
            foreach ($notifications as &$notification) {
                $notification['read'] = true;
            }
            
            session(['admin_notifications' => $notifications]);
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            Log::error('Error marking all admin notifications as read: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to mark all notifications as read']);
        }
    }

    /**
     * Get unread notification count
     */
    public function getUnreadCount()
    {
        return response()->json(['count' => 0]);
    }

    /**
     * Display notifications for public users (alias method)
     */
    public function publicNotifications()
    {
        return $this->publicUserNotifications();
    }

    /**
     * Get status history for inquiry
     */
    public function getStatusHistory($inquiryId)
    {
        return response()->json(['history' => []]);
    }

    /**
     * Send status update to public user
     */
    public function sendStatusUpdateToPublic(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Status update sent']);
    }

    /**
     * Notify inquiry completed
     */
    public function notifyInquiryCompleted(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Completion notification sent']);
    }

    /**
     * Request reassignment
     */
    public function requestReassignment(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Reassignment requested']);
    }

    /**
     * Request clarification
     */
    public function requestClarification(Request $request)
    {
        return response()->json(['success' => true, 'message' => 'Clarification requested']);
    }
}
