<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'category',
    'email',
    'phone',
    'location',
    'membership',
    'status',
    'revenue',
    'rating',
    'avatar',
    'user_id',
    'profile_views',
    'website',
    'description',
    'contact_person',
    'business_type',
    'license_number',
    'age_range',
    'capacity',
    'hours',
    'notify_inquiry',
    'business_name',
    'role_title',
    'phone_number',
    'physical_address',
    'city',
    'state',
    'zip_code',
    'service_categories',
    'service_description',
    'price_amount',
    'pricing_description',
    'available_days',
    'start_time',
    'end_time',
    'plans_id',
    'availability_notes',
    'years_operation',
    'insurance_coverage',
    'diversity_badges',
    'special_features',
    'facebook',
    'instagram',
    'logo_path',
    'facility_photos_paths',
    'license_docs_paths',
    'is_featured',
    // Newly added columns
    'ages_served',
    'operating_hours',
    'care_type',
    'programs_offered',
    'views',
    'clicks',
    'inquiries'
];

    /**
     * The provider belongs to a user record (role = 'provider').
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

/*    public function listings()
    {
        return $this->hasMany(\App\Models\Listing::class);
    }*/

    protected $casts = [
    'revenue' => 'decimal:2',
    'rating' => 'float',
    'profile_views' => 'integer',
    'views' => 'integer',
    'clicks' => 'integer',
    'inquiries' => 'integer',
    'notify_inquiry' => 'boolean',
    'service_categories' => 'array',
    'available_days' => 'array',
    'diversity_badges' => 'array',
    'special_features' => 'array',
    'facility_photos_paths' => 'array',
    'license_docs_paths' => 'array',
];


    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function savedByUsers()
    {
        return $this->hasMany(SavedProvider::class);
    }

    public function followedByUsers()
    {
        return $this->hasMany(FollowedProvider::class);
    }

    public function events(){
return $this->hasMany(Event::class);

    }

    public function subscription(){
         return $this->hasOne(Subscription::class)->with('plan');
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('status', 'approved');
    }

    public function updateRating()
    {
        $approvedReviews = $this->approvedReviews();
        $averageRating = $approvedReviews->avg('rating');
        
        $this->update(['rating' => $averageRating ? round($averageRating, 1) : null]);
    }

    public function isSavedByUser($userId = null)
    {
        if (!$userId && auth()->check()) {
            $userId = auth()->id();
        }
        
        return $this->savedByUsers()->where('user_id', $userId)->exists();
    }

    public function isFollowedByUser($userId = null)
    {
        if (!$userId && auth()->check()) {
            $userId = auth()->id();
        }
        
        return $this->followedByUsers()->where('user_id', $userId)->exists();
    }


    public function recentlyViewed()
    {
        return $this->hasMany(RecentlyViewed::class);
    }


    public function userReview($userId = null)
    {
        if (!$userId && auth()->check()) {
            $userId = auth()->id();
        }
        
        return $this->reviews()->where('user_id', $userId)->first();
    }

public function isInCompare()
{
        $compareList = Session::get('compare_list', []);
        return in_array($this->id, $compareList);
    
    // If you want to store compare list in database for logged-in users
}

 public function scopeNearby($query, $latitude, $longitude, $radius = 10)
    {
        // Haversine formula for distance calculation
        return $query->selectRaw("*, 
            ( 3959 * acos( cos( radians(?) ) * 
            cos( radians( latitude ) ) * 
            cos( radians( longitude ) - 
            radians(?) ) + 
            sin( radians(?) ) * 
            sin( radians( latitude ) ) ) ) 
            AS distance", [$latitude, $longitude, $latitude])
            ->havingRaw("distance < ?", [$radius])
            ->orderBy('distance');
    }
}
