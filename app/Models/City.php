<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state',
        'providers_count',
        'families_count',
        'icon_url',
        'link',
        'is_coming_soon',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'providers_count' => 'integer',
        'families_count' => 'integer',
        'is_coming_soon' => 'boolean',
        'sort_order' => 'integer',
        'status' => 'boolean'
    ];

    /**
     * Get the full location name
     */
    public function getFullNameAttribute()
    {
        return $this->name . ', ' . $this->state;
    }

    /**
     * Get the display families count
     */
    public function getDisplayFamiliesCountAttribute()
    {
        return $this->families_count . '+ families';
    }

    /**
     * Get the display providers count
     */
    public function getDisplayProvidersCountAttribute()
    {
        return $this->providers_count . '+ providers';
    }

    /**
     * Scope active cities
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope available cities (not coming soon)
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_coming_soon', false);
    }

    /**
     * Scope coming soon cities
     */
    public function scopeComingSoon($query)
    {
        return $query->where('is_coming_soon', true);
    }

    /**
     * Scope ordered by sort order and name
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')
                    ->orderBy('name');
    }

    /**
     * Scope popular cities (high families count)
     */
    public function scopePopular($query, $limit = 5)
    {
        return $query->where('families_count', '>', 500)
                    ->orderBy('families_count', 'desc')
                    ->limit($limit);
    }
}