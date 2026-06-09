<?php

namespace App\Http\Controllers\Module4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display notifications for public users
     */
    public function publicUserNotifications()
    {
        $userId = Auth::id();
        
        $notifications = Notification::where('user_id', $userId)
            ->where('user_type', 'public')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Module4.publicUser.notification', compact('notifications'));
    }

    public function publicNotifications()
    {
        return $this->publicUserNotifications();
    }

    /**
     * Display notifications for admin
     */
    public function adminNotifications()
    {
        try {
            $userId = session('admin_id');
            $notifications = Notification::where('user_id', $userId)
                ->where('user_type', 'admin')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('Module4.admin.notification', compact('notifications'));
            
        } catch (\Exception $e) {
            Log::error('Error loading admin notifications: ' . $e->getMessage());
            $notifications = collect();
            return view('Module4.admin.notification', compact('notifications'))
                ->with('error', 'There was an issue loading your notifications. Please try again later.');
        }
    }

    /**
     * Display notifications for agency
     */
    public function agencyNotifications()
    {
        try {
            $userId = session('agency_id');
            $notifications = Notification::where('user_id', $userId)
                ->where('user_type', 'agency')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('Module4.agency.notification', compact('notifications'));
            
        } catch (\Exception $e) {
            Log::error('Error loading agency notifications: ' . $e->getMessage());
            $notifications = collect();
            return view('Module4.agency.notification', compact('notifications'))
                ->with('error', 'There was an issue loading your notifications. Please try again later.');
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId)
    {
        try {
            $notification = Notification::find($notificationId);
            if ($notification) {
                $notification->is_read = true;
                $notification->save();
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Failed to mark notification as read']);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $userType = $request->input('user_type', 'public');
        $userId = $request->input('user_id', Auth::id());

        Notification::where('user_id', $userId)
            ->where('user_type', $userType)
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }

    /**
     * Get unread notification count
     */
    public function getUnreadCount(Request $request)
    {
        $userType = $request->input('user_type', 'public');
        $userId = $request->input('user_id', Auth::id());

        $count = Notification::where('user_id', $userId)
            ->where('user_type', $userType)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    public function getStatusHistory($inquiryId)
    {
        return response()->json(['history' => []]);
    }
    public function sendStatusUpdateToPublic(Request $request) { return response()->json(['success' => true]); }
    public function notifyInquiryCompleted(Request $request) { return response()->json(['success' => true]); }
    public function requestReassignment(Request $request) { return response()->json(['success' => true]); }
    public function requestClarification(Request $request) { return response()->json(['success' => true]); }
}
