<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'subtitle', 'image_url', 'link_url', 'start_at', 'end_at', 'is_active', 'show_on_homepage', 'sort_order'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_active' => 'boolean',
        'show_on_homepage' => 'boolean'
    ];
}
