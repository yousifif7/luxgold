<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Auth;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'provider_name',
        'category',
        'location',
        'city',
        'start_date',
        'end_date',
        'cost',
        'status',
        'max_capacity',
        'current_capacity',
        'age_group',
        'published_at',
        'image_url',
        'author',
        'provider_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'published_at' => 'datetime',
        'cost' => 'decimal:2',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function savedByUsers()
    {
        return $this->hasMany(SavedEvent::class);
    }
   
    public function isSavedByUser()
    {
        if (!Auth::check()) {
            return false;
        }

        return $this->savedByUsers()
            ->where('user_id', Auth::id())
            ->exists();
    }

    /**
     * Check if the event has ended
     */
    public function hasEnded(): bool
    {
        return $this->end_date->isPast();
    }

    /**
     * Check if the event is full (reached maximum capacity)
     */
    public function isFull(): bool
    {
        return $this->max_capacity > 0 && $this->current_capacity >= $this->max_capacity;
    }

    /**
     * Increment the current capacity by the given amount
     */
    public function incrementCapacity(int $amount = 1): bool
    {
        // Check if incrementing would exceed max capacity (if max capacity is set)
        if ($this->max_capacity > 0 && ($this->current_capacity + $amount) > $this->max_capacity) {
            return false;
        }

        $this->current_capacity += $amount;
        return $this->save();
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())->orderBy('start_date');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}