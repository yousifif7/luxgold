<?php
// app/Models/Message.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'inquiry_id',
        'sender_type', // 'user' or 'provider'
        'message',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime'
    ];

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class);
    }
}