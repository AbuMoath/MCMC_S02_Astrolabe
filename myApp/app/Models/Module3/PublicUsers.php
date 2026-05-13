<?php

namespace App\Models\Module3;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Support\Facades\Hash;

class PublicUsers extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;
    use CanResetPasswordTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'public_users';
    protected $primaryKey = 'UserID';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UserName',
        'UserEmail',
        'UserPassword',
        'UserPhoneNum',
        'UserProfilePicture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'UserPassword',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'UserPassword' => 'hashed',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->UserPassword;
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
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        return $this->UserEmail;
    }

    /**
     * Update user profile
     */
    public function updateProfile(array $data)
    {
        return $this->update($data);
    }

    /**
     * Check if password matches
     */
    public function checkPassword($password)
    {
        return Hash::check($password, $this->UserPassword);
    }

    /**
     * Search users by name or email
     */
    public static function search($searchTerm)
    {
        return self::where('UserName', 'like', "%{$searchTerm}%")
            ->orWhere('UserEmail', 'like', "%{$searchTerm}%")
            ->get();
    }    /**
     * Get user's full name for display
     */
    public function getDisplayNameAttribute()
    {
        return $this->UserName;
    }

    /**
     * Get user's email for notifications
     */
    public function getNotificationEmailAttribute()
    {
        return $this->UserEmail;
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('UserEmail');
    }    /**
     * Get the user's profile picture URL
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->UserProfilePicture) {
            return asset('storage/' . $this->UserProfilePicture);
        }
        
        return asset('images/default-avatar.png');
    }

    /**
     * Get the inquiries for the user.
     */
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'UserID', 'UserID');
    }
}