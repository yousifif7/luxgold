<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'cleaner_id',
        'plan_id',
        'status',
        'amount',
        'currency',
        'started_at',
        'renews_at',
        'is_active',
        'cancelled_at',
        'meta',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'renews_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'meta' => 'array',
    ];

    // 🔗 Relationships
    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

     public function plan()
    {
        return $this->belongsTo(Plan::class,'plan_id');
    }

    // 🧠 Helpers
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isCancelled()
    {
        return !is_null($this->cancelled_at);
    }
}
