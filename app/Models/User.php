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
