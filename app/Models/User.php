<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use App\Models\UserDepartment;
use App\Models\UserPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    public const TYPE_AUTHENTICATED = 'authenticated';
    public const TYPE_PUBLIC = 'public';

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'date_of_birth',
        'address',
        'is_approved',
        'is_suspended',
        'user_type',
        'last_login_at',
        'last_login_ip',
        'last_login_browser',
        'last_login_location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
            'is_approved' => 'boolean',
            'is_suspended' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Departments assigned to the user.
     */
    public function departments(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(UserDepartment::class, 'department_user', 'user_id', 'user_department_id')
            ->withTimestamps();
    }

    /**
     * Permissions assigned to the user.
     */
    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(UserPermission::class, 'permission_user', 'user_id', 'user_permission_id')
            ->withTimestamps();
    }

    /**
     * Whether this user can access the Dashboard (Authenticated User).
     */
    public function canAccessDashboard(): bool
    {
        return $this->user_type === self::TYPE_AUTHENTICATED;
    }

    /**
     * Whether this user is a public user (no dashboard access).
     */
    public function isPublicUser(): bool
    {
        return $this->user_type === self::TYPE_PUBLIC;
    }

    /**
     * Get the user's avatar URL. Uses profile_photo if set, otherwise generates an image from the name (UI Avatars).
     */
    public function getAvatarUrlAttribute(): string
    {
        if (! empty($this->profile_photo ?? null)) {
            return asset('storage/'.$this->profile_photo);
        }

        $name = $this->name ?? 'User';
        $encoded = str_replace('+', '%2B', urlencode($name));

        return 'https://ui-avatars.com/api/?name='.$encoded.'&size=160&background=0D8ABC&color=fff';
    }

    /**
     * Send the password reset notification (uses app name as text in email header, no images).
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
