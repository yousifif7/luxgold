<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'image_url',
        'content',
        'read_time',
        'slug',
        'meta_title',
        'meta_description',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'status' => 'boolean'
    ];

    /**
     * Boot function for slug generation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($resource) {
            if (empty($resource->slug)) {
                $resource->slug = Str::slug($resource->title);
            }
        });

        static::updating(function ($resource) {
            if ($resource->isDirty('title') && empty($resource->slug)) {
                $resource->slug = Str::slug($resource->title);
            }
        });
    }

    /**
     * Get the excerpt of the description
     */
    public function getExcerptAttribute($length = 150)
    {
        return Str::limit(strip_tags($this->description), $length);
    }

    /**
     * Get the excerpt of the content
     */
    public function getContentExcerptAttribute($length = 200)
    {
        return Str::limit(strip_tags($this->content), $length);
    }

    /**
     * Get the formatted read time
     */
    public function getFormattedReadTimeAttribute()
    {
        return $this->read_time ?: '5 min read';
    }

    /**
     * Get the route key name for URL
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope active resources
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope ordered by sort order and creation date
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Scope recent resources
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('created_at', 'desc')
                    ->limit($limit);
    }

    /**
     * Scope popular categories
     */
    public function scopePopularCategories($query, $limit = 5)
    {
        return $query->select('category')
                    ->groupBy('category')
                    ->orderByRaw('COUNT(*) DESC')
                    ->limit($limit);
    }

    /**
     * Get related resources (same category)
     */
    public function relatedResources($limit = 3)
    {
        return static::where('category', $this->category)
                    ->where('id', '!=', $this->id)
                    ->active()
                    ->ordered()
                    ->limit($limit)
                    ->get();
    }
}