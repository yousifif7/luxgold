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
        'customer_id',
        'slug'

    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function cleaners(){

        return $this->hasMany(Cleaner::class,'categories_id');
    }

    public function totalCleaners(){

        $cleaners=$this->cleaners();

        return $cleaners->count();
    }

    public function customer()
    {
        return $this->belongsTo(Category::class, 'customer_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'customer_id');
    }
}
