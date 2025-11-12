<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'monthly_fee',
        'annual_fee',
        'description',
        'features',
        'is_active',
    ];

    protected $casts = [
        'monthly_fee' => 'decimal:2',
        'annual_fee' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function getMonthlyFeeAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getAnnualFeeAttribute($value)
    {
        return number_format($value, 2);
    }

    public function subscriptions(){

        return $this->hasMany(Subscription::class);
    }
}