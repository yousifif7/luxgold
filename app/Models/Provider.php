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
        'phone',
        'categories_id',
        'business_name',
        'contact_person',
        'role_title',
        'phone_number',
        'plans_id',
        'email',
        'physical_address',
        'city',
        'state',
        'zip_code',
        'sub_categories',
        'services_offerd',
        'service_description',
        'ages_served_id',
        'operating_hours',
        'care_types_id',
        'programs_offered_id',
        'price_amount',
        'pricing_description',
        'available_days',
        'start_time',
        'end_time',
        'availability_notes',
        'license_number',
        'years_operation',
        'insurance_coverage',
        'diversity_badges',
        'special_features',
        'website',
        'facebook',
        'instagram',
        'logo_path',
        'facility_photos_paths',
        'license_docs_paths',
        'status',
        'is_featured',
        'user_id',
        'avatar',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'categories_id' => 'integer',
        'price_amount' => 'decimal:2',
        'sub_categories' => 'array',
        'services_offerd' => 'array',
        'available_days' => 'array',
        'diversity_badges' => 'array',
        'special_features' => 'array',
        'facility_photos_paths' => 'array',
        'license_docs_paths' => 'array',
        'is_featured' => 'boolean',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The provider belongs to a user record (role = 'provider').
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inquiries(){

        return $this->hasMany(Inquiry::class,'provider_id');
    }

    public function currentPlan(){

        return $this->belongsTo(Plan::class,'plans_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'categories_id');
    }
      public function ages()
    {
        return $this->belongsTo(AgesServed::class,'ages_served_id');
    }


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
return $this->hasMany(Event::class,'provider_id','user_id');

    }

    public function subscription(){
         return $this->hasOne(Subscription::class)->with('plan');
    }

    public function approvedReviews()
    {
        return $this->reviews()->where('status', 'approved');
    }

    public function averageRating()
{
    $approvedReviews = $this->approvedReviews(); // Only approved reviews
    $average = $approvedReviews->avg('rating'); // Calculate average
    
    return $average ? round($average, 1) : null; // Round to 1 decimal or return null
}

public function totalInquiries(){
   $inq=$this->inquiries();

   return $inq->count();

}

public function totalView(){

    $views=$this->recentlyViewed();
    return $views->count();
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
        return $this->hasMany(RecentlyViewed::class,'provider_id');
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
