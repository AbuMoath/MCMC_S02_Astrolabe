<?php

namespace App\Models\Module3;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Support\Facades\Hash;

class Administrator extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'administrators';
    protected $primaryKey = 'AdminID';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'AdminName',
        'AdminEmail',
        'AdminUserName',
        'AdminPassword',
        'AdminPhoneNum',
        'AdminProfilePicture',
        'AdminType',
        'AdminStatus',
        'otp_code',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'AdminPassword',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'AdminPassword' => 'hashed',
        'AdminStatus' => 'boolean',
    ];

    /**
     * Get the password for authentication.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->AdminPassword;
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
     * Find admin by login input (email or username)
     */
    public static function findByLogin($loginInput)
    {
        $isEmail = filter_var($loginInput, FILTER_VALIDATE_EMAIL);
        
        if ($isEmail) {
            return self::where('AdminEmail', $loginInput)->first();
        } else {
            return self::where('AdminUserName', $loginInput)->first();
        }
    }

    /**
     * Check if password matches
     */
    public function checkPassword($password)
    {
        return Hash::check($password, $this->AdminPassword);
    }

    /**
     * Update admin profile
     */
    public function updateProfile(array $data)
    {
        return $this->update($data);
    }

    /**
     * Search administrators by name or email
     */
    public static function search($searchTerm)
    {
        return self::where('AdminName', 'like', "%{$searchTerm}%")
            ->orWhere('AdminEmail', 'like', "%{$searchTerm}%")
            ->orWhere('AdminUserName', 'like', "%{$searchTerm}%")
            ->get();
    }

    /**
     * Get admin's full name for display
     */
    public function getDisplayNameAttribute()
    {
        return $this->AdminName;
    }

    /**
     * Get admin's email for notifications
     */
    public function getNotificationEmailAttribute()
    {
        return $this->AdminEmail;
    }

    /**
     * Scope for active administrators
     */
    public function scopeActive($query)
    {
        return $query->where('AdminStatus', true);
    }

    /**
     * Get the admin's profile picture URL
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->AdminProfilePicture) {
            return asset('storage/' . $this->AdminProfilePicture);
        }
        
        return asset('images/default-admin-avatar.png');
    }

    /**
     * Check if admin has specific permissions
     */
    public function hasPermission($permission)
    {
        // Add permission logic here if needed
        return true; // Default: all admins have all permissions
    }

    /**
     * Get admin's role display name
     */
    public function getRoleDisplayAttribute()
    {
        return $this->AdminType ?? 'Administrator';
    }

    /**
     * Get inquiries assigned to agencies (admin oversight)
     */
    public function getOversightInquiries()
    {
        return \App\Models\Inquiry::whereNotNull('AgencyID')->get();
    }    /**
     * Get unassigned inquiries
     */
    public function getUnassignedInquiries()
    {
        return Inquiry::whereNull('AgencyID')->get();
    }

    /**
     * Get statistics for admin dashboard
     */
    public function getDashboardStats()
    {
        return [
            'total_inquiries' => Inquiry::count(),
            'pending_inquiries' => Inquiry::where('InquiryStatus', 'Pending')->count(),
            'assigned_inquiries' => Inquiry::whereNotNull('AgencyID')->count(),
            'total_users' => PublicUsers::count(),
            'total_agencies' => Agency::count(),
        ];
    }

    /**
     * Get inquiries managed by this administrator.
     */
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'AdminID', 'AdminID');
    }

    /**
     * Get assigned inquiries managed by this administrator.
     */
    public function assignedInquiries()
    {
        return $this->hasMany(AssignedInquiry::class, 'admin_id', 'AdminID');
    }
}