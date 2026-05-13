<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgencyNote extends Model
{    protected $fillable = [
        'inquiry_id',
        'agency_id',
        'agency_name',
        'recipient_type',
        'comment',
        'supporting_document',
        'user_id',
        'is_read'
    ];    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_read' => 'boolean',
    ];

    /**
     * Get the inquiry that this note belongs to
     */
    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(Inquiry::class, 'inquiry_id', 'InquiryID');
    }

    /**
     * Get the agency that created this note
     */
    public function agency(): BelongsTo
    {
        return $this->belongsTo(Agency::class, 'agency_id', 'AgencyID');
    }

    /**
     * Get the user this note is for (if recipient_type is User)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
}