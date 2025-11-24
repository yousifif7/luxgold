<?php
// app/Models/SavedEvent.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedEvent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'event_id',
        'notes',
        'reminder_set',
        'reminder_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reminder_set' => 'boolean',
        'reminder_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that saved the event.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event that was saved.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Scope a query to only include saved events for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include saved events with reminders set.
     */
    public function scopeWithReminders($query)
    {
        return $query->where('reminder_set', true)
                    ->whereNotNull('reminder_at')
                    ->where('reminder_at', '>', now());
    }

    /**
     * Scope a query to only include recently saved events.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Check if a reminder is due.
     */
    public function isReminderDue(): bool
    {
        return $this->reminder_set && 
               $this->reminder_at && 
               $this->reminder_at->lte(now());
    }

    /**
     * Set a reminder for this saved event.
     */
    public function setReminder($reminderAt): bool
    {
        $this->update([
            'reminder_set' => true,
            'reminder_at' => $reminderAt,
        ]);

        return $this->wasChanged();
    }

    /**
     * Remove the reminder for this saved event.
     */
    public function removeReminder(): bool
    {
        $this->update([
            'reminder_set' => false,
            'reminder_at' => null,
        ]);

        return $this->wasChanged();
    }

    /**
     * Check if the user has already saved this event.
     */
    public static function isAlreadySaved($userId, $eventId): bool
    {
        return static::where('user_id', $userId)
                    ->where('event_id', $eventId)
                    ->exists();
    }

    /**
     * Get the count of saved events for a user.
     */
    public static function getCountForUser($userId): int
    {
        return static::where('user_id', $userId)->count();
    }

    /**
     * Get saved events with event details for a user.
     */
    public static function getWithEventsForUser($userId)
    {
        return static::with(['event.cleaner'])
                    ->where('user_id', $userId)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }
}