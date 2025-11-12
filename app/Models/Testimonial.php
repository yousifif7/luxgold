<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'rating',
        'content',
        'avatar_url',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'rating' => 'integer',
        'sort_order' => 'integer',
        'status' => 'boolean'
    ];

    /**
     * Get the star rating for display
     */
    public function getStarRatingAttribute()
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $stars .= '★';
            } else {
                $stars .= '☆';
            }
        }
        return $stars;
    }

    /**
     * Get the abbreviated content for display
     */
    public function getExcerptAttribute($length = 100)
    {
        return Str::limit(strip_tags($this->content), $length);
    }

    /**
     * Get the location with city/state format
     */
    public function getDisplayLocationAttribute()
    {
        return $this->location . ', TX';
    }

    /**
     * Scope active testimonials
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope high rated testimonials
     */
    public function scopeHighRated($query, $minRating = 4)
    {
        return $query->where('rating', '>=', $minRating);
    }

    /**
     * Scope ordered by sort order and rating
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')
                    ->orderBy('rating', 'desc')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Scope recent testimonials
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('created_at', 'desc')
                    ->limit($limit);
    }
}