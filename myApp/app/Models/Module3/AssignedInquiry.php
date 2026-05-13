<?php

namespace App\Models\Module3;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignedInquiry extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assigned_inquiries';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inquiry_id',
        'agency_id',
        'admin_id',
        'assigned_date',
        'assignment_notes',
        'status',
        'priority_level',
        'due_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'assigned_date' => 'datetime',
        'due_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the inquiry that owns the assignment.
     */
    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Get the agency that owns the assignment.
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'AgencyID');
    }

    /**
     * Get the admin that created the assignment.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Administrator::class, 'admin_id', 'AdminID');
    }

    /**
     * Scope a query to only include active assignments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include pending assignments.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include completed assignments.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include high priority assignments.
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority_level', 'high');
    }

    /**
     * Get assignments for a specific agency.
     */
    public static function forAgency($agencyId)
    {
        return self::where('agency_id', $agencyId)->get();
    }

    /**
     * Get assignments created by a specific admin.
     */
    public static function byAdmin($adminId)
    {
        return self::where('admin_id', $adminId)->get();
    }

    /**
     * Check if the assignment is overdue.
     */
    public function isOverdue()
    {
        return $this->due_date && $this->due_date < now() && $this->status !== 'completed';
    }

    /**
     * Mark assignment as completed.
     */
    public function markCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    /**
     * Update assignment priority.
     */
    public function updatePriority($priority)
    {
        $this->update(['priority_level' => $priority]);
    }

    /**
     * Add notes to assignment.
     */
    public function addNotes($notes)
    {
        $currentNotes = $this->assignment_notes ?? '';
        $timestamp = now()->format('Y-m-d H:i:s');
        $newNotes = $currentNotes . "\n[{$timestamp}] {$notes}";
        $this->update(['assignment_notes' => trim($newNotes)]);
    }
}
