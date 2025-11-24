<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'cleaner_id',
        'payment_method',
        'transaction_id',
        'amount',
        'currency',
        'status',
        'paid_at',
        'meta',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'meta' => 'array',
    ];

    // 🔗 Relationships
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function cleaner()
    {
        return $this->belongsTo(\App\Models\Cleaner::class);
    }
    // 🧠 Helpers
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }
}
