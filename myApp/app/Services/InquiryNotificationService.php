<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Module3\Administrator;
use App\Models\Module3\Agency;
use App\Models\Module3\Inquiry;

class InquiryNotificationService
{
    /**
     * Notify all admins when a public user submits a new inquiry.
     */
    public static function notifyAdminsOfNewInquiry(Inquiry $inquiry, string $userName): void
    {
        Administrator::all()->each(function (Administrator $admin) use ($inquiry, $userName) {
            Notification::create([
                'user_id' => $admin->AdminID,
                'user_type' => 'admin',
                'inquiry_id' => $inquiry->InquiryID,
                'type' => 'new_inquiry',
                'title' => 'New Inquiry Submitted',
                'message' => "{$userName} submitted an inquiry.",
            ]);
        });
    }

    /**
     * Notify agency and public user when admin assigns an inquiry.
     */
    public static function notifyAssignment(Inquiry $inquiry, Agency $agency, string $adminName): void
    {
        $inquiry->loadMissing('user');
        $userName = $inquiry->user->UserName ?? 'a user';

        Notification::create([
            'user_id' => $agency->AgencyID,
            'user_type' => 'agency',
            'inquiry_id' => $inquiry->InquiryID,
            'type' => 'inquiry_assigned',
            'title' => 'New Inquiry Assigned',
            'message' => "{$adminName} assigned a new inquiry to you that was submitted by {$userName}.",
        ]);

        if ($inquiry->UserID) {
            Notification::create([
                'user_id' => $inquiry->UserID,
                'user_type' => 'public',
                'inquiry_id' => $inquiry->InquiryID,
                'type' => 'inquiry_assigned',
                'title' => 'Inquiry Assigned',
                'message' => "Your inquiry has been assigned to {$agency->AgencyName}.",
            ]);
        }
    }

    /**
     * Notify public user when an agency updates an inquiry.
     */
    public static function notifyPublicUserOfAgencyUpdate(Inquiry $inquiry, Agency $agency): void
    {
        if (!$inquiry->UserID) {
            return;
        }

        Notification::create([
            'user_id' => $inquiry->UserID,
            'user_type' => 'public',
            'inquiry_id' => $inquiry->InquiryID,
            'type' => 'status_update',
            'title' => 'Inquiry Updated',
            'message' => "Your inquiry received an update from {$agency->AgencyName}.",
        ]);
    }
}
