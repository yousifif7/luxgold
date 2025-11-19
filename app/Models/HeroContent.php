<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroContent extends Model
{
    use HasFactory;

    protected $table = 'hero_contents';

    protected $fillable = [
        'title_part1',
        'title_part2',
        'description',
        'meta_title',
        'meta_description',
        'cta_text',
        'cta_url',
        'hero_alt_text',
        'hero_image_thumbnail',
        'providers_count',
        'rating',
        'support_text',
        'status'
    ];

    protected $casts = [
        'providers_count' => 'integer',
        'rating' => 'decimal:1',
        'status' => 'boolean'
    ];

    /**
     * Get the formatted rating
     */
    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }

    /**
     * Scope active hero content
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}