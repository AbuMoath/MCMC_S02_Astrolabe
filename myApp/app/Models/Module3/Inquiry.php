<?php

namespace App\Models\Module3;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'inquiries';
    protected $primaryKey = 'InquiryID';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'InquiryTitle',
        'InquiryStatus',
        'InquiryPriority',
        'VerificationDescription',
        'InquirySource',
        'InquirySendDate',
        'InquiryDescription',
        'InquiryEvidence',
        'UserID',
        'AgencyID',
        'AdminID',
        'admin_comments',
        'RejectionReason',
        'assignment_date',
        'expected_completion_date',
        'priority_level',
        'StatusComments',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'InquirySendDate' => 'datetime',
        'assignment_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the public user that submitted this inquiry
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(PublicUsers::class, 'UserID', 'UserID');
    }

    /**
     * Get the agency assigned to this inquiry
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'AgencyID', 'AgencyID');
    }    /**
     * Get the administrator who handled this inquiry
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'AdminID', 'AdminID');
    }

    /**
     * Get the assignment record for this inquiry
     */
    public function assignment()
    {
        return $this->hasOne(AssignedInquiry::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Scope for pending inquiries
     */
    public function scopePending($query)
    {
        return $query->where('InquiryStatus', 'Pending');
    }

    /**
     * Scope for assigned inquiries
     */
    public function scopeAssigned($query)
    {
        return $query->whereNotNull('AgencyID');
    }

    /**
     * Scope for unassigned inquiries
     */
    public function scopeUnassigned($query)
    {
        return $query->whereNull('AgencyID');
    }

    /**
     * Scope for inquiries by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('InquiryStatus', $status);
    }

    /**
     * Scope for inquiries by priority
     */
    public function scopeByPriority($query, $priority)
    {
        return $query->where('InquiryPriority', $priority);
    }

    /**
     * Scope for recent inquiries
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Get inquiry priority display name
     */
    public function getPriorityDisplayAttribute()
    {
        return $this->InquiryPriority ?: 'Normal';
    }

    /**
     * Get inquiry status display name
     */
    public function getStatusDisplayAttribute()
    {
        return $this->InquiryStatus ?: 'Pending';
    }

    /**
     * Get inquiry status color for UI
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'Pending' => 'warning',
            'Under Investigation' => 'info',
            'Verified as True' => 'success',
            'Identified as Fake' => 'danger',
            'Rejected' => 'danger',
            'Completed' => 'primary',
        ];

        return $colors[$this->InquiryStatus] ?? 'secondary';
    }

    /**
     * Get priority color for UI
     */
    public function getPriorityColorAttribute()
    {
        $colors = [
            'High' => 'danger',
            'Medium' => 'warning',
            'Normal' => 'info',
            'Low' => 'secondary',
        ];

        return $colors[$this->InquiryPriority ?? 'Normal'] ?? 'info';
    }

    /**
     * Check if inquiry is overdue
     */
    public function getIsOverdueAttribute()
    {
        if (!$this->assignment_date) {
            return false;
        }

        $daysSinceAssignment = $this->assignment_date->diffInDays(now());
        $maxDays = $this->InquiryPriority === 'High' ? 3 : 7;

        return $daysSinceAssignment > $maxDays && 
               !in_array($this->InquiryStatus, ['Verified as True', 'Identified as Fake', 'Completed']);
    }

    /**
     * Get days since submission
     */
    public function getDaysSinceSubmissionAttribute()
    {
        return $this->InquirySendDate ? $this->InquirySendDate->diffInDays(now()) : 0;
    }

    /**
     * Get days since assignment
     */
    public function getDaysSinceAssignmentAttribute()
    {
        return $this->assignment_date ? $this->assignment_date->diffInDays(now()) : 0;
    }

    /**
     * Get evidence file URL
     */
    public function getEvidenceUrlAttribute()
    {
        if ($this->InquiryEvidence) {
            return asset('storage/' . $this->InquiryEvidence);
        }
        
        return null;
    }

    /**
     * Assign inquiry to agency
     */
    public function assignToAgency($agencyId, $adminId = null, $notes = null)
    {
        $this->update([
            'AgencyID' => $agencyId,
            'AdminID' => $adminId,
            'admin_comments' => $notes,
            'assignment_date' => now(),
        ]);

        return $this;
    }

    /**
     * Update inquiry status
     */
    public function updateStatus($status, $description = null)
    {
        $data = ['InquiryStatus' => $status];
        
        if ($description) {
            $data['VerificationDescription'] = $description;
        }

        return $this->update($data);
    }

    /**
     * Reject inquiry
     */
    public function reject($reason)
    {
        return $this->update([
            'InquiryStatus' => 'Rejected',
            'RejectionReason' => $reason,
        ]);
    }

    /**
     * Accept inquiry for investigation
     */
    public function acceptForInvestigation($comments = null)
    {
        $data = ['InquiryStatus' => 'Under Investigation'];
        
        if ($comments) {
            $data['StatusComments'] = $comments;
        }

        return $this->update($data);
    }

    /**
     * Get inquiry summary for reports
     */
    public function getSummary()
    {
        return [
            'id' => $this->InquiryID,
            'title' => $this->InquiryTitle,
            'status' => $this->InquiryStatus,
            'priority' => $this->InquiryPriority ?? 'Normal',
            'submitted_date' => $this->InquirySendDate?->format('Y-m-d'),
            'assigned_date' => $this->assignment_date?->format('Y-m-d'),
            'user_name' => $this->user?->UserName,
            'agency_name' => $this->agency?->AgencyName,
            'days_since_submission' => $this->days_since_submission,
            'is_overdue' => $this->is_overdue,
        ];
    }

    /**
     * Search inquiries by various criteria
     */
    public static function search($searchTerm)
    {
        return self::where('InquiryTitle', 'like', "%{$searchTerm}%")
            ->orWhere('InquirySource', 'like', "%{$searchTerm}%")
            ->orWhere('InquiryDescription', 'like', "%{$searchTerm}%")
            ->orWhere('InquiryID', 'like', "%{$searchTerm}%");
    }

    /**
     * Get inquiries for dashboard statistics
     */
    public static function getDashboardStats($dateRange = null)
    {
        $query = self::query();
        
        if ($dateRange) {
            $query->whereBetween('created_at', $dateRange);
        }

        return [
            'total' => $query->count(),
            'pending' => $query->where('InquiryStatus', 'Pending')->count(),
            'assigned' => $query->whereNotNull('AgencyID')->count(),
            'under_investigation' => $query->where('InquiryStatus', 'Under Investigation')->count(),
            'completed' => $query->whereIn('InquiryStatus', ['Verified as True', 'Identified as Fake', 'Completed'])->count(),
            'rejected' => $query->where('InquiryStatus', 'Rejected')->count(),
        ];
    }
}
