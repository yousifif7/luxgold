<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Cleaner;

class HireRequest extends Model
{
    use HasFactory;

    protected $table = 'hire_requests';

    protected $fillable = [
        'cleaner_id',
        'cleaner_ids',
        'user_id',
        'name',
        'email',
        'phone',
        'cleaning_type',
        'selected_items',
        'frequency',
        'scheduled_at',
        'notes',
        'status',
        'ip_address',
        'user_agent',
        'zip_code',
        'admin_message',
        'city',
    ];

    protected $casts = [
        'cleaner_ids' => 'array',
        'selected_items' => 'array',
        'scheduled_at' => 'datetime',
    ];

    protected $dates = [
        'scheduled_at',
        'responded_at',
    ];

    public function cleaner()
    {
        return $this->belongsTo(Cleaner::class, 'cleaner_id');
    }

    /**
     * Return collection of cleaners when `cleaner_ids` is present.
     */
    public function cleaners()
    {
        if (! $this->cleaner_ids || ! is_array($this->cleaner_ids)) {
            return collect();
        }

        return Cleaner::whereIn('id', $this->cleaner_ids)->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function messages()
    {
        // Placeholder relation if you later add a messages table for hire requests
        return null;
    }

    /**
     * Attempt to find a Category model that matches this hire request's cleaning_type.
     * It will try slug and exact name matches.
     */
    public function matchedCategory()
    {
        if (! $this->cleaning_type) {
            return null;
        }

        $slug = Str::slug($this->cleaning_type);

        $cat = Category::where('slug', $slug)->first();
        if ($cat) {
            return $cat;
        }

        return Category::where('name', $this->cleaning_type)->first();
    }

    /**
     * Return a collection of recommended Cleaners for this hire request.
     * Preference order: cleaners in matched category and same zip, then category, then same zip.
     */
    public function recommendedCleaners($limit = 50)
    {
        $query = Cleaner::query()->where('status', 'active');

        $category = $this->matchedCategory();

        if ($category) {
            $query->where('categories_id', $category->id);

            if ($this->city) {
                $city = trim($this->city);

                // exact, case-insensitive city match
                $sameCity = (clone $query)->whereRaw('lower(city) = ?', [mb_strtolower($city)])->limit($limit)->get();
                if ($sameCity->isNotEmpty()) {
                    return $sameCity;
                }
            }

            // Fallback: return category-matched cleaners (no city preference)
            return $query->limit($limit)->get();
        }

        // fallback: match by zip only
        // Prefer matching by city if provided
        if ($this->city) {
            $city = trim($this->city);
            $exact = Cleaner::whereRaw('lower(city) = ?', [mb_strtolower($city)])->where('status', 'active')->limit($limit)->get();
            if ($exact->isNotEmpty()) {
                return $exact;
            }
        }

        // final fallback: return recent active cleaners
        return Cleaner::where('status', 'active')->orderBy('is_featured', 'desc')->limit($limit)->get();
    }
}
