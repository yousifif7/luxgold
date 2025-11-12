<?php
// app/Models/RecentlyViewed.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentlyViewed extends Model
{
    use HasFactory;

    protected $table='recently_viewed';

    protected $fillable = [
        'user_id',
        'provider_id',
        'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}