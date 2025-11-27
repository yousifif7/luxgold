<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HireRequest extends Model
{
    use HasFactory;

    protected $table = 'hire_requests';

    protected $fillable = [
        'cleaner_id',
        'user_id',
        'name',
        'email',
        'phone',
        'cleaning_type',
        'selected_items',
        'frequency',
        'scheduled_at',
        'notes',
        'status',
        'ip_address',
        'user_agent',
        'zip_code',
    ];

    protected $casts = [
        'selected_items' => 'array',
        'scheduled_at' => 'datetime',
    ];

    protected $dates = [
        'scheduled_at',
        'responded_at',
    ];

    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class, 'cleaner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function messages()
    {
        // Placeholder relation if you later add a messages table for hire requests
        return null;
    }
}
