<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $primaryKey = 'InquiryID';

    protected $fillable = [
        'InquiryTitle',
        'InquiryStatus',
        'InquiryPriority',
        'VerificationDescription',
        'InquirySource',
        'InquirySendDate',
        'InquiryDescription',
        'InquiryEvidence',
        'AgencyID',
        'assignment_date',
        'AdminID',
        'UserID',
        'StatusComments',
    ];

    protected $casts = [
        'InquirySendDate' => 'datetime',
        'assignment_date' => 'datetime',
    ];

    public $timestamps = true; // Enable timestamps

    /**
     * Get the agency assigned to this inquiry
     */
    public function agency()
    {
        return $this->belongsTo(Agency::class, 'AgencyID', 'AgencyID');
    }

    /**
     * Get the user who submitted this inquiry
     */
    public function user()
    {
        return $this->belongsTo(PublicUser::class, 'UserID', 'UserID');
    }

    /**
     * Get the admin who handled this inquiry
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'AdminID', 'AdminID');
    }

    /**
     * Get notifications related to this inquiry
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Get status history for this inquiry
     */
    public function statusHistory()
    {
        return $this->hasMany(StatusHistory::class, 'inquiry_id', 'InquiryID')->orderBy('timestamp', 'desc');
    }

    /**
     * Get investigation notes for this inquiry
     */
    public function investigationNotes()
    {
        return $this->hasMany(InvestigationNote::class, 'inquiry_id', 'InquiryID')->orderBy('created_at', 'desc');
    }

    /**
     * Get reassignment requests for this inquiry
     */
    public function reassignmentRequests()
    {
        return $this->hasMany(ReassignmentRequest::class, 'InquiryID', 'InquiryID');
    }
}
