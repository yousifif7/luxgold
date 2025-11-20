<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'provider_name',
        'category',
        'location',
        'city',
        'start_date',
        'end_date',
        'cost',
        'status',
        'max_capacity',
        'current_capacity',
        'age_group',
        'published_at',
        'image_url',
        'author',
        'provider_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'published_at' => 'datetime',
        'cost' => 'decimal:2',
    ];

    public function provider(){ return $this->belongsTo(User::class); }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function savedByUsers()
    {
        return $this->hasMany(SavedEvent::class);
    }
   
    public function isSavedByUser()
    {
        if (!Auth::check()) {
            return false;
        }

        return $this->savedByUsers()
            ->where('user_id', Auth::id())
            ->exists();
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now())->orderBy('date');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
