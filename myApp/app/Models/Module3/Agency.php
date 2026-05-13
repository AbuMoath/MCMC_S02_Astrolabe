<?php

namespace App\Models\Module3;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Support\Facades\Hash;

class Agency extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'agencies';
    protected $primaryKey = 'AgencyID';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'AgencyName',
        'AgencyEmail',
        'AgencyUserName',
        'AgencyPassword',
        'AgencyPhoneNum',
        'AgencyProfilePicture',
        'AgencyType',
        'AgencyStatus',
        'AgencyAddress',
        'AgencyDescription',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'AgencyPassword',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'AgencyPassword' => 'hashed',
        'AgencyStatus' => 'boolean',
    ];

    /**
     * Get the password for authentication.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->AgencyPassword;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Find agency by login input (email or username)
     */
    public static function findByLogin($loginInput)
    {
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);
        
        if ($isEmail) {
            return self::where('AgencyEmail', $loginInput)->first();
        } else {
            return self::where('AgencyUserName', $loginInput)->first();
        }
    }

    /**
     * Check if password matches
     */
    public function checkPassword($password)
    {
        return Hash::check($password, $this->AgencyPassword);
    }

    /**
     * Update agency profile
     */
    public function updateProfile(array $data)
    {
        return $this->update($data);
    }

    /**
     * Create a new agency
     */
    public static function createAgency(array $data)
    {
        return self::create($data);
    }

    /**
     * Search agencies by name or email
     */
    public static function search($searchTerm)
    {
        return self::where('AgencyName', 'like', "%{$searchTerm}%")
            ->orWhere('AgencyEmail', 'like', "%{$searchTerm}%")
            ->orWhere('AgencyUserName', 'like', "%{$searchTerm}%")
            ->get();
    }    /**
     * Get agency's assigned inquiries
     */
    public function assignedInquiries()
    {
        return $this->hasMany(Inquiry::class, 'AgencyID', 'AgencyID');
    }

    /**
     * Get agency's inquiry assignments
     */
    public function inquiryAssignments()
    {
        return $this->hasMany(AssignedInquiry::class, 'agency_id', 'AgencyID');
    }

    /**
     * Get agency's pending inquiries
     */
    public function pendingInquiries()
    {
        return $this->assignedInquiries()->where('InquiryStatus', 'Pending');
    }

    /**
     * Get agency's completed inquiries
     */
    public function completedInquiries()
    {
        return $this->assignedInquiries()->whereIn('InquiryStatus', [
            'Verified as True', 
            'Identified as Fake', 
            'Completed'
        ]);
    }

    /**
     * Get agency's inquiry statistics
     */
    public function getInquiryStats()
    {
        $inquiries = $this->assignedInquiries();
        
        return [
            'total' => $inquiries->count(),
            'pending' => $inquiries->where('InquiryStatus', 'Pending')->count(),
            'under_investigation' => $inquiries->where('InquiryStatus', 'Under Investigation')->count(),
            'verified_true' => $inquiries->where('InquiryStatus', 'Verified as True')->count(),
            'identified_fake' => $inquiries->where('InquiryStatus', 'Identified as Fake')->count(),
            'rejected' => $inquiries->where('InquiryStatus', 'Rejected')->count(),
        ];
    }

    /**
     * Get agency's full name for display
     */
    public function getDisplayNameAttribute()
    {
        return $this->AgencyName;
    }

    /**
     * Get agency's email for notifications
     */
    public function getNotificationEmailAttribute()
    {
        return $this->AgencyEmail;
    }

    /**
     * Scope for active agencies
     */
    public function scopeActive($query)
    {
        return $query->where('AgencyStatus', true);
    }

    /**
     * Get the agency's profile picture URL
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->AgencyProfilePicture) {
            return asset('storage/' . $this->AgencyProfilePicture);
        }
        
        return asset('images/default-agency-avatar.png');
    }

    /**
     * Check if agency can handle specific inquiry types
     */
    public function canHandle($inquiryType)
    {
        // Add logic based on agency specialization
        return true; // Default: agencies can handle all types
    }

    /**
     * Get agency's performance metrics
     */
    public function getPerformanceMetrics()
    {
        $inquiries = $this->assignedInquiries();
        $total = $inquiries->count();
        
        if ($total === 0) {
            return [
                'completion_rate' => 0,
                'average_response_time' => 0,
                'accuracy_rate' => 0,
            ];
        }
        
        $completed = $this->completedInquiries()->count();
        
        return [
            'completion_rate' => round(($completed / $total) * 100, 2),
            'total_handled' => $total,
            'total_completed' => $completed,
            'pending_count' => $inquiries->where('InquiryStatus', 'Pending')->count(),
        ];
    }

    /**
     * Get agency's workload status
     */
    public function getWorkloadStatus()
    {
        $pendingCount = $this->pendingInquiries()->count();
        
        if ($pendingCount === 0) {
            return 'Available';
        } elseif ($pendingCount <= 5) {
            return 'Light';
        } elseif ($pendingCount <= 10) {
            return 'Moderate';
        } else {
            return 'Heavy';
        }
    }
}