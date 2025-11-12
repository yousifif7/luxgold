<?php
// app/Models/Inquiry.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'provider_id',
        'user_id',
        'name',
        'email',
        'phone',
        'message',
        'newsletter_opt_in',
        'status',
        'ip_address',
        'user_agent'
    ];

    protected $attributes = [
        'status' => 'new'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}