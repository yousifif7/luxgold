<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'contact_person',
        'role_title',
        'phone_number',
        'email',
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
        'user_id',
    ];

    protected $casts = [
        'service_categories' => 'array',
        'available_days' => 'array',
        'diversity_badges' => 'array',
        'special_features' => 'array',
        'facility_photos_paths' => 'array',
        'license_docs_paths' => 'array',
        'price_amount' => 'decimal:2',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
    ];

    /**
     * Get the user that owns the service listing.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the logo URL
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? Storage::url($this->logo_path) : null;
    }

    /**
     * Get facility photos URLs
     */
    public function getFacilityPhotosUrlsAttribute()
    {
        if (!$this->facility_photos_paths) {
            return [];
        }

        return array_map(function ($path) {
            return Storage::url($path);
        }, $this->facility_photos_paths);
    }

    /**
     * Get license docs URLs
     */
    public function getLicenseDocsUrlsAttribute()
    {
        if (!$this->license_docs_paths) {
            return [];
        }

        return array_map(function ($path) {
            return Storage::url($path);
        }, $this->license_docs_paths);
    }

    /**
     * Scope a query to only include approved listings.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending listings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}