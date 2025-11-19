<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

class ReviewModerationLog extends Model
{
    protected $table = 'review_moderation_logs';
    protected $guarded = [];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function adminUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'admin_user_id');
    }
}
