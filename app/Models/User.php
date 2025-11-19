<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'phone',
        'city',
        'state',
        'zip_code',
        'email',
        'password',
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
            'password' => 'hashed',
        ];
    }

    public function savedEvents()
    {
        return $this->hasMany(SavedEvent::class);
    }

     public function provider()
    {
        return $this->hasOne(Provider::class,'user_id');
    }

    /**
     * Get the count of events saved by this user.
     */
    public function getSavedEventsCountAttribute(): int
    {
        return $this->savedEvents()->count();
    }

    public function compareProviders(){

    }

        public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    /**
     * Get unread notifications count
     */
    public function unreadNotificationsCount(): int
    {
        return $this->notifications()->unread()->active()->count();
    }

    /**
     * Simple profile verification check.
     * Returns true if the user has verified email and has key profile fields filled.
     */
    public function getIsVerifiedAttribute(): bool
    {
        // Consider profile complete when email verified and core contact/location fields present
        $hasName = !empty($this->first_name) || !empty($this->last_name) || !empty($this->name);
        $hasContact = !empty($this->phone) && !empty($this->email);
        $hasLocation = !empty($this->city) && !empty($this->state) && !empty($this->zip_code);

        return !is_null($this->email_verified_at) && $hasName && $hasContact && $hasLocation;
    }

    /**
     * Get recent notifications
     */
    public function recentNotifications($limit = 10)
    {
        return $this->notifications()
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Mark all notifications as read
     */
    public function markAllNotificationsAsRead()
    {
        $this->notifications()->unread()->update(['read_at' => now()]);
    }
}
