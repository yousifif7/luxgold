<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'provider_id',
        'rating',
        'comment',
        'status',
        'admin_notes'
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    // Scope for filtering by status
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope for filtering by rating
    public function scopeRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    // Get status badge class
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'approved' => 'bg-success',
            'pending' => 'bg-warning',
            'flagged' => 'bg-danger',
            'hidden' => 'bg-secondary',
            'rejected' => 'bg-dark',
            default => 'bg-secondary'
        };
    }
}