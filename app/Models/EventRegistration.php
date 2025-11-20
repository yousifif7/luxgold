<?php
// app/Models/EventRegistration.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'email',
        'phone',
        'guests',
        'notes',
        'status',
        'registration_code'
    ];

    protected $casts = [
        'guests' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->registration_code = self::generateRegistrationCode();
        });
    }

    public static function generateRegistrationCode()
    {
        $code = 'EVT-' . strtoupper(substr(md5(uniqid()), 0, 8));
        
        // Ensure uniqueness
        while (self::where('registration_code', $code)->exists()) {
            $code = 'EVT-' . strtoupper(substr(md5(uniqid()), 0, 8));
        }
        
        return $code;
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function getTotalAttendeesAttribute()
    {
        return $this->guests + 1; // +1 for the registrant
    }
}