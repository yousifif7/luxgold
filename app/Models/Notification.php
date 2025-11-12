<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'action_url',
        'action_text',
        'notifiable_type',
        'notifiable_id',
        'target_role',
        'sent_at',
        'read_at',
        'expires_at',
        'metadata'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
        'expires_at' => 'datetime',
        'metadata' => 'array'
    ];

    /**
     * Get the owning notifiable model
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope for read notifications
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope for active notifications (not expired)
     */
    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    /**
     * Scope for notifications by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for notifications by target role
     */
    public function scopeForRole($query, $role)
    {
        return $query->where('target_role', $role);
    }

    /**
     * Scope for global notifications (no specific notifiable)
     */
    public function scopeGlobal($query)
    {
        return $query->whereNull('notifiable_id');
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Mark notification as unread
     */
    public function markAsUnread()
    {
        $this->update(['read_at' => null]);
    }

    /**
     * Check if notification is read
     */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Check if notification is unread
     */
    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    /**
     * Check if notification is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Get notification badge color based on type
     */
    public function getBadgeColor(): string
    {
        return match($this->type) {
            'success' => 'bg-success',
            'warning' => 'bg-warning',
            'error' => 'bg-danger',
            'info' => 'bg-info',
            default => 'bg-primary'
        };
    }

    /**
     * Get notification icon based on type
     */
    public function getIcon(): string
    {
        return match($this->type) {
            'success' => 'ti ti-check',
            'warning' => 'ti ti-alert-triangle',
            'error' => 'ti ti-alert-circle',
            'info' => 'ti ti-info-circle',
            'system' => 'ti ti-bell',
            default => 'ti ti-bell'
        };
    }
}