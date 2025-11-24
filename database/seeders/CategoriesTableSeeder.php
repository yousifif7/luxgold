<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        if (! Schema::hasTable('categories')) {
            $this->command->warn('Table `categories` does not exist, skipping CategoriesTableSeeder.');
            return;
        }

        $now = Carbon::now();

        $categories = [
            [
                'name' => 'Home Cleaning',
                'slug' => 'home-cleaning',
                'subtitle' => 'Regular & Recurring Home Cleaning',
                'description' => 'Routine cleaning services for homes including dusting, vacuuming, mopping and general tidying.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-broom',
                'tags' => json_encode(['Recurring', 'Standard', 'Residential']),
                'image_url' => '',
                'sort_order' => 1,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Deep Cleaning',
                'slug' => 'deep-cleaning',
                'subtitle' => 'Deep, One-time Cleans',
                'description' => 'Thorough deep cleans for kitchens, bathrooms, and whole homes—ideal for seasonal or annual cleaning.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-sparkles',
                'tags' => json_encode(['Deep', 'Move-out', 'One-time']),
                'image_url' => '',
                'sort_order' => 2,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Move Out / Move In Cleaning',
                'slug' => 'move-cleaning',
                'subtitle' => 'Move-out and Move-in Cleaning Services',
                'description' => 'Specialized cleaning to prepare properties for new occupants or after moving out.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-box-open',
                'tags' => json_encode(['Move-out', 'Move-in', 'End of Tenancy']),
                'image_url' => '',
                'sort_order' => 3,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Carpet & Upholstery Cleaning',
                'slug' => 'carpet-upholstery',
                'subtitle' => 'Carpet, Rugs and Upholstery',
                'description' => 'Professional carpet and upholstery cleaning using hot water extraction and safe detergents.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-couch',
                'tags' => json_encode(['Carpet', 'Rug', 'Upholstery']),
                'image_url' => '',
                'sort_order' => 4,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Window Cleaning',
                'slug' => 'window-cleaning',
                'subtitle' => 'Interior & Exterior Window Cleaning',
                'description' => 'Streak-free window and glass cleaning for homes and small businesses.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-window-maximize',
                'tags' => json_encode(['Windows', 'Glass', 'Gutters']),
                'image_url' => '',
                'sort_order' => 5,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Commercial Cleaning',
                'slug' => 'commercial-cleaning',
                'subtitle' => 'Offices & Commercial Spaces',
                'description' => 'Daily, weekly or custom cleaning plans for offices, retail and other commercial spaces.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-building',
                'tags' => json_encode(['Office', 'Commercial', 'Janitorial']),
                'image_url' => '',
                'sort_order' => 6,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Organization & Decluttering',
                'slug' => 'organization-decluttering',
                'subtitle' => 'Declutter & Organize Spaces',
                'description' => 'Professional organization, decluttering and setup services for closets, garages and rooms.',
                'cleaners_count' => 0,
                'icon' => 'fa-solid fa-boxes-stacked',
                'tags' => json_encode(['Declutter', 'Organize', 'Closets']),
                'image_url' => '',
                'sort_order' => 7,
                'status' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        $this->command->info('Categories seeded/updated successfully.');
    }
}