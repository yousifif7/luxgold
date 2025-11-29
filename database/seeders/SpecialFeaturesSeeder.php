<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class SpecialFeaturesSeeder extends Seeder
{
    public function run()
    {
        $features = [
            [
                'title' => 'Eco-friendly Products',
                'slug' => Str::slug('Eco-friendly Products'),
                'icon' => 'features/eco.png',
                'description' => 'Cleaning using environmentally friendly, non-toxic products.',
            ],
            [
                'title' => 'Pet-Friendly',
                'slug' => Str::slug('Pet-Friendly'),
                'icon' => 'features/pet-friendly.png',
                'description' => 'Services adapted for homes with pets.',
            ],
            [
                'title' => 'Deep Clean',
                'slug' => Str::slug('Deep Clean'),
                'icon' => 'features/deep-clean.png',
                'description' => 'Thorough deep cleaning including skirting boards, fixtures and hard-to-reach areas.',
            ],
            [
                'title' => 'End-of-Tenancy / Move-Out',
                'slug' => Str::slug('End-of-Tenancy'),
                'icon' => 'features/end-of-tenancy.png',
                'description' => 'Specialist end-of-tenancy cleans to meet landlord expectations.',
            ],
            [
                'title' => 'Oven Cleaning',
                'slug' => Str::slug('Oven Cleaning'),
                'icon' => 'features/oven-cleaning.png',
                'description' => 'Professional oven and appliance cleaning services.',
            ],
            [
                'title' => 'Carpet Cleaning',
                'slug' => Str::slug('Carpet Cleaning'),
                'icon' => 'features/carpet-cleaning.png',
                'description' => 'Steam and deep carpet cleaning solutions.',
            ],
            [
                'title' => 'Same-Day Booking',
                'slug' => Str::slug('Same-Day Booking'),
                'icon' => 'features/same-day.png',
                'description' => 'Available for urgent clean requests subject to availability.',
            ],
            [
                'title' => 'Holiday Let Turnover',
                'slug' => Str::slug('Holiday Let Turnover'),
                'icon' => 'features/holiday-let.png',
                'description' => 'Fast turnaround cleans for short-term rental properties.',
            ],
        ];

        DB::table('special_features')->insert($features);
    }
}
