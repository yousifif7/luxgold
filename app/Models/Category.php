<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'subtitle',
        'description',
        'providers_count',
        'icon',
        'tags',
        'image_url',
        'sort_order',
        'status',
        'parent_id',
        'slug'

    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
