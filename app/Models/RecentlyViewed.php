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
        'cleaner_id',
        'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class);
    }
}