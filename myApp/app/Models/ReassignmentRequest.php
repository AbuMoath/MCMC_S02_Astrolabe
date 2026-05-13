<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReassignmentRequest extends Model
{
    use HasFactory;

    protected $table = 'reassignment_requests';
    protected $primaryKey = 'RequestID';

    protected $fillable = [
        'InquiryID',
        'RequestingAgencyID',
        'RequestReason',
        'RequestDate',
        'RequestStatus',
        'AdminID',
        'AdminResponse',
        'NewAgencyID',
        'ProcessedDate'
    ];

    protected $casts = [
        'RequestDate' => 'datetime',
        'ProcessedDate' => 'datetime',
    ];

    public $timestamps = true;

    /**
     * Get the inquiry that this request is for
     */
    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class, 'InquiryID', 'InquiryID');
    }

    /**
     * Get the agency that requested the reassignment
     */
    public function requestingAgency()
    {
        return $this->belongsTo('App\Models\Module1\Agency', 'RequestingAgencyID', 'AgencyID');
    }

    /**
     * Get the new agency that the inquiry will be assigned to
     */
    public function newAgency()
    {
        return $this->belongsTo('App\Models\Module1\Agency', 'NewAgencyID', 'AgencyID');
    }

    /**
     * Get the admin who processed this request
     */
    public function admin()
    {
        return $this->belongsTo('App\Models\Module1\Administrator', 'AdminID', 'AdminID');
    }
}
